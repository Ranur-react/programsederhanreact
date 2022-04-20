<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Common
{
    protected $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
    }
    public function global_set($key)
    {
        if ($key != 'semua') {
            $this->ci->db->where('nama_seting', $key);
        }
        $query = $this->ci->db->get('settings');
        $result = null;
        if ($key == 'semua') {
            $result = array(null);
            foreach ($query->result() as $row) {
                $result[$row->nama_seting] = $row->value_seting;
            }
            $result = (object)$result;
        } else {
            $result = '';
            foreach ($query->result() as $row) {
                $result = $row->value_seting;
            }
        }
        return $result;
    }
}

/* End of file Common.php */
