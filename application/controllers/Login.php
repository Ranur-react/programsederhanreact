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
        if ($this->session->userdata('status_login') == "sessDashboard") {
            redirect('welcome');
        } else {
            if (remember_token() == '0100') :
                redirect('welcome');
            else :
                $data = [
                    'title' => 'Login'
                ];
                $this->template->auth('auth/login', $data);
            endif;
        }
    }
    public function signin()
    {
        $post = $this->input->post(null, TRUE);
        $username = $post['username'];
        $check_user = $this->Mlogin->check_user($username);
        $this->form_validation->set_rules('username', 'Username', 'callback_username_check[' . $check_user->num_rows() . ']');
        $this->form_validation->set_rules('password', 'Password', 'callback_password_check[' . $username . ']');
        if ($this->form_validation->run()) {
            $data = $check_user->row_array();
            $this->session->set_userdata('masuk', TRUE);
            if ($this->session->userdata('masuk') == TRUE) {
                $id_user = encrypt_url(id_user());
                $this->Mlogin->user_online($data['id_user']);
                $this->session->set_userdata('status_login', 'sessDashboard');
                $this->session->set_userdata('kode', $data['id_user']);
                if (!empty($this->input->post("remember"))) {
                    set_cookie("remember_bm_dashboard",  $id_user, 60 * 60 * 24 * 365);
                } else {
                    set_cookie("remember_bm_dashboard", "");
                }
                $json = [
                    'status' => '0100',
                    'token' => $this->security->get_csrf_hash()
                ];
            } else {
                $this->session->sess_destroy();
            }
        } else {
            $json = array(
                'status' => '0101',
                'token' => $this->security->get_csrf_hash(),
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
        if ($password == null) {
            $this->form_validation->set_message('password_check', 'Password tidak boleh kosong');
            return false;
        } else {
            if ($check->num_rows() > 0) {
                $query = $check->row_array();
                $pass  = $query['password'];
                if (password_verify($password, $pass)) {
                    return true;
                } else {
                    $this->form_validation->set_message('password_check', 'Password yang Anda masukkan salah');
                    return FALSE;
                }
            } else {
                $this->form_validation->set_message('password_check', 'Password yang Anda masukkan salah');
                return FALSE;
            }
        }
    }
}

/* End of file Login.php */
