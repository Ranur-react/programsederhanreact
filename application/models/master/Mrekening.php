<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mrekening extends CI_Model
{
    public function fetch_all()
    {
        return $this->db->from('account_bank')->join('bank_code', 'bank_account=id_bank')->get()->result_array();
    }
}

/* End of file Mrekening.php */
