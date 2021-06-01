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
}

/* End of file Rekening.php */
