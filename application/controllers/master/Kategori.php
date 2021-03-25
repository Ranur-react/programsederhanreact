<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') == "sessDashboard")
            cek_user();
        else
            redirect('logout');
        $this->load->model('master/Mkategori');
    }
    public function index()
    {
        $data = [
            'title' => 'Kategori',
            'small' => 'Menampilkan dan mengelola data kategori',
            'links' => '<li class="active">Kategori</li>',
            'data' => $this->Mkategori->fetch_all()
        ];
        $this->template->dashboard('master/kategori/data', $data);
    }
    public function create()
    {
        $data = [
            'name' => 'Tambah Kategori',
            'post' => 'kategori/store',
            'class' => 'form_create',
            'multipart' => 1,
            'parent' => $this->Mkategori->fetch_all()
        ];
        $this->template->modal_form('master/kategori/create', $data);
    }
    public function store()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('slug', 'Slug', 'required');
        $this->form_validation->set_rules('parent', 'Sub kategori', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post(null, TRUE);
            $types = array('image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
            $mime = get_mime_by_extension($_FILES['gambar']['name']);
            if (isset($_FILES['gambar']['name']) && $_FILES['gambar']['name'] != "") {
                if (in_array($mime, $types)) {
                    $config['upload_path'] = pathKategori() . 'images/kategori';
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['max_size'] = 819200;
                    $config['encrypt_name'] = TRUE;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('gambar')) {
                        $data['upload_data'] = $this->upload->data('file_name');
                        $link = pathKategori() . 'images/kategori/' . $data['upload_data'];
                    }
                    if ($_FILES['gambar']['size'] > 819200) {
                        $json = array(
                            "status" => "0111",
                            "error" => "<div class='text-red'>Ukuran file tidak boleh melebihi 800KB</div>"
                        );
                    } else {
                        $this->Mkategori->store($post, $link);
                        $json = array(
                            'status' => "0100",
                            'pesan' => "Data kategori telah disimpan"
                        );
                    }
                } else {
                    $json = array(
                        "status" => "0111",
                        "error" => "<div class='text-red'>Harap unggah file yang hanya berekstensi .jpeg / .jpg / .png.</div>"
                    );
                }
            } else {
                $this->Mkategori->store($post, $link = '');
                $json = array(
                    'status' => "0100",
                    'pesan' => "Data kategori telah disimpan"
                );
            }
        } else {
            $json['status'] = "0111";
            foreach ($_POST as $key => $value) {
                $json['pesan'][$key] = form_error($key);
            }
        }
        echo json_encode($json);
    }
    public function edit()
    {
        $kode = $this->input->get('kode');
        $data = [
            'name' => 'Edit Kategori',
            'post' => 'kategori/update',
            'class' => 'form_create',
            'multipart' => 1,
            'data' => $this->Mkategori->show($kode),
            'parent' => $this->Mkategori->fetch_all()
        ];
        $this->template->modal_form('master/kategori/edit', $data);
    }
    public function update()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('slug', 'Slug', 'required');
        $this->form_validation->set_rules('parent', 'Sub kategori', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post(null, TRUE);
            $types = array('image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
            $mime = get_mime_by_extension($_FILES['gambar']['name']);
            if (isset($_FILES['gambar']['name']) && $_FILES['gambar']['name'] != "") {
                if (in_array($mime, $types)) {
                    $config['upload_path'] = pathKategori() . 'images/kategori';
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['max_size'] = 819200;
                    $config['encrypt_name'] = TRUE;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('gambar')) {
                        $data['upload_data'] = $this->upload->data('file_name');
                        $link = 'images/kategori/' . $data['upload_data'];
                    }
                    if ($_FILES['gambar']['size'] > 819200) {
                        $json = array(
                            "status" => "0111",
                            "error" => "<div class='text-red'>Ukuran file tidak boleh melebihi 800KB</div>"
                        );
                    } else {
                        $this->Mkategori->update($post, $link);
                        $json = array(
                            'status' => "0100",
                            'pesan' => "Data kategori telah dirubah"
                        );
                    }
                } else {
                    $json = array(
                        "status" => "0111",
                        "error" => "<div class='text-red'>Harap unggah file yang hanya berekstensi .jpeg / .jpg / .png.</div>"
                    );
                }
            } else {
                $this->Mkategori->update($post, $link = '');
                $json = array(
                    'status' => "0100",
                    'pesan' => "Data kategori telah dirubah"
                );
            }
        } else {
            $json['status'] = "0111";
            foreach ($_POST as $key => $value) {
                $json['pesan'][$key] = form_error($key);
            }
        }
        echo json_encode($json);
    }
    public function destroy()
    {
        $kode = $this->input->get('kode', true);
        $action = $this->Mkategori->destroy($kode);
        if ($action == true) {
            $json = array(
                "status" => "0100",
                "message" => successDestroy()
            );
        } else {
            $json = array(
                "status" => "0101",
                "message" => errorDestroy()
            );
        }
        echo json_encode($json);
    }
    // pencarian kategori berdasarkan nama
    public function kategori_by_nama()
    {
        $filter_nama = $this->input->get('filter_nama');
        $data = $this->Mkategori->kategori_by_nama($filter_nama);
        $json = array();
        foreach ($data as $d) {
            $json[] = array(
                'id' => $d['id'],
                'nama' => $d['nama']
            );
        }
        echo json_encode($json);
    }
}
