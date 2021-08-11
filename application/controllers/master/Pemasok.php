<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemasok extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		check_logged_in();
		$this->load->model('master/Mpemasok');
	}
	public function index()
	{
		$data = [
			'title' => 'Pemasok',
			'links' => '<li class="active">Pemasok</li>'
		];
		$this->template->dashboard('master/pemasok/index', $data);
	}
	public function data()
	{
		$query = $this->Mpemasok->fetch_all();
		$data = array();
		$no = $_GET['start'];
		foreach ($query as $value) {
			$no++;
			$row = array();
			$row[] = $no . '.';
			$row[] = $value->nama_supplier;
			$row[] = $value->alamat_supplier;
			$row[] = $value->telp_supplier;
			$row[] = status_span($value->jenis_supplier, 'jenis_pemasok');
			$row[] = '<a href="javascript:void(0)" onclick="edit(\'' . $value->id_supplier . '\')"><i class="icon-pencil7 text-green" title="Edit"></i></a> <a href="javascript:void(0)" onclick="destroy(\'' . $value->id_supplier . '\')"><i class="icon-trash text-red" title="Hapus"></i></a>';
			$data[] = $row;
		}
		$output = array(
			"draw" => $_GET['draw'],
			"recordsTotal" => $this->Mpemasok->count_all(),
			"recordsFiltered" => $this->Mpemasok->count_filtered(),
			"data" => $data,
		);
		echo json_encode($output);
	}
	public function create()
	{
		$data = [
			'name' => 'Tambah Pemasok',
			'post' => 'pemasok/store',
			'class' => 'form_create'
		];
		$this->template->modal_form('master/pemasok/create', $data);
	}
	public function store()
	{
		$this->form_validation->set_rules('jenis', 'Jenis pemasok', 'required');
		$this->form_validation->set_rules('nama', 'Nama pemasok', 'required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'required');
		$this->form_validation->set_rules('telp', 'Telepon', 'required');
		$this->form_validation->set_message('required', errorRequired());
		$this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
		if ($this->form_validation->run() == TRUE) {
			$post = $this->input->post(null, TRUE);
			$this->Mpemasok->store($post);
			$json = array(
				'status' => '0100',
				'token' => $this->security->get_csrf_hash(),
				'pesan' => 'Data pemasok telah disimpan'
			);
		} else {
			$json = array(
				'status' => '0101',
				'token' => $this->security->get_csrf_hash()
			);
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
			'name' => 'Edit Pemasok',
			'post' => 'pemasok/update',
			'class' => 'form_create',
			'data' => $this->Mpemasok->show($kode)
		];
		$this->template->modal_form('master/pemasok/edit', $data);
	}
	public function update()
	{
		$this->form_validation->set_rules('jenis', 'Jenis pemasok', 'required');
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'required');
		$this->form_validation->set_rules('telp', 'Telepon', 'required');
		$this->form_validation->set_message('required', errorRequired());
		$this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
		if ($this->form_validation->run() == TRUE) {
			$post = $this->input->post(null, TRUE);
			$this->Mpemasok->update($post);
			$json = array(
				'status' => '0100',
				'token' => $this->security->get_csrf_hash(),
				'pesan' => 'Data pemasok telah dirubah'
			);
		} else {
			$json = array(
				'status' => '0101',
				'token' => $this->security->get_csrf_hash()
			);
			foreach ($_POST as $key => $value) {
				$json['pesan'][$key] = form_error($key);
			}
		}
		echo json_encode($json);
	}
	public function destroy()
	{
		$kode = $this->input->get('kode', true);
		$action = $this->Mpemasok->destroy($kode);
		if ($action) {
			$json = array(
				'status' => '0100',
				'msg' => successDestroy()
			);
		} else {
			$json = array(
				'status' => '0101',
				'msg' => errorDestroy()
			);
		}
		echo json_encode($json);
	}
}

/* End of file Pemasok.php */
