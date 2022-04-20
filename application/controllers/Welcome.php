<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		check_logged_in();
	}
	public function index()
	{
		$data = [
			'title' => 'Dashboard',
			'menu'  => 'Dashboard',
			'small' => nameApp(),
			'links' => '<li class="active">Dashboard</li>'
		];
		$this->template->dashboard('layout/content', $data);
	}
}
