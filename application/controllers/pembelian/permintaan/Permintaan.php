<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permintaan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') == "sessDashboard")
            cek_user();
        else
            redirect('logout');
        $this->load->model('master/Msupplier');
        $this->load->model('pembelian/permintaan/Mpermintaan');
        $this->load->model('pembelian/permintaan/Mtmp_create');
        $this->load->model('pembelian/permintaan/Mtmp_edit');
    }
    public function index()
    {
        $data = [
            'title' => 'Permintaan',
            'small' => 'Menampilkan dan mengelola data permintaan barang',
            'links' => '<li class="active">Permintaan</li>'
        ];
        $this->template->dashboard('pembelian/permintaan/data', $data);
    }
    public function data()
    {
        $draw   = $_REQUEST['draw'];
        $length = $_REQUEST['length'];
        $start  = $_REQUEST['start'];
        $search = $_REQUEST['search']["value"];
        $total  = $this->Mpermintaan->jumlah_data();
        $output = array();
        $output['draw'] = $draw;
        $output['recordsTotal'] = $output['recordsFiltered'] = $total;
        $output['data'] = array();
        if ($search != "") {
            $query = $this->Mpermintaan->cari_data($search);
        } else {
            $query = $this->Mpermintaan->tampil_data($start, $length);
        }
        if ($search != "") {
            $count = $this->Mpermintaan->cari_data($search);
            $output['recordsTotal'] = $output['recordsFiltered'] = $count->num_rows();
        }
        $no = 1;
        foreach ($query->result_array() as $d) {
            $info = '<a href="javascript:void(0)" onclick="info(\'' . $d['id_permintaan'] . '\')"><i class="icon-eye8 text-black" data-toggle="tooltip" data-original-title="Info"></i></a>';
            $edit = '<a href="' . site_url('permintaan/edit/' . $d['id_permintaan']) . '"><i class="icon-pencil7 text-green" data-toggle="tooltip" data-original-title="Edit"></i></a>';
            $hapus = '<a href="javascript:void(0)" onclick="hapus(\'' . $d['id_permintaan'] . '\')"><i class="icon-trash text-red" data-toggle="tooltip" data-original-title="Hapus"></i></a>';
            $output['data'][] = array(
                $no . '.',
                $d['id_permintaan'],
                $d['nama_supplier'],
                format_biasa($d['tanggal_permintaan']),
                akuntansi($d['total_permintaan']),
                $d['nama_user'],
                status_span($d['status_permintaan'], 'permintaan'),
                $info . '&nbsp;' . $edit . '&nbsp;' . $hapus
            );
            $no++;
        }
        echo json_encode($output);
    }
    public function create()
    {
        $data = [
            'title' => 'Permintaan',
            'small' => 'Tambah Data Permintaan Barang',
            'links' => '<li><a href="' . site_url('permintaan') . '">Permintaan</a></li><li class="active">Tambah</li>',
            'supplier' => $this->Msupplier->getall(),
            'nomor' => $this->Mpermintaan->nosurat()
        ];
        $this->template->dashboard('pembelian/permintaan/tambah', $data);
    }
    public function store()
    {
        $post = $this->input->post(null, TRUE);
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('supplier', 'Supplier', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $tmp_data = $this->Mtmp_create->tampil_data();
            if (count($tmp_data) > 0) :
                $kode = $this->Mpermintaan->kode();
                $this->Mpermintaan->store($kode, $post);
                $json = array(
                    'status' => "0100",
                    'kode' => $kode,
                    'message' => 'Form tambah permintaan barang berhasil dibuat.'
                );
            else :
                $json = array(
                    'status' => "0100",
                    'count' => count($tmp_data),
                    'message' => 'Anda belum melengkapi isian form permintaan barang.'
                );
            endif;
        } else {
            $json['status'] = "0101";
            foreach ($_POST as $key => $value) {
                $json['pesan'][$key] = form_error($key);
            }
        }
        echo json_encode($json);
    }
    public function edit($kode)
    {
        $data = [
            'title' => 'Permintaan',
            'small' => 'Edit Data Permintaan Barang',
            'links' => '<li><a href="' . site_url('permintaan') . '">Permintaan</a></li><li class="active">Edit</li>',
            'supplier' => $this->Msupplier->getall(),
            'data' => $this->Mpermintaan->show($kode)
        ];
        $this->template->dashboard('pembelian/permintaan/edit', $data);
    }
    public function update()
    {
        $post = $this->input->post(null, TRUE);
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('supplier', 'Supplier', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $kode = $post['kode'];
            $tmp_data = $this->Mtmp_edit->tampil_data($kode);
            if (count($tmp_data) > 0) :
                $this->Mpermintaan->update($kode, $post);
                $json = array(
                    'status' => "0100",
                    'kode' => $kode,
                    'message' => 'Form edit permintaan barang berhasil dirubah.'
                );
            else :
                $json = array(
                    'status' => "0100",
                    'count' => count($tmp_data),
                    'message' => 'Anda belum melengkapi isian form permintaan barang.'
                );
            endif;
        } else {
            $json['status'] = "0101";
            foreach ($_POST as $key => $value) {
                $json['pesan'][$key] = form_error($key);
            }
        }
        echo json_encode($json);
    }
    public function detail($kode)
    {
        $data = [
            'title' => 'Permintaan',
            'small' => 'Detail Permintaan barang',
            'links' => '<li><a href="' . site_url('permintaan') . '">Permintaan</a></li><li class="active">Detail</li>',
            'data' => $this->Mpermintaan->show($kode),
            'barang' => $this->Mtmp_edit->tampil_data($kode)
        ];
        $this->template->dashboard('pembelian/permintaan/detail', $data);
    }
    public function info()
    {
        $kode = $this->input->get('kode');
        $data = [
            'name' => 'Detail Permintaan Barang',
            'modallg' => 1,
            'data' => $this->Mpermintaan->show($kode),
            'barang' => $this->Mtmp_edit->tampil_data($kode)
        ];
        $this->template->modal_info('pembelian/permintaan/info', $data);
    }
    public function destroy()
    {
        $kode = $this->input->get('kode', true);
        $query = $this->Mpermintaan->destroy($kode);
        if ($query == "0100") {
            $json = array(
                'status' => "0100",
                "message" => successDestroy()
            );
        } else {
            $json = array(
                'status' => "0101",
                "message" => "Beberapa data barang sudah ada yang diterima."
            );
        }
        echo json_encode($json);
    }
}

/* End of file Permintaan.php */
