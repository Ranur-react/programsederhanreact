<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpelanggan extends CI_Model
{
    var $tabel = 'customer';
    var $id = 'id_supplier';
    var $column_order = array(null, 'nama_customer', 'email_customer', 'phone_customer', 'created_at');
    var $column_search = array('nama_customer', 'email_customer', 'phone_customer');
    var $order = array('created_at' => 'DESC');

    private function _get_data_query()
    {
        $this->db->from($this->tabel);
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_GET['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_GET['search']['value']);
                } else {
                    $this->db->or_like($item, $_GET['search']['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_GET['order'])) {
            $this->db->order_by($this->column_order[$_GET['order']['0']['column']], $_GET['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function fetch_all()
    {
        $this->_get_data_query();
        if ($_GET['length'] != -1)
            $this->db->limit($_GET['length'], $_GET['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtered()
    {
        $this->_get_data_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_all()
    {
        $this->db->from($this->tabel);
        return $this->db->count_all_results();
    }
    public function get_all()
    {
        $query = $this->db->get('customer')->result();
        foreach ($query as $value) {
            $data[] = [
                'id' => $value->id_customer,
                'nama' => $value->nama_customer
            ];
        }
        return $data;
    }
    public function show($id)
    {
        $query = $this->db->where('id_customer', $id)->get('customer')->row();
        $data = [
            'id' => (int)$query->id_customer,
            'nama' => $query->nama_customer,
            'email' => $query->email_customer,
            'phone' => $query->phone_customer,
            'birth' => $query->birth_customer != null ? $query->birth_customer : null,
            'jenkel' => (int)$query->gender_customer,
            'photo' => $query->photo_customer,
            'status' => (int)$query->active_customer
        ];
        $queryAlamat = $this->db->where('customer_alamat', $query->id_customer)
            ->order_by('utama_alamat', 'desc')
            ->get('customer_alamat')->result();
        $result_alamat = array();
        $dataAlamat = array();
        foreach ($queryAlamat as $qa) {
            $result_alamat['id_alamat'] = (int)$qa->id_alamat;
            $result_alamat['label'] = $qa->label_alamat;
            $result_alamat['penerima'] = $qa->penerima_alamat;
            $result_alamat['telp'] = $qa->phone_alamat;
            $result_alamat['jalan'] = $qa->jalan_alamat;
            $result_alamat['detail'] = $qa->detail_alamat;
            $result_alamat['kota'] = $qa->kota_alamat;
            $result_alamat['kodepos'] = $qa->kodepos_alamat;
            $result_alamat['utama'] = (int)$qa->utama_alamat;
            $dataAlamat[] = $result_alamat;
        }
        $data['dataAlamat'] = $dataAlamat;
        $queryBank = $this->db->from('customer_bank')
            ->join('bank_code', 'bank_cs_bank=id_bank')
            ->where('customer_cs_bank', $query->id_customer)
            ->order_by('utama_cs_bank', 'desc')
            ->get()->result();
        $result_bank = array();
        $dataBank = array();
        foreach ($queryBank as $qb) {
            $result_bank['id_bank'] = (int)$qb->id_cs_bank;
            $result_bank['bank'] = $qb->nama_bank;
            $result_bank['pemilik'] = $qb->pemilik_cs_bank;
            $result_bank['norek'] = $qb->norek_cs_bank;
            $result_bank['utama'] = (int)$qb->utama_cs_bank;
            $dataBank[] = $result_bank;
        }
        $data['dataBank'] = $dataBank;
        return $data;
    }
}

/* End of file Mpelanggan.php */
