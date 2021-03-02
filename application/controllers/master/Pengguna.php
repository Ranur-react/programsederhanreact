<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengguna extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') == "sessDashboard")
            cek_user();
        else
            redirect('logout');
        $this->load->model('master/Mgudang');
        $this->load->model('master/Mpengguna');
    }
    public function index()
    {
        $data = [
            'title' => 'Pengguna',
            'small' => 'Menampilkan dan mengelola data pengguna',
            'links' => '<li class="active">Pengguna</li>',
            'data' => $this->Mpengguna->fetch_all()
        ];
        $this->template->dashboard('master/pengguna/data', $data);
    }
    public function create()
    {
        $data = [
            'name' => 'Tambah Pengguna',
            'post' => 'pengguna/store',
            'class' => 'form_create'
        ];
        $this->template->modal_form('master/pengguna/create', $data);
    }
    public function get_level()
    {
        $jenis = $this->input->get('jenis');
        $result = $this->Mpengguna->get_level($jenis);
        $data = '<option value="">Pilih</option>';
        foreach ($result as $d) {
            $data .= '<option value="' . $d['id_role'] . '">' . $d['nama_role'] . '</option>';
        }
        echo $data;
    }
    public function get_gudang()
    {
        $d['jenis'] = $this->input->get('jenis');
        $d['data'] = $this->Mgudang->getall();
        $this->load->view('master/pengguna/get_gudang', $d);
    }
}

/* End of file Pengguna.php */
