<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mbarang extends CI_Model
{
    var $tabel = 'barang';
    var $id = 'id_barang';
    var $column_order = array(null, 'nama_barang');
    var $column_search = array('nama_barang');
    var $order = array('nama_barang' => 'asc');

    public function _get_data_query()
    {
        $this->db->from($this->tabel);
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_GET['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_GET['search']['value']);
                } else {
                    $this->db->or_like($item, $_GET['search']['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_GET['order'])) {
            $this->db->order_by($this->column_order[$_GET['order']['0']['column']], $_GET['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function get_all()
    {
        $this->_get_data_query();
        if ($_GET['length'] != -1)
            $this->db->limit($_GET['length'], $_GET['start']);
        $query = $this->db->get();
        return $query->result();
    }
    public function count_all()
    {
        $this->db->from($this->tabel);
        return $this->db->count_all_results();
    }
    public function count_filtered()
    {
        $this->_get_data_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function fetch_all()
    {
        return $this->db->order_by('nama_barang', 'ASC')->get('barang')->result_array();
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
        $queryGambar = $this->db->where('user', id_user())->get('tmp_gambar')->result_array();
        foreach ($queryGambar as $qg) {
            $this->db->insert(
                'barang_gambar',
                array(
                    'barang_brg_gambar' => $kode,
                    'satuan_brg_gambar' => $qg['idsatuan'],
                    'url_brg_gambar' => $qg['gambar'],
                    'sort_order' => $qg['nourut']
                )
            );
        }
        $this->db->where('user', id_user())->delete('tmp_gambar');
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
            foreach ($post['barang_satuan'] as $id_satuan) {
                $check = $this->db->from('barang_satuan')->where(['barang_brg_satuan' => $kode, 'satuan_brg_satuan' => $id_satuan])->count_all_results();
                if ($check == 0) {
                    $this->db->query("INSERT INTO barang_satuan SET barang_brg_satuan='$kode',satuan_brg_satuan='$id_satuan'");
                }
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
    public function get_satuan($barang)
    {
        $query = $this->db->from('barang_satuan')
            ->join('satuan', 'satuan_brg_satuan=id_satuan')
            ->where('barang_brg_satuan', $barang)
            ->get()->result_array();
        return $query;
    }
}

/* End of file Mbarang.php */
