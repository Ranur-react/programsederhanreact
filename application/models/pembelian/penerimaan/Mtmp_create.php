<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mtmp_create extends CI_Model
{
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
        $data = [
            'iddetail' => $post['iddetail'],
            'permintaan' => $post['idrequest'],
            'harga' => convert_uang($post['harga']),
            'jumlah' => convert_uang($post['jumlah']),
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
        $data = [
            'harga'  => convert_uang($post['harga']),
            'jumlah' => convert_uang($post['jumlah'])
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
