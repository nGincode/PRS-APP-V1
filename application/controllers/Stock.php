<?php

defined('BASEPATH') or exit('No direct script access allowed');

require('./assets/phpoffice/vendor/autoload.php');

require('./assets/fpdf/fpdf.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Stock extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Stock';

        $this->load->model('model_users');
        $this->load->model('model_stock');
        $this->load->model('model_stores');
    }

    //done
    public function index()
    {
        if (!in_array('viewstock', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->data['div'] = $this->session->userdata('divisi');
        $this->data['store'] = $this->model_stores->getStoresoutlet();
        $this->data['page_title'] = 'Manage Stock';

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

        $this->render_template('stock/index', $this->data);
    }

    //done
    public function databarang()
    {
        $user_id = $this->session->userdata('id');

        $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $posstore = $this->input->post('outlet');
            if (isset($posstore)) {
                $store_id = $this->input->post('outlet');
                $str = $this->model_stores->getStoresData($store_id);
                $store = $str['name'];
            } else {
                $store_id = $this->session->userdata('store_id');
                $store = $this->session->userdata('store');
            }
            $data = array(
                'nama_produk' => $this->input->post('nama_produk'),
                'bagian' => $this->input->post('bagian'),
                'satuan' => $this->input->post('satuan'),
                'harga' => $this->input->post('harga'),
                'kategori' => $this->input->post('kategori'),
                'user_id' => $user_id,
                'store_id' => $store_id,
                'store' => $store,
            );
            $create = $this->model_stock->databarang($data);
            if ($create == true) {
                $this->session->set_flashdata('success', 'Data Barang Ditambahkan');
                redirect('stock/databarang', 'refresh');
            } else {
                $this->session->set_flashdata('error', 'Terjadi Kesalahan Penambahan!!');
                redirect('stock/databarang', 'refresh');
            }
        } else {
            $this->data['page_title'] = 'Tambah Stock';
            $this->data['store'] = $this->model_stores->getActiveStore();
            $this->render_template('stock/databarang', $this->data);
        }
    }

    //done
    public function datastock()
    {
        if (!in_array('createstock', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $user_id = $this->session->userdata('id');
        $store_id = $this->session->userdata('store_id');
        $store = $this->session->userdata('store');
        $div = $this->session->userdata('divisi');


        $this->form_validation->set_rules('product[]', 'Nama Produk', 'trim|required');
        $this->form_validation->set_rules('tgl[]', 'Tanggal', 'trim|required');


        if ($this->form_validation->run() == TRUE) {
            $items = array();
            $count_product = count($this->input->post('count[]'));
            for ($x = 0; $x < $count_product; $x++) {


                $a_unit = $this->input->post('a_unit[]')[$x];
                $t_unit = $this->input->post('t_unit[]')[$x];
                $s_unit = $this->input->post('s_unit[]')[$x];

                $reg = $this->input->post('reg[]')[$x];

                $hrg = $this->input->post('a_harga[]')[$x];

                if ($hrg) {
                    $harga = $this->input->post('a_harga[]')[$x];
                } else {
                    $harga = 0;
                }

                $unit = round($a_unit + $t_unit - $s_unit, 1);

                if ($reg) {
                    $pemakaian = round($reg - $unit, 1);
                } else {
                    $pemakaian = 0;
                }

                $sama = $this->input->post('tgl') . $this->input->post('product')[$x];
                $samadb = $this->model_stock->validasisama($this->input->post('product')[$x], $this->input->post('tgl'));

                if ($samadb) {
                    $datastock = $samadb['tgl'] . $samadb['produk_id'];
                } else {
                    $datastock = '';
                }

                if ($sama == $datastock) {
                    $this->session->set_flashdata('error', 'Data Telah Ada!! Tanggal & Nama Barang telah di input');
                    redirect('stock/datastock', 'refresh');
                } else {
                    if (strlen($this->input->post('ket[]')[$x]) == 1) {
                        $ket = '';
                    } else {
                        $ket = $this->input->post('ket[]')[$x];
                    }
                    array_push($items, array(
                        'user_id' => $user_id,
                        'store_id' => $store_id,
                        'store' => $store,
                        'bagian' => $this->input->post('bagian'),
                        'kategori' => $this->input->post('kategory')[$x],
                        'produk_id' => $this->input->post('product')[$x],
                        'nama_produk' => $this->input->post('nama_produk[]')[$x],
                        'a_unit' => $this->input->post('a_unit[]')[$x],
                        't_unit' => $this->input->post('t_unit[]')[$x],
                        's_unit' => $this->input->post('s_unit[]')[$x],
                        'unit' => $unit,
                        'uom' => $this->input->post('satuan_value[]')[$x],
                        'harga' => $harga,
                        'reg' => $this->input->post('reg[]')[$x],
                        'status' => $pemakaian,
                        'tgl' =>  $this->input->post('tgl'),
                        'ket' =>  $ket,
                    ));
                }
            }
            $create = $this->model_stock->createstock($items);
            if ($create == true) {
                $this->session->set_flashdata('success', 'Data Barang Ditambahkan');
                redirect('stock/datastock', 'refresh');
            } else {
                $this->session->set_flashdata('error', 'Terjadi Kesalahan Penambahan!!');
                redirect('stock/datastock', 'refresh');
            }
        } else {

            if ($div == 1 or $div == 2 or $div == 3) {
                $hasil = $this->model_stock->view_data2($div, $store_id);

                $dt = $this->model_stock->tglstock($div, $store_id);
                if (isset($dt['tgl'])) {
                    $this->data['tgl'] = date('Y-m-d', strtotime('+1 day', strtotime($dt['tgl'])));
                } else {
                    $this->data['tgl'] = date('Y-m-d');
                }
                $this->data['data'] = $hasil;
            }
            $this->data['page_title'] = 'Tambah Stock';
            $this->data['user_id'] = $user_id;
            $this->data['div'] = $div;
            $this->data['outlet'] = $store;
            $this->render_template('stock/datastock', $this->data);
        }
    }

    public function view_data()
    {
        if (isset($_POST['cari'])) {

            $store_id = $this->session->userdata('store_id');
            $data['data']    = $this->model_stock->view_data($this->input->post('date'), $store_id, $this->input->post('divisi'));
            $this->load->view('stock/tabel_data', $data);
        } else {
            echo "Silahkan Cek koneksi internet Anda!";
        }
    }

    public function view_data2()
    {
        if (isset($_POST['cari'])) {

            $store_id = $this->session->userdata('store_id');

            $hasil = $this->model_stock->view_data2($this->input->post('divisi'), $store_id);
            $data['data'] = $hasil;

            $dt = $this->model_stock->tglstock($this->input->post('divisi'), $store_id);

            if (isset($dt['tgl'])) {
                $data['tgl'] = date('Y-m-d', strtotime('+1 day', strtotime($dt['tgl'])));
            } else {
                $data['tgl'] = date('Y-m-d');
            }

            $this->load->view('stock/tabel_data2', $data);
        } else {
            echo "Silahkan Cek koneksi internet Anda!";
        }
    }


    public function view_data3()
    {
        if (isset($_POST['cari'])) {

            $store_id = $this->session->userdata('store_id');
            if ($this->input->post('divisi') && $this->input->post('tglawal') && $this->input->post('tglakhir')) {
                $hasil = $this->model_stock->view_data3($this->input->post('divisi'), $store_id, $this->input->post('tglawal'), $this->input->post('tglakhir'));
                $data['data'] = $hasil;
            } else {
                echo 'Input Belum Lengkap';
            }

            $this->load->view('stock/tabel_data3', $data);
        } else {
            echo "Silahkan Cek koneksi internet Anda!";
        }
    }


    public function view_tambah()
    {
        if (isset($_POST['cari'])) {

            $hasil = $this->model_stock->view_data2($this->input->post('bagian'), $this->input->post('store_id'));
            $data['data'] = $hasil;
            $this->load->view('stock/tabel_tambah', $data);
        } else {
            echo "Silahkan Cek koneksi internet Anda!";
        }
    }

    public function hitung()
    {
        echo 'data';
        echo $ah = $this->input->post('ah');
    }

    public function getnamastockidstore()
    {

        // Ambil data kelas (kel_id) yang dikirim via ajax post
        $bagian = $this->input->post('bagian');
        $store_id = $this->input->post('store_id');
        $kategori = $this->input->post('kategori');

        $products = $this->model_stock->getnamastockidstore($bagian, $store_id, $kategori);
        echo json_encode($products);
    }


    public function getnamastock()
    {
        $products = $this->model_stock->getnamastock();
        echo json_encode($products);
    }


    /*uji Coba Pilih Stock*/

    public function getnamastockid()
    {
        $products = $this->model_stock->getnamastockid();
        echo json_encode($products);
    }


    public function getstockValueById()
    {
        $product_id = $this->input->post('product_id');
        if ($product_id) {
            $product_data = $this->model_stock->getnamastockid($product_id);
            echo json_encode($product_data);
        }
    }


    public function fetchstockData()
    {

        $result = array('data' => array());
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
                $data = $this->model_stock->getstockDatabyoutlet($filter, $dari, $sampai);
            } else {
                $data = $this->model_stock->getstockDatabyall($dari, $sampai);
            }
        } else {
            if ($div == 11) {
                $store_id = $this->session->userdata['store_id'];
                $data = $this->model_stock->getstockDatabystoreid($store_id, $dari, $sampai);
            } else {
                $store_id = $this->session->userdata['store_id'];
                $data = $this->model_stock->getstockdiv($store_id, $div, $dari, $sampai);
            }
        }


        foreach ($data as $key => $value) {

            $buttons = '
            <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span></button>
            <ul class="dropdown-menu">';

            $buttons .= ' 
                          <li><a href="' . base_url('stock/update/' . $value['id']) . '" class="btn btn-default"><i class="fa fa-pencil"></i> Edit</a></li>
                       ';
            $buttons .= ' </ul>
            </div>';

            $div = $this->session->userdata('divisi');


            $produk_id = $value['produk_id'];
            $stock = $this->model_stock->getnamastockid($produk_id);
            if (isset($stock)) {
                if ($value['img']) {
                    $nama_produk = '<a target="_blank" href="' . base_url('uploads/stock/' . $value['img']) . '">' . $stock['nama_produk'] . '</a>';
                } else {
                    $nama_produk = $stock['nama_produk'];
                }
            } else {
                $nama_produk = 'tak diketahui';
            }

            if ($value['bagian'] == 1) {
                $bagian = 'Bar & Kasir';
            } elseif ($value['bagian'] == 2) {
                $bagian = 'Waiter';
            } elseif ($value['bagian'] == 3) {
                $bagian = 'Kitchen';
            };

            if ($value['status'] > 0) {
                $status = '+' . $value['status'];
            } elseif ($value['status'] < 0) {
                $status = $value['status'];
            } elseif ($value['status'] == 0) {
                $status = $value['status'];
            }

            if ($value['harga']) {
                $harga = $value['harga'];
            } else {
                $harga = '0';
            }
            $result['data'][$key] = array(

                $buttons,
                $value['store'],
                $bagian,
                $value['tgl'],
                $nama_produk,
                $harga . '/' . $value['uom'],
                $value['a_unit'],
                $value['t_unit'],
                $value['s_unit'],
                $value['unit'],
                $value['reg'],
                $status,
                $value['ket'],
            );
        } // /foreach

        echo json_encode($result);
    }


    /*
    Update
    */
    function compressImage($source, $destination, $quality)
    {
        // mendapatkan info image
        $imgInfo = getimagesize($source);
        $mime = $imgInfo['mime'];
        // membuat image baru
        switch ($mime) {
                // proses kode memilih tipe tipe image 
            case 'image/jpeg':
                $image = imagecreatefromjpeg($source);
                break;
            case 'image/png':
                $image = imagecreatefrompng($source);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($source);
                break;
            default:
                $image = imagecreatefromjpeg($source);
        }

        // Menyimpan image dengan ukuran yang baru
        imagejpeg($image, $destination, $quality);

        // Return image
        return $destination;
    }

    public function update($stock_id)
    {

        if (!$stock_id) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('t_unit', 'Unit', 'trim|required');

        if ($this->form_validation->run() == TRUE) {

            $user_id = $this->session->userdata('id');

            $unit = $this->input->post('a_unit');
            if ($unit) {
                $aunit = $this->input->post('a_unit');
            } else {
                $aunit = 0;
            }
            $u_terpakai = round($aunit + $this->input->post('t_unit') - $this->input->post('s_unit'), 1);

            $pemakaian = round($this->input->post('reg') - $u_terpakai, 1);

            $hrg = $this->input->post('harga');
            if ($hrg) {
                $harga = $this->input->post('harga');
            } else {
                $harga = '0';
            }

            if (!empty($_FILES['image']['name'])) {
                $file_name = rand();
                $config['upload_path']          = FCPATH . '/uploads/stock/';
                $config['allowed_types']        = 'gif|jpg|jpeg|png';
                $config['file_name']            = $file_name;
                $config['quality'] = '20%';

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('image')) {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('stock/update/' . $stock_id, 'refresh');
                } else {
                    $uploaded_data = $this->upload->data();

                    $data = array(
                        'user_id' => $user_id,
                        'a_unit' => $aunit,
                        't_unit' => $this->input->post('t_unit'),
                        's_unit' => $this->input->post('s_unit'),
                        'uom' => $this->input->post('satuan'),
                        'bagian' => $this->input->post('bagian'),
                        'harga' => $harga,
                        'unit' => $u_terpakai,
                        'reg' => $this->input->post('reg'),
                        'status' => $pemakaian,
                        'ket' => $this->input->post('ket'),
                        'img' => $uploaded_data['file_name']


                    );

                    $update = $this->model_stock->updatestock($data, $stock_id);
                    if ($update == true) {
                        $this->session->set_flashdata('success', 'Produk Diupdate');
                        redirect('stock/update/' . $stock_id, 'refresh');
                    } else {
                        $this->session->set_flashdata('error', 'Terjadi Kesalahan Update!!');
                        redirect('stock/update/' . $stock_id, 'refresh');
                    }
                }
            } else {

                $data = array(
                    'user_id' => $user_id,
                    'a_unit' => $aunit,
                    't_unit' => $this->input->post('t_unit'),
                    's_unit' => $this->input->post('s_unit'),
                    'uom' => $this->input->post('satuan'),
                    'bagian' => $this->input->post('bagian'),
                    'harga' => $harga,
                    'unit' => $u_terpakai,
                    'reg' => $this->input->post('reg'),
                    'status' => $pemakaian,
                    'ket' => $this->input->post('ket')


                );

                $update = $this->model_stock->updatestock($data, $stock_id);
                if ($update == true) {
                    $this->session->set_flashdata('success', 'Produk Diupdate');
                    redirect('stock/update/' . $stock_id, 'refresh');
                } else {
                    $this->session->set_flashdata('error', 'Terjadi Kesalahan Update!!');
                    redirect('stock/update/' . $stock_id, 'refresh');
                }
            }
        } else {


            $stock_data = $this->model_stock->getstockDatabyid($stock_id);

            $produk_id = $stock_data['produk_id'];
            $stock = $this->model_stock->getnamastockid($produk_id);
            $this->data['nama_produk'] = $stock['nama_produk'];
            $this->data['satuan'] = $stock['satuan'];
            $this->data['bagian'] = $stock['bagian'];
            $this->data['harga'] = $stock['harga'];

            $this->data['stock_data'] = $stock_data;
            $this->render_template('stock/edit', $this->data);
        }
    }


    /*
    * Hapus
    */
    public function remove()
    {
        if (!in_array('deletestock', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $stock_id = $this->input->post('stock_id');

        $response = array();
        if ($stock_id) {
            $delete = $this->model_stock->remove($stock_id);
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


    public function laporan()
    {
        if (!in_array('viewstock', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->data['store'] = $this->model_stores->getActiveStore();

        $this->render_template('stock/laporan', $this->data);
    }


    public function fetchstockDatabarang()
    {
        $result = array('data' => array());

        $user_id = $this->session->userdata('id');
        $store_id = $this->session->userdata('store_id');


        $div = $this->session->userdata['divisi'];
        if ($div == 0) {
            $data = $this->model_stock->getnamastockall();
        } else {
            if ($div == 11) {
                $store_id = $this->session->userdata['store_id'];
                $data = $this->model_stock->getnamastockstore($store_id);
            } else {
                $store_id = $this->session->userdata['store_id'];
                $data = $this->model_stock->getstocknamediv($store_id, $div);
            }
        }



        foreach ($data as $key => $value) {

            $dbbarang = $value['harga'] . $value['nama_produk'];

            $datav = $this->model_stock->produkstock($value['id']);
            if (isset($datav['harga']) or isset($datav['nama_produk'])) {
                $dbstock = $datav['harga'] . $datav['nama_produk'];
            } else {
                $dbstock = '';
            }


            // button

            $buttons = ' <div class="btn-group dropleft">
            			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span></button>
            			<ul class="dropdown-menu">';

            if (in_array('updatestock', $this->permission)) {
                $buttons .= '<li><a href="' . base_url('stock/databarangedit/' . $value['id']) . '"><i class="fa fa-pencil"></i> Edit</a></li>';
            }

            if (in_array('deletestock', $this->permission)) {
                $buttons .= '<li><a style="cursor:pointer;" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i> Hapus</a></li>';
            }


            if ($dbbarang == $dbstock) {
                $buttons .= '';
            } else {
                if (in_array('updatestock', $this->permission)) {
                    $buttons .= '<li> <a style="cursor:pointer;" onclick="uploadharga(' . $value['id'] . ')"   title="Update Harga, UOM & Category ke Stock"><i class="fa fa-upload"></i> Upload Harga</a></li>';
                }
            }
            $buttons .= '</ul></div>';



            $bagian = $value['bagian'];
            if ($bagian == 1) {
                $bg = "Bar & Kasir";
            } elseif ($bagian == 2) {
                $bg = "Waiter";
            } elseif ($bagian == 3) {
                $bg = "Dapur";
            }

            $ct = $value['kategori'];
            if ($ct == 1) {
                $kategori = "Bahan Baku";
            } elseif ($ct == 2) {
                $kategori = "Supply";
            } elseif ($ct == 3) {
                $kategori = "Perlengkapan";
            }
            $hasil_rupiah = "Rp " . number_format($value['harga'], 0, ',', '.');

            if ($div == 0) {
                if (in_array('updatestock', $this->permission)) {
                    if ($value['profit'] == 0) {
                        $profit = ' <a href="' . base_url('stock/keprofit/' . $value['id']) . '"   title="Jadikan Profit" class="btn btn-success"><i class="fa fa-upload"></i></a>';
                    } else {
                        $profit = ' <a href="' . base_url('stock/keluarprofit/' . $value['id']) . '"   title="Hapus Dari Profit" class="btn btn-danger"><i class="fa fa-close"></i></a>';
                    }
                }

                $result['data'][$key] = array(
                    $buttons,
                    $profit,
                    $value['nama_produk'],
                    $value['store'],
                    $kategori,
                    $hasil_rupiah,
                    $bg,
                    $value['satuan'],
                );
            } else {

                $result['data'][$key] = array(
                    $buttons,
                    $value['nama_produk'],
                    $value['store'],
                    $kategori,
                    $hasil_rupiah,
                    $bg,
                    $value['satuan'],
                );
            }
        } // /foreach

        echo json_encode($result);
    }



    public function getprodukid()
    {
        $produk_id =  $this->input->post('product_id');
        if ($produk_id) {
            $data = $this->model_stock->produkid($produk_id);
            $datav = $this->model_stock->getnamastockid($produk_id);
            foreach ($data as $key => $value) {

                if ($value['s_unit']) {
                    $sunit = $value['s_unit'];
                } else {
                    $sunit = '0';
                }

                $data = array('s_unit' => $sunit, 'harga' => $datav['harga']);
                echo json_encode($data);
            }
        }
    }


    public function databarangedit($id)
    {
        if (!in_array('updatestock', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->data['page_title'] = 'Edit Stock';

        $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'trim|required');


        if ($this->form_validation->run() == TRUE) {

            $user_id = $this->session->userdata('id');
            $data = array(
                'nama_produk' => $this->input->post('nama_produk'),
                'bagian' => $this->input->post('bagian'),
                'kategori' => $this->input->post('kategori'),
                'satuan' => $this->input->post('satuan'),
                'harga' => $this->input->post('harga'),
                'user_id' => $user_id,
            );

            $update = $this->model_stock->update($data, $id);
            if ($update == true) {
                $this->session->set_flashdata('success', 'Produk "' . $this->input->post('nama_produk') . '" Diedit');
                redirect('stock/databarang', 'refresh');
            } else {
                $this->session->set_flashdata('error', 'Terjadi Kesalahan!!');
                redirect('stock/databarang' . $id, 'refresh');
            }
        } else {
            $this->data['data'] = $this->model_stock->getnamastockid($id);
            $this->render_template('stock/databarangedit', $this->data);
        }
    }

    public function removedb()
    {
        if (!in_array('deletestock', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $id = $this->input->post('id');

        $response = array();
        if ($id) {
            $delete = $this->model_stock->removedb($id);
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

    public function akexcel()
    {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getProperties()
            ->setCreator("Fembi Nur Ilham")
            ->setLastModifiedBy("Fembi Nur Ilham")
            ->setTitle("Laporan Stock")
            ->setSubject("Hasil Export Dari PRS System")
            ->setDescription("Semoga Terbantu Dengan Adanya Ini")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Stock");


        $spreadsheet->getActiveSheet()->mergeCells('A4:A5');
        $spreadsheet->getActiveSheet()->mergeCells('B4:B5');
        $spreadsheet->getActiveSheet()->mergeCells('C4:F4');
        $spreadsheet->getActiveSheet()->mergeCells('G4:J4');
        $spreadsheet->getActiveSheet()->mergeCells('K4:N4');
        $spreadsheet->getActiveSheet()->mergeCells('O4:R4');
        $spreadsheet->getActiveSheet()->mergeCells('S4:U4');

        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('V')->setAutoSize(true);

        $sheet->setCellValue('A4', 'No');
        $sheet->setCellValue('B4', 'Nama Produk');
        $sheet->setCellValue('C4', 'Awal');
        $sheet->setCellValue('G4', '+');
        $sheet->setCellValue('K4', 'Sisa');
        $sheet->setCellValue('O4', 'Terpakai');
        $sheet->setCellValue('S4', 'Register');

        $sheet->setCellValue('C5', 'Unit');
        $sheet->setCellValue('D5', 'UOM');
        $sheet->setCellValue('E5', 'Harga');
        $sheet->setCellValue('F5', 'Nominal');
        $sheet->setCellValue('G5', 'Unit');
        $sheet->setCellValue('H5', 'UOM');
        $sheet->setCellValue('I5', 'Harga');
        $sheet->setCellValue('J5', 'Nominal');
        $sheet->setCellValue('K5', 'Unit');
        $sheet->setCellValue('L5', 'UOM');
        $sheet->setCellValue('M5', 'Harga');
        $sheet->setCellValue('N5', 'Nominal');
        $sheet->setCellValue('O5', 'Unit');
        $sheet->setCellValue('P5', 'UOM');
        $sheet->setCellValue('Q5', 'Harga');
        $sheet->setCellValue('R5', 'Nominal');
        $sheet->setCellValue('S5', 'Reg');
        $sheet->setCellValue('T5', 'UOM');
        $sheet->setCellValue('U5', 'Pemakaian');
        $sheet->setCellValue('V5', 'Bagian');


        $store_id = $this->input->post('outlet');
        $bagian = $this->input->post('bagian');


        $settgl_awal = $this->input->post('tgl_awal');
        $settgl_akhir = $this->input->post('tgl_akhir');

        $tgl_awal = date("Y-m-d", strtotime($settgl_awal));
        $tgl_akhir = date("Y-m-d", strtotime($settgl_akhir));

        $tgl_awal1 = date("Y-m-d", strtotime($settgl_awal));
        $tgl_akhir1 = date("Y-m-d", strtotime($settgl_akhir));


        $data = $this->model_stock->nama_produk($store_id, $bagian, $tgl_awal, $tgl_akhir);

        if ($store_id) {
            $store = $this->model_stores->getStoresData($store_id);
            $outletfile = $store['name'];
        } else {
            $outletfile = "SELURUH";
        }
        $filename = "LAPORAN STOCK AKUMALASI " . $outletfile . " DARI " . $tgl_awal . " SAMPAI " . $tgl_akhir . ".xlsx";
        $ket = "Laporan Stock Akumulasi " . $outletfile . " Dari " . $tgl_awal . " Sampai " . $tgl_akhir;


        $baris = 6;
        $no = 1;

        if ($data) {
            foreach ($data as $key => $value) {


                //nama produk
                $produk_id = $value['produk_id'];
                $stock = $this->model_stock->getnamastockid($produk_id);
                if (isset($stock['nama_produk'])) {
                    $nama_produk = $stock['nama_produk'];
                } else {
                    $nama_produk = $value['produk_id'] . ' Tidak diketahui';
                }


                //unit
                $an = $this->model_stock->a_unit($produk_id, $store_id, $bagian, $tgl_awal1, $tgl_akhir1);
                $a_unit = $an['a_unit'];

                $t = $this->model_stock->t_unit($produk_id, $store_id, $bagian, $tgl_awal1, $tgl_akhir1);
                $t_unit = round($t['sum(t_unit)'], 1);

                $s = $this->model_stock->s_unit($produk_id, $store_id, $bagian, $tgl_awal1, $tgl_akhir1);
                $s_unit = $s['s_unit'];

                $up = $this->model_stock->unit($produk_id, $store_id, $bagian, $tgl_awal1, $tgl_akhir1);
                $p_unit = round($up['sum(unit)'], 1);

                $pk = $this->model_stock->pakai($produk_id, $store_id, $bagian, $tgl_awal1, $tgl_akhir1);
                $pakai = round($pk['sum(status)'], 1);

                //UOM
                $um = $this->model_stock->uom($produk_id, $store_id, $bagian, $tgl_awal1, $tgl_akhir1);
                $uom = $um['0']['uom'];

                //harga
                $hr = $this->model_stock->harga($produk_id, $store_id, $bagian, $tgl_awal1, $tgl_akhir1);
                $harga = $hr['0']['harga'];

                //reg
                $rg = $this->model_stock->reg($produk_id, $store_id, $bagian, $tgl_awal1, $tgl_akhir1);
                $reg = round($rg['sum(reg)'], 1);



                //Nom
                if ($harga) {
                    $hrg = $harga;
                } else {
                    $hrg = 0;
                };
                if ($a_unit) {
                    $aunit = $a_unit;
                } else {
                    $aunit = 0;
                };
                if ($t_unit) {
                    $tunit = $t_unit;
                } else {
                    $tunit = 0;
                };
                if ($s_unit) {
                    $sunit = $s_unit;
                } else {
                    $sunit = 0;
                };
                if ($p_unit) {
                    $punit = $p_unit;
                } else {
                    $punit = 0;
                };

                if (isset($stock['bagian'])) {
                    if ($stock['bagian'] == 1) {
                        $bg = 'Bar & Kasir';
                    }
                    if ($stock['bagian'] == 2) {
                        $bg = 'Waiter';
                    }
                    if ($stock['bagian'] == 3) {
                        $bg = 'Kitchen';
                    }
                } else {
                    $bg = 'Tidak diketahui';
                }
                $nom_a = round($aunit * $hrg, 1);
                $nom_t = round($tunit * $hrg, 1);
                $nom_s = round($sunit * $hrg, 1);
                $nom_p = round($punit * $hrg, 1);


                $sheet->setCellValue('A1', 'LAPORAN STOCK AKUMULASI ' . $outletfile);
                $sheet->setCellValue('A2', $ket);
                $sheet->setCellValue('A' . $baris, $no++);
                $sheet->setCellValue('B' . $baris, $nama_produk);
                $sheet->setCellValue('C' . $baris, $aunit);
                $sheet->setCellValue('D' . $baris, $uom);
                $sheet->setCellValue('E' . $baris, $hrg);
                $sheet->setCellValue('F' . $baris, $nom_a);
                $sheet->setCellValue('G' . $baris, $tunit);
                $sheet->setCellValue('H' . $baris, $uom);
                $sheet->setCellValue('I' . $baris, $hrg);
                $sheet->setCellValue('J' . $baris, $nom_t);
                $sheet->setCellValue('K' . $baris, $sunit);
                $sheet->setCellValue('L' . $baris, $uom);
                $sheet->setCellValue('M' . $baris, $hrg);
                $sheet->setCellValue('N' . $baris, $nom_s);
                $sheet->setCellValue('O' . $baris, $punit);
                $sheet->setCellValue('P' . $baris, $uom);
                $sheet->setCellValue('Q' . $baris, $hrg);
                $sheet->setCellValue('R' . $baris, $nom_p);
                $sheet->setCellValue('S' . $baris, $reg);
                $sheet->setCellValue('T' . $baris, $uom);
                $sheet->setCellValue('U' . $baris, $pakai);
                $sheet->setCellValue('V' . $baris, $bg);

                $baris++;
            }

            $ket = $this->model_stock->ket($store_id, $bagian, $tgl_awal1, $tgl_akhir1);
            $number1 = count($data) + 7;
            $sheet->setCellValue('A' . $number1, 'Keterangan :');
            $number = count($data) + 8;
            foreach ($ket as $key => $value) {
                //nama produk
                $produk_id = $value['produk_id'];
                $stock = $this->model_stock->getnamastockid($produk_id);
                if (isset($stock['nama_produk'])) {
                    $nama_produk = $stock['nama_produk'];
                } else {
                    $nama_produk = $value['produk_id'] . ' Tidak diketahui';
                }

                if ($value['ket']) {

                    $sheet->setCellValue('A' . $number, $value['tgl']);
                    $sheet->setCellValue('B' . $number, $nama_produk);
                    $sheet->setCellValue('C' . $number, $value['ket']);
                    $number++;
                }
            }


            $writer = new Xlsx($spreadsheet);
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Content-Type: application/vnd.ms-excel');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        } else {

            $this->session->set_flashdata('error', 'Data Tidak Ditemukan');
            redirect('stock/laporan', 'refresh');
        }
    }


    public function export()
    {

        if ($_POST) {
            $store_id = $this->input->post('outlet');
            $divisi = $this->input->post('bagian');

            //akun office
            $tglawal = $this->input->post('tglawal');
            $tglakhir = $this->input->post('tglakhir');

            if ($tglawal && $tglakhir) {
                $var = date('Y/m/d', strtotime($tglawal)) . ' - ' . date('Y/m/d', strtotime($tglakhir));
            } else {
                $var = $this->input->post('tgl');
            }

            $tgl = str_replace('/', '-', $var);
            $hasil = explode(" - ", $tgl);
            $tgl_awal = date('Y-m-d', strtotime($hasil[0]));
            $tgl_akhir = date('Y-m-d', strtotime($hasil[1]));
        } else {
            redirect('stock', 'refresh');
        }


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getProperties()
            ->setCreator("Fembi Nur Ilham")
            ->setLastModifiedBy("Fembi Nur Ilham")
            ->setTitle("Laporan Stock")
            ->setSubject("Hasil Export Dari PRS System")
            ->setDescription("Semoga Terbantu Dengan Adanya Ini")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Stock");


        $spreadsheet->getActiveSheet()->mergeCells('A4:A5');
        $spreadsheet->getActiveSheet()->mergeCells('B4:B5');
        $spreadsheet->getActiveSheet()->mergeCells('C4:F4');
        $spreadsheet->getActiveSheet()->mergeCells('G4:J4');
        $spreadsheet->getActiveSheet()->mergeCells('K4:N4');
        $spreadsheet->getActiveSheet()->mergeCells('O4:R4');
        $spreadsheet->getActiveSheet()->mergeCells('S4:U4');

        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('V')->setAutoSize(true);

        $sheet->setCellValue('A4', 'Tanggal');
        $sheet->setCellValue('B4', 'Nama Produk');
        $sheet->setCellValue('C4', 'Awal');
        $sheet->setCellValue('G4', '+');
        $sheet->setCellValue('K4', 'Sisa');
        $sheet->setCellValue('O4', 'Terpakai');
        $sheet->setCellValue('S4', 'Register');

        $sheet->setCellValue('C5', 'Unit');
        $sheet->setCellValue('D5', 'UOM');
        $sheet->setCellValue('E5', 'Harga');
        $sheet->setCellValue('F5', 'Nominal');
        $sheet->setCellValue('G5', 'Unit');
        $sheet->setCellValue('H5', 'UOM');
        $sheet->setCellValue('I5', 'Harga');
        $sheet->setCellValue('J5', 'Nominal');
        $sheet->setCellValue('K5', 'Unit');
        $sheet->setCellValue('L5', 'UOM');
        $sheet->setCellValue('M5', 'Harga');
        $sheet->setCellValue('N5', 'Nominal');
        $sheet->setCellValue('O5', 'Unit');
        $sheet->setCellValue('P5', 'UOM');
        $sheet->setCellValue('Q5', 'Harga');
        $sheet->setCellValue('R5', 'Nominal');
        $sheet->setCellValue('S5', 'Reg');
        $sheet->setCellValue('T5', 'UOM');
        $sheet->setCellValue('U5', 'Pemakaian');
        $sheet->setCellValue('V5', 'Keterangan');
        $sheet->setCellValue('W5', 'Divisi');

        $data = $this->model_stock->view_data3($divisi, $store_id, $tgl_awal, $tgl_akhir);

        if ($store_id) {
            $store = $this->model_stores->getStoresData($store_id);
            $outletfile = $store['name'];
        } else {
            $outletfile = "SELURUH";
        }
        $filename = "LAPORAN STOCK " . $outletfile . " DARI " . $tgl_awal . " SAMPAI " . $tgl_akhir . ".xlsx";
        $ket = "Laporan Stock " . $outletfile . " Dari " . $tgl_awal . " Sampai " . $tgl_akhir;

        $baris = 6;

        if ($data) {
            foreach ($data as $key => $value) {

                $produk_id = $value['produk_id'];
                $stock = $this->model_stock->getnamastockid($produk_id);
                if (isset($stock['nama_produk'])) {
                    $nama_produk = $stock['nama_produk'];
                } else {
                    $nama_produk = $value['produk_id'] . ' Tidak diketahui';
                }

                if ($value['bagian'] == 1) {
                    $bagian = 'Bar & Kasir';
                } elseif ($value['bagian'] == 2) {
                    $bagian = 'Waiter';
                } elseif ($value['bagian'] == 3) {
                    $bagian = 'Kitchen';
                };

                if ($value['status'] > 0) {
                    $status = '+' . $value['status'];
                } elseif ($value['status'] < 0) {
                    $status = $value['status'];
                } elseif ($value['status'] == 0) {
                    $status = $value['status'];
                }

                if ($value['harga']) {
                    $harga = $value['harga'];
                } else {
                    $harga = 0;
                }


                $a = $value['a_unit'] * $harga;
                $t = $value['t_unit'] * $harga;
                $s = $value['s_unit'] * $harga;
                $u = $value['unit'] * $harga;


                $sheet->setCellValue('A1', 'LAPORAN STOCK ' . $outletfile);
                $sheet->setCellValue('A2', $ket);
                $sheet->setCellValue('A' . $baris, $value['tgl']);
                $sheet->setCellValue('B' . $baris, $nama_produk);
                $sheet->setCellValue('C' . $baris, $value['a_unit']);
                $sheet->setCellValue('D' . $baris, $value['uom']);
                $sheet->setCellValue('E' . $baris, $harga);
                $sheet->setCellValue('F' . $baris, $a);
                $sheet->setCellValue('G' . $baris, $value['t_unit']);
                $sheet->setCellValue('H' . $baris, $value['uom']);
                $sheet->setCellValue('I' . $baris, $harga);
                $sheet->setCellValue('J' . $baris, $t);
                $sheet->setCellValue('K' . $baris, $value['s_unit']);
                $sheet->setCellValue('L' . $baris, $value['uom']);
                $sheet->setCellValue('M' . $baris, $harga);
                $sheet->setCellValue('N' . $baris, $s);
                $sheet->setCellValue('O' . $baris, $value['unit']);
                $sheet->setCellValue('P' . $baris, $value['uom']);
                $sheet->setCellValue('Q' . $baris, $harga);
                $sheet->setCellValue('R' . $baris, $u);
                $sheet->setCellValue('S' . $baris, $value['reg']);
                $sheet->setCellValue('T' . $baris, $value['uom']);
                $sheet->setCellValue('U' . $baris, $status);
                $sheet->setCellValue('V' . $baris, $value['ket']);
                $sheet->setCellValue('W' . $baris, $bagian);

                $baris++;
            }

            $writer = new Xlsx($spreadsheet);
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Content-Type: application/vnd.ms-excel');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        } else {
            //$this->session->set_flashdata('error', 'Data Tidak Ditemukan');
            //redirect('stock/laporan', 'refresh');
        }
    }


    public function view_akm()
    {

        if (isset($_POST['cari'])) {

            $tgl_awal = $this->input->post('tgl_awal');
            $tgl_akhir = $this->input->post('tgl_akhir');
            $outlet = $this->input->post('outlet');
            $bagian = $this->input->post('bagian');
            $this->data['tgl_awal1'] = $tgl_awal;
            $this->data['tgl_akhir1'] = $tgl_akhir;

            if ($tgl_awal && $tgl_akhir && $outlet && $bagian) {
                $this->data['data']  = $this->model_stock->view_akm($outlet, $tgl_awal, $tgl_akhir);
            } else {
                $this->data['data']  = array();
            }
            $this->load->view('stock/data_akumu', $this->data);
        } else {
            echo "Silahkan Cek koneksi internet Anda!";
        }
    }


    public function view_audit()
    {

        if (isset($_POST['cari'])) {
            $tgl_awal = $this->input->post('tgl_awal');
            $tgl_akhir = $this->input->post('tgl_akhir');
            $outlet = $this->input->post('outlet');
            $bagian = $this->input->post('bagian');
            $this->data['tgl_awal1'] = $tgl_awal;
            $this->data['tgl_akhir1'] = $tgl_akhir;

            if ($tgl_awal && $tgl_akhir && $outlet && $bagian) {
                $this->data['data1']  = $this->model_stock->view_audit($bagian, $outlet, $tgl_awal, $tgl_akhir);
            } else {
                $this->data['data1']  = array();
            }
            $this->load->view('stock/data_audit', $this->data);
        } else {
            echo "Silahkan Cek koneksi internet Anda!";
        }
    }


    public function tambah()
    {

        $this->data['page_title'] = 'Tambah Stock';

        $this->form_validation->set_rules('product', 'Nama Produk', 'trim|required');
        $this->form_validation->set_rules('tgl', 'Tanggal', 'trim|required');


        if ($this->form_validation->run() == TRUE) {

            $user_id = $this->session->userdata('id');

            $idproduct = $this->input->post('product');


            $datastock = $this->model_stock->produkid($idproduct);
            if ($datastock['s_unit']) {
                $a_unit = $datastock['s_unit'];
            } else {
                $a_unit = '0';
            }

            $databarang = $this->model_stock->getnamastockid($idproduct);
            if ($databarang['harga']) {
                $harga = $databarang['harga'];
            } else {
                $harga = 0;
            }
            $uom = $databarang['satuan'];
            $store = $databarang['store'];
            $kategori = $databarang['kategori'];



            $t_unit = $this->input->post('t_unit');
            $s_unit = $this->input->post('s_unit');

            $reg = $this->input->post('reg');


            $unit = round($a_unit + $t_unit - $s_unit, 1);

            if ($a_unit) {
                $a_nom = $a_unit * $harga;
            } else {
                $a_nom = '0';
            }

            if ($t_unit) {
                $t_nom = $t_unit * $harga;
            } else {
                $t_nom = '0';
            }

            if ($s_unit) {
                $s_nom = $s_unit * $harga;
            } else {
                $s_nom = '0';
            }

            if ($unit) {
                $nom_u = $unit * $harga;
            } else {
                $nom_u = '0';
            }


            if ($reg) {
                $pemakaian = round($reg - $unit, 1);
            } else {
                $pemakaian = '0';
            }

            $sama = $this->input->post('tgl') . $this->input->post('product');
            $samadb = $this->model_stock->validasisama($this->input->post('product'), $this->input->post('tgl'));

            if ($samadb) {
                $datastock = $samadb['tgl'] . $samadb['produk_id'];
            } else {
                $datastock = '';
            }

            if ($sama == $datastock) {
                $this->session->set_flashdata('error', 'Data Telah Ada!! Tanggal & Nama Barang telah di input');
                redirect('stock/tambah', 'refresh');
            } else {

                $data = array(
                    'user_id' => $user_id,
                    'store_id' =>  $this->input->post('store_id'),
                    'store' => $store,
                    'bagian' => $this->input->post('bagian'),
                    'kategori' => $kategori,
                    'produk_id' => $this->input->post('product'),
                    'a_unit' => $a_unit,
                    'a_nom' => $a_nom,
                    't_unit' => $this->input->post('t_unit'),
                    't_nom' => $t_nom,
                    's_unit' => $this->input->post('s_unit'),
                    's_nom' => $s_nom,
                    'unit' => $unit,
                    'uom' => $uom,
                    'harga' => $harga,
                    'nom' => $nom_u,
                    'reg' => $this->input->post('reg'),
                    'status' => $pemakaian,
                    'tgl' =>  $this->input->post('tgl'),
                );

                $create = $this->model_stock->createstock($data);
            }


            if ($create == true) {
                $this->session->set_flashdata('success', 'Data Barang Ditambahkan');
                redirect('stock/tambah', 'refresh');
            } else {
                $this->session->set_flashdata('error', 'Terjadi Kesalahan Penambahan!!');
                redirect('stock/tambah', 'refresh');
            }
        } else {

            $this->data['store'] = $this->model_stores->getActiveStore();
            $this->render_template('stock/tambah', $this->data);
        }
    }


    public function pdf()
    {


        $store = $this->session->userdata('store');
        $store_id = $this->session->userdata('store_id');
        $divisi = $this->input->post('divisi');
        $tglawal = $this->input->post('tglawal');
        $tglakhir = $this->input->post('tglakhir');
        $data = $this->model_stock->view_data3($divisi, $store_id, $tglawal, $tglakhir);

        $filename = "Laporan Stock " . $store . " Dari " . $tglawal . " Sampai " . $tglakhir . ".pdf";

        $pdf = new FPDF('L', 'mm', 'A4');

        $pdf->AddPage();
        $pdf->SetLeftMargin(15);

        $pdf->SetFont('Times', 'B', 16);
        $pdf->Image('https://wellthefood.com/wp-content/uploads/2020/08/prs.png', 10, 10, 40, 0, 'PNG');
        $pdf->Cell(0, 7, 'Laporan Stock ' . $store, 0, 1, 'C');


        $pdf->SetFont('Times', 'B', 14);
        if ($divisi == 1) {
            $bagian = 'Bar & Kasir';
        } elseif ($divisi == 2) {
            $bagian = 'Waiter';
        } elseif ($divisi == 3) {
            $bagian = 'Dapur';
        }

        $pdf->Cell(0, 7, 'Divisi ' . $bagian, 0, 1, 'C');
        $pdf->Cell(0, 7, 'Laporan Dari Tanggal ' . date("d M", strtotime($tglawal)) . ' Sampai ' . date("d M Y", strtotime($tglakhir)), 0, 1, 'C');

        $pdf->Cell(10, 7, '', 0, 1);

        $pdf->SetFont('Times', 'B', 8);

        $pdf->Cell(110, 6, 'Data', 1, 0, 'C');
        $pdf->Cell(31, 6, 'Awal', 1, 0, 'C');
        $pdf->Cell(31, 6, 'Masuk', 1, 0, 'C');
        $pdf->Cell(31, 6, 'Sisa', 1, 0, 'C');
        $pdf->Cell(31, 6, 'Terpakai', 1, 0, 'C');
        $pdf->Cell(31, 6, 'Register', 1, 1, 'C');

        $pdf->Cell(7, 6, 'No', 1, 0, 'C');
        $pdf->Cell(25, 6, 'Divisi', 1, 0, 'C');
        $pdf->Cell(18, 6, 'Tanggal', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Nama Produk', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Rp/UOM', 1, 0, 'C');

        $pdf->Cell(11, 6, 'Unit', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Jumlah', 1, 0, 'C');

        $pdf->Cell(11, 6, 'Unit', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Jumlah', 1, 0, 'C');

        $pdf->Cell(11, 6, 'Unit', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Jumlah', 1, 0, 'C');

        $pdf->Cell(11, 6, 'Pakai', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Jumlah', 1, 0, 'C');

        $pdf->Cell(11, 6, 'Reg', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Status', 1, 1, 'C');

        $pdf->SetFont('Times', '', 8);


        $no = 1;

        if ($data) {
            foreach ($data as $key => $value) {

                $produk_id = $value['produk_id'];
                $stock = $this->model_stock->getnamastockid($produk_id);
                $nama_produk = $stock['nama_produk'];

                if ($value['bagian'] == 1) {
                    $bagian = 'Bar & Kasir';
                } elseif ($value['bagian'] == 2) {
                    $bagian = 'Waiter';
                } elseif ($value['bagian'] == 3) {
                    $bagian = 'Kitchen';
                };

                if ($value['status'] > 0) {
                    $status = '+' . $value['status'];
                } elseif ($value['status'] < 0) {
                    $status = $value['status'];
                } elseif ($value['status'] == 0) {
                    $status = $value['status'];
                }

                if ($value['harga']) {
                    $harga = $value['harga'];
                } else {
                    $harga = 0;
                }


                $a = $value['a_unit'] * $harga;
                $t = $value['t_unit'] * $harga;
                $s = $value['s_unit'] * $harga;
                $u = $value['unit'] * $harga;

                $pdf->Cell(7, 6, $no, 1, 0, 'C');
                $pdf->Cell(25, 6, $bagian, 1, 0);
                $pdf->Cell(18, 6, $value['tgl'], 1, 0);
                $pdf->Cell(40, 6, $nama_produk, 1, 0);
                $pdf->Cell(20, 6, "Rp " . number_format($harga, 0, ',', '.') . '/' . $value['uom'], 1, 0);

                $pdf->Cell(11, 6, $value['a_unit'], 1, 0);
                $pdf->Cell(20, 6, $a, 1, 0);

                $pdf->Cell(11, 6, $value['t_unit'], 1, 0);
                $pdf->Cell(20, 6, $t, 1, 0);

                $pdf->Cell(11, 6, $value['s_unit'], 1, 0);
                $pdf->Cell(20, 6, $s, 1, 0);

                $pdf->Cell(11, 6, $value['unit'], 1, 0);
                $pdf->Cell(20, 6, $u, 1, 0);

                $pdf->Cell(11, 6, $value['reg'], 1, 0);
                $pdf->Cell(20, 6, $status, 1, 1);

                $no++;
            }

            $pdf->Cell(10, 7, '', 0, 1);
            $pdf->Cell(10, 7, '', 0, 1);
            $pdf->Cell(0, 7, 'Keterangan :', 0, 1);
            foreach ($data as $key => $value) {

                $produk_id = $value['produk_id'];
                $stock = $this->model_stock->getnamastockid($produk_id);
                $nama_produk = $stock['nama_produk'];
                if ($value['ket']) {
                    $pdf->Cell(18, 7, $value['tgl'], 0, 0);
                    $pdf->Cell(40, 7, $nama_produk, 0, 0);
                    $pdf->Cell(0, 7, $value['ket'], 0, 1);
                }
            }
        } else {
            $this->session->set_flashdata('error', 'Maaf... Data Tidak Ada');
            redirect('stock/laporanstore', 'refresh');
        }


        $pdf->Output('D', $filename);
    }


    public function pdfhari()
    {


        $store = $this->session->userdata('store');
        $store_id = $this->session->userdata('store_id');
        $divisi = $this->input->post('divisi2');
        $date = $this->input->post('date');
        $data = $this->model_stock->view_data($date, $store_id, $divisi);
        $filename = "Laporan Stock " . $store . " Tanggal " . $date . ".pdf";

        $pdf = new FPDF('L', 'mm', 'A4');

        $pdf->AddPage();
        $pdf->SetLeftMargin(15);

        $pdf->SetFont('Times', 'B', 16);
        $pdf->Image('https://wellthefood.com/wp-content/uploads/2020/08/prs.png', 10, 10, 40, 0, 'PNG');
        $pdf->Cell(0, 7, 'Laporan Stock ' . $store, 0, 1, 'C');


        $pdf->SetFont('Times', 'B', 14);
        if ($divisi == 1) {
            $bagian = 'Bar & Kasir';
        } elseif ($divisi == 2) {
            $bagian = 'Waiter';
        } elseif ($divisi == 3) {
            $bagian = 'Dapur';
        }

        $pdf->Cell(0, 7, 'Divisi ' . $bagian, 0, 1, 'C');
        $pdf->Cell(0, 7, 'Laporan Tanggal ' . date("d M Y", strtotime($date)), 0, 1, 'C');

        $pdf->Cell(10, 7, '', 0, 1);

        $pdf->SetFont('Times', 'B', 8);

        $pdf->Cell(110, 6, 'Data', 1, 0, 'C');
        $pdf->Cell(31, 6, 'Awal', 1, 0, 'C');
        $pdf->Cell(31, 6, 'Masuk', 1, 0, 'C');
        $pdf->Cell(31, 6, 'Sisa', 1, 0, 'C');
        $pdf->Cell(31, 6, 'Terpakai', 1, 0, 'C');
        $pdf->Cell(31, 6, 'Register', 1, 1, 'C');

        $pdf->Cell(7, 6, 'No', 1, 0, 'C');
        $pdf->Cell(25, 6, 'Divisi', 1, 0, 'C');
        $pdf->Cell(18, 6, 'Tanggal', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Nama Produk', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Rp/UOM', 1, 0, 'C');

        $pdf->Cell(11, 6, 'Unit', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Jumlah', 1, 0, 'C');

        $pdf->Cell(11, 6, 'Unit', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Jumlah', 1, 0, 'C');

        $pdf->Cell(11, 6, 'Unit', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Jumlah', 1, 0, 'C');

        $pdf->Cell(11, 6, 'Pakai', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Jumlah', 1, 0, 'C');

        $pdf->Cell(11, 6, 'Reg', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Status', 1, 1, 'C');

        $pdf->SetFont('Times', '', 8);


        $no = 1;

        if ($data) {
            foreach ($data as $key => $value) {

                $produk_id = $value['produk_id'];
                $stock = $this->model_stock->getnamastockid($produk_id);
                $nama_produk = $stock['nama_produk'];

                if ($value['bagian'] == 1) {
                    $bagian = 'Bar & Kasir';
                } elseif ($value['bagian'] == 2) {
                    $bagian = 'Waiter';
                } elseif ($value['bagian'] == 3) {
                    $bagian = 'Kitchen';
                };

                if ($value['status'] > 0) {
                    $status = '+' . $value['status'];
                } elseif ($value['status'] < 0) {
                    $status = $value['status'];
                } elseif ($value['status'] == 0) {
                    $status = $value['status'];
                }

                if ($value['harga']) {
                    $harga = $value['harga'];
                } else {
                    $harga = 0;
                }


                $a = $value['a_unit'] * $harga;
                $t = $value['t_unit'] * $harga;
                $s = $value['s_unit'] * $harga;
                $u = $value['unit'] * $harga;

                $pdf->Cell(7, 6, $no, 1, 0, 'C');
                $pdf->Cell(25, 6, $bagian, 1, 0);
                $pdf->Cell(18, 6, $value['tgl'], 1, 0);
                $pdf->Cell(40, 6, $nama_produk, 1, 0);
                $pdf->Cell(20, 6, $harga . '/' . $value['uom'], 1, 0);

                $pdf->Cell(11, 6, $value['a_unit'], 1, 0);
                $pdf->Cell(20, 6, $a, 1, 0);

                $pdf->Cell(11, 6, $value['t_unit'], 1, 0);
                $pdf->Cell(20, 6, $t, 1, 0);

                $pdf->Cell(11, 6, $value['s_unit'], 1, 0);
                $pdf->Cell(20, 6, $s, 1, 0);

                $pdf->Cell(11, 6, $value['unit'], 1, 0);
                $pdf->Cell(20, 6, $u, 1, 0);

                $pdf->Cell(11, 6, $value['reg'], 1, 0);
                $pdf->Cell(20, 6, $status, 1, 1);

                $no++;
            }


            $pdf->Cell(10, 7, '', 0, 1);
            $pdf->Cell(10, 7, '', 0, 1);
            $pdf->Cell(0, 7, 'Keterangan :', 0, 1);
            $pdf->Cell(18, 7, 'Tanggal', 1, 0);
            $pdf->Cell(40, 7, 'Nama Produk', 1, 0);
            $pdf->Cell(209, 7, 'Ket', 1, 1);
            foreach ($data as $key => $value) {

                $produk_id = $value['produk_id'];
                $stock = $this->model_stock->getnamastockid($produk_id);
                $nama_produk = $stock['nama_produk'];
                if ($value['ket']) {
                    $pdf->Cell(18, 7, $value['tgl'], 1, 0);
                    $pdf->Cell(40, 7, $nama_produk, 1, 0);
                    $pdf->Cell(209, 7, $value['ket'], 1, 1);
                }
            }
        } else {
            $this->session->set_flashdata('error', 'Maaf... Data Tidak Ada');
            redirect('stock/laporanstore', 'refresh');
        }



        $pdf->Output('D', $filename);
    }

    public function laporanstore()
    {

        if (!in_array('viewstock', $this->permission)) {
            redirect('dashboard', 'refresh');
        }


        $this->render_template('stock/laporanstore', $this->data);
    }

    public function uploadkestock($id)
    {

        $user_id = $this->session->userdata('id');
        $store_id = $this->session->userdata('store_id');
        $store = $this->session->userdata('store');

        $databarang = $this->model_stock->getnamastockid($id);
        $nama_produk = $databarang['nama_produk'];
        $harga = $databarang['harga'];
        $uom = $databarang['satuan'];
        $kategori = $databarang['kategori'];

        if ($harga == 0) {
            $this->session->set_flashdata('error', 'Harga Harus Terisi!!');
            redirect('stock/databarang', 'refresh');
        } else {

            $data = array(
                'nama_produk' => $nama_produk,
                'harga' => $harga,
                'uom' => $uom,
                'kategori' => $kategori,
            );

            $update = $this->model_stock->updatestockperproduk($data, $id);
            if ($update == true) {
                $this->session->set_flashdata('success', '"' . $nama_produk . '" Telah Masuk Ke Stock');
                redirect('stock/databarang', 'refresh');
            } else {
                $this->session->set_flashdata('error', 'Terjadi Kesalahan!!');
                redirect('stock/databarang', 'refresh');
            }
        }
    }

    public function keprofit($id)
    {


        $databarang = $this->model_stock->getnamastockid($id);
        $nama_produk = $databarang['nama_produk'];

        $data = array(
            'profit' => 1,
        );

        $update = $this->model_stock->update($data, $id);
        if ($update == true) {
            $this->session->set_flashdata('success', 'Produk ' . $nama_produk . ' Telah Masuk Kedaftar Profit');
            redirect('stock/databarang', 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Terjadi Kesalahan!!');
            redirect('stock/databarang', 'refresh');
        }
    }

    public function keluarprofit($id)
    {


        $databarang = $this->model_stock->getnamastockid($id);
        $nama_produk = $databarang['nama_produk'];

        $data = array(
            'profit' => 0,
        );

        $update = $this->model_stock->update($data, $id);
        if ($update == true) {
            $this->session->set_flashdata('success', 'Produk ' . $nama_produk . ' Telah dihapus dari daftar Profit');
            redirect('stock/databarang', 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Terjadi Kesalahan!!');
            redirect('stock/databarang', 'refresh');
        }
    }
}
