<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') == "sessDashboard")
            cek_user();
        else
            redirect('logout');
        $this->load->model('master/Mbarang');
    }
    public function index()
    {
        $data = [
            'title' => 'Barang',
            'small' => 'Menampilkan dan mengelola data barang',
            'links' => '<li class="active">Barang</li>',
            'data' => $this->Mbarang->fetch_all()
        ];
        $this->template->dashboard('master/barang/data', $data);
    }
    public function create()
    {
        $data = [
            'name' => 'Tambah Barang',
            'post' => 'barang/store',
            'class' => 'form_create',
            'modallg' => 1
        ];
        $this->template->modal_form('master/barang/create', $data);
    }
    public function store()
    {
        $post = $this->input->post(null, TRUE);
        $this->form_validation->set_rules('nama', 'Nama barang', 'trim|required');
        $this->form_validation->set_rules('slug', 'Slug', 'trim|required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $this->Mbarang->store($post);
            $json = array(
                'status' => "0100",
                'pesan' => "Data barang telah disimpan"
            );
        } else {
            $json['status'] = "0111";
            foreach ($_POST as $key => $value) {
                $json['pesan'][$key] = form_error($key);
            }
        }
        echo json_encode($json);
    }
    public function edit($kode)
    {
        $data = [
            'title' => 'Barang',
            'small' => 'Mengubah data barang',
            'links' => '<li><a href="' . site_url('barang') . '">Barang</a></li><li class="active">Edit</li>',
            'data' => $this->Mbarang->show($kode)
        ];
        $this->template->dashboard('master/barang/edit', $data);
    }
    public function update()
    {
        $post = $this->input->post(null, TRUE);
        $this->form_validation->set_rules('nama', 'Nama barang', 'trim|required');
        $this->form_validation->set_rules('slug', 'Slug', 'trim|required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $this->Mbarang->update($post);
            $json = array(
                'status' => "0100",
                'pesan' => "Data barang telah dirubah"
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
        $action = $this->Mbarang->destroy($kode);
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

/* End of file Barang.php */
