<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mtmp_create extends CI_Model
{
    public function jumlah_data()
    {
        return $this->db->from('permintaan')
            ->where_in('status_permintaan', array(1, 2))
            ->count_all_results();
    }
    public function tampil_data($start, $length)
    {
        $sql = $this->db->from('permintaan')
            ->join('supplier', 'supplier_permintaan=id_supplier')
            ->join('users', 'user_permintaan=id_user')
            ->where_in('status_permintaan', array(1, 2))
            ->order_by('id_permintaan', 'DESC')
            ->limit($length, $start)
            ->get();
        return $sql;
    }
    public function cari_data($search)
    {
        $sql = $this->db->from('permintaan')
            ->join('supplier', 'supplier_permintaan=id_supplier')
            ->join('users', 'user_permintaan=id_user')
            ->where_in('status_permintaan', array(1, 2))
            ->order_by('id_permintaan', 'DESC')
            ->like('nosurat_permintaan', $search)
            ->or_like('nama_supplier', $search)
            ->get();
        return $sql;
    }
    public function check_permintaan($kode)
    {
        $check_data = $this->db->from('tmp_penerimaan')->where('user', id_user())->count_all_results();
        if ($check_data > 0) :
            $data = $this->db->where('id_permintaan', $kode)->get('permintaan')->row_array();
            $query = $this->db->from('tmp_penerimaan')
                ->join('permintaan', 'permintaan=id_permintaan')
                ->where(['user' => id_user(), 'supplier_permintaan' => $data['supplier_permintaan']])
                ->count_all_results();
            if ($query > 0) :
                $status = '0100';
            else :
                $status = '0101';
            endif;
        else :
            $status = '0100';
        endif;
        return $status;
    }
    public function data()
    {
        return $this->db->from('tmp_penerimaan')
            ->join('permintaan_detail', 'iddetail=id_detail')
            ->join('barang_satuan', 'barang_detail=id_brg_satuan')
            ->join('barang', 'barang_brg_satuan=id_barang')
            ->join('satuan', 'satuan_brg_satuan=id_satuan')
            ->where('user', id_user())
            ->order_by('id')
            ->get()->result_array();
    }
    public function store($post)
    {
        $data = [
            'iddetail' => $post['iddetail'],
            'permintaan' => $post['permintaan'],
            'harga'  => convert_uang($post['harga']),
            'jumlah' => convert_uang($post['jumlah']),
            'user'   => id_user()
        ];
        return $this->db->insert('tmp_penerimaan', $data);
    }
    public function show($kode)
    {
        return $this->db->from('tmp_penerimaan')
            ->join('permintaan_detail', 'iddetail=id_detail')
            ->join('barang_satuan', 'barang_detail=id_brg_satuan')
            ->join('barang', 'barang_brg_satuan=id_barang')
            ->join('satuan', 'satuan_brg_satuan=id_satuan')
            ->where('iddetail', $kode)
            ->get()->row_array();
    }
    public function update($post)
    {
        $data = [
            'harga'  => convert_uang($post['harga']),
            'jumlah' => convert_uang($post['jumlah'])
        ];
        return $this->db->where(['iddetail' => $post['iddetail'], 'user' => id_user()])->update('tmp_penerimaan', $data);
    }
    public function destroy($kode)
    {
        return $this->db->where(['iddetail' => $kode, 'user' => id_user()])->delete('tmp_penerimaan');
    }
    public function batal()
    {
        return $this->db->where('user', id_user())->delete('tmp_penerimaan');
    }
}

/* End of file Mtmp_create.php */
