<?php

defined('BASEPATH') or exit('No direct script access allowed');

require('./assets/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Orders extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Orders';

		$this->load->model('model_orders');
		$this->load->model('model_users');
		$this->load->model('model_products');
		$this->load->model('model_company');
		$this->load->model('model_stores');


		//jam order
		$timezone = new DateTimeZone('Asia/Jakarta');
		$date = new DateTime();
		$date->setTimeZone($timezone);
		$this->data['sekarang'] = $date->format('H:i');

		$this->data['mulai'] = '09:00';
		//$this->data['mulai'] = '18:00';
		$this->data['sampai'] = '05:00';
	}

	//Manage
	public function index()
	{
		if (!in_array('viewOrder', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		$user_id = $this->session->userdata('id');
		$user_data = $this->model_users->getUserData($user_id);
		$lihat = $user_data['group_id'];
		if ($lihat == 2) {
			$this->data['notif'] = $this->model_orders->upbaca(1);
		}
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

		$this->data['store'] = $this->model_stores->getStoresoutlet();
		$this->data['page_title'] = 'Manage Orders';
		$this->data['div'] = $this->session->userdata('divisi');
		$this->data['namastore'] = $this->session->userdata('store');
		$this->render_template('orders/index', $this->data);
	}

	public function fetchOrdersData()
	{
		$div = $this->session->userdata('divisi');
		$store_id = $this->session->userdata('store_id');

		$result = array('data' => array());

		$filter = $this->input->post('filter');
		$var = $this->input->post('tgl');

		if ($var) {
			if (is_numeric($filter) or $filter == '') {
				$tgl = str_replace('/', '-', $var);
				$hasil = explode(" - ", $tgl);
				$dari = strtotime("-1 day", strtotime($hasil[0]));
				$sampai = strtotime("+1 day", strtotime($hasil[1]));

				if ($div == 0) {
					if ($filter) {
						$data = $this->model_orders->getOrdersDatabyoutlet($filter, $dari, $sampai, $store_id);
					} else {
						$data = $this->model_orders->getOrdersDatabyallgudang($dari, $sampai, $store_id);
					}
				} else {
					if ($store_id == 7) {
						$data = $this->model_orders->getOrdersDatabyall($dari, $sampai);
					} else {
						$data = $this->model_orders->getOrdersDatabystoreid($store_id, $dari, $sampai);
					}
				}

				if ($data) {
					foreach ($data as $key => $value) {
						//date laporan
						$date_time = date('d-m-Y', $value['date_time']);
						//$date_time = $value['tgl_pesan'];

						// button

						$buttons = ' <div class="btn-group dropleft">
            			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span></button>
            			<ul class="dropdown-menu">';

						if (in_array('viewOrder', $this->permission)) {
							$buttons .= '<li><a href="#" onclick="receipt(' . $value['id'] . ')" ><i class="fa fa-print"></i> Cetak Receipt</a></li>';
							$buttons .= '<li><a href="#" onclick="lihatFunc(' . $value['id'] . ')"  data-toggle="modal" data-target="#lihatModal"><i class="fa fa-file-text-o"></i> Cek Order</a></li>';
							$buttons .= '<li><a href="' . base_url('orders/excel/' . $value['id']) . '" ><i class="fa fa-file-excel-o"></i> Export Excel</a></li>';


							$orders_data = $this->model_orders->getOrdersData($value['id']);
							$orders_item = $this->model_orders->getOrdersItemData($orders_data['id']);

							// if ($store_id == $value['store_id']) {
							if (isset($orders_item['0'])) {
								if ($orders_item['0']['qtydeliv'] == NULL) {
									$arv = '<a target="__blank" href="' . base_url('orders/arv/' . $value['id']) . '" class="btn btn-danger"><i class="fa fa-spinner"></i></a>';
								} else {
									if ($orders_item['0']['qtyarv'] == NULL) {
										$arv = '<a target="__blank" href="' . base_url('orders/arv/' . $value['id']) . '" class="btn btn-warning"><i class="fa fa-caret-square-o-up"></i></a>';
									} else {
										$arv = '<a target="__blank" href="' . base_url('orders/arv/' . $value['id']) . '" class="btn btn-success"><i class="fa fa-check-square-o"></i></a>';
									}
								}
							}
							// } else {
							// 	$arv = ' <span class="label label-danger" title="Sampai">No Akses</span>';
							// }
						}

						if (in_array('updateOrder', $this->permission)) {
							$buttons .= '<li><a href="' . base_url('orders/update/' . $value['id']) . '"><i class="fa fa-pencil"></i> Edit</a></li>';
						}

						if (in_array('deleteOrder', $this->permission)) {
							$buttons .= '<li><a style="cursor:pointer;" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i> Hapus</a></li>';
						}
						$buttons .= '</ul></div>';

						if ($value['paid_status'] == 1) {
							$paid_status = ' <span class="label label-success" title="Terbayar"><i class="fa fa-money"></i></span>';
						} else {
							$paid_status = ' <span class="label label-default" title="Belum Terbayar"><i class="fa fa-money"></i></span>';
						}

						$orders_data = $this->model_orders->getOrdersData($value['id']);
						$orders_item = $this->model_orders->getOrdersItemData($orders_data['id']);

						if (isset($orders_item['0'])) {
							if ($orders_item['0']['qtydeliv'] == NULL) {
								$perjln = ' <span class="label label-default" title="Belum Diantar"><i class="fa fa-truck"></i></span>';
							} else {
								$perjln = ' <span class="label label-success" title="Telah diantar"><i class="fa fa-truck"></i></span>';
							}

							if ($orders_item['0']['baca'] == 0) {
								$pros = ' <span class="label label-success" title="Diproses logistik"><i class="fa fa-external-link"></i></span>';
							} else {
								$pros = ' <span class="label label-default" title="Belum diproses"><i class="fa fa-external-link"></i></span>';
							}
							if ($orders_item['0']['qtyarv'] == NULL) {
								$sampai = ' <span class="label label-default" title="Belum Sampai"><i class="fa fa-home"></i></span>';
							} else {
								$sampai = ' <span class="label label-success" title="Sampai"><i class="fa fa-home"></i></span>';
							}

							if ($div == 0) {
								if ($value['status_up'] == 1) {
									$up = ' <span class="label label-success" title="Data terupload"><i class="fa fa-upload"></i></span>';
								} else {
									$up = ' <span class="label label-default" title="Belum di upload"><i class="fa fa-upload"></i></span>';
								}
							} else {
								$up = '';
							}


							$tombol = $pros . $perjln . $sampai . $paid_status . $up;
						} else {
							$tombol = '<span class="label label-danger">Data Produk Yang Di Order Tidak ditemukan</span>';
						}

						$uang = $value['net_amount'];
						$harga = number_format("$uang", 0, ",", ".");

						if ($div == 1 or $div == 2 or $div == 3 or $div == 11) {
							$result['data'][$key] = array(
								$buttons,
								$arv,
								$date_time,
								$value['customer_address'],
								'Rp. ' . $harga,
								$tombol,
							);
						} else {
							$result['data'][$key] = array(
								$buttons,
								$date_time,
								$value['bill_no'],
								$value['customer_address'],
								'Rp. ' . $harga,
								$tombol,
							);
						}
					} // /foreach
				} else {
					$result['data'] = array();
				}
			} else {
				$result['data'] = array();
			}
		} else {
			$result['data'] = array();
		}
		echo json_encode($result);
	}
	//end

	public function ketersedian()
	{
		if (!in_array('viewProduct', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->render_template('orders/ketersediaan', $this->data);
	}

	public function ketersediaan()
	{
		if (!in_array('viewOrder', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->data['page_title'] = 'Manage Orders';
		$this->render_template('orders/ketersediaan', $this->data);
	}

	public function create()
	{
		if (!in_array('createOrder', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$div = $this->session->userdata('divisi');
		$store_id = $this->session->userdata('store_id');
		$div = $this->session->userdata('divisi');
		$store = $this->session->userdata('store');
		$user_id = $this->session->userdata('id');


		$this->form_validation->set_rules('product[]', 'Product name', 'trim|required');
		if ($this->form_validation->run() == TRUE) {

			if ($this->data['sekarang'] > $this->data['mulai'] or $this->data['sekarang'] < $this->data['sampai'] or $div == 0) {
				$hitung = $this->input->post('product');
				$clear_array = array_count_values($hitung);
				$au = array_keys($clear_array);
				$ay = array_values($hitung);

				if ($au == $ay) {
					if ($this->input->post('net_amount_value') === 'NaN') {
						echo 8;
					} else {
						$order_id = $this->model_orders->create();
						if ($order_id) {
							echo 1;
						} else {
							echo 9;
						}
					}
				} else {
					echo 2;
				}
			} else {
				echo 3;
			}
		} else {
			// false case
			$company = $this->model_company->getCompanyData(1);
			$this->data['company_data'] = $company;
			$this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
			$this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;

			if ($div == 0) {
				$this->data['page_title'] = 'Tambah Order Dari Logistik';
			} else {
				$this->data['page_title'] = 'BUAT ORDER ' . $store;
				$this->data['logistik'] = $this->model_stores->getlogistiksoutlet();
			}

			$this->data['outlet'] = $store;
			$this->data['div'] = $div;
			$this->data['store_id'] = $store_id;
			$this->data['user'] = $this->model_users->getUserData($user_id);
			$this->data['store'] = $this->model_stores->getStoresoutlet();

			$this->render_template('orders/create', $this->data);
		}
	}

	public function getProductValueById()
	{
		$product_id = $this->input->post('product_id');
		if ($product_id) {
			$product_data = $this->model_products->getProductData($product_id);
			echo json_encode($product_data);
		}
	}

	public function getTableProductRow()
	{
		$div = $this->session->userdata('divisi');
		$store_id = $this->session->userdata('store_id');
		$gudang_id = $this->input->post('gudang_id');
		if ($gudang_id) {
			if ($div == 0) {
				$products = $this->model_products->getProductDataGudang($gudang_id);
			} else {
				$products = $this->model_products->getActiveProductDatagudang($gudang_id);
			}
		} else {

			$products = $this->model_products->getProductDataGudang($store_id);
		}
		echo json_encode($products);
	}

	public function update($id)
	{
		if (!in_array('updateOrder', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		if (!$id) {
			redirect('dashboard', 'refresh');
		}

		$this->data['page_title'] = 'Update Order';
		$this->data['orderdata'] = $this->model_orders->getOrdersData($id);

		$div = $this->session->userdata('divisi');
		$store_id = $this->session->userdata('store_id');

		$this->form_validation->set_rules('product[]', 'Product name', 'trim|required');
		if ($this->form_validation->run() == TRUE) {

			$hitung = $this->input->post('product[]');
			$clear_array = array_count_values($hitung);
			$au = array_keys($clear_array);
			$ay = array_values($hitung);

			if ($au == $ay) {

				if ($this->input->post('net_amount_value') === 'NaN') {
					$update = '';
				} else {
					$update = $this->model_orders->update($id);
				}

				if ($update == true) {
					$this->session->set_flashdata('success', 'Data Berhasil Masuk');
					redirect('orders/update/' . $id, 'refresh');
				} else {
					$this->session->set_flashdata('errors', 'Terjadi Kegagalan!!');
					redirect('orders/update/' . $id, 'refresh');
				}
			} else {
				$this->session->set_flashdata('error', 'Maaf.. ! Produk Pesanan Yang diedit Ada Yang Ganda');
				redirect('orders/update/' . $id, 'refresh');
			}
		} else {
			// false case
			$company = $this->model_company->getCompanyData(1);
			$this->data['company_data'] = $company;
			$this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
			$this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;

			$result = array();
			$orders_data = $this->model_orders->getOrdersData($id);
			$this->data['store_id'] = $store_id;
			$this->data['logistik'] = $this->model_stores->getlogistiksoutlet();

			if (isset($orders_data)) {
				$result['order'] = $orders_data;
				$orders_item = $this->model_orders->getOrdersItemData($orders_data['id']);

				foreach ($orders_item as $k => $v) {
					$result['order_item'][] = $v;
				}

				$this->data['order_data'] = $result;

				if ($div == 0) {
					$this->data['products'] = $this->model_products->getProductDataGudang($orders_data['gudang_id']);
				} else {
					$this->data['products'] = $this->model_products->getActiveProductDatagudang($orders_data['gudang_id']);
				}
			} else {
				$this->session->set_flashdata('error', 'Maaf.. ! Anda Tidak Punya Hak Akses');
				redirect('orders/', 'refresh');
			}

			$this->render_template('orders/edit', $this->data);
		}
	}

	public function remove()
	{
		if (!in_array('deleteOrder', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$div = $this->session->userdata('divisi');
		$order_id = $this->input->post('order_id');
		$orders_data = $this->model_orders->getOrdersData($order_id);
		$orders_items = $this->model_orders->getOrdersItemData($order_id);

		$response = array();

		if (!$orders_items['0']['qtydeliv'] or $div == 0) {
			if ($orders_data['status_up'] == 1) {
				$response['success'] = false;
				$response['messages'] = "Maaf.. ! Sudah di Upload Tidak Bisa Dihapus";
			} else {
				if ($order_id) {
					$delete = $this->model_orders->remove($order_id);
					if ($delete == true) {
						$response['success'] = true;
						$response['messages'] = "Berhasil Terhapus";
					} else {
						$response['success'] = false;
						$response['messages'] = "Kesalahan dalam database saat menghapus informasi produk";
					}
				} else {
					$response['success'] = false;
					$response['messages'] = "Refersh Halaman!!";
				}
			}
		} else {
			$response['success'] = false;
			$response['messages'] = "Maaf.. ! Data telah diproses tidak dapat dihapus";
		}
		echo json_encode($response);
	}


	public function paid($id)
	{
		$data = array('paid_status' => 1,);
		$products = $this->model_orders->updateorder($data, $id);
		redirect('orders/update/' . $id, 'refresh');
	}


	public function lihatorder()
	{
		if (!in_array('viewOrder', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$id = $this->input->post('id');
		$order_data = $this->model_orders->getOrdersData($id);
		$orders_items = $this->model_orders->getOrdersItemData($id);

		echo ' 
			<table class="table table-striped" style="font-size: 11px; width:100%;">
                <thead>
                <tr>
                  <th style="font-size: 12px; width:5%;">No</th>
                  <th style="font-size: 12px; width:20%;">Tgl</th>
                  <th style="font-size: 12px; width:30%;">Produk</th>
                  <th style="font-size: 12px; width:10%;">Order</th>
                  <th style="font-size: 12px; width:10%;">Deliv</th>
                  <th style="font-size: 12px; width:10%;">Rp/1</th>
                  <th style="font-size: 12px; width:10%;">Σ</th>
                </tr>
                </thead>
                <tbody>';

		$no = 1;
		$jml = 0;
		foreach ($orders_items as $k => $v) {

			$product_data = $this->model_products->getProductData($v['product_id']);


			if ($v['rate']) {
				$hrg = $v['rate'];
			} else {
				$hrg = 0;
			}

			if ($v['qty']) {
				$qty = $v['qty'];
			} else {
				$qty = 0;
			}

			if ($v['qtydeliv']) {
				$qtydeliv = $v['qtydeliv'];
				$jumlah = $qtydeliv * $hrg;
			} else {
				$qtydeliv = 0;
				$jumlah = $qty * $hrg;
			}

			if (isset($product_data['name'])) {
				$nama = $product_data['name'];
			} else {
				$nama = $v['nama_produk'];
			}
			$jml += $jumlah;
			echo '	<tr>
				            <td>' . $no . '</td>
				            <td>' . $v['tgl_order'] . '</td>
				            <td>' . $nama . '</td>
				            <td>' . $qty . '</td>
				            <td>' . $qtydeliv . '</td>
				            <td>Rp.' . number_format($hrg, 0, ',', '.') . '/' . $v['satuan'] . '</td>
				            <td>Rp.' . number_format($jumlah, 0, ',', '.') . '</td>
			          	</tr>';

			$no++;
		}
		echo  '<tr>
				            <td>Jumlah</td>
				            <td></td>
				            <td></td>
				            <td></td>
				            <td></td>
				            <td></td>
				            <td>Rp.' . number_format($jml, 0, ',', '.') . '</td>
				            <tr>
                </tbody></table> ';
	}


	public function arv($id)
	{
		if (!in_array('updateOrder', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		if (!$id) {
			redirect('dashboard', 'refresh');
		}

		$this->data['page_title'] = 'Barang Sampai';

		$this->data['orderdata'] = $this->model_orders->getOrdersData($id);

		$this->form_validation->set_rules('product[]', 'Product name', 'trim|required');


		if ($this->form_validation->run() == TRUE) {

			$update = $this->model_orders->arv($id);

			if ($update == true) {
				$this->session->set_flashdata('success', 'Data Berhasil Masuk');
				redirect('orders/', 'refresh');
			} else {
				$this->session->set_flashdata('errors', 'Error occurred!!');
				redirect('orders/arv/' . $id, 'refresh');
			}
		} else {
			// false case
			$company = $this->model_company->getCompanyData(1);
			$this->data['company_data'] = $company;
			$this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
			$this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;

			$result = array();
			$orders_data = $this->model_orders->getOrdersData($id);

			$result['order'] = $orders_data;
			$orders_item = $this->model_orders->getOrdersItemData($orders_data['id']);

			foreach ($orders_item as $k => $v) {
				$result['order_item'][] = $v;
			}

			$this->data['order_data'] = $result;



			$this->data['products'] = $this->model_products->getProductData();

			$this->render_template('orders/arv', $this->data);
		}
	}


	public function excel($id)
	{
		if (!$id) {
			redirect('dashboard', 'refresh');
		}

		$div = $this->session->userdata('divisi');

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$orderdata = $this->model_orders->getOrdersData($id);
		$store = $orderdata['store'];
		$waktu = date('d-m-Y', $orderdata['date_time']);
		$filename = "ORDERAN " . $store . " " . $waktu . ".xlsx";

		$spreadsheet->getProperties()
			->setCreator("Fembi Nur Ilham")
			->setLastModifiedBy("Fembi Nur Ilham")
			->setTitle("Orderan " . $store)
			->setSubject("Hasil Export Dari PRS System")
			->setDescription("Semoga Terbantu Dengan Adanya Ini")
			->setKeywords("office 2007 openxml php")
			->setCategory("Order");

		$sheet->setCellValue('A1', 'Orderan ' . $store);
		$sheet->setCellValue('A2', 'Tanggal ' . $waktu);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);

		$sheet->setCellValue('A4', 'No');
		$sheet->setCellValue('B4', 'Tanggal');
		$sheet->setCellValue('C4', 'Nama Produk');
		$sheet->setCellValue('D4', 'Satuan');
		$sheet->setCellValue('E4', 'Qty');
		$sheet->setCellValue('F4', 'Rp/1');
		$sheet->setCellValue('G4', 'Σ');

		$data = $this->model_orders->excel($id);
		$baris = 5;
		$no = 1;
		$count = 4;
		if ($data) {
			foreach ($data as $key => $value) {

				$produk_id = $value['product_id'];
				$product_data = $this->model_products->getProductData($produk_id);
				$nama_produk = $product_data['name'];

				if ($value['qtydeliv'] or $value['qtydeliv'] == '0') {
					if ($value['qtydeliv'] == $value['qtyarv'] or $div == 0) {
						$sheet->setCellValue('A' . $baris, $no++);
						$sheet->setCellValue('B' . $baris, $value['tgl_order']);
						$sheet->setCellValue('C' . $baris, $nama_produk);
						$sheet->setCellValue('D' . $baris, $value['satuan']);
						$sheet->setCellValue('E' . $baris, $value['qtydeliv']);
						$sheet->setCellValue('F' . $baris, $value['rate']);
						$sheet->setCellValue('G' . $baris, $value['amount']);

						$baris++;
						$count++;
					} else {
						$this->session->set_flashdata('error', 'Gagal Export Excel, Qty Deliv Dengan QTY Arv tidak sama');
						redirect('orders/', 'refresh');
					}
				} else {
					$this->session->set_flashdata('error', 'Gagal Export Excel, Data Belum diproses Oleh Logistik');
					redirect('orders/', 'refresh');
				}
			}
			$jmlh = $count + 1;
			$spreadsheet->getActiveSheet()->mergeCells('A' . $jmlh . ':F' . $jmlh);
			$sheet->setCellValue('A' . $jmlh, 'Jumlah');
			$sheet->setCellValue('G' . $jmlh, $orderdata['net_amount']);

			$writer = new Xlsx($spreadsheet);
			header('Content-Disposition: attachment;filename="' . $filename . '"');
			header('Content-Type: application/vnd.ms-excel');
			header('Cache-Control: max-age=0');
			$writer->save('php://output');
		} else {

			$this->session->set_flashdata('error', 'Data Tidak Ditemukan');
			redirect('orders/', 'refresh');
		}
	}


	public function printDiv()
	{
		$id = $this->input->post('id');

		if (!$id) {
			redirect('dashboard', 'refresh');
		}

		if ($id) {
			$order_data = $this->model_orders->getOrdersData($id);
			$orders_items = $this->model_orders->getOrdersItemData($id);
			$company_info = $this->model_company->getCompanyData(1);

			$order_date = date('d/m/Y', $order_data['date_time']);
			$paid_status = ($order_data['paid_status'] == 1) ? "Paid" : "Unpaid";

			$html = '<!-- Main content -->
			<!DOCTYPE html>
			<html>
			<head>
			  <meta charset="utf-8">
			  <meta http-equiv="X-UA-Compatible" content="IE=edge">
			  <title>Invoice Order</title>
			  <!-- Tell the browser to be responsive to screen width -->
			  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
			  <!-- Bootstrap 3.3.7 -->
			  <link rel="stylesheet" href="' . base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') . '">
			  <!-- Font Awesome -->
			  <link rel="stylesheet" href="' . base_url('assets/bower_components/font-awesome/css/font-awesome.min.css') . '">
			  <link rel="stylesheet" href="' . base_url('assets/dist/css/AdminLTE.min.css') . '">
			</head>
			<body onload="window.print();">
			<style>html, body {height:unset;}</style>
			<div class="wrapper" style="width: 55mm;height:unset;">
			  <section class="invoice">
			    <!-- title row -->
			    <div class="row">
			      <div class="col-xs-12">
			        <h2 class="page-header" style="font-size: 18px; text-align:center;margin-top: -7px;">
					<!-- <img width="100px" src="' . base_url() . 'assets/images/logo/prs.png">--><br> 
			          ' . $company_info['company_name'] . '
			          <small class="pull-right"><br>' . $order_date . '</small>
			        </h2>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- info row -->
			    <div class="row invoice-info">
			      
			      <div class="col-sm-4 invoice-col" style="font-size: 12px; width:100%;">
			        
			        <b>Bill ID:</b> ' . $order_data['bill_no'] . '<br>
			        <b>Penerima:</b> ' . $order_data['customer_name'] . '<br>
			        <b>Outlet:</b> ' . $order_data['customer_address'] . ' <br />
			        <b>No Hp:</b> ' . $order_data['customer_phone'] . '
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->

			    <!-- Table row -->
			    <div class="row">
			      <div class="col-xs-12 table-responsive">
			        <table class="table"  style="font-size: 12px; width:100%;">
			        
			          <tbody>';
			$no = 1;
			$jmltotal = 0;
			foreach ($orders_items as $k => $v) {

				$product_data = $this->model_products->getProductData($v['product_id']);


				if ($v['rate']) {
					$hrg = $v['rate'];
				} else {
					$hrg = 0;
				}

				if ($v['qty']) {
					$qtydb = $v['qty'];
				} else {
					$qtydb = 0;
				}

				if ($v['qtydeliv']) {
					$jumlah = $v['qtydeliv'] * $hrg;
				} else {
					$jumlah = $qtydb * $hrg;
				}

				if ($v['qtydeliv']) {
					$qty = $v['qtydeliv'];
				} else {
					$qty = $qtydb;
				}

				if ($v['qtydeliv'] == '0') {
					$qty = $v['qtydeliv'];
					$jumlah = $v['qtydeliv'] * $hrg;
				}

				if (isset($product_data['name'])) {
					$nama = $product_data['name'];
				} else {
					$nama = $v['nama_produk'];
				}

				$jmltotal += $jumlah;

				$html .= '<tr style="border-top: 2px dashed ;border-bottom: 1px dashed ;">
				            <td colspan="3" style="text-align: center;padding: 5px;line-height: normal;">' . $nama . '<br>' . $qty . ' X ' . $hrg . '/' . $v['satuan'] . ' = Rp.' . number_format($jumlah, 0, ',', '.') . '</td>
			          	</tr>';
			}

			$html .= '</tbody>
			        </table>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->

			    <div class="row">
			      
			      <div class="col-xs-6 pull pull-right" style="font-size: 12px; width:100%; margin-top: -20px;">

			        <div class="table-responsive">
			          <table class="table" >
			           ';

			if ($order_data['service_charge'] > 0) {
				$html .= '<tr>
				              <th>Service Charge (' . $order_data['service_charge_rate'] . '%)</th>
				              <td>Rp. ' . $order_data['service_charge'] . '</td>
				            </tr>';
			}

			if ($order_data['vat_charge'] > 0) {
				$html .= '<tr>
				              <th>Vat Charge (' . $order_data['vat_charge_rate'] . '%)</th>
				              <td>' . $order_data['vat_charge'] . '</td>
				            </tr>';
			}


			$html .= ' 
			            <tr>
			              <th>Total:</th>
			              <td>Rp. ' . number_format($jmltotal, 2, ',', '.') . '</td>
			            </tr>

			            <tr>
			              <th>Status:</th>
			              <td>' . $paid_status . '</td>
			            </tr>
			          </table>
			          <div>
			          <div style="float:left;text-align: center;">Pengirim<br><br><br>_________</div> <div style="float:right;text-align: center;">Penerima<br><br><br>_________</div>
			          </div>
			        </div>
			        <div>
			        Note:
			        <div style=" border: 1px solid;height: 60px;border-radius: 0px 10px;"></div>
			        </div>
			      </div>
			      <center>* Selamat Berkerja Tim *</center>
			      <center>* Terima Kasih *</center>
			      <center>-------------------------------------------------</center>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->
			  </section>
			  <!-- /.content -->
			</div>
			</body>
			</html>';

			echo $html;
		}
	}
}
