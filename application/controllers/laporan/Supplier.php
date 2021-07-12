<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		cek_user();
		$this->load->model('laporan/Msupplier');
	}
	public function index()
	{
		$data = [
			'title' => 'Laporan Supplier',
			'menu'  => 'Laporan Supplier',
			'small' => '',
			'links' => '<li>Laporan</li><li class="active">Supplier</li>'
		];
		$this->template->dashboard('laporan/supplier/index', $data);
	}
	public function cetak()
	{
		$data = [
			'title' => 'Laporan Data Supplier',
			'data' => $this->Msupplier->fetch_all()
		];
		$this->template->laporan('laporan/supplier/all', $data);
	}
}

/* End of file Supplier.php */
