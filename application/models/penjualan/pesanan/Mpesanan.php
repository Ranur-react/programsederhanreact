<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpesanan extends CI_Model
{
    public function kode()
    {
        $query = $this->db
            ->select('id_order', FALSE)
            ->order_by('id_order', 'DESC')
            ->limit(1)
            ->get('orders');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->id_order) + 1;
        } else {
            $kode = 1;
        }
        return $kode;
    }
    public function kode_bayar()
    {
        $query = $this->db
            ->select('id_bayar', FALSE)
            ->order_by('id_bayar', 'DESC')
            ->limit(1)
            ->get('order_bayar');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->id_bayar) + 1;
        } else {
            $kode = 1;
        }
        return $kode;
    }
    public function nosurat()
    {
        $query = $this->db->query("SELECT nourut_order FROM orders WHERE DATE_FORMAT(tanggal_order,'%Y-%m') = DATE_FORMAT(NOW(),'%Y-%m') ORDER BY nourut_order DESC LIMIT 1");
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $nourut = intval($data->nourut_order) + 1;
            $array = array(
                'nourut' => $nourut,
                'nosurat' => zerobefore($nourut) . '/INV/BM/' . KonDecRomawi(date('n')) . '/' . format_tahun(date("Y-m-d"))
            );
        } else {
            $nourut = 1;
            $array = array(
                'nourut' => $nourut,
                'nosurat' => zerobefore($nourut) . '/INV/BM/' . KonDecRomawi(date('n')) . '/' . format_tahun(date("Y-m-d"))
            );
        }
        return $array;
    }
    public function store($post)
    {
        $kode = $this->kode();
        $kodebayar = $this->kode_bayar();
        $nosurat = $this->nosurat();
        $data_order = [
            'id_order' => $kode,
            'nourut_order' => $nosurat['nourut'],
            'invoice_order' => $nosurat['nosurat'],
            'customer_order' => $post['customer'],
            'status_order' => 0
        ];
        $order = $this->db->insert('orders', $data_order);
        $queryAlamat = $this->db->where('id_alamat', $post['alamat'])->get('customer_alamat')->row();
        $data_alamat = [
            'idorder_order_alamat' => $kode,
            'idalamat_order_alamat' => $queryAlamat->id_alamat,
            'label_order_alamat' => $queryAlamat->label_alamat,
            'penerima_order_alamat' => $queryAlamat->penerima_alamat,
            'phone_order_alamat' => $queryAlamat->phone_alamat,
            'jalan_order_alamat' => $queryAlamat->jalan_alamat,
            'detail_order_alamat' => $queryAlamat->detail_alamat,
            'kota_order_alamat' => $queryAlamat->kota_alamat,
            'kodepos_order_alamat' => $queryAlamat->kodepos_alamat
        ];
        $this->db->insert('order_alamat', $data_alamat);
        $total = $this->db->select('SUM((harga-diskon)*jumlah) AS total')->where('user', id_user())->get('tmp_order')->row();
        $dataBayar = [
            'id_bayar' => $kodebayar,
            'order_bayar' => $kode,
            'metode_bayar' => $post['metode'],
            'total_bayar' => $total->total,
            'cod_bayar' => 0,
            'status_bayar' => 0
        ];
        $this->db->insert('order_bayar', $dataBayar);
        if ($post['metode'] == 2) {
            $queryBank = $this->db->where('id_cs_bank', $post['bank'])->get('customer_bank')->row();
            $dataBank = [
                'idbayar_bayar_bank' => $kodebayar,
                'bankcs_bayar_bank' => $queryBank->bank_cs_bank,
                'pemilik_bayar_bank' => $queryBank->pemilik_cs_bank,
                'norek_bayar_bank' => $queryBank->norek_cs_bank
            ];
            $this->db->insert('order_bayar_bank', $dataBank);
        }
        $data_tmp = $this->db->where('user', id_user())->get('tmp_order')->result_array();
        foreach ($data_tmp as $d) {
            $data_detail = [
                'idorder_order_barang' => $kode,
                'idbarang_order_barang' => $d['idhrgdetail'],
                'jumlah_order_barang' => $d['jumlah'],
                'harga_order_barang' => $d['harga'],
                'diskon_order_barang' => $d['diskon']
            ];
            $this->db->insert('order_barang', $data_detail);
        }
        return $order;
    }
}

/* End of file Mpesanan.php */
