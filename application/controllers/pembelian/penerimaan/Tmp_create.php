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
                $d['nosurat_permintaan'],
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
    public function check_permintaan()
    {
        $kode = $this->input->get('kode');
        $data = $this->Mtmp_create->check_permintaan($kode);
        if ($data == '0100') :
            $json = array(
                'status' => '0100'
            );
        else :
            $json = array(
                'status' => '0101',
                'pesan' => 'Supplier yang dipilih tidak sama.'
            );
        endif;
        echo json_encode($json);
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
    public function update()
    {
        $this->form_validation->set_rules('harga', 'Harga', 'required|greater_than[0]');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|greater_than[0]');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_message('greater_than', greater_than());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post(null, TRUE);
            $this->Mtmp_create->update($post);
            $json = array(
                'status' => "0100",
                'count' => 0,
                'notif' => 'Data barang berhasil dirubah'
            );
        } else {
            $json = array(
                'status' => "0101",
                'notif' => 'Data barang gagal dirubah'
            );
            foreach ($_POST as $key => $value) {
                $json['pesan'][$key] = form_error($key);
            }
        }
        echo json_encode($json);
    }
    public function destroy()
    {
        $kode = $this->input->get('kode', true);
        $action = $this->Mtmp_create->destroy($kode);
        if ($action == true) {
            $pesan['status'] = "0100";
        } else {
            $pesan['status'] = "0101";
        }
        echo json_encode($pesan);
    }
    public function batal()
    {
        $action = $this->Mtmp_create->batal();
        if ($action) {
            $json = array(
                'status' => '0100',
                'message' => successCancel()
            );
        } else {
            $json = array(
                'status' => '0101',
                'message' => errorDestroy()
            );
        }
        echo json_encode($json);
    }
}

/* End of file Tmp_create.php */
