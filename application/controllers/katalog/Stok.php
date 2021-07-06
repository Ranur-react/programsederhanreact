<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stok extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_user();
        $this->load->model('master/Mbarang');
    }
    public function index()
    {
        $data = [
            'title' => 'Stok Barang',
            'small' => 'Menampilkan data stok barang',
            'links' => '<li class="active">Stok Barang</li>'
        ];
        $this->template->dashboard('katalog/stok/index', $data);
    }
    public function data()
    {
        $results = $this->Mbarang->get_all();
        $data = array();
        $no = $_GET['start'];
        foreach ($results as $result) {
            $kode = $result->id_barang;
            // Menampilkan data satuan per barang
            $data_satuan = $this->Mbarang->barang_satuan($kode);
            $row_satuan = '';
            foreach ($data_satuan as $data_satuan) {
                $row_satuan .= $data_satuan['nama_satuan'] . '<br>';
            }

            $detail = '<a href="javascript:void(0)"><i class="icon-eye8 text-black" data-toggle="tooltip" data-original-title="Detail"></i></a>';
            $no++;
            $rows = array();
            $rows[] = $no . '.';
            $rows[] = $result->nama_barang;
            $rows[] = rtrim($row_satuan, '<br>');
            $rows[] = '';
            $rows[] = status_span($result->status_barang, 'aktif');
            $rows[] = $detail;
            $data[] = $rows;
        }
        $json = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Mbarang->count_all(),
            "recordsFiltered" => $this->Mbarang->count_filtered(),
            "data" => $data,
        );
        echo json_encode($json);
    }
}

/* End of file Stok.php */
