<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status_login') == "sessDashboard")
			cek_user();
		else
			redirect('logout');
		$this->load->model('master/Msupplier');
	}
	public function index()
	{
		$data = [
			'title' => 'Supplier',
			'small' => 'Menampilkan dan mengelola data supplier',
			'links' => '<li class="active">Supplier</li>',
			'data'  => $this->Msupplier->getall()
		];
		$this->template->dashboard('master/supplier/index', $data);
	}
}
