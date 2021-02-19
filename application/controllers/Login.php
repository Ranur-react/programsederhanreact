<?php defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('auth/Mlogin');
    }
    public function index()
    {
        $data = [
            'title' => 'Login'
        ];
        $this->template->auth('auth/login', $data);
    }
    public function signin()
    {
        $post = $this->input->post(null, TRUE);
        $username = $post['username'];
        $check_user = $this->Mlogin->check_user($username);
        $this->form_validation->set_rules('username', 'Username', 'callback_username_check[' . $check_user->num_rows() . ']');
        $this->form_validation->set_rules('password', 'Password', 'callback_password_check[' . $username . ']');
        if ($this->form_validation->run()) {
            $value = $check_user->row_array();
            $this->session->set_userdata('masuk', TRUE);
            if ($this->session->userdata('masuk') == TRUE) {
                $this->session->set_userdata('status_login', 'sessDashboard');
                $this->session->set_userdata('kode', $value['id_user']);
            } else {
                $this->session->sess_destroy();
            }
            $json = ['status' => "0100"];
        } else {
            $json = array(
                'status' => "0101",
                'username_error' => form_error('username'),
                'password_error' => form_error('password')
            );
        }
        echo json_encode($json);
    }
    public function username_check($username, $recordCount)
    {
        if ($username == null) {
            $this->form_validation->set_message('username_check', 'Username tidak boleh kosong');
            return false;
        } else if ($recordCount == 0) {
            $this->form_validation->set_message('username_check', 'Akun Anda tidak ditemukan');
            return FALSE;
        } else {
            return true;
        }
    }
    public function password_check($password, $username)
    {
        $check = $this->Mlogin->check_user($username);
        $query = $check->row_array();
        $pass  = $query['password'];
        if ($password == null) {
            $this->form_validation->set_message('password_check', 'Password tidak boleh kosong');
            return false;
        } else {
            if (password_verify($password, $pass)) {
                return true;
            } else {
                $this->form_validation->set_message('password_check', 'Password yang Anda masukkan salah');
                return FALSE;
            }
        }
    }
}

/* End of file Login.php */
