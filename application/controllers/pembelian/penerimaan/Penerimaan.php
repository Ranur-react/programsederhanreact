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
        $this->load->model('master/Mgudang');
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
    public function create()
    {
        $data = [
            'title' => 'Penerimaan',
            'small' => 'Tambah Data Penerimaan Barang',
            'links' => '<li><a href="' . site_url('penerimaan') . '">Penerimaan</a></li><li class="active">Tambah</li>',
            'gudang' => $this->Mgudang->getall()
        ];
        $this->template->dashboard('pembelian/penerimaan/tambah', $data);
    }
}

/* End of file Penerimaan.php */
