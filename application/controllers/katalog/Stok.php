<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stok extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_logged_in();
        $this->load->model('katalog/Mproduk');
        $this->load->model('katalog/Mstok');
    }
    public function index()
    {
        $data = [
            'title' => 'Stok Produk',
            'links' => '<li class="active">Stok Produk</li>'
        ];
        $this->template->dashboard('katalog/stok/index', $data);
    }
    public function data()
    {
        $results = $this->Mproduk->get_all();
        $data = array();
        $no = $_GET['start'];
        foreach ($results as $result) {
            $idproduk = $result->id_barang;
            // Menampilkan data satuan per produk
            $data_satuan = $this->Mproduk->get_satuan($idproduk);
            $satuan_all = '';
            foreach ($data_satuan as $data_satuan) {
                $satuan_all .= $data_satuan['nama_satuan'] . '<br>';
            }
            // Menampilkan total stok produk dari semua penerimaan
            $data_stok = $this->Mstok->getDatastok($idproduk);
            $stok_all = '';
            if ($data_stok['data']['totalStok'] > 0) :
                foreach ($data_stok['data']['dataSatuan'] as $data_stok) {
                    if ($data_stok['stokAkhir'] > 0) :
                        $stok_all .= $data_stok['stokAkhirText'] . '<br>';
                    endif;
                }
            else :
                $stok_all .= COUNT_EMPTY;
            endif;
            // $detail = '<a href="javascript:void(0)" class="detail" id="' . $result->id_barang . '"><i class="icon-eye8 text-black" title="Detail"></i></a>';
            $rekap = '<a href="' . site_url('stok-produk/rekap/' . $result->id_barang) . '"><i class="icon-clipboard6 text-purple" title="Rekap Stok"></i></a>';
            $no++;
            $rows = array();
            $rows[] = $no . '.';
            $rows[] = $result->nama_barang;
            $rows[] = rtrim($satuan_all, '<br>');
            $rows[] = rtrim($stok_all, '<br>');
            $rows[] = $rekap;
            $data[] = $rows;
        }
        $json = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Mproduk->count_all(),
            "recordsFiltered" => $this->Mproduk->count_filtered(),
            "data" => $data,
        );
        echo json_encode($json);
    }
    public function rekap($idproduk)
    {
        $data = [
            'title' => 'Stok Produk',
            'small' => 'Rekap stok produk dari penerimaan',
            'links' => '<li>Stok Produk</li><li class="active">Rekap</li>',
            'sidebar' => 'collapse',
            'data' => $this->Mstok->getStokterima($idproduk)
        ];
        $this->template->dashboard('katalog/stok/rekap', $data);
    }



    // Function tidak digunakan
    public function detail()
    {
        $id = $this->input->get('id');
        $data = $this->Mstok->getDatastok($id);
        echo json_encode($data);
    }
    public function data_terima()
    {
        $kode = $this->input->get('kode');
        $d['data'] = $this->Mstok->data_penerimaan($kode);
        $this->load->view('katalog/stok/data', $d);
    }
}

/* End of file Stok.php */
