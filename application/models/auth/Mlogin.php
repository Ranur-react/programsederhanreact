<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mlogin extends CI_Model
{
    private $tabel = 'users';
    public function check_user($username)
    {
        return $this->db->where(['username' => $username, 'status_user' => 1])->get($this->tabel);
    }
    public function check_remember($kode = null)
    {
        return $this->db->where('id_user', $kode)->get($this->tabel)->row_array();
    }
    public function user_online($id = null)
    {
        $data = ['login_user' => 1];
        $this->db->set('last_login', 'NOW()', FALSE);
        return $this->db->where('id_user', $id)->update($this->tabel, $data);
    }
}

/* End of file Mlogin.php */
