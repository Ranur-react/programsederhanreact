<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') == "sessDashboard")
            cek_user();
        else
            redirect('logout');
        $this->load->model('master/Mcustomer');
    }
    public function index()
    {
        $data = [
            'title' => 'Customer',
            'small' => 'Daftar Customer',
            'links' => '<li class="active">Customer</li>'
        ];
        $this->template->dashboard('master/customer/data', $data);
    }
    public function data()
    {
        $draw   = $_REQUEST['draw'];
        $length = $_REQUEST['length'];
        $start  = $_REQUEST['start'];
        $search = $_REQUEST['search']["value"];
        $total  = $this->Mcustomer->jumlah_data();
        $output = array();
        $output['draw'] = $draw;
        $output['recordsTotal'] = $output['recordsFiltered'] = $total;
        $output['data'] = array();
        if ($search != "") {
            $query = $this->Mcustomer->cari_data($search);
        } else {
            $query = $this->Mcustomer->tampil_data($start, $length);
        }
        if ($search != "") {
            $count = $this->Mcustomer->cari_data($search);
            $output['recordsTotal'] = $output['recordsFiltered'] = $count->num_rows();
        }
        foreach ($query->result_array() as $d) {
            $edit = '<a href="#"><i class="icon-eye8 text-blue" title="Edit"></i></a>';
            $output['data'][] = array(
                $d['nama_customer'],
                $d['email_customer'],
                $d['phone_customer'],
                format_biasa(format_tglen_timestamp($d['created_at'])),
                status_span($d['active_customer'], 'aktif'),
                $edit
            );
        }
        echo json_encode($output);
    }
}

/* End of file Customer.php */
