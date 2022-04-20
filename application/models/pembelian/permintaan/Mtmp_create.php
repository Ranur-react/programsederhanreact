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
            ->get()->result();
    }
    public function store($post)
    {
        $data = [
            'satuan' => $post['satuan'],
            'harga'  => hapus_desimal($post['harga']),
            'jumlah' => hapus_desimal($post['jumlah']),
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
            ->where('id', $kode)
            ->get()->row_array();
    }
    public function update($post)
    {
        $data = [
            'satuan' => $post['satuan'],
            'harga'  => hapus_desimal($post['harga']),
            'jumlah' => hapus_desimal($post['jumlah'])
        ];
        return $this->db->where('id', $post['idtmp'])->update('tmp_permintaan', $data);
    }
    public function destroy($kode)
    {
        return $this->db->where('id', $kode)->delete('tmp_permintaan');
    }
    public function batal()
    {
        return $this->db->where('user', id_user())->delete('tmp_permintaan');
    }
}

/* End of file Mtmp_create.php */
