<?php

defined('BASEPATH') or exit('No direct script access allowed');

require('./assets/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


require('./assets/fpdf/fpdf.php');

class Absen extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Absen';


        $this->load->model('model_users');
        $this->load->model('model_groups');
        $this->load->model('model_stores');
        $this->load->model('model_absen');
    }


    public function index()
    {

        $absen_data = $this->model_absen->getabsen();

        $this->data['absen_data'] = $absen_data;

        $this->render_template('absen/index', $this->data);
    }


    public function laporan()
    {

        $absen_data = $this->model_absen->getabsen();

        $this->data['absen_data'] = $absen_data;

        $this->render_template('absen/laporan', $this->data);
    }


    public function create()
    {

        $this->form_validation->set_rules('tgl', 'Tanggal', 'trim|required');

        if ($this->form_validation->run() == TRUE) {

            $data = array(
                'tgl' => $this->input->post('tgl'),
                'nama' => $this->input->post('nama'),
                'pagi' => $this->input->post('pagi'),
                'sore' => $this->input->post('sore'),
                'middapro' => $this->input->post('middapro'),
                'izin' => $this->input->post('izin'),
                'waktu' => $this->input->post('waktu')

            );

            $create = $this->model_absen->create($data);
            if ($create == true) {
                $this->session->set_flashdata('success', 'Data Telah di Tambahkan');
                redirect('absen/create', 'refresh');
            } else {
                $this->session->set_flashdata('error', 'Maaf Terjadi Kegagalan!!');
                redirect('absen/create', 'refresh');
            }
        } else {
            $this->render_template('absen/create', $this->data);
        }
    }


    public function remove()
    {
        $id = $this->input->post('id');
        $delete = $this->model_absen->delete($id);
    }



    public function excel()
    {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getProperties()
            ->setCreator("Fembi Nur Ilham")
            ->setLastModifiedBy("Fembi Nur Ilham")
            ->setTitle("Laporan Absensi")
            ->setSubject("Hasil Export Dari PRS System")
            ->setDescription("Semoga Terbantu Dengan Adanya Ini")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Absensi");


        $spreadsheet->getActiveSheet()->mergeCells('A1:H1');
        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);

        $sheet->setCellValue('A1', 'Data Keterlambatan/Izin Office Bulan Februari');

        $sheet->setCellValue('A3', 'No');
        $sheet->setCellValue('B3', 'Tanggal');
        $sheet->setCellValue('C3', 'Nama Karyawan');
        $sheet->setCellValue('D3', 'Alasan Absen Pagi Kosong/terlambat');
        $sheet->setCellValue('E3', 'Absen Middle Dapro Kosong');
        $sheet->setCellValue('F3', 'Alasan Absen Sore Kosong/lebih awal');
        $sheet->setCellValue('G3', 'Izin tidak masuk kerja');
        $sheet->setCellValue('H3', 'Waktu');

        $tglawal = $this->input->post('tglawal');
        $tglakhir = $this->input->post('tglakhir');

        $filename = 'Laporan Absensi ' . $tglawal . ' Sampai ' . $tglakhir . '.xlsx';

        $data = $this->model_absen->getabsentgl($tglawal, $tglakhir);


        if ($data) {
            $baris = 4;
            $no = 1;
            foreach ($data as $key => $v) {
                $sheet->setCellValue('A' . $baris, $no);
                $sheet->setCellValue('B' . $baris, $v['tgl']);
                $sheet->setCellValue('C' . $baris, $v['nama']);
                $sheet->setCellValue('D' . $baris, $v['pagi']);
                $sheet->setCellValue('E' . $baris, $v['middapro']);
                $sheet->setCellValue('F' . $baris, $v['sore']);
                $sheet->setCellValue('G' . $baris, $v['izin']);
                $sheet->setCellValue('H' . $baris, $v['waktu']);

                $baris++;
                $no++;
            }

            $writer = new Xlsx($spreadsheet);
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Content-Type: application/vnd.ms-excel');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        } else {
            $this->session->set_flashdata('error', 'Maaf data tidak ada');
            redirect('absen', 'refresh');
        }
    }
}
