<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tmp_edit extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pembelian/penerimaan/Mtmp_edit');
    }
    public function data_tmp()
    {
        $kode = $this->input->get('kode');
        $d['data'] = $this->Mtmp_edit->data_tmp($kode);
        $this->load->view('pembelian/penerimaan/tmp_edit/data_tmp', $d);
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
