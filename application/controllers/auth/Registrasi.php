<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registrasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('master/Mpengguna');
        $this->load->model('master/Mgudang');
        $this->load->model('auth/Mregistrasi');
    }
    public function index()
    {
        $data = [
            'title' => 'Registrasi'
        ];
        $this->template->auth('auth/registrasi', $data);
    }
    public function signup_level()
    {
        $jenis = $this->input->get('jenis');
        $result = $this->Mpengguna->get_level($jenis);
        $data = '<option value="">--- Pilih Level ---</option>';
        foreach ($result as $d) {
            $data .= '<option value="' . $d['id_role'] . '">' . $d['nama_role'] . '</option>';
        }
        echo $data;
    }
    public function signup_gudang()
    {
        $jenis = $this->input->get('jenis');
        $query = $this->Mgudang->getall();
        if ($jenis == 2) :
            $data = '<div class="form-group">';
            $data .= '<select name="gudang" id="gudang" class="form-control">';
            $data .= '<option value="">--- Pilih Gudang ---</option>';
            foreach ($query as $d) {
                $data .= '<option value="' . $d['id_gudang'] . '">' . $d['nama_gudang'] . '</option>';
            }
            $data .= '</select>';
            $data .= '</div>';
            echo $data;
        endif;
    }
    public function signup()
    {
        $post = $this->input->post(null, TRUE);
        $this->form_validation->set_rules('nama', 'Nama lengkap', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[users.username]');
        $this->form_validation->set_rules(
            'password',
            'Password',
            'required|min_length[5]',
            ['min_length' => 'Minimal panjang password 5 karakter']
        );
        $this->form_validation->set_rules('jenis', 'Jenis pengguna', 'required');
        $this->form_validation->set_rules('level', 'Level', 'required');
        if ($post['jenis'] == 2) :
            $this->form_validation->set_rules('gudang', 'Gudang', 'required');
        endif;
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_message('is_unique', errorUnique());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $this->Mregistrasi->signup($post);
            $json = array(
                'status' => "0100",
                'message' => sukses('Registrasi akun baru berhasil dilakukan. Mohon tunggu validasi akun dari <b>Administrator</b>.')
            );
        } else {
            $json['status'] = "0111";
            $json['message'] = "";
            foreach ($_POST as $key => $value) {
                $json['pesan'][$key] = form_error($key);
            }
        }
        echo json_encode($json);
    }
}

/* End of file Registrasi.php */
