<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') == "sessDashboard")
            cek_user();
        else
            redirect('logout');
        $this->load->model('master/Mbarang');
    }
    public function index()
    {
        $data = [
            'title' => 'Barang',
            'small' => 'Menampilkan dan mengelola data barang',
            'links' => '<li class="active">Barang</li>',
            'data' => $this->Mbarang->fetch_all()
        ];
        $this->template->dashboard('master/barang/data', $data);
    }
    public function data()
    {
        $draw   = $_REQUEST['draw'];
        $length = $_REQUEST['length'];
        $start  = $_REQUEST['start'];
        $search = $_REQUEST['search']["value"];
        $status = '';
        $total  = $this->Mbarang->jumlah_data();
        $output = array();
        $output['draw'] = $draw;
        $output['recordsTotal'] = $output['recordsFiltered'] = $total;
        $output['data'] = array();
        if ($search != "") {
            $query = $this->Mbarang->cari_data($search, $status);
        } else {
            $query = $this->Mbarang->tampil_data($start, $length, $status);
        }
        if ($search != "") {
            $count = $this->Mbarang->cari_data($search, $status);
            $output['recordsTotal'] = $output['recordsFiltered'] = $count->num_rows();
        }
        $no = 1;
        foreach ($query->result_array() as $d) {
            $kode = $d['id_barang'];
            $data_kategori = $this->Mbarang->barang_kategori($kode);
            $result = '';
            foreach ($data_kategori as $data_kategori) {
                $result .= $data_kategori['nama_kategori'] . '<br>';
            }
            $edit = '<a href="' . site_url('barang/edit/' . $d['id_barang']) . '"><i class="icon-pencil7 text-green" data-toggle="tooltip" data-original-title="Edit"></i></a>';
            $hapus = '<a href="javascript:void(0)" onclick="hapus(\'' . $d['id_barang'] . '\')"><i class="icon-trash text-red" data-toggle="tooltip" data-original-title="Hapus"></i></a>';
            $output['data'][] = array(
                $no . '.',
                $d['nama_barang'],
                '',
                '',
                rtrim($result, ''),
                status_span($d['status_barang'], 'aktif'),
                $edit . '&nbsp;' . $hapus
            );
            $no++;
        }
        echo json_encode($output);
    }
    public function create()
    {
        $data = [
            'title' => 'Barang',
            'small' => 'Tambah data barang',
            'links' => '<li><a href="' . site_url('barang') . '">Barang</a></li><li class="active">Tambah</li>'
        ];
        $this->template->dashboard('master/barang/create', $data);
    }
    public function store()
    {
        $post = $this->input->post(null, TRUE);
        $this->form_validation->set_rules('nama', 'Nama barang', 'trim|required');
        $this->form_validation->set_rules('slug', 'Slug', 'trim|required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $this->Mbarang->store($post);
            $json = array(
                'status' => "0100",
                'pesan' => "Data barang telah disimpan"
            );
        } else {
            $json['status'] = "0111";
            foreach ($_POST as $key => $value) {
                $json['pesan'][$key] = form_error($key);
            }
        }
        echo json_encode($json);
    }
    public function edit($kode)
    {
        $data = [
            'title' => 'Barang',
            'small' => 'Mengubah data barang',
            'links' => '<li><a href="' . site_url('barang') . '">Barang</a></li><li class="active">Edit</li>',
            'data' => $this->Mbarang->show($kode),
            'barang_desc' => $this->Mbarang->barang_desc($kode),
            'barang_kategori' => $this->Mbarang->barang_kategori($kode),
            'barang_satuan' => $this->Mbarang->barang_satuan($kode)
        ];
        $this->template->dashboard('master/barang/edit', $data);
    }
    public function update()
    {
        $post = $this->input->post(null, TRUE);
        $this->form_validation->set_rules('nama', 'Nama barang', 'trim|required');
        $this->form_validation->set_rules('slug', 'Slug', 'trim|required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $this->Mbarang->update($post);
            $json = array(
                'status' => "0100",
                'pesan' => "Data barang telah dirubah"
            );
        } else {
            $json['status'] = "0111";
            foreach ($_POST as $key => $value) {
                $json['pesan'][$key] = form_error($key);
            }
        }
        echo json_encode($json);
    }
    public function destroy()
    {
        $kode = $this->input->get('kode', true);
        $action = $this->Mbarang->destroy($kode);
        if ($action) {
            $json = array(
                'status' => "0100",
                "message" => successDestroy()
            );
        } else {
            $json = array(
                'status' => "0101",
                "message" => errorDestroy()
            );
        }
        echo json_encode($json);
    }

}

/* End of file Barang.php */
