<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mstok extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pembelian/penerimaan/Mpenerimaan');
    }
    public function data_penerimaan($id = null)
    {
        $query = "SELECT * FROM barang JOIN barang_satuan ON id_barang=barang_brg_satuan JOIN satuan ON satuan_brg_satuan=id_satuan JOIN permintaan_detail ON id_brg_satuan=barang_detail JOIN penerimaan_detail ON minta_detail=permintaan_detail.id_detail";
        $query .= " WHERE id_barang='$id'";
        $query = $this->db->query($query)->result();
        $data = array();
        foreach ($query as $result) {
            $id_terima = $result->terima_detail;
            // tampilkan informasi penerimaan barang
            $row_terima = $this->Mpenerimaan->show($id_terima);
            $row_terjual = $this->total_terjual($id, $id_terima);
            $rows = array();
            $rows['id_terima'] = $row_terima['id_terima'];
            $rows['nomor'] = $row_terima['nosurat_terima'];
            $rows['supplier'] = $row_terima['nama_supplier'];
            $rows['tanggal'] = format_indo($row_terima['tanggal_terima']);
            $rows['created_at'] = sort_jam_timestamp($row_terima['created_at']) . ' ' . format_tglin_timestamp($row_terima['created_at']);
            $rows['gudang'] = $row_terima['nama_gudang'];
            $rows['barang'] = $result->nama_barang;
            $rows['satuan_beli'] = $result->singkatan_satuan;
            $rows['jumlah_beli'] = rupiah($result->jumlah_detail);
            $rows['stok'] = convert_satuan($result->id_satuan, $result->stok_detail);
            $rows['terjual'] = convert_satuan($result->id_satuan, $row_terjual->terjual);
            $data[] = $rows;
        }
        return $data;
    }
    public function total_terjual($id, $id_terima)
    {
        $sql = "SELECT SUM(berat_hrg_detail*jumlah_order_barang) AS terjual FROM barang JOIN barang_satuan ON id_barang=barang_brg_satuan JOIN satuan ON satuan_brg_satuan=id_satuan JOIN permintaan_detail ON id_brg_satuan=barang_detail JOIN penerimaan_detail ON minta_detail=permintaan_detail.id_detail JOIN penerimaan_harga ON detail_terima_harga=penerimaan_detail.id_detail JOIN harga_barang ON barang_terima_harga=id_hrg_barang JOIN harga_detail ON id_hrg_barang=harga_hrg_detail JOIN order_barang ON id_hrg_detail=idbarang_order_barang WHERE id_barang='$id' AND terima_detail='$id_terima'";
        return $this->db->query($sql)->row();
    }
}

/* End of file Mstok.php */
