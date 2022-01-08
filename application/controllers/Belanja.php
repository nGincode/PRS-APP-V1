<?php

defined('BASEPATH') or exit('No direct script access allowed');

require('./assets/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Belanja extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Belanja';

		$this->load->model('model_orders');
		$this->load->model('model_users');
		$this->load->model('model_products');
		$this->load->model('model_company');
		$this->load->model('model_stores');
		$this->load->model('model_belanja');
	}


	public function create()
	{
		if (!in_array('createbelanja', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		$div = $this->session->userdata('divisi');
		$user_id = $this->session->userdata('id');

		$this->data['page_title'] = 'Tambah Belanja';

		$this->form_validation->set_rules('product[]', 'Product name', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$hitung = $this->input->post('product');
			$clear_array = array_count_values($hitung);
			$au = array_keys($clear_array);
			$ay = array_values($hitung);

			if ($au == $ay) {

				// $cektgl = $this->model_belanja->jumlahtgl($this->input->post('tgl'));
				// if ($cektgl < 1) {
				$bill_no = 'BILBLJ-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4));
				$judulbelanja = array(
					'tgl' =>  $this->input->post('tgl'),
					'total' =>  $this->input->post('net_amount_value'),
					'bill_no' =>  $bill_no
				);
				$createbelanja = $this->model_belanja->createbelanja($judulbelanja);
				if ($createbelanja) {

					$databelanja = $this->model_belanja->getakhirbelanja();

					if ($databelanja['tgl'] == $this->input->post('tgl')) {
						$count_product = count($this->input->post('product'));

						$items = array();
						for ($x = 0; $x < $count_product; $x++) {
							$nama_produk = $this->model_products->getProductData($this->input->post('product[]')[$x]);
							array_push($items, array(
								'tgl' =>  $this->input->post('tgl'),
								'product_id' => $this->input->post('product[]')[$x],
								'nama_produk' => $nama_produk['name'],
								'tipe' => $nama_produk['tipe'],
								'qty' => $this->input->post('qty[]')[$x],
								'satuan' => $this->input->post('satuan_value[]')[$x],
								'harga' => $this->input->post('rate_value[]')[$x],
								'belanja_id' => $databelanja['id']
							));
						}
						$belanja = $this->model_belanja->create($items);
						if ($belanja) {
							$this->session->set_flashdata('success', 'Berhasil Dipesan');
							redirect('belanja/', 'refresh');
						} else {
							$this->session->set_flashdata('error', 'Terjadi Kesalahan!!');
							redirect('belanja/create/', 'refresh');
						}
					} else {
						$this->session->set_flashdata('error', 'Terjadi Kesalahan!!');
						redirect('belanja/create/', 'refresh');
					}
				} else {
					$this->session->set_flashdata('error', 'Terjadi Kesalahan!!');
					redirect('belanja/create/', 'refresh');
				}
				// } else {
				// 	$this->session->set_flashdata('error', 'Tanggal Telah Ada!!');
				// 	redirect('belanja/create/', 'refresh');
				// }
			} else {
				$this->session->set_flashdata('error', 'Maaf.. ! Produk Pesanan Anda Ada Yang Ganda');
				redirect('belanja/create', 'refresh');
			}
		} else {
			// false case
			$store_id = $this->session->userdata('store_id');
			$div = $this->session->userdata('divisi');
			$company = $this->model_company->getCompanyData(1);
			$this->data['company_data'] = $company;
			$this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
			$this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;

			if ($div == 0) {
				$this->data['products'] = $this->model_products->getActiveProductDataall();
			} else {
				$this->data['products'] = $this->model_products->getActiveProductData($store_id);
			}

			$user_id = $this->session->userdata('id');
			$this->data['outlet'] = $this->session->userdata['store'];
			$this->data['user'] = $this->model_users->getUserData($user_id);
			$this->data['div'] = $div;
			$this->data['store_id'] = $store_id;
			$this->data['store'] = $this->model_stores->getStoresoutlet();

			$this->render_template('belanja/create', $this->data);
		}
	}


	public function index()
	{
		if (!in_array('viewbelanja', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		$this->data['page_title'] = 'Manage Belanja';
		$this->render_template('belanja/index', $this->data);
	}


	public function fetchbelanjaData()
	{
		$result = array('data' => array());

		$data = $this->model_belanja->getbelanjaData();


		foreach ($data as $key => $value) {

			// button
			$buttons = ' <div class="btn-group dropleft">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span></button>
				<ul class="dropdown-menu">';

			if (in_array('updatebelanja', $this->permission)) {
				$buttons .= '<li><a href="' . base_url("belanja/edit/" . $value['id']) . '"><i class="fa fa-pencil"></i> Edit</a></li>';
			}


			$getbelanja = $this->model_belanja->getbelanjaData($value['id']);
			if ($getbelanja['status'] == 0) {
				if (in_array('updatebelanja', $this->permission)) {
					$buttons .= '<li><a href="#" onclick="bekukan(' . $value['id'] . ')"><i class="fa fa-check"></i> Bekukan</a></li>';
				}
			}
			$buttons .= '<li><a href="#" onclick="lihatBelnj(' . $value['id'] . ')"  data-toggle="modal" data-target="#lihatBelnj"><i class="fa fa-file-text-o"></i> Cek Belanja</a></li>';
			$buttons .= '<li><a href="#" onclick="receipt(' . $value['id'] . ')" ><i class="fa fa-print"></i> Cetak Receipt</a></li>';
			if (in_array('deletebelanja', $this->permission)) {
				$buttons .= '<li><a  onclick="removeFunc(' . $value['id'] . ')" style="cursor:pointer;"   data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash-o"></i> Hapus</a></li>';
			}
			$buttons .= '</ul></div>';

			if ($value['status'] == 0) {
				$status = '<button type="button" class="btn btn-warning">Proses</button>';
			} else if ($value['status'] == 1) {
				$status = '<button type="button" class="btn btn-success">Selesai</button>';
			} else {
				$status = '<button type="button" class="btn btn-primary">Tidak diketahui</button>';
			}

			if ($value['total']) {
				$total = number_format($value['total'], 0, ',', '.');
			} else {
				$total = 0;
			}

			$result['data'][$key] = array(
				'<center>' . $buttons . '</center>',
				'<center>' . $value['tgl'] . '</center>',
				'<center>' . $value['bill_no'] . '</center>',
				'<center>' . "Rp " . $total . '</center>',
				'<center>' . $status . '</center>',
			);
		} // /foreach

		echo json_encode($result);
	}


	public function remove()
	{
		if (!in_array('deletebelanja', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$belanja_id = $this->input->post('belanja_id');
		$belanja_data = $this->model_belanja->getbelanjaData($belanja_id);
		$response = array();
		if ($belanja_data['status'] == 0) {
			if ($belanja_data) {
				$delete = $this->model_belanja->remove($belanja_id);
				if ($delete == true) {
					$response['success'] = true;
					$response['messages'] = "Berhasil Terhapus";
				} else {
					$response['success'] = false;
					$response['messages'] = "Kesalahan dalam database saat menghapus informasi produk";
				}
			}
		} else {
			$response['success'] = false;
			$response['messages'] = "Tidak dizinkan untuk dihapus";
		}

		echo json_encode($response);
	}

	public function edit($id)
	{
		if (!in_array('updatebelanja', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		if (!$id) {
			redirect('dashboard', 'refresh');
		}
		$this->data['page_title'] = 'Edit Belanja';
		$store_id = $this->session->userdata('store_id');
		$div = $this->session->userdata('divisi');



		$this->form_validation->set_rules('product[]', 'Product name', 'trim|required');
		if ($this->form_validation->run() == TRUE) {


			$hitung = $this->input->post('product');
			$clear_array = array_count_values($hitung);
			$au = array_keys($clear_array);
			$ay = array_values($hitung);

			if ($au == $ay) {
				$judulbelanja = array(
					'tgl' =>  $this->input->post('tgl'),
					'total' =>  $this->input->post('gross_amount_value'),
				);
				$ebelanja = $this->model_belanja->editbelanja($id, $judulbelanja);
				if ($ebelanja) {

					$count_product = count($this->input->post('product'));


					$this->db->where('belanja_id', $id);
					$this->db->delete('belanja_item');

					$items = array();
					for ($x = 0; $x < $count_product; $x++) {
						$nama_produk = $this->model_products->getProductData($this->input->post('product[]')[$x]);
						array_push($items, array(
							'tgl' =>  $this->input->post('tgl'),
							'product_id' => $this->input->post('product[]')[$x],
							'nama_produk' => $nama_produk['name'],
							'tipe' => $nama_produk['tipe'],
							'qty' => $this->input->post('qty[]')[$x],
							'satuan' => $this->input->post('satuan_value[]')[$x],
							'harga' => $this->input->post('rate_value[]')[$x],
							'belanja_id' => $id
						));
					}
					$belanja = $this->model_belanja->create($items);
					if ($belanja) {
						$this->session->set_flashdata('success', 'Berhasil Diubah');
						redirect('belanja/edit/' . $id, 'refresh');
					} else {
						$this->session->set_flashdata('error', 'Terjadi Kesalahan!!');
						redirect('belanja/edit/' . $id, 'refresh');
					}
				} else {
					$this->session->set_flashdata('error', 'Terjadi Kesalahan!!');
					redirect('belanja/', 'refresh');
				}
			} else {
				$this->session->set_flashdata('error', 'Maaf.. ! Produk Pesanan Anda Ada Yang Ganda');
				redirect('belanja', 'refresh');
			}
		} else {
			$company = $this->model_company->getCompanyData(1);
			$this->data['company_data'] = $company;
			$this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
			$this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;



			$result = array();
			$orders_data = $this->model_belanja->getbelanjaData($id);

			if (isset($orders_data)) {
				$result['order'] = $orders_data;
				$orders_item = $this->model_belanja->getbelanjaid($orders_data['id']);

				foreach ($orders_item as $k => $v) {
					$result['order_item'][] = $v;
				}

				$this->data['order_data'] = $result;
				$this->data['products'] = $this->model_products->getProductData();
			} else {
				$this->session->set_flashdata('error', 'Maaf.. ! Anda Tidak Punya Hak Akses');
				redirect('belanja', 'refresh');
			}



			$user_id = $this->session->userdata('id');
			$this->data['outlet'] = $this->session->userdata['store'];
			$this->data['user'] = $this->model_users->getUserData($user_id);
			$this->data['div'] = $div;
			$this->data['store_id'] = $store_id;
			$this->data['store'] = $this->model_stores->getStoresoutlet();
			$this->data['id'] = $id;


			$this->data['getbelanja'] = $this->model_belanja->getbelanjaData($id);


			$data = $this->model_belanja->getbelanjaData($id);
			$this->data['tgl'] = $data['tgl'];
		}

		$this->render_template('belanja/edit', $this->data);
	}

	public function bayar($id)
	{
		if (!in_array('updatebelanja', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		$data = $this->model_belanja->paid($id);
		if ($data == true) {
			$this->session->set_flashdata('success', 'Berhasil Terbayar');
			redirect('belanja/', 'refresh');
		} else {
			$this->session->set_flashdata('error', 'Terjadi Kesalahan!!');
			redirect('belanja/', 'refresh');
		}
	}




	public function excel()
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$spreadsheet->getProperties()
			->setCreator("Fembi Nur Ilham")
			->setLastModifiedBy("Fembi Nur Ilham")
			->setTitle("Belanja ")
			->setSubject("Hasil Export Dari PRS System")
			->setDescription("Semoga Terbantu Dengan Adanya Ini")
			->setKeywords("office 2007 openxml php")
			->setCategory("Belanja");

		$styleArray = [
			'font' => [
				'bold' => true,
				'size' => 20,
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
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
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			],

		];

		$tgl_awal = $this->input->post('tgl_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');

		$filename = "Laporan Belanja Dari Tanggal" . $tgl_awal . " - " . $tgl_akhir . ".xlsx";


		$sheet->setCellValue('A1', 'Laporan Belanja Logistik');
		$sheet->setCellValue('A2', $tgl_awal . ' Sampai ' . $tgl_akhir);
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->mergeCells('A1:G1');
		$spreadsheet->getActiveSheet()->mergeCells('A2:G2');


		$tgl = $this->model_belanja->belanjaData($tgl_awal, $tgl_akhir);
		$baris = 4;
		$count = 4;
		$hasil = 0;
		if ($tgl) {
			foreach ($tgl as $key => $value) {
				$blj = $this->model_belanja->getbelanjaData($value['id']);
				$bljitem =  $this->model_belanja->getbelanjaid($blj['id']);

				$no = 1;

				$sheet->setCellValue('A' . $baris, 'No');
				$sheet->setCellValue('B' . $baris, 'Tanggal');
				$sheet->setCellValue('C' . $baris, 'Nama Produk');
				$sheet->setCellValue('D' . $baris, 'Satuan');
				$sheet->setCellValue('F' . $baris, 'Rp/1');
				$sheet->setCellValue('E' . $baris, 'Qty');
				$sheet->setCellValue('G' . $baris++, 'Σ');


				$data = $this->model_belanja->databelanja($value['tgl'], $tgl_awal, $tgl_akhir);
				foreach ($data as $key => $value) {
					$produk_id = $value['product_id'];
					$product_data = $this->model_products->getProductData($produk_id);
					$nama_produk = $product_data['name'];
					$total = $value['qty'] * $value['harga'];
					$hasil += $total;
					$sheet->setCellValue('A' . $baris, $no++);
					$sheet->setCellValue('B' . $baris, $value['tgl']);
					$sheet->setCellValue('C' . $baris, $nama_produk);
					$sheet->setCellValue('D' . $baris, $value['satuan']);
					$sheet->setCellValue('F' . $baris,  'Rp. ' . number_format($value['harga'], 0, ",", "."));
					$sheet->setCellValue('E' . $baris, $value['qty']);
					$sheet->setCellValue('G' . $baris, 'Rp. ' . number_format($total, 0, ",", "."));

					$baris++;
					$count++;
				}
				$sheet->setCellValue('G' . $baris, $hasil);
				$sheet->setCellValue('A' . $baris, 'Jumlah');
				$spreadsheet->getActiveSheet()->mergeCells('A' . $baris . ':F' . $baris);
				$sheet->setCellValue('G' . $baris, $hasil);

				$spreadsheet->getActiveSheet()->getStyle('A1:G' . $baris)->applyFromArray($alignmentcenter);

				$baris++;
				$count++;

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
			redirect('belanja/', 'refresh');
		}
	}







	public function printDiv()
	{
		$id = $this->input->post('id');

		if (!$id) {
			redirect('dashboard', 'refresh');
		}

		if ($id) {
			$getbelanjaData = $this->model_belanja->getbelanjaData($id);
			$orders_items = $this->model_belanja->getbelanjaid($id);

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
			        <h2 class="page-header" style="font-size: 18px; text-align:center;margin-top: -7px;"><br>
			          <center><b>Pembelanjaan</b></center>
			        </h2>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- info row -->
			    <div class="row invoice-info">
			      
			      <div class="col-sm-4 invoice-col" style="font-size: 12px; width:100%;">
			        
			        <b>Bill ID :</b> ' . $getbelanjaData['bill_no'] . '<br>
			        <b>Tanggal :</b> ' . $getbelanjaData['tgl'] . '
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


				if ($v['harga']) {
					$hrg = $v['harga'];
				} else {
					$hrg = 0;
				}

				if ($v['qty']) {
					$qty = $v['qty'];
					$jumlah = $qty * $hrg;
				} else {
					$qty = 0;
					$jumlah = $qty * $hrg;
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


			$html .= ' 
			            <tr>
			              <th>Total:</th>
			              <td>Rp. ' . number_format($jmltotal, 2, ',', '.') . '</td>
			            </tr>

			           
			          </table>
			          <div>
			        </div>
			        <div>
			        Note:
			        <div style=" border: 1px solid;height: 60px;border-radius: 0px 10px;"></div>
			        </div>
			      </div>
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


	public function bekukan($id)
	{
		if (!in_array('updatebelanja', $this->permission)) {
			redirect('belanja', 'refresh');
		}
		if (!$id) {
			redirect('balanja', 'refresh');
		}


		$bekukan = $this->model_belanja->bekukan($id);

		if ($bekukan == true) {
			echo '';
		} else {
			echo 1;
		}
	}

	public function ambil()
	{

		$tgl = $this->input->post('tgl');
		$cektgl = $this->model_belanja->jumlahtgl($tgl);
		if ($cektgl < 1) {
			$data = $this->model_orders->getOrderidtgl($tgl);

			$bill_no = 'BILBLJ-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4));
			$judulbelanja = array(
				'tgl' =>  $tgl,
				'total' =>  0,
				'bill_no' =>  $bill_no
			);
			$createbelanja = $this->model_belanja->createbelanja($judulbelanja);

			if ($createbelanja) {
				$databelanja = $this->model_belanja->getakhirbelanja();
				$items = array();
				$harga = 0;
				foreach ($data as $val) {

					$qty = 0;
					$result = $this->model_orders->getOrderbyidtgl($val['product_id'], $tgl);
					foreach ($result as $v) {
						$qty += $v['qty'];
					}

					$product = $this->model_products->getProductData($val['product_id']);

					array_push($items, array(
						'tgl' =>  $tgl,
						'product_id' => $val['product_id'],
						'nama_produk' => $product['name'],
						'tipe' => $product['tipe'],
						'qty' => $qty,
						'satuan' => $product['satuan'],
						'harga' => $product['price'],
						'belanja_id' => $databelanja['id']
					));
					$harga += $product['price'];
				}
				$belanja = $this->model_belanja->create($items);
				$this->model_belanja->ubahjumlah($databelanja['id'], $harga);
				echo $databelanja['id'];
			} else {
				echo 'zz';
			}
		} else {
			echo 'z';
		}
	}




	public function lihatblj()
	{
		$id = $this->input->post('id');
		$order_data = $this->model_belanja->getbelanjaData($id);
		$orders_items = $this->model_belanja->getbelanjaid($id);

		echo ' 
			<table class="table table-striped" style="font-size: 11px; width:100%;">
		        <thead>
		        <tr>
		          <th style="font-size: 12px; width:5%;">No</th>
		          <th style="font-size: 12px; width:20%;">Tgl</th>
		          <th style="font-size: 12px; width:30%;">Produk</th>
		          <th style="font-size: 12px; width:10%;">Qty</th>
		          <th style="font-size: 12px; width:10%;">Rp/1</th>
		          <th style="font-size: 12px; width:10%;">Σ</th>
		        </tr>
		        </thead>
		        <tbody>';

		$no = 1;
		$jml = 0;
		foreach ($orders_items as $k => $v) {

			$product_data = $this->model_products->getProductData($v['product_id']);


			if ($v['harga']) {
				$hrg = $v['harga'];
			} else {
				$hrg = 0;
			}

			if ($v['qty']) {
				$qty = $v['qty'];
			} else {
				$qty = 0;
			}

			if ($v['qty']) {
				$qtydeliv = $v['qty'];
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
				            <td>' . $v['tgl'] . '</td>
				            <td>' . $nama . '</td>
				            <td>' . $qty . '</td>
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
		            <td>Rp.' . number_format($jml, 0, ',', '.') . '</td>
		            <tr>
		</tbody></table> ';
	}
}
