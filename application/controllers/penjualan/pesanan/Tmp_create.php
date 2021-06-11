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
}

/* End of file Tmp_create.php */
