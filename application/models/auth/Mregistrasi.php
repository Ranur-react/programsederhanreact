<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mregistrasi extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('master/Mpengguna');
    }
    public function signup($post)
    {
        $kode = $this->Mpengguna->kode();
        $data = array(
            'id_user' => $kode,
            'nama_user' => $post['nama'],
            'username' => $post['username'],
            'password' => password_hash($post['password'], PASSWORD_BCRYPT),
            'avatar_user' => make_avatar($post['nama']),
            'jenis_user' => $post['jenis'],
            'status_user' => 0
        );
        $users = $this->db->insert('users', $data);
        if ($post['jenis'] == 1) :
            $data_office = array(
                'id_level' => $this->Mpengguna->kode_office(),
                'user_level' => $kode,
                'role_level' => $post['level']
            );
            $office = $this->db->insert('user_office', $data_office);
            return array($users, $office);
        else :
            $data_gudang = array(
                'id_level' => $this->Mpengguna->kode_gudang(),
                'user_level' => $kode,
                'gudang_level' => $post['gudang'],
                'role_level' => $post['level']
            );
            $gudang = $this->db->insert('user_gudang', $data_gudang);
            return array($users, $gudang);
        endif;
    }
}

/* End of file Mregistrasi.php */
