<?php

defined('BASEPATH') or exit('No direct script access allowed');


require('./assets/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Html;

class penjualan extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Penjualan';

        $this->load->model('model_products');
        $this->load->model('model_users');
        $this->load->model('model_penjualan');
        $this->load->model('Model');
        $this->load->model('model_stores');
    }


    public function item()
    {
        if (!in_array('createpenjualan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('nama', 'Nama', 'trim|required|is_unique[penjualan_item_resep.nama]');
        $this->form_validation->set_rules('satuan', 'Satuan', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            // true case


            $data = array(
                'nama' => $this->input->post('nama'),
                'satuan' => $this->input->post('satuan'),
                'harga' => $this->input->post('harga'),
            );

            $create = $this->model_penjualan->create($data);
            if ($create == true) {
                $this->session->set_flashdata('success', 'Data Ditambahkan');
                redirect('penjualan/item', 'refresh');
            } else {
                $this->session->set_flashdata('error', 'Terjadi Kesalahan Penambahan!!');
                redirect('penjualan/item', 'refresh');
            }
        } else {
            // false case       

            $this->data['dataitem'] = $this->model_penjualan->getitemresep();
            $this->render_template('penjualan/item', $this->data);
        }
    }



    public function duplicate()
    {
        if (!in_array('createpenjualan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $id = $this->input->get('id');

        $dt = $this->model_penjualan->getresep($id);
        $dt1 = $this->model_penjualan->getresepitemid($id);


        $data = array(
            'nama_menu' => $dt['nama_menu'] . '_duplicate',
            'store_id' => $dt['store_id'] . '_duplicate',
        );

        $create = $this->model_penjualan->createresep($data);

        $idresep = $this->model_penjualan->idresep();
        $data1 = array();
        foreach ($dt1 as $v) {
            array_push($data1, array(
                'idpenjualanresep' => $idresep['id'],
                'iditemresep' => $v['iditemresep'],
                'idproduct' => $v['idproduct'],
                'qty' => $v['qty'],
                'idproduct' => $v['idproduct'],
            ));
        }




        $create = $this->model_penjualan->createitem($data1);


        if ($create == true) {
            $this->session->set_flashdata('success', 'Data Ditambahkan');
            redirect('penjualan/resep', 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Terjadi Kesalahan Penambahan!!');
            redirect('penjualan/resep', 'refresh');
        }
    }


    public function edititem()
    {

        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('satuan', 'Satuan', 'trim|required');

        $postid = $this->model_penjualan->getitemresep($this->input->post('id'));

        if ($postid) {
            if ($this->form_validation->run() == TRUE) {

                $data = array(
                    'nama' => $this->input->post('nama'),
                    'satuan' => $this->input->post('satuan'),
                    'harga' => $this->input->post('harga'),
                );

                $edit = $this->model_penjualan->updateitemresepdata($this->input->post('id'), $data);
                if ($edit == true) {
                    $this->session->set_flashdata('success', 'Data diedit');
                    redirect('penjualan/item', 'refresh');
                } else {
                    $this->session->set_flashdata('error', 'Terjadi Kesalahan Penambahan!!');
                    redirect('penjualan/item', 'refresh');
                }
            } else {
                // false case       

                $this->data['dataitem'] = $this->model_penjualan->getitemresep();
                $this->render_template('penjualan/item', $this->data);
            }
        } else {
            $this->session->set_flashdata('error', 'Terjadi Kesalahan Penambahan!!');
            redirect('penjualan/item', 'refresh');
        }
    }

    public function fetchitemresep()
    {

        $result = array('data' => array());


        $dt = $this->model_penjualan->getitemresep();
        $no = 1;
        foreach ($dt as $key => $value) {

            $buttons = ' <div class="btn-group dropleft">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span></button>
            <ul class="dropdown-menu">';
            if (in_array('deletepenjualan', $this->permission)) {
                $buttons .= '<li><a style="cursor:pointer;" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i> Hapus</a></li>';
            }
            $buttons .= '</ul></div>';


            $result['data'][$key] = array(
                $buttons,
                $no++,
                $value['nama'],
                $value['satuan'],
                $value['harga'],
            );
        }
        echo json_encode($result);
    }

    public function remove()
    {
        if (!in_array('deletepenjualan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $id = $this->input->post('id');

        $cek = $this->model_penjualan->cekresep($id);
        $response = array();
        if ($cek) {
            $response['success'] = false;
            $response['messages'] = "Item Resep Ini Masih digunakan diresep";
        } else {
            if ($id) {
                $delete = $this->model_penjualan->remove($id);
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
        }

        echo json_encode($response);
    }


    public function resep()
    {
        if (!in_array('createpenjualan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        if ($this->input->post('store') == 7) {
            $idproduct = $this->input->post('menuproduk');
            $namp = $this->model_products->getProductData($idproduct);
            if ($namp) {
                $namamnu = $namp['name'];
            } else {
                $namamnu = '';
            }
            $this->form_validation->set_rules('menuproduk', 'Nama Menu', 'trim|required|is_unique[penjualan_resep.nama_menu]');
        } else {
            $idproduct = 0;
            $namamnu = $this->input->post('menu');
            $this->form_validation->set_rules('menu', 'Nama Menu', 'trim|required');
        }


        if ($this->form_validation->run() == TRUE) {

            $cek = $this->model_penjualan->cekmenudupli($this->input->post('store'), $namamnu);
            if ($cek) {
                $this->session->set_flashdata('error', 'Maaf.. ! Nama Item Telah di Gunakan');
                redirect('penjualan/resep', 'refresh');
            } else {

                $hitung = $this->input->post('product');
                $clear_array = array_count_values($hitung);
                $au = array_keys($clear_array);
                $ay = array_values($hitung);
                if ($au == $ay) {


                    $data = array(
                        'nama_menu' => $namamnu,
                        'store_id' => $this->input->post('store'),
                        'idproduct' => $idproduct
                    );
                    $this->model_penjualan->createresep($data);
                    $idresep = $this->model_penjualan->idresep();

                    $count_product = count($this->input->post('product'));
                    $items = array();
                    for ($x = 0; $x < $count_product; $x++) {
                        if ($this->input->post('store') == 7) {
                            $idproduct = $this->input->post('product[]')[$x];
                            $iditemresep = 0;
                        } else {
                            $iditemresep = $this->input->post('product[]')[$x];
                            $idproduct = 0;
                        }

                        array_push($items, array(
                            'idpenjualanresep' => $idresep['id'],
                            'iditemresep' => $iditemresep,
                            'idproduct' => $idproduct,
                            'qty' => $this->input->post('qty[]')[$x],
                        ));
                    }

                    $create = $this->model_penjualan->createitem($items);
                    if ($create == true) {
                        $this->session->set_flashdata('success', 'Item Ditambahkan');
                        redirect('penjualan/resep', 'refresh');
                    } else {
                        $this->session->set_flashdata('error', 'Terjadi Kesalahan Penambahan!!');
                        redirect('penjualan/resep', 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Maaf.. ! Item Anda Ada Yang Ganda');
                    redirect('penjualan/resep', 'refresh');
                }
            }
        } else {

            $this->data['products'] = $this->model_penjualan->getitemresep();
            $this->data['store'] = $this->model_stores->getStoresData();
            $this->data['prodctjdi'] = $this->model_penjualan->getProductjadi();

            $this->render_template('penjualan/resep', $this->data);
        }
    }

    public function resepeditinput()
    {

        $id = $this->input->post('id');

        if ($this->input->post('store') == 7) {
            $idproduct = $this->input->post('menuproduk');
            $namp = $this->model_products->getProductData($idproduct);
            if ($namp) {
                $namamnu = $namp['name'];
            } else {
                $namamnu = '';
            }
            $this->form_validation->set_rules('menuproduk', 'Nama Menu', 'trim|required');
        } else {
            $idproduct = 0;
            $namamnu = $this->input->post('menu');
            $this->form_validation->set_rules('menu', 'Nama Menu', 'trim|required');
        }

        if ($this->form_validation->run() == TRUE) {


            $hitung = $this->input->post('product[]');
            $clear_array = array_count_values($hitung);
            $au = array_keys($clear_array);
            $ay = array_values($hitung);
            if ($au == $ay) {

                $data = array(
                    'nama_menu' => $namamnu,
                    'store_id' => $this->input->post('store'),
                    'idproduct' => $idproduct
                );
                $this->db->where('id', $id);
                $this->db->update('penjualan_resep', $data);


                $this->db->where('idpenjualanresep', $id);
                $this->db->delete('penjualan_resep_id');


                $count_product = count($this->input->post('product'));
                $items = array();
                for ($x = 0; $x < $count_product; $x++) {
                    if ($this->input->post('store') == 7) {
                        $idproducts = $this->input->post('product[]')[$x];
                        $iditemresep = 0;
                    } else {
                        $iditemresep = $this->input->post('product[]')[$x];
                        $idproducts = 0;
                    }

                    array_push($items, array(
                        'idpenjualanresep' => $id,
                        'iditemresep' => $iditemresep,
                        'idproduct' => $idproducts,
                        'qty' => $this->input->post('qty[]')[$x],
                    ));
                }

                $create = $this->model_penjualan->createitem($items);
                if ($create == true) {
                    $this->session->set_flashdata('success', 'Item Diubah');
                    redirect('penjualan/resep', 'refresh');
                } else {
                    $this->session->set_flashdata('error', 'Terjadi Kesalahan Penambahan!!');
                    redirect('penjualan/resep', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error', 'Maaf.. ! Item Anda Ada Yang Ganda');
                redirect('penjualan/resepedit?id=' . $id, 'refresh');
            }
        }
    }

    public function resepedit()
    {

        $id = $this->input->get('id');
        $getresep = $this->model_penjualan->getresep($id);
        if ($getresep) {
            $this->data['namaresep'] = $getresep['nama_menu'];
            $this->data['stores'] = $getresep['store_id'];
            $this->data['idproduct'] = $getresep['idproduct'];
            $this->data['dt'] = $this->model_penjualan->getresepitemid($getresep['id']);
        } else {
            $this->data['namaresep'] = '';
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('penjualan/resep', 'refresh');
        }


        $this->data['store'] = $this->model_stores->getStoresoutlet();
        $this->data['prodctjdi'] = $this->model_penjualan->getProductjadi();
        $this->render_template('penjualan/resepedit', $this->data);
    }


    public function getProductValueById()
    {
        $product_id = $this->input->post('product_id');
        if ($product_id) {
            $product_data = $this->model_penjualan->getitemresep($product_id);
            echo json_encode($product_data);
        }
    }


    public function getProductValueByIdLogistik()
    {
        $product_id = $this->input->post('product_id');
        if ($product_id) {
            $product_data = $this->model_penjualan->getitemprod($product_id);
            echo json_encode($product_data);
        }
    }

    public function getTableProductRow()
    {
        $products = $this->model_penjualan->getitemresep();
        echo json_encode($products);
    }

    public function getTableProductRowLogistik()
    {
        $products = $this->model_penjualan->getitemprod();
        echo json_encode($products);
    }

    public function edititempjl()
    {
        $id = $this->input->post('id');
        $products = $this->model_penjualan->getitemresepid($id);
        echo json_encode($products);
    }


    public function fetchresep()
    {

        $result = array('data' => array());


        $dt = $this->model_penjualan->getresep();
        $no = 1;
        foreach ($dt as $key => $value) {

            $buttons = ' <div class="btn-group dropleft">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span></button>
            <ul class="dropdown-menu">';
            if (in_array('viewpenjualan', $this->permission)) {
                $buttons .= '<li><a style="cursor:pointer;" onclick="lihat(' . $value['id'] . ')" data-toggle="modal" data-target="#lihatModal"><i class="fa fa-eye"></i> Lihat</a></li>';
            }
            if (in_array('viewpenjualan', $this->permission)) {
                $buttons .= '<li><a style="cursor:pointer;" href="' . base_url('penjualan/resepedit?id=' . $value['id']) . '" ><i class="fa fa-pencil"></i> Edit</a></li>';
            }
            if (in_array('viewpenjualan', $this->permission)) {
                $buttons .= '<li><a style="cursor:pointer;" href="' . base_url('penjualan/duplicate?id=' . $value['id']) . '" ><i class="fa fa-copy"></i> Duplicate</a></li>';
            }
            if (in_array('deletepenjualan', $this->permission)) {
                $buttons .= '<li><a style="cursor:pointer;" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i> Hapus</a></li>';
            }
            $buttons .= '</ul></div>';
            $jmlh = 0;
            $dataresep = $this->model_penjualan->getresepitemid($value['id']);
            foreach ($dataresep as $v) {
                if ($v['iditemresep']) {
                    $item1 = $this->model_penjualan->getitemresep($v['iditemresep']);
                    if (isset($item1['harga']) && isset($v['qty'])) {
                        if ($item1['harga'] && $v['qty']) {
                            $jmlh += $item1['harga'] * $v['qty'];
                        } else {
                            $jmlh += 0;
                        }
                    } else {
                        $jmlh += 0;
                    }
                    $jmlh += 0;
                } else {
                    $item1 = $this->model_penjualan->getitemprod($v['idproduct']);
                    if (isset($item1['price'])) {
                        $jmlh += $item1['price'] * $v['qty'];
                    } else {
                        $jmlh += 0;
                    }
                    $jmlh += 0;
                }
            }

            $store = $this->model_stores->getStoresData($value['store_id']);

            $ttl = "Rp " . number_format($jmlh, 0, ',', '.');
            $result['data'][$key] = array(
                $no++,
                $buttons,
                $store['name'],
                $value['nama_menu'],
                $ttl
            );
        }
        echo json_encode($result);
    }

    public function fetchitemresepid()
    {


        $id = $this->input->post('id');

        $dt = $this->model_penjualan->getresepitemid($id);
        $no = 1;

        echo '
        <table class="table">
            <thead>
            <tr>
      <th scope="col">No</th>
      <th scope="col">Nama</th>
      <th scope="col">Qty</th>
      <th scope="col">Harga</th>
            </tr>
        </thead>
        <tbody>';

        if ($dt) {
            foreach ($dt as $key => $value) {
                $iditmrsp = $value['iditemresep'];
                $dt = $this->model_penjualan->getitemresep($iditmrsp);
                if (isset($dt['nama'])) {
                    $nama = $dt['nama'];
                    $harga = $dt['harga'];
                    $satuan = $dt['satuan'];
                } else {
                    if ($value['idproduct']) {
                        $pro = $this->model_products->getProductData($value['idproduct']);
                        if ($pro) {
                            $nama = $pro['name'];
                            $harga = $pro['price'];
                            $satuan = $pro['satuan'];
                        } else {
                            $nama = 'Item dihapus';
                            $harga = '';
                            $satuan = '';
                        }
                    } else {
                        $nama = 'Item dihapus';
                        $harga = '';
                        $satuan = '';
                    }
                }
                echo '
            <tr>
              <th scope="row">' . $no++ . '</th>
              <td>' . $nama . '</td>
              <td>' . $value['qty'] . '/' . $satuan . '</td>
              <td>' . $harga . '</td>
            </tr>';
            }
        } else {
            echo '
            <tr>
              <td  colspan="4" style="text-align: center;">Tidak temukan</td>
            </tr>';
        }

        echo '
            </tbody>
            </table>';
    }

    public function removeitem()
    {
        if (!in_array('deletepenjualan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $id = $this->input->post('id');

        $response = array();
        if ($id) {
            $delete = $this->model_penjualan->removepenjualan_resep_id($id);
            $delete = $this->model_penjualan->removepenjualan_resep($id);
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







    public function generateChar($num)
    {
        $numeric = ($num - 1) % 26;
        $letter = chr(65 + $numeric);
        $div = ($num - 1) / 26;
        $num2 = (int)$div;
        if ($num2 > 0) {
            return $this->generateChar($num2) . $letter;
        } else {
            return $letter;
        }
    }

    public function getLetters($num_col)
    {
        // initialize array to hold coloumn character
        $letters = [];

        // generate char based on coloumn in db
        for ($i = 1; $i <= $num_col; $i++) {
            $char = $this->generateChar($i);
            array_push($letters, $char);
        }

        return $letters;
    }


    public function dl_format()
    {
        $fields = $this->Model->getFields();

        $htmlString = '<table>';
        $htmlString .= '<tr>';
        foreach ($fields as $field) {
            $htmlString .= '<th align="center" style="font-weight:bold">';
            $htmlString .= $field;
            $htmlString .= '</th>';
        }
        $htmlString .= '</tr>';
        $htmlString .= '</table>';

        // convert to spreadsheet-type
        $reader = new Html();
        $spreadsheet = $reader->loadFromString($htmlString);

        // // generate excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="format_import.xlsx"');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function check_import()
    {
        // load upload library
        $this->load->library('upload');
        $data['title'] = 'import data from excel';

        // get fieldsname & number of coloumn
        $data['fields'] = $this->Model->getFields();
        $num_col = $this->Model->getCol();

        // get letters array
        $alphabet = $this->getLetters($num_col);

        $this->load->view('templates/header', $this->data);
        $this->load->view('templates/header_menu', $this->data);
        $this->load->view('templates/side_menubar', $this->data);
        $this->load->view('penjualan/import', $this->data);


        // check if preview button was clicked
        if (isset($_POST['preview'])) {

            // set config for uploaded file
            $config['upload_path']          = './uploads/';
            $config['allowed_types']        = 'xlsx';
            $config['file_name']                        = 'import_data';
            $config['overwrite']                        = TRUE;

            // load upload library config
            $this->upload->initialize($config);

            // if uploaded
            if ($this->upload->do_upload('file_import')) {
                // read file that has been uploaded using specific reader
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet = $reader->load('./uploads/' . $this->upload->data('file_name'));

                // get all retrieved data from cell to array
                $data['sheet'] = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                $data['letters'] = $alphabet;

                $this->load->view('penjualan/import_preview', $data);
            }
            // if failed upload
            else {
                $this->session->set_flashdata('error', 'File failed to upload :(');
                redirect('penjualan/check_import');
            }
        }
        $this->load->view('templates/footer', $this->data);
    }


    public function import()
    {
        // get number of coloumn
        $fields = $this->Model->getFields();
        $num_col = $this->Model->getCol();

        // get letters array
        $alphabet = $this->getLetters($num_col);

        // read file that has been uploaded using specific reader
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load('./uploads/import_data.xlsx');

        // retieve all data in excel then convert into array
        $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        // initialize array to hold inserted data 
        $data = [];

        // variable for initialize row
        $n = 0;
        foreach ($sheet as $row) {
            // looping each coloumn in each row
            for ($i = 0; $i < $num_col; $i++) {
                $data[$n][$fields[$i]] = $row[$alphabet[$i]];
            }
            // when all coloumn done, move to next row
            $n++;
        }

        // remove the first data (row header)
        array_shift($data);


        $this->model_penjualan->removepenjualan_import();

        // post all data in batch to database
        $this->Model->post_batch($data);
        $this->session->set_flashdata('success', 'Import data has been inserted');
        redirect('penjualan/check_import');
    }



    public function export()
    {

        $this->render_template('penjualan/export', $this->data);
    }


    public function fetchimport()
    {

        $result = array('data' => array());


        $dt = $this->model_penjualan->getimport();
        $no = 1;
        foreach ($dt as $key => $value) {

            $pesan = $value['nama'];
            $ms = str_replace('(GB) ', '', $pesan);
            $message = str_replace('GB ', '', $ms);

            $name = $message;
            $varian = $value['varian'];
            $dtnama_menu = $this->model_penjualan->getnamamenu("$name");
            $dtnama_varian = $this->model_penjualan->getnamamenu("$varian");

            if ($dtnama_menu) {
                $nama_menu = $dtnama_menu['nama_menu'];
                $id_menu = $dtnama_menu['id'];

                $itemrsp = $this->model_penjualan->getresepitemid($id_menu);

                $qtyresep = '';
                $qtyvarian = '';
                $total = '';
                $upqty = 0;

                $qtytotalvrn = array();
                if ($dtnama_varian) {
                    $nama_varian =  $dtnama_varian['nama_menu'];
                    $id_varian =  $dtnama_varian['id'];
                    $itemrspvarian = $this->model_penjualan->getresepitemid($id_varian);
                    $variancek = '(' . $nama_varian . ')';

                    foreach ($itemrspvarian as  $v) {
                        $iditemresep = $this->model_penjualan->getitemresep($v['iditemresep']);
                        if ($iditemresep) {
                            $qtytotalvrn[$iditemresep['nama']] = $v['qty'] * $value['qty'];
                            if ($iditemresep['harga']) {
                                $qtyvarian .= '(' . $iditemresep['nama'] . ' ' . '@' . $v['qty'] . ' ' . $iditemresep['satuan'] . '/' . $iditemresep['harga'] . ')<br>';
                            } else {
                                $qtyvarian .= '(' . $iditemresep['nama'] . ' ' . $v['qty'] . ' ' . $iditemresep['satuan']  . ')<br>';
                            }
                        } else {
                            $qtyvarian = '-';
                            $variancek = '<font color="red">( No Varian )</font>';
                        }
                    }
                } else {
                    $qtyvarian = '-';
                    $variancek = '';
                }


                $qtytotalrsp = array();
                foreach ($itemrsp as  $v) {
                    $iditemresep = $this->model_penjualan->getitemresep($v['iditemresep']);
                    $ambiliditem = $this->model_penjualan->getitemprod($v['idproduct']);
                    if ($v['iditemresep'] && $iditemresep) {
                        $qtytotalrsp[$iditemresep['nama']] = $v['qty'] * $value['qty'];
                        if ($iditemresep['harga']) {
                            $qtyresep .= '(' . $iditemresep['nama'] . ' ' . '@' . $v['qty'] . ' ' . $iditemresep['satuan'] . '/' . $iditemresep['harga'] . ')<br>';
                            $total .= $iditemresep['nama'] . ' '  . $v['qty'] * $value['qty'] . '/' . $iditemresep['satuan'] . ' (Rp.' . $iditemresep['harga'] * $value['qty'] . ')<br>';
                        } else {
                            $qtyresep .= '(' . $iditemresep['nama'] . ' ' . $v['qty'] . ' ' . $iditemresep['satuan']  . ')<br>';
                            $total .= $iditemresep['nama'] . ' '  . $v['qty'] * $value['qty'] . '/' . $iditemresep['satuan'] . '<br>';
                        }
                    } else if ($v['idproduct'] && $ambiliditem) {
                        $qtytotalrsp[$ambiliditem['name']] = $v['qty'] * $value['qty'];
                        if ($ambiliditem['price']) {
                            $qtyresep .= '(' . $ambiliditem['name'] . ' ' . '@' . $v['qty'] . ' ' . $ambiliditem['satuan'] . '/' . $ambiliditem['price'] . ')<br>';
                            $total .= $ambiliditem['name'] . ' '  . $v['qty'] * $value['qty'] . '/' . $ambiliditem['satuan'] . ' (Rp.' . $ambiliditem['price'] * $value['qty'] . ')<br>';
                        } else {
                            $qtyresep .= '(' . $ambiliditem['name'] . ' ' . $v['qty'] . ' ' . $ambiliditem['satuan']  . ')<br>';
                            $total .= $ambiliditem['name'] . ' '  . $v['qty'] * $value['qty'] . '/' . $ambiliditem['satuan'] . '<br>';
                        }
                    }
                }
            } else {
                $nama_menu = '<font color="red">Tak ditemukan</font>';
                $qtyresep = '-';
                $total = '-';
                $qtytotalrsp = array();
                $qtytotalvrn = array();
                $qtyvarian = '-';
                $variancek = '<font color="red">( No Varian )</font>';
            }



            $array = array_merge(array($qtytotalrsp), array($qtytotalvrn));
            $sumArray = array();
            foreach ($array as $k => $subArray) {
                foreach ($subArray as $id => $k) {
                    if (!isset($sumArray[$id])) {
                        $sumArray[$id] = $k;
                    } else {
                        $sumArray[$id] += $k;
                    }
                }
            }
            $qty = array_values($sumArray);
            $nama = array_keys($sumArray);
            $totalqty = '';
            $c = count($nama);
            $totalhpp = 0;
            for ($i = 0; $i < $c; $i++) {

                $dtnama_menu = $this->model_penjualan->getnamaitemmenu("$nama[$i]");
                if ($dtnama_menu['harga']) {
                    $total = $dtnama_menu['harga'] * $qty[$i];
                    $totalhpp += $total;
                    $ttl = "(Rp " . number_format($total, 0, ',', '.') . ')';
                } else {
                    $totalhpp += 0;
                    $ttl = '';
                }
                if ($c == $i + 1) {
                    $totalqty .=   $nama[$i] . ' ' . $qty[$i] . '/' . $dtnama_menu['satuan']  . ' ' . $ttl . '<br>';
                } else {
                    $totalqty .=   $nama[$i]  . ' ' . $qty[$i] . '/' . $dtnama_menu['satuan'] . ' '  . $ttl . '<br>';
                }
            }

            if ($totalqty) {
                $totalhasil = $totalqty;
            } else {
                $totalhasil = '-';
            }

            if ($varian) {
                $vrn = '(' . $value['varian'] . ')';
            } else {
                $vrn = '';
            }

            $hasil_rupiah = "Rp " . number_format($totalhpp, 0, ',', ',');
            $result['data'][$key] = array(
                $no++,
                $value['nama'] . ' ' . $vrn,
                $nama_menu . ' ' . $variancek,
                $value['qty'],
                $qtyresep,
                $qtyvarian,
                $totalhasil,
                $hasil_rupiah
            );
        }
        echo json_encode($result);
    }


    public function fetchimportitem()
    {

        $dt = $this->model_penjualan->getimport();
        $no = 1;
        $data1 = array();
        $data2 = array();
        foreach ($dt as $key => $value) {

            $pesan = $value['nama'];
            $ms = str_replace('(GB) ', '', $pesan);
            $message = str_replace('GB ', '', $ms);

            $name = $message;
            $varian = $value['varian'];
            $dtnama_menu = $this->model_penjualan->getnamamenu("$name");
            $dtnama_varian = $this->model_penjualan->getnamamenu("$varian");


            if ($dtnama_menu) {
                $id_menu = $dtnama_menu['id'];
                $itemrsp = $this->model_penjualan->getresepitemid($id_menu);



                $dt1 = array();
                foreach ($itemrsp as $v) {
                    $iditemresep = $this->model_penjualan->getitemresepid($v['iditemresep']);
                    $ambiliditem = $this->model_penjualan->getitemprod($v['idproduct']);
                    if ($v['iditemresep'] && $iditemresep) {
                        $dt1[$iditemresep['nama']] =  $v['qty'] * $value['qty'];
                    } else if ($v['idproduct'] && $ambiliditem) {
                        $dt1[$ambiliditem['name']] =  $v['qty'] * $value['qty'];
                    }
                }

                $dt2 = array();
                if ($dtnama_varian) {
                    $id_varian =  $dtnama_varian['id'];
                    $itemrspvarian = $this->model_penjualan->getresepitemid($id_varian);
                    foreach ($itemrspvarian as $v) {
                        $iditemresep = $this->model_penjualan->getitemresepid($v['iditemresep']);
                        if ($iditemresep) {
                            $dt2[$iditemresep['nama']] =  $v['qty'] * $value['qty'];
                        }
                    }
                }

                $data1[] = $dt1;
                $data2[] = $dt2;
            } else {
                $data1[] = [];
                $data2[] = [];
            }
        }

        $hasil = array_merge($data1, $data2);

        $sumArray = array();

        foreach ($hasil as $k => $subArray) {
            foreach ($subArray as $id => $value) {
                if (!isset($sumArray[$id])) {
                    $sumArray[$id] = $value;
                } else {
                    $sumArray[$id] += $value;
                }
            }
        }

        $qty = array_values($sumArray);
        $nama = array_keys($sumArray);


        $c = count($nama);

        $array = '{"data":[';
        for ($i = 0; $i < $c; $i++) {

            $dtnama_menu = $this->model_penjualan->getnamaitemmenu("$nama[$i]");
            if ($dtnama_menu) {
                $total = $dtnama_menu['harga'] * $qty[$i];
                $harga = "Rp " . number_format($dtnama_menu['harga'], 0, ',', '.');
                $ttl = "Rp " . number_format($total, 0, ',', '.');
            } else {
                $harga = 0;
                $ttl = 0;
            }
            if ($c == $i + 1) {
                $array .= '[' . $no++ . ',' .  '"' . $nama[$i] . '"' . ',' . '"' . $qty[$i] . '/' . $dtnama_menu['satuan'] . '"' . ',' . '"' . $harga . '"' . ',"' . $ttl . '"' .  ']';
            } else {
                $array .= '[' . $no++ . ',' .  '"' . $nama[$i] . '"' . ',' . '"' . $qty[$i] . '/' . $dtnama_menu['satuan'] . '"' . ',' . '"' . $harga . '"' . ',"' . $ttl . '"' .  '],';
            }
        }
        $array .= ']}';

        print_r($array);
    }



    public function excelpermenu()
    {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $filename = "Laporan Penjualan Permenu " . date('d-m-Y') . ".xlsx";

        $spreadsheet->getProperties()
            ->setCreator("Fembi Nur Ilham")
            ->setLastModifiedBy("Fembi Nur Ilham")
            ->setTitle("Laporan Penjualan ")
            ->setSubject("Hasil Export Dari PRS System")
            ->setDescription("Semoga Terbantu Dengan Adanya Ini")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Order");

        $sheet->setCellValue('A1', 'Laporan Penjualan Permenu ');
        $sheet->setCellValue('A2', date('d-m-Y'));
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);

        $sheet->setCellValue('A4', 'No');
        $sheet->setCellValue('B4', 'Nama Import');
        $sheet->setCellValue('C4', 'Nama Menu');
        $sheet->setCellValue('D4', 'Qty Import');
        $sheet->setCellValue('E4', 'Qty Resep Menu');
        $sheet->setCellValue('F4', 'Qty Resep Varian');
        $sheet->setCellValue('G4', 'Total');
        $sheet->setCellValue('H4', 'HPP');



        $data = $this->model_penjualan->getimport();
        $baris = 5;
        $no = 1;
        $count = 4;
        if ($data) {
            foreach ($data as $key => $value) {

                $pesan = $value['nama'];
                $ms = str_replace('(GB) ', '', $pesan);
                $message = str_replace('GB ', '', $ms);

                $name = $message;
                $varian = $value['varian'];
                $dtnama_menu = $this->model_penjualan->getnamamenu("$name");
                $dtnama_varian = $this->model_penjualan->getnamamenu("$varian");

                if ($dtnama_menu) {
                    $nama_menu = $dtnama_menu['nama_menu'];
                } else {
                    $nama_menu = '(Menu Nothing) ';
                }


                if ($varian) {
                    $vrn = '(' . $value['varian'] . ')';
                    if ($dtnama_varian) {
                        $nama_varian =  $dtnama_varian['nama_menu'];
                    } else {
                        $nama_varian = '( Tak ditemukan )';
                    }
                } else {
                    $vrn = '';
                    $nama_varian = '';
                }

                $sheet->setCellValue('A' . $baris, $no++);
                $sheet->setCellValue('B' . $baris, $value['nama'] . $vrn);
                $sheet->setCellValue('C' . $baris, $nama_menu . ' ' . $nama_varian);
                $sheet->setCellValue('D' . $baris, $value['qty']);

                if ($dtnama_menu) {
                    $nama_menu = $dtnama_menu['nama_menu'];
                    $id_menu = $dtnama_menu['id'];

                    $itemrsp = $this->model_penjualan->getresepitemid($id_menu);

                    $qtyresep = '';
                    $qtyvarian = '';
                    $total = '';
                    $upqty = 0;

                    $qtytotalvrn = array();
                    if ($dtnama_varian) {
                        $nama_varian =  $dtnama_varian['nama_menu'];
                        $id_varian =  $dtnama_varian['id'];
                        $itemrspvarian = $this->model_penjualan->getresepitemid($id_varian);
                        $variancek = '(' . $nama_varian . ')';

                        foreach ($itemrspvarian as  $v) {
                            $iditemresep = $this->model_penjualan->getitemresep($v['iditemresep']);
                            if ($iditemresep) {
                                $qtytotalvrn[$iditemresep['nama']] = $v['qty'] * $value['qty'];
                                if ($iditemresep['harga']) {
                                    $qtyvarian .= '(' . $iditemresep['nama'] . ' ' . '@' . $v['qty'] . ' ' . $iditemresep['satuan'] . '/' . $iditemresep['harga'] . ')';
                                } else {
                                    $qtyvarian .= '(' . $iditemresep['nama'] . ' ' . $v['qty'] . ' ' . $iditemresep['satuan']  . ')';
                                }
                            } else {
                                $qtyvarian = '-';
                                $variancek = '( No Varian )';
                            }
                        }
                    } else {
                        $qtyvarian = '-';
                        $variancek = '( No Varian )';
                    }


                    $qtytotalrsp = array();
                    foreach ($itemrsp as  $v) {
                        $iditemresep = $this->model_penjualan->getitemresep($v['iditemresep']);
                        if ($iditemresep) {
                            $qtytotalrsp[$iditemresep['nama']] = $v['qty'] * $value['qty'];
                            if ($iditemresep['harga']) {
                                $qtyresep .= '(' . $iditemresep['nama'] . ' ' . '@' . $v['qty'] . ' ' . $iditemresep['satuan'] . '/' . $iditemresep['harga'] . ') ';
                                $total .= $iditemresep['nama'] . ' '  . $v['qty'] * $value['qty'] . '/' . $iditemresep['satuan'] . ' (Rp.' . $iditemresep['harga'] * $value['qty'] . ') ';
                            } else {
                                $qtyresep .= '(' . $iditemresep['nama'] . ' ' . $v['qty'] . ' ' . $iditemresep['satuan']  . ') ';
                                $total .= $iditemresep['nama'] . ' '  . $v['qty'] * $value['qty'] . '/' . $iditemresep['satuan'] . ' ';
                            }
                        }
                    }
                } else {
                    $qtyresep = '-';
                    $total = '-';
                    $qtytotalrsp = array();
                    $qtytotalvrn = array();
                    $qtyvarian = '-';
                }



                $array = array_merge(array($qtytotalrsp), array($qtytotalvrn));
                $sumArray = array();
                foreach ($array as $k => $subArray) {
                    foreach ($subArray as $id => $k) {
                        if (!isset($sumArray[$id])) {
                            $sumArray[$id] = $k;
                        } else {
                            $sumArray[$id] += $k;
                        }
                    }
                }

                $sheet->setCellValue('E' . $baris, $qtyresep);
                $sheet->setCellValue('F' . $baris, $qtyvarian);


                $qty = array_values($sumArray);
                $nama = array_keys($sumArray);

                $c = count($nama);
                $totalhpp = 0;
                if (!$c == 0) {
                    for ($i = 0; $i < $c; $i++) {

                        $dtnama_menu = $this->model_penjualan->getnamaitemmenu("$nama[$i]");

                        if ($dtnama_menu) {
                            if ($dtnama_menu['harga']) {
                                $total = $dtnama_menu['harga'] * $qty[$i];
                                $ttl = "(Rp " . number_format($total, 0, ',', '.') . ')';
                                $totalhpp +=  $total;
                            } else {
                                $totalhpp += 0;
                                $ttl = '';
                            }
                            if ($c == $i + 1) {
                                $totalqty =   $nama[$i] . ' ' . $qty[$i] . '/' . $dtnama_menu['satuan']  . ' ' . $ttl . '';
                                $sheet->setCellValue('G' . $baris++, $totalqty);
                            } else {
                                $totalqty =   $nama[$i]  . ' ' . $qty[$i] . '/' . $dtnama_menu['satuan'] . ' '  . $ttl . '';
                                $sheet->setCellValue('G' . $baris++, $totalqty);
                            }
                        }
                    }
                } else {
                    $sheet->setCellValue('G' . $baris++, '-');
                }
                $hasil_rupiah = "Rp " . number_format($totalhpp, 0, ',', ',');
                $sheet->setCellValue('H' . $baris, $hasil_rupiah);



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
            redirect('penjualan/', 'refresh');
        }
    }



    public function excelperitem()
    {


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $filename = "Laporan Penjualan Peritem " . date('d-m-Y') . ".xlsx";

        $spreadsheet->getProperties()
            ->setCreator("Fembi Nur Ilham")
            ->setLastModifiedBy("Fembi Nur Ilham")
            ->setTitle("Laporan Penjualan ")
            ->setSubject("Hasil Export Dari PRS System")
            ->setDescription("Semoga Terbantu Dengan Adanya Ini")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Order");

        $sheet->setCellValue('A1', 'Laporan Penjualan Peritem ');
        $sheet->setCellValue('A2', date('d-m-Y'));
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);

        $sheet->setCellValue('A4', 'No');
        $sheet->setCellValue('B4', 'Nama Item');
        $sheet->setCellValue('C4', 'QTY Total');
        $sheet->setCellValue('D4', '1/Harga');
        $sheet->setCellValue('E4', 'Harga Total');

        $dt = $this->model_penjualan->getimport();
        $no = 1;
        $data = array();

        $baris = 5;
        if ($dt) {
            $data1 = array();
            $data2 = array();
            foreach ($dt as $key => $value) {

                $pesan = $value['nama'];
                $message = str_replace('GB ', '', $pesan);

                $name = $message;
                $varian = $value['varian'];
                $dtnama_menu = $this->model_penjualan->getnamamenu("$name");
                $dtnama_varian = $this->model_penjualan->getnamamenu("$varian");


                if ($dtnama_menu) {
                    $id_menu = $dtnama_menu['id'];
                    $itemrsp = $this->model_penjualan->getresepitemid($id_menu);



                    $dt1 = array();
                    foreach ($itemrsp as $v) {
                        $iditemresep = $this->model_penjualan->getitemresepid($v['iditemresep']);
                        if ($iditemresep) {
                            $dt1[$iditemresep['nama']] =  $v['qty'] * $value['qty'];
                        }
                    }

                    $dt2 = array();
                    if ($dtnama_varian) {
                        $id_varian =  $dtnama_varian['id'];
                        $itemrspvarian = $this->model_penjualan->getresepitemid($id_varian);
                        foreach ($itemrspvarian as $val) {
                            $iditemresepvar = $this->model_penjualan->getitemresepid($val['iditemresep']);
                            if ($iditemresepvar) {
                                $dt2[$iditemresepvar['nama']] =  $val['qty'] * $value['qty'];
                            }
                        }
                    }

                    $data1[] = $dt1;
                    $data2[] = $dt2;
                } else {
                    $data1[] = [];
                    $data2[] = [];
                }
            }

            $hasil = array_merge($data1, $data2);

            $sumArray = array();

            foreach ($hasil as $k => $subArray) {
                foreach ($subArray as $id => $value) {
                    if (!isset($sumArray[$id])) {
                        $sumArray[$id] = $value;
                    } else {
                        $sumArray[$id] += $value;
                    }
                }
            }

            $qty = array_values($sumArray);
            $nama = array_keys($sumArray);


            $c = count($nama);

            $array = '[';

            $jml = 0;
            for ($i = 0; $i < $c; $i++) {

                $dtnama_menu = $this->model_penjualan->getnamaitemmenu("$nama[$i]");
                if ($dtnama_menu) {
                    if ($dtnama_menu['harga']) {
                        $jml += $dtnama_menu['harga'] * $qty[$i];
                        $total = $dtnama_menu['harga'] * $qty[$i];
                        $harga =  number_format($dtnama_menu['harga'], 0, ',', ',');
                        $ttl =  number_format($total, 0, ',', ',');
                    } else {
                        $harga = 0;
                        $ttl = 0;
                    }
                    if ($c == $i + 1) {
                        $array .= '[' . $no++ . ',' .  '"' . $nama[$i] . '"' . ',' . '"' . $qty[$i] . '/' . $dtnama_menu['satuan'] . '"' . ',' . '"' . $harga . '"' . ',"' . $ttl . '"' .  ']';
                    } else {
                        $array .= '[' . $no++ . ',' .  '"' . $nama[$i] . '"' . ',' . '"' . $qty[$i] . '/' . $dtnama_menu['satuan'] . '"' . ',' . '"' . $harga . '"' . ',"' . $ttl . '"' .  '],';
                    }
                }
            }
            $array .= ']';
        }

        //print_r($array);
        $result = json_decode($array, TRUE);
        $n = 1;
        foreach ($result as $v) {
            $sheet->setCellValue('A' . $baris, $n++);
            $sheet->setCellValue('B' . $baris, $v[1]);
            $sheet->setCellValue('C' . $baris, $v[2]);
            $sheet->setCellValue('D' . $baris, $v[3]);
            $sheet->setCellValue('E' . $baris, $v[4]);

            $baris++;
        }
        $sheet->setCellValue('A' . $baris, 'Jumlah ');
        $sheet->setCellValue('E' . $baris, $jml);
        $writer = new Xlsx($spreadsheet);
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Content-Type: application/vnd.ms-excel');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function excelresep()
    {
        $idstore = $this->input->post('id');
        if ($idstore) {
            $store =  $this->model_stores->getStoresData($idstore);
            $judul = "HPP Resep " . $store['name'];
        } else {
            $judul = 'HPP Resep Keseluruhan';
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $filename = $judul . date('d-m-Y') . ".xlsx";

        $spreadsheet->getProperties()
            ->setCreator("Fembi Nur Ilham")
            ->setLastModifiedBy("Fembi Nur Ilham")
            ->setTitle("Laporan Penjualan ")
            ->setSubject("Hasil Export Dari PRS System")
            ->setDescription("Semoga Terbantu Dengan Adanya Ini")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Order");

        $sheet->setCellValue('A1', $judul);
        $sheet->setCellValue('A2', date('d-m-Y'));
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);

        $sheet->setCellValue('A4', 'No');
        $sheet->setCellValue('B4', 'Nama Resep');
        $sheet->setCellValue('C4', 'Item');
        $sheet->setCellValue('D4', 'Qty');
        $sheet->setCellValue('E4', 'Satuan');
        $sheet->setCellValue('F4', 'Harga');
        $sheet->setCellValue('G4', 'HPP');



        $data = $this->model_penjualan->getnamamenustore($idstore);
        $baris = 5;
        $no = 1;
        $count = 4;

        if ($data) {
            foreach ($data as $key => $value) {

                if (!$value['idproduct']) {
                    $name = $value['nama_menu'];
                } else {
                    $product = $this->model_products->getProductData($value['idproduct']);
                    $name = $product['name'];
                }
                $dtnama_menu = $this->model_penjualan->getnamamenu("$name");

                $nama_menu = $dtnama_menu['nama_menu'];
                $id_menu = $dtnama_menu['id'];



                $sheet->setCellValue('A' . $baris, $no++);
                $sheet->setCellValue('B' . $baris, $nama_menu);

                $itemrsp = $this->model_penjualan->getresepitemid($id_menu);


                $hpp = 0;
                if ($itemrsp) {
                    foreach ($itemrsp as  $v) {
                        if (!$value['idproduct']) {
                            $iditemresep = $this->model_penjualan->getitemresep($v['iditemresep']);
                            if ($iditemresep) {
                                if ($iditemresep['harga']) {
                                    $hpp += $iditemresep['harga'] * $v['qty'];
                                    $sheet->setCellValue('C' . $baris, $iditemresep['nama']);
                                    $sheet->setCellValue('D' . $baris, $v['qty']);
                                    $sheet->setCellValue('E' . $baris, $iditemresep['satuan']);
                                    $sheet->setCellValue('F' . $baris, $iditemresep['harga']);
                                }
                                $baris++;
                            } else {
                                $sheet->setCellValue('C' . $baris, 'Tak Ditemukan');
                                $sheet->setCellValue('D' . $baris, '-');
                                $sheet->setCellValue('E' . $baris, '-');
                                $sheet->setCellValue('F' . $baris, '-');
                            }
                        } else {
                            $iditemresep = $this->model_products->getProductData($v['idproduct']);
                            if ($iditemresep) {
                                if ($iditemresep['price']) {
                                    $hpp += $iditemresep['price'] * $v['qty'];
                                    $sheet->setCellValue('C' . $baris, $iditemresep['name']);
                                    $sheet->setCellValue('D' . $baris, $v['qty']);
                                    $sheet->setCellValue('E' . $baris, $iditemresep['satuan']);
                                    $sheet->setCellValue('F' . $baris, $iditemresep['price']);
                                }
                                $baris++;
                            } else {
                                $sheet->setCellValue('C' . $baris, 'Tak Ditemukan');
                                $sheet->setCellValue('D' . $baris, '-');
                                $sheet->setCellValue('E' . $baris, '-');
                                $sheet->setCellValue('F' . $baris, '-');
                            }
                        }
                    }
                } else {
                    $sheet->setCellValue('C' . $baris, 'Tak Ditemukan');
                }

                if ($hpp) {
                    $spreadsheet
                        ->getActiveSheet()
                        ->getStyle('B' . $baris . ':G' . $baris)
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('28a745');
                    $sheet->setCellValue('G' . $baris, $hpp);
                } else {
                    $spreadsheet
                        ->getActiveSheet()
                        ->getStyle('B' . $baris . ':G' . $baris)
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('dc3545');
                    $sheet->setCellValue('G' . $baris, '-');
                }


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
            redirect('penjualan/', 'refresh');
        }
    }

    public function tes()
    {
        $pesan = 'GB Baso Aci';
        $message = str_replace('GB ', '', $pesan);
    }
}
