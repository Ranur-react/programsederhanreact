<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Harga extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') == "sessDashboard")
            cek_user();
        else
            redirect('logout');
        $this->load->model('katalog/Mharga');
    }
    public function index()
    {
        $data = [
            'title' => 'Harga Jual',
            'small' => 'Menampilkan dan mengelola data harga jual barang',
            'links' => '<li class="active">Harga Jual</li>'
        ];
        $this->template->dashboard('katalog/harga/index', $data);
    }
    public function data()
    {
        $list = $this->Mharga->fetch_all();
        $data = array();
        $no = $_GET['start'];
        foreach ($list as $value) {
            $detail = '<a href="#"><i class="icon-eye8 text-black" title="Detail"></i></a>';
            $histori = '<a href="#"><i class="icon-history text-green" title="Riwayat Harga"></i></a>';

            $no++;
            $row = array();
            $row[] = $no . '.';
            $row[] = $value->nama_barang;
            $row[] = '';
            $row[] = '';
            $row[] = status_span($value->status_barang, 'aktif');
            $row[] = $detail . '&nbsp;' . $histori;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Mharga->count_all(),
            "recordsFiltered" => $this->Mharga->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }
}

/* End of file Harga.php */
