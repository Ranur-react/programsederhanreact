<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gudang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_user();
        $this->load->model('laporan/Mgudang');
    }
    public function index()
    {
        $data = [
            'title' => 'Laporan Data Gudang',
            'menu'  => 'Laporan Data Gudang',
            'small' => '',
            'links' => '<li>Laporan</li><li class="active">Gudang</li>'
        ];
        $this->template->dashboard('laporan/gudang/index', $data);
    }
    public function cetak()
    {
        $data = [
            'title' => 'Laporan Data Gudang',
            'data' => $this->Mgudang->fetch_all()
        ];
        $this->template->laporan('laporan/gudang/all', $data);
    }
}

/* End of file Gudang.php */
