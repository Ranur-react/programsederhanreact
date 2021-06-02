<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mtmp_create extends CI_Model
{
    public function tampil_data()
    {
        return $this->db->from('tmp_permintaan')
            ->join('barang_satuan', 'satuan=id_brg_satuan')
            ->join('barang', 'barang_brg_satuan=id_barang')
            ->join('satuan', 'satuan_brg_satuan=id_satuan')
            ->where('user', id_user())
            ->order_by('tmp_permintaan.id')
            ->get()->result_array();
    }
    public function store($post)
    {
        $data = [
            'satuan' => $post['satuan'],
            'harga'  => convert_uang($post['harga']),
            'jumlah' => convert_uang($post['jumlah']),
            'user'   => id_user()
        ];
        return $this->db->insert('tmp_permintaan', $data);
    }
    public function show($kode)
    {
        return $this->db->from('tmp_permintaan')
            ->join('barang_satuan', 'satuan=id_brg_satuan')
            ->join('barang', 'barang_brg_satuan=id_barang')
            ->join('satuan', 'satuan_brg_satuan=id_satuan')
            ->where(['satuan' => $kode, 'user' => id_user()])
            ->get()->row_array();
    }
    public function update($post)
    {
        $data = [
            'satuan' => $post['satuan'],
            'harga'  => convert_uang($post['harga']),
            'jumlah' => convert_uang($post['jumlah'])
        ];
        return $this->db->where(['satuan' => $post['barang'], 'user' => id_user()])->update('tmp_permintaan', $data);
    }
    public function destroy($kode)
    {
        return $this->db->where(['satuan' => $kode, 'user' => id_user()])->delete('tmp_permintaan');
    }
    public function batal()
    {
        return $this->db->where('user', id_user())->delete('tmp_permintaan');
    }
}

/* End of file Mtmp_create.php */
