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
	public function create()
	{
		$data = [
			'name' => 'Tambah Supplier',
			'post' => 'master/supplier/store',
			'class' => 'form_create'
		];
		$this->template->modal_form('master/supplier/create', $data);
	}
	public function store()
	{
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'required');
		$this->form_validation->set_rules('telp', 'Telepon', 'required');
		$this->form_validation->set_message('required', errorRequired());
		$this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
		if ($this->form_validation->run() == TRUE) {
			$post = $this->input->post(null, TRUE);
			$this->Msupplier->store($post);
			$json = array(
				'status' => "0100",
				'pesan' => "Data supplier telah disimpan"
			);
		} else {
			$json['status'] = "0111";
			foreach ($_POST as $key => $value) {
				$json['pesan'][$key] = form_error($key);
			}
		}
		echo json_encode($json);
	}
	public function edit()
	{
		$kode = $this->input->get('kode');
		$data = [
			'name' => 'Edit Supplier',
			'post' => 'master/supplier/update',
			'class' => 'form_create',
			'data' => $this->Msupplier->show($kode)
		];
		$this->template->modal_form('master/supplier/edit', $data);
	}
	public function update()
	{
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'required');
		$this->form_validation->set_rules('telp', 'Telepon', 'required');
		$this->form_validation->set_message('required', errorRequired());
		$this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
		if ($this->form_validation->run() == TRUE) {
			$post = $this->input->post(null, TRUE);
			$this->Msupplier->update($post);
			$json = array(
				'status' => "0100",
				'pesan' => "Data supplier telah dirubah"
			);
		} else {
			$json['status'] = "0111";
			foreach ($_POST as $key => $value) {
				$json['pesan'][$key] = form_error($key);
			}
		}
		echo json_encode($json);
	}
	public function destroy()
	{
		$kode = $this->input->get('kode', true);
		$action = $this->Msupplier->destroy($kode);
		if ($action) {
			$json = array(
				'status' => "0100",
				"message" => successDestroy()
			);
		} else {
			$json = array(
				'status' => "0101",
				"message" => errorDestroy()
			);
		}
		echo json_encode($json);
	}
}
