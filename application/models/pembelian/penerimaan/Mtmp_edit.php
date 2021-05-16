<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mtmp_edit extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pembelian/penerimaan/Mpenerimaan');
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
    public function data_tmp($kode)
    {
        return $this->db->select('*,penerimaan_detail.id_detail AS id_detail_terima,penerimaan_detail.harga_detail AS harga_terima,penerimaan_detail.jumlah_detail AS jumlah_terima')
            ->from('penerimaan_detail')
            ->join('permintaan_detail', 'minta_detail=permintaan_detail.id_detail')
            ->join('barang_satuan', 'barang_detail=id_brg_satuan')
            ->join('barang', 'barang_brg_satuan=id_barang')
            ->join('satuan', 'satuan_brg_satuan=id_satuan')
            ->where('terima_detail', $kode)
            ->order_by('penerimaan_detail.id_detail', 'ASC')
            ->get()->result_array();
    }
    public function show($kode)
    {
        return $this->db->select('terima_detail,permintaan_detail.permintaan_detail AS id_minta,nama_barang,nama_satuan,singkatan_satuan,penerimaan_detail.id_detail AS id_detail_terima,penerimaan_detail.harga_detail AS harga_terima,penerimaan_detail.jumlah_detail AS jumlah_terima,permintaan_detail.harga_detail AS harga_minta,permintaan_detail.jumlah_detail AS jumlah_minta')
            ->from('penerimaan_detail')
            ->join('permintaan_detail', 'minta_detail=permintaan_detail.id_detail')
            ->join('barang_satuan', 'barang_detail=id_brg_satuan')
            ->join('barang', 'barang_brg_satuan=id_barang')
            ->join('satuan', 'satuan_brg_satuan=id_satuan')
            ->where('penerimaan_detail.id_detail', $kode)
            ->get()->row_array();
    }
    public function get_total($kode)
    {
        $query = $this->db->select('IFNULL(SUM(harga_detail*jumlah_detail),0) AS total')->where('terima_detail', $kode)->get('penerimaan_detail')->row();
        return $query->total;
    }
    public function update_total($kode)
    {
        $total = $this->get_total($kode);
        $data = array(
            'total_terima' => $total
        );
        return $this->db->where('id_terima', $kode)->update('penerimaan', $data);
    }
    public function store($post)
    {
        $idterima = $post['idterima'];
        $terima = $this->Mpenerimaan->show($idterima);
        $barang = $this->show_minta($post['iddetail']);
        $query = $this->db->from('penerimaan_supplier')->where(['id_terima_supplier' => $idterima, 'id_minta_supplier' => $post['idminta']])->count_all_results();
        if ($query == 0) {
            $this->db->insert('penerimaan_supplier', ['id_terima_supplier' => $idterima, 'id_minta_supplier' => $post['idminta']]);
        }
        $data = [
            'terima_detail' => $idterima,
            'minta_detail' => $post['iddetail'],
            'harga_detail' => convert_uang($post['harga']),
            'jumlah_detail' => convert_uang($post['jumlah'])
        ];
        $this->db->insert('penerimaan_detail', $data);
        $id_detail_terima = $this->db->insert_id();
        $this->db->insert('harga_barang', [
            'tanggal_hrg_barang' => $terima['tanggal_terima']
        ]);
        $id_harga = $this->db->insert_id();
        $this->db->insert('penerimaan_harga', [
            'detail_terima_harga' => $id_detail_terima,
            'barang_terima_harga' => $id_harga
        ]);
        $data_satuan = $this->db->where('barang_brg_satuan', $barang['id_barang'])->get('barang_satuan')->result();
        foreach ($data_satuan as $ds) {
            $this->db->insert('harga_detail', [
                'harga_hrg_detail' => $id_harga,
                'satuan_hrg_detail' => $ds->id_brg_satuan,
                'jual_hrg_detail' => 0,
                'default_hrg_detail' => 0,
                'aktif_hrg_detail' => 0,
            ]);
        }
        $this->update_total($idterima);
        $this->Mpenerimaan->UpdateStatusPermintaan($idterima);
        return true;
    }
    public function update($post)
    {
        $data = $this->show($post['iddetail']);
        $kode = $data['terima_detail'];
        $data = [
            'harga_detail'  => convert_uang($post['harga']),
            'jumlah_detail' => convert_uang($post['jumlah'])
        ];
        $query = $this->db->where('id_detail', $post['iddetail'])->update('penerimaan_detail', $data);
        $this->update_total($kode);
        return $query;
    }
    public function destroy($kode)
    {
        $data = $this->show($kode);
        $idterima = $data['terima_detail'];
        $idminta = $data['id_minta'];
        $check = $this->db->from('permintaan_detail')
            ->join('penerimaan_detail', 'permintaan_detail.id_detail=minta_detail')
            ->where(['permintaan_detail' => $idminta, 'terima_detail' => $idterima])
            ->where_not_in('penerimaan_detail.id_detail', $kode)
            ->count_all_results();
        if ($check > 0) :
            $this->db->where('id_detail', $kode)->delete('penerimaan_detail');
            $this->Mpenerimaan->UpdateStatusPermintaan($idterima);
            $status = '0100';
        else :
            $this->db->where('id_detail', $kode)->delete('penerimaan_detail');
            $this->Mpenerimaan->UpdateStatusPermintaan($idterima);
            $this->db->where(['id_terima_supplier' => $idterima, 'id_minta_supplier' => $idminta])->delete('penerimaan_supplier');
            $status = '0100';
        endif;
        $this->update_total($idterima);
        return $status;
    }
}

/* End of file Mtmp_edit.php */
