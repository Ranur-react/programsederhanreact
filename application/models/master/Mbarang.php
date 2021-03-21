<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mbarang extends CI_Model
{
    public function fetch_all()
    {
        return $this->db->order_by('nama_barang', 'ASC')->get('barang')->result_array();
    }
}

/* End of file Mbarang.php */
