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
    public function get_alamat()
    {
        $idcustomer = $this->input->get('idcustomer');
        $query = $this->db->where('customer_alamat', $idcustomer)->get('customer_alamat')->result_array();
        $data = '<option value=""></option>';
        foreach ($query as $row) {
            $data .= '<option value="' . $row['id_alamat'] . '">' . $row['penerima_alamat'] . ' - ' . $row['detail_alamat'] . '</option>';
        }
        echo $data;
    }
    public function get_bank()
    {
        $idcustomer = $this->input->get('idcustomer');
        $idmetode = $this->input->get('idmetode');
        $data = $this->db->from('customer_bank')
            ->join('bank_code', 'bank_cs_bank=id_bank')
            ->where('customer_cs_bank', $idcustomer)
            ->get()->result_array();
        if ($idmetode == '1') {
            echo '';
        } else {
            echo '<div class="col-lg-6 col-sm-6 col-md-6">';
            echo '<div class="form-group">';
            echo '<label class="required">Pilih Bank</label>';
            echo '<select class="form-control" name="bank" id="bank">';
            echo '<option value="">Pilih Bank</option>';
            foreach ($data as $d) {
                echo '<option value="' . $d['id_cs_bank'] . '">' . $d['nama_bank'] . ' a/n ' . $d['pemilik_cs_bank'] . ' ' . $d['norek_cs_bank'] . '</option>';
            }
            echo '</select>';
            echo '</div>';
            echo '</div>';
        }
    }
}

/* End of file Tmp_create.php */
