<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpesanan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('penjualan/Mpembayaran');
    }
    public function jumlah_data()
    {
        return $this->db->count_all_results('orders');
    }
    public function tampil_data($start, $length)
    {
        $sql = $this->db->from('orders')
            ->join('customer', 'customer_order=id_customer')
            ->join('order_bayar', 'id_order=order_bayar')
            ->join('metode_bayar', 'id_metode=metode_bayar')
            ->order_by('id_order', 'DESC')
            ->limit($length, $start)
            ->get();
        return $sql;
    }
    public function cari_data($search)
    {
        $sql = $this->db->from('orders')
            ->join('customer', 'customer_order=id_customer')
            ->join('order_bayar', 'id_order=order_bayar')
            ->join('metode_bayar', 'id_metode=metode_bayar')
            ->order_by('id_order', 'DESC')
            ->like('invoice_order', $search)
            ->or_like('nama_customer', $search)
            ->or_like("DATE_FORMAT(tanggal_order,'%d-%m-%Y')", $search)
            ->get();
        return $sql;
    }
    public function kode()
    {
        $query = $this->db
            ->select('id_order', FALSE)
            ->order_by('id_order', 'DESC')
            ->limit(1)
            ->get('orders');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->id_order) + 1;
        } else {
            $kode = 1;
        }
        return $kode;
    }
    public function kode_bayar()
    {
        $query = $this->db
            ->select('id_bayar', FALSE)
            ->order_by('id_bayar', 'DESC')
            ->limit(1)
            ->get('order_bayar');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->id_bayar) + 1;
        } else {
            $kode = 1;
        }
        return $kode;
    }
    public function nosurat()
    {
        $query = $this->db->query("SELECT nourut_order FROM orders WHERE DATE_FORMAT(tanggal_order,'%Y-%m') = DATE_FORMAT(NOW(),'%Y-%m') ORDER BY nourut_order DESC LIMIT 1");
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $nourut = intval($data->nourut_order) + 1;
            $array = array(
                'nourut' => $nourut,
                'nosurat' => zerobefore($nourut) . '/INV/BM/' . KonDecRomawi(date('n')) . '/' . format_tahun(date("Y-m-d"))
            );
        } else {
            $nourut = 1;
            $array = array(
                'nourut' => $nourut,
                'nosurat' => zerobefore($nourut) . '/INV/BM/' . KonDecRomawi(date('n')) . '/' . format_tahun(date("Y-m-d"))
            );
        }
        return $array;
    }
    public function store($post)
    {
        $kode = $this->kode();
        $kodebayar = $this->kode_bayar();
        $nosurat = $this->nosurat();
        $data_order = [
            'id_order' => $kode,
            'nourut_order' => $nosurat['nourut'],
            'invoice_order' => $nosurat['nosurat'],
            'customer_order' => $post['customer'],
            'status_order' => $post['metode'] == 1 ? 1 : 0
        ];
        $order = $this->db->insert('orders', $data_order);
        $queryAlamat = $this->db->where('id_alamat', $post['alamat'])->get('customer_alamat')->row();
        $data_alamat = [
            'idorder_order_alamat' => $kode,
            'idalamat_order_alamat' => $queryAlamat->id_alamat,
            'label_order_alamat' => $queryAlamat->label_alamat,
            'penerima_order_alamat' => $queryAlamat->penerima_alamat,
            'phone_order_alamat' => $queryAlamat->phone_alamat,
            'jalan_order_alamat' => $queryAlamat->jalan_alamat,
            'detail_order_alamat' => $queryAlamat->detail_alamat,
            'kota_order_alamat' => $queryAlamat->kota_alamat,
            'kodepos_order_alamat' => $queryAlamat->kodepos_alamat
        ];
        $this->db->insert('order_alamat', $data_alamat);
        $total = $this->db->select('SUM((harga-diskon)*jumlah) AS total')->where('user', id_user())->get('tmp_order')->row();
        $dataBayar = [
            'id_bayar' => $kodebayar,
            'order_bayar' => $kode,
            'metode_bayar' => $post['metode'],
            'total_bayar' => $total->total,
            'cod_bayar' => 0,
            'status_bayar' => 0
        ];
        $this->db->insert('order_bayar', $dataBayar);
        if ($post['metode'] == 2) {
            $dataBank = [
                'idbayar_bayar_bank' => $kodebayar,
                'bankcs_bayar_bank' => $post['bank']
            ];
            $this->db->insert('order_bayar_bank', $dataBank);
        }
        $data_tmp = $this->db->where('user', id_user())->get('tmp_order')->result_array();
        foreach ($data_tmp as $d) {
            $data_detail = [
                'idorder_order_barang' => $kode,
                'idbarang_order_barang' => $d['idhrgdetail'],
                'jumlah_order_barang' => $d['jumlah'],
                'harga_order_barang' => $d['harga'],
                'diskon_order_barang' => $d['diskon']
            ];
            $this->db->insert('order_barang', $data_detail);
        }
        return $order;
    }
    public function show($id = null)
    {
        $result = $this->db->from('orders')
            ->join('customer', 'customer_order=id_customer')
            ->join('order_bayar', 'id_order=order_bayar')
            ->join('metode_bayar', 'id_metode=metode_bayar')
            ->where('id_order', $id)
            ->get()->row();
        $data = [
            'id' => $result->id_order,
            'idbayar' => $result->id_bayar,
            'nomor' => $result->invoice_order,
            'tanggal' => $result->tanggal_order,
            'customer' => $result->nama_customer,
            'metode' => $result->nama_metode,
            'idmetode' => $result->metode_bayar,
            'status' => $result->status_order,
            'status_bayar' => $result->status_bayar,
            'total' => $result->total_bayar
        ];
        return $data;
    }
    public function produk($id = null)
    {
        $sql = "SELECT * FROM order_barang JOIN harga_detail ON idbarang_order_barang=id_hrg_detail JOIN barang_satuan ON satuan_hrg_detail=id_brg_satuan
        JOIN barang ON barang_brg_satuan=id_barang JOIN satuan ON satuan_brg_satuan=id_satuan
        WHERE idorder_order_barang=" . (int)$id;
        $query = $this->db->query($sql)->result();
        $total = 0;
        $rows = array();
        foreach ($query as $value) {
            $total = $total + (($value->harga_order_barang - $value->diskon_order_barang) * $value->jumlah_order_barang);
            $result = [
                'id_hrg_detail' => $value->id_hrg_detail,
                'id_satuan' => $value->satuan_brg_satuan,
                'id_brg_satuan' => $value->id_brg_satuan,
                'produk' => $value->nama_barang,
                'harga' => $value->harga_order_barang - $value->diskon_order_barang,
                'jumlah' => (int)$value->jumlah_order_barang,
                'berat' => (int)$value->berat_hrg_detail,
                'singkat' => $value->singkatan_satuan,
                'total' => ($value->harga_order_barang - $value->diskon_order_barang) * $value->jumlah_order_barang,
                'note' => $value->info_order_barang
            ];
            $rows[] = $result;
        }
        $data['data'] = $rows;
        $data['total'] = $total;
        return $data;
    }
    public function pengiriman($id = null)
    {
        $result = $this->db->where('idorder_order_alamat', $id)->get('order_alamat')->row();
        $data = [
            'penerima' => $result->penerima_order_alamat,
            'telp' => $result->phone_order_alamat,
            'alamat' => $result->detail_order_alamat,
            'kota' => $result->kota_order_alamat,
            'pos' => $result->kodepos_order_alamat
        ];
        return $data;
    }
    public function create_status($idorder = null, $code = null)
    {
        $data = array(
            'status_order' => $code
        );
        return $this->db->where('id_order', $idorder)->update('orders', $data);
    }
    public function confirm($id = null)
    {
        return $this->create_status($id, 2);
    }
    public function batal($id = null)
    {
        $data = $this->show($id);
        $confirm = $this->db->where('idbayar_bukti', $data['idbayar'])->where_in('status_bukti', [0, 1])->get('order_bukti_bayar')->row();
        if ($confirm != null) :
            $this->Mpembayaran->status_confirm($confirm->id_bukti, 2);
        endif;
        $this->Mpembayaran->create_status($data['idbayar'], 3);
        $this->create_status($id, 5);
    }
}

/* End of file Mpesanan.php */
