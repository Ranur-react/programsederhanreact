<?php
class MKaryawan extends CI_Model
{
	public function Show()
	{
		return $this->db->query("select * from tb_karyawan ")->result_array();
	}

	public function insert($data)
	{
		// echo $data['nobp'];

		return $this->db->query("insert into tb_karyawan values('"
			. $data['id']
			. "','"
			. $data['nama']
			. "','"
			. $data['alamat']
			. "');");
	}
}