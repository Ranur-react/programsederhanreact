<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mtmp_create extends CI_Model
{
    public function tampil_data()
    {
        return $this->db->from('tmp_permintaan')
            ->join('barang', 'barang=id_barang')
            ->join('satuan', 'satuan=id_satuan')
            ->where('user', id_user())
            ->get()->result_array();
    }
    public function store($post)
    {
        $data = [
            'barang' => $post['barang'],
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
            ->join('barang', 'barang=id_barang')
            ->join('satuan', 'satuan=id_satuan')
            ->where(['barang' => $kode, 'user', id_user()])
            ->get()->row_array();
    }
    public function update($post)
    {
        $data = [
            'satuan' => $post['satuan'],
            'harga'  => convert_uang($post['harga']),
            'jumlah' => convert_uang($post['jumlah'])
        ];
        return $this->db->where(['barang' => $post['barang'], 'user' => id_user()])->update('tmp_permintaan', $data);
    }
    public function destroy($kode)
    {
        return $this->db->where(['barang' => $kode, 'user' => id_user()])->delete('tmp_permintaan');
    }
    public function batal()
    {
        return $this->db->where('user', id_user())->delete('tmp_permintaan');
    }
}

/* End of file Mtmp_create.php */
