<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mbarang extends CI_Model
{
    public function fetch_all()
    {
        return $this->db->order_by('nama_barang', 'ASC')->get('barang')->result_array();
    }
    public function kode()
    {
        $query = $this->db
            ->select('id_barang', FALSE)
            ->order_by('id_barang', 'DESC')
            ->limit(1)
            ->get('barang');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->id_barang) + 1;
        } else {
            $kode = 1;
        }
        return $kode;
    }
    public function store($post)
    {
        $kode = $this->kode();
        $data = array(
            'id_barang' => $kode,
            'nama_barang' => $post['nama'],
            'slug_barang' => $post['slug'],
            'status_barang' => $post['status']
        );
        $barang = $this->db->insert('barang', $data);
        return $barang;
    }
    public function show($kode)
    {
        return $this->db->where('id_barang', $kode)->get('barang')->row_array();
    }
    public function update($post)
    {
        $data = array(
            'nama_barang' => $post['nama'],
            'slug_barang' => $post['slug'],
            'desc_barang' => $post['desc'],
            'status_barang' => $post['status']
        );
        return $this->db->where('id_barang', $post['kode'])->update('barang', $data);
    }
    public function destroy($kode)
    {
        return $this->db->simple_query("DELETE FROM barang WHERE id_barang='$kode'");
    }
}

/* End of file Mbarang.php */
