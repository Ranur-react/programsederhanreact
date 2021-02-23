<?php
class Msupplier extends CI_Model
{
	protected $tabel = 'supplier';
	public function getall()
	{
		return $this->db->get($this->tabel)->result_array();
	}
	public function kode()
	{
		$query = $this->db
			->select('id_supplier', FALSE)
			->order_by('id_supplier', 'DESC')
			->limit(1)
			->get($this->tabel);
		if ($query->num_rows() <> 0) {
			$data = $query->row();
			$kode = intval($data->id_supplier) + 1;
		} else {
			$kode = 1;
		}
		return $kode;
	}
	public function store($post)
	{
		$data = [
			'id_supplier' => $this->kode(),
			'nama_supplier' => $post['nama'],
			'alamat_supplier' => $post['alamat'],
			'telp_supplier' => $post['telp']
		];
		return $this->db->insert($this->tabel, $data);
	}
	public function show($kode)
	{
		return $this->db->where('id_supplier', $kode)->get($this->tabel)->row_array();
	}
	public function update($post)
	{
		$data = [
			'nama_supplier' => $post['nama'],
			'alamat_supplier' => $post['alamat'],
			'telp_supplier' => $post['telp']
		];
		return $this->db->where('id_supplier', $post['kode'])->update($this->tabel, $data);
	}
}
