<?php
class Mpenjualan extends CI_Model
{
	public function fetch_all()
	{
		$query_order = $this->db->from('orders')
			->join('customer', 'customer_order=id_customer')
			->order_by('id_order', 'desc')
			->get()->result();
		$data = array();
		$result = array();
		foreach ($query_order as $qo) {
			$result = [
				'id' => $qo->id_order,
				'invoice' => $qo->invoice_order,
				'tanggal' => $qo->tanggal_order,
				'customer' => $qo->nama_customer
			];
			$query_produk = $this->query_produk($qo->invoice_order);
			$resultProduk = array();
			$dataProduk = array();
			foreach ($query_produk as $rowProduk) {
				$resultProduk = [
					'produk' => $rowProduk->nama_barang,
					'singkat' => $rowProduk->singkatan_satuan,
					'harga' => $rowProduk->harga_order_barang - $rowProduk->diskon_order_barang,
					'jumlah' => $rowProduk->jumlah_order_barang,
					'berat' => $rowProduk->berat_hrg_detail . ' ' . $rowProduk->singkatan_satuan,
					'total' => ($rowProduk->harga_order_barang - $rowProduk->diskon_order_barang) * $rowProduk->jumlah_order_barang
				];
				$dataProduk[] = $resultProduk;
			}
			$result['produk'] = $dataProduk;
			$data[] = $result;
		}
		return $data;
	}
	public function query_produk($id)
	{
		return $this->db->query("SELECT * FROM order_barang JOIN harga_detail ON idbarang_order_barang=id_hrg_detail JOIN barang_satuan ON satuan_hrg_detail=id_brg_satuan JOIN barang ON barang_brg_satuan=id_barang JOIN satuan ON satuan_brg_satuan=id_satuan WHERE idorder_order_barang=" . (int)$id)->result();
	}
}

/* End of file Mpenjualan.php */