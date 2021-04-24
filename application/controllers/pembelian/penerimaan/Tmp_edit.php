<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tmp_edit extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') == "sessDashboard")
            cek_user();
        else
            redirect('logout');
        $this->load->model('pembelian/penerimaan/Mpenerimaan');
        $this->load->model('pembelian/penerimaan/Mtmp_edit');
    }
    public function data_supplier()
    {
        $kode = $this->input->get('kode');
        $d['data'] = $this->Mtmp_edit->data_supplier($kode);
        $this->load->view('pembelian/penerimaan/tmp_edit/data_supplier', $d);
    }
    public function check_permintaan()
    {
        $id_terima = $this->input->get('id_terima');
        $id_minta = $this->input->get('id_minta');
        $data = $this->Mtmp_edit->check_permintaan($id_terima, $id_minta);
        if ($data == '0100') :
            $json = array(
                'status' => '0100'
            );
        elseif ($data == '0101') :
            $json = array(
                'status' => '0101',
                'pesan' => 'Supplier yang dipilih tidak sama.'
            );
        else :
            $json = array(
                'status' => '0102',
                'pesan' => 'Data permintaan telah diinputkan sebelumnya.'
            );
        endif;
        echo json_encode($json);
    }
    public function data_tmp()
    {
        $kode = $this->input->get('kode');
        $d['data'] = $this->Mtmp_edit->data_tmp($kode);
        $this->load->view('pembelian/penerimaan/tmp_edit/data_tmp', $d);
    }
    public function create()
    {
        $id_detail = $this->input->get('id_detail');
        $id_terima = $this->input->get('id_terima');
        $data = [
            'name' => 'Tambah Barang',
            'post' => 'penerimaan/tmp-edit/store',
            'class' => 'form_tmp',
            'backdrop' => 1,
            'terima' => $this->Mpenerimaan->show($id_terima),
            'data' => $this->Mtmp_edit->show_minta($id_detail)
        ];
        $this->template->modal_form('pembelian/penerimaan/tmp_edit/create', $data);
    }
    public function edit()
    {
        $kode = $this->input->get('kode');
        $data = [
            'name' => 'Edit Barang',
            'post' => 'penerimaan/tmp-edit/update',
            'class' => 'form_tmp',
            'backdrop' => 1,
            'data' => $this->Mtmp_edit->show($kode)
        ];
        $this->template->modal_form('pembelian/penerimaan/tmp_edit/edit', $data);
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
            $json['status'] = "0100";
        } else {
            $json['status'] = "0101";
        }
        echo json_encode($json);
    }
}

/* End of file Tmp_edit.php */
