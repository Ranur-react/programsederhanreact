<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') == "sessDashboard")
            cek_user();
        else
            redirect('logout');
    }
    public function index()
    {
        $data = [
            'title' => 'Customer',
            'small' => 'Daftar Customer',
            'links' => '<li class="active">Customer</li>'
        ];
        $this->template->dashboard('master/customer/data', $data);
    }
}

/* End of file Customer.php */
