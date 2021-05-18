<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpelunasan extends CI_Model
{
    public function total_bayar($id = null)
    {
        $query = $this->db->query("SELECT *,(SELECT IFNULL(SUM(jumlah_bayar),0) FROM penerimaan_bayar WHERE id_terima=terima_bayar AND terima_bayar='$id') AS bayar FROM penerimaan WHERE id_terima='$id'")->row();
        $data = array(
            'idterima' => $query->id_terima,
            'total' => $query->total_terima,
            'bayar' => $query->bayar,
            'sisa' => ($query->total_terima - $query->bayar)
        );
        return $data;
    }
    public function show($id = null)
    {
        $query = $this->db->from('penerimaan_bayar')
            ->where('terima_bayar', $id)
            ->order_by('id_bayar', 'ASC')
            ->get()->result();
        $data = array();
        foreach ($query as $value) {
            $rows['id_bayar'] = $value->id_bayar;
            $rows['tanggal'] = format_indo($value->tanggal_bayar);
            $rows['info'] = $value->info_bayar;
            $rows['jumlah'] = rupiah($value->jumlah_bayar);
            $rows['nominal'] = $value->jumlah_bayar;
            $data[] = $rows;
        }
        return $data;
    }
}

/* End of file Mpelunasan.php */
