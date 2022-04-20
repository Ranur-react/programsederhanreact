<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mharga extends CI_Model
{
    var $tabel = 'barang';
    var $id = 'id_barang';
    var $column_order = array(null, 'nama_barang');
    var $column_search = array('nama_barang');
    var $order = array('nama_barang' => 'asc');

    public function __construct()
    {
        parent::__construct();
        $this->load->model('pembelian/penerimaan/Mpenerimaan');
    }
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
    public function fetch_all()
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
    public function get_harga_terakhir($id = null)
    {
        $this->db->from('terima');
        $this->db->join('supplier', 'pemasok_terima=id_supplier');
        $this->db->join('terima_detail', 'id_terima=terima_detail');
        $this->db->join('terima_harga', 'id_detail=iddetail_harga');
        $this->db->join('barang_satuan', 'idsatuan_harga=id_brg_satuan');
        $this->db->join('barang', 'id_barang=barang_brg_satuan');
        $this->db->join('satuan', 'id_satuan=satuan_brg_satuan');
        $this->db->where(['id_barang' => $id, 'status_default' => 1]);
        $this->db->where('id_detail IN (SELECT DISTINCT iddetail_stok FROM terima_stok,barang_satuan,barang WHERE idsatuan_stok=id_brg_satuan AND id_barang=barang_brg_satuan AND id_barang=' . $id . ' AND real_stok >= 0)');
        $this->db->order_by('nourut_terima', 'desc');
        $this->db->limit(1);
        $sql = $this->db->get()->row();
        if ($sql != null) :
            $data = [
                'iddetail_terima' => (int)$sql->id_detail,
                'nomor' => $sql->nosurat_terima,
                'tanggal' => format_indo($sql->tanggal_terima),
                'pemasok' => $sql->nama_supplier,
                'produk' => $sql->nama_barang,
                'satuan' => $sql->singkatan_satuan,
                'hargaBeli' => currency($sql->harga_detail),
                'hargaText' => currency($sql->jual_harga),
                'jumlahProduk' => $sql->nilai_satuan
            ];
            $sql_satuan = $this->db->from('terima_detail')
                ->join('terima_harga', 'id_detail=iddetail_harga')
                ->join('barang_satuan', 'idsatuan_harga=id_brg_satuan')
                ->join('barang', 'id_barang=barang_brg_satuan')
                ->join('satuan', 'id_satuan=satuan_brg_satuan')
                ->where(['id_detail' => $id, 'status_aktif' => 1])
                ->where('id_detail IN (SELECT DISTINCT iddetail_stok FROM terima_stok,barang_satuan,barang WHERE idsatuan_stok=id_brg_satuan AND id_barang=barang_brg_satuan AND id_barang=' . $id . ' AND real_stok >= 0)')
                ->get()->result();
            $data_satuan = [];
            $result_satuan = [];
            foreach ($sql_satuan as $sql_satuan) {
                if ($sql_satuan->nilai_satuan == 0) :
                    $warning = '<span style="padding-left:5px;color: rgba(0,0,0,.54)">(Jumlah produk belum diset)</span>';
                else :
                    $warning = '';
                endif;
                $result_satuan = [
                    'jumlahProduk' => $sql_satuan->nilai_satuan,
                    'satuan' => $sql_satuan->singkatan_satuan,
                    'hargaText' => currency($sql_satuan->jual_harga),
                    'default' => $sql_satuan->status_default,
                    'aktif' => $sql_satuan->status_aktif,
                    'warning' => $warning
                ];
                $data_satuan[] = $result_satuan;
            }
            $data['dataSatuan'] = $data_satuan;
            $arr = [
                'status' => true,
                'data' => $data
            ];
        else :
            $arr = [
                'status' => false,
                'data' => []
            ];
        endif;
        return $arr;
    }
    public function data_harga($id = null)
    {
        $sql = $this->db->from('terima_harga')
            ->join('barang_satuan', 'idsatuan_harga=id_brg_satuan')
            ->join('satuan', 'satuan_brg_satuan=id_satuan')
            ->where('iddetail_harga', $id)
            ->get()->result();
        $data = [];
        $result = [];
        foreach ($sql as $sql) {
            $result = [
                'idharga' => $sql->id_harga,
                'satuan' => $sql->nama_satuan,
                'singkatan' => $sql->singkatan_satuan,
                'default' => $sql->status_default,
                'aktif' => $sql->status_aktif,
                'jumlahJual' => number_decimal($sql->nilai_satuan),
                'harga' => $sql->jual_harga,
                'hargaText' => currency($sql->jual_harga)
            ];
            $data[] = $result;
        }
        return $data;
    }
    public function get_harga($id = null)
    {
        $sql = $this->db->select('*,terima_detail.id_detail AS iddetail_terima,s1.singkatan_satuan AS singkatan1,s2.singkatan_satuan AS singkatan2')->from('terima')
            ->join('supplier', 'id_supplier=pemasok_terima')
            ->join('terima_detail', 'id_terima=terima_detail')
            ->join('permintaan_detail', 'minta_detail=permintaan_detail.id_detail')
            ->join('barang_satuan bs1', 'barang_detail=bs1.id_brg_satuan')
            ->join('satuan s1', 'bs1.satuan_brg_satuan=s1.id_satuan')
            ->join('terima_harga', 'terima_detail.id_detail=iddetail_harga')
            ->join('barang_satuan bs2', 'idsatuan_harga=bs2.id_brg_satuan')
            ->join('satuan s2', 'bs2.satuan_brg_satuan=s2.id_satuan')
            ->where('id_harga', $id)
            ->get()->row();
        $data = [
            'idharga' => (int)$sql->id_harga,
            'idterima' => (int)$sql->id_terima,
            'iddetail_terima' => (int)$sql->iddetail_terima,
            'nomor' => $sql->nosurat_terima,
            'tanggal' => format_indo($sql->tanggal_terima),
            'pemasok' => $sql->nama_supplier,
            'hargabeli' => currency($sql->harga_detail),
            'satuan1' => $sql->singkatan1,
            'satuan2' => $sql->singkatan2,
            'jumlah' => $sql->nilai_satuan,
            'harga' => $sql->jual_harga,
            'default' => $sql->status_default,
            'aktif' => $sql->status_aktif
        ];
        return $data;
    }
    public function update($post)
    {
        if (isset($post['default'])) {
            $this->db->where('iddetail_harga', $post['iddetail_terima'])->update('terima_harga', ['status_default' => 0]);
            $default = 1;
        } else {
            $default = 0;
        }
        if (isset($post['aktif'])) {
            $aktif = 1;
        } else {
            if (isset($post['default'])) {
                $aktif = 1;
            } else {
                $aktif = 0;
            }
        }
        $data = [
            'nilai_satuan' => hapus_desimal($post['jumlah']),
            'jual_harga' => hapus_desimal($post['harga']),
            'status_default' => $default,
            'status_aktif' => $aktif
        ];
        return $this->db->where('id_harga', $post['idharga'])->update('terima_harga', $data);
    }









    // Function tidak digunakan
    public function get_penerimaan($id = null, $default = null, $aktif = null, $limit = null)
    {
        $query = "SELECT * FROM barang JOIN barang_satuan ON id_barang=barang_brg_satuan JOIN satuan ON satuan_brg_satuan=id_satuan JOIN permintaan_detail ON id_brg_satuan=barang_detail JOIN terima_detail ON permintaan_detail.id_detail=minta_detail JOIN terima_harga ON terima_detail.id_detail=iddetail_harga WHERE id_barang='$id'";
    }
    public function query_penerimaan($id = null, $default = null, $aktif = null, $limit = null)
    {
        $query = "SELECT * FROM barang JOIN barang_satuan ON id_barang=barang_brg_satuan JOIN satuan ON satuan_brg_satuan=id_satuan JOIN permintaan_detail ON id_brg_satuan=barang_detail
        JOIN penerimaan_detail ON minta_detail=permintaan_detail.id_detail JOIN penerimaan_harga
        ON detail_terima_harga=penerimaan_detail.id_detail JOIN harga_barang ON barang_terima_harga=id_hrg_barang";
        if ($limit == 1) :
            $query .= " JOIN harga_detail ON id_hrg_barang=harga_hrg_detail WHERE id_barang='$id'";
        elseif ($aktif == 1 && $limit == 0) :
            $query .= " JOIN harga_detail ON id_hrg_barang=harga_hrg_detail WHERE id_barang='$id'";
        else :
            $query .= " WHERE id_barang='$id'";
        endif;
        // Tampilkan harga satuan dengan status default
        if ($default == 1) :
            $query .= " AND default_hrg_detail='1'";
        elseif ($default == 0 && $limit == 1) :
            $query .= " AND default_hrg_detail='0'";
        endif;
        if ($limit == 1) :
            // Tampilkan harga satuan terakhir
            $query .= " ORDER BY tanggal_hrg_barang DESC LIMIT 1";
            $query = $this->db->query($query)->row();
        elseif ($aktif == 1 && $limit == 0) :
            // Tampilkan semua data terima diurutkan dari yang terakhir
            $query .= " ORDER BY tanggal_hrg_barang DESC";
            $query = $this->db->query($query)->result();
        else :
            // Tampilkan semua data terima diurutkan dari yang terakhir
            $query .= " ORDER BY id_hrg_barang DESC";
            $query = $this->db->query($query)->result();
        endif;
        return $query;
    }
    public function array_penerimaan($id = null, $default = null, $aktif = null, $limit = null)
    {
        $results = $this->query_penerimaan($id, $default, $aktif, $limit);
        $data = array();
        foreach ($results as $result) {
            $id_terima = $result->terima_detail;
            $id_harga = $result->id_hrg_barang;
            // Tampilkan informasi penerimaan barang
            $row_terima = $this->Mpenerimaan->show($id_terima);
            $rows = array();
            $rows['id_terima'] = $row_terima['id_terima'];
            $rows['nomor'] = $row_terima['nosurat_terima'];
            $rows['id_harga'] = $id_harga;
            $rows['supplier'] = $row_terima['nama_supplier'];
            $rows['tanggal'] = format_indo($row_terima['tanggal_terima']);
            $rows['created_at'] = sort_jam_timestamp($row_terima['created_at']) . ' ' . format_tglin_timestamp($row_terima['created_at']);
            $rows['barang'] = $result->nama_barang;
            $rows['satuan_beli'] = $result->singkatan_satuan;
            $rows['harga_beli'] = rupiah($result->harga_detail);
            $rows['jumlah_beli'] = rupiah($result->jumlah_detail);
            $rows['default'] = $this->query_harga_default($id_harga);
            if ($aktif == 1) :
                // Tampilkan data harga satuan yang aktif
                $result_harga = $this->query_harga_satuan($id_harga, 1);
            else :
                // Tampilkan semua data harga satuan
                $result_harga = $this->query_harga_satuan($id_harga, 0);
            endif;
            $rows_harga = array();
            $row_harga = array();
            foreach ($result_harga as $rh) {
                $rows_harga['id_detail'] = $rh->id_hrg_detail;
                $rows_harga['satuan'] = $rh->nama_satuan;
                $rows_harga['singkatan'] = $rh->singkatan_satuan;
                $rows_harga['default'] = $rh->default_hrg_detail;
                $rows_harga['aktif'] = $rh->aktif_hrg_detail;
                $rows_harga['berat'] = $rh->berat_hrg_detail;
                $rows_harga['harga'] = $rh->jual_hrg_detail;
                $row_harga[] = $rows_harga;
            }
            $rows['data_harga'] = $row_harga;
            // Panggil data satuan yang belum diinputkan
            $result_satuan = $this->db->query("SELECT * FROM barang_satuan JOIN satuan ON satuan_brg_satuan=id_satuan WHERE barang_brg_satuan='$id' AND id_brg_satuan NOT IN (SELECT satuan_hrg_detail FROM harga_detail WHERE harga_hrg_detail='$id_harga')")->result();
            $rows_satuan = array();
            $row_satuan = array();
            foreach ($result_satuan as $rs) {
                $rows_satuan['id_satuan'] = $rs->id_brg_satuan;
                $rows_satuan['nama_satuan'] = $rs->nama_satuan;
                $row_satuan[] = $rows_satuan;
            }
            $rows['data_satuan'] = $row_satuan;
            $data[] = $rows;
        }
        return $data;
    }
    public function query_harga_default($id)
    {
        $query = $this->db->from('harga_detail')->where(['harga_hrg_detail' => $id, 'default_hrg_detail' => 1])->count_all_results();
        if ($query > 0) :
            $query = 1;
        else :
            $query = 0;
        endif;
        return $query;
    }
    public function query_harga_satuan($id = null, $aktif = null)
    {
        $query = "SELECT * FROM harga_detail JOIN barang_satuan ON satuan_hrg_detail=id_brg_satuan JOIN satuan ON satuan_brg_satuan=id_satuan";
        if ($aktif == 1) :
            // Tampilkan data harga satuan yang aktif
            $query .= " WHERE harga_hrg_detail='$id' AND aktif_hrg_detail='$aktif'";
        else :
            // Tampilkan semua data harga satuan
            $query .= " WHERE harga_hrg_detail='$id'";
        endif;
        $query = $this->db->query($query)->result();
        return $query;
    }
    public function add_satuan($id_satuan, $id_harga)
    {
        $data = array(
            'harga_hrg_detail' => $id_harga,
            'satuan_hrg_detail' => $id_satuan,
            'jual_hrg_detail' => 0,
            'default_hrg_detail' => 0,
            'aktif_hrg_detail' => 0
        );
        return $this->db->insert('harga_detail', $data);
    }
    public function show_terima($id = null)
    {
        $query = $this->db->query("SELECT * FROM harga_detail JOIN barang_satuan ON satuan_hrg_detail=id_brg_satuan JOIN barang ON barang_brg_satuan=id_barang JOIN satuan ON satuan_brg_satuan=id_satuan JOIN harga_barang ON harga_hrg_detail=id_hrg_barang
        JOIN penerimaan_harga ON id_hrg_barang=barang_terima_harga
        JOIN penerimaan_detail ON detail_terima_harga=id_detail JOIN penerimaan ON terima_detail=id_terima JOIN penerimaan_supplier ON id_terima=id_terima_supplier
        JOIN permintaan ON id_minta_supplier=id_permintaan
        JOIN supplier ON supplier_permintaan=id_supplier
        WHERE id_hrg_detail='$id' LIMIT 1")->row();
        return $query;
    }
    public function show_satuan($id_hrg_detail = null)
    {
        return $this->db->from('harga_detail')
            ->join('harga_barang', 'harga_hrg_detail=id_hrg_barang')
            ->join('penerimaan_harga', 'id_hrg_barang=barang_terima_harga')
            ->join('penerimaan_detail', 'detail_terima_harga=id_detail')
            ->join('permintaan_detail', 'minta_detail=permintaan_detail.id_detail')
            ->join('barang_satuan', 'barang_detail=id_brg_satuan')
            ->join('satuan', 'satuan_brg_satuan=id_satuan')
            ->where('id_hrg_detail', $id_hrg_detail)
            ->get()->row();
    }
}

/* End of file Mharga.php */
