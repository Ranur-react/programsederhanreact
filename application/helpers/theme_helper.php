<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('assets')) {
    function assets()
    {
        $CI = &get_instance();
        $CI->load->model('settings/Mconfig');
        $data = $CI->Mconfig->pathAssets();
        $path = $data->value_seting;
        return $path;
    }
}

if (!function_exists('pathImage')) {
    function pathImage()
    {
        $CI = &get_instance();
        $CI->load->model('settings/Mconfig');
        $data = $CI->Mconfig->pathImage();
        $path = $data->value_seting;
        return $path;
    }
}
