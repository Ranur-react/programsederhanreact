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
			'pageheader' => pageHeader(['Dashboard' => $this->common->global_set('nameapp')]),
			'breadcrumb' => breadcrumb(['active' => 'Dashboard'])
		];
		$this->template->dashboard('layout/content', $data);
	}
}
