<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengguna extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') == "sessDashboard")
            cek_user();
        else
            redirect('logout');
        $this->load->model('master/Mgudang');
        $this->load->model('master/Mpengguna');
    }
    public function index()
    {
        $data = [
            'title' => 'Pengguna',
            'small' => 'Menampilkan dan mengelola data pengguna',
            'links' => '<li class="active">Pengguna</li>',
            'data' => $this->Mpengguna->fetch_all()
        ];
        $this->template->dashboard('master/pengguna/data', $data);
    }
}

/* End of file Pengguna.php */
