<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengiriman extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_user();
        $this->load->model('penjualan/pesanan/Mpesanan');
        $this->load->model('penjualan/Mpengiriman');
    }
    public function index()
    {
        $data = [
            'title' => 'Pengiriman',
            'small' => 'Daftar Pengiriman',
            'links' => '<li class="active">Pengiriman</li>',
            'sidebar' => 'collapse'
        ];
        $this->template->dashboard('penjualan/pengiriman/index', $data);
    }
    public function data()
    {
        $draw   = $_REQUEST['draw'];
        $length = $_REQUEST['length'];
        $start  = $_REQUEST['start'];
        $search = $_REQUEST['search']["value"];
        $total  = $this->Mpengiriman->jumlah_data();
        $output = array();
        $output['draw'] = $draw;
        $output['recordsTotal'] = $output['recordsFiltered'] = $total;
        $output['data'] = array();
        if ($search != "") {
            $query = $this->Mpengiriman->cari_data($search);
        } else {
            $query = $this->Mpengiriman->tampil_data($start, $length);
        }
        if ($search != "") {
            $count = $this->Mpengiriman->cari_data($search);
            $output['recordsTotal'] = $output['recordsFiltered'] = $count->num_rows();
        }
        foreach ($query->result_array() as $d) {
            $detail = '<a href="javascript:void(0)" onclick="detail(\'' . $d['id_order'] . '\')" title="Detail"><i class="icon-eye8 text-black"></i></a>';
            $kirim = '<a href="javascript:void(0)" onclick="create(\'' . $d['id_order'] . '\')" title="Pengiriman"><i class="fas fa-shipping-fast text-blue"></i></a>';
            $terima = '<a href="javascript:void(0)" onclick="terima(\'' . $d['id_order'] . '\')" title="Terima Pesanan"><i class="fas fa-people-carry text-green"></i></a>';
            if ($d['status_order'] == 2) {
                $action = $detail . '&nbsp;' . $kirim;
            } else if ($d['status_order'] == 3) {
                $action = $detail . '&nbsp;' . $terima;
            } else {
                $action = $detail;
            }
            $output['data'][] = array(
                $d['invoice_order'],
                format_indo(format_tglen_timestamp($d['tanggal_order'])) . ', ' . sort_jam_timestamp($d['tanggal_order']),
                $d['nama_customer'],
                $d['nama_metode'],
                akuntansi($d['total_bayar']),
                status_span($d['status_bayar'], 'bayar'),
                status_span($d['status_order'], 'order'),
                $action
            );
        }
        echo json_encode($output);
    }
    public function create()
    {
        $kode = $this->input->get('kode');
        $data = [
            'name' => 'Detail pengiriman pesanan',
            'modallg' => 1,
            'data' => $this->Mpesanan->show($kode),
            'produk' => $this->Mpesanan->produk($kode),
            'pengiriman' => $this->Mpesanan->pengiriman($kode)
        ];
        $this->template->modal_info('penjualan/pengiriman/create', $data);
    }
    public function store()
    {
        $kode = $this->input->get('kode');
        $this->Mpengiriman->store($kode);
        $json = array(
            'status' => '0100',
            'pesan' => 'Proses pesanan berhasil ditambahkan dalam pengiriman'
        );
        echo json_encode($json);
    }
    public function terima()
    {
        $kode = $this->input->get('kode');
        $data = [
            'name' => 'Detail Penerima',
            'post' => 'pengiriman/storeterima',
            'class' => 'form_create',
            'data' => $this->Mpengiriman->show($kode),
            'relasi' => $this->Mpengiriman->relasi(),
            'pesanan' => $this->Mpesanan->show($kode),
        ];
        $this->template->modal_form('penjualan/pengiriman/terima', $data);
    }
    public function storeterima()
    {
        $post = $this->input->post(null, TRUE);
        $this->form_validation->set_rules('nama', 'Nama penerima', 'required');
        $this->form_validation->set_rules('relasi', 'Relasi dengan penerima', 'required');
        if ($post['idmetode'] == 1) :
            $this->form_validation->set_rules('nilai', 'Jumlah bayar', 'callback_bayar_check[' . $post['idbayar'] . ']');
        endif;
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $this->Mpengiriman->storeterima($post);
            $json = array(
                'status' => '0100',
                'message' => 'Pesanan telah sampai ketujuan'
            );
        } else {
            $json = array(
                'status' => '0101',
                'message' => 'Penerimaan pesanan gagal disimpan'
            );
            foreach ($_POST as $key => $value) {
                $json['pesan'][$key] = form_error($key);
            }
        }
        echo json_encode($json);
    }
    public function bayar_check($nilai, $idbayar)
    {
        $data = $this->db->where('id_bayar', $idbayar)->get('order_bayar')->row();
        if ($nilai == null) {
            $this->form_validation->set_message('bayar_check', 'Jumlah bayar tidak boleh kosong');
            return false;
        } else {
            if ($data->total_bayar == convert_uang($nilai)) {
                return true;
            } else {
                $this->form_validation->set_message('bayar_check', 'Jumlah bayar tidak sesuai');
                return false;
            }
        }
    }
}

/* End of file Pengiriman.php */
