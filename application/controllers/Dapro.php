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
}
