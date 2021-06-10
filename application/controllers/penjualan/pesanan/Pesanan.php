<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_user();
    }
    public function index()
    {
        $data = [
            'title' => 'Pesanan',
            'small' => 'Daftar Pesanan',
            'links' => '<li class="active">Pesanan</li>'
        ];
        $this->template->dashboard('penjualan/pesanan/index', $data);
    }
}

/* End of file Pesanan.php */
