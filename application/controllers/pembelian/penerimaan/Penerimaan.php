<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penerimaan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_logged_in();
        $this->load->model('master/Mpemasok');
        $this->load->model('master/Mgudang');
        $this->load->model('pembelian/penerimaan/Mpenerimaan');
        $this->load->model('pembelian/penerimaan/Mtmp_create');
    }
    public function index()
    {
        $data = [
            'title' => 'Penerimaan',
            'small' => 'Menampilkan dan mengelola data penerimaan barang',
            'links' => '<li class="active">Penerimaan</li>'
        ];
        $this->template->dashboard('pembelian/penerimaan/index', $data);
    }
    public function data()
    {
        $query = $this->Mpenerimaan->fetch_all();
        $data = array();
        $no = $_GET['start'];
        foreach ($query as $value) {
            $no++;
            $bayar = '<a href="' . site_url('penerimaan/pelunasan/' . $value->id_terima) . '"><i class="icon-coin-dollar text-purple" title="Bayar"></i></a>';
            $detail = '<a href="javascript:void(0)" class="detail" id="' . $value->id_terima . '"><i class="icon-eye8 text-black" title="Detail"></i></a>';
            $edit = '<a href="' . site_url('penerimaan/edit/' . $value->id_terima) . '"><i class="icon-pencil7 text-green" title="Edit"></i></a>';
            $destroy = '<a href="javascript:void(0)" class="destroy" id="' . $value->id_terima . '"><i class="icon-trash text-red" title="Hapus"></i></a>';
            $row = array();
            $row[] = $no . '.';
            $row[] = $value->nosurat_terima;
            $row[] = $value->nama_supplier;
            $row[] = $value->nama_gudang;
            $row[] = format_biasa($value->tanggal_terima);
            $row[] = akuntansi($value->total_terima);
            $row[] = $value->nama_user;
            $row[] = status_span($value->status_terima, 'penerimaan');
            $row[] = $bayar . '&nbsp;' . $detail . '&nbsp;' . $edit . '&nbsp;' . $destroy;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Mpenerimaan->count_all(),
            "recordsFiltered" => $this->Mpenerimaan->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function create()
    {
        $data = [
            'title' => 'Penerimaan',
            'small' => 'Tambah Penerimaan Produk',
            'links' => '<li><a href="' . site_url('penerimaan') . '">Penerimaan</a></li><li class="active">Tambah</li>',
            'sidebar' => 'collapse',
            'supplier' => $this->Mpemasok->getall(),
            'gudang' => $this->Mgudang->fetch_all(),
            'nomor' => $this->Mpenerimaan->nosurat()
        ];
        $this->template->dashboard('pembelian/penerimaan/create', $data);
    }
    public function store()
    {
        $post = $this->input->post(null, TRUE);
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('pemasok', 'Pemasok', 'required');
        $this->form_validation->set_rules('gudang', 'Gudang', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $tmp_data = $this->Mtmp_create->fetch_all();
            if (count($tmp_data) > 0) :
                $kode = $this->Mpenerimaan->kode();
                $this->Mpenerimaan->store($kode, $post);
                $json = array(
                    'status' => '0100',
                    'token' => $this->security->get_csrf_hash(),
                    'kode' => $kode,
                    'msg' => 'Form penerimaan produk berhasil dibuat.'
                );
            else :
                $json = array(
                    'status' => '0100',
                    'token' => $this->security->get_csrf_hash(),
                    'count' => count($tmp_data),
                    'msg' => 'Anda belum melengkapi isian form penerimaan produk.'
                );
            endif;
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
            'title' => 'Penerimaan',
            'small' => 'Edit Data Penerimaan Barang',
            'links' => '<li><a href="' . site_url('penerimaan') . '">Penerimaan</a></li><li class="active">Edit</li>',
            'sidebar' => 'collapse',
            'supplier' => $this->Mpemasok->getall(),
            'gudang' => $this->Mgudang->fetch_all(),
            'data' => $this->Mpenerimaan->show($kode)
        ];
        $this->template->dashboard('pembelian/penerimaan/edit', $data);
    }
    public function update()
    {
        $post = $this->input->post(null, TRUE);
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('gudang', 'Gudang', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $idterima = $post['idterima'];
            $tmp_data = $this->db->from('terima_detail')->where('terima_detail', $idterima)->count_all_results();
            if ($tmp_data > 0) :
                $this->Mpenerimaan->update($idterima, $post);
                $json = array(
                    'status' => '0100',
                    'token' => $this->security->get_csrf_hash(),
                    'kode' => $idterima,
                    'msg' => 'Form edit penerimaan produk berhasil dirubah.'
                );
            else :
                $json = array(
                    'status' => '0100',
                    'token' => $this->security->get_csrf_hash(),
                    'count' => $tmp_data,
                    'msg' => 'Anda belum melengkapi isian form edit penerimaan produk.'
                );
            endif;
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
    public function detail($kode)
    {
        $data = [
            'title' => 'Penerimaan',
            'small' => 'Detail Penerimaan Produk',
            'links' => '<li><a href="' . site_url('penerimaan') . '">Penerimaan</a></li><li class="active">Detail</li>',
            'data' => $this->Mpenerimaan->show($kode)
        ];
        $this->template->dashboard('pembelian/penerimaan/detail', $data);
    }
    public function view()
    {
        $id = $this->input->get('id');
        $data = [
            'name' => 'Detail Penerimaan Produk',
            'modallg' => 1,
            'data' => $this->Mpenerimaan->show($id)
        ];
        $this->template->modal_info('pembelian/penerimaan/view', $data);
    }
    public function destroy()
    {
        $id = $this->input->get('id', true);
        $proses = $this->Mpenerimaan->destroy($id);
        if ($proses['status'] == '0100') {
            $json = array(
                'status' => '0100',
                'msg' => $proses['msg']
            );
        } else {
            $json = array(
                'status' => '0101',
                'msg' => $proses['msg']
            );
        }
        echo json_encode($json);
    }
}

/* End of file Penerimaan.php */
