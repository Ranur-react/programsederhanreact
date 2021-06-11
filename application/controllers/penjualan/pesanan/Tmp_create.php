<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tmp_create extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('penjualan/pesanan/Mtmp_create');
    }
    public function index()
    {
        $d['data'] = $this->Mtmp_create->data();
        $this->load->view('penjualan/pesanan/tmp_create/data', $d);
    }
    public function create()
    {
        $data = [
            'name' => 'Tambah Barang',
            'post' => 'pesanan/tmp-create/store',
            'class' => 'form_tmp',
            'backdrop' => 1,
            'barang' => $this->Mtmp_create->getBarangDefault()
        ];
        $this->template->modal_form('penjualan/pesanan/tmp_create/create', $data);
    }
    public function get_penerimaan()
    {
        $idbarang = $this->input->get('idbarang');
        $terima = $this->Mtmp_create->getHargaTerima($idbarang, 'aktif');
        $default = $this->Mtmp_create->getHargaTerima($idbarang, 'default');
        $id_harga = $default['idharga'];
        $harga = $this->Mtmp_create->getHarga($id_harga);
        echo '<div class="form-group">';
        echo '<label class="required">Tanggal Penerimaan</label>';
        echo '<select class="form-control idharga" name="tanggal" id="tanggal">';
        echo '<option value="">Pilih Tanggal Penerimaan</option>';
        foreach ($terima as $t) {
            $select = $t['idharga'] == $id_harga ? 'selected' : null;
            echo '<option value="' . $t['idharga'] . '" ' . $select . '>' . $t['nomor'] . '</option>';
        }
        echo '</select>';
        echo '<div id="tanggal"></div>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label class="required">Harga</label>';
        echo '<select class="form-control" name="harga" id="harga">';
        echo '<option value="">Pilih Harga</option>';
        foreach ($harga as $h) {
            $selecthrg = $h['default'] == 1 ? 'selected' : null;
            echo '<option value="' . $h['idhrgdetail'] . '" ' . $selecthrg . '>' . rupiah($h['nominal']) . ' ' . $h['satuan'] . '</option>';
        }
        echo '</select>';
        echo '<div id="harga"></div>';
        echo '</div>';
    }
    public function get_harga()
    {
        $id_harga = $this->input->get('idharga');
        $harga = $this->Mtmp_create->getHarga($id_harga);
        var_dump($harga);
        echo '<div class="form-group">';
        echo '<label class="required">Harga</label>';
        echo '<select class="form-control" name="harga" id="harga">';
        echo '<option value="">Pilih Harga</option>';
        foreach ($harga as $h) {
            $selecthrg = $h['default'] == 1 ? 'selected' : null;
            echo '<option value="' . $h['idhrgdetail'] . '" ' . $selecthrg . '>' . rupiah($h['nominal']) . ' ' . $h['satuan'] . '</option>';
        }
        echo '</select>';
        echo '<div id="harga"></div>';
        echo '</div>';
    }
    public function store()
    {
        $post = $this->input->post(null, TRUE);
        $this->form_validation->set_rules('barang', 'Barang', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal penerimaan', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|greater_than[0]');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_message('greater_than', greater_than());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $this->Mtmp_create->store($post);
            $json = array(
                'status' => '0100',
                'message' => 'Barang berhasil ditambahkan'
            );
        } else {
            $json = array(
                'status' => '0101',
                'message' => 'Barang gagal ditambahkan'
            );
            foreach ($_POST as $key => $value) {
                $json['pesan'][$key] = form_error($key);
            }
        }
        echo json_encode($json);
    }
}

/* End of file Tmp_create.php */
