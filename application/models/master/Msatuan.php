<?php
class Msatuan extends CI_Model
{
    var $tabel = 'satuan';
    var $id = 'id_satuan';

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
            $kode = intval($data->id_satuan) + 1;
        } else {
            $kode = 1;
        }
        return $kode;
    }
    public function store($post)
    {
        $data = array(
            'id_satuan' => $this->kode(),
            'nama_satuan' => $post['nama'],
            'singkatan_satuan' => $post['singkatan'],
        );
        return $this->db->insert($this->tabel, $data);
    }
}
