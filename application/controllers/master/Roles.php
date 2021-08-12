<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Roles extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_logged_in();
        $this->load->model('master/Mroles');
    }
    public function index()
    {
        $data = [
            'title' => 'Hak Akses',
            'links' => '<li class="active">Hak Akses</li>'
        ];
        $this->template->dashboard('master/roles/index', $data);
    }
    public function data()
    {
        $query = $this->Mroles->fetch_all();
        if ($query == null) {
            $data = (int)0;
        } else {
            foreach ($query as $row) {
                $data[] = [
                    'id' => $row['id_role'],
                    'nama' => $row['nama_role'],
                    'status' => in_array($row['id_role'], ['1', '2', '3', '4', '5', '6']) ? 1 : 0
                ];
            }
        }
        echo json_encode($data);
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
                'token' => $this->security->get_csrf_hash(),
                'pesan' => 'Data hak akses telah disimpan'
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
                'token' => $this->security->get_csrf_hash(),
                'pesan' => 'Data hak akses telah dirubah'
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
        $action = $this->Mroles->destroy($kode);
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

/* End of file Roles.php */
