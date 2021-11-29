<?php

defined('BASEPATH') or exit('No direct script access allowed');

require('./assets/phpoffice/vendor/autoload.php');

require('./assets/fpdf/fpdf.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Pegawai extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Karyawan';


        $this->load->model('model_users');
        $this->load->model('model_groups');
        $this->load->model('model_stores');
        $this->load->model('model_pegawai');
    }


    public function index()
    {

        if (!in_array('viewPegawai', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $pegawai_data = $this->model_pegawai->getpegawai();

        $this->data['pegawai_data'] = $pegawai_data;

        $this->render_template('pegawai/index', $this->data);
    }


    public function apraisal()
    {
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'trim|required');

        if ($this->form_validation->run() == TRUE) {

            $id = $this->input->post('nama');
            $pegawai = $this->model_pegawai->getpegawaiid($id);
            $score = $this->input->post('score');
            $tipe = $this->input->post('tipe');
            if ($tipe == 1) {
                if ($score > 1424) {
                    $hasil = 'A';
                } elseif ($score > 1184) {
                    $hasil = 'B';
                } elseif ($score > 944) {
                    $hasil = 'C';
                } elseif ($score > 640) {
                    $hasil = 'D';
                } elseif ($score < 641) {
                    $hasil = 'E';
                }
            } else {
                if ($score > 979) {
                    $hasil = 'A';
                } elseif ($score > 814) {
                    $hasil = 'B';
                } elseif ($score > 649) {
                    $hasil = 'C';
                } elseif ($score > 440) {
                    $hasil = 'D';
                } elseif ($score < 441) {
                    $hasil = 'E';
                }
            }

            $store = $this->model_stores->getStoresData($pegawai['store_id']);

            $data = array(
                'score' => $this->input->post('score'),
                'tanggal' => $this->input->post('tanggal'),
                'nama' => $pegawai['nama'],
                'store' => $store['name'],
                'store_id' => $pegawai['store_id'],
                'divisi' => $pegawai['divisi'],
                'jabatan' => $pegawai['jabatan'],
                'nilai' => $hasil,
                'id_pegawai' => $id,

            );

            $create = $this->model_pegawai->createapraisal($data);
            if ($create == true) {
                $this->session->set_flashdata('success', 'Data Telah di Tambahkan');
                redirect('Pegawai/apraisal', 'refresh');
            } else {
                $this->session->set_flashdata('error', 'Maaf Terjadi Kegagalan!!');
                redirect('Pegawai/apraisal', 'refresh');
            }
        } else {

            $pegawai_data = $this->model_pegawai->getpegawai();
            $getapraisal = $this->model_pegawai->getapraisal();

            $this->data['pegawai_data'] = $pegawai_data;
            $this->data['apraisal_data'] = $getapraisal;
            $this->data['store'] = $this->model_stores->getStoresData();

            $this->render_template('pegawai/apresial', $this->data);
        }
    }


    public function laporan()
    {


        $this->data['store'] = $this->model_stores->getActiveStore();

        $this->render_template('pegawai/laporan', $this->data);
    }

    public function edit($id)
    {

        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            // true case

            $store_id = $this->input->post('store');
            $data = array(
                'nama' => $this->input->post('nama'),
                'lahir' => $this->input->post('lahir'),
                'tempat' => $this->input->post('tempat'),
                'jk' => $this->input->post('jk'),
                'masuk_kerja' => $this->input->post('masuk_kerja'),
                'divisi' => $this->input->post('divisi'),
                'jabatan' => $this->input->post('jabatan'),
                'alamat' => $this->input->post('alamat'),
                'hp' => $this->input->post('hp'),
                'agama' => $this->input->post('agama'),
                'keluar' => $this->input->post('status'),
                'store_id' => $store_id

            );

            $create = $this->model_pegawai->edit($data, $id);
            if ($create == true) {
                $this->session->set_flashdata('success', 'Data Telah di Tambahkan');
                redirect('Pegawai', 'refresh');
            } else {
                $this->session->set_flashdata('error', 'Maaf Terjadi Kegagalan!!');
                redirect('Pegawai/edit/' . $id, 'refresh');
            }
        } else {
            $pegawai_data = $this->model_pegawai->getpegawaiDataid($id);

            $this->data['pegawai_data'] = $pegawai_data;
            $this->data['store'] = $this->model_stores->getStoresData();

            $this->render_template('pegawai/edit', $this->data);
        }
    }

    public function remove()
    {
        $id = $this->input->post('id');
        $delete = $this->model_pegawai->delete($id);
    }

    public function removeappresial()
    {
        $id = $this->input->post('id');
        $delete = $this->model_pegawai->removeappresial($id);
    }

    public function removeabsen()
    {
        $id = $this->input->post('id');
        $absen = $this->model_pegawai->getabsenperid($id);
        $nama = $absen['image'];
        $delete = $this->model_pegawai->deleteabsen($id);
        unlink('uploads/absensi/' . $nama);
    }

    public function datapegawai()
    {

        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            // true case
            $store_id = $this->input->post('store');
            $data = array(
                'nama' => $this->input->post('nama'),
                'lahir' => $this->input->post('lahir'),
                'tempat' => $this->input->post('tempat'),
                'jk' => $this->input->post('jk'),
                'masuk_kerja' => $this->input->post('masuk_kerja'),
                'divisi' => $this->input->post('divisi'),
                'jabatan' => $this->input->post('jabatan'),
                'alamat' => $this->input->post('alamat'),
                'hp' => $this->input->post('hp'),
                'agama' => $this->input->post('agama'),
                'store_id' => $store_id

            );

            $create = $this->model_pegawai->create($data);
            if ($create == true) {
                $this->session->set_flashdata('success', 'Data Telah di Tambahkan');
                redirect('Pegawai/datapegawai', 'refresh');
            } else {
                $this->session->set_flashdata('error', 'Maaf Terjadi Kegagalan!!');
                redirect('Pegawai/datapegawai', 'refresh');
            }
        } else {
            $this->data['store'] = $this->model_stores->getStoresData();
            $this->render_template('pegawai/datapegawai', $this->data);
        }
    }

    public function absensi()
    {

        date_default_timezone_set("Asia/Jakarta");
        $store_id = $this->session->userdata('store_id');
        $this->data['dt_store'] = $this->model_stores->getStoresData($store_id);
        $div = $this->session->userdata('divisi');
        if (!$div == 0) {
            $pegawai_data = $this->model_pegawai->getpegawaiDataaktiv($store_id);
        } else {
            $pegawai_data = $this->model_pegawai->getpegawai();
        }

        $this->data['pegawai_data'] = $pegawai_data;
        $this->data['div'] = $div;
        $this->data['store'] = $this->model_stores->getStoresData();

        if (isset($_GET['filter'])) {
            $dt = $this->model_stores->getStoresData($_GET['filter']);
            if ($dt) {
                $this->data['pilih'] = $dt['name'];
            } else {
                $this->data['pilih'] = 'Tidak ditemukan';
            }
        } else {
            $this->data['pilih'] = 'SEMUA';
        };



        $this->render_template('pegawai/absensi', $this->data);
    }

    public function excelapresial()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getProperties()
            ->setCreator("Fembi Nur Ilham")
            ->setLastModifiedBy("Fembi Nur Ilham")
            ->setTitle("Appresial")
            ->setSubject("Hasil Export Dari PRS System")
            ->setDescription("Semoga Terbantu Dengan Adanya Ini")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Appresial");

        $styleArray = [
            'font' => [
                'bold' => true,
                'size' => 20,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                ],
            ],

        ];
        $alignmentcenter = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],

        ];

        $sheet->setCellValue('A1', 'Rekap Appraisal Outlet ');

        $spreadsheet->getActiveSheet()->mergeCells('A1:G1');
        $spreadsheet->getActiveSheet()->getStyle('A1:G1')->applyFromArray($alignmentcenter);
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('A3')->applyFromArray($alignmentcenter);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('B3')->applyFromArray($alignmentcenter);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('C3')->applyFromArray($alignmentcenter);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('D3')->applyFromArray($alignmentcenter);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('E3')->applyFromArray($alignmentcenter);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('F3')->applyFromArray($alignmentcenter);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('G3')->applyFromArray($alignmentcenter);

        $sheet->setCellValue('A3', 'No');
        $sheet->setCellValue('B3', 'Outlet');
        $sheet->setCellValue('C3', 'Divisi');
        $sheet->setCellValue('D3', 'Jabatan');
        $sheet->setCellValue('E3', 'Score');
        $sheet->setCellValue('F3', 'Nilai');
        $sheet->setCellValue('G3', 'Perpanjangan');

        $store_id = $this->input->post('outlet');
        if ($store_id == 0) {
            $data = $this->model_pegawai->getapresialall();
            $filename = "Rekap Appraisal Seluruh Outlet.xlsx";
        } else {
            $data = $this->model_pegawai->getapresialData($store_id);
            $store = $this->model_stores->getStoresData($store_id);
            $filename = "Rekap Appraisal " . $store['name'] . ".xlsx";
        }

        $baris = 4;
        $no = 1;
        $count = 4;
        if ($data) {
            foreach ($data as $key => $value) {

                $sheet->setCellValue('A' . $baris, $no++);
                $spreadsheet->getActiveSheet()->getStyle('A' . $baris)->applyFromArray($alignmentcenter);
                $sheet->setCellValue('B' . $baris, $value['store']);
                $spreadsheet->getActiveSheet()->getStyle('B' . $baris)->applyFromArray($alignmentcenter);
                $sheet->setCellValue('C' . $baris, $value['divisi']);
                $spreadsheet->getActiveSheet()->getStyle('C' . $baris)->applyFromArray($alignmentcenter);
                $sheet->setCellValue('D' . $baris, $value['jabatan']);
                $spreadsheet->getActiveSheet()->getStyle('D' . $baris)->applyFromArray($alignmentcenter);
                $sheet->setCellValue('E' . $baris, $value['score']);
                $spreadsheet->getActiveSheet()->getStyle('E' . $baris)->applyFromArray($alignmentcenter);
                $sheet->setCellValue('F' . $baris, $value['nilai']);
                $spreadsheet->getActiveSheet()->getStyle('F' . $baris)->applyFromArray($alignmentcenter);
                $sheet->setCellValue('G' . $baris, $value['tanggal']);
                $spreadsheet->getActiveSheet()->getStyle('G' . $baris)->applyFromArray($alignmentcenter);

                $baris++;
                $count++;
            }
            $writer = new Xlsx($spreadsheet);
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Content-Type: application/vnd.ms-excel');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        } else {

            $this->session->set_flashdata('error', 'Data Tidak Ditemukan');
            redirect('Pegawai/apraisal/', 'refresh');
        }
    }

    public function saveabsensi()
    {
        $nama = $this->input->post('nama');
        $image = $this->input->post('image');
        $ket = $this->input->post('ket');
        $sift = $this->input->post('sift');

        $store_id = $this->session->userdata('store_id');
        $store = $this->session->userdata('store');

        date_default_timezone_set("Asia/Jakarta");

        $waktu = date('H:i:s');

        if ($ket == 1) {
            $date = date('Y-m-d');
            $datev = 1;
            $masuk = 1;
            $keluar = 0;

            $waktusift = $this->model_stores->getStoresData($store_id);
            //waktu terlambat
            if ($sift == 1) {
                $cek = json_decode($waktusift['s1'], TRUE);
                if ($cek[0]) {
                    $cekwaktu = '';
                } else {
                    $cekwaktu = 'Shift 1';
                }
                if ($waktu > $cek[0]) {
                    $terlambat = 1;
                } else {
                    $terlambat = 0;
                }
            } else if ($sift == 2) {
                $cek = json_decode($waktusift['s2'], TRUE);
                if ($cek[0]) {
                    $cekwaktu = '';
                } else {
                    $cekwaktu = 'Shift 2';
                }
                if ($waktu > $cek[0]) {
                    $terlambat = 1;
                } else {
                    $terlambat = 0;
                }
            } else if ($sift == 3) {
                $cek = json_decode($waktusift['lembur'], TRUE);
                if ($cek[0]) {
                    $cekwaktu = '';
                } else {
                    $cekwaktu = 'lembur';
                }
                if ($waktu > $cek[0]) {
                    $terlambat = 1;
                } else {
                    $terlambat = 0;
                }
            } else if ($sift == 4) {
                $cek = json_decode($waktusift['khusus_s1'], TRUE);
                if ($cek[0]) {
                    $cekwaktu = '';
                } else {
                    $cekwaktu = 'Khusus Shift 1';
                }
                if ($waktu > $cek[0]) {
                    $terlambat = 1;
                } else {
                    $terlambat = 0;
                }
            } else if ($sift == 5) {
                $cek = json_decode($waktusift['khusus_s2'], TRUE);
                if ($cek[0]) {
                    $cekwaktu = '';
                } else {
                    $cekwaktu = 'Khusus Shift 1';
                }
                if ($waktu > $cek[0]) {
                    $terlambat = 1;
                } else {
                    $terlambat = 0;
                }
            }
            $pegawai = $this->model_pegawai->cekdulikatabsenm($date, $nama, 1);
        } else {
            $tgl = $this->model_pegawai->ambiltanggalakhirmasuk($nama, 1);
            if (isset($tgl)) {
                $date = $tgl['tgl'];
                $datev = 1;
            } else {
                $date = 0;
                $datev = 0;
            }
            $masuk = 0;
            $keluar = 1;
            $terlambat = 0;
            $cekwaktu = '';
            $pegawai = $this->model_pegawai->cekdulikatabsenk($date, $nama, 1);
        }

        $validkeluar = $this->model_pegawai->cekdulikatabsenm($date, $nama, 1);
        if (isset($cek[0])) {
            $time = date('H:i:s', strtotime("$cek[0]") - 60 * 60);
        } else {
            $time = 0;
        }
        if ($ket = 2 or $time < $waktu) {
            if ($ket = 2 or $waktu < '18:00:00') {
                if ($ket = 2 or $waktu > '05:00:00' or $ket == 2) {
                    if (!$cekwaktu) {
                        if ($datev == 1) {
                            if ($validkeluar > 0 or $pegawai == 0) {

                                if ($pegawai == 0) {

                                    $image = str_replace('data:image/jpeg;base64,', '', $image);
                                    $image = base64_decode($image);
                                    $filename = 'image_' . time() . '.png';
                                    file_put_contents(FCPATH . '/uploads/absensi/' . $filename, $image);
                                    if (file_exists(FCPATH . '/uploads/absensi/' . $filename)) {
                                        if (filesize(FCPATH . '/uploads/absensi/' .  $filename) > 1024) {

                                            $pegawai = $this->model_pegawai->getpegawaiid($nama);

                                            $data = array(
                                                'nama' => $pegawai['nama'],
                                                'image' => $filename,
                                                'store' => $store,
                                                'idpegawai' => $nama,
                                                'store_id' => $store_id,
                                                'waktu_masuk' => $masuk,
                                                'waktu_keluar' => $keluar,
                                                'tgl' => $date,
                                                'terlambat' => $terlambat,
                                                'sift' => $sift,
                                                'waktu' => $waktu

                                            );

                                            $res = $this->model_pegawai->insertabsen($data);
                                            echo json_encode($res);
                                        } else {
                                            echo json_encode('qw');
                                        }
                                    } else {
                                        echo json_encode('q');
                                    }
                                } else {
                                    echo json_encode(0);
                                }
                            } else {
                                echo json_encode(5);
                            }
                        } else {
                            echo json_encode('yy');
                        }
                    } else {
                        echo json_encode('zz');
                    }
                } else {
                    echo json_encode('xx');
                }
            } else {
                echo json_encode('xx');
            }
        } else {
            echo json_encode('cc');
        }
    }

    //diperbaiki
    public function absensiedit($id)
    {

        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            // true case

            $store_id = $this->session->userdata('store_id');
            $store = $this->session->userdata('store');
            $pegawai = $this->model_pegawai->getpegawaiid();

            $data = array();

            $update = $this->model_ivn->update($data);
            if ($update == true) {
                $this->session->set_flashdata('Berhasil', 'Produk Diupdate');
                redirect('ivn/', 'refresh');
            } else {
                $this->session->set_flashdata('Eror', 'Terjadi Kesalahan Update!!');
                redirect('ivn/update/', 'refresh');
            }
        } else {

            $store_id = $this->session->userdata('store_id');
            $div = $this->session->userdata('divisi');
            if (!$div == 0) {
                $this->data['pegawai_data'] = $this->model_pegawai->getpegawaiData($store_id);
                $this->data['absen'] = $this->model_pegawai->getabsenperid($id);
            } else {
                $this->data['pegawai_data'] = $this->model_pegawai->getpegawai();
                $this->data['absen'] = $this->model_pegawai->getabsenperid($id);
            }
            $this->data['store'] = $this->model_stores->getStoresData();
            $this->render_template('Pegawai/absensiedit', $this->data);
        }
    }

    public function laporanabsensi()
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
            ->setCategory("Laporan Absensi");

        $styleArray = [
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],

        ];
        $alignmentcenter = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],

        ];
        $styleborder = array(
            'borders' => array(
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => array('argb' => '8bc34a'),
                ],

            ),
        );

        $store_id = $this->input->post('outlet');
        $str = $this->model_stores->getStoresData($store_id);
        $store = $str['name'];
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');

        $sheet->setCellValue('A1', 'LAPORAN ABSENSI ' . $store . ' DARI ' . $tgl_awal . ' SAMPAI ' . $tgl_akhir);


        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->mergeCells('A3:A5');
        $spreadsheet->getActiveSheet()->mergeCells('B3:B5');

        $sheet->setCellValue('A3', 'No');
        $sheet->setCellValue('B3', 'Nama Karyawan');
        $sheet->setCellValue('C3', 'Tanggal');

        $spreadsheet->getActiveSheet()->mergeCells('A3:A5');
        $spreadsheet->getActiveSheet()->getStyle('A3:A5')->applyFromArray($alignmentcenter);

        $spreadsheet->getActiveSheet()->mergeCells('B3:B5');
        $spreadsheet->getActiveSheet()->getStyle('B3:B5')->applyFromArray($alignmentcenter);

        $alpa = 'C';
        $alpab = 'C';
        $baris = 6;
        $barisb = 6;
        $no = 1;
        $no2 = 1;

        // $data = $this->model_pegawai->excelabsensi($tgl_awal, $tgl_akhir, $store_id);
        $nama = $this->model_pegawai->namapegawai($store_id);
        $tgl = $this->model_pegawai->excelabsensijudul($tgl_awal, $tgl_akhir, $store_id);
        $filename = "Laporan Absensi " . $store . " Dari " . $tgl_awal . " Sampai " . $tgl_akhir . ".xlsx";

        if ($tgl) {

            foreach ($nama as $key => $n) {

                $alpac = 'C';
                $sheet->setCellValue('A' . $barisb, $no);
                $sheet->setCellValue('B' . $barisb, $n['nama']);

                foreach ($tgl as $key => $t) {

                    $masuk = $this->model_pegawai->excelmasuk($n['nama'], $t['tgl'], $store_id, 1);
                    $keluar = $this->model_pegawai->excelkeluar($n['nama'], $t['tgl'], $store_id, 1);
                    if ($masuk) {
                        $sheet->setCellValue($alpac++ . $baris, $masuk['waktu']);
                    } else {
                        $sheet->setCellValue($alpac++ . $baris, '');
                    }
                    if ($keluar) {
                        $sheet->setCellValue($alpac++ . $baris, $keluar['waktu']);
                    } else {
                        $sheet->setCellValue($alpac++ . $baris, '');
                    }
                }

                $jumlahmasuk = $this->model_pegawai->Jumalahmasuk($n['nama'], $tgl_awal, $tgl_akhir, $store_id, 1);
                $terlambat = $this->model_pegawai->terlambat($n['nama'], $tgl_awal, $tgl_akhir, $store_id, 1);
                $lembur = $this->model_pegawai->jumlahlembur($n['nama'], $tgl_awal, $tgl_akhir, $store_id, 3);



                $sheet->setCellValue($alpac++ . $baris, $terlambat);
                $sheet->setCellValue($alpac++ . $baris, $lembur);
                $sheet->setCellValue($alpac++ . $baris, $jumlahmasuk);

                $baris++;
                $barisb++;
                $no++;
            }
            foreach ($tgl as $key => $t) {
                $alph = $alpa;
                $alph++;
                $sheet->setCellValue($alpa . '4', $t['tgl']);
                $spreadsheet->getActiveSheet()->mergeCells($alpa . '4:' .  $alph . '4');
                $spreadsheet->getActiveSheet()->getStyle($alpa . '4:' .  $alph . '4')->applyFromArray($alignmentcenter);
                $sheet->setCellValue($alpa . '5', 'Masuk');
                $alpa++;
                $sheet->setCellValue($alpa . '5', 'Keluar');
                $alpa++;
                $alpab++;
            }


            $spreadsheet->getActiveSheet()->mergeCells('C3:' . $alph . '3');
            $spreadsheet->getActiveSheet()->getStyle('C3:' . $alph . '3')->applyFromArray($alignmentcenter);

            $alpab++;


            //$spreadsheet->getActiveSheet()->mergeCells('C3:' . $alpab . '3');
            //$spreadsheet->getActiveSheet()->getStyle('C3:' . $alpab . '3')->applyFromArray($alignmentcenter);

            $sheet->setCellValue($alpa . '3', 'Terlambat');
            $spreadsheet->getActiveSheet()->mergeCells($alpa . '3:' . $alpa . '5');
            $spreadsheet->getActiveSheet()->getStyle($alpa . '3:' . $alpa . '5')->applyFromArray($alignmentcenter);
            $sheet->getColumnDimension($alpa)->setAutoSize(true);
            $alpa++;

            $sheet->setCellValue($alpa . '3', 'Lembur');
            $spreadsheet->getActiveSheet()->mergeCells($alpa . '3:' . $alpa . '5');
            $spreadsheet->getActiveSheet()->getStyle($alpa . '3:' . $alpa . '5')->applyFromArray($alignmentcenter);
            $sheet->getColumnDimension($alpa)->setAutoSize(true);
            $alpa++;

            $sheet->setCellValue($alpa . '3', 'Total Absensi');
            $spreadsheet->getActiveSheet()->mergeCells($alpa . '3:' . $alpa . '5');
            $spreadsheet->getActiveSheet()->getStyle($alpa . '3:' . $alpa . '5')->applyFromArray($alignmentcenter);
            $sheet->getColumnDimension($alpa)->setAutoSize(true);


            $spreadsheet->getActiveSheet()->mergeCells('A1:' . $alpa . '1');
            $spreadsheet->getActiveSheet()->getStyle('A1:' . $alpa . '1')->applyFromArray($alignmentcenter);

            //border
            $baris--;
            $sheet->getStyle('A1')->applyFromArray($styleArray);
            $sheet->getStyle('A2:' . $alpa . '2')->applyFromArray($styleborder);
            $sheet->getStyle('A5:' . $alpa . '5')->applyFromArray($styleborder);
            $sheet->getStyle('A' . $baris . ':' . $alpa .  $baris)->applyFromArray($styleborder);


            $baris++;
            $baris++;


            $sheet->getStyle('A' . $baris)->applyFromArray($styleArray);
            $sheet->setCellValue('A' . $baris, 'Laporan History Absensi');
            $barislaporan = $baris;
            $baris++;
            $dtbrs = $baris;
            $baris++;

            $spreadsheet->getActiveSheet()->mergeCells('A3:A5');
            $spreadsheet->getActiveSheet()->mergeCells('B3:B5');
            $sheet->setCellValue('A' . $baris, 'No');
            $sheet->setCellValue('B' . $baris, 'Nama Karyawan');
            $sheet->setCellValue('C' . $baris, 'Tanggal');
            $alpad = 'C';
            $brs = $baris;
            $bb = $baris + 2;
            $spreadsheet->getActiveSheet()->mergeCells('A' . $baris . ':A' . $bb);
            $spreadsheet->getActiveSheet()->getStyle('A' . $baris . ':A' . $bb)->applyFromArray($alignmentcenter);

            $spreadsheet->getActiveSheet()->mergeCells('B' . $baris . ':B' . $bb);
            $spreadsheet->getActiveSheet()->getStyle('B' . $baris . ':B' . $bb)->applyFromArray($alignmentcenter);

            $baris++;

            $allp =  $alpad;
            foreach ($tgl as $key => $t) {
                $sheet->setCellValue($alpad . $baris, $t['tgl']);
                $alph = $alpad;
                $alph++;
                $spreadsheet->getActiveSheet()->mergeCells($alpad . $baris . ':' .  $alph . $baris);
                $spreadsheet->getActiveSheet()->getStyle($alpad . $baris . ':' .  $alph . $baris)->applyFromArray($alignmentcenter);
                $alpad++;
                $alpad++;
            }
            $baris++;

            foreach ($tgl as $key => $t) {
                $sheet->setCellValue($allp . $baris, 'Masuk');
                $allp++;
                $sheet->setCellValue($allp . $baris, 'Keluar');
                $allp++;
            }

            $spreadsheet->getActiveSheet()->mergeCells('C' . $brs . ':' . $alph . $brs);
            $spreadsheet->getActiveSheet()->getStyle('C' . $brs . ':' . $alph . $brs)->applyFromArray($alignmentcenter);

            $spreadsheet->getActiveSheet()->mergeCells('A' . $barislaporan . ':' . $alph . $barislaporan);
            $spreadsheet->getActiveSheet()->getStyle('A' . $barislaporan . ':' . $alph . $barislaporan)->applyFromArray($alignmentcenter);

            $sheet->getStyle('A' . $dtbrs . ':' . $alph . $dtbrs)->applyFromArray($styleborder);
            $garis = $dtbrs + 3;
            $sheet->getStyle('A' . $garis . ':' . $alph . $garis)->applyFromArray($styleborder);

            $baris++;

            foreach ($nama as $key => $n) {
                $alpac = 'C';
                $sheet->setCellValue('A' . $baris, $no2++);
                $sheet->setCellValue('B' . $baris, $n['nama']);

                foreach ($tgl as $key => $t) {

                    $masuk = $this->model_pegawai->excelmasuk($n['nama'], $t['tgl'], $store_id, 1);
                    $keluar = $this->model_pegawai->excelkeluar($n['nama'], $t['tgl'], $store_id, 1);
                    if ($masuk) {
                        if (file_exists(FCPATH . '/uploads/absensi/' .  $masuk['image'])) {
                            if (filesize(FCPATH . '/uploads/absensi/' .  $masuk['image']) > 1024) {
                                $spreadsheet->getActiveSheet()->getRowDimension($baris)->setRowHeight(40);
                                $spreadsheet->getActiveSheet()->getColumnDimension($alpac)->setWidth(10);
                                $sheeti = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                                $sheeti->setName('name');
                                $sheeti->setDescription('description');
                                $sheeti->setPath('uploads/absensi/' . $masuk['image']);
                                $sheeti->setHeight(50);
                                $sheeti->setCoordinates($alpac++ . $baris);
                                $sheeti->setOffsetX(2);
                                $sheeti->setOffsetY(2);
                                $sheeti->setWorksheet($sheet);
                            } else {
                                $sheet->setCellValue($alpac++ . $baris, 'Ukuran Eror');
                            }
                        } else {
                            $sheet->setCellValue($alpac++ . $baris, 'Camera Eror');
                        }
                    } else {
                        $sheet->setCellValue($alpac++ . $baris, '');
                    }
                    if ($keluar) {
                        if (file_exists(FCPATH . '/uploads/absensi/' .  $keluar['image'])) {
                            if (filesize(FCPATH . '/uploads/absensi/' .  $keluar['image']) > 1024) {
                                $spreadsheet->getActiveSheet()->getRowDimension($baris)->setRowHeight(40);
                                $spreadsheet->getActiveSheet()->getColumnDimension($alpac)->setWidth(10);
                                $sheeti = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                                $sheeti->setName('name');
                                $sheeti->setDescription('description');
                                $sheeti->setPath('uploads/absensi/' . $keluar['image']);
                                $sheeti->setHeight(50);
                                $sheeti->setCoordinates($alpac++ . $baris);
                                $sheeti->setOffsetX(2);
                                $sheeti->setOffsetY(2);
                                $sheeti->setWorksheet($sheet);
                            } else {
                                $sheet->setCellValue($alpac++ . $baris, 'Ukuran Eror');
                            }
                        } else {
                            $sheet->setCellValue($alpac++ . $baris, 'Camera Eror');
                        }
                    } else {
                        $sheet->setCellValue($alpac++ . $baris, '');
                    }
                }
                $baris++;
                $barisb++;
                $no++;
            }
            $grs = $baris - 1;
            $sheet->getStyle('A' . $grs . ':' . $alph . $grs)->applyFromArray($styleborder);
            $alpab++;
            $writer = new Xlsx($spreadsheet);
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Content-Type: application/vnd.ms-excel');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        } else {
            $this->session->set_flashdata('error', 'Data Tidak Ditemukan');
            redirect('Pegawai/absensi/', 'refresh');
        }
    }

    public function fetchabsensiData()
    {
        $result = array('data' => array());

        date_default_timezone_set("Asia/Jakarta");
        $store_id = $this->session->userdata('store_id');
        $div = $this->session->userdata('divisi');

        $filter = $this->input->post('filter');
        $var = $this->input->post('tgl');

        $tgl = str_replace('/', '-', $var);
        $hasil = explode(" - ", $tgl);
        $dari = date('Y-m-d', strtotime($hasil[0]));
        $sampai = date('Y-m-d', strtotime($hasil[1]));


        if ($div == 0) {
            if ($filter) {
                $absen_data = $this->model_pegawai->getabsenDatabyoutlet($filter, $dari, $sampai);
            } else {
                $absen_data = $this->model_pegawai->getabsenDatabyall($dari, $sampai);
            }
        } else {
            $absen_data = $this->model_pegawai->getabsenDatabystoreid($store_id, $dari, $sampai);
        }
        foreach ($absen_data as $key => $value) {
            $img = '<center><a href="../uploads/absensi/' . $value['image'] . '"><i class="fa fa-image"></i></a></center>';
            // button


            $buttons = ' <div class="btn-group dropleft">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span></button>
            <ul class="dropdown-menu">';

            if (in_array('updatePegawai', $this->permission)) {
                $buttons .= '<li><a href="' . base_url('Pegawai/absensiedit/' . $value['id']) . '"><i class="fa fa-pencil"></i> Masuk</a></li>';
            }

            if ($value['waktu_masuk'] == 1) {
                $masuk = '<center style="color: green;">' . $value['waktu'] . '</center>';
            } else {
                $masuk = '';
            }

            $kk = $this->model_pegawai->absenkeluar($store_id, $value['tgl'], $value['idpegawai']);
            if (isset($kk['waktu_keluar'])) {
                $keluar = '<center>' . $kk['waktu'] . '</center>';
            } else {
                $keluar = '<center><i class="fa fa-close" style="color: red;"></i></center>';
            };


            $kk1 = $this->model_pegawai->absenkeluarkeof($value['tgl'], $value['idpegawai']);
            if (isset($kk1['waktu_keluar'])) {
                $keluar1 = '<center>' . $kk1['waktu'] . '</center>';
            } else {
                $keluar1 = '<center><i class="fa fa-close" style="color: red;"></i></center>';
            };
            if (isset($kk1['image'])) {
                $img1 = '<center><a href="../uploads/absensi/' . $kk1['image'] . '"><i class="fa fa-image"></i></a></center>';
            } else {
                $img1 = '<center>-</center>';
            };

            if (isset($kk1['id'])) {
                if (in_array('updatePegawai', $this->permission)) {
                    $buttons .= '<li><a href="' . base_url('Pegawai/absensiedit/' . $kk1['id']) . '"><i class="fa fa-pencil"></i> Keluar</a></li>';
                }
            }
            if (in_array('deletePegawai', $this->permission)) {
                $buttons .= '<li><a style="cursor:pointer;" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i> Hapus</a></li>';
            }

            $buttons .= '</ul></div>';


            if ($value['sift'] < 3) {
                $shf = $value['sift'];
            } else if ($value['sift'] == 3) {
                $shf = 'Lembur';
            } else if ($value['sift'] == 4) {
                $shf = '1';
            } else if ($value['sift'] == 5) {
                $shf = '2';
            }
            if ($div == 0) {
                if ($value['waktu_masuk'] == 1) {
                    $result['data'][] = array(
                        $buttons,
                        $value['tgl'],
                        $value['store'],
                        $value['nama'],
                        $shf,
                        $img,
                        $img1,
                        $masuk,
                        $keluar1
                    );
                }
            } else {
                if ($value['waktu_masuk'] == 1) {
                    $result['data'][] = array(
                        $value['tgl'],
                        $value['nama'],
                        $shf,
                        $masuk,
                        $keluar,
                    );
                }
            }
        } // /foreach

        echo json_encode($result);
    }

    public function jamoutlet()
    {

        $id = $this->input->post('id');

        $stores = $this->model_stores->getStoresData($id);

        $s1 = json_decode($stores['s1'], TRUE);
        if ($stores['s1']) {
            $s1m = $s1[0];
            $s1k = $s1[1];
        } else {
            $s1m = '';
            $s1k = '';
        }
        $s2 = json_decode($stores['s2'], TRUE);
        if ($stores['s2']) {
            $s2m = $s2[0];
            $s2k = $s2[1];
        } else {
            $s2m = '';
            $s2k = '';
        }

        $lembur = json_decode($stores['lembur'], TRUE);
        if ($stores['lembur']) {
            $lemburm = $lembur[0];
            $lemburk = $lembur[1];
        } else {
            $lemburm = '';
            $lemburk = '';
        }

        $ks1 = json_decode($stores['khusus_s1'], TRUE);
        if ($stores['khusus_s1']) {
            $ks1m = $ks1[0];
            $ks1k = $ks1[1];
        } else {
            $ks1m = '';
            $ks1k = '';
        }
        $ks2 = json_decode($stores['khusus_s2'], TRUE);
        if ($stores['khusus_s2']) {
            $ks2m = $ks2[0];
            $ks2k = $ks2[1];
        } else {
            $ks2m = '';
            $ks2k = '';
        }

        $ak = json_decode($stores['akustik'], TRUE);
        if ($stores['akustik']) {
            $akustikm = $ak[0];
            $akustikk = $ak[1];
        } else {
            $akustikm = '';
            $akustikk = '';
        }
        if ($stores) {
            echo '
        

                <div class="form-group">
                 <label class="col-sm-5 control-label" style="text-align:left;">Sift 1</label>
                </div>

                <div class="form-group">
            <label class="col-sm-5 control-label" style="text-align:left;">Jam Awal :</label>
            <div class="col-sm-7">

            <div class="input-group date">
            <div class="input-group-addon ">
              <i class="fa fa-clock-o "></i>
            </div>
            <input type="time" value="' . $s1m . '" required name="time_awal1" class="form-control pull-right">
          </div>

                 </div>
                </div>

            <div class="form-group">
            <label class="col-sm-5 control-label" style="text-align:left;">Jam Akhir :</label>
            <div class="col-sm-7">

            <div class="input-group date">
                <div class="input-group-addon ">
                <i class="fa fa-clock-o "></i>
                </div>
                <input value="' . $s1k . '" type="time" name="time_akhir1" required class="form-control pull-right">
            </div>

            </div>
                    </div>


                <div class="form-group">
                    <label class="col-sm-5 control-label" style="text-align:left;">Sift 2</label>
                </div>

                <div class="form-group">
                    <label class="col-sm-5 control-label" style="text-align:left;">Jam Awal :</label>
                    <div class="col-sm-7">

                    <div class="input-group date">
                        <div class="input-group-addon ">
                        <i class="fa fa-clock-o "></i>
                        </div>
                        <input type="time" value="' . $s2m . '"  name="time_awal2" class="form-control pull-right">
                    </div>

                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-5 control-label" style="text-align:left;">Jam Akhir :</label>
                    <div class="col-sm-7">

                    <div class="input-group date">
                        <div class="input-group-addon ">
                        <i class="fa fa-clock-o "></i>
                        </div>
                        <input value="' . $s2k . '" type="time" name="time_akhir2"  class="form-control pull-right">
                    </div>

                    </div>
                </div>
                
                
                

                <div class="form-group">
                    <label class="col-sm-5 control-label" style="text-align:left;">Lembur</label>
                </div>

                
                <div class="form-group">
                    <label class="col-sm-5 control-label" style="text-align:left;">Jam Awal :</label>
                    <div class="col-sm-7">

                    <div class="input-group date">
                        <div class="input-group-addon ">
                        <i class="fa fa-clock-o "></i>
                        </div>
                        <input type="time" value="' . $lemburm . '"  name="time_awal3" class="form-control pull-right">
                    </div>

                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-5 control-label" style="text-align:left;">Jam Akhir :</label>
                    <div class="col-sm-7">

                    <div class="input-group date">
                        <div class="input-group-addon ">
                        <i class="fa fa-clock-o "></i>
                        </div>
                        <input value="' . $lemburk . '" type="time" name="time_akhir3"  class="form-control pull-right">
                    </div>

                    </div>
                </div>


                
                <div class="form-group">
                    <label class="col-sm-5 control-label" style="text-align:left;">Khusus Shift 1</label>
                </div>

                
                <div class="form-group">
                    <label class="col-sm-5 control-label" style="text-align:left;">Jam Awal :</label>
                    <div class="col-sm-7">

                    <div class="input-group date">
                        <div class="input-group-addon ">
                        <i class="fa fa-clock-o "></i>
                        </div>
                        <input type="time" value="' . $ks1m . '"  name="time_awal4" class="form-control pull-right">
                    </div>

                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-5 control-label" style="text-align:left;">Jam Akhir :</label>
                    <div class="col-sm-7">

                    <div class="input-group date">
                        <div class="input-group-addon ">
                        <i class="fa fa-clock-o "></i>
                        </div>
                        <input value="' . $ks1k . '" type="time" name="time_akhir4"  class="form-control pull-right">
                    </div>

                    </div>
                </div>


                
                <div class="form-group">
                    <label class="col-sm-5 control-label" style="text-align:left;">Khusus Shift 2</label>
                </div>

                
                <div class="form-group">
                    <label class="col-sm-5 control-label" style="text-align:left;">Jam Awal :</label>
                    <div class="col-sm-7">

                    <div class="input-group date">
                        <div class="input-group-addon ">
                        <i class="fa fa-clock-o "></i>
                        </div>
                        <input type="time" value="' . $ks2m . '"  name="time_awal5" class="form-control pull-right">
                    </div>

                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-5 control-label" style="text-align:left;">Jam Akhir :</label>
                    <div class="col-sm-7">

                    <div class="input-group date">
                        <div class="input-group-addon ">
                        <i class="fa fa-clock-o "></i>
                        </div>
                        <input value="' . $ks2k . '" type="time" name="time_akhir5"  class="form-control pull-right">
                    </div>

                    </div>
                </div>

                
                
                <div class="form-group">
                    <label class="col-sm-5 control-label" style="text-align:left;">Akustik</label>
                </div>

                
                <div class="form-group">
                    <label class="col-sm-5 control-label" style="text-align:left;">Jam Awal :</label>
                    <div class="col-sm-7">

                    <div class="input-group date">
                        <div class="input-group-addon ">
                        <i class="fa fa-clock-o "></i>
                        </div>
                        <input type="time" value="' . $akustikm . '"  name="time_awal6" class="form-control pull-right">
                    </div>

                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-5 control-label" style="text-align:left;">Jam Akhir :</label>
                    <div class="col-sm-7">

                    <div class="input-group date">
                        <div class="input-group-addon ">
                        <i class="fa fa-clock-o "></i>
                        </div>
                        <input value="' . $akustikk . '" type="time" name="time_akhir6"  class="form-control pull-right">
                    </div>

                    </div>
                </div>
                ';
        } else {
            echo '';
        }
    }


    public function jamoutletinput()
    {
        $id = $this->input->post('outlet');
        $time_awal1 = $this->input->post('time_awal1');
        $time_akhir1 = $this->input->post('time_akhir1');

        $time_awal2 = $this->input->post('time_awal2');
        $time_akhir2 = $this->input->post('time_akhir2');

        $time_awal3 = $this->input->post('time_awal3');
        $time_akhir3 = $this->input->post('time_akhir3');

        $time_awal4 = $this->input->post('time_awal4');
        $time_akhir4 = $this->input->post('time_akhir4');

        $time_awal5 = $this->input->post('time_awal5');
        $time_akhir5 = $this->input->post('time_akhir5');

        $time_awal6 = $this->input->post('time_awal6');
        $time_akhir6 = $this->input->post('time_akhir6');

        if ($id) {
            if ($time_awal1) {
                $ta1m = $time_awal1;
            } else {
                $ta1m = '';
            }

            if ($time_akhir1) {
                $ta1k = $time_akhir1;
            } else {
                $ta1k = '';
            }

            if ($time_awal2) {
                $ta2m = $time_awal2;
            } else {
                $ta2m = '';
            }

            if ($time_akhir2) {
                $ta2k = $time_akhir2;
            } else {
                $ta2k = '';
            }


            if ($time_awal3) {
                $ta3m = $time_awal3;
            } else {
                $ta3m = '';
            }

            if ($time_akhir3) {
                $ta3k = $time_akhir3;
            } else {
                $ta3k = '';
            }


            if ($time_awal4) {
                $ta4m = $time_awal4;
            } else {
                $ta4m = '';
            }

            if ($time_akhir4) {
                $ta4k = $time_akhir4;
            } else {
                $ta4k = '';
            }

            if ($time_awal5) {
                $ta5m = $time_awal5;
            } else {
                $ta5m = '';
            }

            if ($time_akhir5) {
                $ta5k = $time_akhir5;
            } else {
                $ta5k = '';
            }


            if ($time_awal6) {
                $ta6m = $time_awal6;
            } else {
                $ta6m = '';
            }
            if ($time_akhir6) {
                $ta6k = $time_akhir6;
            } else {
                $ta6k = '';
            }

            $dts1 = array($ta1m, $ta1k);
            $dts2 = array($ta2m, $ta2k);
            $dts3 = array($ta3m, $ta3k);
            $dts4 = array($ta4m, $ta4k);
            $dts5 = array($ta5m, $ta5k);
            $dts6 = array($ta6m, $ta6k);

            $s1 = json_encode($dts1);
            $s2 = json_encode($dts2);
            $lembur = json_encode($dts3);
            $khususs1 = json_encode($dts4);
            $khususs2 = json_encode($dts5);
            $akustik = json_encode($dts6);

            $data = array(
                's1' => "$s1",
                's2' => "$s2",
                'lembur' => "$lembur",
                'khusus_s1' => "$khususs1",
                'khusus_s2' => "$khususs2",
                'akustik' => "$akustik"

            );


            $update = $this->model_stores->update($data, $id);

            if ($update == true) {
                $this->session->set_flashdata('success', 'Jam Telah diatur');
                redirect('pegawai/absensi', 'refresh');
            } else {
                $this->session->set_flashdata('error', 'Terjadi Kesalahan Update!!');
                redirect('pegawai/absensi', 'refresh');
            }
        }
    }
    public function ambilnamaid()
    {
        $id = $this->input->post('id');
        $pegawai = $this->model_pegawai->getpegawaiid($id);
        if (isset($pegawai['nama'])) {
            echo $pegawai['nama'];
        } else {
            echo 'gagal';
        }
    }

    public function test()
    {
        $time = date('H:i:s', strtotime('10:09:00') - 60 * 60);

        echo $time; //11:09
    }
}
