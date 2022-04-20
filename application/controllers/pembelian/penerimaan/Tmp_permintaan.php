<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tmp_permintaan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_logged_in();
        $this->load->model('pembelian/penerimaan/Mtmp_permintaan');
    }
    public function index()
    {
        $this->load->view('pembelian/penerimaan/tmp_request/index');
    }
    public function data()
    {
        $query = $this->Mtmp_permintaan->fetch_all();
        $data = array();
        $no = $_GET['start'];
        foreach ($query as $value) {
            $no++;
            $pilih = '<a class="btn btn-success btn-xs pilih-request" id="' . $value->id_permintaan . '" label="' . $value->nosurat_permintaan . '">Pilih <i class="icon-arrow-right8"></i></a>';
            $row = array();
            $row[] = $no . '.';
            $row[] = $value->nosurat_permintaan;
            $row[] = format_biasa($value->tanggal_permintaan);
            $row[] = currency($value->total_permintaan);
            $row[] = $value->nama_user;
            $row[] = status_span($value->status_permintaan, 'permintaan');
            $row[] = $pilih;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Mtmp_permintaan->count_all(),
            "recordsFiltered" => $this->Mtmp_permintaan->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function show()
    {
        $idminta = $this->input->get('idminta');
        $data = $this->Mtmp_permintaan->get_data($idminta);
        echo json_encode($data);
    }
}

/* End of file Tmp_permintaan.php */
