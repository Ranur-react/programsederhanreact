<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pelunasan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_logged_in();
        $this->load->model('pembelian/penerimaan/Mpenerimaan');
        $this->load->model('pembelian/penerimaan/Mpelunasan');
    }
    public function index($kode)
    {
        $data = [
            'title' => 'Pelunasan',
            'small' => 'Kelola pelunasan penerimaan',
            'links' => '<li class="active">Pelunasan</li>',
            'data' => $this->Mpenerimaan->show($kode)
        ];
        $this->template->dashboard('pembelian/penerimaan/pelunasan/index', $data);
    }
    public function data()
    {
        $idterima = $this->input->get('idterima');
        $data = $this->Mpenerimaan->show($idterima);
        echo json_encode($data);
    }
    public function create()
    {
        $idterima = $this->input->get('idterima');
        $data = [
            'name' => 'Pelunasan',
            'post' => 'penerimaan/pelunasan/store',
            'class' => 'form_create',
            'data' => $this->Mpenerimaan->show($idterima)
        ];
        $this->template->modal_form('pembelian/penerimaan/pelunasan/create', $data);
    }
    public function store()
    {
        $this->form_validation->set_rules('tanggal', 'Tanggal bayar', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah bayar', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post(null, TRUE);
            $this->Mpelunasan->store($post);
            $json = array(
                'status' => '0100',
                'token' => $this->security->get_csrf_hash(),
                'msg' => 'Pelunasan berhasil ditambahkan'
            );
        } else {
            $json = array(
                'status' => '0101',
                'token' => $this->security->get_csrf_hash(),
                'msg' => 'Pelunasan gagal ditambahkan'
            );
            foreach ($_POST as $key => $value) {
                $json['pesan'][$key] = form_error($key);
            }
        }
        echo json_encode($json);
    }
    public function destroy()
    {
        $id = $this->input->get('id', true);
        $query = $this->Mpelunasan->destroy($id);
        if ($query == '0100') {
            $json = array(
                'status' => '0100',
                'msg' => 'Pelunasan berhasil dihapus'
            );
        } else {
            $json = array(
                'status' => '0101',
                'msg' => 'Pelunasan gagal dihapus.'
            );
        }
        echo json_encode($json);
    }
}

/* End of file Pelunasan.php */
