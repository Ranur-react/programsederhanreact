<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mkategori extends CI_Model
{
    public function fetch_all()
    {
        return $this->db->query("SELECT cp.kategori_path AS id,GROUP_CONCAT(cd2.nama_kategori ORDER BY cp.level_path SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS nama,
        c1.parent_kategori AS parent
        FROM kategori_path cp LEFT JOIN kategori c1 ON (cp.kategori_path=c1.id_kategori)
        LEFT JOIN kategori c2 ON (cp.parent_path=c2.id_kategori)
        LEFT JOIN kategori cd2 ON (cp.parent_path=cd2.id_kategori)
        LEFT JOIN kategori cd1 ON (cp.kategori_path=cd1.id_kategori)
        GROUP BY cp.kategori_path
        ORDER BY nama ASC")->result_array();
    }
    public function kode()
    {
        $this->db->select('id_kategori', FALSE)
            ->order_by('id_kategori', 'DESC')
            ->limit(1);
        $query = $this->db->get('kategori');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->id_kategori) + 1;
        } else {
            $kode = 1;
        }
        return $kode;
    }
    public function store($post, $link)
    {
        $kode = $this->kode();
        $nama = $post['nama'];
        $slug = $post['slug'];
        $parent = $post['parent'];
        $this->db->query("INSERT INTO kategori VALUES('$kode','$nama','$slug','$link','$parent')");
        $level = 0;
        if ($parent != "0") :
            $query = $this->db->query("SELECT * FROM kategori_path WHERE kategori_path='$parent'");
            foreach ($query->result() as $result) {
                $path = $result->parent_path;
                $this->db->query("INSERT INTO kategori_path(kategori_path,parent_path,level_path) VALUES ('$kode','$path','$level')");
                $level++;
            }
        endif;
        $this->db->query("INSERT INTO kategori_path(kategori_path,parent_path,level_path) VALUES ('$kode','$kode',$level)");
    }
    public function show($kode)
    {
        return $this->db->where('id_kategori', $kode)->get('kategori')->row_array();
    }
}

/* End of file Mkategori.php */
