<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// cek session user dan remember me
if (!function_exists('cek_user')) {
    function cek_user()
    {
        $CI = &get_instance();
        if ($CI->session->userdata('status_login') != 'sessDashboard') :
            if (remember_token() != '0100') :
                redirect('logout');
            endif;
        endif;
    }
}

if (!function_exists('remember_token')) {
    function remember_token()
    {
        $CI = &get_instance();
        $CI->load->model('auth/Mlogin');
        if (get_cookie('remember_bm_dashboard')) :
            $id_user = decrypt_url(get_cookie('remember_bm_dashboard'));
            $data = $CI->Mlogin->check_remember($id_user);
            if ($data != null) :
                $CI->session->set_userdata('masuk', TRUE);
                $CI->session->set_userdata('status_login', 'sessDashboard');
                $CI->session->set_userdata('kode', $data['id_user']);
                return '0100';
            else :
                return '0101';
            endif;
        else :
            return '0101';
        endif;
    }
}

// session kode user
if (!function_exists('id_user')) {
    function id_user()
    {
        $CI = &get_instance();
        return $CI->session->userdata('kode');
    }
}

// nama user yang login
if (!function_exists('user_profile')) {
    function user_profile()
    {
        $CI = &get_instance();
        $row = $CI->db->where('id_user', id_user())->get('users')->row_array();
        return $row['nama_user'];
    }
}

// avatar user
if (!function_exists('user_photo')) {
    function user_photo()
    {
        $CI = &get_instance();
        $row = $CI->db->where('id_user', id_user())->get('users')->row_array();
        if ($row['avatar_user'] != null) {
            return assets() . $row['avatar_user'];
        } else {
            $CI->load->model('settings/Mconfig');
            $data = $CI->Mconfig->noUserImage();
            $image = $data->value_seting;
            return $image;
        }
    }
}

// role user
if (!function_exists('role_user')) {
    function role_user()
    {
        $CI = &get_instance();
        $row = $CI->db->where('id_user', id_user())->get('users')->row_array();
        if ($row['jenis_user'] == 1) :
            $result = $CI->db->from('role')
                ->join('user_office', 'id_role=role_level')
                ->where('user_level', id_user())
                ->get()->row_array();
            $role = $result['nama_role'];
        endif;
        return $role;
    }
}
