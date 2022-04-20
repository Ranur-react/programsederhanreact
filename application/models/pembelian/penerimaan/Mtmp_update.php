<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mtmp_update extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pembelian/penerimaan/Mpenerimaan');
        $this->load->model('pembelian/penerimaan/Mtmp_permintaan');
    }
    public function get_total($id = null)
    {
        $query = $this->db->select('IFNULL(SUM(harga_detail*jumlah_detail),0) AS total')->where('terima_detail', $id)->get('terima_detail')->row();
        return $query->total;
    }
    public function update_total($id = null)
    {
        $total = $this->get_total($id);
        $data = array(
            'total_terima' => $total
        );
        return $this->db->where('id_terima', $id)->update('terima', $data);
    }
    public function store($post)
    {
        $idterima = $post['idterima'];
        $iddetail = $post['iddetail'];
        $jumlah = hapus_desimal($post['jumlah']);
        $sql_request = $this->Mtmp_permintaan->show($iddetail);
        $konversi = prosesKonversi($sql_request['id_satuan'], $jumlah);
        $data = [
            'terima_detail' => $idterima,
            'minta_detail' => $iddetail,
            'harga_detail' => hapus_desimal($post['harga']),
            'jumlah_detail' => $jumlah
        ];
        $this->db->insert('terima_detail', $data);
        $id_detail_terima = $this->db->insert_id();
        $sql_produk = $this->show($id_detail_terima);
        $this->db->insert('terima_stok', [
            'iddetail_stok' => $id_detail_terima,
            'idsatuan_stok' => $sql_produk['id_brg_satuan'],
            'jumlah_stok' => $jumlah,
            'convert_stok' => $konversi['jumlah'],
            'real_stok' => $konversi['jumlah']
        ]);
        $data_satuan = $this->db->where('barang_brg_satuan', $sql_request['id_barang'])->get('barang_satuan')->result();
        foreach ($data_satuan as $ds) {
            $this->db->insert('terima_harga', [
                'iddetail_harga' => $id_detail_terima,
                'idsatuan_harga' => $ds->id_brg_satuan,
                'nilai_satuan' => 0,
                'jual_harga' => 0,
                'status_default' => 0,
                'status_aktif' => 0,
            ]);
        }
        $this->update_total($idterima);
        $this->Mpenerimaan->UpdateStatusRequest($idterima);
        return true;
    }
    public function show($id = null)
    {
        return $this->db->select('*,permintaan_detail.id_detail as iddetailminta,permintaan_detail.harga_detail as harga_minta,permintaan_detail.jumlah_detail as jumlah_minta,terima_detail.id_detail as iddetailterima,terima_detail.harga_detail as harga_terima,terima_detail.jumlah_detail as jumlah_terima')
            ->from('terima_detail')
            ->join('permintaan_detail', 'minta_detail=permintaan_detail.id_detail')
            ->join('barang_satuan', 'barang_detail=id_brg_satuan')
            ->join('barang', 'barang_brg_satuan=id_barang')
            ->join('satuan', 'satuan_brg_satuan=id_satuan')
            ->where('terima_detail.id_detail', $id)
            ->get()->row_array();
    }
    public function update($post)
    {
        $iddetailterima = $post['iddetailterima'];
        $data = $this->show($iddetailterima);
        $idterima = $data['terima_detail'];
        $jumlah = hapus_desimal($post['jumlah']);
        $konversi = prosesKonversi($data['id_satuan'], $jumlah);
        $cek_data = $this->db->where(['iddetail_stok' => $iddetailterima, 'idsatuan_stok' => $data['id_brg_satuan']])->get('terima_stok')->row_array();
        if ($cek_data['convert_stok'] > $cek_data['real_stok']) :
            $arr = [
                'status' => false,
                'msg' => 'Produk gagal dirubah karena stok menjadi minus'
            ];
        else :
            $data_produk = [
                'harga_detail'  => hapus_desimal($post['harga']),
                'jumlah_detail' => $jumlah
            ];
            $this->db->where('id_detail', $iddetailterima)->update('terima_detail', $data_produk);
            $data_stok = [
                'jumlah_stok' => $jumlah,
                'convert_stok' => $konversi['jumlah'],
                'real_stok' => $konversi['jumlah']
            ];
            $this->db->where('iddetail_stok', $iddetailterima)->update('terima_stok', $data_stok);
            $this->update_total($idterima);
            $arr = [
                'status' => true,
                'msg' => 'Produk berhasil dirubah'
            ];
        endif;
        return $arr;
    }
    public function destroy($id)
    {
        $cek_stok = $this->db->select('terima_detail,SUM(convert_stok) AS stok_awal, SUM(real_stok) AS stok_akhir')
            ->from('terima_stok')
            ->join('terima_detail', 'iddetail_stok=id_detail')
            ->where('iddetail_stok', $id)
            ->get()->row_array();
        $idterima = $cek_stok['terima_detail'];
        if ($cek_stok['stok_awal'] > $cek_stok['stok_akhir']) :
            $arr = [
                'status' => false,
                'msg' => 'Produk gagal dihapus karena stok menjadi minus'
            ];
        else :
            $this->db->where('iddetail_stok', $id)->delete('terima_stok');
            $this->db->where('iddetail_harga', $id)->delete('terima_harga');
            $this->db->where('id_detail', $id)->delete('terima_detail');
            $this->Mpenerimaan->UpdateStatusRequest($idterima);
            $this->update_total($idterima);
            $arr = [
                'status' => true,
                'msg' => 'Produk berhasil dihapus'
            ];
        endif;
        return $arr;
    }




    public function data_supplier($kode)
    {
        return $this->db->from('penerimaan_supplier')
            ->join('permintaan', 'id_minta_supplier=id_permintaan')
            ->join('supplier', 'supplier_permintaan=id_supplier')
            ->where('id_terima_supplier', $kode)
            ->get()->result_array();
    }
    public function check_permintaan($id_terima, $id_minta)
    {
        $check_data = $this->db->from('penerimaan_supplier')->where(['id_terima_supplier' => $id_terima, 'id_minta_supplier' => $id_minta])->count_all_results();
        if ($check_data > 0) :
            $status = '0102';
        else :
            $data = $this->db->where('id_permintaan', $id_minta)->get('permintaan')->row_array();
            $query = $this->db->from('penerimaan_supplier')
                ->join('permintaan', 'id_minta_supplier=id_permintaan')
                ->where(['id_terima_supplier' => $id_terima, 'supplier_permintaan' => $data['supplier_permintaan']])
                ->count_all_results();
            if ($query > 0) :
                $status = '0100';
            else :
                $status = '0101';
            endif;
        endif;
        return $status;
    }
    public function show_minta($id_detail)
    {
        return $this->db->from('permintaan_detail')
            ->join('barang_satuan', 'barang_detail=id_brg_satuan')
            ->join('barang', 'barang_brg_satuan=id_barang')
            ->join('satuan', 'satuan_brg_satuan=id_satuan')
            ->where('id_detail', $id_detail)
            ->get()->row_array();
    }
    public function data_harga($kode)
    {
        return $this->db->from('penerimaan_detail')
            ->join('penerimaan_harga', 'id_detail=detail_terima_harga')
            ->join('harga_barang', 'barang_terima_harga=id_hrg_barang')
            ->where('terima_detail', $kode)
            ->get()->result();
    }
}

/* End of file Mtmp_update.php */
