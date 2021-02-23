<?php
class Msupplier extends CI_Model
{
	protected $tabel = 'supplier';
	public function getall()
	{
		return $this->db->get($this->tabel)->result_array();
	}
}
