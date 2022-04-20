<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Harga extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_logged_in();
        $this->load->model('katalog/Mharga');
        $this->load->model('katalog/Mstok');
    }
    public function index()
    {
        $data = [
            'title' => 'Harga Jual',
            'links' => '<li class="active">Harga Jual</li>'
        ];
        $this->template->dashboard('katalog/harga/index', $data);
    }
    public function data()
    {
        $results = $this->Mharga->fetch_all();
        $data = array();
        $no = $_GET['start'];
        foreach ($results as $result) {
            // $row = $this->Mharga->query_penerimaan($result->id_barang, 1, 0, 1);
            // if ($row != null) {
            // $terima = $this->db->where('id_terima', $row->terima_detail)->get('penerimaan')->row();
            // Menampilkan stok barang dari penerimaan terakhir dengan status default aktif
            // $row_stok = $row != null ? convert_satuan($row->id_satuan, $row->stok_detail) . ' ' . $row->singkatan_satuan : 0;
            // Menampilkan harga jual dari penerimaan terakhir dengan status default aktif
            $harga_terakhir = $this->Mharga->get_harga_terakhir($result->id_barang);
            if ($harga_terakhir['status'] == true) :
                $harga_produk = '';
                $harga_produk .= $harga_terakhir['data']['hargaText'] . '&nbsp;/&nbsp;' . $harga_terakhir['data']['jumlahProduk'] . ' ' . $harga_terakhir['data']['satuan'] . '<br>';
                $harga_produk .= '<div class="text-muted text-size-small">No: ' . $harga_terakhir['data']['nomor'] . ' Tgl: ' . $harga_terakhir['data']['tanggal'] . '</div>';
            else :
                $harga_produk = COUNT_EMPTY;
            endif;
            // Button detail dan rekap
            $detail = '<a href="javascript:void(0)" class="detail" id="' . $result->id_barang . '" title="Detail"><i class="icon-eye8 text-black"></i></a>';
            $rekap = '<a href="' . site_url('harga/rekap/' . $result->id_barang) . '" title="Rekap Harga Jual"><i class="icon-clipboard6 text-purple"></i></a>';
            $no++;
            $rows = array();
            $rows[] = $no . '.';
            $rows[] = $result->nama_barang;
            $rows[] = $harga_produk;
            $rows[] = $detail . '&nbsp;' . $rekap;
            $data[] = $rows;
        }
        $json = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Mharga->count_all(),
            "recordsFiltered" => $this->Mharga->count_filtered(),
            "data" => $data,
        );
        echo json_encode($json);
    }
    public function detail()
    {
        $id = $this->input->get('id');
        $data = [
            'name' => 'Harga Jual Produk',
            'modallg' => 1,
            'data' => $this->Mharga->get_harga_terakhir($id)
        ];
        $this->template->modal_info('katalog/harga/detail', $data);
    }
    public function rekap($id = null)
    {
        $data = [
            'title' => 'Rekap Harga Jual',
            'small' => 'Rekap harga jual produk',
            'links' => '<li><a href="' . site_url('harga') . '">Harga Jual</a></li><li class="active">Rekap</li>',
            'sidebar' => 'collapse',
            'data' => $this->Mstok->getStokterima($id)
        ];
        $this->template->dashboard('katalog/harga/rekap', $data);
    }
    public function data_harga()
    {
        $iddetail_terima = $this->input->get('iddetail_terima');
        $data = $this->Mharga->data_harga($iddetail_terima);
        echo json_encode($data);
    }
    public function edit()
    {
        $idharga = $this->input->get('idharga');
        $num = $this->input->get('num');
        $data = [
            'name' => 'Edit Harga Jual',
            'post' => 'harga/update',
            'class' => 'form_create',
            'nourut' => $num,
            'data' => $this->Mharga->get_harga($idharga)
        ];
        $this->template->modal_form('katalog/harga/edit', $data);
    }
    public function update()
    {
        $this->form_validation->set_rules('jumlah', 'Jumlah produk', 'required');
        $this->form_validation->set_rules('harga', 'Harga jual', 'required');
        $this->form_validation->set_message('required', errorRequired());
        $this->form_validation->set_error_delimiters(errorDelimiter(), errorDelimiter_close());
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post(null, TRUE);
            $this->Mharga->update($post);
            $json = array(
                'status' => '0100',
                'token' => $this->security->get_csrf_hash(),
                'pesan' => 'Harga jual persatuan berhasil dirubah',
                'iddetail_terima' => $post['iddetail_terima'],
                'nourut' => $post['nourut']
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





    // Function tidak digunakan
    // public function data()
    // {
    //     $results = $this->Mharga->fetch_all();
    //     $data = array();
    //     $no = $_GET['start'];
    //     foreach ($results as $result) {
    //         $row = $this->Mharga->query_penerimaan($result->id_barang, 1, 0, 1);
    //         if ($row != null) {
    //             $terima = $this->db->where('id_terima', $row->terima_detail)->get('penerimaan')->row();
    //             // Menampilkan stok barang dari penerimaan terakhir dengan status default aktif
    //             $row_stok = $row != null ? convert_satuan($row->id_satuan, $row->stok_detail) . ' ' . $row->singkatan_satuan : 0;
    //             // Menampilkan harga jual dari penerimaan terakhir dengan status default aktif
    //             $harga_terakhir = $this->Mharga->query_harga_satuan($row->id_hrg_barang, 1);
    //             $data_harga = '';
    //             foreach ($harga_terakhir as $value) {
    //                 $data_harga .= 'Rp ' . rupiah($value->jual_hrg_detail) . '&nbsp;/' . $value->berat_hrg_detail . ' ' . $value->singkatan_satuan . '<br>';
    //             }
    //             $data_harga .= '<div class="text-muted text-size-small">No: ' . $terima->nosurat_terima . ' Tgl: ' . format_indo($row->tanggal_hrg_barang) . '</div>';
    //         }

    //         $detail = '<a href="javascript:void(0)" onclick="detail(\'' . $result->id_barang . '\')"><i class="icon-eye8 text-black" title="Detail"></i></a>';
    //         $histori = '<a href="' . site_url('harga/histori/' . $result->id_barang) . '"><i class="icon-history text-green" title="Histori Harga"></i></a>';

    //         $no++;
    //         $rows = array();
    //         $rows[] = $no . '.';
    //         $rows[] = $result->nama_barang;
    //         $rows[] = $row != null ? $row_stok : 0;
    //         $rows[] = $row != null ? rtrim($data_harga, '') : '<div class="text-muted text-size-small">Harga belum diaktifkan</div>';
    //         $rows[] = status_span($result->status_barang, 'aktif');
    //         $rows[] = $detail . '&nbsp;' . $histori;
    //         $data[] = $rows;
    //     }
    //     $json = array(
    //         "draw" => $_GET['draw'],
    //         "recordsTotal" => $this->Mharga->count_all(),
    //         "recordsFiltered" => $this->Mharga->count_filtered(),
    //         "data" => $data,
    //     );
    //     echo json_encode($json);
    // }    
    public function data_terima()
    {
        $kode = $this->input->get('kode');
        $d['data'] = $this->Mharga->array_penerimaan($kode, 0, 0, 0);
        $this->load->view('katalog/harga/data', $d);
    }
    public function add_satuan()
    {
        $id_satuan = $this->input->get('id_satuan');
        $id_harga = $this->input->get('id_harga');
        $this->Mharga->add_satuan($id_satuan, $id_harga);
        $json = array(
            'message' => 'Satuan telah ditambahkan'
        );
        echo json_encode($json);
    }
}

/* End of file Harga.php */
