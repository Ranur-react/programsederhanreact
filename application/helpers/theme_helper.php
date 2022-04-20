<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('assets')) {
    function assets()
    {
        $link = base_url() . 'assets/';
        return $link;
    }
}

if (!function_exists('assets_css')) {
    function assets_css()
    {
        $link = base_url() . 'assets/src/css/';
        return $link;
    }
}

if (!function_exists('assets_js')) {
    function assets_js()
    {
        $link = base_url() . 'assets/src/js/';
        return $link;
    }
}
