<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengguna extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_logged_in();
        $this->load->model('master/Mroles');
        $this->load->model('master/Mgudang');
        $this->load->model('master/Mpengguna');
    }
    public function index()
    {
        $data = [
            'title' => 'Pengguna',
            'links' => '<li class="active">Pengguna</li>'
        ];
        $this->template->dashboard('master/pengguna/index', $data);
    }
    public function data()
    {
        $query = $this->Mpengguna->fetch_all();
        $data = array();
        $no = $_GET['start'];
        foreach ($query as $value) {
            $kode = $value->id_user;
            $jenis = $value->jenis_user;
            if ($jenis == 1) :
                $tabel = 'user_office';
                $gudang = '';
            else :
                $tabel = 'user_gudang';
                $data_gudang = $this->db->from($tabel)->join('role', 'role_level=id_role')->join('gudang', 'gudang_level=id_gudang')->where('user_level', $kode)->get()->row_array();
                $gudang = '<div class="text-muted text-size-small"><span class="status-mark position-left"></span>' . $data_gudang['nama_gudang'] . '</div>';
            endif;
            $level = $this->db->from($tabel)->join('role', 'role_level=id_role')->where('user_level', $kode)->get()->row_array();
            $api = $this->db->where('user_api', $kode)->get('user_api')->row_array();
            if ($api != null) {
                $link_api = '<i class="icon-copy4 text-purple"></i>';
            } else {
                $link_api = '<a href="javascript:void(0)" onclick="generate(\'' . $value->id_user . '\')"><i class="icon-plus-circle2 text-black" title="Tambah"></i></a>';
            }
            $no++;
            $row = array();
            $row[] = $no . '.';
            $row[] = $value->nama_user;
            $row[] = $value->username;
            $row[] = $level['nama_role'] . '' . $gudang;
            $row[] = $link_api;
            $row[] = '<a href="javascript:void(0)" onclick="status(\'' . $value->id_user . '\')">' . status_span($value->status_user, 'aktif') . '</a>';
            $row[] = '<a href="javascript:void(0)" onclick="edit(\'' . $value->id_user . '\')"><i class="icon-pencil7 text-green" title="Edit"></i></a> <a href="javascript:void(0)" onclick="destroy(\'' . $value->id_user . '\')"><i class="icon-trash text-red" title="Hapus"></i></a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Mpengguna->count_all(),
            "recordsFiltered" => $this->Mpengguna->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function create()
    {
        $data = [
            'name' => 'Tambah Pengguna',
            'post' => 'pengguna/store',
            'class' => 'form_create',
            'role' => $this->Mroles->fetch_all()
        ];
        $this->template->modal_form('master/pengguna/create', $data);
    }
    public function get_gudang()
    {
        $role = $this->input->get('role');
        $row = $this->Mroles->show($role);
        if ($row['jenis_role'] == 2) :
            $gudang = $this->Mgudang->fetch_all();
            echo '<div class="form-group">';
            echo '<label>Gudang</label>';
            echo '<select name="gudang" id="gudang" class="form-control">';
            echo '<option value="">Pilih</option>';
            foreach ($gudang as $d) {
                echo '<option value="' . $d['id_gudang'] . '">' . $d['nama_gudang'] . '</option>';
            }
            echo '</select>';
            echo '</div>';
        endif;
    }
    public function store()
    {
        $post = $this->input->post(null, TRUE);
        $this->form_validation->set_rules('nama', 'Nama lengkap', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_username_check_blank');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('role', 'Hak akses', 'required');
        $row = $this->Mroles->show($post['role']);
        if ($row['jenis_role'] == 2) :
            $this->form_validation->set_rules('gudang', 'Gudang', 'required');
        endif;
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post(null, TRUE);
            $this->Mpengguna->store($post);
            $json = array(
                'status' => '0100',
                'token' => $this->security->get_csrf_hash(),
                'pesan' => 'Data pengguna telah disimpan'
            );
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
            'name' => 'Edit Pengguna',
            'post' => 'pengguna/update',
            'class' => 'form_create',
            'data' => $this->Mpengguna->show($kode)
        ];
        $this->template->modal_form('master/pengguna/edit', $data);
    }
    public function update()
    {
        $this->form_validation->set_rules('nama', 'Nama lengkap', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_username_check_blank');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post(null, TRUE);
            $this->Mpengguna->update($post);
            $json = array(
                'status' => '0100',
                'token' => $this->security->get_csrf_hash(),
                'pesan' => 'Data pengguna telah dirubah'
            );
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
    public function username_check_blank($str)
    {
        $pattren = '/ /';
        $result = preg_match($pattren, $str);
        if ($result) {
            $this->form_validation->set_message('username_check_blank', '%s tidak boleh memiliki spasi.');
            return false;
        } else {
            return true;
        }
    }
    public function destroy()
    {
        $kode = $this->input->get('kode', true);
        $action = $this->Mpengguna->destroy($kode);
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
    public function status_pengguna()
    {
        $kode = $this->input->get('kode', true);
        $query = $this->Mpengguna->show($kode);
        if ($query['status_user'] == 1) :
            $data = array('status_user' => 0);
        else :
            $data = array('status_user' => 1);
        endif;
        $this->db->where('id_user', $kode)->update('users', $data);
        $json = array(
            'status' => '0100'
        );
        echo json_encode($json);
    }
    public function generate_api()
    {
        $kode = $this->input->get('kode', true);
        $check = $this->db->from('user_api')->where('user_api', $kode)->count_all_results();
        if ($check == 0) {
            $data = array(
                'user_api' => $kode,
                'key_api' => implode('-', str_split(substr(strtolower(md5(microtime() . rand(1000, 9999))), 0, 30), 6)),
                'status_api' => 1
            );
            $this->db->insert('user_api', $data);
        }
        $json = array(
            'status' => '0100'
        );
        echo json_encode($json);
    }
}

/* End of file Pengguna.php */
