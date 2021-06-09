<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mcustomer extends CI_Model
{
    public function jumlah_data()
    {
        return $this->db->count_all_results('customer');
    }
    public function tampil_data($start, $length)
    {
        $query = $this->db->query("SELECT * FROM customer ORDER BY created_at DESC LIMIT $start,$length");
        return $query;
    }
    public function cari_data($search)
    {
        $query = $this->db->query("SELECT * FROM customer WHERE nama_customer LIKE '%$search%' ESCAPE '!' OR email_customer LIKE '%$search%' ESCAPE '!' OR phone_customer LIKE '%$search%' ESCAPE '!' ORDER BY created_at DESC");
        return $query;
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

/* End of file Mcustomer.php */
