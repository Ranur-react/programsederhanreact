<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tmp_create extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_logged_in();
        $this->load->model('pembelian/penerimaan/Mtmp_create');
        $this->load->model('pembelian/penerimaan/Mtmp_permintaan');
    }
    public function data()
    {
        $query = $this->Mtmp_create->fetch_all();
        if ($query == null) {
            $data = [(int)0];
        } else {
            $total = 0;
            foreach ($query as $row) {
                $total = $total + ($row->harga * $row->jumlah);
                $data[] = [
                    'id' => (int)$row->id,
                    'iddetail' => (int)$row->iddetail,
                    'produk' => $row->nama_barang,
                    'satuan' => $row->singkatan_satuan,
                    'harga' => (int)$row->harga,
                    'jumlah' => (int)$row->jumlah,
                    'subtotal' => $row->harga * $row->jumlah
                ];
            }
        }
        echo json_encode($data);
    }
    public function create()
    {
        $iddetail = $this->input->get('iddetail');
        $cek_user = $this->db->where(['iddetail' => $iddetail, 'user' => id_user()])->get('tmp_penerimaan');
        $cek_barang = $this->db->where('iddetail', $iddetail)->where_not_in('user', id_user())->get('tmp_penerimaan');
        if ($cek_user->num_rows() > 0) :
            echo '0101';
        elseif ($cek_barang->num_rows() > 0) :
            echo '0102';
        else :
            $data = [
                'name' => 'Tambah Produk',
                'post' => 'penerimaan/tmp-create/store',
                'class' => 'form_tmp',
                'backdrop' => 1,
                'data' => $this->Mtmp_permintaan->show($iddetail)
            ];
            $this->template->modal_form('pembelian/penerimaan/tmp_create/create', $data);
        endif;
    }
    public function store()
    {
        $this->form_validation->set_rules('harga', 'Harga', 'required|greater_than[0]');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|greater_than[0]');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_message('greater_than', greater_than());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post(null, TRUE);
            $this->Mtmp_create->store($post);
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
        echo json_encode($json);
    }
    public function edit()
    {
        $id = $this->input->get('id');
        $data = [
            'name' => 'Edit Produk',
            'post' => 'penerimaan/tmp-create/update',
            'class' => 'form_tmp',
            'backdrop' => 1,
            'data' => $this->Mtmp_create->show($id)
        ];
        $this->template->modal_form('pembelian/penerimaan/tmp_create/edit', $data);
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
            $this->Mtmp_create->update($post);
            $json = array(
                'status' => '0100',
                'token' => $this->security->get_csrf_hash(),
                'msg' => 'Produk berhasil dirubah'
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
        $action = $this->Mtmp_create->destroy($id);
        if ($action == true) {
            $pesan['status'] = true;
        } else {
            $pesan['status'] = false;
        }
        echo json_encode($pesan);
    }
    public function batal()
    {
        $action = $this->Mtmp_create->batal();
        if ($action) {
            $json = array(
                'status' => '0100',
                'msg' => successCancel()
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

/* End of file Tmp_create.php */
