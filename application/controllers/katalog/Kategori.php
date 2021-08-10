<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_logged_in();
        $this->load->model('katalog/Mkategori');
    }
    public function index()
    {
        $data = [
            'title' => 'Kategori',
            'links' => '<li class="active">Kategori</li>'
        ];
        $this->template->dashboard('katalog/kategori/index', $data);
    }
    public function data()
    {
        $draw   = $_REQUEST['draw'];
        $length = $_REQUEST['length'];
        $start  = $_REQUEST['start'];
        $search = $_REQUEST['search']["value"];
        $total  = $this->Mkategori->count_all();
        $output = array();
        $output['draw'] = $draw;
        $output['recordsTotal'] = $output['recordsFiltered'] = $total;
        $output['data'] = array();
        if ($search != "") {
            $query = $this->Mkategori->search_data($search);
        } else {
            $query = $this->Mkategori->fetch_all($start, $length);
        }
        if ($search != "") {
            $count = $this->Mkategori->search_data($search);
            $output['recordsTotal'] = $output['recordsFiltered'] = $count->num_rows();
        }
        $no = 1;
        foreach ($query->result_array() as $d) {
            $edit = '<a href="javascript:void(0)" onclick="edit(\'' . $d['id'] . '\')"><i class="icon-pencil7 text-green" title="Edit"></i></a>';
            $hapus = '<a href="javascript:void(0)" onclick="destroy(\'' . $d['id'] . '\')"><i class="icon-trash text-red" title="Hapus"></i></a>';
            $output['data'][] = array(
                $no . '.',
                $d['nama'],
                $d['image'] != '' ? '<img src="' . assets() . $d['image'] . '" alt="' . $d['nama'] . '">' : '',
                $edit . '&nbsp;' . $hapus
            );
            $no++;
        }
        echo json_encode($output);
    }
    public function create()
    {
        $data = [
            'name' => 'Tambah Kategori',
            'post' => 'kategori/store',
            'class' => 'form_create',
            'multipart' => 1,
            'parent' => $this->Mkategori->get_all()
        ];
        $this->template->modal_form('katalog/kategori/create', $data);
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
            $types = array('image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png', 'image/svg+xml');
            $mime = get_mime_by_extension($_FILES['gambar']['name']);
            if (isset($_FILES['gambar']['name']) && $_FILES['gambar']['name'] != "") {
                if (in_array($mime, $types)) {
                    $config['upload_path'] = pathImage() . 'images/kategori';
                    $config['allowed_types'] = 'jpg|jpeg|png|svg';
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
                            'status' => '0101',
                            'token' => $this->security->get_csrf_hash(),
                            'error' => '<div class="text-red">Ukuran file tidak boleh melebihi 800KB</div>'
                        );
                    } else {
                        $this->Mkategori->store($post, $link);
                        $json = array(
                            'status' => '0100',
                            'token' => $this->security->get_csrf_hash(),
                            'msg' => 'Data kategori telah disimpan'
                        );
                    }
                } else {
                    $json = array(
                        'status' => '0101',
                        'token' => $this->security->get_csrf_hash(),
                        'error' => '<div class="text-red">Harap unggah file yang hanya berekstensi .jpeg / .jpg / .png.</div>'
                    );
                }
            } else {
                $this->Mkategori->store($post, $link = '');
                $json = array(
                    'status' => '0100',
                    'token' => $this->security->get_csrf_hash(),
                    'msg' => 'Data kategori telah disimpan'
                );
            }
        } else {
            $json = array(
                'status' => '0101',
                'token' => $this->security->get_csrf_hash()
            );
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
            'parent' => $this->Mkategori->get_all()
        ];
        $this->template->modal_form('katalog/kategori/edit', $data);
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
            $types = array('image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png', 'image/svg+xml');
            $mime = get_mime_by_extension($_FILES['gambar']['name']);
            if (isset($_FILES['gambar']['name']) && $_FILES['gambar']['name'] != "") {
                if (in_array($mime, $types)) {
                    $config['upload_path'] = pathImage() . 'images/kategori';
                    $config['allowed_types'] = 'jpg|jpeg|png|svg';
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
                            'status' => '0101',
                            'token' => $this->security->get_csrf_hash(),
                            'error' => '<div class="text-red">Ukuran file tidak boleh melebihi 800KB</div>'
                        );
                    } else {
                        $this->Mkategori->update($post, $link);
                        $json = array(
                            'status' => '0100',
                            'token' => $this->security->get_csrf_hash(),
                            'msg' => 'Data kategori telah dirubah'
                        );
                    }
                } else {
                    $json = array(
                        'status' => '0101',
                        'token' => $this->security->get_csrf_hash(),
                        'error' => '<div class="text-red">Harap unggah file yang hanya berekstensi .jpeg / .jpg / .png.</div>'
                    );
                }
            } else {
                $this->Mkategori->update($post, $link = '');
                $json = array(
                    'status' => '0100',
                    'token' => $this->security->get_csrf_hash(),
                    'msg' => 'Data kategori telah disimpan'
                );
            }
        } else {
            $json = array(
                'status' => '0101',
                'token' => $this->security->get_csrf_hash()
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
        $action = $this->Mkategori->destroy($kode);
        if ($action) {
            $json = array(
                'status' => '0100',
                'msg' => successDestroy()
            );
        } else {
            $json = array(
                'status' => '0101',
                'msg' => errorDestroy()
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
