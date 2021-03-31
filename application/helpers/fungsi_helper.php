<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('status_span')) {
    function status_span($code, $jenis)
    {
        if ($jenis == 'aktif') :
            if ($code == 1) :
                $pesan = 'Enabled';
                $class = 'status-active';
            else :
                $pesan = 'Disabled';
                $class = 'status-unpaid';
            endif;
        elseif ($jenis == 'permintaan') :
            if ($code == 1) :
                $pesan = 'Pending';
                $class = 'status-pending transfer';
            elseif ($code == 2) :
                $pesan = 'Proses';
                $class = 'status-suspended';
            elseif ($code == 3) :
                $pesan = 'Selesai';
                $class = 'status-completed';
            elseif ($code == 4) :
                $pesan = 'Batal';
                $class = 'status-cancelled';
            endif;
        endif;
        $span = '<span class="label status ' . $class . '">' . $pesan . '</span>';
        return $span;
    }
}

if (!function_exists('make_avatar')) {
    function make_avatar($character)
    {
        $path = "images/users/" . time() . ".png";
        $simpan = pathImage() . "images/users/" . time() . ".png";
        $image = imagecreate(200, 200);
        $red = rand(0, 255);
        $green = rand(0, 255);
        $blue = rand(0, 255);
        imagecolorallocate($image, $red, $green, $blue);
        $textcolor = imagecolorallocate($image, 255, 255, 255);
        $dir = realpath(__DIR__ . '/../../../assets/dist/font/arial.ttf');
        $font = str_replace('\\', '/', $dir);
        $string = strtoupper($character[0]);
        imagettftext($image, 100, 0, 55, 150, $textcolor, $font, $string);
        imagepng($image, $simpan);
        imagedestroy($image);
        return $path;
    }
}

if (!function_exists('rupiah')) {
    function rupiah($uang)
    {
        $format = number_format($uang, 0, ",", ".");
        return $format;
    }
}

if (!function_exists('akuntansi')) {
    function akuntansi($uang)
    {
        $format = "<span style='float:left;'>Rp.</span><span style='float:right;'>" . number_format($uang, 0, ",", ".") . "</span>";
        return $format;
    }
}

if (!function_exists('convert_uang')) {
    function convert_uang($text)
    {
        $text = str_replace(".", "", $text);
        return $text;
    }
}
