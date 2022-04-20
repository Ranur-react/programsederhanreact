<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Konversi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_logged_in();
        $this->load->model('katalog/Msatuan');
        $this->load->model('katalog/Mkonversi');
    }
    public function index()
    {
        $data = [
            'title' => 'Konversi Satuan',
            'links' => '<li class="active">Konversi</li>'
        ];
        $this->template->dashboard('katalog/konversi/index', $data);
    }
    public function data()
    {
        $query = $this->Mkonversi->fetch_all();
        if ($query == null) {
            $data = (int)0;
        } else {
            foreach ($query as $row) {
                $data[] = [
                    'id' => $row['id_konversi'],
                    'satuan_terbesar' => $row['satuan_terbesar'],
                    'satuan_terkecil' => $row['satuan_terkecil'],
                    'singkatan_satuan' => $row['singkatan_satuan'],
                    'nilai' => '1 ' . $row['singkatan_terbesar'] . ' = ' . number_decimal($row['nilai_konversi']) . ' ' . $row['singkatan_terkecil']
                ];
            }
        }
        echo json_encode($data);
    }
    public function create()
    {
        $data = [
            'name' => 'Tambah Konversi Satuan',
            'post' => 'konversi-satuan/store',
            'class' => 'form_create',
            'satuan' => $this->Msatuan->fetch_all()
        ];
        $this->template->modal_form('katalog/konversi/create', $data);
    }
    public function store()
    {
        $this->form_validation->set_rules('terbesar', 'Satuan terbesar', 'required');
        $this->form_validation->set_rules('terkecil', 'Satuan terkecil', 'required');
        $this->form_validation->set_rules('nilai', 'Nilai konversi', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post(null, TRUE);
            $this->Mkonversi->store($post);
            $json = array(
                'status' => '0100',
                'token' => $this->security->get_csrf_hash(),
                'pesan' => 'Data konversi satuan telah disimpan'
            );
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
    public function edit()
    {
        $id = $this->input->get('id');
        $data = [
            'name' => 'Edit Konversi Satuan',
            'post' => 'konversi-satuan/update',
            'class' => 'form_create',
            'satuan' => $this->Msatuan->fetch_all(),
            'data' => $this->Mkonversi->show($id)
        ];
        $this->template->modal_form('katalog/konversi/edit', $data);
    }
    public function update()
    {
        $this->form_validation->set_rules('terbesar', 'Satuan terbesar', 'required');
        $this->form_validation->set_rules('terkecil', 'Satuan terkecil', 'required');
        $this->form_validation->set_rules('nilai', 'Nilai konversi', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post(null, TRUE);
            $this->Mkonversi->update($post);
            $json = array(
                'status' => '0100',
                'token' => $this->security->get_csrf_hash(),
                'pesan' => 'Data konversi satuan telah dirubah'
            );
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
    public function destroy()
    {
        $id = $this->input->get('id');
        $action = $this->Mkonversi->destroy($id);
        if ($action) {
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
}

/* End of file Konversi.php */
