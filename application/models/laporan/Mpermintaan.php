<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpermintaan extends CI_Model
{
    public function fetch_all()
    {
        $query_minta = $this->db->from('permintaan')
            ->join('supplier', 'supplier_permintaan=id_supplier')
            ->order_by('id_permintaan', 'desc')
            ->get()->result();
        $data = array();
        $result = array();
        foreach ($query_minta as $qm) {
            $result = [
                'nomor' => $qm->nosurat_permintaan,
                'tanggal' => $qm->tanggal_permintaan,
                'supplier' => $qm->nama_supplier
            ];
            $query_produk = $this->query_produk($qm->id_permintaan);
            $resultProduk = array();
            $dataProduk = array();
            foreach ($query_produk as $rowProduk) {
                $resultProduk = [
                    'produk' => $rowProduk->nama_barang,
                    'satuan' => $rowProduk->nama_satuan,
                    'singkat' => $rowProduk->singkatan_satuan,
                    'harga' => $rowProduk->harga_detail,
                    'jumlah' => $rowProduk->jumlah_detail,
                    'total' => $rowProduk->harga_detail * $rowProduk->jumlah_detail
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
        return $this->db->from('permintaan_detail')
            ->join('barang_satuan', 'barang_detail=id_brg_satuan')
            ->join('barang', 'barang_brg_satuan=id_barang')
            ->join('satuan', 'satuan_brg_satuan=id_satuan')
            ->where('permintaan_detail', $id)
            ->get()->result();
    }
    public function perperiode($awal, $akhir)
    {
        $query_minta = $this->db->from('permintaan')
            ->join('supplier', 'supplier_permintaan=id_supplier')
            ->where("tanggal_permintaan BETWEEN '$awal' AND '$akhir'")
            ->order_by('id_permintaan', 'desc')
            ->get()->result();
        $data = array();
        $result = array();
        foreach ($query_minta as $qm) {
            $result = [
                'nomor' => $qm->nosurat_permintaan,
                'tanggal' => $qm->tanggal_permintaan,
                'supplier' => $qm->nama_supplier
            ];
            $query_produk = $this->query_produk($qm->id_permintaan);
            $resultProduk = array();
            $dataProduk = array();
            foreach ($query_produk as $rowProduk) {
                $resultProduk = [
                    'produk' => $rowProduk->nama_barang,
                    'satuan' => $rowProduk->nama_satuan,
                    'singkat' => $rowProduk->singkatan_satuan,
                    'harga' => $rowProduk->harga_detail,
                    'jumlah' => $rowProduk->jumlah_detail,
                    'total' => $rowProduk->harga_detail * $rowProduk->jumlah_detail
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
        $query_minta = $this->db->from('permintaan')
            ->join('supplier', 'supplier_permintaan=id_supplier')
            ->where("DATE_FORMAT(tanggal_permintaan,'%c')='$bulan' AND DATE_FORMAT(tanggal_permintaan,'%Y')='$tahun'")
            ->order_by('id_permintaan', 'desc')
            ->get()->result();
        $data = array();
        $result = array();
        foreach ($query_minta as $qm) {
            $result = [
                'nomor' => $qm->nosurat_permintaan,
                'tanggal' => $qm->tanggal_permintaan,
                'supplier' => $qm->nama_supplier
            ];
            $query_produk = $this->query_produk($qm->id_permintaan);
            $resultProduk = array();
            $dataProduk = array();
            foreach ($query_produk as $rowProduk) {
                $resultProduk = [
                    'produk' => $rowProduk->nama_barang,
                    'satuan' => $rowProduk->nama_satuan,
                    'singkat' => $rowProduk->singkatan_satuan,
                    'harga' => $rowProduk->harga_detail,
                    'jumlah' => $rowProduk->jumlah_detail,
                    'total' => $rowProduk->harga_detail * $rowProduk->jumlah_detail
                ];
                $dataProduk[] = $resultProduk;
            }
            $result['produk'] = $dataProduk;
            $data[] = $result;
        }
        return $data;
    }
}

/* End of file Mpermintaan.php */
