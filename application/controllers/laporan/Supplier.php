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
			'links' => '<li class="active">Laporan</li>'
		];
		$this->template->dashboard('laporan/supplier/index', $data);
	}

	public function cetak()
	{
		$data['data'] = $this->Msupplier->shows();
		$this->load->view('laporan/supplier/cetak',$data);


	}
}
