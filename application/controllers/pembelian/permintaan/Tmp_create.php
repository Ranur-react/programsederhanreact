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
        $this->form_validation->set_rules('barang', 'Barang', 'required|callback_cekbarang');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required|greater_than[0]');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|greater_than[0]');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_message('greater_than', greater_than());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post(null, TRUE);
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
    public function cekbarang($barang)
    {
        $check = $this->db->where(['barang' => $barang, 'user' => id_user()])->get('tmp_permintaan');
        if ($check->num_rows() == 1) {
            $this->form_validation->set_message('cekbarang', 'Barang sudah ditambahkan, silahkan update jika ingin melakukan perubahan.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
}

/* End of file Tmp_create.php */
