<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permintaan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') == "sessDashboard")
            cek_user();
        else
            redirect('logout');
        $this->load->model('master/Msupplier');
        $this->load->model('pembelian/permintaan/Mpermintaan');
        $this->load->model('pembelian/permintaan/Mtmp_create');
    }
    public function index()
    {
        $data = [
            'title' => 'Permintaan',
            'small' => 'Menampilkan dan mengelola data permintaan barang',
            'links' => '<li class="active">Permintaan</li>'
        ];
        $this->template->dashboard('pembelian/permintaan/data', $data);
    }
    public function create()
    {
        $data = [
            'title' => 'Permintaan',
            'small' => 'Tambah Data Permintaan Barang',
            'links' => '<li class="active">Permintaan</li>',
            'supplier' => $this->Msupplier->getall()
        ];
        $this->template->dashboard('pembelian/permintaan/tambah', $data);
    }
    public function store()
    {
        $post = $this->input->post(null, TRUE);
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('supplier', 'Supplier', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $tmp_data = $this->Mtmp_create->tampil_data();
            if (count($tmp_data) > 0) :
                $kode = $this->Mpermintaan->kode();
                $this->Mpermintaan->store($kode, $post);
                $json = array(
                    'status' => "0100",
                    'kode' => '1'
                );
            else :
                $json = array(
                    'status' => "0100",
                    'count' => count($tmp_data),
                    'message' => 'Anda belum melengkapi isian form permintaan barang.'
                );
            endif;
        } else {
            $json['status'] = "0101";
            foreach ($_POST as $key => $value) {
                $json['pesan'][$key] = form_error($key);
            }
        }
        echo json_encode($json);
    }
}

/* End of file Permintaan.php */
