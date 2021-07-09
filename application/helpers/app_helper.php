<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Nama Aplikasi
if (!function_exists('nameApp')) {
    function nameApp()
    {
        $CI = &get_instance();
        $CI->load->model('settings/Mconfig');
        $data = $CI->Mconfig->nameApp();
        $name = $data->value_seting;
        return $name;
    }
}

// Logo Aplikasi
if (!function_exists('logoApp')) {
    function logoApp()
    {
        $CI = &get_instance();
        $CI->load->model('settings/Mconfig');
        $data = $CI->Mconfig->logoApp();
        $image = assets() . $data->value_seting;
        return $image;
    }
}
// Logo Aplikasi
if (!function_exists('logoDashboard')) {
    function logoDashboard()
    {
        $CI = &get_instance();
        $CI->load->model('settings/Mconfig');
        $data = $CI->Mconfig->logoDashboard();
        $image = assets() . $data->value_seting;
        return $image;
    }
}

// Favicon Aplikasi
if (!function_exists('faviconApp')) {
    function faviconApp()
    {
        $CI = &get_instance();
        $CI->load->model('settings/Mconfig');
        $data = $CI->Mconfig->faviconApp();
        $image = assets() . $data->value_seting;
        return $image;
    }
}

// cek session user yang login
if (!function_exists('cek_user')) {
    function cek_user()
    {
        $CI = &get_instance();
        if ($CI->session->userdata('status_login') != 'sessDashboard') :
            redirect('logout');
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
            $image = assets() . $data->value_seting;
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
