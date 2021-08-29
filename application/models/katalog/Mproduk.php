<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mproduk extends CI_Model
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
        $produk = $this->db->insert('barang', $data);
        if (isset($post['pemasok'])) {
            foreach ($post['pemasok'] as $id_pemasok) {
                $this->db->query("INSERT INTO barang_supplier SET barang_brg_referensi='$kode',supplier_brg_referensi='$id_pemasok'");
            }
        }
        if (isset($post['produk_desc'])) {
            foreach ($post['produk_desc'] as $produk_desc_key => $produk_desc) {
                foreach ($produk_desc['produk_desc_desc'] as $produk_desc_desc) {
                    if ($produk_desc['name'] != "" && $produk_desc_desc != "") :
                        $this->db->query("INSERT INTO barang_deskripsi SET barang_brg_desc = '" . $kode . "', judul_brg_desc = '" . $produk_desc['name'] . "', desc_brg_desc = '" .  $produk_desc_desc . "', level_brg_desc = '" . $produk_desc['attribute_id'] . "'");
                    endif;
                }
            }
        }
        if (isset($post['produk_kategori'])) {
            foreach ($post['produk_kategori'] as $id_kategori) {
                $this->db->query("INSERT INTO barang_kategori SET barang_brg_kategori='$kode',kategori_brg_kategori='$id_kategori'");
            }
        }
        if (isset($post['produk_satuan'])) {
            foreach ($post['produk_satuan'] as $id_satuan) {
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
        return $produk;
    }
    public function show($id = null)
    {
        $sql = $this->db->where('id_barang', $id)->get('barang')->row();
        $data = [
            'id' => (int)$sql->id_barang,
            'nama' => $sql->nama_barang,
            'slug' => $sql->slug_barang,
            'status' => (int)$sql->status_barang
        ];
        // Referensi pemasok produk
        $sql_pemasok = $this->db->from('barang_supplier')
            ->join('supplier', 'supplier_brg_referensi=id_supplier')
            ->where('barang_brg_referensi', $sql->id_barang)
            ->get()->result();
        $result_pemasok = array();
        $dataPemasok = array();
        foreach ($sql_pemasok as $sp) {
            $result_pemasok = [
                'iddetailPemasok' => (int)$sp->id_brg_referensi,
                'idPemasok' => (int)$sp->id_supplier,
                'pemasok' => $sp->nama_supplier
            ];
            $dataPemasok[] = $result_pemasok;
        }
        $data['dataPemasok'] = $dataPemasok;
        // Deksripsi produk
        $sql_desc = $this->db->from('barang_deskripsi')->where('barang_brg_desc', $sql->id_barang)->get()->result();
        $result_desc = array();
        $dataDesc = array();
        foreach ($sql_desc as $sd) {
            $result_desc = [
                'idDesc' => (int)$sd->id_brg_desc,
                'judul' => $sd->judul_brg_desc,
                'desc' => $sd->desc_brg_desc,
                'level' => (int)$sd->level_brg_desc
            ];
            $dataDesc[] = $result_desc;
        }
        $data['dataDesc'] = $dataDesc;
        // Kategori produk
        $sql_kategori = $this->db->query("SELECT cp.kategori_path AS id,GROUP_CONCAT(cd2.nama_kategori ORDER BY cp.level_path SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS nama,cd1.nama_kategori AS child,c1.parent_kategori AS parent FROM kategori_path cp LEFT JOIN kategori c1 ON (cp.kategori_path=c1.id_kategori) LEFT JOIN kategori c2 ON (cp.parent_path=c2.id_kategori) LEFT JOIN kategori cd2 ON (cp.parent_path=cd2.id_kategori) LEFT JOIN kategori cd1 ON (cp.kategori_path=cd1.id_kategori) LEFT JOIN barang_kategori ON (cp.kategori_path=kategori_brg_kategori) WHERE barang_brg_kategori='" . $sql->id_barang . "' GROUP BY cp.kategori_path")->result();
        $result_kategori = array();
        $dataKategori = array();
        foreach ($sql_kategori as $sd) {
            $result_kategori = [
                'idKategori' => (int)$sd->id,
                'kategori' => $sd->nama,
                'child' => $sd->child
            ];
            $dataKategori[] = $result_kategori;
        }
        $data['dataKategori'] = $dataKategori;
        // Satuan produk
        $sql_satuan = $this->db->from('barang_satuan')
            ->join('satuan', 'id_satuan=satuan_brg_satuan')
            ->where('barang_brg_satuan', $sql->id_barang)
            ->get()->result();
        $result_satuan = array();
        $dataSatuan = array();
        foreach ($sql_satuan as $sd) {
            $result_satuan = [
                'idSatuan' => (int)$sd->satuan_brg_satuan,
                'satuan' => $sd->nama_satuan
            ];
            $dataSatuan[] = $result_satuan;
        }
        $data['dataSatuan'] = $dataSatuan;
        // Gambar produk
        $sql_gambar = $this->db->from('barang_gambar')
            ->join('satuan', 'satuan_brg_gambar=id_satuan')
            ->where('barang_brg_gambar', $sql->id_barang)
            ->order_by('sort_order', 'asc')
            ->get()->result();
        $result_gambar = array();
        $dataGambar = array();
        foreach ($sql_gambar as $sd) {
            $result_gambar = [
                'idGambar' => (int)$sd->id_brg_gambar,
                'satuan' => $sd->nama_satuan,
                'gambar' => assets() . $sd->url_brg_gambar,
                'gambarPath' => pathImage() . $sd->url_brg_gambar,
                'nourut' => (int)$sd->sort_order
            ];
            $dataGambar[] = $result_gambar;
        }
        $data['dataGambar'] = $dataGambar;
        return $data;
    }
    public function update($post)
    {
        $kode = $post['kode'];
        $data = array(
            'nama_barang' => $post['nama'],
            'slug_barang' => $post['slug'],
            'status_barang' => $post['status']
        );
        $produk = $this->db->where('id_barang', $kode)->update('barang', $data);
        if (isset($post['pemasok'])) {
            $this->db->where('barang_brg_referensi', $kode)->delete('barang_supplier');
            foreach ($post['pemasok'] as $id_pemasok) {
                $this->db->query("INSERT INTO barang_supplier SET barang_brg_referensi='$kode',supplier_brg_referensi='$id_pemasok'");
            }
        }
        if (isset($post['produk_desc'])) {
            $this->db->where('barang_brg_desc', $kode)->delete('barang_deskripsi');
            foreach ($post['produk_desc'] as $produk_desc_key => $produk_desc) {
                foreach ($produk_desc['produk_desc_desc'] as $produk_desc_desc) {
                    if ($produk_desc['name'] != "" && $produk_desc_desc != "") :
                        $this->db->query("INSERT INTO barang_deskripsi SET barang_brg_desc = '" . $kode . "', judul_brg_desc = '" . $produk_desc['name'] . "', desc_brg_desc = '" .  $produk_desc_desc . "', level_brg_desc = '" . $produk_desc['attribute_id'] . "'");
                    endif;
                }
            }
        }

        if (isset($post['produk_kategori'])) {
            $this->db->where('barang_brg_kategori', $kode)->delete('barang_kategori');
            foreach ($post['produk_kategori'] as $id_kategori) {
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
        if (isset($post['produk_satuan'])) {
            foreach ($post['produk_satuan'] as $id_satuan) {
                $check = $this->db->from('barang_satuan')->where(['barang_brg_satuan' => $kode, 'satuan_brg_satuan' => $id_satuan])->count_all_results();
                if ($check == 0) {
                    $this->db->query("INSERT INTO barang_satuan SET barang_brg_satuan='$kode',satuan_brg_satuan='$id_satuan'");
                }
            }
        }
        return $produk;
    }
    public function destroy($kode)
    {
        $sql = $this->show($kode);
        foreach ($sql['dataGambar'] as $value) {
            unlink($value['gambarPath']);
            RemoveEmptyFolders($value['gambarPath']);
            $this->db->where('id_brg_gambar', $value['idGambar'])->delete('barang_gambar');
        }
        $this->db->where('barang_brg_satuan', $kode)->delete('barang_satuan');
        $this->db->where('barang_brg_kategori', $kode)->delete('barang_kategori');
        $this->db->where('barang_brg_desc', $kode)->delete('barang_deskripsi');
        $this->db->where('barang_brg_referensi', $kode)->delete('barang_supplier');
        $this->db->where('id_barang', $kode)->delete('barang');
        return true;
    }
    public function get_satuan($id = null)
    {
        $query = $this->db->from('barang_satuan')
            ->join('satuan', 'satuan_brg_satuan=id_satuan')
            ->where('barang_brg_satuan', $id)
            ->get()->result_array();
        return $query;
    }
}

/* End of file Mproduk.php */
