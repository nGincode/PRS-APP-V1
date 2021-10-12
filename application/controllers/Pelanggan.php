<?php

defined('BASEPATH') or exit('No direct script access allowed');

require('./assets/phpoffice/vendor/autoload.php');

require('./assets/fpdf/fpdf.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Pelanggan extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Pelanggan';


        $this->load->model('model_users');
        $this->load->model('model_groups');
        $this->load->model('model_stores');
        $this->load->model('model_pelanggan');
    }


    public function index()
    {
        if (!in_array('viewpelanggan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $div = $this->session->userdata('divisi');
        if ($div == 0) {
            $pelanggan_data = $this->model_pelanggan->getpelanggan();
        } else {
            $store_id = $this->session->userdata('store_id');
            $pelanggan_data = $this->model_pelanggan->getpelangganid($store_id);
        }
        $this->data['pelanggan_data'] = $pelanggan_data;

        $this->render_template('pelanggan/index', $this->data);
    }

    public function create()
    {
        if (!in_array('createpelanggan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('tgl', 'Tanggal', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            // true case

            $user_id = $this->session->userdata('id');
            $store_id = $this->session->userdata('store_id');
            $store = $this->session->userdata('store');
            $tgl = $this->input->post('tgl');
            $dttgl = $this->model_pelanggan->cektgl($tgl);

            if ($dttgl < 1) {
                $data = array(
                    'tgl' => $tgl,
                    'pr' => $this->input->post('pr'),
                    'lk' => $this->input->post('lk'),
                    'user_id' => $user_id,
                    'store_id' => $store_id,
                    'store' => $store,

                );

                $create = $this->model_pelanggan->create($data);
                if ($create == true) {
                    $this->session->set_flashdata('success', 'Data Telah di Tambahkan');
                    redirect('pelanggan/create', 'refresh');
                } else {
                    $this->session->set_flashdata('error', 'Maaf Terjadi Kegagalan!!');
                    redirect('pelanggan/create', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error', 'Maaf Tanggal Anda Telah diinput Sebelumnya !!');
                redirect('pelanggan/create', 'refresh');
            }
        } else {

            $div = $this->session->userdata('divisi');
            if ($div == 0) {
                $pelanggan_data = $this->model_pelanggan->getpelanggan();
            } else {
                $store_id = $this->session->userdata('store_id');
                $pelanggan_data = $this->model_pelanggan->getpelangganid($store_id);
            }
            $this->data['pelanggan_data'] = $pelanggan_data;
            $this->render_template('pelanggan/create', $this->data);
        }
    }


    public function excel()
    {

        $div = $this->session->userdata('divisi');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $getpelanggantgl = $this->model_pelanggan->getpelanggantgl($tgl_awal, $tgl_akhir);

        $filename = "Laporan Jumlah Pelanggan Dari " . $tgl_awal . " Sampai " . $tgl_akhir . ".xlsx";

        $spreadsheet->getProperties()
            ->setCreator("Fembi Nur Ilham")
            ->setLastModifiedBy("Fembi Nur Ilham")
            ->setTitle("Laporan Jumlah Pelanggan ")
            ->setSubject("Hasil Export Dari PRS System")
            ->setDescription("Semoga Terbantu Dengan Adanya Ini")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Order");

        $sheet->setCellValue('A1', 'Laporan Jumlah Pelanggan');
        $sheet->setCellValue('A2', 'Tanggal ' . $tgl_awal . '-' . $tgl_akhir);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);

        $sheet->setCellValue('A4', 'No');
        $sheet->setCellValue('B4', 'Store');
        $sheet->setCellValue('C4', 'Tanggal');
        $sheet->setCellValue('D4', 'Perempuan');
        $sheet->setCellValue('E4', 'Laki-Laki');
        $sheet->setCellValue('F4', 'Jumlah');

        $baris = 5;
        $no = 1;
        if ($getpelanggantgl) {
            foreach ($getpelanggantgl as $key => $value) {
                $jmlhh = $value['pr'] + $value['lk'];
                $sheet->setCellValue('A' . $baris, $no++);
                $sheet->setCellValue('B' . $baris, $value['store']);
                $sheet->setCellValue('C' . $baris, $value['tgl']);
                $sheet->setCellValue('D' . $baris, $value['pr']);
                $sheet->setCellValue('E' . $baris, $value['lk']);
                $sheet->setCellValue('F' . $baris, $jmlhh);
                $baris++;
            }
            $writer = new Xlsx($spreadsheet);
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Content-Type: application/vnd.ms-excel');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        } else {

            $this->session->set_flashdata('error', 'Data Tidak Ditemukan');
            redirect('pelanggan/', 'refresh');
        }
    }


    public function remove()
    {
        $id = $this->input->post('id');
        $this->model_pelanggan->delete($id);
    }






    public function edit($id)
    {
        $user_id = $this->session->userdata('id');
        $store_id = $this->session->userdata('store_id');
        $store = $this->session->userdata('store');

        $this->form_validation->set_rules('tgl', 'Tanggal', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            // true case

            $gop = $this->input->post('pemasukan') - $this->input->post('pengeluaran');

            $data = array(
                'pengeluaran' => $this->input->post('pengeluaran'),
                'pettycash' => $this->input->post('pettycash'),
                'pemasukkan' => $this->input->post('pemasukan'),
                'gop' => $gop,
                'user_id' => $user_id,
                'store_id' => $store_id,
                'store' => $this->input->post('store'),

            );

            $create = $this->model_omzet->edit($data, $id);
            if ($create == true) {
                $this->session->set_flashdata('success', 'Data Telah di Edit');
                redirect('Omzet/', 'refresh');
            } else {
                $this->session->set_flashdata('error', 'Maaf Terjadi Kegagalan!!');
                redirect('Omzet/edit' . $id, 'refresh');
            }
        } else {
            $store_id = $this->session->userdata('store_id');
            $omzet_data = $this->model_omzet->getomzetidedit($store_id, $id);

            $this->data['omzet_data'] = $omzet_data;

            $this->render_template('omzet/edit', $this->data);
        }
    }
}
