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
            $detail = '<a href="javascript:void(0)"><i class="icon-eye8 text-black" data-toggle="tooltip" data-original-title="Detail"></i></a>';
            $no++;
            $rows = array();
            $rows[] = $no . '.';
            $rows[] = $result->nama_barang;
            $rows[] = '';
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
