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
    public function create()
    {
        $kode = $this->input->get('kode');
        $data = [
            'name' => 'Pelunasan',
            'post' => 'pelunasan/store',
            'class' => 'form_create',
            'data' => $this->Mpenerimaan->show($kode),
            'bayar' => $this->Mpelunasan->total_bayar($kode)
        ];
        $this->template->modal_form('pembelian/pelunasan/create', $data);
    }
    public function store()
    {
        $this->form_validation->set_rules('tanggal', 'Tanggal bayar', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah bayar', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post(null, TRUE);
            $this->Mpelunasan->store($post);
            $json = array(
                'status' => '0100',
                'message' => 'Pelunasan berhasil ditambahkan'
            );
        } else {
            $json = array(
                'status' => '0101',
                'message' => 'Pelunasan gagal ditambahkan'
            );
            foreach ($_POST as $key => $value) {
                $json['pesan'][$key] = form_error($key);
            }
        }
        echo json_encode($json);
    }
}

/* End of file Pelunasan.php */
