<?php
class Mgudang extends CI_Model
{
    var $tabel = 'gudang';
    var $id = 'id_gudang';

    public function getall()
    {
        return $this->db->get($this->tabel)->result_array();
    }
}
