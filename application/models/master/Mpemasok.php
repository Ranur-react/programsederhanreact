<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpemasok extends CI_Model
{
	var $tabel = 'supplier';
	var $id = 'id_supplier';
	var $column_order = array(null, 'nama_supplier', 'alamat_supplier', 'telp_supplier');
	var $column_search = array('nama_supplier', 'alamat_supplier', 'telp_supplier');
	var $order = array('nama_supplier' => 'asc');

	private function _get_data_query()
	{
		$this->db->from($this->tabel);
		$i = 0;
		foreach ($this->column_search as $item) {
			if ($_GET['search']['value']) {
				if ($i === 0) {
					$this->db->group_start();
					$this->db->like($item, $_GET['search']['value']);
				} else {
					$this->db->or_like($item, $_GET['search']['value']);
				}
				if (count($this->column_search) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		if (isset($_GET['order'])) {
			$this->db->order_by($this->column_order[$_GET['order']['0']['column']], $_GET['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}
	function fetch_all()
	{
		$this->_get_data_query();
		if ($_GET['length'] != -1)
			$this->db->limit($_GET['length'], $_GET['start']);
		$query = $this->db->get();
		return $query->result();
	}
	function count_filtered()
	{
		$this->_get_data_query();
		$query = $this->db->get();
		return $query->num_rows();
	}
	function count_all()
	{
		$this->db->from($this->tabel);
		return $this->db->count_all_results();
	}
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
			'telp_supplier' => $post['telp'],
			'jenis_supplier' => $post['jenis']
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
			'telp_supplier' => $post['telp'],
			'jenis_supplier' => $post['jenis']
		];
		return $this->db->where('id_supplier', $post['kode'])->update($this->tabel, $data);
	}
	public function destroy($kode)
	{
		return $this->db->simple_query("DELETE FROM " . $this->tabel . " WHERE id_supplier='$kode'");
	}
}

/* End of file Mpemasok.php */
