<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengiriman extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_user();
        $this->load->model('laporan/Mpengiriman');
    }
    public function index()
    {
        $data = [
            'title' => 'Laporan Data Pengiriman',
            'menu'  => 'Laporan Data Pengiriman',
            'small' => '',
            'links' => '<li>Laporan</li><li class="active">Pengiriman</li>'
        ];
        $this->template->dashboard('laporan/pengiriman/index', $data);
    }
    public function cetak()
    {
        $data = [
            'title' => 'Laporan Data Pengiriman',
            'data' => $this->Mpengiriman->fetch_all()
        ];
        $this->template->laporan('laporan/pengiriman/all', $data);
    }
    public function terima()
    {
        $data = [
            'title' => 'Laporan Pesanan Diterima',
            'data' => $this->Mpengiriman->get_terima()
        ];
        $this->template->laporan('laporan/pengiriman/terima', $data);
    }
}

/* End of file Pengiriman.php */
