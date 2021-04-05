<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tmp_create extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') == "sessDashboard")
            cek_user();
        else
            redirect('logout');
        $this->load->model('pembelian/penerimaan/Mtmp_create');
    }
    public function index()
    {
        $this->load->view('pembelian/penerimaan/tmp_create/data_permintaan');
    }
}

/* End of file Tmp_create.php */
