<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ivn extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Inventaris';

        $this->load->model('model_products');
        $this->load->model('model_ivn');
        $this->load->model('model_users');
        $this->load->model('model_stores');
    }

    /* 
    * It only redirects to the manage product page
    */

    public function index()
    {
        if (!in_array('viewivn', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->data['store'] = $this->model_stores->getStoresoutlet();
        $this->data['div'] = $this->session->userdata['divisi'];
        $this->render_template('ivn/index', $this->data);
    }


    /*
Input Data+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/

    //tampil input data
    public function fetchivnDatainput()
    {
        $result = array('data' => array());

        $store_id = $this->session->userdata['store_id'];


        $div = $this->session->userdata['divisi'];

        if ($div == 11) {
            $data = $this->model_ivn->getlaporaninputstore($store_id);
        } elseif ($div == 1 or $div == 2 or $div == 3) {
            $data = $this->model_ivn->getlaporaninputstorediv($store_id, $div);
        }

        foreach ($data as $key => $value) {

            $result['data'][$key] = array(
                $value['tgl_masuk'],
                $value['nama'],
                $value['bagian'],
                $value['jumlah'],
                "Rp " . number_format($value['harga'], 0, ',', '.'),
                "Rp " . number_format($value['jumlah'] * $value['harga'], 0, ',', '.')
            );
        } // /foreach

        echo json_encode($result);
    }


    /*
Input Data+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/

    /*
    * Lihat Data Manage
    */
    public function fetchivnData()
    {
        $result = array('data' => array());

        $id_user = $this->session->userdata['id'];
        $store_id = $this->session->userdata['store_id'];

        $div = $this->session->userdata['divisi'];


        if ($div == 11 or $div == 1 or $div == 2 or $div == 3) {
            $data = $this->model_ivn->getivnDatastore($store_id);
        } elseif ($div == 0) {
            $data = $this->model_ivn->getivnDatall();
        }



        foreach ($data as $key => $value) {
            // button


            $buttons = ' <div class="btn-group dropleft">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span></button>
            <ul class="dropdown-menu">';

            if (in_array('updateivn', $this->permission)) {
                $buttons .= '<li><a href="' . base_url('ivn/update/' . $value['id']) . '"><i class="fa fa-pencil"></i> Edit</a></li>';
            }

            if (in_array('deleteivn', $this->permission)) {
                $buttons .= '<li><a style="cursor:pointer;" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i> Hapus</a></li>';
            }

            $buttons .= '</ul></div>';

            if ($value['img']) {
                $img = '<a href="' . base_url($value['img']) . '" target="_blank"><img src="' . base_url($value['img']) . '" alt="' . $value['nama'] . '" class="img-circle" width="50" height="50" /></a>';
            } else {
                $img = '<img src="' . base_url('uploads/ivn_image/unnamed.png') . '" width="50" height="50" alt="' . $value['nama'] . '" title="Gambar Tidak Ada" class="img-circle" width="50" height="50" />';
            }


            $hasil_rupiah = "Rp " . number_format($value['harga'], 0, ',', '.');

            if ($div == 11 or $div == 1 or $div == 2 or $div == 3) {
                $result['data'][$key] = array(
                    $img,
                    $value['bagian'],
                    $value['nama'],
                    $hasil_rupiah,
                    $value['jumlah'],


                );
            } else {
                $result['data'][$key] = array(
                    $buttons,
                    $value['store'],
                    $img,
                    $value['bagian'],
                    $value['nama'],
                    $hasil_rupiah,
                    $value['jumlah'],
                );
            }
        } // /foreach

        echo json_encode($result);
    }



    /*
    Update
    */
    public function update($ivn_id)
    {
        if (!in_array('updateivn', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        if (!$ivn_id) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            // true case
            $data = array(
                'bagian' =>  $this->input->post('bagian'),
                'nama' => $this->input->post('nama'),
                'harga' => $this->input->post('harga'),
                'jumlah' => $this->input->post('jumlah'),
            );


            if ($_FILES['ivn_image']['size'] > 0) {
                $upload_image = $this->upload_imageivn();
                $upload_image = array('img' => $upload_image);

                $this->model_ivn->update($upload_image, $ivn_id);
            }

            $update = $this->model_ivn->update($data, $ivn_id);
            if ($update == true) {
                $this->session->set_flashdata('Berhasil', 'Produk Diupdate');
                redirect('ivn/', 'refresh');
            } else {
                $this->session->set_flashdata('Eror', 'Terjadi Kesalahan Update!!');
                redirect('ivn/update/' . $ivn_id, 'refresh');
            }
        } else {


            $ivn_data = $this->model_ivn->getivneditData($ivn_id);
            $this->data['ivn_data'] = $ivn_data;
            $this->render_template('ivn/edit', $this->data);
        }
    }

    /*
    * Hapus
    */
    public function remove()
    {
        if (!in_array('deleteivn', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $ivn_id = $this->input->post('ivn_id');

        $response = array();
        if ($ivn_id) {
            $delete = $this->model_ivn->remove($ivn_id);
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









    //Laporan Inventaris
    public function laporaninventaris()
    {
        if (!in_array('viewivn', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $id_user = $this->session->userdata['id'];
        $outlet = $this->model_users->getUserData($id_user);
        $this->data['store'] = $outlet['store'];
        $this->data['namadepan'] = $outlet['firstname'];
        $this->data['namabelakang'] = $outlet['lastname'];

        $this->load->view('ivn/laporan/cetaklaporaninventaris', $this->data);
    }


    public function laporanasset()
    {
        if (!in_array('viewivn', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $id_user = $this->session->userdata['id'];
        $store_id = $this->session->userdata['store_id'];
        $outlet = $this->model_users->getUserData($id_user);
        $this->data['store'] = $outlet['store'];
        //nama akun
        $user_id = $this->session->userdata('id');
        $outlet = $this->model_users->getUserData($user_id);
        $this->data['nama'] = $outlet['firstname'] . ' ' . $outlet['lastname'];
        $this->data['ivn'] = $this->model_ivn->getivnDatastore($store_id);

        $this->load->view('ivn/laporan/cetaklaporanasset', $this->data);
    }
    //Selesai








    //Laporan Inventaris Baru
    public function create()
    {
        if (!in_array('createivn', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');


        $id_user = $this->session->userdata['id'];
        $store = $this->session->userdata['store'];
        $div = $this->session->userdata['divisi'];
        $store_id = $this->session->userdata['store_id'];


        if ($this->form_validation->run() == TRUE) {
            // true case
            $upload_image = $this->upload_imageivn();

            $bgn = $this->input->post('bagian');
            if ($bgn == 1) {
                $bagian = 'Bar & Kasir';
            } elseif ($bgn == 2) {
                $bagian = 'Waiter';
            } elseif ($bgn == 3) {
                $bagian = 'Kitchen';
            };

            $data = array(
                'user_id' => $id_user,
                'store' => $store,
                'store_id' => $store_id,
                'bagian' =>  $bagian,
                'nama' => $this->input->post('nama'),
                'img' => $upload_image,
                'harga' => $this->input->post('harga'),
                'jumlah' => $this->input->post('jumlah'),
                'bulan' => $this->input->post('bulan'),
                'tahun' => $this->input->post('tahun'),
                'divisi' => $this->input->post('bagian'),
            );

            $laporan = array(
                'user_id' => $id_user,
                'store' => $store,
                'store_id' => $store_id,
                'bagian' =>  $bagian,
                'tgl_masuk' => $this->input->post('tgl_masuk'),
                'nama' => $this->input->post('nama'),
                'harga' => $this->input->post('harga'),
                'jumlah' => $this->input->post('jumlah'),
                'divisi' => $this->input->post('bagian'),
            );

            $create = $this->model_ivn->laporanbaru($laporan);
            $create = $this->model_ivn->create($data);
            if ($create == true) {
                $this->session->set_flashdata('success', 'Inventaris Ditambahkan');
                redirect('ivn/create', 'refresh');
            } else {
                $this->session->set_flashdata('error', 'Terjadi Kesalahan Penambahan!!');
                redirect('ivn/create', 'refresh');
            }
        } else {
            // false case       

            $this->render_template('ivn/create', $this->data);
        }
    }

    public function upload_imageivn()
    {
        // assets/images/product_image
        $config['upload_path'] = 'uploads/ivn_image';
        $config['file_name'] =  uniqid();
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '5000';

        // $config['max_width']  = '1024';s
        // $config['max_height']  = '768';

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('ivn_image')) {
            $error = $this->upload->display_errors();
            $dt = '';
            return $dt;
        } else {
            $data = array('upload_data' => $this->upload->data());
            $type = explode('.', $_FILES['ivn_image']['name']);
            $type = $type[count($type) - 1];

            $path = $config['upload_path'] . '/' . $config['file_name'] . '.' . $type;
            return ($data == true) ? $path : false;
        }
    }


    //selesai




    //Laporan Inventaris Masuk
    public function bmasuk()
    {
        if (!in_array('createivn', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $id_user = $this->session->userdata['id'];
        $store = $this->session->userdata['store'];
        $store_id = $this->session->userdata['store_id'];

        $this->form_validation->set_rules('nama', 'nama', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $id = $this->input->post('nama');
            $jumlah = $this->input->post('jumlah');

            $ambildata = $this->model_ivn->getivneditData($id);
            $nama = $ambildata['nama'];
            $bagian = $ambildata['bagian'];
            $harga = $ambildata['harga'];
            $bulan = $ambildata['bulan'];
            $tahun = $ambildata['tahun'];
            $divisi = $ambildata['divisi'];
            $qty = $jumlah + $ambildata['jumlah'];

            $laporan = array(
                'user_id' => $id_user,
                'store' => $store,
                'store_id' => $store_id,
                'tgl_masuk' => $this->input->post('tgl_bmasuk'),
                'nama' => $nama,
                'jumlah' => $jumlah,
                'bagian' => $bagian,
                'nama' => $nama,
                'harga' => $harga,
                'divisi' => $divisi,
            );
            $data = array(
                'jumlah' => $qty,
            );

            $create = $this->model_ivn->createivn($laporan);
            $update = $this->model_ivn->update($data, $id);
            if ($update == true) {
                $this->session->set_flashdata('success', 'Stock bertambah');
                redirect('ivn/bmasuk', 'refresh');
            } else {
                $this->session->set_flashdata('Error', 'Terjadi Kesalahan !!');
                redirect('ivn/bmasuk', 'refresh');
            }
        }

        $div = $this->session->userdata['divisi'];

        if ($div == 11) {
            $this->data['ivn'] = $this->model_ivn->getivnDatastore($store_id);
        } elseif ($div == 1 or $div == 2 or $div == 3) {
            $this->data['ivn'] = $this->model_ivn->getivnDatastorediv($store_id, $div);
        }
        $this->render_template('ivn/bmasuk', $this->data);
    }

    public function laporanivnmasuk()
    {

        $result = array('data' => array());

        $id_user = $this->session->userdata['id'];
        $store_id = $this->session->userdata['store_id'];

        $div = $this->session->userdata['divisi'];

        if ($div == 11) {
            $data = $this->model_ivn->getlaporanmasukstore($store_id);
        } elseif ($div == 1 or $div == 2 or $div == 3) {
            $data = $this->model_ivn->getlaporanmasukstorediv($store_id, $div);
        }


        foreach ($data as $key => $value) {

            $result['data'][$key] = array(
                $value['tgl_masuk'],
                $value['nama'],
                $value['bagian'],
                $value['jumlah'],
                "Rp " . number_format($value['harga'], 0, ',', '.'),
                "Rp " . number_format($value['harga'] * $value['jumlah'], 0, ',', '.')
            );
        } // /foreach

        echo json_encode($result);
    }

    //Selesai






    /* laporan Keluar Inventaris*/
    public function lkeluar()
    {
        if (!in_array('createivn', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $id_user = $this->session->userdata['id'];
        $id_store = $this->session->userdata['store_id'];
        $store = $this->session->userdata['store'];

        $this->form_validation->set_rules('nama', 'nama', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $id = $this->input->post('nama');
            $jumlah = $this->input->post('jumlah');

            $ambildata = $this->model_ivn->getivneditData($id);
            $nama = $ambildata['nama'];
            $bagian = $ambildata['bagian'];
            $bulan = $ambildata['bulan'];
            $tahun = $ambildata['tahun'];
            $qty = $ambildata['jumlah'] - $jumlah;
            $harga = $ambildata['harga'];
            $divisi = $ambildata['divisi'];

            $laporan = array(
                'user_id' => $id_user,
                'store' => $store,
                'store_id' => $id_store,
                'tgl_keluar' => $this->input->post('tgl_keluar'),
                'nama' => $nama,
                'jumlah' => $jumlah,
                'bagian' => $bagian,
                'nama' => $nama,
                'ke' => $this->input->post('ke'),
                'harga' => $harga,
                'divisi' => $divisi,
            );
            $data = array(
                'jumlah' => $qty,
            );

            $create = $this->model_ivn->createivnkeluar($laporan);
            $update = $this->model_ivn->update($data, $id);
            if ($update == true) {
                $this->session->set_flashdata('success', 'Inventaris Anda Berkurang');
                redirect('ivn/lkeluar', 'refresh');
            } else {
                $this->session->set_flashdata('error', 'Terjadi Kesalahan !!');
                redirect('ivn/lkeluar/', 'refresh');
            }
        }

        $div = $this->session->userdata['divisi'];

        if ($div == 11) {
            $this->data['ivn'] = $this->model_ivn->getivnDatastore($id_store);
        } elseif ($div == 1 or $div == 2 or $div == 3) {
            $this->data['ivn'] = $this->model_ivn->getivnDatastorediv($id_store, $div);
        }
        $this->render_template('ivn/lkeluar', $this->data);
    }
    public function laporanivnkeluar()
    {
        $result = array('data' => array());

        $store_id = $this->session->userdata['store_id'];



        $div = $this->session->userdata['divisi'];

        if ($div == 11) {
            $data = $this->model_ivn->getlaporankaluar($store_id);
        } elseif ($div == 1 or $div == 2 or $div == 3) {
            $data = $this->model_ivn->getlaporankaluardiv($store_id, $div);
        }

        foreach ($data as $key => $value) {

            $result['data'][$key] = array(
                $value['tgl_keluar'],
                $value['nama'],
                $value['bagian'],
                $value['ke'],
                $value['jumlah'],
                "Rp " . number_format($value['harga'], 0, ',', '.'),
                "Rp " . number_format($value['harga'] * $value['jumlah'], 0, ',', '.')
            );
        } // /foreach

        echo json_encode($result);
    }



    //Selesai







    /* laporan Rusak Inventaris*/
    public function lrusak()
    {
        if (!in_array('createivn', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $id_user = $this->session->userdata['id'];
        $store = $this->session->userdata['store'];
        $store_id = $this->session->userdata['store_id'];

        $this->form_validation->set_rules('nama', 'nama', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $id = $this->input->post('nama');
            $jumlah = $this->input->post('jumlah');

            $ambildata = $this->model_ivn->getivnDataid($id);
            $nama = $ambildata['nama'];
            $bagian = $ambildata['bagian'];
            $bulan = $ambildata['bulan'];
            $tahun = $ambildata['tahun'];
            $harga = $ambildata['harga'];
            $qty = $ambildata['jumlah'] -  $jumlah;
            $divisi = $ambildata['divisi'];

            $laporan = array(
                'user_id' => $id_user,
                'store' => $store,
                'store_id' => $store_id,
                'tgl_rusak' => $this->input->post('tgl_rusak'),
                'nama' => $nama,
                'jumlah' => $jumlah,
                'bagian' => $bagian,
                'nama' => $nama,
                'ket' => $this->input->post('ket'),
                'harga' => $harga,
                'divisi' => $divisi,

            );
            $data = array(
                'jumlah' => $qty,
            );

            $create = $this->model_ivn->createivnrusak($laporan);
            $update = $this->model_ivn->update($data, $id);
            if ($update == true) {
                $this->session->set_flashdata('success', 'Inventaris Anda Berkurang');
                redirect('ivn/lrusak', 'refresh');
            } else {
                $this->session->set_flashdata('error', 'Terjadi Kesalahan !!');
                redirect('ivn/lrusak', 'refresh');
            }
        }

        $div = $this->session->userdata['divisi'];

        if ($div == 11) {
            $this->data['ivn'] = $this->model_ivn->getivnDatastore($store_id);
        } elseif ($div == 1 or $div == 2 or $div == 3) {
            $this->data['ivn'] = $this->model_ivn->getivnDatastorediv($store_id, $div);
        }
        $this->render_template('ivn/lrusak', $this->data);
    }
    //Tampil Laporan
    public function laporanivnrusak()
    {
        $result = array('data' => array());

        $store_id = $this->session->userdata['store_id'];



        $div = $this->session->userdata['divisi'];

        if ($div == 11) {
            $data = $this->model_ivn->getlaporanrusak($store_id);
        } elseif ($div == 1 or $div == 2 or $div == 3) {
            $data = $this->model_ivn->getlaporanrusakdiv($store_id, $div);
        }

        foreach ($data as $key => $value) {

            $result['data'][$key] = array(
                $value['tgl_rusak'],
                $value['nama'],
                $value['bagian'],
                $value['ket'],
                $value['jumlah'],
                "Rp " . number_format($value['harga'], 0, ',', '.'),
                "Rp " . number_format($value['harga'] * $value['jumlah'], 0, ',', '.')
            );
        } // /foreach

        echo json_encode($result);
    }



    //Selesai




    public function arsip()
    {

        $id_user = $this->session->userdata['id'];
        $create = $this->model_ivn->arsip($id_user);
    }



    public function larsip()
    {
        if (!in_array('viewivn', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->render_template('ivn/larsip', $this->data);
    }



    public function tampilarsip()
    {

        $result = array('data' => array());

        $user_id = $this->session->userdata('id');
        $div = $this->session->userdata('divisi');
        $store_id = $this->session->userdata('store_id');

        if ($div == 11 or $div == 1 or $div == 2 or $div == 3) {
            $data = $this->model_ivn->getarsip($store_id);
        } elseif ($div == 0) {
            $data = $this->model_ivn->getarsip();
        }



        foreach ($data as $key => $value) {
            $bln = $value['bulan'];
            if ($bln == 1) {
                $bulan = 'Januari';
            } elseif ($bln == 2) {
                $bulan = 'Februari';
            } elseif ($bln == 3) {
                $bulan = 'Maret';
            } elseif ($bln == 4) {
                $bulan = 'April';
            } elseif ($bln == 5) {
                $bulan = ' Mei';
            } elseif ($bln == 6) {
                $bulan = 'Juni';
            } elseif ($bln == 7) {
                $bulan = 'Juli';
            } elseif ($bln == 8) {
                $bulan = 'Agustus';
            } elseif ($bln == 9) {
                $bulan = 'September';
            } elseif ($bln == 10) {
                $bulan = 'Oktober';
            } elseif ($bln == 11) {
                $bulan = 'November';
            } elseif ($bln == 12) {
                $bulan = 'Desember';
            }
            $result['data'][$key] = array(
                $bulan,
                $value['nama'],
                $value['bagian'],
                $value['jumlah'],
                $value['tahun'],
            );
        }
        echo json_encode($result);
    }



    //update tgl seleuruh manage
    public function updatebln()
    {
        $a = date('m');
        $b = ltrim($a, '0');
        $sql = "UPDATE ivn SET bulan = $b";
        $query = $this->db->query($sql);
        return;
    }


    /* Export To Excel Cuy
*/
    public function export_manage()
    {

        $id_user = $this->session->userdata['id'];

        $this->data['data'] = $this->model_ivn->getivnData($id_user);
        $this->data['m'] = date('M');
        $this->data['y'] = date('Y');

        $this->load->view('ivn/excel/export_manage', $this->data);
    }


    public function laporan()
    {
        if (!in_array('viewivn', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->render_template('ivn/laporan', $this->data);
    }

    public function proseslaporan()
    {
        if (!in_array('viewivn', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $div = $this->session->userdata('divisi');

        if ($div == 0) {
            //store
            $store_id = $this->input->post('store');

            $store = $this->model_stores->getStoresData($store_id);
            $outlet = $this->model_users->ambilleader($store_id);
            $this->data['nama'] = $outlet['firstname'] . ' ' . $outlet['lastname'];
            $this->data['store']  = $store['name'];
        } else {
            //nama akun
            $user_id = $this->session->userdata('id');
            $outlet = $this->model_users->getUserData($user_id);
            $this->data['nama'] = $outlet['firstname'] . ' ' . $outlet['lastname'];
            //store
            $store_id = $this->session->userdata('store_id');
            $this->data['store'] = $this->session->userdata('store');
        }



        $settgl_awal  = $this->input->post('tgl_awal');
        $tgl_awal = date("Y-m-d", strtotime($settgl_awal));

        $settgl_akhir   = $this->input->post('tgl_akhir');
        $tgl_akhir = date("Y-m-d", strtotime($settgl_akhir));

        //judul
        $tgla = date("d-M-Y", strtotime($settgl_awal));
        $tglak = date("d-M-Y", strtotime($tgl_akhir));
        $this->data['judul'] = 'Laporan Dari ' . $tgla . ' Sampai ' . $tglak;

        $this->data['rusak'] = $this->model_ivn->cetakpertanggalrusak($tgl_awal, $tgl_akhir, $store_id);
        $this->data['masuk'] = $this->model_ivn->cetakpertanggalmasukstore($tgl_awal, $tgl_akhir, $store_id);
        $this->data['baru'] = $this->model_ivn->cetakpertanggalbaru($tgl_awal, $tgl_akhir, $store_id);
        $this->data['keluar'] = $this->model_ivn->cetakpertanggalkeluar($tgl_awal, $tgl_akhir, $store_id);


        $this->data['ivn'] = $this->model_ivn->getivnDatastore($store_id);

        $this->load->view('ivn/laporan/cetaklaporan', $this->data);
    }
}
