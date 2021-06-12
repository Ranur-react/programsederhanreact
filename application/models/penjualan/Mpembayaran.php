<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpembayaran extends CI_Model
{
    public function kode()
    {
        $query = $this->db
            ->select('id_bukti', FALSE)
            ->order_by('id_bukti', 'DESC')
            ->limit(1)
            ->get('order_bukti_bayar');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->id_bukti) + 1;
        } else {
            $kode = 1;
        }
        return $kode;
    }
    public function store($post, $link)
    {
        $data = [
            'id_bukti' => $this->kode(),
            'idbayar_bukti' => $post['idbayar'],
            'tanggal_bukti'  => date("Y-m-d", strtotime($post['tanggal'])),
            'nilai_bukti' => convert_uang($post['nilai']),
            'image_bukti'   => $link,
            'status_bukti' => 0
        ];
        return $this->db->insert('order_bukti_bayar', $data);
    }
}

/* End of file Mpembayaran.php */
