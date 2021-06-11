<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tmp_create extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('penjualan/pesanan/Mtmp_create');
    }
    public function index()
    {
        $d['data'] = $this->Mtmp_create->data();
        $this->load->view('penjualan/pesanan/tmp_create/data', $d);
    }
    public function create()
    {
        $data = [
            'name' => 'Tambah Barang',
            'post' => 'pesanan/tmp-create/store',
            'class' => 'form_tmp',
            'backdrop' => 1,
            'barang' => $this->Mtmp_create->getBarangDefault()
        ];
        $this->template->modal_form('penjualan/pesanan/tmp_create/create', $data);
    }
}

/* End of file Tmp_create.php */
