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
			'links' => '<li class="active">Laporan</li>'
		];
		$this->template->dashboard('laporan/penjualan/index', $data);
	}

	public function cetak()
	{
		$data['data'] = $this->Mpenjualan->shows();
		$this->load->view('laporan/penjualan/cetak',$data);


	}
}
