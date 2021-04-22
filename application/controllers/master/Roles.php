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
}

/* End of file Roles.php */
