<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('bulan')) {
    function bulan($bln)
    {
        switch ($bln) {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }
}

if (!function_exists('format_biasa')) {
    function format_biasa($tgl)
    {
        $ubah = gmdate($tgl, time() + 60 * 60 * 8);
        $pecah = explode("-", $ubah);
        $tanggal = $pecah[2];
        $bulan = $pecah[1];
        $tahun = $pecah[0];
        return $tanggal . '-' . $bulan . '-' . $tahun;
    }
}

if (!function_exists('format_indo')) {
    function format_indo($tgl)
    {
        $ubah = gmdate($tgl, time() + 60 * 60 * 8);
        $pecah = explode("-", $ubah);
        $tanggal = $pecah[2];
        $bulan = bulan($pecah[1]);
        $tahun = $pecah[0];
        return $tanggal . ' ' . $bulan . ' ' . $tahun;
    }
}

if (!function_exists('format_tglin_timestamp')) {
    function format_tglin_timestamp($tgl)
    {
        // $inttime = date('Y-m-d H:i:s', $tgl);
        $tglBaru = explode(" ", $tgl);
        $tglBaru1 = $tglBaru[0];
        $tglBaru2 = $tglBaru[1];
        $tglBarua = explode("-", $tglBaru1);

        $tgl = $tglBarua[2];
        $bln = $tglBarua[1];
        $thn = $tglBarua[0];

        $bln = bulan($bln);
        $ubahTanggal = "$tgl $bln $thn";

        return $ubahTanggal;
    }
}

if (!function_exists('sort_jam_timestamp')) {
    function sort_jam_timestamp($tgl)
    {
        // $inttime = date('Y-m-d H:i:s', $tgl);
        $tglBaru = explode(" ", $tgl);
        $tglBaru1 = $tglBaru[0];
        $tglBaru2 = $tglBaru[1];
        $tglBarua = explode("-", $tglBaru1);

        $tgl = $tglBarua[2];
        $bln = $tglBarua[1];
        $thn = $tglBarua[0];

        $bln = bulan($bln);
        $ubahTanggal = "$tglBaru2 ";

        return substr($ubahTanggal, 0, 5);
    }
}

if (!function_exists('format_tahun')) {
    function format_tahun($tgl)
    {
        $ubah  = gmdate($tgl, time() + 60 * 60 * 8);
        $pecah = explode("-", $ubah);
        $tahun = $pecah[0];
        return $tahun;
    }
}
