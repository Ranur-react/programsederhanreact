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
