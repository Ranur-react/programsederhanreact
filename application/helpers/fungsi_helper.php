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

if (!function_exists('make_avatar')) {
    function make_avatar($character)
    {
        $path = "images/users/" . time() . ".png";
        $simpan = pathKategori() . "../assets/images/users/" . time() . ".png";
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
