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
    public function show($kode)
    {
        return $this->db->select('terima_detail,nama_barang,nama_satuan,singkatan_satuan,penerimaan_detail.id_detail AS id_detail_terima,penerimaan_detail.harga_detail AS harga_terima,penerimaan_detail.jumlah_detail AS jumlah_terima,permintaan_detail.harga_detail AS harga_minta,permintaan_detail.jumlah_detail AS jumlah_minta')
            ->from('penerimaan_detail')
            ->join('permintaan_detail', 'minta_detail=permintaan_detail.id_detail')
            ->join('barang_satuan', 'barang_detail=id_brg_satuan')
            ->join('barang', 'barang_brg_satuan=id_barang')
            ->join('satuan', 'satuan_brg_satuan=id_satuan')
            ->where('penerimaan_detail.id_detail', $kode)
            ->get()->row_array();
    }
    public function get_total($kode)
    {
        $query = $this->db->select('IFNULL(SUM(harga_detail*jumlah_detail),0) AS total')->where('terima_detail', $kode)->get('penerimaan_detail')->row();
        return $query->total;
    }
    public function update_total($kode)
    {
        $total = $this->get_total($kode);
        $data = array(
            'total_terima' => $total
        );
        return $this->db->where('id_terima', $kode)->update('penerimaan', $data);
    }
    public function update($post)
    {
        $data = $this->show($post['iddetail']);
        $kode = $data['terima_detail'];
        $data = [
            'harga_detail'  => convert_uang($post['harga']),
            'jumlah_detail' => convert_uang($post['jumlah'])
        ];
        $query = $this->db->where('id_detail', $post['iddetail'])->update('penerimaan_detail', $data);
        $this->update_total($kode);
        return $query;
    }
}

/* End of file Mtmp_edit.php */
