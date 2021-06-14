<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') == "sessDashboard")
            cek_user();
        else
            redirect('logout');
        $this->load->model('master/Mbarang');
        $this->load->model('master/Msatuan');
    }
    public function index()
    {
        $data = [
            'title' => 'Barang',
            'small' => 'Menampilkan dan mengelola data barang',
            'links' => '<li class="active">Barang</li>',
            'data' => $this->Mbarang->fetch_all()
        ];
        $this->template->dashboard('master/barang/data', $data);
    }
    public function data()
    {
        $draw   = $_REQUEST['draw'];
        $length = $_REQUEST['length'];
        $start  = $_REQUEST['start'];
        $search = $_REQUEST['search']["value"];
        $status = '';
        $total  = $this->Mbarang->jumlah_data();
        $output = array();
        $output['draw'] = $draw;
        $output['recordsTotal'] = $output['recordsFiltered'] = $total;
        $output['data'] = array();
        if ($search != "") {
            $query = $this->Mbarang->cari_data($search, $status);
        } else {
            $query = $this->Mbarang->tampil_data($start, $length, $status);
        }
        if ($search != "") {
            $count = $this->Mbarang->cari_data($search, $status);
            $output['recordsTotal'] = $output['recordsFiltered'] = $count->num_rows();
        }
        $no = 1;
        foreach ($query->result_array() as $d) {
            $kode = $d['id_barang'];
            $data_kategori = $this->Mbarang->barang_kategori($kode);
            $result = '';
            foreach ($data_kategori as $data_kategori) {
                $result .= $data_kategori['nama_kategori'] . '<br>';
            }
            $edit = '<a href="' . site_url('barang/edit/' . $d['id_barang']) . '"><i class="icon-pencil7 text-green" data-toggle="tooltip" data-original-title="Edit"></i></a>';
            $hapus = '<a href="javascript:void(0)" onclick="hapus(\'' . $d['id_barang'] . '\')"><i class="icon-trash text-red" data-toggle="tooltip" data-original-title="Hapus"></i></a>';
            $output['data'][] = array(
                $no . '.',
                $d['nama_barang'],
                '',
                '',
                rtrim($result, ''),
                status_span($d['status_barang'], 'aktif'),
                $edit . '&nbsp;' . $hapus
            );
            $no++;
        }
        echo json_encode($output);
    }
    public function create()
    {
        $data = [
            'title' => 'Barang',
            'small' => 'Tambah data barang',
            'links' => '<li><a href="' . site_url('barang') . '">Barang</a></li><li class="active">Tambah</li>'
        ];
        $this->template->dashboard('master/barang/create', $data);
    }
    public function store()
    {
        $post = $this->input->post(null, TRUE);
        $this->form_validation->set_rules('nama', 'Nama barang', 'trim|required');
        $this->form_validation->set_rules('slug', 'Slug', 'trim|required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $this->Mbarang->store($post);
            $json = array(
                'status' => "0100",
                'pesan' => "Data barang telah disimpan"
            );
        } else {
            $json['status'] = "0111";
            foreach ($_POST as $key => $value) {
                $json['pesan'][$key] = form_error($key);
            }
        }
        echo json_encode($json);
    }
    public function edit($kode)
    {
        $data = [
            'title' => 'Barang',
            'small' => 'Mengubah data barang',
            'links' => '<li><a href="' . site_url('barang') . '">Barang</a></li><li class="active">Edit</li>',
            'data' => $this->Mbarang->show($kode),
            'barang_desc' => $this->Mbarang->barang_desc($kode),
            'barang_kategori' => $this->Mbarang->barang_kategori($kode),
            'barang_satuan' => $this->Mbarang->barang_satuan($kode)
        ];
        $this->template->dashboard('master/barang/edit', $data);
    }
    public function update()
    {
        $post = $this->input->post(null, TRUE);
        $this->form_validation->set_rules('nama', 'Nama barang', 'trim|required');
        $this->form_validation->set_rules('slug', 'Slug', 'trim|required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $this->Mbarang->update($post);
            $json = array(
                'status' => "0100",
                'pesan' => "Data barang telah dirubah"
            );
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
        $action = $this->Mbarang->destroy($kode);
        if ($action) {
            $json = array(
                'status' => "0100",
                "message" => successDestroy()
            );
        } else {
            $json = array(
                'status' => "0101",
                "message" => errorDestroy()
            );
        }
        echo json_encode($json);
    }
    public function get_satuan()
    {
        $barang = $this->input->get('barang');
        $query = $this->Mbarang->get_satuan($barang);
        $data = '<option value="">Pilih</option>';
        foreach ($query as $d) {
            $data .= '<option value="' . $d['id_brg_satuan'] . '">' . $d['nama_satuan'] . '</option>';
        }
        echo $data;
    }
    public function load_gambar()
    {
        $action = $this->input->post('action');
        $urut   = $this->input->post('page_id_array');
        if ($action == 'create') {
            $query = $this->db->from('tmp_gambar')
                ->join('satuan', 'idsatuan=id_satuan')
                ->where('user', id_user())
                ->order_by('nourut', 'asc')
                ->get()->result_array();
            if ($query == null) {
                $data = [(int)0];
            } else {
                foreach ($query as $row) {
                    $data[] = [
                        'id' => $row['id'],
                        'satuan' => $row['nama_satuan'],
                        'gambar' => assets() . $row['gambar'],
                        'nourut' => $row['nourut']
                    ];
                }
            }
            echo json_encode($data);
        }
        if ($action == 'nocreate') {
            for ($count = 0; $count < count($urut); $count++) {
                $this->db->set('nourut', ($count + 1));
                $this->db->where('id', $urut[$count]);
                $this->db->update('tmp_gambar');
            }
        }
        if ($action == 'update') {
            $kode = $this->input->post('kode');
            $query = $this->db->from('barang_gambar')
                ->join('satuan', 'satuan_brg_gambar=id_satuan')
                ->where('barang_brg_gambar', $kode)
                ->order_by('sort_order', 'asc')
                ->get()->result_array();
            if ($query == null) {
                $data = [(int)0];
            } else {
                foreach ($query as $row) {
                    $data[] = [
                        'id' => $row['id_brg_gambar'],
                        'satuan' => $row['nama_satuan'],
                        'gambar' => assets() . $row['url_brg_gambar'],
                        'nourut' => $row['sort_order']
                    ];
                }
            }
            echo json_encode($data);
        }
        if ($action == 'noupdate') {
            for ($count = 0; $count < count($urut); $count++) {
                $this->db->set('sort_order', ($count + 1));
                $this->db->where('id_brg_gambar', $urut[$count]);
                $this->db->update('barang_gambar');
            }
        }
    }
    public function create_gambar()
    {
        $action = $this->input->get('action');
        $kode = $this->input->get('kode');
        if ($action == 'create') {
            $data = ['action' => 'create', 'kode' => 0];
        } else {
            $data = ['action' => 'update', 'kode' => $kode];
        }
        $data = [
            'name' => 'Upload Gambar',
            'post' => 'barang/store-gambar',
            'class' => 'form_create',
            'multipart' => 1,
            'satuan' => $this->Msatuan->getall(),
            'data' => $data
        ];
        $this->template->modal_form('master/barang/create-gambar', $data);
    }
    public function store_gambar()
    {
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post(null, TRUE);
            $types = array('image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png', 'image/svg+xml');
            $mime = get_mime_by_extension($_FILES['gambar']['name']);
            if (isset($_FILES['gambar']['name']) && $_FILES['gambar']['name'] != "") {
                if (in_array($mime, $types)) {
                    $config['upload_path'] = pathImage() . 'images/produk';
                    $config['allowed_types'] = 'jpg|jpeg|png|svg';
                    $config['max_size'] = 819200;
                    $config['encrypt_name'] = TRUE;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('gambar')) {
                        $data['upload_data'] = $this->upload->data('file_name');
                        $link = 'images/produk/' . $data['upload_data'];
                    }
                    if ($_FILES['gambar']['size'] > 819200) {
                        $json = array(
                            "status" => "0101",
                            "error" => "<div class='text-red'>Ukuran file tidak boleh melebihi 800KB</div>"
                        );
                    } else {
                        if ($post['action'] == 'create') {
                            $count = $this->db->from('tmp_gambar')->where('user', id_user())->order_by('nourut', 'DESC')->limit(1)->get()->row_array();
                            $nomor = $count['nourut'] + 1;
                            $data = array(
                                'idsatuan' => $post['satuan'],
                                'gambar' => $link,
                                'nourut' => $nomor,
                                'user' => id_user()
                            );
                            $this->db->insert('tmp_gambar', $data);
                        } else if ($post['action'] == 'update') {
                            $count = $this->db->from('barang_gambar')->where('barang_brg_gambar', $post['kode'])->order_by('sort_order', 'DESC')->limit(1)->get()->row_array();
                            $nomor = $count['sort_order'] + 1;
                            $data = array(
                                'barang_brg_gambar' => $post['kode'],
                                'satuan_brg_gambar' => $post['satuan'],
                                'url_brg_gambar' => $link,
                                'sort_order' => $nomor
                            );
                            $this->db->insert('barang_gambar', $data);
                        }
                        $json = array(
                            'status' => "0100",
                            'pesan' => "Data gambar telah disimpan"
                        );
                    }
                } else {
                    $json = array(
                        "status" => "0101",
                        "error" => "<div class='text-red'>Harap unggah file yang hanya berekstensi .jpeg / .jpg / .png.</div>"
                    );
                }
            } else {
                $json = array(
                    "status" => "0101",
                    "error" => "<div class='text-red'>Harap unggah file yang hanya berekstensi .jpeg / .jpg / .png.</div>"
                );
            }
        } else {
            $json['status'] = "0101";
            foreach ($_POST as $key => $value) {
                $json['pesan'][$key] = form_error($key);
            }
        }
        echo json_encode($json);
    }
    public function destroy_gambar()
    {
        $kode = $this->input->get('kode');
        $action = $this->input->get('action');
        if ($action == 'create') {
            $data = $this->db->where('id', $kode)->get('tmp_gambar')->row_array();
            unlink(pathImage() . $data['gambar']);
            return $this->db->where('id', $kode)->delete('tmp_gambar');
        } else {
            $data = $this->db->where('id_brg_gambar', $kode)->get('barang_gambar')->row_array();
            unlink(pathImage() . $data['url_brg_gambar']);
            return $this->db->where('id_brg_gambar', $kode)->delete('barang_gambar');
        }
    }
}

/* End of file Barang.php */
