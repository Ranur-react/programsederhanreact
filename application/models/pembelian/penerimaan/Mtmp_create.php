<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mtmp_create extends CI_Model
{
    public function jumlah_data()
    {
        return $this->db->from('permintaan')
            ->where_in('status_permintaan', array(1, 2))
            ->count_all_results();
    }
    public function tampil_data($start, $length)
    {
        $sql = $this->db->from('permintaan')
            ->join('supplier', 'supplier_permintaan=id_supplier')
            ->join('users', 'user_permintaan=id_user')
            ->where_in('status_permintaan', array(1, 2))
            ->order_by('id_permintaan', 'DESC')
            ->limit($length, $start)
            ->get();
        return $sql;
    }
    public function cari_data($search)
    {
        $sql = $this->db->from('permintaan')
            ->join('supplier', 'supplier_permintaan=id_supplier')
            ->join('users', 'user_permintaan=id_user')
            ->where_in('status_permintaan', array(1, 2))
            ->order_by('id_permintaan', 'DESC')
            ->like('nama_supplier', $search)
            ->get();
        return $sql;
    }
    public function data()
    {
        return $this->db->from('tmp_penerimaan')
            ->join('permintaan_detail', 'iddetail=id_detail')
            ->join('barang', 'barang_detail=id_barang')
            ->join('satuan', 'satuan_detail=id_satuan')
            ->where('user', id_user())
            ->get()->result_array();
    }
    public function store($post)
    {
        $data = [
            'iddetail' => $post['iddetail'],
            'permintaan' => $post['permintaan'],
            'harga'  => convert_uang($post['harga']),
            'jumlah' => convert_uang($post['jumlah']),
            'user'   => id_user()
        ];
        return $this->db->insert('tmp_penerimaan', $data);
    }
    public function show($kode)
    {
        return $this->db->from('tmp_penerimaan')
            ->join('permintaan_detail', 'iddetail=id_detail')
            ->join('barang', 'barang_detail=id_barang')
            ->join('satuan', 'satuan_detail=id_satuan')
            ->where('iddetail', $kode)
            ->get()->row_array();
    }
}

/* End of file Mtmp_create.php */
