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

            $data = array(
                'tgl' => date('Y-m-d'),
                'nama' => $nama,
                'idproduct' => $id,
                'qty' => $jml,
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
}
