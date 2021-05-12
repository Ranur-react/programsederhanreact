<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Harga extends CI_Controller
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
            'title' => 'Harga Jual',
            'small' => 'Menampilkan dan mengelola data harga jual barang',
            'links' => '<li class="active">Harga Jual</li>'
        ];
        $this->template->dashboard('katalog/harga/index', $data);
    }
}

/* End of file Harga.php */
