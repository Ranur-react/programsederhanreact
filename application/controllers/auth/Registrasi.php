<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registrasi extends CI_Controller
{
    public function index()
    {
        $data = [
            'title' => 'Registrasi'
        ];
        $this->template->auth('auth/registrasi', $data);
    }
}

/* End of file Registrasi.php */
