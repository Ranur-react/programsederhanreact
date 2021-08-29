<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tmp_edit extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('katalog/Mproduk');
        $this->load->model('pembelian/permintaan/Mpermintaan');
        $this->load->model('pembelian/permintaan/Mtmp_edit');
    }
    public function data()
    {
        $kode = $this->input->get('kode');
        $data = $this->Mpermintaan->show($kode);
        echo json_encode($data);
    }
    public function create()
    {
        $data = [
            'name' => 'Tambah Produk',
            'post' => 'permintaan/tmp-edit/store',
            'class' => 'form_tmp',
            'backdrop' => 1,
            'produk' => $this->Mproduk->fetch_all(),
            'kode' => $this->input->get('kode')
        ];
        $this->template->modal_form('pembelian/permintaan/tmp_edit/create', $data);
    }
    public function store()
    {
        $post = $this->input->post(null, TRUE);
        $param = $post['idminta'] . '||' . $post['produk'] . '||' . $post['satuan'];
        $this->form_validation->set_rules('produk', 'Produk', 'required|callback_cekproduk[' . $param . ']');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');
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
        echo json_encode($json);
    }
    public function cekproduk($field_value, $second_value)
    {
        list($idminta, $produk, $satuan) = explode('||', $second_value);
        $check = $this->db->where(['permintaan_detail' => $idminta, 'barang_detail' => $satuan])->get('permintaan_detail');
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
        $query = $this->Mtmp_edit->show($kode);
        $data = [
            'name' => 'Edit Produk',
            'post' => 'permintaan/tmp-edit/update',
            'class' => 'form_tmp',
            'backdrop' => 1,
            'satuan' => $this->Mproduk->get_satuan($query['id_barang']),
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
        $action = $this->Mtmp_edit->destroy($kode);
        if ($action == "0100") {
            $json = array(
                'status' => '0100',
                'msg' => 'Data produk berhasil dihapus'
            );
        } else {
            $json = array(
                'status' => '0101',
                'msg' => 'Data produk tidak bisa dihapus'
            );
        }
        echo json_encode($json);
    }
    public function batal()
    {
        $kode = $this->input->get('kode');
        $total = $this->db->from('penerimaan_minta')->where('id_minta_minta', $kode)->count_all_results();
        if ($total > 0) :
            $json = array(
                'status' => '0101',
                'msg' => 'Beberapa data produk sudah ada yang diterima'
            );
        else :
            $this->Mtmp_edit->batal($kode);
            $json = array(
                'status' => '0100',
                'msg' => successCancel()
            );
        endif;
        echo json_encode($json);
    }
}

/* End of file Tmp_edit.php */
