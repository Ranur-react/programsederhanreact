<?php
class Msupplier extends CI_Model
{
	protected $tabel = 'supplier';
	public function getall()
	{
		$this->db->from($this->tabel);
		return $this->db->get()->result_array();
	}
	
	public function shows()
	{
			
		return $this->db->query("SELECT * FROM supplier")->result_array();
	}

	public function tampildata()
	{
		return $this->db->query("SELECT * FROM supplier")->result_array();
	}
}
