<?php

defined('BASEPATH') or exit('No direct script access allowed');

require('./assets/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


require('./assets/fpdf/fpdf.php');

class Omzet extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Omzet';


        $this->load->model('model_users');
        $this->load->model('model_groups');
        $this->load->model('model_stores');
        $this->load->model('model_omzet');
    }


    public function index()
    {

        $store_id = $this->session->userdata('store_id');
        $omzet_data = $this->model_omzet->getomzetid($store_id);

        $this->data['omzet_data'] = $omzet_data;

        $this->render_template('omzet/index', $this->data);
    }





    public function create()
    {

        $this->form_validation->set_rules('tgl', 'Tanggal', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            // true case

            $user_id = $this->session->userdata('id');
            $store_id = $this->session->userdata('store_id');
            $omzet_data = $this->model_omzet->getomzetid($store_id);

            $tgl = $this->input->post('tgl');
            $dttgl = $this->model_omzet->cektgl($tgl);

            $gop = $this->input->post('pemasukan') - $this->input->post('pengeluaran');


            if ($dttgl < 1) {
                $data = array(
                    'tgl' => $tgl,
                    'pengeluaran' => $this->input->post('pengeluaran'),
                    'pettycash' => $this->input->post('pettycash'),
                    'pemasukkan' => $this->input->post('pemasukan'),
                    'gop' => $gop,
                    'user_id' => $user_id,
                    'store_id' => $store_id,
                    'store' => $this->input->post('store'),

                );

                $create = $this->model_omzet->create($data);
                if ($create == true) {
                    $this->session->set_flashdata('success', 'Data Telah di Tambahkan');
                    redirect('Omzet/create', 'refresh');
                } else {
                    $this->session->set_flashdata('error', 'Maaf Terjadi Kegagalan!!');
                    redirect('Omzet/create', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error', 'Maaf Tanggal Anda Telah diinput Sebelumnya !!');
                redirect('Omzet/create', 'refresh');
            }
        } else {
            $this->render_template('omzet/create', $this->data);
        }
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



    public function remove()
    {
        $id = $this->input->post('id');
        $delete = $this->model_omzet->delete($id);
    }
}
