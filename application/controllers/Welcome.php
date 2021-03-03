<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status_login') == "sessDashboard")
			cek_user();
		else
			redirect('logout');
	}
	public function index()
	{
		$data = [
			'title' => 'Dashboard | ' . nameApp(),
			'menu'  => 'Dashboard',
			'small' => nameApp(),
			'links' => '<li class="active">Dashboard</li>'
		];
		$this->template->dashboard('layout/content', $data);
	}
}
