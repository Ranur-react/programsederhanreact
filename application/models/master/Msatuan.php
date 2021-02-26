<?php
class Msatuan extends CI_Model
{
    var $tabel = 'satuan';
    var $id = 'id_satuan';

    public function getall()
    {
        return $this->db->get($this->tabel)->result_array();
    }
}
