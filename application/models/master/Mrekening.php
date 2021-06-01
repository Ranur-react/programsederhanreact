<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mrekening extends CI_Model
{
    public function fetch_all()
    {
        return $this->db->from('account_bank')->join('bank_code', 'bank_account=id_bank')->get()->result_array();
    }
    public function fetch_bank()
    {
        return $this->db->get('bank_code')->result_array();
    }
    public function kode()
    {
        $query = $this->db
            ->select('id_account', FALSE)
            ->order_by('id_account', 'DESC')
            ->limit(1)
            ->get('account_bank');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->id_account) + 1;
        } else {
            $kode = 1;
        }
        return $kode;
    }
    public function store($post)
    {
        $data = array(
            'id_account' => $this->kode(),
            'bank_account' => $post['code'],
            'kcb_account' => $post['cabang'],
            'norek_account' => $post['norek'],
            'pemilik_account' => $post['holder'],
            'status_account' => $post['status']
        );
        return $this->db->insert('account_bank', $data);
    }
    public function show($kode)
    {
        return $this->db->where('id_account', $kode)->get('account_bank')->row_array();
    }
    public function update($post)
    {
        $data = array(
            'bank_account' => $post['code'],
            'kcb_account' => $post['cabang'],
            'norek_account' => $post['norek'],
            'pemilik_account' => $post['holder'],
            'status_account' => $post['status']
        );
        return $this->db->where('id_account', $post['kode'])->update('account_bank', $data);
    }
    public function destroy($kode)
    {
        return $this->db->simple_query("DELETE FROM account_bank WHERE id_account='$kode'");
    }
}

/* End of file Mrekening.php */
