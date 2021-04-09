<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penerimaan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') == "sessDashboard")
            cek_user();
        else
            redirect('logout');
        $this->load->model('master/Mgudang');
        $this->load->model('pembelian/penerimaan/Mpenerimaan');
        $this->load->model('pembelian/penerimaan/Mtmp_create');
        $this->load->model('pembelian/penerimaan/Mtmp_edit');
    }
    public function index()
    {
        $data = [
            'title' => 'Penerimaan',
            'small' => 'Menampilkan dan mengelola data penerimaan barang',
            'links' => '<li class="active">Penerimaan</li>'
        ];
        $this->template->dashboard('pembelian/penerimaan/data', $data);
    }
    public function create()
    {
        $data = [
            'title' => 'Penerimaan',
            'small' => 'Tambah Data Penerimaan Barang',
            'links' => '<li><a href="' . site_url('penerimaan') . '">Penerimaan</a></li><li class="active">Tambah</li>',
            'gudang' => $this->Mgudang->getall()
        ];
        $this->template->dashboard('pembelian/penerimaan/tambah', $data);
    }
    public function store()
    {
        $post = $this->input->post(null, TRUE);
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('gudang', 'Gudang', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $tmp_data = $this->Mtmp_create->data();
            if (count($tmp_data) > 0) :
                $kode = $this->Mpenerimaan->kode();
                $this->Mpenerimaan->store($kode, $post);
                $json = array(
                    'status' => "0100",
                    'kode' => 1,
                    'message' => 'Form tambah penerimaan barang berhasil dibuat.'
                );
            else :
                $json = array(
                    'status' => "0100",
                    'count' => count($tmp_data),
                    'message' => 'Anda belum melengkapi isian form penerimaan barang.'
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
    public function detail($kode)
    {
        $data = [
            'title' => 'Penerimaan',
            'small' => 'Detail Penerimaan barang',
            'links' => '<li><a href="' . site_url('penerimaan') . '">Penerimaan</a></li><li class="active">Detail</li>',
            'data' => $this->Mpenerimaan->show($kode),
            'barang' => $this->Mtmp_edit->tampil_data($kode)
        ];
        $this->template->dashboard('pembelian/penerimaan/detail', $data);
    }
}

/* End of file Penerimaan.php */
