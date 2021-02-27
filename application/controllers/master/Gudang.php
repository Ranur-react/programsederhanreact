<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gudang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') == "sessDashboard")
            cek_user();
        else
            redirect('logout');
        $this->load->model('master/Mgudang');
    }
    public function index()
    {
        $data = [
            'title' => 'Gudang',
            'small' => 'Menampilkan dan mengelola data gudang',
            'links' => '<li class="active">Gudang</li>',
            'data' => $this->Mgudang->getall()
        ];
        $this->template->dashboard('master/gudang/data', $data);
    }
    public function create()
    {
        $data = [
            'name' => 'Tambah Gudang',
            'post' => 'gudang/store',
            'class' => 'form_create'
        ];
        $this->template->modal_form('master/gudang/create', $data);
    }
    public function store()
    {
        $this->form_validation->set_rules('nama', 'Nama gudang', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_message('is_unique', errorUnique());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post(null, TRUE);
            $this->Mgudang->store($post);
            $json = array(
                'status' => "0100",
                'pesan' => "Data gudang telah disimpan"
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
            'name' => 'Edit Gudang',
            'post' => 'gudang/update',
            'class' => 'form_create',
            'data' => $this->Mgudang->show($kode)
        ];
        $this->template->modal_form('master/gudang/edit', $data);
    }
    public function update()
    {
        $this->form_validation->set_rules('nama', 'Nama gudang', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post(null, TRUE);
            $this->Mgudang->update($post);
            $json = array(
                'status' => "0100",
                'pesan' => "Data gudang telah dirubah"
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
        $action = $this->Mgudang->destroy($kode);
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
