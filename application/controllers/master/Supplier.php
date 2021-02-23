<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status_login') == true)
			cek_user();
		else
			redirect('logout');
		$this->load->model('master/Msupplier');
	}
	public function index()
	{
		$data = [
			'title' => 'Data Supplier',
			'menu'  => 'Data Supplier',
			'small' => '',
			'urls'  => '<li class="active">Data Supplier</li>',
			'data'  => $this->Msupplier->getall()
		];
		$this->template->dashboard('master/supplier/index', $data);
	}
	public function create()
	{

		$this->load->view('master/supplier/create','');
	}
	public function store()
	{
		if ($this->input->is_ajax_request() == TRUE) {
			$this->form_validation->set_rules('idsupplier', 'Id Supplier', 'required|is_unique[karyawan.id_karyawan]');
			$this->form_validation->set_rules('namasupplier', 'Nama Supplier', 'required');
			$this->form_validation->set_rules('alamatsupplier', 'Alamat Supplier', 'required');
			$this->form_validation->set_rules('telpsupplier', 'Telp Supllier', 'required');
			$this->form_validation->set_message('required', '%s tidak boleh kosong.');
			$this->form_validation->set_message('is_unique', '%s sudah digunakan.');
			if ($this->form_validation->run() == TRUE) {
				$params = $this->input->post(null, TRUE);
				$this->Msupplier->store($params);
				$json['status'] = true;
				$this->session->set_flashdata('pesan', sukses('data supplier berhasil di simpan'));
			} else {
				$json['status'] = false;
				$json['pesan']  = $this->form_validation->error_array();
			}
			echo json_encode($json);
		} else {
			exit('data tidak bisa dieksekusi');
		}
	}
	public function edit()
	{
		$kode = $this->input->post('kode');
		$d['data'] = $this->Msupplier->shows($kode);
		$this->load->view('master/datasupplier/edit', $d);
	}
	public function update()
	{
		if ($this->input->is_ajax_request() == TRUE) {
			$this->form_validation->set_rules('idsupplier', 'Id Supplier', 'required');
			$this->form_validation->set_rules('namasupplier', 'Nama Supplier', 'required');
			$this->form_validation->set_rules('alamatsupplier', 'Alamat Supplier', 'required');
			$this->form_validation->set_rules('telpsupplier', 'Telp Supplier', 'required');
			$this->form_validation->set_message('required', '%s tidak boleh kosong.');
			$this->form_validation->set_message('is_unique', '%s sudah digunakan.');
			if ($this->form_validation->run() == TRUE) {
				$params = $this->input->post(null, TRUE);
				$this->Msupplier->update($params);
				$json['status'] = true;
				$this->session->set_flashdata('pesan', sukses('Data supplier berhasil diupdate'));
			} else {
				$json['status'] = false;
				$json['pesan']  = $this->form_validation->error_array();
			}
			echo json_encode($json);
		} else {
			exit('data tidak bisa dieksekusi');
		}
	}
	public function destroy($kode)
	{
		if (!$this->Msupplier->destroy($kode)) {
			$this->session->set_flashdata('pesan', danger('Anda tidak bisa menghapus data supplier'));
		} else {
			$this->session->set_flashdata('pesan', sukses('Anda telah menghapus data supplier'));
		}
		redirect('sup');
	}
}
