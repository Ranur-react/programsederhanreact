<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tmp_edit extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_logged_in();
        $this->load->model('pembelian/penerimaan/Mpenerimaan');
        $this->load->model('pembelian/penerimaan/Mtmp_edit');
        $this->load->model('pembelian/penerimaan/Mtmp_permintaan');
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
        $iddetail = $this->input->get('iddetail');
        $cek_user = $this->db->where('iddetail', $iddetail)->get('tmp_penerimaan');
        $cek_barang = $this->db->where('minta_detail', $iddetail)->where_not_in('terima_detail', $idterima)->get('terima_detail');
        if ($cek_user->num_rows() > 0) :
            echo '0101';
        elseif ($cek_barang->num_rows() > 0) :
            echo '0102';
        else :
            $data = [
                'name' => 'Tambah Produk',
                'post' => 'penerimaan/tmp-edit/store',
                'class' => 'form_tmp',
                'backdrop' => 1,
                'terima' => $this->Mpenerimaan->show($idterima),
                'data' => $this->Mtmp_permintaan->show($iddetail)
            ];
            $this->template->modal_form('pembelian/penerimaan/tmp_edit/create', $data);
        endif;
    }
    public function store()
    {
        $post = $this->input->post(null, TRUE);
        $cek_user = $this->db->from('terima_detail')->where('minta_detail', $post['iddetail'])->count_all_results();
        if ($cek_user > 0) :
            $json = array(
                'status' => '0100',
                'count' => $cek_user,
                'token' => $this->security->get_csrf_hash(),
                'msg' => 'Produk sudah ditambahkan, silahkan update jika ingin melakukan perubahan.'
            );
        else :
            $this->form_validation->set_rules('harga', 'Harga', 'required|greater_than[0]');
            $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|greater_than[0]');
            $this->form_validation->set_message('required', errorRequired());
            $this->form_validation->set_message('greater_than', greater_than());
            $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
            if ($this->form_validation->run() == TRUE) {
                $this->Mtmp_edit->store($post);
                $json = array(
                    'status' => '0100',
                    'token' => $this->security->get_csrf_hash(),
                    'msg' => 'Produk berhasil ditambahkan'
                );
            } else {
                $json = array(
                    'status' => '0101',
                    'token' => $this->security->get_csrf_hash(),
                    'msg' => 'Produk gagal ditambahkan'
                );
                foreach ($_POST as $key => $value) {
                    $json['pesan'][$key] = form_error($key);
                }
            }
        endif;
        echo json_encode($json);
    }
    public function edit()
    {
        $id = $this->input->get('id');
        $data = [
            'name' => 'Edit Produk',
            'post' => 'penerimaan/tmp-edit/update',
            'class' => 'form_tmp',
            'backdrop' => 1,
            'data' => $this->Mtmp_edit->show($id)
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
            $proses = $this->Mtmp_edit->update($post);
            $json = array(
                'status' => '0100',
                'token' => $this->security->get_csrf_hash(),
                'count' => $proses['status'] == true ? 0 : 1,
                'msg' => $proses['msg']
            );
        } else {
            $json = array(
                'status' => '0101',
                'token' => $this->security->get_csrf_hash(),
                'msg' => 'Produk gagal dirubah'
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
        $action = $this->Mtmp_edit->destroy($id);
        if ($action['status'] == true) {
            $json = array(
                'status' => '0100',
                'msg' => $action['msg']
            );
        } else {
            $json = array(
                'status' => '0101',
                'msg' => $action['msg']
            );
        }
        echo json_encode($json);
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
}

/* End of file Tmp_edit.php */
