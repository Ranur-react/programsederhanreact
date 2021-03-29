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
        $this->load->model('master/Msupplier');
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
    public function create()
    {
        $data = [
            'title' => 'Permintaan',
            'small' => 'Tambah Data Permintaan Barang',
            'links' => '<li class="active">Permintaan</li>',
            'supplier' => $this->Msupplier->getall()
        ];
        $this->template->dashboard('pembelian/permintaan/tambah', $data);
    }
}

/* End of file Permintaan.php */
