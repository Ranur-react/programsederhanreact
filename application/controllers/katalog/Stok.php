<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stok extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_user();
        $this->load->model('master/Mbarang');
        $this->load->model('katalog/Mharga');
    }
    public function index()
    {
        $data = [
            'title' => 'Stok Barang',
            'small' => 'Menampilkan data stok barang',
            'links' => '<li class="active">Stok Barang</li>'
        ];
        $this->template->dashboard('katalog/stok/index', $data);
    }
    public function data()
    {
        $results = $this->Mbarang->get_all();
        $data = array();
        $no = $_GET['start'];
        foreach ($results as $result) {
            $kode = $result->id_barang;
            // Menampilkan data satuan per barang
            $data_satuan = $this->Mbarang->barang_satuan($kode);
            $row_satuan = '';
            foreach ($data_satuan as $data_satuan) {
                $row_satuan .= $data_satuan['nama_satuan'] . '<br>';
            }
            // Menampilkan stok barang dari penerimaan terakhir
            $stok = $this->Mharga->query_penerimaan($kode, 0, 0, 1);
            if ($stok != null) {
                $terima_akhir = $this->db->where('id_terima', $stok->terima_detail)->get('penerimaan')->row();
                $row_stok = $stok != null ? convert_satuan($stok->id_satuan, $stok->stok_detail) . ' ' . $stok->singkatan_satuan : 0;
                $row_terima = '<div class="text-muted text-size-small">No: ' . $terima_akhir->nosurat_terima . ' Tgl: ' . format_indo($terima_akhir->tanggal_terima) . '</div>';
            }

            $detail = '<a href="' . site_url('stok-barang/detail/' . $result->id_barang) . '"><i class="icon-eye8 text-black" title="Detail"></i></a>';
            $no++;
            $rows = array();
            $rows[] = $no . '.';
            $rows[] = $result->nama_barang;
            $rows[] = rtrim($row_satuan, '<br>');
            $rows[] = $stok != null ? $row_stok . '<br>' . $row_terima : 0;
            $rows[] = status_span($result->status_barang, 'aktif');
            $rows[] = $detail;
            $data[] = $rows;
        }
        $json = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Mbarang->count_all(),
            "recordsFiltered" => $this->Mbarang->count_filtered(),
            "data" => $data,
        );
        echo json_encode($json);
    }
    public function detail($kode)
    {
        $data = [
            'title' => 'Stok Barang',
            'small' => 'Menampilkan detail stok barang',
            'links' => '<li>Stok Barang</li><li class="active">Detail</li>',
            'sidebar' => 'collapse',
            'kode' => $kode
        ];
        $this->template->dashboard('katalog/stok/detail', $data);
    }
}

/* End of file Stok.php */
