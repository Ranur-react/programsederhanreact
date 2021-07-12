<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		cek_user();
		$this->load->model('laporan/Mpenjualan');
	}
	public function index()
	{
		$data = [
			'title' => 'Laporan Penjualan',
			'menu'  => 'Laporan Penjualan',
			'small' => '',
			'links' => '<li>Laporan</li><li class="active">Penjualan</li>'
		];
		$this->template->dashboard('laporan/penjualan/index', $data);
	}
	public function cetak()
	{
		$data = [
			'title' => 'Laporan Data Penjualan',
			'data' => $this->Mpenjualan->fetch_all()
		];
		$this->template->laporan('laporan/penjualan/all', $data);
	}
}

/* End of file Penjualan.php */