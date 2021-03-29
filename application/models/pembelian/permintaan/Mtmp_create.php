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
}

/* End of file Mtmp_create.php */
