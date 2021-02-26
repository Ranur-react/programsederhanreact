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
}
