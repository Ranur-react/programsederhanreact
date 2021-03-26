<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mbarang extends CI_Model
{
    public function fetch_all()
    {
        return $this->db->order_by('nama_barang', 'ASC')->get('barang')->result_array();
    }
    public function jumlah_data()
    {
        return $this->db->count_all_results("barang");
    }
    public function tampil_data($start, $length, $status = '')
    {
        $sql = $this->db->from('barang');
        if ($status != '') {
            $sql = $this->db->where('status_barang', $status);
        }
        $sql = $this->db->limit($length, $start);
        $sql = $this->db->get();
        return $sql;
    }
    public function cari_data($search, $status = '')
    {
        $sql = $this->db
            ->from('barang')
            ->order_by('nama_barang', 'ASC')
            ->like('nama_barang', $search);
        if ($status != '') {
            $sql = $this->db->where('status_barang', $status);
        }
        $sql = $this->db->get();
        return $sql;
    }
    public function barang_desc($kode)
    {
        return $this->db->where('barang_brg_desc', $kode)->get('barang_deskripsi')->result_array();
    }
    public function barang_kategori($kode)
    {
        return $this->db->from('barang_kategori')
            ->join('kategori', 'id_kategori=kategori_brg_kategori')
            ->where('barang_brg_kategori', $kode)
            ->get()->result_array();
    }
    public function barang_satuan($kode)
    {
        return $this->db->from('barang_satuan')
            ->join('satuan', 'id_satuan=satuan_brg_satuan')
            ->where('barang_brg_satuan', $kode)
            ->get()->result_array();
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
        if (isset($post['barang_desc'])) {
            foreach ($post['barang_desc'] as $barang_desc_key => $barang_desc) {
                foreach ($barang_desc['barang_desc_desc'] as $barang_desc_desc) {
                    if ($barang_desc['name'] != "" && $barang_desc_desc != "") :
                        $this->db->query("INSERT INTO barang_deskripsi SET barang_brg_desc = '" . $kode . "', judul_brg_desc = '" . $barang_desc['name'] . "', desc_brg_desc = '" .  $barang_desc_desc . "', level_brg_desc = '" . $barang_desc['attribute_id'] . "'");
                    endif;
                }
            }
        }
        if (isset($post['barang_kategori'])) {
            foreach ($post['barang_kategori'] as $id_kategori) {
                $this->db->query("INSERT INTO barang_kategori SET barang_brg_kategori='$kode',kategori_brg_kategori='$id_kategori'");
            }
        }
        if (isset($post['barang_satuan'])) {
            foreach ($post['barang_satuan'] as $id_satuan) {
                $this->db->query("INSERT INTO barang_satuan SET barang_brg_satuan='$kode',satuan_brg_satuan='$id_satuan'");
            }
        }
        return $barang;
    }
    public function show($kode)
    {
        return $this->db->where('id_barang', $kode)->get('barang')->row_array();
    }
    public function update($post)
    {
        $kode = $post['kode'];
        $data = array(
            'nama_barang' => $post['nama'],
            'slug_barang' => $post['slug'],
            'status_barang' => $post['status']
        );
        $barang = $this->db->where('id_barang', $kode)->update('barang', $data);
        if (isset($post['barang_desc'])) {
            $this->db->where('barang_brg_desc', $kode)->delete('barang_deskripsi');
            foreach ($post['barang_desc'] as $barang_desc_key => $barang_desc) {
                foreach ($barang_desc['barang_desc_desc'] as $barang_desc_desc) {
                    if ($barang_desc['name'] != "" && $barang_desc_desc != "") :
                        $this->db->query("INSERT INTO barang_deskripsi SET barang_brg_desc = '" . $kode . "', judul_brg_desc = '" . $barang_desc['name'] . "', desc_brg_desc = '" .  $barang_desc_desc . "', level_brg_desc = '" . $barang_desc['attribute_id'] . "'");
                    endif;
                }
            }
        }
        if (isset($post['barang_kategori'])) {
            $this->db->where('barang_brg_kategori', $kode)->delete('barang_kategori');
            foreach ($post['barang_kategori'] as $id_kategori) {
                $this->db->query("INSERT INTO barang_kategori SET barang_brg_kategori='$kode',kategori_brg_kategori='$id_kategori'");
            }
        }
        if (isset($post['barang_satuan'])) {
            $this->db->where('barang_brg_satuan', $kode)->delete('barang_satuan');
            foreach ($post['barang_satuan'] as $id_satuan) {
                $this->db->query("INSERT INTO barang_satuan SET barang_brg_satuan='$kode',satuan_brg_satuan='$id_satuan'");
            }
        }
        return $barang;
    }
    public function destroy($kode)
    {
        $hapus_satuan = $this->db->where('barang_brg_satuan', $kode)->delete('barang_satuan');
        $hapus_kategori = $this->db->where('barang_brg_kategori', $kode)->delete('barang_kategori');
        $hapus_desc = $this->db->where('barang_brg_desc', $kode)->delete('barang_deskripsi');
        $hapus_barang = $this->db->where('id_barang', $kode)->delete('barang');
        return array($hapus_satuan, $hapus_kategori, $hapus_desc, $hapus_barang);
    }
}

/* End of file Mbarang.php */
