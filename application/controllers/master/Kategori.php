<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') == "sessDashboard")
            cek_user();
        else
            redirect('logout');
        $this->load->model('master/Mkategori');
    }
    public function index()
    {
        $data = [
            'title' => 'Kategori',
            'small' => 'Menampilkan dan mengelola data kategori',
            'links' => '<li class="active">Kategori</li>',
            'data' => $this->Mkategori->fetch_all()
        ];
        $this->template->dashboard('master/kategori/data', $data);
    }
    public function create()
    {
        $data = [
            'name' => 'Tambah Data',
            'post' => 'kategori/store',
            'class' => 'form_create',
            'multipart' => 1,
            'parent' => $this->Mkategori->fetch_all()
        ];
        $this->template->modal_form('master/kategori/create', $data);
    }
    public function store()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('slug', 'Slug', 'required');
        $this->form_validation->set_rules('parent', 'Sub kategori', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post(null, TRUE);
            if (isset($_FILES['gambar']['name']) && $_FILES['gambar']['name'] != "") {
                // 
            } else {
                $this->Mkategori->store($post, $link = '');
                $json = array(
                    'status' => "0100",
                    'pesan' => "Data kategori telah disimpan"
                );
            }
        } else {
            $json['status'] = "0111";
            foreach ($_POST as $key => $value) {
                $json['pesan'][$key] = form_error($key);
            }
        }
        echo json_encode($json);
    }
}
