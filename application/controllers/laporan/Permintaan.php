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
            'post' => 'laporan/permintaan/cetak_perperiode',
            'class' => 'form_report'
        ];
        $this->template->modal_report('laporan/permintaan/modal_perperiode', $data);
    }
    public function cetak_perperiode()
    {
        $awal = date("Y-m-d", strtotime($this->input->post('awal')));
        $akhir = date("Y-m-d", strtotime($this->input->post('akhir')));
        $data = [
            'title' => 'Laporan Permintaan Barang Perperiode',
            'awal' => $awal,
            'akhir' => $akhir,
            'data' => $this->Mpermintaan->perperiode($awal, $akhir)
        ];
        $this->template->laporan('laporan/permintaan/cetak_perperiode', $data);
    }
    public function modal_perbulan()
    {
        $data = [
            'name' => 'Permintaan Perbulan',
            'post' => 'laporan/permintaan/cetak_perbulan',
            'class' => 'form_report'
        ];
        $this->template->modal_report('laporan/permintaan/modal_perbulan', $data);
    }
    public function cetak_perbulan()
    {
        $bulan = $this->input->post('bulan', true);
        $tahun = $this->input->post('tahun', true);
        $data = [
            'title' => 'Laporan Permintaan Barang Perbulan',
            'bulan' => $bulan,
            'tahun' => $tahun,
            'data' => $this->Mpermintaan->perbulan($bulan, $tahun)
        ];
        $this->template->laporan('laporan/permintaan/cetak_perbulan', $data);
    }
}

/* End of file Permintaan.php */
