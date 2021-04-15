<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tmp_edit extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pembelian/penerimaan/Mtmp_edit');
    }
    public function data()
    {
        $kode = $this->input->get('kode');
        $d['data'] = $this->Mtmp_edit->tampil_data($kode);
        $this->load->view('pembelian/penerimaan/tmp_edit/data', $d);
    }
    public function edit()
    {
        $kode = $this->input->get('kode');
        $data = [
            'name' => 'Edit Barang',
            'post' => 'penerimaan/tmp-edit/update',
            'class' => 'form_tmp',
            'backdrop' => 1,
            'data' => $this->Mtmp_edit->show($kode)
        ];
        $this->template->modal_form('pembelian/penerimaan/tmp_edit/edit', $data);
    }
}

/* End of file Tmp_edit.php */
