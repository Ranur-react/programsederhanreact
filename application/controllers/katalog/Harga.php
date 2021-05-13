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
                $harga_terakhir = $this->Mharga->harga_terakhir_aktif($row->id_hrg_barang);
                $data_harga = '';
                foreach ($harga_terakhir as $value) {
                    $data_harga .= rupiah($value->jual_hrg_detail) . '&nbsp;' . $value->singkatan_satuan . '<br>';
                }
                $data_harga .= '<div class="text-muted text-size-small">Tgl terima: ' . format_indo($row->tanggal_hrg_barang) . '</div>';
            }

            $detail = '<a href="javascript:void(0)" onclick="detail(\'' . $result->id_barang . '\')"><i class="icon-eye8 text-black" title="Detail"></i></a>';
            $histori = '<a href="' . site_url('harga/histori/' . $result->id_barang) . '"><i class="icon-history text-green" title="Histori Harga"></i></a>';

            $no++;
            $rows = array();
            $rows[] = $no . '.';
            $rows[] = $result->nama_barang;
            $rows[] = '';
            $rows[] = $row != null ? rtrim($data_harga, '') : '<div class="text-muted text-size-small">Harga belum diaktifkan</div>';
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
    public function detail()
    {
        $kode = $this->input->get('kode');
        $data = $this->Mharga->data_harga_aktif($kode);
        $view = [
            'name' => 'Daftar harga jual barang',
            'modallg' => 1,
            'data' => $data
        ];
        $this->template->modal_info('katalog/harga/detail', $view);
    }
    public function histori($id = null)
    {
        $data = [
            'title' => 'Histori Harga Jual',
            'small' => '',
            'links' => '<li><a href="' . site_url('harga') . '">Harga Jual</a></li><li class="active">Histori</li>'
        ];
        $this->template->dashboard('katalog/harga/histori', $data);
    }
}

/* End of file Harga.php */
