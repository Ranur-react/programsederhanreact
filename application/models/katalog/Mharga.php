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
    public function query_penerimaan($id = null, $default = null, $aktif = null, $limit = null)
    {
        $query = "SELECT * FROM barang JOIN barang_satuan ON id_barang=barang_brg_satuan JOIN permintaan_detail ON id_brg_satuan=barang_detail
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
            $query .= " ORDER BY tanggal_hrg_barang DESC";
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
            $rows['id_harga'] = $id_harga;
            $rows['supplier'] = $row_terima['nama_supplier'];
            $rows['tanggal'] = format_indo($row_terima['tanggal_terima']);
            $rows['created_at'] = sort_jam_timestamp($row_terima['created_at']) . ' ' . format_tglin_timestamp($row_terima['created_at']);
            $rows['barang'] = $result->nama_barang;
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
        $query = $this->db->query("SELECT * FROM harga_detail JOIN barang_satuan ON satuan_hrg_detail=id_brg_satuan JOIN barang ON barang_brg_satuan=id_barang JOIN harga_barang ON harga_hrg_detail=id_hrg_barang
        JOIN penerimaan_harga ON id_hrg_barang=barang_terima_harga
        JOIN penerimaan_detail ON detail_terima_harga=id_detail JOIN penerimaan ON terima_detail=id_terima JOIN penerimaan_supplier ON id_terima=id_terima_supplier
        JOIN permintaan ON id_minta_supplier=id_permintaan
        JOIN supplier ON supplier_permintaan=id_supplier
        WHERE id_hrg_detail='$id' LIMIT 1")->row();
        return $query;
    }
    public function show_harga($id = null)
    {
        $data_terima = $this->show_terima($id);
        $query = $this->db->where('id_hrg_detail', $id)->get('harga_detail')->row();
        $data['barang'] = $data_terima->nama_barang;
        $data['id_terima'] = $data_terima->id_terima;
        $data['tanggal'] = format_indo($data_terima->tanggal_terima);
        $data['created_at'] = sort_jam_timestamp($data_terima->created_at) . ' ' . format_tglin_timestamp($data_terima->created_at);
        $data['id_harga'] = $query->harga_hrg_detail;
        $data['id_detail'] = $query->id_hrg_detail;
        $data['harga'] = rupiah($query->jual_hrg_detail);
        $data['default'] = $query->default_hrg_detail;
        $data['aktif'] = $query->aktif_hrg_detail;
        return $data;
    }
    public function update_harga($post)
    {
        if (isset($post['default'])) {
            $this->db->where('harga_hrg_detail', $post['idharga'])->update('harga_detail', ['default_hrg_detail' => 0]);
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
            'jual_hrg_detail' => convert_uang($post['harga']),
            'aktif_hrg_detail' => $aktif,
            'default_hrg_detail' => $default
        ];
        return $this->db->where('id_hrg_detail', $post['iddetail'])->update('harga_detail', $data);
    }
}

/* End of file Mharga.php */
