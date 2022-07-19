<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mahasiswa extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('MMahasiswa');
	}
	public function index()
	{
		echo "hallo mhs";
	}
	public function Post()
	{
		$data = json_decode(trim(file_get_contents('php://input')), true);
		echo var_dump($data);
		echo $data['address'];
	}

	public function Simpan()
	{
		$data = json_decode(trim(file_get_contents('php://input')), true);
		$this->MMahasiswa->insert($data);
	}
	public function Edit()
	{
		$data = json_decode(trim(file_get_contents('php://input')), true);
		$this->MMahasiswa->update($data);
	}
	public function Hapus($key)
	{
		$this->MMahasiswa->delete($key);
	}
	public function GetAll()
	{
		$data = $this->MMahasiswa->Show();
		echo json_encode($data);
	}
	public function Get($param)
	{
		$data = $this->MMahasiswa->ShowFilterId($param);
		echo json_encode($data);
	}
}