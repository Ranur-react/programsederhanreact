<?php
class Msatuan extends CI_Model
{
    var $tabel = 'satuan';
    var $id = 'id_satuan';

    public function getall($data = null)
    {
        if ($data == 'data')
            return $this->db->get($this->tabel)->result_array();
        else
            return $this->db->where_not_in('id_satuan', '1')->get($this->tabel)->result_array();
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
        return $this->db->where($this->id, $post['kode'])->update($this->tabel, ['nama_satuan' => $post['nama'], 'singkatan_satuan' => $post['singkatan']]);
    }
    public function destroy($kode)
    {
        return $this->db->simple_query("DELETE FROM " . $this->tabel . " WHERE id_satuan='$kode'");
    }
}
