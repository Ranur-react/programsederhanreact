<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permintaan extends CI_Controller
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
            'title' => 'Permintaan',
            'small' => 'Menampilkan dan mengelola data permintaan barang',
            'links' => '<li class="active">Permintaan</li>'
        ];
        $this->template->dashboard('pembelian/permintaan/data', $data);
    }
}

/* End of file Permintaan.php */
