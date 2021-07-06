<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stok extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_user();
    }
    public function index()
    {
        $data = [
            'title' => 'Stok Barang',
            'small' => 'Menampilkan data stok barang',
            'links' => '<li class="active">Stok Barang</li>'
        ];
        $this->template->dashboard('katalog/stok/index', $data);
    }
}

/* End of file Stok.php */
