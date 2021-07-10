<?php
class Mpenjualan extends CI_Model
{
	protected $tabel = 'orders';
	public function getall()
	{
		$this->db->from($this->tabel);
		return $this->db->get()->result_array();
	}
	
	public function shows()
	{
			
		return $this->db->query("SELECT invoice_order, tanggal_order, nama_barang, harga_order_barang, jumlah_order_barang FROM orders JOIN order_barang ON id_order=idorder_order_barang JOIN harga_detail ON idbarang_order_barang=id_hrg_detail
			JOIN barang_satuan ON satuan_hrg_detail=id_brg_satuan JOIN barang ON barang_brg_satuan=id_barang")->result_array();
	}

	public function tampildata()
	{
		return $this->db->query("SELECT invoice_order, tanggal_order, nama_barang, harga_order_barang, jumlah_order_barang FROM orders JOIN order_barang ON id_order=idorder_order_barang JOIN harga_detail ON idbarang_order_barang=id_hrg_detail
			JOIN barang_satuan ON satuan_hrg_detail=id_brg_satuan JOIN barang ON barang_brg_satuan=id_barang")->result_array();
	}
}
