<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mcustomer extends CI_Model
{
    public function jumlah_data()
    {
        return $this->db->count_all_results('customer');
    }
    public function tampil_data($start, $length)
    {
        $query = $this->db->query("SELECT * FROM customer ORDER BY created_at DESC LIMIT $start,$length");
        return $query;
    }
    public function cari_data($search)
    {
        $query = $this->db->query("SELECT * FROM customer WHERE nama_customer LIKE '%$search%' ESCAPE '!' OR email_customer LIKE '%$search%' ESCAPE '!' OR phone_customer LIKE '%$search%' ESCAPE '!' ORDER BY created_at DESC");
        return $query;
    }
}

/* End of file Mcustomer.php */
