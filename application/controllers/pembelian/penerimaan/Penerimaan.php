<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penerimaan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') == "sessDashboard")
            cek_user();
        else
            redirect('logout');
    }
    public function index()
    {
        $data = [
            'title' => 'Penerimaan',
            'small' => 'Menampilkan dan mengelola data penerimaan barang',
            'links' => '<li class="active">Penerimaan</li>'
        ];
        $this->template->dashboard('pembelian/penerimaan/data', $data);
    }
}

/* End of file Penerimaan.php */
