<?php
class Mroles extends CI_Model
{
    protected $tabel = 'role';
    public function fetch_all()
    {
        return $this->db->get($this->tabel)->result_array();
    }
}
