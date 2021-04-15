<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mtmp_edit extends CI_Model
{
    public function tampil_data($kode)
    {
        return $this->db->select('*,penerimaan_detail.id_detail AS id_detail_terima,penerimaan_detail.harga_detail AS harga_terima,penerimaan_detail.jumlah_detail AS jumlah_terima')
            ->from('penerimaan_detail')
            ->join('permintaan_detail', 'minta_detail=permintaan_detail.id_detail')
            ->join('barang_satuan', 'barang_detail=id_brg_satuan')
            ->join('barang', 'barang_brg_satuan=id_barang')
            ->join('satuan', 'satuan_brg_satuan=id_satuan')
            ->where('terima_detail', $kode)
            ->get()->result_array();
    }
}

/* End of file Mtmp_edit.php */
