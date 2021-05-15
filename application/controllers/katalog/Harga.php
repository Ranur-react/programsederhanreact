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
            $row = $this->Mharga->query_penerimaan($result->id_barang, 1, 0, 1);
            if ($row != null) {
                $harga_terakhir = $this->Mharga->query_harga_satuan($row->id_hrg_barang, 1);
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
        $data = $this->Mharga->array_penerimaan($kode, 1, 1, 0);
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
            'links' => '<li><a href="' . site_url('harga') . '">Harga Jual</a></li><li class="active">Histori</li>',
            'sidebar' => 'collapse',
            'kode' => $id
        ];
        $this->template->dashboard('katalog/harga/histori', $data);
    }
    public function data_terima()
    {
        $kode = $this->input->get('kode');
        $d['data'] = $this->Mharga->array_penerimaan($kode, 0, 0, 0);
        $this->load->view('katalog/harga/data', $d);
    }
    public function add_satuan()
    {
        $id_satuan = $this->input->get('id_satuan');
        $id_harga = $this->input->get('id_harga');
        $this->Mharga->add_satuan($id_satuan, $id_harga);
        $json = array(
            'message' => 'Satuan telah ditambahkan'
        );
        echo json_encode($json);
    }
}

/* End of file Harga.php */
