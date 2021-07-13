<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mgudang extends CI_Model
{
    public function fetch_all()
    {
        return $this->db->get('gudang')->result_array();
    }
}

/* End of file Mgudang.php */
