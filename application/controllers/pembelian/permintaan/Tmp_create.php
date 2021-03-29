<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tmp_create extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('master/Mbarang');
        $this->load->model('pembelian/permintaan/Mtmp_create');
    }
    public function data()
    {
        $d['data'] = $this->Mtmp_create->tampil_data();
        $this->load->view('pembelian/permintaan/tmp_create/data', $d);
    }
    public function create()
    {
        $data = [
            'name' => 'Tambah Barang',
            'post' => 'permintaan/tmp-create/store',
            'class' => 'form_tmp',
            'backdrop' => 1,
            'barang' => $this->Mbarang->fetch_all()
        ];
        $this->template->modal_form('pembelian/permintaan/tmp_create/create', $data);
    }
}

/* End of file Tmp_create.php */
