<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penerimaan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') == "sessDashboard")
            cek_user();
        else
            redirect('logout');
        $this->load->model('master/Mgudang');
        $this->load->model('pembelian/penerimaan/Mpenerimaan');
        $this->load->model('pembelian/penerimaan/Mtmp_create');
        $this->load->model('pembelian/penerimaan/Mtmp_edit');
    }
    public function index()
    {
        $data = [
            'title' => 'Penerimaan',
            'small' => 'Menampilkan dan mengelola data penerimaan barang',
            'links' => '<li class="active">Penerimaan</li>'
        ];
        $this->template->dashboard('pembelian/penerimaan/data', $data);
    }
    public function data()
    {
        $draw   = $_REQUEST['draw'];
        $length = $_REQUEST['length'];
        $start  = $_REQUEST['start'];
        $search = $_REQUEST['search']["value"];
        $total  = $this->Mpenerimaan->jumlah_data();
        $output = array();
        $output['draw'] = $draw;
        $output['recordsTotal'] = $output['recordsFiltered'] = $total;
        $output['data'] = array();
        if ($search != "") {
            $query = $this->Mpenerimaan->cari_data($search);
        } else {
            $query = $this->Mpenerimaan->tampil_data($start, $length);
        }
        if ($search != "") {
            $count = $this->Mpenerimaan->cari_data($search);
            $output['recordsTotal'] = $output['recordsFiltered'] = $count->num_rows();
        }
        $no = 1;
        foreach ($query->result_array() as $d) {
            $info = '<a href="javascript:void(0)" onclick="info(\'' . $d['id_terima'] . '\')"><i class="icon-eye8 text-black" data-toggle="tooltip" data-original-title="Info"></i></a>';
            $edit = '<a href="' . site_url('penerimaan/edit/' . $d['id_terima']) . '"><i class="icon-pencil7 text-green" data-toggle="tooltip" data-original-title="Edit"></i></a>';
            $hapus = '<a href="javascript:void(0)" onclick="hapus(\'' . $d['id_terima'] . '\')"><i class="icon-trash text-red" data-toggle="tooltip" data-original-title="Hapus"></i></a>';
            $output['data'][] = array(
                $no . '.',
                $d['id_terima'],
                $d['nama'],
                $d['nama_gudang'],
                format_biasa($d['tanggal_terima']),
                akuntansi($d['total_terima']),
                $d['nama_user'],
                status_span($d['status_terima'], 'penerimaan'),
                $info . '&nbsp;' . $edit . '&nbsp;' . $hapus
            );
            $no++;
        }
        echo json_encode($output);
    }
    public function create()
    {
        $data = [
            'title' => 'Penerimaan',
            'small' => 'Tambah Data Penerimaan Barang',
            'links' => '<li><a href="' . site_url('penerimaan') . '">Penerimaan</a></li><li class="active">Tambah</li>',
            'sidebar' => 'collapse',
            'gudang' => $this->Mgudang->getall()
        ];
        $this->template->dashboard('pembelian/penerimaan/tambah', $data);
    }
    public function store()
    {
        $post = $this->input->post(null, TRUE);
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('gudang', 'Gudang', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $tmp_data = $this->Mtmp_create->data();
            if (count($tmp_data) > 0) :
                $kode = $this->Mpenerimaan->kode();
                $this->Mpenerimaan->store($kode, $post);
                $json = array(
                    'status' => "0100",
                    'kode' => $kode,
                    'message' => 'Form tambah penerimaan barang berhasil dibuat.'
                );
            else :
                $json = array(
                    'status' => "0100",
                    'count' => count($tmp_data),
                    'message' => 'Anda belum melengkapi isian form penerimaan barang.'
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
            'title' => 'Penerimaan',
            'small' => 'Edit Data Penerimaan Barang',
            'links' => '<li><a href="' . site_url('penerimaan') . '">Penerimaan</a></li><li class="active">Edit</li>',
            'sidebar' => 'collapse',
            'gudang' => $this->Mgudang->getall(),
            'data' => $this->Mpenerimaan->show($kode)
        ];
        $this->template->dashboard('pembelian/penerimaan/edit', $data);
    }
    public function update()
    {
        $post = $this->input->post(null, TRUE);
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('gudang', 'Gudang', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $kode = $post['kode'];
            $tmp_data = $this->Mtmp_edit->tampil_data($kode);
            if (count($tmp_data) > 0) :
                $this->Mpenerimaan->update($kode, $post);
                $json = array(
                    'status' => "0100",
                    'kode' => $kode,
                    'message' => 'Form edit penerimaan barang berhasil dirubah.'
                );
            else :
                $json = array(
                    'status' => "0100",
                    'count' => count($tmp_data),
                    'message' => 'Anda belum melengkapi isian form penerimaan barang.'
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
            'title' => 'Penerimaan',
            'small' => 'Detail Penerimaan barang',
            'links' => '<li><a href="' . site_url('penerimaan') . '">Penerimaan</a></li><li class="active">Detail</li>',
            'data' => $this->Mpenerimaan->show($kode),
            'barang' => $this->Mtmp_edit->data_tmp($kode)
        ];
        $this->template->dashboard('pembelian/penerimaan/detail', $data);
    }
    public function info()
    {
        $kode = $this->input->get('kode');
        $data = [
            'name' => 'Detail Penerimaan Barang',
            'modallg' => 1,
            'data' => $this->Mpenerimaan->show($kode),
            'barang' => $this->Mtmp_edit->data_tmp($kode)
        ];
        $this->template->modal_info('pembelian/penerimaan/info', $data);
    }
    public function destroy()
    {
        $kode = $this->input->get('kode', true);
        $query = $this->Mpenerimaan->destroy($kode);
        if ($query == '0100') {
            $json = array(
                'status' => '0100',
                'message' => 'Data penerimaan barang berhasil dihapus'
            );
        } else {
            $json = array(
                'status' => '0101',
                'message' => 'Data penerimaan barang tidak bisa dihapus.'
            );
        }
        echo json_encode($json);
    }
}

/* End of file Penerimaan.php */
