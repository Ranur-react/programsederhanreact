<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpenerimaan extends CI_Model
{
    public function fetch_all()
    {
        $query_terima = $this->db->query("SELECT *,(SELECT nama_supplier FROM penerimaan_supplier,permintaan,supplier WHERE id_terima=id_terima_supplier AND id_minta_supplier=id_permintaan AND supplier_permintaan=id_supplier LIMIT 1) AS nama FROM penerimaan JOIN gudang ON gudang_terima=id_gudang JOIN users ON user_terima=id_user ORDER BY id_terima DESC")->result();
        $data = array();
        $result = array();
        foreach ($query_terima as $qt) {
            $result = [
                'nomor' => $qt->nosurat_terima,
                'tanggal' => $qt->tanggal_terima,
                'supplier' => $qt->nama,
                'gudang' => $qt->nama_gudang
            ];
            $query_produk = $this->query_produk($qt->id_terima);
            $resultProduk = array();
            $dataProduk = array();
            foreach ($query_produk as $rowProduk) {
                $resultProduk = [
                    'produk' => $rowProduk->nama_barang,
                    'satuan' => $rowProduk->nama_satuan,
                    'singkat' => $rowProduk->singkatan_satuan,
                    'harga' => $rowProduk->harga,
                    'jumlah' => $rowProduk->jumlah,
                    'total' => $rowProduk->harga * $rowProduk->jumlah
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
        return $this->db->select('*,penerimaan_detail.harga_detail AS harga,penerimaan_detail.jumlah_detail AS jumlah')
            ->from('penerimaan_detail')
            ->join('permintaan_detail', 'minta_detail=permintaan_detail.id_detail')
            ->join('barang_satuan', 'barang_detail=id_brg_satuan')
            ->join('barang', 'barang_brg_satuan=id_barang')
            ->join('satuan', 'satuan_brg_satuan=id_satuan')
            ->where('terima_detail', $id)
            ->get()->result();
    }
    public function perperiode($awal, $akhir)
    {
        $query_terima = $this->db->query("SELECT *,(SELECT nama_supplier FROM penerimaan_supplier,permintaan,supplier WHERE id_terima=id_terima_supplier AND id_minta_supplier=id_permintaan AND supplier_permintaan=id_supplier LIMIT 1) AS nama FROM penerimaan JOIN gudang ON gudang_terima=id_gudang JOIN users ON user_terima=id_user WHERE tanggal_terima BETWEEN '$awal' AND '$akhir' ORDER BY id_terima DESC")->result();
        $data = array();
        $result = array();
        foreach ($query_terima as $qt) {
            $result = [
                'nomor' => $qt->nosurat_terima,
                'tanggal' => $qt->tanggal_terima,
                'supplier' => $qt->nama,
                'gudang' => $qt->nama_gudang
            ];
            $query_produk = $this->query_produk($qt->id_terima);
            $resultProduk = array();
            $dataProduk = array();
            foreach ($query_produk as $rowProduk) {
                $resultProduk = [
                    'produk' => $rowProduk->nama_barang,
                    'satuan' => $rowProduk->nama_satuan,
                    'singkat' => $rowProduk->singkatan_satuan,
                    'harga' => $rowProduk->harga,
                    'jumlah' => $rowProduk->jumlah,
                    'total' => $rowProduk->harga * $rowProduk->jumlah
                ];
                $dataProduk[] = $resultProduk;
            }
            $result['produk'] = $dataProduk;
            $data[] = $result;
        }
        return $data;
    }
    public function perbulan($bulan, $tahun)
    {
        $query_terima = $this->db->query("SELECT *,(SELECT nama_supplier FROM penerimaan_supplier,permintaan,supplier WHERE id_terima=id_terima_supplier AND id_minta_supplier=id_permintaan AND supplier_permintaan=id_supplier LIMIT 1) AS nama FROM penerimaan JOIN gudang ON gudang_terima=id_gudang JOIN users ON user_terima=id_user WHERE DATE_FORMAT(tanggal_terima,'%c')='$bulan' AND DATE_FORMAT(tanggal_terima,'%Y')='$tahun' ORDER BY id_terima DESC")->result();
        $data = array();
        $result = array();
        foreach ($query_terima as $qt) {
            $result = [
                'nomor' => $qt->nosurat_terima,
                'tanggal' => $qt->tanggal_terima,
                'supplier' => $qt->nama,
                'gudang' => $qt->nama_gudang
            ];
            $query_produk = $this->query_produk($qt->id_terima);
            $resultProduk = array();
            $dataProduk = array();
            foreach ($query_produk as $rowProduk) {
                $resultProduk = [
                    'produk' => $rowProduk->nama_barang,
                    'satuan' => $rowProduk->nama_satuan,
                    'singkat' => $rowProduk->singkatan_satuan,
                    'harga' => $rowProduk->harga,
                    'jumlah' => $rowProduk->jumlah,
                    'total' => $rowProduk->harga * $rowProduk->jumlah
                ];
                $dataProduk[] = $resultProduk;
            }
            $result['produk'] = $dataProduk;
            $data[] = $result;
        }
        return $data;
    }
}

/* End of file Mpenerimaan.php */
