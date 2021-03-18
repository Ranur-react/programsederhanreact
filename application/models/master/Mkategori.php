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
}

/* End of file Mkategori.php */
