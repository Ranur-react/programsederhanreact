<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tmp_create extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') == "sessDashboard")
            cek_user();
        else
            redirect('logout');
        $this->load->model('pembelian/penerimaan/Mtmp_create');
    }
    public function index()
    {
        $this->load->view('pembelian/penerimaan/tmp_create/data_permintaan');
    }
    public function data_permintaan()
    {
        $draw   = $_REQUEST['draw'];
        $length = $_REQUEST['length'];
        $start  = $_REQUEST['start'];
        $search = $_REQUEST['search']["value"];
        $total  = $this->Mtmp_create->jumlah_data();
        $output = array();
        $output['draw'] = $draw;
        $output['recordsTotal'] = $output['recordsFiltered'] = $total;
        $output['data'] = array();
        if ($search != "") {
            $query = $this->Mtmp_create->cari_data($search);
        } else {
            $query = $this->Mtmp_create->tampil_data($start, $length);
        }
        if ($search != "") {
            $count = $this->Mtmp_create->cari_data($search);
            $output['recordsTotal'] = $output['recordsFiltered'] = $count->num_rows();
        }
        $no = 1;
        foreach ($query->result_array() as $d) {
            $pilih = '<a href="javascript:void(0)" class="btn btn-success btn-xs">Pilih <i class="icon-arrow-right8"></i></a>';
            $output['data'][] = array(
                $no . '.',
                $d['id_permintaan'],
                $d['nama_supplier'],
                format_biasa($d['tanggal_permintaan']),
                akuntansi($d['total_permintaan']),
                $d['nama_user'],
                status_span($d['status_permintaan'], 'permintaan'),
                $pilih
            );
            $no++;
        }
        echo json_encode($output);
    }
}

/* End of file Tmp_create.php */
