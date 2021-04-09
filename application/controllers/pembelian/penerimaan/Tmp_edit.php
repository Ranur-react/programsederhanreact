<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tmp_edit extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('master/Mbarang');
        $this->load->model('pembelian/penerimaan/Mtmp_edit');
    }
    public function data()
    {
        $kode = $this->input->get('kode');
        $d['data'] = $this->Mtmp_edit->tampil_data($kode);
        $this->load->view('pembelian/penerimaan/tmp_edit/data', $d);
    }
}

/* End of file Tmp_edit.php */
