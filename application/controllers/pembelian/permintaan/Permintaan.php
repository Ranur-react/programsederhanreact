<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permintaan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_logged_in();
        $this->load->model('pembelian/permintaan/Mpermintaan');
        $this->load->model('pembelian/permintaan/Mtmp_create');
    }
    public function index()
    {
        $data = [
            'title' => 'Permintaan',
            'small' => 'Daftar Permintaan Produk',
            'links' => '<li class="active">Permintaan</li>'
        ];
        $this->template->dashboard('pembelian/permintaan/index', $data);
    }
    public function data()
    {
        $query = $this->Mpermintaan->fetch_all();
        $data = array();
        $no = $_GET['start'];
        foreach ($query as $value) {
            $no++;
            $info = '<a href="javascript:void(0)" onclick="view(\'' . $value->id_permintaan . '\')"><i class="icon-eye8 text-black" data-toggle="tooltip" data-original-title="Detail"></i></a>';
            $edit = '<a href="' . site_url('permintaan/edit/' . $value->id_permintaan) . '"><i class="icon-pencil7 text-green" data-toggle="tooltip" data-original-title="Edit"></i></a>';
            $hapus = '<a href="javascript:void(0)" onclick="destroy(\'' . $value->id_permintaan . '\')"><i class="icon-trash text-red" data-toggle="tooltip" data-original-title="Hapus"></i></a>';
            $row = array();
            $row[] = $no . '.';
            $row[] = $value->nosurat_permintaan;
            $row[] = format_biasa($value->tanggal_permintaan);
            $row[] = currency($value->total_permintaan);
            $row[] = $value->nama_user;
            $row[] = status_span($value->status_permintaan, 'permintaan');
            $row[] = $info . '&nbsp;' . $edit . '&nbsp;' . $hapus;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Mpermintaan->count_all(),
            "recordsFiltered" => $this->Mpermintaan->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function create()
    {
        $data = [
            'title' => 'Permintaan',
            'small' => 'Tambah Permintaan Produk',
            'links' => '<li><a href="' . site_url('permintaan') . '">Permintaan</a></li><li class="active">Tambah</li>',
            'nomor' => $this->Mpermintaan->nosurat()
        ];
        $this->template->dashboard('pembelian/permintaan/create', $data);
    }
    public function store()
    {
        $post = $this->input->post(null, TRUE);
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $tmp_data = $this->Mtmp_create->tampil_data();
            if (count($tmp_data) > 0) :
                $kode = $this->Mpermintaan->kode();
                $this->Mpermintaan->store($kode, $post);
                $json = array(
                    'status' => '0100',
                    'token' => $this->security->get_csrf_hash(),
                    'kode' => $kode,
                    'msg' => 'Form tambah permintaan produk berhasil dibuat.'
                );
            else :
                $json = array(
                    'status' => '0100',
                    'token' => $this->security->get_csrf_hash(),
                    'count' => count($tmp_data),
                    'msg' => 'Anda belum melengkapi isian form permintaan produk.'
                );
            endif;
        } else {
            $json = array(
                'status' => '0101',
                'token' => $this->security->get_csrf_hash()
            );
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
            'small' => 'Edit Permintaan Produk',
            'links' => '<li><a href="' . site_url('permintaan') . '">Permintaan</a></li><li class="active">Edit</li>',
            'data' => $this->Mpermintaan->show($kode)
        ];
        $this->template->dashboard('pembelian/permintaan/edit', $data);
    }
    public function update()
    {
        $post = $this->input->post(null, TRUE);
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $kode = $post['kode'];
            $tmp_data = $this->Mpermintaan->show($kode);
            if (count($tmp_data['dataProduk']) > 0) :
                $this->Mpermintaan->update($kode, $post);
                $json = array(
                    'status' => '0100',
                    'token' => $this->security->get_csrf_hash(),
                    'kode' => $kode,
                    'msg' => 'Form edit permintaan produk berhasil dirubah'
                );
            else :
                $json = array(
                    'status' => '0100',
                    'token' => $this->security->get_csrf_hash(),
                    'count' => count($tmp_data['dataProduk']),
                    'msg' => 'Anda belum melengkapi isian form permintaan produk'
                );
            endif;
        } else {
            $json = array(
                'status' => '0101',
                'token' => $this->security->get_csrf_hash()
            );
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
            'small' => 'Detail Permintaan Produk',
            'links' => '<li><a href="' . site_url('permintaan') . '">Permintaan</a></li><li class="active">Detail</li>',
            'data' => $this->Mpermintaan->show($kode)
        ];
        $this->template->dashboard('pembelian/permintaan/detail', $data);
    }
    public function view()
    {
        $kode = $this->input->get('kode');
        $data = [
            'name' => 'Detail Permintaan Produk',
            'modallg' => 1,
            'data' => $this->Mpermintaan->show($kode)
        ];
        $this->template->modal_info('pembelian/permintaan/view', $data);
    }
    public function destroy()
    {
        $kode = $this->input->get('kode', true);
        $query = $this->Mpermintaan->destroy($kode);
        if ($query == "0100") {
            $json = array(
                'status' => '0100',
                'msg' => successDestroy()
            );
        } else {
            $json = array(
                'status' => '0101',
                'msg' => errorDestroy()
            );
        }
        echo json_encode($json);
    }
    public function print($kode)
    {
        $data = [
            'title' => 'Faktur Permintaan Produk',
            'data' => $this->Mpermintaan->show($kode)
        ];
        $this->load->view('pembelian/permintaan/cetak', $data);
    }
}

/* End of file Permintaan.php */
