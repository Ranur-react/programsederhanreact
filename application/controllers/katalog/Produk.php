<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_logged_in();
        $this->load->model('katalog/Mproduk');
        $this->load->model('katalog/Msatuan');
        $this->load->model('master/Mpemasok');
        $this->load->model('katalog/Mharga');
    }
    public function index()
    {
        $data = [
            'title' => 'Produk',
            'links' => '<li class="active">Produk</li>'
        ];
        $this->template->dashboard('katalog/produk/index', $data);
    }
    public function data()
    {
        $results = $this->Mproduk->get_all();
        $data = array();
        $no = $_GET['start'];
        foreach ($results as $result) {
            $kode = $result->id_barang;
            // Menampilkan stok produk dari penerimaan terakhir
            // $stok = $this->Mharga->query_penerimaan($kode, 0, 0, 1);
            // if ($stok != null) {
            //     $terima_akhir = $this->db->where('id_terima', $stok->terima_detail)->get('penerimaan')->row();
            //     $row_stok = $stok != null ? convert_satuan($stok->id_satuan, $stok->stok_detail) . ' ' . $stok->singkatan_satuan : 0;
            //     $row_terima = '<div class="text-muted text-size-small">No: ' . $terima_akhir->nosurat_terima . ' Tgl: ' . format_indo($terima_akhir->tanggal_terima) . '</div>';
            // }
            // Menampilkan data kategori produk
            $data_kategori = $this->Mproduk->show($kode);
            $row_kategori = '';
            foreach ($data_kategori['dataKategori'] as $data_kategori) {
                $row_kategori .= $data_kategori['child'] . '<br>';
            }
            // Menampilkan data pemasok produk
            $data_pemasok = $this->Mproduk->show($kode);
            $row_pemasok = '';
            foreach ($data_pemasok['dataPemasok'] as $data_pemasok) {
                $row_pemasok .= $data_pemasok['pemasok'] . '<br>';
            }
            $edit = '<a href="' . site_url('produk/edit/' . $result->id_barang) . '"><i class="icon-pencil7 text-green" data-toggle="tooltip" data-original-title="Edit"></i></a>';
            $hapus = '<a href="javascript:void(0)" onclick="destroy(\'' . $result->id_barang . '\')"><i class="icon-trash text-red" data-toggle="tooltip" data-original-title="Hapus"></i></a>';
            $no++;
            $rows = array();
            $rows[] = $no . '.';
            $rows[] = $result->nama_barang;
            $rows[] = rtrim($row_kategori, '<br>');
            $rows[] = rtrim($row_pemasok, '<br>');
            $rows[] = '';
            // $rows[] = $stok != null ? $row_stok . '<br>' . $row_terima : 0;
            $rows[] = status_span($result->status_barang, 'aktif');
            $rows[] = $edit . '&nbsp;' . $hapus;
            $data[] = $rows;
        }
        $json = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Mproduk->count_all(),
            "recordsFiltered" => $this->Mproduk->count_filtered(),
            "data" => $data,
        );
        echo json_encode($json);
    }
    public function create()
    {
        $data = [
            'title' => 'Produk',
            'links' => '<li><a href="' . site_url('produk') . '">Produk</a></li><li class="active">Tambah</li>',
            'pemasok' => $this->Mpemasok->getall()
        ];
        $this->template->dashboard('katalog/produk/create', $data);
    }
    public function store()
    {
        $post = $this->input->post(null, TRUE);
        $this->form_validation->set_rules('nama', 'Nama barang', 'trim|required');
        $this->form_validation->set_rules('slug', 'Slug', 'trim|required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $this->Mproduk->store($post);
            $json = array(
                'status' => '0100',
                'token' => $this->security->get_csrf_hash(),
                'msg' => 'Data produk telah disimpan'
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
    public function edit($kode)
    {
        $data = [
            'title' => 'Produk',
            'links' => '<li><a href="' . site_url('produk') . '">Produk</a></li><li class="active">Edit</li>',
            'data' => $this->Mproduk->show($kode),
            'pemasok' => $this->Mpemasok->getall()
        ];
        $this->template->dashboard('katalog/produk/edit', $data);
    }
    public function update()
    {
        $post = $this->input->post(null, TRUE);
        $this->form_validation->set_rules('nama', 'Nama barang', 'trim|required');
        $this->form_validation->set_rules('slug', 'Slug', 'trim|required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $this->Mproduk->update($post);
            $json = array(
                'status' => '0100',
                'token' => $this->security->get_csrf_hash(),
                'msg' => 'Data produk telah dirubah'
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
    public function destroy()
    {
        $kode = $this->input->get('kode', true);
        $action = $this->Mproduk->destroy($kode);
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
    public function get_satuan()
    {
        $barang = $this->input->get('barang');
        $query = $this->Mproduk->get_satuan($barang);
        $data = '<option value="">Pilih</option>';
        foreach ($query as $d) {
            $data .= '<option value="' . $d['id_brg_satuan'] . '">' . $d['nama_satuan'] . '</option>';
        }
        echo $data;
    }
    public function data_gambar()
    {
        $action = $this->input->get('action');
        $urut   = $this->input->get('page_id_array');
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
            $kode = $this->input->get('kode');
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
            'post' => 'produk/store-gambar',
            'class' => 'form_create',
            'multipart' => 1,
            'satuan' => $this->Msatuan->fetch_all(),
            'data' => $data
        ];
        $this->template->modal_form('katalog/produk/create-gambar', $data);
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
                    $date = date('Y-m-d');
                    $image_dir = pathImage() . 'images/produk/' . $date . '/';
                    if (!is_dir($image_dir)) {
                        mkdir($image_dir, 0777, true);
                    }
                    $config['upload_path'] = $image_dir;
                    $config['allowed_types'] = 'jpg|jpeg|png|svg';
                    $config['max_size'] = 819200;
                    $config['encrypt_name'] = TRUE;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('gambar')) {
                        $data['upload_data'] = $this->upload->data('file_name');
                        $link = 'images/produk/' . $date . '/' . $data['upload_data'];
                    }
                    if ($_FILES['gambar']['size'] > 819200) {
                        $json = array(
                            'status' => '0101',
                            'token' => $this->security->get_csrf_hash(),
                            'error' => '<div class="text-red">Ukuran file tidak boleh melebihi 800KB</div>'
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
                            'status' => '0100',
                            'token' => $this->security->get_csrf_hash(),
                            'msg' => 'Data gambar telah disimpan'
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
                $json = array(
                    'status' => '0101',
                    'token' => $this->security->get_csrf_hash(),
                    'error' => '<div class="text-red">Harap unggah file yang hanya berekstensi .jpeg / .jpg / .png.</div>'
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
    public function destroy_gambar()
    {
        $kode = $this->input->get('kode');
        $action = $this->input->get('action');
        if ($action == 'create') {
            $data = $this->db->where('id', $kode)->get('tmp_gambar')->row_array();
            unlink(pathImage() . $data['gambar']);
            RemoveEmptyFolders(pathImage() . $data['gambar']);
            return $this->db->where('id', $kode)->delete('tmp_gambar');
        } else {
            $data = $this->db->where('id_brg_gambar', $kode)->get('barang_gambar')->row_array();
            unlink(pathImage() . $data['url_brg_gambar']);
            RemoveEmptyFolders(pathImage() . $data['url_brg_gambar']);
            return $this->db->where('id_brg_gambar', $kode)->delete('barang_gambar');
        }
    }
}

/* End of file Produk.php */
