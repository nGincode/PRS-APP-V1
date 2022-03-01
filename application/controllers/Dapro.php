<?php

defined('BASEPATH') or exit('No direct script access allowed');

require('./assets/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


require('./assets/fpdf/fpdf.php');

class Dapro extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Dapur Produksi';


        $this->load->model('model_users');
        $this->load->model('model_groups');
        $this->load->model('model_stores');
        $this->load->model('model_dapro');
        $this->load->model('model_products');
    }


    public function bahanmatah()
    {
        $this->data['namastore'] = $_SESSION['store'];
        $this->render_template('dapro/bahanmatah', $this->data);
    }


    public function fatchbahanmatah()
    {

        $result = array('data' => array());
        $var = $this->input->post('tgl');

        if ($var) {

            $tgl = str_replace('/', '-', $var);
            $hasil = explode(" - ", $tgl);
            $dari = date('Y-m-d', strtotime("-1 day", strtotime($hasil[0])));
            $sampai = date('Y-m-d', strtotime("+1 day", strtotime($hasil[1])));

            $data = $this->model_dapro->getdapro_bahanbaku($dari, $sampai);
            foreach ($data as $key => $value) {

                $result['data'][$key] = array(
                    // $buttons,
                    $value['tgl'],
                    $value['nama_produk'],
                    $value['qty'],
                    $value['harga'],
                    $value['satuan']
                );
            }
        } else {
            $result['data'] = array();
        }
        echo json_encode($result);
    }


    public function fatchorderitem()
    {

        $result = array('data' => array());
        $var = $this->input->post('tgl');

        $store_id = $this->session->userdata('store_id');

        if ($var) {

            $tgl = str_replace('/', '-', $var);
            $hasil = explode(" - ", $tgl);
            $dari = date('Y-m-d', strtotime("-1 day", strtotime($hasil[0])));
            $sampai = date('Y-m-d', strtotime("+1 day", strtotime($hasil[1])));

            $data = $this->model_dapro->getorders_item($dari, $sampai, $store_id);
            foreach ($data as $key => $value) {

                if ($value['dapro']) {
                    $status = '<a class="btn btn-success">Terupload</a>';
                } else {
                    $status = '<a class="btn btn-warning">Belum Terupload</a>';
                }

                if ($value['tipe']) {
                    $tipe = 'Bahan Baku';
                } else {
                    $tipe = 'Reguler';
                }

                // button
                if (!$value['dapro']) {
                    $buttons = ' <div class="btn-group dropleft">
			    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span></button>
				<ul class="dropdown-menu">';
                    $buttons .= '<li><a href="#" onclick="upload_orderdapro(' . $value['id'] . ')" ><i class="fa fa-upload"></i> Upload</a></li>';
                    $buttons .= '</ul></div>';
                } else {
                    $buttons = 'Terupload';
                }

                if ($value['qtyarv']) {
                    $result['data'][$key] = array(
                        $buttons,
                        $value['tgl_laporan'],
                        $value['nama_produk'],
                        $value['qty'],
                        $value['rate'] . '/' . $value['satuan'],
                        $tipe,
                        $status
                    );
                }
            }
        } else {
            $result['data'] = array();
        }
        echo json_encode($result);
    }


    public function fatchorderstock()
    {

        $result = array('data' => array());

        $productid = $this->model_dapro->getproduct_id();

        if ($productid) {
            foreach ($productid as $key => $value) {

                $data = $this->model_dapro->getdaproid($value['product_id']);

                if ($productid) {
                    $qty = 0;
                    $satuan = $data[0]['satuan'];
                    $harga = $data[0]['harga'];
                    $tipe = $data[0]['tipe'];
                    foreach ($data as $val) {
                        $qty += $val['qty'];
                    }

                    if ($tipe) {
                        $t = 'Bahan Baku';
                    } else {
                        $t = 'Reguler';
                    }

                    $total = $harga * $qty;

                    $result['data'][$key] = array(
                        $value['nama_produk'],
                        $t,
                        $qty,
                        $harga . '/' . $satuan,
                        $total
                    );
                } else {
                    $result['data'] = array();
                }
            }
        } else {
            $result['data'] = array();
        }
        echo json_encode($result);
    }

    public function inputbrngjdi()
    {
        $jml = $this->input->post('jml');
        $id = $this->input->post('id');
        $max = $this->input->post('max');
        $harga = $this->input->post('harganya');
        $nama = $this->input->post('nama');
        $idproduct = $this->input->post('idproduct');

        if ($jml <= $max && $id && $jml && $harga && $nama && $idproduct) {


            $data = $this->model_dapro->getitemresep($id);

            if ($data) {
                foreach ($data as $key1 => $val) {
                    //qty stock
                    $qty = $val['qty'];
                    $idp = $val['idproduct'];

                    $product = $this->model_products->getProductData($idp);
                    $nama = $product['name'];
                    $harga = $product['price'];
                    $tipe = $product['tipe'];
                    $satuan = $product['satuan'];

                    $hsl = $qty * $jml;
                    $input = array(
                        'tgl' => date('Y-m-d'),
                        'nama_produk' => $nama,
                        'product_id' => $idp,
                        'qty' => -$hsl,
                        'harga' => $harga,
                        'tipe' => $tipe,
                        'satuan' => $satuan
                    );
                    $data = $this->model_dapro->upbahanmetah($input);
                }
            }

            $productsat = $this->model_products->getProductData($idproduct);
            $data = array(
                'tgl' => date('Y-m-d'),
                'nama' => $productsat['name'],
                'idproduct' => $idproduct,
                'qty' => $jml,
                'satuan' => $productsat['satuan'],
                'harga' => $harga
            );

            $this->model_dapro->insertbahanjadi($data);

            echo 1;
        }
    }

    public function fatchbrngjdi()
    {

        $result = array('data' => array());
        $var = $this->input->post('tgl');


        if ($var) {

            $tgl = str_replace('/', '-', $var);
            $hasil = explode(" - ", $tgl);
            $dari = date('Y-m-d', strtotime("-1 day", strtotime($hasil[0])));
            $sampai = date('Y-m-d', strtotime("+1 day", strtotime($hasil[1])));

            $data = $this->model_dapro->getdapro_bahanjadi($dari, $sampai);
            foreach ($data as $key => $value) {

                $total = $value['qty'] * $value['harga'];

                $result['data'][$key] = array(
                    $value['tgl'],
                    $value['nama'],
                    $value['qty'],
                    $value['harga'],
                    $total
                );
            }
        } else {
            $result['data'] = array();
        }
        echo json_encode($result);
    }
    public function fatchresep()
    {

        $result = array('data' => array());

        $productid = $this->model_dapro->getresepstore();

        if ($productid) {
            foreach ($productid as $key => $value) {
                $data = $this->model_dapro->getitemresep($value['id']);

                if ($data) {
                    $hasil = array();
                    $harga = 0;
                    foreach ($data as $key1 => $val) {
                        //qty stock
                        $id = $this->model_dapro->getdaproid($val['idproduct']);
                        if ($id) {
                            $qty = 0;
                            foreach ($id as $key2 => $v) {
                                $qty += $v['qty'];
                                $harga += $v['harga'] * $v['qty'];
                            }
                            //qty resep
                            $qtyrsp = $val['qty'];
                            $qty;
                            $hasil[] = floor($qty / $qtyrsp);
                        } else {
                            $hasil[] = 0;
                        }
                    }
                    $hitung =  min($hasil);
                }

                $total = $hitung * $harga;
                $input = '
                <input type="hidden" value="' . $value['idproduct'] . '" name="idproduct" id="idproduct">
                <input type="hidden" value="' . $value['id'] . '" name="id" id="indent">
                <input type="hidden" value="' . $hitung . '" name="max" id="keleb">
                <input type="hidden" value="' . $value['nama_menu'] . '" name="nmmnu" id="nmmnu">
                <input type="hidden" value="' . $harga . '" name="harganya" id="harganya">
                <input class="form-control" name="jml" type="number" max="' . $hitung . '" id="jml"><button onclick="kirimbrngjdi()" class="btn btn-success">Kirim</button>
                ';
                if ($hitung > 0) {
                    $result['data'][$key] = array(
                        $value['nama_menu'],
                        $hitung,
                        $input,
                        $harga,
                        $total
                    );
                }
            }
        } else {
            $result['data'] = array();
        }
        echo json_encode($result);
    }


    public function status_up()
    {

        $id = $this->input->post('id');
        if (!$id) {
            echo 1;
        } else {
            $row = $this->model_dapro->status_up($id);

            $data = array(
                'qty' => $row['qtyarv'],
                'product_id' => $row['product_id'],
                'nama_produk' => $row['nama_produk'],
                'harga' => $row['rate'],
                'satuan' => $row['satuan'],
                'tgl' => $row['tgl_laporan'],
                'tipe' => $row['tipe']
            );


            $data2 = array(
                'dapro' => 1
            );

            $data = $this->model_dapro->upbahanmetah($data);
            if ($data == true) {
                $up = $this->model_dapro->uporder($data2, $id);
                if ($up == true) {
                    echo 6;
                } else {
                    echo 1;
                }
            } else {
                echo 1;
            }
        }
    }


    public function hasil()
    {
        $this->data['namastore'] = $_SESSION['store'];
        $this->render_template('dapro/hasil', $this->data);
    }

    public function laporan()
    {
        $this->render_template('dapro/laporan', $this->data);
    }

    public function laporandata()
    {
        $id = $this->input->post('id');



        $data = $this->model_dapro->fetchbahanjaditgl($id, 0);
        $data1 = $this->model_dapro->fetchbahanbakutgl($id, 0);
        $data3 = $this->model_dapro->fetchbahanjaditgl1($id, 0);


        echo '<br><br><h2><b>Laporan Barang Jadi</b></h2>
        <table class="table table-bordered" id="product_info_table" >
          <tr>
            <th style="text-align: center;">Tanggal</th>
            <th style="text-align: center;">Nama</th>
            <th style="text-align: center;">Qty</th>
            <th style="text-align: center;">Harga</th>
            <th style="text-align: center;">Total</th>
          </tr>
          </thead>
          <tbody>';

        if ($data) {

            foreach ($data as $v) {

                $ak = $this->model_dapro->fetchbahanjaditglak($v['idproduct'], $id, 0);

                $qty = 0;
                foreach ($ak as $vl) {
                    $qty += $vl['qty'];
                }

                $total = $ak[0]['harga'] * $qty;

                echo '
                    <tr>
                    <td>' . $ak[0]['tgl'] . '</td>
                    <td>' . $ak[0]['nama'] . '</td>
                    <td>' . $qty . '</td>
                    <td>' . $ak[0]['harga'] . '/' . $ak[0]['satuan'] . '</td>
                    <td>' . $total . '</td>
                    </tr>';
            }
        } else {
            echo '<tr><td colspan="5" alignt="center"><center><h4><b>Tidak ditemukan</b></h4></center></td></tr>';
        }
        echo '
        
          </tbody>
        </table>';




        echo '<br><br><h2><b>Laporan Barang Baku</b></h2>
        <table class="table table-bordered" id="product_info_table" >
          <tr>
            <th style="text-align: center;">Tanggal</th>
            <th style="text-align: center;">Nama</th>
            <th style="text-align: center;">Qty</th>
            <th style="text-align: center;">Harga</th>
            <th style="text-align: center;">Total</th>
          </tr>
          </thead>
          <tbody>';

        if ($data1) {

            foreach ($data1 as $v1) {

                $ak1 = $this->model_dapro->fetchbahanbakutglak($v1['product_id'], $id, 0);

                $qty1 = 0;
                foreach ($ak1 as $vl1) {
                    $qty1 += $vl1['qty'];
                }

                $total1 = $ak1[0]['harga'] * $qty1;

                echo '
                    <tr>
                    <td>' . $ak1[0]['tgl'] . '</td>
                    <td>' . $ak1[0]['nama_produk'] . '</td>
                    <td>' . abs($qty1) . '</td>
                    <td>' . $ak1[0]['harga'] . '/' . $ak[0]['satuan'] . '</td>
                    <td>' . abs($total1) . '</td>
                    </tr>';
            }
        } else {
            echo '<tr><td colspan="5" alignt="center"><center><h4><b>Tidak ditemukan</b></h4></center></td></tr>';
        }
        echo '
        
          </tbody>
        </table>';



        echo '<br><br><h2><b>Laporan Barang Jadi Ke logistik</b></h2>
        <table class="table table-bordered" id="product_info_table" >
          <tr>
            <th style="text-align: center;">Tanggal</th>
            <th style="text-align: center;">Nama</th>
            <th style="text-align: center;">Qty</th>
            <th style="text-align: center;">Harga</th>
            <th style="text-align: center;">Total</th>
          </tr>
          </thead> 
          <tbody>';

        if ($data3) {

            foreach ($data3 as $v3) {

                $ak3 = $this->model_dapro->fetchbahanjaditglak1($v3['idproduct'], $id, 0);

                $qty3 = 0;
                foreach ($ak3 as $vl3) {
                    $qty3 += $vl3['qty'];
                }

                $total3 = $ak3[0]['harga'] * $qty3;

                echo '
                    <tr>
                    <td>' . $ak3[0]['tgl'] . '</td>
                    <td>' . $ak3[0]['nama'] . '</td>
                    <td>' . $qty3 . '</td>
                    <td>' . $ak3[0]['harga'] . '/' . $ak[0]['satuan'] . '</td>
                    <td>' . $total3 . '</td>
                    </tr>';
            }
        } else {
            echo '<tr><td colspan="5" alignt="center"><center><h4><b>Tidak ditemukan</b></h4></center></td></tr>';
        }
        echo '
        
          </tbody>
        </table>';
    }




    public function excel()
    {

        $tglawal = $this->input->post('tglawal');
        $tglakhir = $this->input->post('tglakhir');


        $data = $this->model_dapro->fetchbahanjaditgl($tglawal, $tglakhir);
        $data1 = $this->model_dapro->fetchbahanbakutgl($tglawal, $tglakhir);
        $data3 = $this->model_dapro->fetchbahanjaditgl1($tglawal, $tglakhir);



        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getProperties()
            ->setCreator("Fembi Nur Ilham")
            ->setLastModifiedBy("Fembi Nur Ilham")
            ->setTitle("Stock Logistik")
            ->setSubject("Hasil Export Dari PRS System")
            ->setDescription("Semoga Terbantu Dengan Adanya Ini")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Stock Logistik");


        $filename = "Laporan Dapur Produksi " . $tglawal . " Sampai " . $tglakhir . ".xlsx";

        $sheet->setCellValue('A1', 'Laporan Dapur Produksi');
        $sheet->setCellValue('A2', "Tanggal " . $tglawal . " Sampai " . $tglakhir);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);

        $sheet->setCellValue('A4', 'Laporan Barang Jadi');
        $sheet->setCellValue('A5', 'No');
        $sheet->setCellValue('B5', 'Nama Produk');
        $sheet->setCellValue('C5', 'Qty');
        $sheet->setCellValue('D5', 'Satuan');
        $sheet->setCellValue('E5', 'Harga');
        $sheet->setCellValue('F5', 'Total');

        $baris = 6;
        $no = 1;
        $no1 = 1;
        $no3 = 1;
        $count = 6;
        $hrgjml = 0;
        $hrgjml1 = 0;
        $hrgjml3 = 0;
        if ($data or $data1 or $data3) {
            if ($data) {
                foreach ($data as $v) {
                    $ak = $this->model_dapro->fetchbahanjaditglak($v['idproduct'], $tglawal, $tglakhir);

                    $qty = 0;
                    foreach ($ak as $vl) {
                        $qty += $vl['qty'];
                    }

                    $total = $ak[0]['harga'] * $qty;

                    $sheet->setCellValue('A' . $baris,  $no++);
                    $sheet->setCellValue('B' . $baris, $ak[0]['nama']);
                    $sheet->setCellValue('C' . $baris, $qty);
                    $sheet->setCellValue('D' . $baris,  $ak[0]['satuan']);
                    $sheet->setCellValue('E' . $baris,  $ak[0]['harga']);
                    $sheet->setCellValue('F' . $baris, $total);

                    $baris++;
                    $count++;
                    $hrgjml += $total;
                }
                $jmlh = $count;
                $spreadsheet->getActiveSheet()->mergeCells('A' . $jmlh . ':E' . $jmlh);
                $sheet->setCellValue('A' . $jmlh, 'Jumlah');
                $sheet->setCellValue('F' . $jmlh, $hrgjml);
            } else {
                $spreadsheet->getActiveSheet()->mergeCells('A' . $baris . ':E' . $baris);
                $sheet->setCellValue('A' . $baris,  'Tidak ditemukan');
                $baris++;
            }


            $jmlh++;
            $jmlh++;
            $sheet->setCellValue('A' . $jmlh, 'Laporan Barang Baku');
            $jmlh++;
            $sheet->setCellValue('A' . $jmlh, 'No');
            $sheet->setCellValue('B' . $jmlh, 'Nama Produk');
            $sheet->setCellValue('C' . $jmlh, 'Qty');
            $sheet->setCellValue('D' . $jmlh, 'Satuan');
            $sheet->setCellValue('E' . $jmlh, 'Harga');
            $sheet->setCellValue('F' . $jmlh, 'Total');
            $jmlh++;
            if ($data1) {
                foreach ($data1 as $v1) {
                    $ak1 = $this->model_dapro->fetchbahanbakutglak($v1['product_id'], $tglawal, $tglakhir);

                    $qty1 = 0;
                    foreach ($ak1 as $vl1) {
                        $qty1 += $vl1['qty'];
                    }

                    $total1 = $ak1[0]['harga'] * $qty1;

                    $sheet->setCellValue('A' . $jmlh,  $no1++);
                    $sheet->setCellValue('B' . $jmlh, $ak1[0]['nama_produk']);
                    $sheet->setCellValue('C' . $jmlh, abs($qty1));
                    $sheet->setCellValue('D' . $jmlh,  $ak1[0]['satuan']);
                    $sheet->setCellValue('E' . $jmlh,  $ak1[0]['harga']);
                    $sheet->setCellValue('F' . $jmlh, abs($total1));

                    $jmlh++;
                    $count++;
                    $hrgjml1 += $total1;
                }
                $spreadsheet->getActiveSheet()->mergeCells('A' . $jmlh . ':E' . $jmlh);
                $sheet->setCellValue('A' . $jmlh, 'Jumlah');
                $sheet->setCellValue('F' . $jmlh, abs($hrgjml1));
            } else {
                $spreadsheet->getActiveSheet()->mergeCells('A' . $jmlh . ':E' . $jmlh);
                $sheet->setCellValue('A' . $jmlh,  'Tidak ditemukan');
                $jmlh++;
            }




            $jmlh++;
            $jmlh++;
            $sheet->setCellValue('A' . $jmlh, 'Laporan Barang Jadi Ke logistik');
            $jmlh++;
            $sheet->setCellValue('A' . $jmlh, 'No');
            $sheet->setCellValue('B' . $jmlh, 'Nama Produk');
            $sheet->setCellValue('C' . $jmlh, 'Qty');
            $sheet->setCellValue('D' . $jmlh, 'Satuan');
            $sheet->setCellValue('E' . $jmlh, 'Harga');
            $sheet->setCellValue('F' . $jmlh, 'Total');
            $jmlh++;
            if ($data3) {
                foreach ($data3 as $v3) {

                    $ak3 = $this->model_dapro->fetchbahanjaditglak1($v3['idproduct'], $tglawal, $tglakhir);

                    $qty3 = 0;
                    foreach ($ak3 as $vl3) {
                        $qty3 += $vl3['qty'];
                    }

                    $total3 = $ak3[0]['harga'] * $qty3;

                    $sheet->setCellValue('A' . $jmlh,  $no3++);
                    $sheet->setCellValue('B' . $jmlh, $ak3[0]['nama']);
                    $sheet->setCellValue('C' . $jmlh, abs($qty3));
                    $sheet->setCellValue('D' . $jmlh,  $ak3[0]['satuan']);
                    $sheet->setCellValue('E' . $jmlh,  $ak3[0]['harga']);
                    $sheet->setCellValue('F' . $jmlh, abs($total3));

                    $jmlh++;
                    $count++;
                    $hrgjml3 += $total3;
                }
                $spreadsheet->getActiveSheet()->mergeCells('A' . $jmlh . ':E' . $jmlh);
                $sheet->setCellValue('A' . $jmlh, 'Jumlah');
                $sheet->setCellValue('F' . $jmlh, abs($hrgjml3));
            } else {
                $spreadsheet->getActiveSheet()->mergeCells('A' . $jmlh . ':E' . $jmlh);
                $sheet->setCellValue('A' . $jmlh,  'Tidak ditemukan');
                $jmlh++;
            }


            $writer = new Xlsx($spreadsheet);
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Content-Type: application/vnd.ms-excel');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        } else {
            $this->session->set_flashdata('error', 'Data Tidak Ditemukan');
            redirect('dapro/', 'refresh');
        }
    }
}
