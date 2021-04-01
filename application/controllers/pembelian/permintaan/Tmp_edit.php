<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tmp_edit extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('master/Mbarang');
        $this->load->model('pembelian/permintaan/Mtmp_edit');
    }
    public function data()
    {
        $kode = $this->input->get('kode');
        $d['data'] = $this->Mtmp_edit->tampil_data($kode);
        $this->load->view('pembelian/permintaan/tmp_edit/data', $d);
    }
    public function create()
    {
        $data = [
            'name' => 'Tambah Barang',
            'post' => 'permintaan/tmp-edit/store',
            'class' => 'form_tmp',
            'backdrop' => 1,
            'barang' => $this->Mbarang->fetch_all(),
            'kode' => $this->input->get('kode')
        ];
        $this->template->modal_form('pembelian/permintaan/tmp_edit/create', $data);
    }
}

/* End of file Tmp_edit.php */
