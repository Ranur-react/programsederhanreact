<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpenerimaan extends CI_Model
{
    public function kode()
    {
        $query = $this->db
            ->select('id_terima', FALSE)
            ->order_by('id_terima', 'DESC')
            ->limit(1)
            ->get('penerimaan');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->id_terima) + 1;
        } else {
            $kode = 1;
        }
        return $kode;
    }
    public function store($kode, $post)
    {
        $total = $this->db->select('SUM(harga*jumlah) AS total')->where('user', id_user())->get('tmp_penerimaan')->row();
        $data_permintaan = [
            'id_terima' => $kode,
            'gudang_terima' => $post['gudang'],
            'tanggal_terima' => date("Y-m-d", strtotime($post['tanggal'])),
            'total_terima' => $total->total,
            'status_terima' => 0,
            'user_terima' => id_user()
        ];
        $permintaan = $this->db->insert('penerimaan', $data_permintaan);
        $data_tmp = $this->Mtmp_create->data();
        foreach ($data_tmp as $d) {
            $data_detail = [
                'terima_detail' => $kode,
                'minta_detail' => $d['iddetail'],
                'harga_detail' => $d['harga'],
                'jumlah_detail' => $d['jumlah']
            ];
            $this->db->insert('penerimaan_detail', $data_detail);
        }
        $data_supplier = $this->db->from('tmp_penerimaan')->group_by('permintaan')->get()->result_array();
        foreach ($data_supplier as $s) {
            $detail_supplier = [
                'id_terima_supplier' => $kode,
                'id_minta_supplier' => $s['permintaan'],
            ];
            $this->db->insert('penerimaan_supplier', $detail_supplier);
        }
        $this->db->where('user', id_user())->delete('tmp_penerimaan');
        return $permintaan;
    }
}

/* End of file Mpenerimaan.php */
