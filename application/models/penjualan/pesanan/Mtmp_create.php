<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mtmp_create extends CI_Model
{
    public function data()
    {
        $query = $this->db->query("SELECT * FROM tmp_order JOIN harga_detail ON idhrgdetail=id_hrg_detail JOIN harga_barang ON harga_hrg_detail=id_hrg_barang JOIN penerimaan_harga ON id_hrg_barang=barang_terima_harga JOIN penerimaan_detail ON detail_terima_harga=id_detail JOIN penerimaan ON terima_detail=id_terima JOIN barang_satuan ON satuan_hrg_detail=id_brg_satuan JOIN barang ON barang_brg_satuan=id_barang JOIN satuan ON satuan_brg_satuan=id_satuan WHERE user=" . id_user() . " ORDER BY id")->result();
        $total = 0;
        foreach ($query as $value) {
            $total = $total + ($value->harga * $value->jumlah);
            $result = [
                'id' => $value->id,
                'barang' => $value->nama_barang,
                'nomor' => $value->nosurat_terima,
                'tanggal' => $value->tanggal_terima,
                'harga' => $value->harga,
                'jumlah' => $value->jumlah,
                'satuan' => $value->singkatan_satuan,
                'total' => $value->harga * $value->jumlah
            ];
            $rows[] = $result;
        }
        $data['data'] = $rows;
        $data['total'] = $total;
        return $data;
    }
}

/* End of file Mtmp_create.php */
