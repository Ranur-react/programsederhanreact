<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Nama Aplikasi
if (!function_exists('nameApp')) {
    function nameApp()
    {
        return "Barang Mudo";
    }
}

// Logo Aplikasi
if (!function_exists('logoApp')) {
    function logoApp()
    {
        return base_url() . 'assets/logo/logo.png';
    }
}

// Favicon Aplikasi
if (!function_exists('faviconApp')) {
    function faviconApp()
    {
        return base_url() . 'assets/logo/favicon.ico';
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
