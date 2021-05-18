<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpelunasan extends CI_Model
{
    public function kode()
    {
        $query = $this->db
            ->select('id_bayar', FALSE)
            ->order_by('id_bayar', 'DESC')
            ->limit(1)
            ->get('penerimaan_bayar');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->id_bayar) + 1;
        } else {
            $kode = 1;
        }
        return $kode;
    }
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
    public function update_status_bayar($id = null)
    {
        $data = $this->total_bayar($id);
        if ($data['total'] == $data['bayar'] or $data['total'] < $data['bayar']) :
            // update status jadi lunas
            $status = 2;
        elseif ($data['bayar'] > 0) :
            // update status jadi belum lunas
            $status = 1;
        else :
            // update status jadi belum bayar
            $status = 0;
        endif;
        return $this->db->where('id_terima', $id)->update('penerimaan', ['status_terima' => $status]);
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
    public function store($post)
    {
        $data = [
            'id_bayar' => $this->kode(),
            'terima_bayar' => $post['idterima'],
            'tanggal_bayar' => date("Y-m-d", strtotime($post['tanggal'])),
            'info_bayar' => empty($post['keterangan']) ? null : $post['keterangan'],
            'jumlah_bayar' => convert_uang($post['jumlah']),
            'user_bayar' => id_user()
        ];
        $query = $this->db->insert('penerimaan_bayar', $data);
        $this->update_status_bayar($post['idterima']);
        return $query;
    }
}

/* End of file Mpelunasan.php */
