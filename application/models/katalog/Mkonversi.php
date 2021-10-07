<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mkonversi extends CI_Model
{
    var $tabel = 'satuan_konversi';
    var $id = 'id_konversi';

    public function fetch_all()
    {
        return $this->db->select('*,s1.nama_satuan as satuan_terbesar,s1.singkatan_satuan as singkatan_terbesar,s2.nama_satuan as satuan_terkecil,s2.singkatan_satuan as singkatan_terkecil')
            ->from('satuan_konversi')
            ->join('satuan s1', 's1.id_satuan=idsatuan_terbesar')
            ->join('satuan s2', 's2.id_satuan=idsatuan_terkecil')
            ->get()->result_array();
    }
    public function kode()
    {
        $query = $this->db
            ->select($this->id, FALSE)
            ->order_by($this->id, 'DESC')
            ->limit(1)
            ->get($this->tabel);
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->id_konversi) + 1;
        } else {
            $kode = 1;
        }
        return $kode;
    }
    public function store($post)
    {
        $data = array(
            'id_konversi' => $this->kode(),
            'idsatuan_terbesar' => $post['terbesar'],
            'idsatuan_terkecil' => $post['terkecil'],
            'nilai_konversi' => convert_uang($post['nilai']),
        );
        return $this->db->insert($this->tabel, $data);
    }
    public function show($id)
    {
        return $this->db->select('*,s1.nama_satuan as satuan_terbesar,s2.nama_satuan as satuan_terkecil,s2.singkatan_satuan')
            ->from('satuan_konversi')
            ->join('satuan s1', 's1.id_satuan=idsatuan_terbesar')
            ->join('satuan s2', 's2.id_satuan=idsatuan_terkecil')
            ->where('id_konversi', $id)
            ->get()->row();
    }
    public function update($post)
    {
        $data = array(
            'idsatuan_terbesar' => $post['terbesar'],
            'idsatuan_terkecil' => $post['terkecil'],
            'nilai_konversi' => convert_uang($post['nilai']),
        );
        return $this->db->where('id_konversi', $post['kode'])->update($this->tabel, $data);
    }
    public function destroy($id)
    {
        return $this->db->simple_query("DELETE FROM " . $this->tabel . " WHERE id_konversi='$id'");
    }
}

/* End of file Mkonversi.php */
