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
            $edit = '<a href="' . site_url('customer/detail/' . $d['id_customer']) . '"><i class="icon-eye8 text-blue" title="Edit"></i></a>';
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
    public function detail($kode)
    {
        $data = [
            'title' => 'Customer',
            'small' => 'Detail Customer',
            'links' => '<li class="active">Customer</li>',
            'data' => $this->Mcustomer->show($kode)
        ];
        $this->template->dashboard('master/customer/detail', $data);
    }
    public function update()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('phone', 'No Ponsel', 'trim|required');
        $this->form_validation->set_rules('birth', 'Tanggal lahir', 'required');
        $this->form_validation->set_rules('jenkel', 'Jenis kelamin', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post(null, TRUE);
            $this->Mcustomer->update($post);
            $json = array(
                'status' => '0100',
                'message' => 'Data customer telah dirubah'
            );
        } else {
            $json['status'] = '0111';
            foreach ($_POST as $key => $value) {
                $json['pesan'][$key] = form_error($key);
            }
        }
        echo json_encode($json);
    }
}

/* End of file Customer.php */
