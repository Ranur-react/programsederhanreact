<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Satuan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') == "sessDashboard")
            cek_user();
        else
            redirect('logout');
        $this->load->model('master/Msatuan');
    }
    public function index()
    {
        $data = [
            'title' => 'Satuan',
            'small' => 'Menampilkan dan mengelola data satuan',
            'links' => '<li class="active">Satuan</li>',
            'data' => $this->Msatuan->getall()
        ];
        $this->template->dashboard('master/satuan/data', $data);
    }
    public function create()
    {
        $data = [
            'name' => 'Tambah Satuan',
            'post' => 'satuan/store',
            'class' => 'form_create'
        ];
        $this->template->modal_form('master/satuan/create', $data);
    }
    public function store()
    {
        $this->form_validation->set_rules('nama', 'Nama satuan', 'required');
        $this->form_validation->set_rules('singkatan', 'Singkatan', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_message('is_unique', errorUnique());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post(null, TRUE);
            $this->Msatuan->store($post);
            $json = array(
                'status' => "0100",
                'pesan' => "Data satuan telah disimpan"
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
            'name' => 'Edit Satuan',
            'post' => 'satuan/update',
            'class' => 'form_create',
            'data' => $this->Msatuan->show($kode)
        ];
        $this->template->modal_form('master/satuan/edit', $data);
    }
    public function update()
    {
        $this->form_validation->set_rules('nama', 'Nama satuan', 'required');
        $this->form_validation->set_rules('singkatan', 'Singkatan', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post(null, TRUE);
            $this->Msatuan->update($post);
            $json = array(
                'status' => "0100",
                'pesan' => "Data satuan telah dirubah"
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
        $action = $this->Msatuan->destroy($kode);
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
