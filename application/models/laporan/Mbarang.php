<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mbarang extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('katalog/Mharga');
    }
    public function fetch_all()
    {
        $results = $this->db->order_by('nama_barang', 'ASC')->get('barang')->result();
        $data = array();
        foreach ($results as $result) {
            $kode = $result->id_barang;
            // Menampilkan stok barang dari penerimaan terakhir
            $stok = $this->Mharga->query_penerimaan($kode, 0, 0, 1);
            if ($stok != null) {
                $row_stok = $stok != null ? convert_satuan($stok->id_satuan, $stok->stok_detail) . ' ' . $stok->singkatan_satuan : 0;
            }
            // Menampilkan harga jual dari penerimaan terakhir dengan status default aktif
            $row = $this->Mharga->query_penerimaan($kode, 1, 0, 1);
            if ($row != null) {
                $harga_terakhir = $this->Mharga->query_harga_satuan($row->id_hrg_barang, 1);
                $data_harga = '';
                foreach ($harga_terakhir as $value) {
                    $data_harga .= 'Rp ' . rupiah($value->jual_hrg_detail) . '&nbsp;/' . $value->berat_hrg_detail . ' ' . $value->singkatan_satuan . '<br>';
                }
            }
            // Menampilkan data kategori per barang
            $data_kategori = $this->barang_kategori($kode);
            $row_kategori = '';
            foreach ($data_kategori as $data_kategori) {
                $row_kategori .= $data_kategori['nama_kategori'] . '<br>';
            }
            $rows = array();
            $rows = [
                'produk' => $result->nama_barang,
                'stok' => $stok != null ? $row_stok : 0,
                'harga' => $row != null ? rtrim($data_harga, '') : '',
                'kategori' => rtrim($row_kategori, '<br>')
            ];
            $data[] = $rows;
        }
        return $data;
    }
    public function barang_kategori($kode)
    {
        return $this->db->from('barang_kategori')
            ->join('kategori', 'id_kategori=kategori_brg_kategori')
            ->where('barang_brg_kategori', $kode)
            ->get()->result_array();
    }
}

/* End of file Mbarang.php */
