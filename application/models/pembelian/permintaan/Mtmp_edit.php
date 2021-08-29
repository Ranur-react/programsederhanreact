<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mtmp_edit extends CI_Model
{
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
            'permintaan_detail' => $post['idminta'],
            'barang_detail' => $post['satuan'],
            'harga_detail' => convert_uang($post['harga']),
            'jumlah_detail' => convert_uang($post['jumlah'])
        ];
        $store = $this->db->insert('permintaan_detail', $data);
        $this->update_total($post['idminta']);
        return $store;
    }
    public function show($kode)
    {
        return $this->db->from('permintaan_detail')
            ->join('barang_satuan', 'barang_detail=id_brg_satuan')
            ->join('barang', 'barang_brg_satuan=id_barang')
            ->join('satuan', 'satuan_brg_satuan=id_satuan')
            ->where('id_detail', $kode)
            ->get()->row_array();
    }
    public function update($post)
    {
        $data = $this->show($post['kode']);
        $kode = $data['permintaan_detail'];
        $data = [
            'barang_detail' => $post['satuan'],
            'harga_detail' => convert_uang($post['harga']),
            'jumlah_detail' => convert_uang($post['jumlah'])
        ];
        $update = $this->db->where('id_detail', $post['kode'])->update('permintaan_detail', $data);
        $this->update_total($kode);
        return $update;
    }
    public function destroy($kode)
    {
        $check = $this->db->from('penerimaan_detail')->where('minta_detail', $kode)->count_all_results();
        if ($check > 0) :
            $status = '0101';
        else :
            $data = $this->show($kode);
            $this->db->where('id_detail', $kode)->delete('permintaan_detail');
            $this->update_total($data['permintaan_detail']);
            $status = '0100';
        endif;
        return $status;
    }
    public function batal($kode)
    {
        $detail = $this->db->where('permintaan_detail', $kode)->delete('permintaan_detail');
        $data = $this->db->where('id_permintaan', $kode)->delete('permintaan');
        return array($detail, $data);
    }
}

/* End of file Mtmp_edit.php */
