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
    public function modal_perperiode()
    {
        $data = [
            'name' => 'Penerimaan Perperiode',
            'post' => 'laporan/penerimaan/cetak_perperiode',
            'class' => 'form_report'
        ];
        $this->template->modal_report('laporan/penerimaan/modal_perperiode', $data);
    }
    public function cetak_perperiode()
    {
        $awal = date("Y-m-d", strtotime($this->input->post('awal')));
        $akhir = date("Y-m-d", strtotime($this->input->post('akhir')));
        $data = [
            'title' => 'Laporan Penerimaan Barang Perperiode',
            'awal' => $awal,
            'akhir' => $akhir,
            'data' => $this->Mpenerimaan->perperiode($awal, $akhir)
        ];
        $this->template->laporan('laporan/penerimaan/cetak_perperiode', $data);
    }
}

/* End of file Penerimaan.php */
