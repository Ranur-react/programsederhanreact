<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('MKaryawan');
	}

	public function Simpan()
	{
		$data = json_decode(trim(file_get_contents('php://input')), true);
		$this->MKaryawan->insert($data);
	}

	public function GetAll()
	{
		$data = $this->MKaryawan->Show();
		echo json_encode($data);
	}
}