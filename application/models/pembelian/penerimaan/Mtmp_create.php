<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mtmp_create extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pembelian/penerimaan/Mtmp_permintaan');
    }
    public function fetch_all()
    {
        return $this->db->from('tmp_penerimaan')
            ->join('permintaan_detail', 'iddetail=id_detail')
            ->join('barang_satuan', 'barang_detail=id_brg_satuan')
            ->join('barang', 'barang_brg_satuan=id_barang')
            ->join('satuan', 'satuan_brg_satuan=id_satuan')
            ->where('user', id_user())
            ->order_by('id')
            ->get()->result();
    }
    public function store($post)
    {
        $jumlah = hapus_desimal($post['jumlah']);
        $sql_request = $this->Mtmp_permintaan->show($post['iddetail']);
        $konversi = prosesKonversi($sql_request['id_satuan'], $jumlah);
        $data = [
            'iddetail' => $post['iddetail'],
            'permintaan' => $post['idrequest'],
            'harga' => hapus_desimal($post['harga']),
            'jumlah' => $jumlah,
            'stok' => $konversi['jumlah'],
            'user' => id_user()
        ];
        return $this->db->insert('tmp_penerimaan', $data);
    }
    public function show($id = null)
    {
        return $this->db->from('tmp_penerimaan')
            ->join('permintaan_detail', 'iddetail=id_detail')
            ->join('barang_satuan', 'barang_detail=id_brg_satuan')
            ->join('barang', 'barang_brg_satuan=id_barang')
            ->join('satuan', 'satuan_brg_satuan=id_satuan')
            ->where('id', $id)
            ->get()->row_array();
    }
    public function update($post)
    {
        $jumlah = hapus_desimal($post['jumlah']);
        $result = $this->show($post['id']);
        $sql_request = $this->Mtmp_permintaan->show($result['iddetail']);
        $konversi = prosesKonversi($sql_request['id_satuan'], $jumlah);
        $data = [
            'harga'  => hapus_desimal($post['harga']),
            'jumlah' => $jumlah,
            'stok' => $konversi['jumlah']
        ];
        return $this->db->where(['id' => $post['id'], 'user' => id_user()])->update('tmp_penerimaan', $data);
    }
    public function destroy($id)
    {
        return $this->db->where(['id' => $id, 'user' => id_user()])->delete('tmp_penerimaan');
    }
    public function batal()
    {
        return $this->db->where('user', id_user())->delete('tmp_penerimaan');
    }
}

/* End of file Mtmp_create.php */
