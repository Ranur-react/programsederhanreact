<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mtmp_create extends CI_Model
{
    public function jumlah_data()
    {
        return $this->db->from('permintaan')
            ->where_in('status_permintaan', array(1, 2))
            ->count_all_results();
    }
    public function tampil_data($start, $length)
    {
        $sql = $this->db->from('permintaan')
            ->join('supplier', 'supplier_permintaan=id_supplier')
            ->join('users', 'user_permintaan=id_user')
            ->where_in('status_permintaan', array(1, 2))
            ->order_by('id_permintaan', 'DESC')
            ->limit($length, $start)
            ->get();
        return $sql;
    }
    public function cari_data($search)
    {
        $sql = $this->db->from('permintaan')
            ->join('supplier', 'supplier_permintaan=id_supplier')
            ->join('users', 'user_permintaan=id_user')
            ->where_in('status_permintaan', array(1, 2))
            ->order_by('id_permintaan', 'DESC')
            ->like('nama_supplier', $search)
            ->get();
        return $sql;
    }
}

/* End of file Mtmp_create.php */