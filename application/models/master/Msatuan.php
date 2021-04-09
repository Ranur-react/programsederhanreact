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
    public function show($kode)
    {
        return $this->db->where($this->id, $kode)->get($this->tabel)->row();
    }
    public function update($post)
    {
        $data = array(
            'nama_satuan' => $post['nama'],
            'singkatan_satuan' => $post['singkatan']
        );
        return $this->db->where($this->id, $post['kode'])->update($this->tabel, $data);
    }
    public function destroy($kode)
    {
        return $this->db->simple_query("DELETE FROM " . $this->tabel . " WHERE id_satuan='$kode'");
    }
    // pencarian satuan berdasarkan nama
    public function satuan_by_nama($filter_nama = '')
    {
        return $this->db->like('nama_satuan', $filter_nama)->get('satuan')->result_array();
    }
}
