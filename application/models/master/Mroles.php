<?php
class Mroles extends CI_Model
{
    protected $tabel = 'role';
    public function fetch_all()
    {
        return $this->db->get($this->tabel)->result_array();
    }
    public function kode()
    {
        $query = $this->db
            ->select('id_role', FALSE)
            ->order_by('id_role', 'DESC')
            ->limit(1)
            ->get($this->tabel);
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->id_role) + 1;
        } else {
            $kode = 1;
        }
        return $kode;
    }
    public function store($post)
    {
        $data = array(
            'id_role' => $this->kode(),
            'nama_role' => $post['nama'],
            'jenis_role' => 0
        );
        return $this->db->insert($this->tabel, $data);
    }
    public function show($kode)
    {
        return $this->db->where('id_role', $kode)->get($this->tabel)->row_array();
    }
    public function update($post)
    {
        $data = array(
            'nama_role' => $post['nama']
        );
        return $this->db->where('id_role', $post['kode'])->update($this->tabel, $data);
    }
    public function destroy($kode)
    {
        return $this->db->simple_query("DELETE FROM " . $this->tabel . " WHERE id_role='$kode'");
    }
}
