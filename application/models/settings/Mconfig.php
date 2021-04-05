<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mconfig extends CI_Model
{
    public function nameApp()
    {
        return $this->db->where('nama_seting', 'nameapp')->get('settings')->row();
    }
    public function pathAssets()
    {
        return $this->db->where('nama_seting', 'pathassets')->get('settings')->row();
    }
    public function logoApp()
    {
        return $this->db->where('nama_seting', 'pathlogo')->get('settings')->row();
    }
    public function logoDashboard()
    {
        return $this->db->where('nama_seting', 'pathlogohome')->get('settings')->row();
    }
    public function faviconApp()
    {
        return $this->db->where('nama_seting', 'pathfavicon')->get('settings')->row();
    }
    public function noUserImage()
    {
        return $this->db->where('nama_seting', 'pathnouser')->get('settings')->row();
    }
    public function pathKategori()
    {
        return $this->db->where('nama_seting', 'pathimage')->get('settings')->row();
    }
}

/* End of file Mconfig.php */
