<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mlogin extends CI_Model
{
    private $tabel = 'users';
    public function check_user($username)
    {
        return $this->db->where(['username' => $username, 'status_user' => 1])->get($this->tabel);
    }
    public function validate($post)
    {
        $username = $post['username'];
        $password = $post['password'];
        return $this->db->where(['username' => $username, 'pas_real' => $password, 'status_user' => 1])->get($this->tabel)->row_array();
    }
}

/* End of file Mlogin.php */
