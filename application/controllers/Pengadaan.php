<?php

defined('BASEPATH') or exit('No direct script access allowed');

class pengadaan extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Pengadaan';

        $this->load->model('model_pengadaan');
        $this->load->model('model_users');
    }

    /* 
    * It only redirects to the manage product page
    */

    public function index()
    {
        if (!in_array('viewpengadaan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->render_template('pengadaan/index', $this->data);
    }


    public function create()
    {
        if (!in_array('createpengadaan', $this->permission)) {
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
                'jumlah' => $this->input->post('jumlah'),
                'ket' => $this->input->post('ket'),
                'tgl_input' => $this->input->post('tgl_input'),
                'divisi' => $div,
            );


            $create = $this->model_pengadaan->create($data);
            if ($create == true) {
                $this->session->set_flashdata('success', 'Pengadaan Ditambahkan');
                redirect('pengadaan/create', 'refresh');
            } else {
                $this->session->set_flashdata('Eror', 'Terjadi Kesalahan Penambahan!!');
                redirect('pengadaan/create', 'refresh');
            }
        } else {
            // false case       
            $this->data['div'] = $this->session->userdata['divisi'];
            $this->render_template('pengadaan/create', $this->data);
        }
    }



    //Tampilkan data di create pengadaan
    public function fetchpengadaan()
    {
        $result = array('data' => array());
        $div = $this->session->userdata['divisi'];
        if ($div == 0) {
            $data = $this->model_pengadaan->getpengadaanseluruh();
        } else {
            if ($div == 11) {
                $store_id = $this->session->userdata['store_id'];
                $data = $this->model_pengadaan->getpengadaanstore($store_id);
            } else {
                $store_id = $this->session->userdata['store_id'];
                $data = $this->model_pengadaan->getpengadaandiv($store_id, $div);
            }
        }



        foreach ($data as $key => $value) {

            if ($value['divisi'] == 1) {
                $divisi = 'Bar & Kasir';
            } elseif ($value['divisi'] == 2) {
                $divisi = 'Waiter';
            } elseif ($value['divisi'] == 3) {
                $divisi = 'Kitchen';
            } else {
                $divisi = '-';
            };


            if (!$div == 0) {
                $result['data'][$key] = array(
                    $value['tgl_input'],
                    $value['nama'],
                    $value['jumlah'],
                    $value['ket'],
                );
            } else {
                $result['data'][$key] = array(
                    $value['tgl_input'],
                    $value['store'],
                    $divisi,
                    $value['nama'],
                    $value['jumlah'],
                    $value['ket'],
                );
            }
        } // /foreach

        echo json_encode($result);
    }




    //tampilkan data di manage
    public function fetchpengadaanData()
    {
        $result = array('data' => array());
        $id_user = $this->session->userdata['id'];
        $store_id = $this->session->userdata['store_id'];


        $div = $this->session->userdata['divisi'];
        if ($div == 0) {
            $data = $this->model_pengadaan->getpengadaanseluruh();
        } else {
            if ($div == 11) {
                $store_id = $this->session->userdata['store_id'];
                $data = $this->model_pengadaan->getpengadaanstore($store_id);
            } else {
                $store_id = $this->session->userdata['store_id'];
                $data = $this->model_pengadaan->getpengadaandiv($store_id, $div);
            }
        }

        foreach ($data as $key => $value) {


            if ($value['divisi'] == 1) {
                $divisi = 'Bar & Kasir';
            } elseif ($value['divisi'] == 2) {
                $divisi = 'Waiter';
            } elseif ($value['divisi'] == 3) {
                $divisi = 'Kitchen';
            } else {
                $divisi = '-';
            };

            $buttons = ' <div class="btn-group dropleft">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span></button>
            <ul class="dropdown-menu">';
            if (in_array('updatepengadaan', $this->permission)) {
                $buttons .= '<li><a href="' . base_url('pengadaan/update/' . $value['id']) . '"><i class="fa fa-pencil"></i> Edit</a></li>';
            }

            if (in_array('deletepengadaan', $this->permission)) {
                $buttons .= '<li><a style="cursor:pointer;" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i> Hapus</a></li>';
            }
            $buttons .= '</ul></div>';

            $status = $value['status'];
            if ($status == 0) {
                $sts = '<span class="label label-warning">Proses</span>';
            } elseif ($status == 1) {
                $sts = '<span class="label label-danger">Ditolak</span>';
            } elseif ($status == 2) {
                $sts = '<span class="label label-success">Diterima</span>';
            }

            $result['data'][$key] = array(
                $buttons,
                $value['tgl_input'],
                $value['store'],
                $divisi,
                $value['nama'],
                $value['jumlah'],
                $value['ket'],
                $sts,


            );
        } // /foreach

        echo json_encode($result);
    }




    public function remove()
    {
        if (!in_array('deletepengadaan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $pengadaan_id = $this->input->post('pengadaan_id');

        $response = array();
        if ($pengadaan_id) {
            $delete = $this->model_pengadaan->remove($pengadaan_id);
            if ($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Berhasil Terhapus";
            } else {
                $response['success'] = false;
                $response['messages'] = "Kesalahan dalam database saat menghapus informasi produk";
            }
        } else {
            $response['success'] = false;
            $response['messages'] = "Refersh kembali!!";
        }

        echo json_encode($response);
    }




    /*
    Update
    */
    public function update($pengadaan_id)
    {
        if (!in_array('updatepengadaan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        if (!$pengadaan_id) {
            redirect('dashboard', 'refresh');
        }


        $this->form_validation->set_rules('status', 'Status', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            // true case
            $data = array(
                'status' => $this->input->post('status'),
            );

            $update = $this->model_pengadaan->update($data, $pengadaan_id);
            if ($update == true) {
                $this->session->set_flashdata('Berhasil', 'Produk Diupdate');
                redirect('pengadaan/', 'refresh');
            } else {
                $this->session->set_flashdata('Eror', 'Terjadi Kesalahan Update!!');
                redirect('pengadaan/', 'refresh');
            }
        } else {

            $pengadaan_data = $this->model_pengadaan->getpengadaanid($pengadaan_id);
            $this->data['pengadaan_data'] = $pengadaan_data;
            $this->render_template('pengadaan/edit', $this->data);
        }
    }


    public function laporanpengadaan()
    {
        if (!in_array('viewpengadaan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $id_user = $this->session->userdata['id'];
        $outlet = $this->model_users->getUserData($id_user);
        $this->data['store'] = $outlet['store'];
        $this->data['namadepan'] = $outlet['firstname'];
        $this->data['namabelakang'] = $outlet['lastname'];

        $this->load->view('pengadaan/laporan/cetaklaporanpengadaan', $this->data);
    }

    public function laporanpengadaanall()
    {
        if (!in_array('viewpengadaan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $id_user = $this->session->userdata['id'];
        $outlet = $this->model_users->getUserData($id_user);
        $this->data['store'] = $outlet['store'];
        $this->data['namadepan'] = $outlet['firstname'];
        $this->data['namabelakang'] = $outlet['lastname'];

        $this->load->view('pengadaan/laporan/cetaklaporanpengadaanall', $this->data);
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

        $update = $this->model_pengadaan->updatestore($data, $id_user);
        if ($update == true) {
            $this->session->set_flashdata('success', 'Produk Diupdate');
            redirect('pengadaan/', 'refresh');
        } else {
            $this->session->set_flashdata('Error', 'Terjadi Kesalahan Update!!');
        }
    }
}
