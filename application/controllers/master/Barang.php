<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') == "sessDashboard")
            cek_user();
        else
            redirect('logout');
        $this->load->model('master/Mbarang');
    }
    public function index()
    {
        $data = [
            'title' => 'Barang',
            'small' => 'Menampilkan dan mengelola data barang',
            'links' => '<li class="active">Barang</li>',
            'data' => $this->Mbarang->fetch_all()
        ];
        $this->template->dashboard('master/barang/data', $data);
    }
    public function create()
    {
        $data = [
            'name' => 'Tambah Barang',
            'post' => 'barang/store',
            'class' => 'form_create',
            'modallg' => 1
        ];
        $this->template->modal_form('master/barang/create', $data);
    }
}

/* End of file Barang.php */
