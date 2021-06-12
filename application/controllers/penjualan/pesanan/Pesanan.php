<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_user();
        $this->load->model('master/Mcustomer');
        $this->load->model('penjualan/pesanan/Mpesanan');
    }
    public function index()
    {
        $data = [
            'title' => 'Pesanan',
            'small' => 'Daftar Pesanan',
            'links' => '<li class="active">Pesanan</li>'
        ];
        $this->template->dashboard('penjualan/pesanan/index', $data);
    }
    public function data()
    {
        $draw   = $_REQUEST['draw'];
        $length = $_REQUEST['length'];
        $start  = $_REQUEST['start'];
        $search = $_REQUEST['search']["value"];
        $total  = $this->Mpesanan->jumlah_data();
        $output = array();
        $output['draw'] = $draw;
        $output['recordsTotal'] = $output['recordsFiltered'] = $total;
        $output['data'] = array();
        if ($search != "") {
            $query = $this->Mpesanan->cari_data($search);
        } else {
            $query = $this->Mpesanan->tampil_data($start, $length);
        }
        if ($search != "") {
            $count = $this->Mpesanan->cari_data($search);
            $output['recordsTotal'] = $output['recordsFiltered'] = $count->num_rows();
        }
        foreach ($query->result_array() as $d) {
            $detail = '<a href="javascript:void(0)" onclick="detail(\'' . $d['id_order'] . '\')" title="Detail"><i class="icon-eye8 text-black"></i></a>';
            $confirm = '<a href="javascript:void(0)" class="btn btn-xs btn-danger" onclick="confirm(\'' . $d['id_order'] . '\')">Konfirmasi</a>';
            $output['data'][] = array(
                $d['invoice_order'],
                format_indo(format_tglen_timestamp($d['tanggal_order'])) . ', ' . sort_jam_timestamp($d['tanggal_order']),
                $d['nama_customer'],
                $d['nama_metode'],
                akuntansi($d['total_bayar']),
                $confirm,
                status_span($d['status_order'], 'order'),
                $detail
            );
        }
        echo json_encode($output);
    }
    public function create()
    {
        $data = [
            'title' => 'Pesanan',
            'small' => 'Tambah Pesanan',
            'links' => '<li><a href="' . site_url('pesanan') . '">Pesanan</a></li><li class="active">Tambah</li>',
            'customer' => $this->Mcustomer->get_all()
        ];
        $this->template->dashboard('penjualan/pesanan/create', $data);
    }
    public function store()
    {
        $post = $this->input->post(null, TRUE);
        $this->form_validation->set_rules('customer', 'Customer', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('metode', 'Metode pembayaran', 'required');
        if ($post['metode'] == '2') {
            $this->form_validation->set_rules('bank', 'Bank', 'required');
        }
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $this->Mpesanan->store($post);
            $json = array(
                'status' => '0100',
                'message' => 'Form tambah pesanan barang berhasil dibuat.'
            );
        } else {
            $json['status'] = '0101';
            foreach ($_POST as $key => $value) {
                $json['pesan'][$key] = form_error($key);
            }
        }
        echo json_encode($json);
    }
    public function detail()
    {
        $kode = $this->input->get('kode');
        $data = [
            'name' => 'Detail Pesanan',
            'modallg' => 1,
            'data' => $this->Mpesanan->show($kode),
            'produk' => $this->Mpesanan->produk($kode),
            'pengiriman' => $this->Mpesanan->pengiriman($kode)
        ];
        $this->template->modal_info('penjualan/pesanan/detail', $data);
    }
}

/* End of file Pesanan.php */
