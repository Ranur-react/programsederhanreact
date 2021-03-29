<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpermintaan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pembelian/permintaan/Mtmp_create');
    }
    public function kode()
    {
        $query = $this->db
            ->select('id_permintaan', FALSE)
            ->order_by('id_permintaan', 'DESC')
            ->limit(1)
            ->get('permintaan');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->id_permintaan) + 1;
        } else {
            $kode = 1;
        }
        return $kode;
    }
    public function store($kode, $post)
    {
        $total = $this->db->select('SUM(harga*jumlah) AS total')->where('user', id_user())->get('tmp_permintaan')->row();
        $data_permintaan = [
            'id_permintaan' => $kode,
            'supplier_permintaan' => $post['supplier'],
            'tanggal_permintaan' => date("Y-m-d", strtotime($post['tanggal'])),
            'total_permintaan' => $total->total,
            'status_permintaan' => 1,
            'user_permintaan' => id_user()
        ];
        $this->db->set('created_at', 'NOW()', FALSE);
        $this->db->set('updated_at', 'NOW()', FALSE);
        $permintaan = $this->db->insert('permintaan', $data_permintaan);
        $data_tmp = $this->Mtmp_create->tampil_data();
        foreach ($data_tmp as $d) {
            $data_detail = [
                'permintaan_detail' => $kode,
                'barang_detail' => $d['barang'],
                'satuan_detail' => $d['satuan'],
                'harga_detail' => $d['harga'],
                'jumlah_detail' => $d['jumlah']
            ];
            $this->db->insert('permintaan_detail', $data_detail);
        }
        $hapus_tmp = $this->db->where('user', id_user())->delete('tmp_permintaan');
        return array($permintaan, $hapus_tmp);
    }
}

/* End of file Mpermintaan.php */
