<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tmp_create extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_logged_in();
        $this->load->model('katalog/Mproduk');
        $this->load->model('pembelian/permintaan/Mtmp_create');
    }
    public function data()
    {
        $query = $this->Mtmp_create->tampil_data();
        if ($query == null) {
            $data = [
                'status' => false
            ];
        } else {
            $total = 0;
            foreach ($query as $row) {
                $total = $total + ($row->harga * $row->jumlah);
                $result[] = [
                    'id' => $row->id,
                    'nama' => $row->nama_barang,
                    'satuan' => $row->singkatan_satuan,
                    'harga' => currency($row->harga),
                    'jumlah' => number_decimal($row->jumlah),
                    'total' => currency($row->harga * $row->jumlah)
                ];
            }
            $data = [
                'status' => true,
                'data' => $result,
                'total' => currency($total)
            ];
        }
        echo json_encode($data);
    }
    public function create()
    {
        $data = [
            'name' => 'Tambah Produk',
            'post' => 'permintaan/tmp-create/store',
            'class' => 'form_tmp',
            'backdrop' => 1,
            'produk' => $this->Mproduk->fetch_all()
        ];
        $this->template->modal_form('pembelian/permintaan/tmp_create/create', $data);
    }
    public function store()
    {
        $post = $this->input->post(null, TRUE);
        $this->form_validation->set_rules('produk', 'Produk', 'required|callback_cekproduk[' . $post['satuan'] . ']');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required|greater_than[0]');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|greater_than[0]');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_message('greater_than', greater_than());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
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
    public function cekproduk($produk, $satuan)
    {
        $check = $this->db->where(['satuan' => $satuan, 'user' => id_user()])->get('tmp_permintaan');
        if ($check->num_rows() == 1) {
            $this->form_validation->set_message('cekproduk', 'Produk sudah ditambahkan, silahkan update jika ingin melakukan perubahan.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    public function edit()
    {
        $kode = $this->input->get('kode');
        $query = $this->Mtmp_create->show($kode);
        $data = [
            'name' => 'Edit Produk',
            'post' => 'permintaan/tmp-create/update',
            'class' => 'form_tmp',
            'backdrop' => 1,
            'satuan' => $this->Mproduk->get_satuan($query['id_barang']),
            'data' => $query
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
                'status' => '0100',
                'token' => $this->security->get_csrf_hash(),
                'msg' => 'Data produk berhasil dirubah'
            );
        } else {
            $json = array(
                'status' => '0101',
                'token' => $this->security->get_csrf_hash(),
                'msg' => 'Data produk gagal dirubah'
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
            $json['status'] = '0100';
        } else {
            $json['status'] = '0101';
        }
        echo json_encode($json);
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
