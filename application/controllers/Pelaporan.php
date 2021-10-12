<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class pelaporan extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Pelaporan';

        $this->load->model('model_pelaporan');
        $this->load->model('model_users');
	}

    /* 
    * It only redirects to the manage product page
    */

    public function index()
    {
        if(!in_array('viewpelaporan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->render_template('pelaporan/index', $this->data);  
    }


    public function create()
    {
         if(!in_array('createpelaporan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        
    
        $id_user = $this->session->userdata['id'];
        $div = $this->session->userdata['divisi'];
        $store = $this->session->userdata['store'];
        $store_id = $this->session->userdata['store_id'];

        if ($this->form_validation->run() == TRUE) {
            // true case

            $data = array(
                'user_id' => $id_user,
                'store' => $store,
                'store_id' => $store_id,
                'nama' => $this->input->post('nama'),
                'ket' => $this->input->post('ket'),
                'tgl_input' => $this->input->post('tgl_input'),
                'divisi' => $div,
            );


            $create = $this->model_pelaporan->create($data);
            if($create == true) {
                $this->session->set_flashdata('success', 'Pelaporan Ditambahkan');
                redirect('pelaporan/create', 'refresh');
            }
            else {
                $this->session->set_flashdata('Eror', 'Terjadi Kesalahan Penambahan!!');
                redirect('pelaporan/create', 'refresh');
            }
        }
        else {
            // false case       

            $this->render_template('pelaporan/create', $this->data);
        }   
    }



//Tampilkan data di create pelaporan
        public function fetchpelaporan()
    {
        $result = array('data' => array());
        $div = $this->session->userdata['divisi'];
        if($div == 0){$data = $this->model_pelaporan->getpelaporanseluruh();}else{
        if($div == 11){
        $store_id = $this->session->userdata['store_id'];
        $data = $this->model_pelaporan->getpelaporanstore($store_id);
        }else{
        $store_id = $this->session->userdata['store_id'];
        $data = $this->model_pelaporan->getpelaporandiv($store_id, $div);
        }}

        

        foreach ($data as $key => $value) {

        if($value['divisi'] == 1){$divisi = 'Bar & Kasir';}elseif($value['divisi'] == 2){$divisi = 'Waiter';}elseif($value['divisi'] == 3){$divisi = 'Kitchen';}else{$divisi = '-';};
        
           
       
            $result['data'][$key] = array(
                $value['tgl_input'],
                $value['store'],
                $divisi,
                $value['nama'],
                $value['ket'],


            );
        } // /foreach

        echo json_encode($result);
    }   




//tampilkan data di manage
        public function fetchpelaporanData()
    {
        $result = array('data' => array());
        $id_user = $this->session->userdata['id'];
        $store_id = $this->session->userdata['store_id'];


        $div = $this->session->userdata['divisi'];
        if($div == 0){$data = $this->model_pelaporan->getpelaporanseluruh();}else{
        if($div == 11){
        $store_id = $this->session->userdata['store_id'];
        $data = $this->model_pelaporan->getpelaporanstore($store_id);
        }else{
        $store_id = $this->session->userdata['store_id'];
        $data = $this->model_pelaporan->getpelaporandiv($store_id, $div);
        }}

        foreach ($data as $key => $value) {


        if($value['divisi'] == 1){$divisi = 'Bar & Kasir';}elseif($value['divisi'] == 2){$divisi = 'Waiter';}elseif($value['divisi'] == 3){$divisi = 'Kitchen';}else{$divisi = '-';};

            $buttons = '';
            if(in_array('updatepelaporan', $this->permission)) {
                $buttons .= '<a href="'.base_url('pelaporan/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
            }

            if(in_array('deletepelaporan', $this->permission)) { 
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
            }
            $status=$value['status'];
           if ($status == 0){
               $sts= '<span class="label label-warning">Proses</span>';
           }elseif ($status == 1) {
               $sts= '<span class="label label-danger">Ditolak</span>';
           }elseif ($status == 2) {
               $sts= '<span class="label label-success">Diterima</span>';
           }
       
            $result['data'][$key] = array(
                $value['tgl_input'],
                $value['store'],
                $divisi,
                $value['nama'],
                $value['ket'],
                $sts,
                $buttons,


            );
        } // /foreach

        echo json_encode($result);
    }   




    public function remove()
    {
        if(!in_array('deletepelaporan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
        $pelaporan_id = $this->input->post('pelaporan_id');

        $response = array();
        if($pelaporan_id) {
            $delete = $this->model_pelaporan->remove($pelaporan_id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Berhasil Terhapus"; 
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Kesalahan dalam database saat menghapus informasi produk";
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refersh kembali!!";
        }

        echo json_encode($response);
    }




 /*
    Update
    */
    public function update($pelaporan_id)
    {      
        if(!in_array('updatepelaporan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        if(!$pelaporan_id) {
            redirect('dashboard', 'refresh');
        }


        $this->form_validation->set_rules('status', 'Status', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            // true case
            $data = array(
                'status' => $this->input->post('status'),
            );

            $update = $this->model_pelaporan->update($data, $pelaporan_id);
            if($update == true) {
                $this->session->set_flashdata('Berhasil', 'Produk Diupdate');
                redirect('pelaporan/', 'refresh');
            }
            else {
                $this->session->set_flashdata('Eror', 'Terjadi Kesalahan Update!!');
                redirect('pelaporan/update/'.$ivn_id, 'refresh');
            }
        }
        else {
               
            $pelaporan_data = $this->model_pelaporan->getpelaporanid($pelaporan_id);
            $this->data['pelaporan_data'] = $pelaporan_data;
            $this->render_template('pelaporan/edit', $this->data); 
        }   
    }


    public function laporanpelaporan()
    {
        if(!in_array('viewpelaporan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
        $id_user = $this->session->userdata['id'];
        $outlet= $this->model_users->getUserData($id_user);
        $this->data['store']=$outlet['store'];
        $this->data['namadepan']=$outlet['firstname'];
        $this->data['namabelakang']=$outlet['lastname'];

        $this->load->view('pelaporan/laporan/cetaklaporanpelaporan', $this->data);  
    }

public function laporanpelaporanall()
    {
        if(!in_array('viewpelaporan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
        $id_user = $this->session->userdata['id'];
        $outlet= $this->model_users->getUserData($id_user);
        $this->data['store']=$outlet['store'];
        $this->data['namadepan']=$outlet['firstname'];
        $this->data['namabelakang']=$outlet['lastname'];

        $this->load->view('pelaporan/laporan/cetaklaporanpelaporanall', $this->data);  
    }





 /*
    Update Data Store
    */
    public function updatestore()
    {   

       
        $id_user = $this->session->userdata['id'];
        $store_id = $this->session->userdata['store_id'];
        $store = $this->session->userdata['store'];

            $data = array(
                'store_id' => $store_id,
                'store' => $store,
            );

            $update = $this->model_pelaporan->updatestore($data, $id_user);
            if($update == true) {
                $this->session->set_flashdata('success', 'Produk Diupdate');
                redirect('pelaporan/', 'refresh');
            }
            else {
                $this->session->set_flashdata('Error', 'Terjadi Kesalahan Update!!');
            }
        
    }



}