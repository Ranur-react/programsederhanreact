<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tmp_edit extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('master/Mbarang');
        $this->load->model('pembelian/permintaan/Mtmp_edit');
    }
    public function data()
    {
        $kode = $this->input->get('kode');
        $d['data'] = $this->Mtmp_edit->tampil_data($kode);
        $this->load->view('pembelian/permintaan/tmp_edit/data', $d);
    }
    public function create()
    {
        $data = [
            'name' => 'Tambah Barang',
            'post' => 'permintaan/tmp-edit/store',
            'class' => 'form_tmp',
            'backdrop' => 1,
            'barang' => $this->Mbarang->fetch_all(),
            'kode' => $this->input->get('kode')
        ];
        $this->template->modal_form('pembelian/permintaan/tmp_edit/create', $data);
    }
    public function store()
    {
        $post = $this->input->post(null, TRUE);
        $param = $post['id_permintaan'] . '||' . $post['barang'] . '||' . $post['satuan'];
        $this->form_validation->set_rules('barang', 'Barang', 'required|callback_cekbarang[' . $param . ']');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required|greater_than[0]');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|greater_than[0]');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_message('greater_than', greater_than());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $this->Mtmp_edit->store($post);
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
    public function cekbarang($field_value, $second_value)
    {
        list($kode, $barang, $satuan) = explode('||', $second_value);
        $check = $this->db->where(['permintaan_detail' => $kode, 'barang_detail' => $satuan])->get('permintaan_detail');
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
        $query = $this->Mtmp_edit->show($kode);
        $data = [
            'name' => 'Edit Barang',
            'post' => 'permintaan/tmp-edit/update',
            'class' => 'form_tmp',
            'backdrop' => 1,
            'satuan' => $this->Mbarang->get_satuan($query['id_barang']),
            'data' => $query
        ];
        $this->template->modal_form('pembelian/permintaan/tmp_edit/edit', $data);
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
            $this->Mtmp_edit->update($post);
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
        $action = $this->Mtmp_edit->destroy($kode);
        if ($action == true) {
            $pesan['success'] = "0100";
        } else {
            $pesan['error'] = "0101";
        }
    }
    public function batal()
    {
        $kode = $this->input->get('kode');
        $total = 0;
        if ($total > 0) :
            $json['error'] = 'Beberapa data barang sudah ada yang diterima';
        else :
            $this->Mtmp_edit->batal($kode);
            $json['success'] = successCancel();
        endif;
        echo json_encode($json);
    }
}

/* End of file Tmp_edit.php */
