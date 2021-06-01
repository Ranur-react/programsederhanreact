<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekening extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') == "sessDashboard")
            cek_user();
        else
            redirect('logout');
        $this->load->model('master/Mrekening');
    }
    public function index()
    {
        $data = [
            'title' => 'Rekening Bank',
            'small' => 'Menampilkan dan mengelola data rekening bank',
            'links' => '<li class="active">Rekening Bank</li>',
            'data'  => $this->Mrekening->fetch_all()
        ];
        $this->template->dashboard('master/rekening/index', $data);
    }
}

/* End of file Rekening.php */
