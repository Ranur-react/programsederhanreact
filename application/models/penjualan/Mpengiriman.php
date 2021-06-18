<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpengiriman extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('penjualan/pesanan/Mpesanan');
        $this->load->model('penjualan/Mpembayaran');
    }
    public function jumlah_data()
    {
        return $this->db->from('orders')->where_in('status_order', [2, 3, 4])->count_all_results();
    }
    public function tampil_data($start, $length)
    {
        $sql = $this->db->from('orders')
            ->join('customer', 'customer_order=id_customer')
            ->join('order_bayar', 'id_order=order_bayar')
            ->join('metode_bayar', 'id_metode=metode_bayar')
            ->where_in('status_order', [2, 3, 4])
            ->order_by('id_order', 'DESC')
            ->limit($length, $start)
            ->get();
        return $sql;
    }
    public function cari_data($search)
    {
        $sql = $this->db->from('orders')
            ->join('customer', 'customer_order=id_customer')
            ->join('order_bayar', 'id_order=order_bayar')
            ->join('metode_bayar', 'id_metode=metode_bayar')
            ->where_in('status_order', [2, 3, 4])
            ->order_by('id_order', 'DESC')
            ->like('invoice_order', $search)
            ->or_like('nama_customer', $search)
            ->or_like("DATE_FORMAT(tanggal_order,'%d-%m-%Y')", $search)
            ->get();
        return $sql;
    }
    public function store($id = null)
    {
        $data = [
            'idorder_kirim' => $id,
            'iduser_kirim'  => id_user()
        ];
        $this->db->insert('pengiriman', $data);
        return $this->Mpesanan->create_status($id, 3);
    }
    public function relasi()
    {
        $data = array(
            1 => 'Yang bersangkutan',
            2 => 'Keluarga',
            3 => 'Teman',
            4 => 'Lainnya'
        );
        return $data;
    }
    public function show($id = null)
    {
        return $this->db->where('idorder_kirim', $id)->get('pengiriman')->row_array();
    }
    public function storeterima($post)
    {
        $data = [
            'idkirim_terima' => $post['idkirim'],
            'penerima_terima'  => $post['nama'],
            'relasi_terima'  => $post['relasi'],
            'note_terima'  => $post['note'],
            'user_terima'  => id_user()
        ];
        $this->db->insert('pengiriman_terima', $data);
        if ($post['idmetode'] == 1) :
            $this->db->insert(
                'pengiriman_bayar',
                [
                    'idkirim_bayar' => $post['idkirim'],
                    'nilai_bayar' => $post['nilai']
                ]
            );
            $this->Mpembayaran->create_status($post['idbayar'], 2);
        endif;
        return $this->Mpesanan->create_status($post['idorder'], 4);
    }
    public function show_terima($id = null)
    {
        $result = $this->db->from('pengiriman')
            ->join('pengiriman_terima', 'id_kirim=idkirim_terima')
            ->where('idorder_kirim', $id)
            ->get()->row();
        $relasi = $this->relasi();
        foreach ($relasi as $key => $value) {
            if ($key == $result->relasi_terima) :
                $data = array(
                    'penerima' => $result->penerima_terima,
                    'relasi' => $value
                );
            endif;
        }
        return $data;
        // var_dump($data);
        // exit;
    }
}

/* End of file Mpengiriman.php */
