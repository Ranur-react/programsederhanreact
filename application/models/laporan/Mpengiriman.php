<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpengiriman extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        cek_user();
        $this->load->model('laporan/Mpenjualan');
    }
    public function fetch_all()
    {
        $query_order = $this->db->from('pengiriman')
            ->join('orders', 'idorder_kirim=id_order')
            ->join('order_alamat', 'id_order=idorder_order_alamat')
            ->join('customer', 'customer_order=id_customer')
            ->order_by('id_order', 'desc')
            ->get()->result();
        $data = array();
        $result = array();
        foreach ($query_order as $qo) {
            $result = [
                'id' => $qo->id_order,
                'invoice' => $qo->invoice_order,
                'tanggal' => $qo->tanggal_order,
                'customer' => $qo->nama_customer,
                'alamat' => $qo->detail_order_alamat . ', ' . $qo->kota_order_alamat
            ];
            $query_produk = $this->Mpenjualan->query_produk($qo->invoice_order);
            $resultProduk = array();
            $dataProduk = array();
            foreach ($query_produk as $rowProduk) {
                $resultProduk = [
                    'produk' => $rowProduk->nama_barang,
                    'singkat' => $rowProduk->singkatan_satuan,
                    'harga' => $rowProduk->harga_order_barang - $rowProduk->diskon_order_barang,
                    'jumlah' => $rowProduk->jumlah_order_barang,
                    'berat' => $rowProduk->berat_hrg_detail . ' ' . $rowProduk->singkatan_satuan,
                    'total' => ($rowProduk->harga_order_barang - $rowProduk->diskon_order_barang) * $rowProduk->jumlah_order_barang
                ];
                $dataProduk[] = $resultProduk;
            }
            $result['produk'] = $dataProduk;
            $data[] = $result;
        }
        return $data;
    }
}

/* End of file Mpengiriman.php */
