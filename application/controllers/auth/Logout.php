<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logout extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('auth/Mlogin');
    }
    public function index()
    {
        $this->Mlogin->user_logout(id_user());
        delete_cookie('remember_bm_dashboard');
        $this->session->unset_userdata('status_login', FALSE);
        $this->session->unset_userdata('kode');
        redirect('login');
    }
}

/* End of file Logout.php */
