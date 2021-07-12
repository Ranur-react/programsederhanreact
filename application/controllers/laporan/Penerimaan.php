<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penerimaan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_user();
        $this->load->model('laporan/Mpenerimaan');
    }
    public function index()
    {
        $data = [
            'title' => 'Laporan Penerimaan Barang',
            'menu'  => 'Laporan Penerimaan Barang',
            'small' => '',
            'links' => '<li>Laporan</li><li class="active">Penerimaan</li>'
        ];
        $this->template->dashboard('laporan/penerimaan/index', $data);
    }
    public function cetak()
    {
        $data = [
            'title' => 'Laporan Penerimaan Barang',
            'data' => $this->Mpenerimaan->fetch_all()
        ];
        $this->template->laporan('laporan/penerimaan/all', $data);
    }
}

/* End of file Penerimaan.php */
