<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mtmp_edit extends CI_Model
{
    public function tampil_data($kode)
    {
        return $this->db->from('permintaan_detail')
            ->join('barang', 'barang_detail=id_barang')
            ->join('satuan', 'satuan_detail=id_satuan')
            ->where('permintaan_detail', $kode)
            ->get()->result_array();
    }
    public function get_total($kode)
    {
        $query = $this->db->select('IFNULL(SUM(harga_detail*jumlah_detail),0) AS total')->where('permintaan_detail', $kode)->get('permintaan_detail')->row();
        return $query->total;
    }
    public function update_total($kode)
    {
        $total = $this->get_total($kode);
        $data = array(
            'total_permintaan' => $total
        );
        return $this->db->where('id_permintaan', $kode)->update('permintaan', $data);
    }
    public function store($post)
    {
        $data = [
            'permintaan_detail' => $post['id_permintaan'],
            'barang_detail' => $post['barang'],
            'satuan_detail' => $post['satuan'],
            'harga_detail' => convert_uang($post['harga']),
            'jumlah_detail' => convert_uang($post['jumlah'])
        ];
        $store = $this->db->insert('permintaan_detail', $data);
        $this->update_total($post['id_permintaan']);
        return $store;
    }
    public function show($kode)
    {
        return $this->db->from('permintaan_detail')
            ->join('barang', 'barang_detail=id_barang')
            ->join('satuan', 'satuan_detail=id_satuan')
            ->where('id_detail', $kode)
            ->get()->row_array();
    }
    public function update($post)
    {
        $data = $this->show($post['kode']);
        $kode = $data['permintaan_detail'];
        $data = [
            'satuan_detail' => $post['satuan'],
            'harga_detail' => convert_uang($post['harga']),
            'jumlah_detail' => convert_uang($post['jumlah'])
        ];
        $update = $this->db->where('id_detail', $post['kode'])->update('permintaan_detail', $data);
        $this->update_total($kode);
        return $update;
    }
    public function destroy($kode)
    {
        $data = $this->show($kode);
        $kode = $data['permintaan_detail'];
        $hapus = $this->db->where('id_detail', $kode)->delete('permintaan_detail');
        $this->update_total($kode);
        return $hapus;
    }
}

/* End of file Mtmp_edit.php */
