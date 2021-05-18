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
    }
    public function detail($kode)
    {
        $data = [
            'title' => 'Pelunasan',
            'small' => 'Kelola pelunasan penerimaan',
            'links' => '<li class="active">Pelunasan</li>'
        ];
        $this->template->dashboard('pembelian/pelunasan/detail', $data);
    }
}

/* End of file Pelunasan.php */
