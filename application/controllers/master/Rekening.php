<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekening extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_logged_in();
        $this->load->model('master/Mrekening');
    }
    public function index()
    {
        $data = [
            'title' => 'Rekening Bank',
            'links' => '<li class="active">Rekening Bank</li>'
        ];
        $this->template->dashboard('master/rekening/index', $data);
    }
    public function data()
    {
        $query = $this->Mrekening->fetch_all();
        if ($query == null) {
            $data = (int)0;
        } else {
            foreach ($query as $row) {
                $status = [
                    'class' => $row['status_account'] == 1 ? 'status-active' : 'status-pending',
                    'text' => $row['status_account'] == 1 ? 'Aktif' : 'Tidak Aktif'
                ];
                $data[] = [
                    'id' => $row['id_account'],
                    'nama' => $row['nama_bank'],
                    'kcb' => $row['kcb_account'],
                    'norek' => $row['norek_account'],
                    'pemilik' => $row['pemilik_account'],
                    'status' => '<span class="label status ' . $status['class'] . '">' . $status['text'] . '</span>'
                ];
            }
        }
        echo json_encode($data);
    }
    public function create()
    {
        $data = [
            'name' => 'Tambah Rekening Bank',
            'post' => 'rekening/store',
            'class' => 'form_create',
            'multipart' => 1,
            'bank' => $this->Mrekening->fetch_bank()
        ];
        $this->template->modal_form('master/rekening/create', $data);
    }
    public function store()
    {
        $this->form_validation->set_rules('code', 'Bank', 'required');
        $this->form_validation->set_rules('cabang', 'Kantor Cabang', 'required');
        $this->form_validation->set_rules('norek', 'No Rekening', 'required');
        $this->form_validation->set_rules('holder', 'Atasnama', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post(null, TRUE);
            $types = array('image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png', 'image/svg+xml');
            $mime = get_mime_by_extension($_FILES['gambar']['name']);
            if (isset($_FILES['gambar']['name']) && $_FILES['gambar']['name'] != "") {
                if (in_array($mime, $types)) {
                    $config['upload_path'] = pathImage() . 'images/bank';
                    $config['allowed_types'] = 'jpg|jpeg|png|svg';
                    $config['max_size'] = 819200;
                    $config['encrypt_name'] = TRUE;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('gambar')) {
                        $data['upload_data'] = $this->upload->data('file_name');
                        $link = 'images/bank/' . $data['upload_data'];
                    }
                    if ($_FILES['gambar']['size'] > 819200) {
                        $json = array(
                            'status' => '0101',
                            'token' => $this->security->get_csrf_hash(),
                            'error' => '<div class="text-red">Ukuran file tidak boleh melebihi 800KB</div>'
                        );
                    } else {
                        $this->Mrekening->store($post, $link);
                        $json = array(
                            'status' => '0100',
                            'token' => $this->security->get_csrf_hash(),
                            'pesan' => 'Data rekening bank telah disimpan'
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
                $this->Mrekening->store($post, $link = '');
                $json = array(
                    'status' => '0100',
                    'token' => $this->security->get_csrf_hash(),
                    'pesan' => 'Data rekening bank telah disimpan'
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
            'name' => 'Edit Rekening Bank',
            'post' => 'rekening/update',
            'class' => 'form_create',
            'multipart' => 1,
            'bank' => $this->Mrekening->fetch_bank(),
            'data' => $this->Mrekening->show($kode)
        ];
        $this->template->modal_form('master/rekening/edit', $data);
    }
    public function update()
    {
        $this->form_validation->set_rules('code', 'Bank', 'required');
        $this->form_validation->set_rules('cabang', 'Kantor Cabang', 'required');
        $this->form_validation->set_rules('norek', 'No Rekening', 'required');
        $this->form_validation->set_rules('holder', 'Atasnama', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post(null, TRUE);
            $types = array('image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png', 'image/svg+xml');
            $mime = get_mime_by_extension($_FILES['gambar']['name']);
            if (isset($_FILES['gambar']['name']) && $_FILES['gambar']['name'] != "") {
                if (in_array($mime, $types)) {
                    $config['upload_path'] = pathImage() . 'images/bank';
                    $config['allowed_types'] = 'jpg|jpeg|png|svg';
                    $config['max_size'] = 819200;
                    $config['encrypt_name'] = TRUE;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('gambar')) {
                        $data['upload_data'] = $this->upload->data('file_name');
                        $link = 'images/bank/' . $data['upload_data'];
                    }
                    if ($_FILES['gambar']['size'] > 819200) {
                        $json = array(
                            'status' => '0101',
                            'token' => $this->security->get_csrf_hash(),
                            'error' => '<div class="text-red">Ukuran file tidak boleh melebihi 800KB</div>'
                        );
                    } else {
                        $this->Mrekening->update($post, $link);
                        $json = array(
                            'status' => '0100',
                            'token' => $this->security->get_csrf_hash(),
                            'pesan' => 'Data rekening bank telah dirubah'
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
                $this->Mrekening->update($post, $link = '');
                $json = array(
                    'status' => '0100',
                    'token' => $this->security->get_csrf_hash(),
                    'pesan' => 'Data rekening bank telah dirubah'
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
        $action = $this->Mrekening->destroy($kode);
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
    public function status($kode)
    {
        $query = $this->Mrekening->show($kode);
        if ($query['status_account'] == 1) :
            $data = array('status_account' => 0);
        else :
            $data = array('status_account' => 1);
        endif;
        $this->db->where('id_account', $kode)->update('account_bank', $data);
        redirect('rekening');
    }
}

/* End of file Rekening.php */
