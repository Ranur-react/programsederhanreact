<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gudang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') == "sessDashboard")
            cek_user();
        else
            redirect('logout');
        $this->load->model('master/Mgudang');
    }
    public function index()
    {
        $data = [
            'title' => 'Gudang',
            'small' => 'Menampilkan dan mengelola data gudang',
            'links' => '<li class="active">Gudang</li>',
            'data' => $this->Mgudang->getall()
        ];
        $this->template->dashboard('master/gudang/data', $data);
    }
}
