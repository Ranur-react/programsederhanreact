<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Roles extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') == "sessDashboard")
            cek_user();
        else
            redirect('logout');
        $this->load->model('master/Mroles');
    }
    public function index()
    {
        $data = [
            'title' => 'Hak Akses',
            'small' => 'Menampilkan dan mengelola data hak akses user',
            'links' => '<li class="active">Hak Akses</li>',
            'data'  => $this->Mroles->fetch_all()
        ];
        $this->template->dashboard('master/roles/index', $data);
    }
    public function create()
    {
        $data = [
            'name' => 'Tambah Hak Akses',
            'post' => 'roles/store',
            'class' => 'form_create'
        ];
        $this->template->modal_form('master/roles/create', $data);
    }
    public function store()
    {
        $this->form_validation->set_rules('nama', 'Hak akses', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post(null, TRUE);
            $this->Mroles->store($post);
            $json = array(
                'status' => '0100',
                'pesan' => 'Data hak akses telah disimpan'
            );
        } else {
            $json['status'] = '0111';
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
            'name' => 'Edit Hak Akses',
            'post' => 'roles/update',
            'class' => 'form_create',
            'data' => $this->Mroles->show($kode)
        ];
        $this->template->modal_form('master/roles/edit', $data);
    }
    public function update()
    {
        $this->form_validation->set_rules('nama', 'Hak akses', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post(null, TRUE);
            $this->Mroles->update($post);
            $json = array(
                'status' => '0100',
                'pesan' => 'Data hak akses telah dirubah'
            );
        } else {
            $json['status'] = '0111';
            foreach ($_POST as $key => $value) {
                $json['pesan'][$key] = form_error($key);
            }
        }
        echo json_encode($json);
    }
    public function destroy()
    {
        $kode = $this->input->get('kode', true);
        $action = $this->Mroles->destroy($kode);
        if ($action) {
            $json = array(
                'status' => '0100',
                'message' => successDestroy()
            );
        } else {
            $json = array(
                'status' => '0101',
                'message' => errorDestroy()
            );
        }
        echo json_encode($json);
    }
}

/* End of file Roles.php */
