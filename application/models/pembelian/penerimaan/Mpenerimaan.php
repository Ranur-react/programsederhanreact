<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpenerimaan extends CI_Model
{
    var $tabel = 'terima';
    var $id = 'id_terima';
    var $column_order = array(null, 'nosurat_terima', 'tanggal_terima');
    var $column_search = array('nosurat_terima', 'nama_supplier', 'nama_gudang');
    var $order = array('id_terima' => 'DESC');

    public function __construct()
    {
        parent::__construct();
        $this->load->model('pembelian/penerimaan/Mtmp_create');
        $this->load->model('pembelian/penerimaan/Mtmp_edit');
    }
    private function _get_data_query()
    {
        $this->db->from($this->tabel)
            ->join('supplier', 'pemasok_terima=id_supplier')
            ->join('gudang', 'gudang_terima=id_gudang')
            ->join('users', 'user_terima=id_user');
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
    public function fetch_all()
    {
        $this->_get_data_query();
        if ($_GET['length'] != -1)
            $this->db->limit($_GET['length'], $_GET['start']);
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered()
    {
        $this->_get_data_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all()
    {
        $this->db->from($this->tabel);
        return $this->db->count_all_results();
    }
    public function kode()
    {
        $query = $this->db
            ->select('id_terima', FALSE)
            ->order_by('id_terima', 'DESC')
            ->limit(1)
            ->get('terima');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->id_terima) + 1;
        } else {
            $kode = 1;
        }
        return $kode;
    }
    public function nosurat()
    {
        $query = $this->db->query("SELECT nourut_terima FROM terima WHERE DATE_FORMAT(tanggal_terima,'%Y-%m') = DATE_FORMAT(NOW(),'%Y-%m') ORDER BY nourut_terima DESC LIMIT 1");
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $nourut = intval($data->nourut_terima) + 1;
            $array = array(
                'nourut' => $nourut,
                'nosurat' => zerobefore($nourut) . '/DO/BM/' . KonDecRomawi(date('n')) . '/' . format_tahun(date("Y-m-d"))
            );
        } else {
            $nourut = 1;
            $array = array(
                'nourut' => $nourut,
                'nosurat' => zerobefore($nourut) . '/DO/BM/' . KonDecRomawi(date('n')) . '/' . format_tahun(date("Y-m-d"))
            );
        }
        return $array;
    }
    public function store($kode, $post)
    {
        $nosurat = $this->nosurat();
        $total = $this->db->select('SUM(harga*jumlah) AS total')->where('user', id_user())->get('tmp_penerimaan')->row();
        $data_terima = [
            'id_terima' => $kode,
            'nourut_terima' => $nosurat['nourut'],
            'nosurat_terima' => $nosurat['nosurat'],
            'pemasok_terima' => $post['pemasok'],
            'gudang_terima' => $post['gudang'],
            'tanggal_terima' => date("Y-m-d", strtotime($post['tanggal'])),
            'total_terima' => $total->total,
            'status_terima' => 0,
            'user_terima' => id_user()
        ];
        $this->db->insert('terima', $data_terima);
        $data_tmp = $this->Mtmp_create->fetch_all();
        foreach ($data_tmp as $d) {
            $id_barang = $d->id_barang;
            $data_detail = [
                'terima_detail' => $kode,
                'minta_detail' => $d->iddetail,
                'harga_detail' => $d->harga,
                'jumlah_detail' => $d->jumlah
            ];
            $this->db->insert('terima_detail', $data_detail);
            $id_detail_terima = $this->db->insert_id();
            $this->db->insert('terima_stok', [
                'iddetail_stok' => $id_detail_terima,
                'idsatuan_stok' => $d->id_brg_satuan,
                'jumlah_stok' => $d->jumlah,
                'convert_stok' => $d->stok,
                'real_stok' => $d->stok
            ]);
            $data_satuan = $this->db->where('barang_brg_satuan', $id_barang)->get('barang_satuan')->result();
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
        }
        $data_pemasok = $this->db->from('tmp_penerimaan')->where('user', id_user())->group_by('permintaan')->get()->result_array();
        foreach ($data_pemasok as $s) {
            $detail_supplier = [
                'idterima' => $kode,
                'idrequest' => $s['permintaan'],
            ];
            $this->db->insert('terima_request', $detail_supplier);
        }
        $this->db->where('user', id_user())->delete('tmp_penerimaan');
        $this->UpdateStatusRequest($kode);
        return true;
    }
    public function UpdateStatusRequest($id = null)
    {
        $data_pemasok = $this->db->where('idterima', $id)->get('terima_request')->result_array();
        foreach ($data_pemasok as $dp) {
            $count_minta = $this->db->from('permintaan_detail')->where('permintaan_detail', $dp['idrequest'])->count_all_results();
            $count_terima = $this->db->from('permintaan_detail')
                ->join('terima_detail', 'permintaan_detail.id_detail=minta_detail')
                ->where('permintaan_detail', $dp['idrequest'])
                ->count_all_results();
            if ($count_terima == 0) :
                $data['status_permintaan'] = 1;
            elseif ($count_terima < $count_minta) :
                $data['status_permintaan'] = 2;
            else :
                $data['status_permintaan'] = 3;
            endif;
            $this->db->where('id_permintaan', $dp['idrequest'])->update('permintaan', $data);
        }
    }
    public function show($id = null)
    {
        $sql = $this->db->from('terima')
            ->join('supplier', 'pemasok_terima=id_supplier')
            ->join('gudang', 'gudang_terima=id_gudang')
            ->join('users', 'user_terima=id_user')
            ->where('id_terima', $id)
            ->get()->row();
        if ($sql != null) :
            $data = [
                'info' => true,
                'idterima' => (int)$sql->id_terima,
                'nomor' => $sql->nosurat_terima,
                'tanggal' => $sql->tanggal_terima,
                'tanggalIndo' => format_biasa($sql->tanggal_terima),
                'tanggalText' => format_indo($sql->tanggal_terima),
                'total' => (int)$sql->total_terima,
                'totalText' => rupiah($sql->total_terima),
                'status' => (int)$sql->status_terima,
                'statusText' => status_label($sql->status_terima, 'penerimaan'),
                'user' => $sql->nama_user,
                'idpemasok' => (int)$sql->id_supplier,
                'pemasok' => $sql->nama_supplier,
                'idgudang' => (int)$sql->id_gudang,
                'gudang' => $sql->nama_gudang
            ];
            $sql_produk = $this->db->select('*,terima_detail.id_detail AS iddetailterima,terima_detail.harga_detail AS harga_terima,terima_detail.jumlah_detail AS jumlah_terima')
                ->from('terima_detail')
                ->join('permintaan_detail', 'minta_detail=permintaan_detail.id_detail')
                ->join('barang_satuan', 'barang_detail=id_brg_satuan')
                ->join('barang', 'barang_brg_satuan=id_barang')
                ->join('satuan', 'satuan_brg_satuan=id_satuan')
                ->where('terima_detail', $id)
                ->order_by('terima_detail.id_detail', 'ASC')
                ->get()->result();
            $dataProduk = [];
            $resultProduk = [];
            $total = 0;
            foreach ($sql_produk as $sp) {
                $subtotal = $sp->harga_terima * $sp->jumlah_terima;
                $total = $total + $subtotal;
                $resultProduk = [
                    'iddetailterima' => (int)$sp->iddetailterima,
                    'produk' => $sp->nama_barang,
                    'satuan' => $sp->singkatan_satuan,
                    'harga' => (int)$sp->harga_terima,
                    'hargaText' => rupiah($sp->harga_terima),
                    'jumlah' => (int)$sp->jumlah_terima,
                    'jumlahText' => rupiah($sp->jumlah_terima),
                    'subtotal' => (int)$subtotal,
                    'subtotalText' => rupiah($subtotal)
                ];
                $sql_stok = $this->db->from('terima_stok')
                    ->join('barang_satuan', 'idsatuan_stok=id_brg_satuan')
                    ->join('barang', 'barang_brg_satuan=id_barang')
                    ->join('satuan', 'satuan_brg_satuan=id_satuan')
                    ->where('iddetail_stok', $sp->iddetailterima)
                    ->get()->result();
                $dataStok = [];
                $resultStok = [];
                foreach ($sql_stok as $st) {
                    $convertAwal = konversi_nilai_satuan($st->id_satuan, $st->convert_stok);
                    $convertAkhir = konversi_nilai_satuan($st->id_satuan, $st->real_stok);
                    $resultStok = [
                        'idstok_produk' => (int)$st->id_stok,
                        'idsatuan' => (int)$sp->id_satuan,
                        'satuan' => $sp->singkatan_satuan,
                        'stokAwal' => (int)$st->convert_stok,
                        'stokAwalConvert' => $convertAwal['jumlah'],
                        'stokAkhir' => (int)$st->real_stok,
                        'stokAkhirConvert' => $convertAkhir['jumlah']
                    ];
                    $dataStok[] = $resultStok;
                }
                $resultProduk['dataStok'] = $dataStok;
                $dataProduk[] = $resultProduk;
            }
            $data['dataProduk'] = $dataProduk;
            $data['totalTerima'] = $total;
            $data['totalFormat'] = rupiah($total);
            $sql_request = $this->db->from('terima_request')
                ->join('permintaan', 'idrequest=id_permintaan')
                ->where('idterima', $id)
                ->get()->row();
            $result_kategori = [
                'idminta' => (int)$sql_request->id_permintaan
            ];
            $data['dataRequest'] = $result_kategori;
            $sql_bayar = $this->db->where('terima_bayar', $id)->get('terima_bayar')->result();
            $dataBayar = [];
            $resultBayar = [];
            $totalBayar = 0;
            foreach ($sql_bayar as $sb) {
                $totalBayar = $totalBayar + $sb->jumlah_bayar;
                $resultBayar = [
                    'idbayar' => $sb->id_bayar,
                    'tanggal' => $sb->tanggal_bayar,
                    'tanggalIndo' => format_biasa($sb->tanggal_bayar),
                    'tanggalText' => format_indo($sb->tanggal_bayar),
                    'note' => $sb->note_bayar,
                    'jumlah' => $sb->jumlah_bayar,
                    'jumlahText' => rupiah($sb->jumlah_bayar)
                ];
                $dataBayar[] = $resultBayar;
            }
            $sisa = $sql->total_terima - $totalBayar;
            $data['dataBayar'] = $dataBayar;
            $data['totalBayar'] = $totalBayar;
            $data['totalBayarFormat'] = rupiah($totalBayar);
            $data['sisaBayar'] = $sisa;
            $data['sisaBayarFormat'] = rupiah($sisa);
        else :
            $data['info'] = false;
        endif;
        return $data;
    }
    public function update($id = null, $post)
    {
        $data = array(
            'pemasok_terima' => $post['pemasok'],
            'gudang_terima' => $post['gudang'],
            'tanggal_terima' => date("Y-m-d", strtotime($post['tanggal']))
        );
        return $this->db->where('id_terima', $id)->update('terima', $data);
    }
    public function destroy($id)
    {
        $data = $this->show($id);
        if ($data['status'] == 0) :
            $cek_stok = $this->db->select('terima_detail,SUM(convert_stok) AS stok_awal, SUM(real_stok) AS stok_akhir')
                ->from('terima_stok')
                ->join('terima_detail', 'iddetail_stok=id_detail')
                ->where('terima_detail', $id)
                ->get()->row_array();
            if ($cek_stok['stok_awal'] > $cek_stok['stok_akhir']) :
                $arr = [
                    'status' => '0101',
                    'msg' => 'Penerimaan produk gagal dihapus karena stok menjadi minus'
                ];
            else :
                foreach ($data['dataProduk'] as $dd) {
                    $this->db->where('iddetail_stok', $dd['iddetailterima'])->delete('terima_stok');
                    $this->db->where('iddetail_harga', $dd['iddetailterima'])->delete('terima_harga');
                    $this->db->where('id_detail', $dd['iddetailterima'])->delete('terima_detail');
                }
                $this->UpdateStatusRequest($id);
                $this->db->where('idterima', $id)->delete('terima_request');
                $this->db->where('id_terima', $id)->delete('terima');
                $arr = [
                    'status' => '0100',
                    'msg' => 'Penerimaan produk berhasil dihapus'
                ];
            endif;
        else :
            $arr = [
                'status' => '0101',
                'msg' => 'Penerimaan produk gagal dihapus'
            ];
        endif;
        return $arr;
    }
}

/* End of file Mpenerimaan.php */
