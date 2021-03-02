<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpengguna extends CI_Model
{
    public function fetch_all()
    {
        return $this->db->get('users')->result_array();
    }
}

/* End of file Mpengguna.php */
