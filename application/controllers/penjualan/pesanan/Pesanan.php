<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_user();
        $this->load->model('master/Mcustomer');
        $this->load->model('penjualan/pesanan/Mpesanan');
    }
    public function index()
    {
        $data = [
            'title' => 'Pesanan',
            'small' => 'Daftar Pesanan',
            'links' => '<li class="active">Pesanan</li>'
        ];
        $this->template->dashboard('penjualan/pesanan/index', $data);
    }
    public function create()
    {
        $data = [
            'title' => 'Pesanan',
            'small' => 'Tambah Pesanan',
            'links' => '<li><a href="' . site_url('pesanan') . '">Pesanan</a></li><li class="active">Tambah</li>',
            'customer' => $this->Mcustomer->get_all()
        ];
        $this->template->dashboard('penjualan/pesanan/create', $data);
    }
    public function store()
    {
        $post = $this->input->post(null, TRUE);
        $this->form_validation->set_rules('customer', 'Customer', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('metode', 'Metode pembayaran', 'required');
        if ($post['metode'] == '2') {
            $this->form_validation->set_rules('bank', 'Bank', 'required');
        }
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $this->Mpesanan->store($post);
            $json = array(
                'status' => '0100',
                'message' => 'Form tambah pesanan barang berhasil dibuat.'
            );
        } else {
            $json['status'] = '0101';
            foreach ($_POST as $key => $value) {
                $json['pesan'][$key] = form_error($key);
            }
        }
        echo json_encode($json);
    }
}

/* End of file Pesanan.php */
