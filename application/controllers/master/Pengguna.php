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
    public function store()
    {
        $post = $this->input->post(null, TRUE);
        $this->form_validation->set_rules('nama', 'Nama lengkap', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('jenis', 'Jenis pengguna', 'required');
        $this->form_validation->set_rules('level', 'Level', 'required');
        if ($post['jenis'] == 2) :
            $this->form_validation->set_rules('gudang', 'Gudang', 'required');
        endif;
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $this->Mpengguna->store($post);
            $json = array(
                'status' => "0100",
                'pesan' => "Data pengguna telah disimpan"
            );
        } else {
            $json['status'] = "0111";
            foreach ($_POST as $key => $value) {
                $json['pesan'][$key] = form_error($key);
            }
        }
        echo json_encode($json);
    }
    public function edit()
    {
        $kode = $this->input->get('kode');
        $data = [
            'name' => 'Edit Pengguna',
            'post' => 'pengguna/update',
            'class' => 'form_create',
            'data' => $this->Mpengguna->show($kode)
        ];
        $this->template->modal_form('master/pengguna/edit', $data);
    }
}

/* End of file Pengguna.php */
