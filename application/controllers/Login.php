<?php defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('auth/Mlogin');
    }
    public function index()
    {
        $data = [
            'title' => 'Login'
        ];
        $this->template->auth('auth/login', $data);
    }
}

/* End of file Login.php */
