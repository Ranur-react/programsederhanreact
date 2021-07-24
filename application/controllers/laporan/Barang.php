<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		cek_user();
		$this->load->model('laporan/Mbarang');
	}
	public function index()
	{
		$data = [
			'title' => 'Laporan Data Barang',
			'menu'  => 'Laporan Data Barang',
			'small' => '',
			'links' => '<li>Laporan</li><li class="active">Barang</li>'
		];
		$this->template->dashboard('laporan/barang/index', $data);
	}
	public function cetak()
	{
		$data = [
			'title' => 'Laporan Data Barang',
			'data' => $this->Mbarang->fetch_all()
		];
		$this->template->laporan('laporan/barang/all', $data);
	}
	public function stok()
	{
		$data = [
			'title' => 'Laporan Stok Barang',
			'data' => $this->Mbarang->fetch_all()
		];
		$this->template->laporan('laporan/barang/stok', $data);
	}
}

/* End of file Barang.php */