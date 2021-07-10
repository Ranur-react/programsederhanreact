<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
			cek_user();
	}
	public function index()
	{
		$data = [
			'title' => 'Laporan Barang',
			'menu'  => 'Laporan Barang',
			'small' => '',
			'links' => '<li class="active">Laporan</li>'
		];
		$this->template->dashboard('laporan/barang/index', $data);
	}
}
