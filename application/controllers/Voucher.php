<?php

defined('BASEPATH') or exit('No direct script access allowed');

require('./assets/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


require('./assets/fpdf/fpdf.php');

class Voucher extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Voucher';


        $this->load->model('model_users');
        $this->load->model('model_groups');
        $this->load->model('model_stores');
        $this->load->model('model_vocgif');
    }


    public function data()
    {

        $this->render_template('voc_giv/data', $this->data);
    }


    public function fetchData()
    {
        $var = $this->input->post('tgl');
        $tgl = str_replace('/', '-', $var);
        $hasil = explode(" - ", $tgl);
        $dari = date('Y-m-d', strtotime($hasil[0]));
        $sampai = date('Y-m-d', strtotime($hasil[1]));

        $data = $this->model_vocgif->select_all_tgl($dari, $sampai);
        // $data = $this->model_vocgif->givdata();


        if ($data) {
            foreach ($data as $key => $pakai) {


                if ($pakai['claim'] == 1) {
                    $claim =  '<button class="btn btn-success"><i class="glyphicon glyphicon-ok"></i></button>';
                } else {
                    $claim =  '<button class="btn btn-danger" data-id="168"><i class="glyphicon glyphicon-remove"></i></button>';
                }

                $store = $this->model_stores->getStoresData($pakai['outlet']);
                if ($pakai['outlet'] == 0) {
                    $ui =  'Tidak Terdeteksi';
                } else {
                    $ui = $store['name'];
                }

                $result['data'][$key] = array(
                    $claim,
                    $pakai['kode'],
                    $pakai['namavoc'],
                    $ui,
                    $pakai['tglmasuk']
                );
            }
            echo json_encode($result);
        } else {
            $result['data'] = array();
            echo json_encode($result);
        }
    }




    public function create()
    {

        $this->data['outlet'] = $this->model_stores->getStoresData();
        $this->data['sumber'] = $this->model_vocgif->namavocall();
        $this->data['namavoucher'] = $this->model_vocgif->namavocall();
        $this->data['data'] = $this->model_vocgif->givdata();
        $this->render_template('voc_giv/create', $this->data);
    }


    public function buatnamavoc()
    {
        if (isset($_POST)) {
            $nama = $this->input->post('nama_voucher');
            $outlet = $this->input->post('outlet');

            $data = $this->model_vocgif->validasinama($nama);
            if (!$data > 0) {

                $config['upload_path']          = './uploads/voucher';
                $config['file_name']          = $nama;
                $config['allowed_types']        = 'jpg';

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('img')) {
                    $error = $this->upload->display_errors();
                    print_r($error);
                    echo '<br>Upload Gagal';
                } else {
                    $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
                    $file_name = $upload_data['file_name'];
                    $data = array(
                        'nama' => $nama,
                        'untuk' => $outlet,
                        'tglbuat' => date('Y-m-d'),
                        'img' => $file_name
                    );

                    $create = $this->model_vocgif->create($data);

                    if ($create == true) {
                        $this->session->set_flashdata('success', 'Berhasil di Tambah');
                        redirect('Voucher/create', 'refresh');
                    } else {
                        $this->session->set_flashdata('error', 'Terjadi Kesalahan !!!');
                        redirect('Voucher/create', 'refresh');
                    }
                }
            } else {
                $this->session->set_flashdata('error', 'Nama Tidak Boleh Sama');
                redirect('Voucher/create', 'refresh');
            }
        }
    }


    public function buatvoc()
    {

        if (isset($_POST)) {
            $jml = $this->input->post('jml');

            if ($jml) {
                include("assets/phpqrcode/qrlib.php");
                $valid = 0;
                for ($i = 0; $i < $jml; $i++) {
                    $kode  = 'GIV' . substr(str_shuffle(str_repeat("0123456789", 7)), 0, 7);
                    $cekvocer = $this->model_vocgif->cekvocer($kode);
                    $asal = $this->input->post('asal');
                    $outlet = $this->input->post('outlet');
                    $kadaluarsa = $this->input->post('kadaluarsa');

                    if (!$cekvocer > 0) {


                        $namav = $this->model_vocgif->namavoc($asal);

                        $data = array(
                            'namavoc' => $namav['nama'],
                            'kode' => $kode,
                            'asal' => $asal,
                            'tempat' => $outlet,
                            'kadaluarsa' => $kadaluarsa
                        );

                        $create = $this->model_vocgif->createdata($data);


                        if ($create == true) {


                            $tempdir = FCPATH . '/assets/data qr/';

                            if (!file_exists($tempdir)) #kalau folder belum ada, maka buat.
                                mkdir($tempdir);
                            $isi_teks = "$kode";
                            $namafile = "$kode.png";
                            $quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
                            $ukuran = 8; //batasan 1 paling kecil, 10 paling besar
                            $padding = 0;

                            QRCode::png($isi_teks, $tempdir . $namafile, $quality, $ukuran, $padding);


                            $valid += 0;
                        } else {
                            $valid += 1;
                        }
                    } else {
                        $valid += 100;
                    }
                }
                if ($valid == 100) {
                    $this->session->set_flashdata('error', 'Voucher Telah Ada');
                    redirect('Voucher/create', 'refresh');
                } else if ($valid == 0) {
                    $this->session->set_flashdata('success', 'Berhasil Menambah Voucher');
                    redirect('Voucher/create', 'refresh');
                } else if ($valid > 0) {
                    $this->session->set_flashdata('error', 'Beberapa Voucher Gagal');
                    redirect('Voucher/create', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error', 'Masukkan Jumlah Voucher');
                redirect('Voucher/create', 'refresh');
            }
        }
    }


    public function print()
    {
        $asal = $this->input->post('asal');
        $data['akun'] = $this->model_vocgif->select_asal($asal);
        $this->load->view('voc_giv/print', $data);
    }

    public function remove()
    {

        $id = $this->input->post('id');
        $tiket_data = $this->model_vocgif->namavoc($id);
        $response = array();
        if ($tiket_data) {
            $cek = $this->model_vocgif->cekdata($id);
            if ($cek < 1) {
                $delete = $this->model_vocgif->removenv($id);
                if ($delete == true) {
                    unlink("./uploads/voucher/" . $tiket_data['img']);
                    $response['success'] = true;
                    $response['messages'] = "Berhasil Terhapus";
                } else {
                    $response['success'] = false;
                    $response['messages'] = "Kesalahan dalam database saat menghapus informasi produk";
                }
            } else {
                $response['success'] = false;
                $response['messages'] = "Vocuher Ada Yang Belum Terclaim";
            }
        }

        echo json_encode($response);
    }
}
