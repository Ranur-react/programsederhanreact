<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpengiriman extends CI_Model
{
    public function jumlah_data()
    {
        return $this->db->from('orders')->where_in('status_order', [2, 3, 4])->count_all_results();
    }
    public function tampil_data($start, $length)
    {
        $sql = $this->db->from('orders')
            ->join('customer', 'customer_order=id_customer')
            ->join('order_bayar', 'id_order=order_bayar')
            ->join('metode_bayar', 'id_metode=metode_bayar')
            ->where_in('status_order', [2, 3, 4])
            ->order_by('id_order', 'DESC')
            ->limit($length, $start)
            ->get();
        return $sql;
    }
    public function cari_data($search)
    {
        $sql = $this->db->from('orders')
            ->join('customer', 'customer_order=id_customer')
            ->join('order_bayar', 'id_order=order_bayar')
            ->join('metode_bayar', 'id_metode=metode_bayar')
            ->where_in('status_order', [2, 3, 4])
            ->order_by('id_order', 'DESC')
            ->like('invoice_order', $search)
            ->or_like('nama_customer', $search)
            ->or_like("DATE_FORMAT(tanggal_order,'%d-%m-%Y')", $search)
            ->get();
        return $sql;
    }
}

/* End of file Mpengiriman.php */
