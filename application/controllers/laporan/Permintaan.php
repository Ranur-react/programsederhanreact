<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permintaan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_user();
        $this->load->model('laporan/Mpermintaan');
    }
    public function index()
    {
        $data = [
            'title' => 'Laporan Permintaan Barang',
            'menu'  => 'Laporan Permintaan Barang',
            'small' => '',
            'links' => '<li>Laporan</li><li class="active">Permintaan</li>'
        ];
        $this->template->dashboard('laporan/permintaan/index', $data);
    }
    public function cetak()
    {
        $data = [
            'title' => 'Laporan Permintaan Barang',
            'data' => $this->Mpermintaan->fetch_all()
        ];
        $this->template->laporan('laporan/permintaan/all', $data);
    }
    public function modal_perperiode()
    {
        $data = [
            'name' => 'Permintaan Perperiode',
            'post' => 'kategori/store',
            'class' => 'form_report'
        ];
        $this->template->modal_report('laporan/permintaan/modal_perperiode', $data);
    }
}

/* End of file Permintaan.php */
