<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pelanggan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_logged_in();
        $this->load->model('master/Mpelanggan');
    }
    public function index()
    {
        $data = [
            'title' => 'Pelanggan',
            'links' => '<li class="active">Pelanggan</li>'
        ];
        $this->template->dashboard('master/pelanggan/index', $data);
    }
    public function data()
    {
        $query = $this->Mpelanggan->fetch_all();
        $data = array();
        $no = $_GET['start'];
        foreach ($query as $value) {
            $no++;
            $row = array();
            $row[] = $no . '.';
            $row[] = $value->nama_customer;
            $row[] = $value->email_customer;
            $row[] = $value->phone_customer;
            $row[] = format_biasa(format_tglen_timestamp($value->created_at));
            $row[] = status_span($value->active_customer, 'aktif');
            $row[] = '<a href="' . site_url('pelanggan/detail/' . $value->id_customer) . '"><i class="icon-eye8 text-black" title="Detail"></i></a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Mpelanggan->count_all(),
            "recordsFiltered" => $this->Mpelanggan->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function detail($kode)
    {
        $data = [
            'title' => 'Pelanggan',
            'small' => 'Detail Pelanggan',
            'links' => '<li class="active">Pelanggan</li>',
            'data' => $this->Mpelanggan->show($kode)
        ];
        $this->template->dashboard('master/pelanggan/detail', $data);
    }
}

/* End of file Pelanggan.php */
