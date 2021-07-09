<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mtmp_create extends CI_Model
{
    public function data()
    {
        $query = $this->db->query("SELECT * FROM tmp_order JOIN harga_detail ON idhrgdetail=id_hrg_detail JOIN harga_barang ON harga_hrg_detail=id_hrg_barang JOIN penerimaan_harga ON id_hrg_barang=barang_terima_harga JOIN penerimaan_detail ON detail_terima_harga=id_detail JOIN penerimaan ON terima_detail=id_terima JOIN barang_satuan ON satuan_hrg_detail=id_brg_satuan JOIN barang ON barang_brg_satuan=id_barang JOIN satuan ON satuan_brg_satuan=id_satuan WHERE user=" . id_user() . " ORDER BY id")->result();
        $total = 0;
        $rows = array();
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
    public function getBarangDefault()
    {
        // Tampilkan semua barang dengan default harga aktif
        $sql = "SELECT * FROM barang JOIN barang_satuan ON id_barang=barang_brg_satuan JOIN harga_detail ON id_brg_satuan=satuan_hrg_detail
        WHERE status_barang=1 AND default_hrg_detail=1 GROUP BY id_barang ORDER BY nama_barang ASC";
        $query = $this->db->query($sql)->result();
        foreach ($query as $value) {
            $data[] = [
                'id' => $value->id_barang,
                'barang' => $value->nama_barang
            ];
        }
        return $data;
    }
    public function getHargaTerima($idbarang, $status)
    {
        $sql = "SELECT * FROM penerimaan JOIN penerimaan_detail ON id_terima=terima_detail JOIN penerimaan_harga ON id_detail=detail_terima_harga JOIN harga_barang ON barang_terima_harga=id_hrg_barang JOIN harga_detail ON id_hrg_barang=harga_hrg_detail JOIN barang_satuan ON satuan_hrg_detail=id_brg_satuan JOIN satuan ON satuan_brg_satuan=id_satuan WHERE barang_brg_satuan=" . (int)$idbarang;
        // Tampilkan penerimaan barang dengan harga barang default
        if ($status == 'default') :
            $sql .= " AND default_hrg_detail=1";
        endif;
        // Tampilkan penerimaan barang dengan harga barang aktif
        if ($status == 'aktif') :
            $sql .= " AND aktif_hrg_detail=1";
        endif;
        $sql .= " GROUP BY id_terima ORDER BY id_hrg_barang DESC";
        if ($status == 'default') :
            $sql .= " LIMIT 1";
        endif;
        if ($status == 'default') :
            $query = $this->db->query($sql)->row();
            $data = ['idharga' => $query->id_hrg_barang];
        endif;
        if ($status == 'aktif') :
            $query = $this->db->query($sql)->result();
            foreach ($query as $value) {
                $data[] = [
                    'idterima' => $value->id_terima,
                    'idharga' => $value->id_hrg_barang,
                    'nomor' => $value->nosurat_terima
                ];
            }
        endif;
        return $data;
    }
    public function getHarga($id_harga)
    {
        $sql = "SELECT * FROM harga_detail JOIN barang_satuan ON satuan_hrg_detail=id_brg_satuan JOIN satuan ON satuan_brg_satuan=id_satuan WHERE harga_hrg_detail=" . (int)$id_harga . " AND aktif_hrg_detail=1 ORDER BY default_hrg_detail DESC";
        $query = $this->db->query($sql)->result();
        foreach ($query as $value) {
            $data[] = [
                'idhrgdetail' => $value->id_hrg_detail,
                'nominal' => $value->jual_hrg_detail,
                'satuan' => $value->singkatan_satuan,
                'default' => $value->default_hrg_detail
            ];
        }
        return $data;
    }
    public function store($post)
    {
        $id = $post['harga'];
        $data = $this->db->where('id_hrg_detail', $id)->get('harga_detail')->row();
        $data = [
            'idhrgdetail' => $post['harga'],
            'harga'  => $data->jual_hrg_detail,
            'jumlah' => convert_uang($post['jumlah']),
            'user'   => id_user()
        ];
        return $this->db->insert('tmp_order', $data);
    }
    public function destroy($kode)
    {
        return $this->db->where('id', $kode)->delete('tmp_order');
    }
}

/* End of file Mtmp_create.php */
