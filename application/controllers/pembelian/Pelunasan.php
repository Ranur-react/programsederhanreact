<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pelunasan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') == "sessDashboard")
            cek_user();
        else
            redirect('logout');
        $this->load->model('pembelian/penerimaan/Mpenerimaan');
        $this->load->model('pembelian/Mpelunasan');
    }
    public function detail($kode)
    {
        $data = [
            'title' => 'Pelunasan',
            'small' => 'Kelola pelunasan penerimaan',
            'links' => '<li class="active">Pelunasan</li>',
            'data' => $this->Mpenerimaan->show($kode)
        ];
        $this->template->dashboard('pembelian/pelunasan/detail', $data);
    }
    public function data()
    {
        $idterima = $this->input->get('idterima');
        $d['data'] = $this->Mpenerimaan->show($idterima);
        $d['result'] = $this->Mpelunasan->show($idterima);
        $d['bayar'] = $this->Mpelunasan->total_bayar($idterima);
        $this->load->view('pembelian/pelunasan/data', $d);
    }
}

/* End of file Pelunasan.php */
