<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('konversi_jumlah_satuan')) {
    function konversi_jumlah_satuan($idsatuan, $jumlah)
    {
        $CI = &get_instance();
        $satuan_terbesar = $CI->db->from('satuan_konversi')
            ->where('idsatuan_terbesar', $idsatuan);
        if ($satuan_terbesar->count_all_results() > 0) :
            $data_terbesar = $CI->db->select('ks1.idsatuan_terbesar AS idsatuan_besar,ks1.idsatuan_terkecil AS idsatuan_kecil,s2.nama_satuan AS satuan_terkecil,nilai_konversi')
                ->from('satuan_konversi AS ks1')
                ->join('satuan AS s1', 'ks1.idsatuan_terbesar=s1.id_satuan')
                ->join('satuan AS s2', 'ks1.idsatuan_terkecil=s2.id_satuan')
                ->where('ks1.idsatuan_terbesar', $idsatuan)
                ->get()->row_array();
            $data = [
                'idsatuan_besar' => (int)$data_terbesar['idsatuan_besar'],
                'idsatuan_kecil' => (int)$data_terbesar['idsatuan_kecil'],
                'jumlah' => $jumlah * $data_terbesar['nilai_konversi']
            ];
        endif;

        $satuan_terkecil = $CI->db->from('satuan_konversi')
            ->where('idsatuan_terkecil', $idsatuan);
        if ($satuan_terkecil->count_all_results() > 0) :
            $data_terkecil = $CI->db->select('ks1.idsatuan_terbesar AS idsatuan_besar,ks1.idsatuan_terkecil AS idsatuan_kecil,s1.nama_satuan AS satuan_terbesar')
                ->from('satuan_konversi AS ks1')
                ->join('satuan AS s1', 'ks1.idsatuan_terbesar=s1.id_satuan')
                ->join('satuan AS s2', 'ks1.idsatuan_terkecil=s2.id_satuan')
                ->where('ks1.idsatuan_terkecil', $idsatuan)
                ->get()->row_array();
            $data = [
                'idsatuan_besar' => (int)$data_terkecil['idsatuan_besar'],
                'idsatuan_kecil' => (int)$data_terkecil['idsatuan_kecil'],
                'jumlah' => (int)$jumlah
            ];
        endif;
        return $data;
    }
}

if (!function_exists('konversi_nilai_satuan')) {
    function konversi_nilai_satuan($idsatuan, $jumlah)
    {
        $CI = &get_instance();
        $satuan_terbesar = $CI->db->from('satuan_konversi')
            ->where('idsatuan_terbesar', $idsatuan);
        if ($satuan_terbesar->count_all_results() > 0) :
            // Dibagi
            $data_terbesar = $CI->db->select('ks1.idsatuan_terbesar AS idsatuan_besar,ks1.idsatuan_terkecil AS idsatuan_kecil,s2.nama_satuan AS satuan_terkecil,nilai_konversi')
                ->from('satuan_konversi AS ks1')
                ->join('satuan AS s1', 'ks1.idsatuan_terbesar=s1.id_satuan')
                ->join('satuan AS s2', 'ks1.idsatuan_terkecil=s2.id_satuan')
                ->where('ks1.idsatuan_terbesar', $idsatuan)
                ->get()->row_array();
            $proses = $jumlah / $data_terbesar['nilai_konversi'];
            $sisa_bagi = $jumlah % $data_terbesar['nilai_konversi'];
            $hasil = ($jumlah - $sisa_bagi) / $data_terbesar['nilai_konversi'];
            $value = $sisa_bagi == 0 ? $proses : $hasil . ',' . $sisa_bagi;
            $data = [
                'idsatuan_besar' => (int)$data_terbesar['idsatuan_besar'],
                'idsatuan_kecil' => (int)$data_terbesar['idsatuan_kecil'],
                'jumlah' => $value
            ];
        endif;
        return $data;
    }
}
