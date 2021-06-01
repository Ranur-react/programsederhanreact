<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekening extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') == "sessDashboard")
            cek_user();
        else
            redirect('logout');
        $this->load->model('master/Mrekening');
    }
    public function index()
    {
        $data = [
            'title' => 'Rekening Bank',
            'small' => 'Menampilkan dan mengelola data rekening bank',
            'links' => '<li class="active">Rekening Bank</li>',
            'data'  => $this->Mrekening->fetch_all()
        ];
        $this->template->dashboard('master/rekening/index', $data);
    }
    public function sync()
    {
        //inisialisasi fungsi curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://localhost:81/integra/api_bank/briapi/kode_bank');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $content = curl_exec($ch);
        curl_close($ch);
        //mengubah data json menjadi data array asosiatif
        $result = json_decode($content, true);
        //looping data menggunakan foreach
        $no = 2;
        foreach ($result['Data'] as $value) {
            $kode =  $value['BankCode'];
            $nama =  $value['Bankname'];
            $check = $this->db->from('bank_code')->where('id_bank', $no)->count_all_results();
            if ($check == 0) :
                $this->db->query("INSERT INTO bank_code VALUES('$no','$kode','$nama')");
            endif;
            $no++;
        }
        redirect('rekening');
    }
    public function create()
    {
        $data = [
            'name' => 'Tambah Rekening Bank',
            'post' => 'rekening/store',
            'class' => 'form_create',
            'bank' => $this->Mrekening->fetch_bank()
        ];
        $this->template->modal_form('master/rekening/create', $data);
    }
    public function store()
    {
        $this->form_validation->set_rules('code', 'Bank', 'required');
        $this->form_validation->set_rules('cabang', 'Kantor Cabang', 'required');
        $this->form_validation->set_rules('norek', 'No Rekening', 'required');
        $this->form_validation->set_rules('holder', 'Atasnama', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post(null, TRUE);
            $this->Mrekening->store($post);
            $json = array(
                'status' => "0100",
                'pesan' => "Data rekening bank telah disimpan"
            );
        } else {
            $json['status'] = "0111";
            foreach ($_POST as $key => $value) {
                $json['pesan'][$key] = form_error($key);
            }
        }
        echo json_encode($json);
    }
}

/* End of file Rekening.php */
