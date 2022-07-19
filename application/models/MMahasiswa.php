<?php
class MMahasiswa extends CI_Model
{
	public function Show()
	{
		return $this->db->query("select * from tb_mahasiswa ")->result_array();
	}
	public function ShowFilterId($key)
	{
		return $this->db->query("select * from tb_mahasiswa where nim='$key' ")->row_array();
	}

	public function insert($data)
	{

		return $this->db->query("insert into tb_mahasiswa values('" . $data['nobp'] . "','" . $data['nama'] . "','" . $data['alamat'] . "','" . $data['nohp'] . "');");
	}
	public function update($data)
	{

		return $this->db->query("update tb_mahasiswa SET nama='" . $data['nama'] . "',alamat='" . $data['alamat'] . "',hp='" . $data['nohp'] . "' where nim='" . $data['nobp'] . "';");
	}
	public function delete($key)
	{

		return $this->db->query("delete from tb_mahasiswa where nim='$key';");
	}
}