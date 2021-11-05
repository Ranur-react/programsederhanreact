<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpermintaan extends CI_Model
{
    var $tabel = 'permintaan';
    var $id = 'id_permintaan';
    var $column_order = array(null, 'nosurat_permintaan', 'tanggal_permintaan');
    var $column_search = array('nosurat_permintaan');
    var $order = array('id_permintaan' => 'DESC');

    public function __construct()
    {
        parent::__construct();
        $this->load->model('pembelian/permintaan/Mtmp_create');
        $this->load->model('pembelian/permintaan/Mtmp_edit');
    }
    private function _get_data_query()
    {
        $this->db->from($this->tabel)->join('users', 'user_permintaan=id_user');
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_GET['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_GET['search']['value']);
                } else {
                    $this->db->or_like($item, $_GET['search']['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_GET['order'])) {
            $this->db->order_by($this->column_order[$_GET['order']['0']['column']], $_GET['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function fetch_all()
    {
        $this->_get_data_query();
        if ($_GET['length'] != -1)
            $this->db->limit($_GET['length'], $_GET['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtered()
    {
        $this->_get_data_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_all()
    {
        $this->db->from($this->tabel);
        return $this->db->count_all_results();
    }
    public function kode()
    {
        $query = $this->db
            ->select('id_permintaan', FALSE)
            ->order_by('id_permintaan', 'DESC')
            ->limit(1)
            ->get('permintaan');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->id_permintaan) + 1;
        } else {
            $kode = 1;
        }
        return $kode;
    }
    public function nosurat()
    {
        $query = $this->db->query("SELECT nourut_permintaan FROM permintaan WHERE DATE_FORMAT(tanggal_permintaan,'%Y-%m') = DATE_FORMAT(NOW(),'%Y-%m') ORDER BY nourut_permintaan DESC LIMIT 1");
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $nourut = intval($data->nourut_permintaan) + 1;
            $array = array(
                'nourut' => $nourut,
                'nosurat' => zerobefore($nourut) . '/PO/BM/' . KonDecRomawi(date('n')) . '/' . format_tahun(date("Y-m-d"))
            );
        } else {
            $nourut = 1;
            $array = array(
                'nourut' => $nourut,
                'nosurat' => zerobefore($nourut) . '/PO/BM/' . KonDecRomawi(date('n')) . '/' . format_tahun(date("Y-m-d"))
            );
        }
        return $array;
    }
    public function store($kode, $post)
    {
        $nosurat = $this->nosurat();
        $total = $this->db->select('SUM(harga*jumlah) AS total')->where('user', id_user())->get('tmp_permintaan')->row();
        $data_permintaan = [
            'id_permintaan' => $kode,
            'nourut_permintaan' => $nosurat['nourut'],
            'nosurat_permintaan' => $nosurat['nosurat'],
            'tanggal_permintaan' => date("Y-m-d", strtotime($post['tanggal'])),
            'total_permintaan' => $total->total,
            'status_permintaan' => 1,
            'user_permintaan' => id_user()
        ];
        $permintaan = $this->db->insert('permintaan', $data_permintaan);
        $data_tmp = $this->Mtmp_create->tampil_data();
        foreach ($data_tmp as $d) {
            $data_detail = [
                'permintaan_detail' => $kode,
                'barang_detail' => $d->satuan,
                'harga_detail' => $d->harga,
                'jumlah_detail' => $d->jumlah
            ];
            $this->db->insert('permintaan_detail', $data_detail);
        }
        $hapus_tmp = $this->db->where('user', id_user())->delete('tmp_permintaan');
        return array($permintaan, $hapus_tmp);
    }
    public function show($id = null)
    {
        $sql = $this->db->from('permintaan')
            ->join('users', 'user_permintaan=id_user')
            ->where('id_permintaan', $id)
            ->get()->row();
        if ($sql == null) :
            $data['status'] = false;
        else :
            $data = [
                'status' => true,
                'id' => (int)$sql->id_permintaan,
                'nomor' => $sql->nosurat_permintaan,
                'tanggal' => $sql->tanggal_permintaan,
                'tanggal_format' => format_indo($sql->tanggal_permintaan),
                'tanggal_date' => format_biasa($sql->tanggal_permintaan),
                'status_label' => status_label($sql->status_permintaan, 'permintaan'),
                'user' => $sql->nama_user
            ];
            $queryProduk = $this->db->from('permintaan_detail')
                ->join('barang_satuan', 'barang_detail=id_brg_satuan')
                ->join('barang', 'barang_brg_satuan=id_barang')
                ->join('satuan', 'satuan_brg_satuan=id_satuan')
                ->where('permintaan_detail', $sql->id_permintaan)
                ->order_by('id_detail')
                ->get()->result();
            $result_produk = array();
            $dataProduk = array();
            $total = 0;
            foreach ($queryProduk as $qp) {
                $count_terima = $this->db->from('permintaan_detail')->join('terima_detail', 'permintaan_detail.id_detail=minta_detail')->where('permintaan_detail.id_detail', $qp->id_detail)->count_all_results();
                $subtotal = $qp->harga_detail * $qp->jumlah_detail;
                $total = $total + $subtotal;
                $result_produk = [
                    'iddetail' => (int)$qp->id_detail,
                    'produk' => $qp->nama_barang,
                    'satuan' => $qp->nama_satuan,
                    'singkatan' => $qp->singkatan_satuan,
                    'harga' => (int)$qp->harga_detail,
                    'hargaText' => currency($qp->harga_detail),
                    'jumlah' => (int)$qp->jumlah_detail,
                    'jumlahText' => number_decimal($qp->jumlah_detail),
                    'jumlahProduk' => number_decimal($qp->jumlah_detail) . ' ' . $qp->singkatan_satuan,
                    'total' => $subtotal,
                    'totalText' => currency($subtotal),
                    'statusTerima' => $count_terima
                ];
                $dataProduk[] = $result_produk;
            }
            $data['dataProduk'] = $dataProduk;
            $data['total'] = $total;
            $data['totalText'] = currency($total);
        endif;
        return $data;
    }
    public function update($kode, $post)
    {
        $total = $this->Mtmp_edit->get_total($kode);
        $data = array(
            'tanggal_permintaan' => date("Y-m-d", strtotime($post['tanggal'])),
            'total_permintaan' => $total
        );
        return $this->db->where('id_permintaan', $kode)->update('permintaan', $data);
    }
    public function destroy($kode)
    {
        $data = $this->show($kode);
        if ($data['status'] == 1) :
            $this->db->where('permintaan_detail', $kode)->delete('permintaan_detail');
            $this->db->where('id_permintaan', $kode)->delete('permintaan');
            return "0100";
        else :
            return "0101";
        endif;
    }
}

/* End of file Mpermintaan.php */
