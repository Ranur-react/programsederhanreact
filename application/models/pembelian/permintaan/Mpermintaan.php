<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpermintaan extends CI_Model
{
    public function kode()
    {
        $query = $this->db
            ->select('id_permintaan', FALSE)
            ->order_by('id_permintaan', 'DESC')
            ->limit(1)
            ->get('permintaan');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->id_permintaan) + 1;
        } else {
            $kode = 1;
        }
        return $kode;
    }
}

/* End of file Mpermintaan.php */
