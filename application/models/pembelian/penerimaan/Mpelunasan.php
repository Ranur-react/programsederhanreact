<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpelunasan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pembelian/penerimaan/Mpenerimaan');
    }
    public function kode()
    {
        $query = $this->db
            ->select('id_bayar', FALSE)
            ->order_by('id_bayar', 'DESC')
            ->limit(1)
            ->get('terima_bayar');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->id_bayar) + 1;
        } else {
            $kode = 1;
        }
        return $kode;
    }
    public function store($post)
    {
        $data = [
            'id_bayar' => $this->kode(),
            'terima_bayar' => $post['idterima'],
            'tanggal_bayar' => date("Y-m-d", strtotime($post['tanggal'])),
            'note_bayar' => $post['note'],
            'jumlah_bayar' => convert_uang($post['jumlah']),
            'user_bayar' => id_user()
        ];
        $this->db->insert('terima_bayar', $data);
        $this->update_status_terima($post['idterima']);
        return true;
    }
    public function update_status_terima($id = null)
    {
        $data = $this->Mpenerimaan->show($id);
        if ($data['total'] == $data['totalBayar'] or $data['total'] < $data['totalBayar']) :
            // update status jadi lunas
            $status = 2;
        elseif ($data['totalBayar'] > 0) :
            // update status jadi belum lunas
            $status = 1;
        else :
            // update status jadi belum bayar
            $status = 0;
        endif;
        return $this->db->where('id_terima', $id)->update('terima', ['status_terima' => $status]);
    }
    public function destroy($id)
    {
        $data = $this->db->where('id_bayar', $id)->get('terima_bayar')->row();
        if ($data) :
            $this->db->where('id_bayar', $id)->delete('terima_bayar');
            $this->update_status_terima($data->terima_bayar);
            return '0100';
        else :
            return '0101';
        endif;
    }
}

/* End of file Mpelunasan.php */
