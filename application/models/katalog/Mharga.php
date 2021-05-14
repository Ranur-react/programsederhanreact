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
    public function data_terima($id = null, $aktif = null, $limit = null)
    {
        $query = "SELECT * FROM barang JOIN barang_satuan ON id_barang=barang_brg_satuan JOIN permintaan_detail ON id_brg_satuan=barang_detail JOIN penerimaan_detail ON minta_detail=permintaan_detail.id_detail JOIN penerimaan_harga ON detail_terima_harga=penerimaan_detail.id_detail JOIN harga_barang ON barang_terima_harga=id_hrg_barang JOIN harga_detail ON id_hrg_barang=harga_hrg_detail WHERE id_barang='$id'";
        // Tampilkan harga satuan dengan status default
        if ($aktif == 1) :
            $query .= " AND default_hrg_detail='$aktif'";
        endif;
        if ($limit == 1) :
            // Tampilkan harga satuan terakhir
            $query .= " ORDER BY tanggal_hrg_barang DESC LIMIT 1";
            $query = $this->db->query($query)->row();
        else :
            // Tampilkan semua data terima diurutkan dari yang terakhir
            $query .= " ORDER BY tanggal_hrg_barang DESC";
            $query = $this->db->query($query)->result();
        endif;
        return $query;
    }
    public function harga_satuan($id = null, $aktif = null)
    {
        $query = "SELECT * FROM harga_detail JOIN barang_satuan ON satuan_hrg_detail=id_brg_satuan JOIN satuan ON satuan_brg_satuan=id_satuan";
        if ($aktif == 1) :
            $query .= " WHERE harga_hrg_detail='$id' AND aktif_hrg_detail='$aktif'";
        else :
            $query .= " WHERE harga_hrg_detail='$id'";
        endif;
        $query = $this->db->query($query)->result();
        return $query;
    }
    public function data_harga($id = null, $default = null, $aktif = null)
    {
        if ($default == 1) :
            $results = $this->data_terima($id, 1, 0);
        else :
            $results = $this->data_terima($id, 0, 0);
        endif;
        $data = array();
        foreach ($results as $result) {
            $id_terima = $result->terima_detail;
            $id_harga = $result->id_hrg_barang;
            // Tampilkan informasi penerimaan barang
            $row_terima = $this->Mpenerimaan->show($id_terima);
            $rows = array();
            $rows['id_terima'] = $row_terima['id_terima'];
            $rows['id_harga'] = $id_harga;
            $rows['supplier'] = $row_terima['nama_supplier'];
            $rows['tanggal'] = format_indo($row_terima['tanggal_terima']);
            $rows['created_at'] = sort_jam_timestamp($row_terima['created_at']) . ' ' . format_tglin_timestamp($row_terima['created_at']);
            $rows['barang'] = $result->nama_barang;
            $rows['default'] = $result->default_hrg_detail;
            if ($default == 1) :
                // Tampilkan data harga satuan yang aktif
                $result_harga = $this->harga_satuan($id_harga, 1);
            else :
                // Tampilkan semua data harga satuan
                $result_harga = $this->harga_satuan($id_harga, 0);
            endif;
            $rows_harga = array();
            $row_harga = array();
            foreach ($result_harga as $rh) {
                $rows_harga['id_detail'] = $rh->id_hrg_detail;
                $rows_harga['satuan'] = $rh->nama_satuan;
                $rows_harga['singkatan'] = $rh->singkatan_satuan;
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
}

/* End of file Mharga.php */
