<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mtmp_permintaan extends CI_Model
{
    var $tabel = 'permintaan';
    var $id = 'id_permintaan';
    var $column_order = array(null, 'nosurat_permintaan', 'tanggal_permintaan');
    var $column_search = array('nosurat_permintaan');
    var $order = array('id_permintaan' => 'DESC');


    public function __construct()
    {
        parent::__construct();
        $this->load->model('pembelian/permintaan/Mpermintaan');
    }
    private function _get_data_query()
    {
        $this->db->where_in('status_permintaan', array(1, 2));
        $this->db->from($this->tabel)
            ->join('users', 'user_permintaan=id_user');
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
    function fetch_all()
    {
        $this->_get_data_query();
        if ($_GET['length'] != -1)
            $this->db->limit($_GET['length'], $_GET['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtered()
    {
        $this->_get_data_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_all()
    {
        $this->db->from($this->tabel);
        return $this->db->count_all_results();
    }
    public function get_data($id = null)
    {
        // Periksa data tmp sesuai session user
        $check_data = $this->db->from('tmp_penerimaan')->where('user', id_user())->count_all_results();
        // Jika data tmp besar dari nol
        if ($check_data > 0) :
            // Periksa data tmp berdasarkan kode yang kirim dan session user
            $user_sess = $this->db->from('tmp_penerimaan')->where(['permintaan' => $id, 'user', id_user()])->count_all_results();
            if ($user_sess > 0) :
                // Jika data tmp ada tampilkan data permintaan
                $data = [
                    'status' => '0100',
                    'msg' => 'Data permintaan berhasil dipilih.',
                    'data' => $this->Mpermintaan->show($id)
                ];
            else :
                // Munculkan pesan bahwa data permintaan tidak sama dengan data yang ada
                $poproduk = $this->db->where('id_permintaan', $id)->get('permintaan')->row();
                $data = [
                    'status' => '0101',
                    'msg' => 'Selesaikan terlebih dahulu data permintaan dengan Nomor: ' . $poproduk->nosurat_permintaan
                ];
            endif;
        else :
            // Periksa data tmp berdasarkan kode dan session user lainnya
            $user_other = $this->db->from('tmp_penerimaan')->where('permintaan', $id)->where_not_in('user', id_user())->count_all_results();
            // Jika data tmp kosong tampilkan data permintaan
            if ($user_other > 0) :
                // Munculkan pesan bahwa data permintaan sedang diinputkan oleh user lainnya
                $data = [
                    'status' => '0101',
                    'msg' => 'Data permintaan sedang diinputkan oleh user lainnya.'
                ];
            else :
                $data = [
                    'status' => '0100',
                    'msg' => 'Data permintaan berhasil dipilih.',
                    'data' => $this->Mpermintaan->show($id)
                ];
            endif;
        endif;
        return $data;
    }
    public function show($id = null)
    {
        return $this->db->from('permintaan_detail')
            ->join('barang_satuan', 'barang_detail=id_brg_satuan')
            ->join('barang', 'barang_brg_satuan=id_barang')
            ->join('satuan', 'satuan_brg_satuan=id_satuan')
            ->where('id_detail', $id)
            ->get()->row_array();
    }
}

/* End of file Mtmp_permintaan.php */
