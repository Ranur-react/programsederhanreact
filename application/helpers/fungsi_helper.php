<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('status_span')) {
    function status_span($code, $jenis)
    {
        if ($code == 1) :
            if ($jenis == 'aktif') :
                $pesan = 'Enabled';
            endif;
            $span = '<span class="label status status-active ">' . $pesan . '</span>';
        elseif ($code == 2) :
            if ($jenis == 'aktif') :
                $pesan = 'Disabled';
            endif;
            $span = '<span class="label status status-unpaid">' . $pesan . '</span>';
        endif;
        return $span;
    }
}
