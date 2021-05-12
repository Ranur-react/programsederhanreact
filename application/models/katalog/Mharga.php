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
    public function terima_terakhir_aktif($id = null, $limit = null)
    {
        $query = "SELECT * FROM barang JOIN barang_satuan ON id_barang=barang_brg_satuan JOIN permintaan_detail ON id_brg_satuan=barang_detail JOIN penerimaan_detail ON minta_detail=permintaan_detail.id_detail JOIN penerimaan_harga ON detail_terima_harga=penerimaan_detail.id_detail JOIN harga_barang ON barang_terima_harga=id_hrg_barang JOIN harga_detail ON id_hrg_barang=harga_hrg_detail WHERE id_barang='$id' AND default_hrg_detail='1'";
        if ($limit == 1) :
            $query .= " ORDER BY tanggal_hrg_barang,created_at DESC LIMIT 1";
            $query = $this->db->query($query)->row();
        else :
            $query .= " ORDER BY tanggal_hrg_barang,created_at DESC";
            $query = $this->db->query($query)->result();
        endif;
        return $query;
    }
    public function harga_terakhir_aktif($id = null)
    {
        return $this->db->from('harga_detail')
            ->join('barang_satuan', 'satuan_hrg_detail=id_brg_satuan')
            ->join('satuan', 'satuan_brg_satuan=id_satuan')
            ->where(['harga_hrg_detail' => $id, 'aktif_hrg_detail' => 1])
            ->get()->result();
    }
    public function data_harga_aktif($id = null)
    {
        $results = $this->terima_terakhir_aktif($id, 0);
        $data = array();
        foreach ($results as $result) {
            $id_terima = $result->terima_detail;
            $id_harga = $result->id_hrg_barang;
            // Tampilkan informasi penerimaan barang
            $row_terima = $this->Mpenerimaan->show($id_terima);
            $rows = array();
            $rows['barang'] = $result->nama_barang;
            $rows['id_terima'] = $row_terima['id_terima'];
            $rows['supplier'] = $row_terima['nama_supplier'];
            $rows['tanggal'] = $row_terima['tanggal_terima'];
            $rows['created_at'] = $row_terima['created_at'];
            // Tampilkan data harga satuan yang aktif
            $result_harga = $this->harga_terakhir_aktif($id_harga);
            $rows_harga = array();
            $row_harga = array();
            foreach ($result_harga as $rh) {
                $rows_harga['satuan'] = $rh->nama_satuan;
                $rows_harga['singkatan'] = $rh->singkatan_satuan;
                $rows_harga['harga'] = $rh->jual_hrg_detail;
                $row_harga[] = $rows_harga;
            }
            $rows['data_harga'] = $row_harga;
            $data[] = $rows;
        }
        return $data;
    }
}

/* End of file Mharga.php */
