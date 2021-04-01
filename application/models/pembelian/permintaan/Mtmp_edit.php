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
}

/* End of file Mtmp_edit.php */
