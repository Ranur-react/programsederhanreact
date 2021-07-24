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
