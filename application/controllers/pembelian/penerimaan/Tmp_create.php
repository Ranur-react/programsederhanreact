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

        $this->load->model('pembelian/permintaan/Mpermintaan');
        $this->load->model('pembelian/permintaan/Mtmp_edit');
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
            $pilih = '<a href="javascript:void(0)" onclick="pilih(\'' . $d['id_permintaan'] . '\')" class="btn btn-success btn-xs">Pilih <i class="icon-arrow-right8"></i></a>';
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
    public function show_permintaan()
    {
        $kode = $this->input->get('id_permintaan');
        $data['data'] = $this->Mpermintaan->show($kode);
        $data['barang'] = $this->Mtmp_edit->tampil_data($kode);
        $this->load->view('pembelian/penerimaan/tmp_create/show', $data);
    }
    public function data()
    {
        $d['data'] = $this->Mtmp_create->data();
        $this->load->view('pembelian/penerimaan/tmp_create/data', $d);
    }
    public function create()
    {
        $kode = $this->input->get('kode');
        $data = [
            'name' => 'Tambah Barang',
            'post' => 'penerimaan/tmp-create/store',
            'class' => 'form_tmp',
            'backdrop' => 1,
            'data' => $this->Mtmp_edit->show($kode)
        ];
        $this->template->modal_form('pembelian/penerimaan/tmp_create/create', $data);
    }
    public function store()
    {
        $post = $this->input->post(null, TRUE);
        $cek_user = $this->db->where(['iddetail' => $post['iddetail'], 'user' => id_user()])->get('tmp_penerimaan');
        $cek_barang = $this->db->where('iddetail', $post['iddetail'])->where_not_in('user', id_user())->get('tmp_penerimaan');
        if ($cek_user->num_rows() > 0) :
            $json = array(
                'status' => "0100",
                'count' => $cek_user->num_rows(),
                'message' => info('Barang sudah ditambahkan, silahkan update jika ingin melakukan perubahan.')
            );
        elseif ($cek_barang->num_rows() > 0) :
            $json = array(
                'status' => "0100",
                'count' => $cek_barang->num_rows(),
                'message' => info('Barang sudah ditambahkan oleh user yang lain.')
            );
        else :
            $this->form_validation->set_rules('harga', 'Harga', 'required|greater_than[0]');
            $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|greater_than[0]');
            $this->form_validation->set_message('required', errorRequired());
            $this->form_validation->set_message('greater_than', greater_than());
            $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
            if ($this->form_validation->run() == TRUE) {
                $this->Mtmp_create->store($post);
                $json = array(
                    'status' => "0100",
                    'count' => 0,
                    'notif' => 'Barang berhasil ditambahkan',
                );
            } else {
                $json = array(
                    'status' => "0101",
                    'notif' => 'Barang gagal ditambahkan',
                    'message' => ''
                );
                foreach ($_POST as $key => $value) {
                    $json['pesan'][$key] = form_error($key);
                }
            }
        endif;
        echo json_encode($json);
    }
    public function edit()
    {
        $kode = $this->input->get('kode');
        $data = [
            'name' => 'Edit Barang',
            'post' => 'penerimaan/tmp-create/update',
            'class' => 'form_tmp',
            'backdrop' => 1,
            'data' => $this->Mtmp_create->show($kode)
        ];
        $this->template->modal_form('pembelian/penerimaan/tmp_create/edit', $data);
    }
}

/* End of file Tmp_create.php */
