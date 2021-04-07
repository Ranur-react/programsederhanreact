<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tmp_create extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('master/Mbarang');
        $this->load->model('pembelian/permintaan/Mtmp_create');
    }
    public function data()
    {
        $d['data'] = $this->Mtmp_create->tampil_data();
        $this->load->view('pembelian/permintaan/tmp_create/data', $d);
    }
    public function create()
    {
        $data = [
            'name' => 'Tambah Barang',
            'post' => 'permintaan/tmp-create/store',
            'class' => 'form_tmp',
            'backdrop' => 1,
            'barang' => $this->Mbarang->fetch_all()
        ];
        $this->template->modal_form('pembelian/permintaan/tmp_create/create', $data);
    }
    public function store()
    {
        $post = $this->input->post(null, TRUE);
        $this->form_validation->set_rules('barang', 'Barang', 'required|callback_cekbarang[' . $post['satuan'] . ']');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required|greater_than[0]');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|greater_than[0]');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_message('greater_than', greater_than());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $this->Mtmp_create->store($post);
            $json = array(
                'status' => "0100",
                'message' => 'Barang berhasil ditambahkan'
            );
        } else {
            $json = array(
                'status' => "0101",
                'message' => 'Barang gagal ditambahkan'
            );
            foreach ($_POST as $key => $value) {
                $json['pesan'][$key] = form_error($key);
            }
        }
        echo json_encode($json);
    }
    public function cekbarang($barang, $satuan)
    {
        $check = $this->db->where(['satuan' => $satuan, 'user' => id_user()])->get('tmp_permintaan');
        if ($check->num_rows() == 1) {
            $this->form_validation->set_message('cekbarang', 'Barang sudah ditambahkan, silahkan update jika ingin melakukan perubahan.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    public function edit()
    {
        $kode = $this->input->get('kode');
        $data = [
            'name' => 'Edit Barang',
            'post' => 'permintaan/tmp-create/update',
            'class' => 'form_tmp',
            'backdrop' => 1,
            'satuan' => $this->Mbarang->get_satuan($kode),
            'data' => $this->Mtmp_create->show($kode)
        ];
        $this->template->modal_form('pembelian/permintaan/tmp_create/edit', $data);
    }
    public function update()
    {
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');
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
                'message' => 'Data barang berhasil dirubah'
            );
        } else {
            $json = array(
                'status' => "0101",
                'message' => 'Data barang gagal dirubah'
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
            $pesan['success'] = "0100";
        } else {
            $pesan['error'] = "0101";
        }
    }
    public function batal()
    {
        $action = $this->Mtmp_create->batal();
        if ($action) {
            $pesan['success'] = successCancel();
        } else {
            $pesan['error'] = errorDestroy();
        }
        echo json_encode($pesan);
    }
}

/* End of file Tmp_create.php */
