<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mkategori extends CI_Model
{
    public function count_all()
    {
        return $this->db->count_all_results('kategori');
    }
    public function fetch_all($start, $length)
    {
        $sql = $this->db->query("SELECT cp.kategori_path AS id,GROUP_CONCAT(cd2.nama_kategori ORDER BY cp.level_path SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS nama,
        c1.parent_kategori AS parent,cd2.icon_kategori AS image
        FROM kategori_path cp LEFT JOIN kategori c1 ON (cp.kategori_path=c1.id_kategori)
        LEFT JOIN kategori c2 ON (cp.parent_path=c2.id_kategori)
        LEFT JOIN kategori cd2 ON (cp.parent_path=cd2.id_kategori)
        LEFT JOIN kategori cd1 ON (cp.kategori_path=cd1.id_kategori)
        GROUP BY cp.kategori_path
        ORDER BY nama ASC LIMIT $start,$length");
        return $sql;
    }
    public function search_data($search)
    {
        $sql = $this->db->query("SELECT cp.kategori_path AS id,GROUP_CONCAT(cd2.nama_kategori ORDER BY cp.level_path SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS nama,
        c1.parent_kategori AS parent
        FROM kategori_path cp LEFT JOIN kategori c1 ON (cp.kategori_path=c1.id_kategori)
        LEFT JOIN kategori c2 ON (cp.parent_path=c2.id_kategori)
        LEFT JOIN kategori cd2 ON (cp.parent_path=cd2.id_kategori)
        LEFT JOIN kategori cd1 ON (cp.kategori_path=cd1.id_kategori)
        WHERE cd2.nama_kategori LIKE '%$search%'
        GROUP BY cp.kategori_path
        ORDER BY nama ASC");
        return $sql;
    }
    public function get_all()
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
    public function update($post, $link)
    {
        $kode = $post['kode'];
        $parent = $post['parent'];
        $row = $this->show($kode);
        if ($link == '') :
            $data = array(
                'nama_kategori' => $post['nama'],
                'slug_kategori' => $post['slug'],
                'parent_kategori' => $parent
            );
        else :
            if ($row['icon_kategori'] != "") {
                unlink(pathImage() . $row['icon_kategori']);
            }
            $data = array(
                'nama_kategori' => $post['nama'],
                'slug_kategori' => $post['slug'],
                'icon_kategori' => $link,
                'parent_kategori' => $parent
            );
        endif;
        $this->db->where('id_kategori', $kode)->update('kategori', $data);

        $sql = $this->db->query("SELECT * FROM kategori_path WHERE parent_path='$kode' ORDER BY level_path ASC");
        if ($sql->num_rows() > 0) {
            foreach ($sql->result_array() as $kategory_path) {
                // Hapus semua level yang ada dibawah
                $this->db->query("DELETE FROM kategori_path WHERE kategori_path='" . $kategory_path['kategori_path'] . "' AND level_path < '" . $kategory_path['level_path'] . "'");
                $path = array();
                // Dapatkan level induk yang baru
                $query = $this->db->query("SELECT * FROM kategori_path WHERE kategori_path='$parent' ORDER BY level_path ASC");
                foreach ($query->result_array() as $result) {
                    $path[] = $result['parent_path'];
                }
                // Dapatkan level yang tersisa saat ini
                $query = $this->db->query("SELECT * FROM kategori_path WHERE kategori_path='" . $kategory_path['kategori_path'] . "' ORDER BY level_path ASC");
                foreach ($query->result_array() as $result) {
                    $path[] = $result['parent_path'];
                }
                // Gabungkan jalur dengan level baru
                $level = 0;
                foreach ($path as $path_id) {
                    $this->db->query("REPLACE INTO kategori_path SET kategori_path='" . $kategory_path['kategori_path'] . "', parent_path='" . $path_id . "', level_path='" . $level . "'");
                    $level++;
                }
            }
        } else {
            // Hapus semua level yang ada dibawah
            $this->db->query("DELETE FROM kategori_path WHERE category_id='$kode'");
            // Perbaiki untuk level tanpa jalur
            $level = 0;
            $query = $this->db->query("SELECT * FROM kategori_path WHERE category_id='$parent' ORDER BY level_path ASC");
            foreach ($query->result_array() as $result) {
                $this->db->query("INSERT INTO kategori_path SET kategori_path='" . $kode . "',parent_path='" . $result['parent_path'] . "', level_path='" . $level . "'");
                $level++;
            }
            $this->db->query("REPLACE INTO kategori_path SET kategori_path='" . $kode . "',parent_path='" . $kode . "', level_path='" . $level . "'");
        }
    }
    public function destroy($kode)
    {
        $data = $this->show($kode);
        $this->db->query("DELETE FROM kategori_path WHERE kategori_path='$kode'");
        $query = $this->db->query("SELECT * FROM kategori_path WHERE parent_path='$kode'")->result_array();
        foreach ($query as $result) {
            $this->destroy($result['kategori_path']);
        }
        if ($data['icon_kategori'] != "") {
            unlink(pathImage() . $data['icon_kategori']);
        }
        $this->db->query("DELETE FROM kategori WHERE id_kategori='$kode'");
        return true;
    }
    // pencarian kategori berdasarkan nama
    public function kategori_by_nama($filter_nama = '')
    {
        return $this->db->query("SELECT cp.kategori_path AS id,GROUP_CONCAT(cd2.nama_kategori ORDER BY cp.level_path SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS nama,
        c1.parent_kategori AS parent
        FROM kategori_path cp LEFT JOIN kategori c1 ON (cp.kategori_path=c1.id_kategori)
        LEFT JOIN kategori c2 ON (cp.parent_path=c2.id_kategori)
        LEFT JOIN kategori cd2 ON (cp.parent_path=cd2.id_kategori)
        LEFT JOIN kategori cd1 ON (cp.kategori_path=cd1.id_kategori)
        WHERE cd1.nama_kategori LIKE '%$filter_nama%'
        GROUP BY cp.kategori_path
        ORDER BY nama ASC LIMIT 10")->result_array();
    }
}

/* End of file Mkategori.php */
