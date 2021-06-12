<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_user();
        $this->load->model('penjualan/pesanan/Mpesanan');
    }
    public function confirm()
    {
        $kode = $this->input->get('kode');
        $data = [
            'name' => 'Konfirmasi Pembayaran',
            'post' => '',
            'class' => 'form_create',
            'data' => $this->Mpesanan->show($kode)
        ];
        $this->template->modal_form('penjualan/pembayaran/confirm', $data);
    }
}

/* End of file Pembayaran.php */
