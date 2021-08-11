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
        elseif ($jenis == 'jenis_pemasok') :
            if ($code == 0) :
                $pesan = 'Perorangan';
                $class = 'status-active';
            else :
                $pesan = 'Perusahaan';
                $class = 'status-pending transfer';
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
        elseif ($jenis == 'penerimaan') :
            if ($code == 0) :
                $pesan = 'Belum Bayar';
                $class = 'status-pending transfer';
            elseif ($code == 1) :
                $pesan = 'Belum Lunas';
                $class = 'status-suspended';
            elseif ($code == 2) :
                $pesan = 'Lunas';
                $class = 'status-completed';
            endif;
        elseif ($jenis == 'order') :
            if ($code == 0) :
                $pesan = 'Belum Diproses';
                $class = 'info-pending';
            elseif ($code == 1) :
                $pesan = 'Menunggu Konfirmasi';
                $class = 'info-inprogress';
            elseif ($code == 2) :
                $pesan = 'Dalam Pengemasan';
                $class = 'info-inprogress';
            elseif ($code == 3) :
                $pesan = 'Dikirim';
                $class = 'info-delivered';
            elseif ($code == 4) :
                $pesan = 'Sampai Tujuan';
                $class = 'info-accepted';
            elseif ($code == 5) :
                $pesan = 'Dibatalkan';
                $class = 'status-cancelled';
            endif;
        elseif ($jenis == 'bayar') :
            if ($code == 0) :
                $pesan = 'Belum Bayar';
                $class = 'info-pending';
            elseif ($code == 1) :
                $pesan = 'Menunggu Konfirmasi';
                $class = 'info-inprogress';
            elseif ($code == 2) :
                $pesan = 'Sudah Bayar';
                $class = 'info-accepted';
            elseif ($code == 3) :
                $pesan = 'Dibatalkan';
                $class = 'status-cancelled';
            endif;
        elseif ($jenis == 'confirm') :
            if ($code == 0) :
                $pesan = 'Belum Disetujui';
                $class = 'info-pending';
            elseif ($code == 1) :
                $pesan = 'Sudah Disetujui';
                $class = 'info-accepted';
            elseif ($code == 2) :
                $pesan = 'Dibatalkan';
                $class = 'status-cancelled';
            endif;
        endif;
        $span = '<span class="label status ' . $class . '">' . $pesan . '</span>';
        return $span;
    }
}

if (!function_exists('status_label')) {
    function status_label($code, $jenis)
    {
        if ($jenis == 'permintaan') :
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
        elseif ($jenis == 'penerimaan') :
            if ($code == 0) :
                $pesan = 'Belum Bayar';
                $class = 'status-pending transfer';
            elseif ($code == 1) :
                $pesan = 'Belum Lunas';
                $class = 'status-suspended';
            elseif ($code == 2) :
                $pesan = 'Lunas';
                $class = 'status-completed';
            endif;
        elseif ($jenis == 'order') :
            if ($code == 0) :
                $pesan = 'Belum Diproses';
                $class = 'info-pending';
            elseif ($code == 1) :
                $pesan = 'Menunggu Konfirmasi';
                $class = 'info-inprogress';
            elseif ($code == 2) :
                $pesan = 'Dalam Pengemasan';
                $class = 'info-inprogress';
            elseif ($code == 3) :
                $pesan = 'Dikirim';
                $class = 'info-delivered';
            elseif ($code == 4) :
                $pesan = 'Sampai Tujuan';
                $class = 'info-accepted';
            elseif ($code == 5) :
                $pesan = 'Dibatalkan';
                $class = 'status-cancelled';
            endif;
        elseif ($jenis == 'bayar') :
            if ($code == 0) :
                $pesan = 'Belum Bayar';
                $class = 'info-pending';
            elseif ($code == 1) :
                $pesan = 'Menunggu Konfirmasi';
                $class = 'info-inprogress';
            elseif ($code == 2) :
                $pesan = 'Sudah Bayar';
                $class = 'info-accepted';
            elseif ($code == 3) :
                $pesan = 'Dibatalkan';
                $class = 'status-cancelled';
            endif;
        elseif ($jenis == 'confirm') :
            if ($code == 0) :
                $pesan = 'Belum Disetujui';
                $class = 'info-pending';
            elseif ($code == 1) :
                $pesan = 'Sudah Disetujui';
                $class = 'info-accepted';
            elseif ($code == 2) :
                $pesan = 'Dibatalkan';
                $class = 'status-cancelled';
            endif;
        endif;
        $span = '<span class="label status-label ' . $class . '">' . $pesan . '</span>';
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

if (!function_exists('convert_stok')) {
    function convert_stok($satuan, $jumlah)
    {
        /**
         * Function ini difungsikan untuk mengkonversi jumlah pembelian
         * dari satuan KG ke Gram, jika satuan yang dibeli adalah
         * Gram maka jumlah tidak dikonversi dan apabila satuan
         * yang tidak bisa dikonversi maka jumlah masih tetap
         */
        if ($satuan == 1) :
            // Konversi jumlah dari satuan Kg ke satuan gram
            $nilai = 1000 * $jumlah;
        elseif ($satuan == 3) :
            // Konversi jumlah dari satuan gram tetap pada satuan gram
            $nilai = 1 * $jumlah;
        else :
            // Tidak terjadi konversi pada jumlah
            $nilai = 1 * $jumlah;
        endif;
        return $nilai;
    }
}

if (!function_exists('convert_satuan')) {
    function convert_satuan($satuan, $jumlah)
    {
        if ($satuan == 1) :
            // Konversi jumlah dari satuan Gram ke satuan Kg
            $nilai = $jumlah / 1000;
        elseif ($satuan == 3) :
            // Konversi jumlah dari satuan gram tetap pada satuan gram
            $nilai = $jumlah / 1;
        else :
            // Tidak terjadi konversi pada jumlah
            $nilai = $jumlah;
        endif;
        return $nilai;
    }
}

if (!function_exists('zerobefore')) {
    function zerobefore($lenght)
    {
        $count = strlen($lenght);
        if ($count == 1) :
            $nomor = '0000' . $lenght;
        elseif ($count == 2) :
            $nomor = '000' . $lenght;
        elseif ($count == 3) :
            $nomor = '00' . $lenght;
        elseif ($count == 4) :
            $nomor = '0' . $lenght;
        else :
            $nomor = $lenght;
        endif;
        return $nomor;
    }
}

if (!function_exists('relasi')) {
    function relasi($kode)
    {
        $data = array(
            1 => 'Yang bersangkutan',
            2 => 'Keluarga',
            3 => 'Teman',
            4 => 'Lainnya'
        );
        foreach ($data as $key => $value) {
            if ($key == $kode) :
                return $value;
            endif;
        }
    }
}
