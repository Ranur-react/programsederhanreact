<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengiriman extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_user();
    }
    public function index()
    {
        $data = [
            'title' => 'Pengiriman',
            'small' => 'Daftar Pengiriman',
            'links' => '<li class="active">Pengiriman</li>',
            'sidebar' => 'collapse'
        ];
        $this->template->dashboard('penjualan/pengiriman/index', $data);
    }
}

/* End of file Pengiriman.php */
