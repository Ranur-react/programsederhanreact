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
		$this->load->view('welcome_message');
	}
}
