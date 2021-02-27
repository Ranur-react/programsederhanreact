<?php
class Mgudang extends CI_Model
{
    var $tabel = 'gudang';
    var $id = 'id_gudang';

    public function getall()
    {
        return $this->db->get($this->tabel)->result_array();
    }
    public function kode()
    {
        $query = $this->db
            ->select($this->id, FALSE)
            ->order_by($this->id, 'DESC')
            ->limit(1)
            ->get($this->tabel);
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->id_gudang) + 1;
        } else {
            $kode = 1;
        }
        return $kode;
    }
    public function store($post)
    {
        $data = array(
            'id_gudang' => $this->kode(),
            'nama_gudang' => $post['nama'],
            'alamat_gudang' => $post['alamat']
        );
        return $this->db->insert($this->tabel, $data);
    }
}
