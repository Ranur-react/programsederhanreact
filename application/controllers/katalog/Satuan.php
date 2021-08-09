<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Satuan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_logged_in();
        $this->load->model('katalog/Msatuan');
    }
    public function index()
    {
        $data = [
            'title' => 'Satuan',
            'small' => 'Menampilkan dan mengelola data satuan',
            'links' => '<li class="active">Satuan</li>'
        ];
        $this->template->dashboard('katalog/satuan/index', $data);
    }
    public function data()
    {
        $query = $this->Msatuan->fetch_all();
        if ($query == null) {
            $data = (int)0;
        } else {
            foreach ($query as $row) {
                $data[] = [
                    'id' => $row['id_satuan'],
                    'nama' => $row['nama_satuan'],
                    'singkatan' => $row['singkatan_satuan']
                ];
            }
        }
        echo json_encode($data);
    }
    public function create()
    {
        $data = [
            'name' => 'Tambah Satuan',
            'post' => 'satuan/store',
            'class' => 'form_create'
        ];
        $this->template->modal_form('katalog/satuan/create', $data);
    }
    public function store()
    {
        $this->form_validation->set_rules('nama', 'Nama satuan', 'required');
        $this->form_validation->set_rules('singkatan', 'Singkatan', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post(null, TRUE);
            $this->Msatuan->store($post);
            $json = array(
                'status' => '0100',
                'token' => $this->security->get_csrf_hash(),
                'pesan' => 'Data satuan telah disimpan'
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
            'name' => 'Edit Satuan',
            'post' => 'satuan/update',
            'class' => 'form_create',
            'data' => $this->Msatuan->show($kode)
        ];
        $this->template->modal_form('katalog/satuan/edit', $data);
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
                'status' => '0100',
                'token' => $this->security->get_csrf_hash(),
                'pesan' => 'Data satuan telah dirubah'
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
        $action = $this->Msatuan->destroy($kode);
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
    // pencarian satuan berdasarkan nama
    public function satuan_by_nama()
    {
        $filter_nama = $this->input->get('filter_nama');
        $data = $this->Msatuan->satuan_by_nama($filter_nama);
        $json = array();
        foreach ($data as $d) {
            $json[] = array(
                'id' => $d['id_satuan'],
                'nama' => $d['nama_satuan']
            );
        }
        echo json_encode($json);
    }
}
