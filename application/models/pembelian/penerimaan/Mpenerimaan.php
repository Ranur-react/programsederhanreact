<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpenerimaan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pembelian/penerimaan/Mtmp_create');
        $this->load->model('pembelian/penerimaan/Mtmp_edit');
    }
    public function jumlah_data()
    {
        return $this->db->count_all_results("penerimaan");
    }
    public function tampil_data($start, $length)
    {
        $query = $this->db->query("SELECT *,(SELECT nama_supplier FROM penerimaan_supplier,permintaan,supplier WHERE id_terima=id_terima_supplier AND id_minta_supplier=id_permintaan AND supplier_permintaan=id_supplier LIMIT 1) AS nama FROM penerimaan JOIN gudang ON gudang_terima=id_gudang JOIN users ON user_terima=id_user ORDER BY id_terima DESC LIMIT $start,$length");
        return $query;
    }
    public function cari_data($search)
    {
        $query = $this->db->query("SELECT *,(SELECT nama_supplier FROM penerimaan_supplier,permintaan,supplier WHERE id_terima=id_terima_supplier AND id_minta_supplier=id_permintaan AND supplier_permintaan=id_supplier) AS nama FROM penerimaan JOIN gudang ON gudang_terima=id_gudang JOIN users ON user_terima=id_user WHERE id_terima LIKE '%$search%' ESCAPE '!' OR nama_gudang LIKE '%$search%' ESCAPE '!' OR (SELECT nama_supplier FROM penerimaan_supplier,permintaan,supplier WHERE id_terima=id_terima_supplier AND id_minta_supplier=id_permintaan AND supplier_permintaan=id_supplier) LIKE '%$search%' ESCAPE '!' ORDER BY id_terima DESC");
        return $query;
    }
    public function kode()
    {
        $query = $this->db
            ->select('id_terima', FALSE)
            ->order_by('id_terima', 'DESC')
            ->limit(1)
            ->get('penerimaan');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->id_terima) + 1;
        } else {
            $kode = 1;
        }
        return $kode;
    }
    public function store($kode, $post)
    {
        $total = $this->db->select('SUM(harga*jumlah) AS total')->where('user', id_user())->get('tmp_penerimaan')->row();
        $data_terima = [
            'id_terima' => $kode,
            'gudang_terima' => $post['gudang'],
            'tanggal_terima' => date("Y-m-d", strtotime($post['tanggal'])),
            'total_terima' => $total->total,
            'status_terima' => 0,
            'user_terima' => id_user()
        ];
        $terima = $this->db->insert('penerimaan', $data_terima);
        $data_tmp = $this->Mtmp_create->data();
        foreach ($data_tmp as $d) {
            $id_barang = $d['id_barang'];
            $data_detail = [
                'terima_detail' => $kode,
                'minta_detail' => $d['iddetail'],
                'harga_detail' => $d['harga'],
                'jumlah_detail' => $d['jumlah']
            ];
            $this->db->insert('penerimaan_detail', $data_detail);
            $id_detail_terima = $this->db->insert_id();
            $this->db->insert('harga_barang', ['terima_hrg_barang' => $id_detail_terima]);
            $id_harga = $this->db->insert_id();
            $data_satuan = $this->db->where('barang_brg_satuan', $id_barang)->get('barang_satuan')->result();
            foreach ($data_satuan as $ds) {
                $this->db->insert('harga_detail', [
                    'harga_hrg_detail' => $id_harga,
                    'satuan_hrg_detail' => $ds->id_brg_satuan,
                    'jual_hrg_detail' => 0,
                    'default_hrg_detail' => 0,
                    'aktif_hrg_detail' => 0,
                ]);
            }
        }
        $data_supplier = $this->db->from('tmp_penerimaan')->group_by('permintaan')->get()->result_array();
        foreach ($data_supplier as $s) {
            $detail_supplier = [
                'id_terima_supplier' => $kode,
                'id_minta_supplier' => $s['permintaan'],
            ];
            $this->db->insert('penerimaan_supplier', $detail_supplier);
        }
        $this->db->where('user', id_user())->delete('tmp_penerimaan');
        $this->UpdateStatusPermintaan($kode);
        return $terima;
    }
    public function UpdateStatusPermintaan($kode)
    {
        $data_supplier = $this->db->where('id_terima_supplier', $kode)->get('penerimaan_supplier')->result_array();
        foreach ($data_supplier as $ds) {
            $count_minta = $this->db->from('permintaan_detail')->where('permintaan_detail', $ds['id_minta_supplier'])->count_all_results();
            $count_terima = $this->db->from('permintaan_detail')
                ->join('penerimaan_detail', 'permintaan_detail.id_detail=minta_detail')
                ->where('permintaan_detail', $ds['id_minta_supplier'])
                ->count_all_results();
            if ($count_terima == 0) :
                $data['status_permintaan'] = 1;
            elseif ($count_terima < $count_minta) :
                $data['status_permintaan'] = 2;
            else :
                $data['status_permintaan'] = 3;
            endif;
            $this->db->where('id_permintaan', $ds['id_minta_supplier'])->update('permintaan', $data);
        }
    }
    public function show($kode)
    {
        return $this->db->from('penerimaan')
            ->join('gudang', 'gudang_terima=id_gudang')
            ->join('penerimaan_supplier', 'id_terima=id_terima_supplier')
            ->join('permintaan', 'id_minta_supplier=id_permintaan')
            ->join('supplier', 'supplier_permintaan=id_supplier')
            ->where('id_terima', $kode)
            ->limit(1)
            ->get()->row_array();
    }
    public function update($kode, $post)
    {
        $total = $this->Mtmp_edit->get_total($kode);
        $data = array(
            'gudang_terima' => $post['gudang'],
            'tanggal_terima' => date("Y-m-d", strtotime($post['tanggal'])),
            'total_terima' => $total
        );
        return $this->db->where('id_terima', $kode)->update('penerimaan', $data);
    }
    public function destroy($kode)
    {
        $data = $this->show($kode);
        if ($data['status_terima'] == 0) :
            $this->db->where('terima_detail', $kode)->delete('penerimaan_detail');
            $this->UpdateStatusPermintaan($kode);
            $this->db->where('id_terima_supplier', $kode)->delete('penerimaan_supplier');
            $this->db->where('id_terima', $kode)->delete('penerimaan');
            return '0100';
        else :
            return '0101';
        endif;
    }
}

/* End of file Mpenerimaan.php */
