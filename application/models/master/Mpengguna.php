<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpengguna extends CI_Model
{
    public function fetch_all()
    {
        return $this->db->get('users')->result_array();
    }
    public function kode()
    {
        $query = $this->db
            ->select('id_user', FALSE)
            ->order_by('id_user', 'DESC')
            ->limit(1)
            ->get('users');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->id_user) + 1;
        } else {
            $kode = 1;
        }
        return $kode;
    }
    public function kode_office()
    {
        $query = $this->db
            ->select('id_level', FALSE)
            ->order_by('id_level', 'DESC')
            ->limit(1)
            ->get('user_office');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->id_level) + 1;
        } else {
            $kode = 1;
        }
        return $kode;
    }
    public function kode_gudang()
    {
        $query = $this->db
            ->select('id_level', FALSE)
            ->order_by('id_level', 'DESC')
            ->limit(1)
            ->get('user_gudang');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->id_level) + 1;
        } else {
            $kode = 1;
        }
        return $kode;
    }
    public function store($post)
    {
        $kode = $this->kode();
        $row = $this->db->where('id_role', $post['role'])->get('role')->row_array();
        $data = array(
            'id_user' => $kode,
            'nama_user' => $post['nama'],
            'username' => $post['username'],
            'password' => password_hash($post['password'], PASSWORD_BCRYPT),
            'avatar_user' => make_avatar($post['nama']),
            'jenis_user' => $row['jenis_role'],
            'status_user' => 1
        );
        $users = $this->db->insert('users', $data);
        if ($row['jenis_role'] == 1) :
            $data_office = array(
                'id_level' => $this->kode_office(),
                'user_level' => $kode,
                'role_level' => $post['role']
            );
            $office = $this->db->insert('user_office', $data_office);
            return array($users, $office);
        else :
            $data_gudang = array(
                'id_level' => $this->kode_gudang(),
                'user_level' => $kode,
                'gudang_level' => $post['gudang'],
                'role_level' => $post['role']
            );
            $gudang = $this->db->insert('user_gudang', $data_gudang);
            return array($users, $gudang);
        endif;
    }
    public function show($kode)
    {
        return $this->db->where('id_user', $kode)->get('users')->row_array();
    }
    public function update($post)
    {
        $kode = $post['kode'];
        if (empty($post['password'])) {
            $data = [
                'nama_user' => $post['nama'],
                'username' => $post['username'],
                'status_user' => $post['status']
            ];
        } else {
            $data = array(
                'nama_user' => $post['nama'],
                'username' => $post['username'],
                'password' => password_hash($post['password'], PASSWORD_BCRYPT),
                'status_user' => $post['status']
            );
        }
        return $this->db->where('id_user', $kode)->update('users', $data);
    }
    public function destroy($kode)
    {
        $data = $this->show($kode);
        if ($data['jenis_user'] == 1) :
            $this->db->where('user_level', $kode)->delete('user_office');
        else :
            $this->db->where('user_level', $kode)->delete('user_gudang');
        endif;
        unlink(pathImage() . $data['avatar_user']);
        $this->db->where('id_user', $kode)->delete('users');
        return true;
    }
}

/* End of file Mpengguna.php */
