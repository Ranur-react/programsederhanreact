<?php
class Msupplier extends CI_Model
{
	protected $tabel = 'supplier';
	public function getall()
	{
		$this->db->from($this->tabel);
		return $this->db->get()->result_array();
	}
	public function store($params)
	{
		$data = [
			'id_supplier' => $params['idsupplier'],
			'nama_supplier' => $params['namasupplier'],
			'alamat_supplier' => $params['alamatsupplier'],
			'telp_supplier' => $params['telpsupplier'],
		];
		$karyawan= $this->db->insert($this->tabel, $data);
		return array($karyawan);
	}
	public function shows($kode)
	{
		return $this->db->where('id_supplier', $kode)->get($this->tabel)->row_array();
	}
	public function update($params)
	{
		$kode = $params['kode'];
		$data = [
			'id_supplier' => $params['idsupplier'],
			'nama_supplier' => $params['namasupplier'],
			'alamat_supplier' => $params['alamatsupplier'],
			'telp_supplier' => $params['telpsupplier'],
		];
		return $this->db->where('id_supplier', $kode)->update($this->tabel, $data);
	}
	public function destroy($kode)
	{

		return $this->db->simple_query("DELETE FROM " . $this->tabel . " WHERE id_supplier='$kode'");
	
	}

	public function tampildata()
	{
		return $this->db->query("SELECT * FROM supplier;")->result_array();
	}
}
