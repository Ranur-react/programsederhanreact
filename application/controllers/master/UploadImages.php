<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UploadImages extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') == "sessDashboard")
            cek_user();
        else
            redirect('logout');
        $this->load->model('master/Msatuan');
    }
    public function index()
    {
       $kode = $this->input->post('kode');
       $data = [
            'name' => 'Galeri Gambar',
            'class' => 'form_create',
            'submitLabel' => 'Pilih',
            'submitIcon' =>'fa fa-check-square-o',
            'modallg'=>0,
            'key'=>$kode,
        ];
        $this->template->modal_images_form('master/Images/History', $data);
    }
    public function choseImages()
    {
        $data = [
            'name' => 'Upload ke Galery',
        ];
        $this->load->view('master/Images/ChoseFiles', $data);
    }
    public function delteImages()
    {
       $file = $this->input->post('filedes');
       $filepath=assets().'images/Galery/'.$file;
       $json=[];
            $json['path']=$filepath;
            unlink($filepath);
        // if (unlink($filepath)))
        //   {
            
        //     $json['status']=true;
        //   }
        //   else{
        //     $json['status']=false;

        //   }
         echo json_encode($json);
    }
    public function insertImages()
    {
            // $target_dir=assets().'images/ImagesGalery/';
            // if (!file_exists($target_dir)) {
            //     mkdir($target_dir,777,true);
            // }
            //     if(move_uploaded_file($_FILES['files']['name'],$target_dir)){
            //         echo "Tersmpan";
            //     }else{
            //         echo "Gagal";
            //     }
        foreach ($_FILES as $key => $value) {
            echo $key;
        }


        
    }
}
