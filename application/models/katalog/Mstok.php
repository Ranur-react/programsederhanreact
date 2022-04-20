<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mstok extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pembelian/penerimaan/Mpenerimaan');
    }
    public function getDatastok($id = null)
    {
        $sql = $this->db->from('barang')
            ->where('id_barang', $id)
            ->get()->row();
        $dataProduk = [
            'idproduk' => (int)$sql->id_barang,
            'produk' => $sql->nama_barang
        ];
        $sqlSatuan = $this->db->from('barang_satuan')
            ->join('satuan', 'id_satuan=satuan_brg_satuan')
            ->where('barang_brg_satuan', $id)
            ->get()->result();
        foreach ($sqlSatuan as $sqlSatuan) {
            $dataSatuan[] = (int)$sqlSatuan->id_satuan;
        }
        $sqlKonversi = $this->db->select('ks.id_konversi,ks.idsatuan_terbesar AS idsatuan_besar,ks.idsatuan_terkecil AS idsatuan_kecil,s1.singkatan_satuan AS satuan_terbesar,ks.nilai_konversi')
            ->from('satuan_konversi AS ks')
            ->join('satuan AS s1', 'ks.idsatuan_terbesar=s1.id_satuan')
            ->join('satuan AS s2', 'ks.idsatuan_terkecil=s2.id_satuan')
            ->where_in('ks.idsatuan_terbesar', $dataSatuan)
            ->or_where_in('ks.idsatuan_terkecil', $dataSatuan)
            ->get()->result();
        $dataKonversi = [];
        $resultKonversi = [];
        $total = 0;
        foreach ($sqlKonversi as $sqlKonversi) {
            $resultKonversi = [
                'idkonversi' => (int)$sqlKonversi->id_konversi
            ];
            $sqlStok = $this->db->from('barang_satuan')
                ->join('terima_stok', 'id_brg_satuan=idsatuan_stok')
                ->where('barang_brg_satuan', $id)
                ->where_in('satuan_brg_satuan', array($sqlKonversi->idsatuan_besar, $sqlKonversi->idsatuan_kecil))
                ->where('real_stok > ', 0)
                ->get()->result();
            $dataStok = [];
            $resultStok = [];
            $totalStokAwal = 0;
            $totalStokAkhir = 0;
            foreach ($sqlStok as $sqlStok) {
                $totalStokAwal = $totalStokAwal + $sqlStok->convert_stok;
                $totalStokAkhir = $totalStokAkhir + $sqlStok->real_stok;

                $resultStok = [
                    'idstok' => (int)$sqlStok->id_stok,
                    'stokAwal' => (int)$sqlStok->convert_stok,
                    'stokAkhir' => (int)$sqlStok->real_stok
                ];
                $dataStok[] = $resultStok;
            }

            $total = $total + $totalStokAkhir;
            $stokAwal = nilaiKonversi($sqlKonversi->idsatuan_besar, $totalStokAwal);
            $stokAkhir = nilaiKonversi($sqlKonversi->idsatuan_besar, $totalStokAkhir);
            $resultKonversi['stokAwal'] = $totalStokAwal;
            $resultKonversi['stokAwalText'] = $stokAwal['value'];
            $resultKonversi['stokAkhir'] = $totalStokAkhir;
            $resultKonversi['stokAkhirText'] = $stokAkhir['value'];
            $resultKonversi['dataStok'] = $dataStok;

            $dataKonversi[] = $resultKonversi;
        }
        $data['totalStok'] = $total;
        $data['dataSatuan'] = $dataKonversi;
        // $data['satuan'] = $dataSatuan;
        $data['produk'] = $dataProduk;
        $arr = [
            'status' => true,
            'data' => $data
        ];
        return $arr;
    }
    public function getStokterima($id = null)
    {
        $sql = $this->db->from('barang')
            ->where('id_barang', $id)
            ->get()->row();
        $dataProduk = [
            'idproduk' => (int)$sql->id_barang,
            'produk' => $sql->nama_barang
        ];
        $sql_terima = $this->db->select('*,terima_detail.harga_detail as hargabeli')->from('barang')
            ->join('barang_satuan', 'id_barang=barang_brg_satuan')
            ->join('permintaan_detail', 'id_brg_satuan=barang_detail')
            ->join('terima_detail', 'permintaan_detail.id_detail=minta_detail')
            ->join('terima', 'terima_detail=id_terima')
            ->join('supplier', 'pemasok_terima=id_supplier')
            ->join('gudang', 'gudang_terima=id_gudang')
            ->where('id_barang', $id)
            ->order_by('nourut_terima', 'desc')
            ->get()->result();
        $data_terima = [];
        $result_terima = [];
        foreach ($sql_terima as $sql_terima) {
            $konversi = prosesKonversi($sql_terima->satuan_brg_satuan, $sql_terima->jumlah_detail);
            $jumlah = nilaiKonversi($sql_terima->satuan_brg_satuan, $konversi['jumlah']);
            $result_terima = [
                'idterima' => (int)$sql_terima->id_terima,
                'nomor' => $sql_terima->nosurat_terima,
                'hargabeli' => currency($sql_terima->hargabeli),
                'tanggal' => format_indo($sql_terima->tanggal_terima),
                'pemasok' => $sql_terima->nama_supplier,
                'gudang' => $sql_terima->nama_gudang,
                'jumlah' => $jumlah['value'],
            ];
            $sql_stok = $this->db->from('barang')
                ->join('barang_satuan', 'id_barang=barang_brg_satuan')
                ->join('satuan', 'satuan_brg_satuan=id_satuan')
                ->join('terima_stok', 'id_brg_satuan=idsatuan_stok')
                ->where('iddetail_stok', $sql_terima->id_detail)
                ->get()->result();
            $data_stok = [];
            $result_stok = [];
            foreach ($sql_stok as $ss) {
                $stok = nilaiKonversi($ss->satuan_brg_satuan, $ss->real_stok);
                $result_stok = [
                    'satuan' => $ss->nama_satuan,
                    'stok' => $stok['jumlah'] != '0' ? $stok['value'] : COUNT_EMPTY
                ];
                $data_stok[] = $result_stok;
            }
            $result_terima['dataStokSatuan'] = $data_stok;
            $sql_harga = $this->db->from('terima_harga')
                ->join('barang_satuan', 'idsatuan_harga=id_brg_satuan')
                ->join('satuan', 'satuan_brg_satuan=id_satuan')
                ->where('iddetail_harga', $sql_terima->id_detail)
                ->get()->result();
            $data_harga = [];
            $result_harga = [];
            foreach ($sql_harga as $sh) {
                $result_harga = [
                    'idharga' => $sh->id_harga,
                    'satuan' => $sh->nama_satuan,
                    'singkatan' => $sh->singkatan_satuan,
                    'default' => $sh->status_default,
                    'aktif' => $sh->status_aktif,
                    'jumlahJual' => number_decimal($sh->nilai_satuan),
                    'harga' => $sh->jual_harga,
                    'hargaText' => currency($sh->jual_harga)
                ];
                $data_harga[] = $result_harga;
            }
            $result_terima['dataHarga'] = $data_harga;
            $data_terima[] = $result_terima;
        }
        $data['penerimaan'] = $data_terima;
        $data['produk'] = $dataProduk;
        $arr = [
            'status' => true,
            'data' => $data
        ];
        return $arr;
    }









    // Function tidak digunakan
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
