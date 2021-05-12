<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Harga extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') == "sessDashboard")
            cek_user();
        else
            redirect('logout');
        $this->load->model('katalog/Mharga');
    }
    public function index()
    {
        $data = [
            'title' => 'Harga Jual',
            'small' => 'Menampilkan dan mengelola data harga jual barang',
            'links' => '<li class="active">Harga Jual</li>'
        ];
        $this->template->dashboard('katalog/harga/index', $data);
    }
    public function data()
    {
        $results = $this->Mharga->fetch_all();
        $data = array();
        $no = $_GET['start'];
        foreach ($results as $result) {
            $row = $this->Mharga->terima_terakhir_aktif($result->id_barang, 1);
            if ($row != null) {
                $data_harga = '<div class="text-muted text-size-small">Tgl terima: ' . format_indo($row->tanggal_hrg_barang) . '</div>';
            }

            $detail = '<a href="#"><i class="icon-eye8 text-black" title="Detail"></i></a>';
            $histori = '<a href="#"><i class="icon-history text-green" title="Riwayat Harga"></i></a>';

            $no++;
            $rows = array();
            $rows[] = $no . '.';
            $rows[] = $result->nama_barang;
            $rows[] = '';
            $rows[] = $row != null ? $data_harga : '<div class="text-muted text-size-small">Harga belum diaktifkan</div>';
            $rows[] = status_span($result->status_barang, 'aktif');
            $rows[] = $detail . '&nbsp;' . $histori;
            $data[] = $rows;
        }
        $json = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Mharga->count_all(),
            "recordsFiltered" => $this->Mharga->count_filtered(),
            "data" => $data,
        );
        echo json_encode($json);
    }
}

/* End of file Harga.php */
