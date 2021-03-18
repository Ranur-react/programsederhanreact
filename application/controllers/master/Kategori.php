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
}
