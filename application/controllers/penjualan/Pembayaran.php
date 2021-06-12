<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_user();
        $this->load->model('penjualan/pesanan/Mpesanan');
        $this->load->model('penjualan/Mpembayaran');
    }
    public function confirm()
    {
        $kode = $this->input->get('kode');
        $data = [
            'name' => 'Konfirmasi Pembayaran',
            'post' => 'pembayaran/store',
            'class' => 'form_create',
            'data' => $this->Mpesanan->show($kode)
        ];
        $this->template->modal_form('penjualan/pembayaran/confirm', $data);
    }
    public function store()
    {
        $this->form_validation->set_rules('tanggal', 'Tanggal transfer', 'required');
        $this->form_validation->set_rules('nilai', 'Jumlah transfer', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post(null, TRUE);
            $types = array('image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png', 'image/svg+xml');
            $mime = get_mime_by_extension($_FILES['gambar']['name']);
            if (isset($_FILES['gambar']['name']) && $_FILES['gambar']['name'] != "") {
                if (in_array($mime, $types)) {
                    $config['upload_path'] = pathImage() . 'images/bukti';
                    $config['allowed_types'] = 'jpg|jpeg|png|svg';
                    $config['max_size'] = 819200;
                    $config['encrypt_name'] = TRUE;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('gambar')) {
                        $data['upload_data'] = $this->upload->data('file_name');
                        $link = 'images/bukti/' . $data['upload_data'];
                    }
                    if ($_FILES['gambar']['size'] > 819200) {
                        $json = array(
                            'status' => '0101',
                            'error' => '<div class="text-red">Ukuran file tidak boleh melebihi 800KB</div>'
                        );
                    } else {
                        $this->Mpembayaran->store($post, $link);
                        $json = array(
                            'status' => '0100',
                            'pesan' => 'Konfirmasi pembayaran berhasil disimpan'
                        );
                    }
                } else {
                    $json = array(
                        'status' => '0101',
                        'error' => '<div class="text-red">Harap unggah file yang hanya berekstensi .jpeg / .jpg / .png.</div>'
                    );
                }
            } else {
                $json = array(
                    'status' => '0101',
                    'error' => '<div class="text-red">Silahkan upload bukti pembayaran.</div>'
                );
            }
        } else {
            $json['status'] = '0101';
            foreach ($_POST as $key => $value) {
                $json['pesan'][$key] = form_error($key);
            }
        }
        echo json_encode($json);
    }
    public function detail()
    {
        $kode = $this->input->get('kode');
        $data = [
            'name' => 'Detail Pembayaran Pesanan',
            'modallg' => 1,
            'data' => $this->Mpesanan->show($kode),
            'bayar' => $this->Mpembayaran->show($kode)
        ];
        $this->template->modal_info('penjualan/pembayaran/detail', $data);
    }
}

/* End of file Pembayaran.php */
