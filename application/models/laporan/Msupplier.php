<?php
class Msupplier extends CI_Model
{
	protected $tabel = 'supplier';
	public function fetch_all()
	{
		return $this->db->get($this->tabel)->result_array();
	}
}

/* End of file Msupplier.php */