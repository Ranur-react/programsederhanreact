<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registrasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('master/Mpengguna');
        $this->load->model('master/Mgudang');
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
}

/* End of file Registrasi.php */
