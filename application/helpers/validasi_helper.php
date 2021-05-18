<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('errorDelimiter')) {
    function errorDelimiter()
    {
        return '<div class="help-block col-sm-reset inline">';
    }
}
if (!function_exists('errorDelimiter_close')) {
    function errorDelimiter_close()
    {
        return '</div>';
    }
}

if (!function_exists('errorRequired')) {
    function errorRequired()
    {
        return '{field} tidak boleh kosong.';
    }
}
if (!function_exists('errorUnique')) {
    function errorUnique()
    {
        return '{field} sudah digunakan.';
    }
}
if (!function_exists('errorValidemail')) {
    function errorValidemail()
    {
        return '{field} harus berisi alamat email yang valid.';
    }
}
if (!function_exists('errorMatches')) {
    function errorMatches()
    {
        return '{field} tidak sama. Coba masukkan ulang.';
    }
}
if (!function_exists('greater_than')) {
    function greater_than()
    {
        return '{field} harus mengandung angka lebih dari 0.';
    }
}

if (!function_exists('errorDestroy')) {
    function errorDestroy()
    {
        return 'Data Not Deleted. Something went wrong!!!';
    }
}

if (!function_exists('successDestroy')) {
    function successDestroy()
    {
        return 'Data Deleted Successfully';
    }
}

if (!function_exists('successCancel')) {
    function successCancel()
    {
        return 'Data Canceled Successfully';
    }
}
