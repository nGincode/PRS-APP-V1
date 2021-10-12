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

				$cektgl = $this->model_belanja->jumlahtgl($this->input->post('tgl'));
				if ($cektgl < 1) {
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
									'qty' => $this->input->post('qty[]')[$x],
									'satuan' => $this->input->post('satuan_value[]')[$x],
									'harga' => $this->input->post('rate_value[]')[$x],
									'belanja_id' => $databelanja['id']
								));
							}
							$belanja = $this->model_belanja->create($items);
							if ($belanja) {
								$this->session->set_flashdata('success', 'Berhasil Dipesan');
								redirect('belanja/create', 'refresh');
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
				} else {
					$this->session->set_flashdata('error', 'Tanggal Telah Ada!!');
					redirect('belanja/create/', 'refresh');
				}
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

			$result['data'][$key] = array(
				'<center>' . $buttons . '</center>',
				'<center>' . $value['tgl'] . '</center>',
				'<center>' . $value['bill_no'] . '</center>',
				'<center>' . "Rp " . number_format($value['total'], 0, ',', '.') . '</center>',
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
				$this->data['products'] = $this->model_products->getActiveProductDataall();
			} else {
				$this->session->set_flashdata('error', 'Maaf.. ! Anda Tidak Punya Hak Akses');
				redirect('orders/', 'refresh');
			}



			$user_id = $this->session->userdata('id');
			$this->data['outlet'] = $this->session->userdata['store'];
			$this->data['user'] = $this->model_users->getUserData($user_id);
			$this->data['div'] = $div;
			$this->data['store_id'] = $store_id;
			$this->data['store'] = $this->model_stores->getStoresoutlet();


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
}
