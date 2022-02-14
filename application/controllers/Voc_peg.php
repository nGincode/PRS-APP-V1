<?php
defined('BASEPATH') or exit('No direct script access allowed');

require('./assets/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Voc_peg extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Voucher Pegawai';

		$this->load->model('model_vocpeg');
		$this->load->model('model_users');
		$this->load->model('model_stores');
		$this->load->model('model_vocgif');
	}

	public function index()
	{

		if (!in_array('viewvocp', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->data['page'] = "employe";
		$this->data['judul'] = "Data Employe";
		$this->data['deskripsi'] = "Manage Data";
		$this->data['dataemploye'] = $this->model_vocpeg->select_all_employe();
		$this->data['jml_pakai'] 	= $this->model_vocpeg->total_rows();
		$this->render_template('voc_peg/index', $this->data);
	}

	public function buat($id)
	{


		$pegawai = $this->model_vocpeg->datapegawai($id);
		$s = $pegawai['store_id'] . date('my', strtotime($pegawai['masuk_kerja'])) . date('dmy', strtotime($pegawai['lahir']));
		$cek = $this->model_vocpeg->cek($s);

		$barcode = $pegawai['nama'] . '.png';

		if ($pegawai['store_id'] == 6) {
			$jml = 2;
		} else {
			$jml = 1;
		}

		if ($cek == 0) {
			$data = array(
				'idpegawai' => $pegawai['id'],
				'store_id' => $pegawai['store_id'],
				'nama' => $pegawai['nama'],
				'barcode' => $barcode,
				'nopegawai' => $s,
				'jml_voc' => 0,
				'limit_voc' => $jml,
				'aktif' => 1,
			);

			$create = $this->model_vocpeg->create($data, $id);


			if ($create == true) {

				include("assets/phpqrcode/qrlib.php");

				$tempdir = FCPATH . 'uploads/data_qr/voc_peg/';

				if (!file_exists($tempdir))
					mkdir($tempdir);
				$isi_teks = "$s";
				$namafile = "$barcode";
				$quality = 'H';
				$ukuran = 8;
				$padding = 0;

				QRCode::png($isi_teks, $tempdir . $namafile, $quality, $ukuran, $padding);

				$this->session->set_flashdata('success', 'ID Pegawai Berhasil Dibuat');
				redirect('voc_peg', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Gagal Mengakses Database');
				redirect('voc_peg', 'refresh');
			}
		} else {

			$this->session->set_flashdata('error', 'ID Pegawai Telah Ada');
			redirect('voc_peg', 'refresh');
		}
	}

	//fix
	public function reset()
	{
		$l_voc = $this->model_vocpeg->lj_voc();
		$limit_voc = 0;
		$jml_voc = 0;
		foreach ($l_voc as $key => $value) {
			$limit_voc += $value['limit_voc'];
			$jml_voc += $value['jml_voc'];
		}

		if (!$jml_voc) {
			$this->session->set_flashdata('error', 'Telah direset');
			redirect('voc_peg', 'refresh');
		} else {
			$jml = $this->model_vocpeg->limit_voc();
			foreach ($jml as $key => $value) {
				$this->model_vocpeg->reset($value['id'], $value['limit_voc']);
			}

			$this->session->set_flashdata('success', 'Berhasil direset');
			redirect('voc_peg', 'refresh');
		}
	}

	public function scan()
	{

		if (!in_array('createvocp', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		$store = $this->session->userdata['store'];

		$this->data['page'] = "pakai";
		$this->data['judul'] = "Data Voucher";
		$this->data['deskripsi'] = "Manage Data";

		$this->data['datapakai'] = $this->model_vocpeg->select_all($store);

		$voucher = $this->input->post('voucher');
		if ($voucher) {
			$idvoc = $this->M_pakai->cekvoc($voucher);
			if ($idvoc) {
				if ($idvoc['jml_voc'] > 0) {
					$data = array(
						'jml_voc' => $idvoc['jml_voc'] + 1,
					);
					$data2 = array(
						'idpegawai' => $idvoc['idpegawai'],
						'nopegawai' => $idvoc['nopegawai'],
						'idakun' => $idvoc['id'],
						'nama' => $idvoc['nama'],
						'outlet' => $this->userdata->nama,
						'tgl' => date('Y-m-d'),
					);
					$update = $this->M_pakai->updatejmlvoc($idvoc['id'], $data, $data2);
					if ($update == true) {
						$this->session->set_flashdata('success', 'Berhasil di Gunakan');
						redirect('voc_peg', 'refresh');
					} else {
						$this->session->set_flashdata('error', 'Terjadi Kesalahan !!');
						redirect('voc_peg', 'refresh');
					}
				} else {
					$this->session->set_flashdata('error', 'Voucher Telah Terpakai');
					redirect('voc_peg', 'refresh');
				}
			} else {
				$this->session->set_flashdata('error', 'ID Pegawai Tidak di Temukan');
				redirect('voc_peg', 'refresh');
			}
		} else {
			$this->render_template('voc_peg/scan', $this->data);
		}
	}

	public function tampil()
	{
		$id = $this->input->post('id');


		if (preg_match("/GIV/", $id)) {

			$data = $this->model_vocgif->ambilvocer($id);
			if ($data) {


				$tgl1 = strtotime(date('Y-m-d'));
				$tgl2 = strtotime($data['kadaluarsa']);

				$jarak = $tgl2 - $tgl1;

				$hari = $jarak / 60 / 60 / 24;

				if ($hari < 0) {

					echo  '<b><img width="150" src="' . base_url('assets/images/voc/gagal.gif') . '"><br> ~Maaf Vocuher Anda Kadaluarsa~</b>';
				} else {
					$store_id = $this->session->userdata['store_id'];
					if ($data['tempat'] == 0 or $data['tempat'] == $store_id) {

						if ($data['claim'] > 0) {
							$tb = '<b><img width="150" src="' . base_url('assets/images/voc/gagal.gif') . '"><br> ~Vocuher Telah digunakan~</b>';
							$dt = '';
							$sub = '';
						} else {

							$dt = "<br>
							Nama : " . $data['namavoc'] . " <br> 
							ID Voucher : " . $data['kode'] . " <br> 
							Kadaluarsa : " . $data['kadaluarsa'] . " <br> 
							Sisa Penukaran : $hari Hari<br> ";
							$sub = '<br><br>';
							echo '<a href="' . base_url('voc_peg/gunakangiv?idvoc=' . $id) . '"><button class="btn btn-success btn-sm" class="form-control"><span class="glyphicon glyphicon-send"></span> <b>Gunakan</b></button></a></form>';

							$tb = '<img width="150" src="' . base_url('assets/images/voc/berhasil.gif') . '"><br>
							';
						}
						echo $dt . $sub . $tb;
					} else {

						$store = $this->model_stores->getStoresData($data['tempat']);
						echo  '<b><img width="150" src="' . base_url('assets/images/voc/gagal.gif') . '"><br> 
						~Maaf Vocuher Anda Hanya Dapat Ditukar di ' . $store['name'] . '~</b>';
					}
				}
			} else {
				echo 'Tidak ditemukan';
			}
		} else {
			// $tgl = date('d');
			// if ($tgl == 26 or $tgl == 27 or $tgl == 28 or $tgl == 29 or  $tgl == 30 or $tgl == 31) {

			// 	echo  '<b><img width="150" src="' . base_url('assets/images/voc/gagal.gif') . '"><br> ~Maaf Voucher Hanya Dapat Ditukar Pada Tanggal 1-25 ~</b>';
			// } else {
			$data = $this->model_vocpeg->tampilnopegawai($id);
			if ($data) {
				$jmlvouher = $data['limit_voc'] - $data['jml_voc'];
				$dt = "Nama : " . $data['nama'] . " <br> ID Pegawai : " . $data['nopegawai'] . " <br> Sisa Penukaran  <br> <font style='font-size: x-large;color: #e91e63;font-weight: bolder;'>" . $jmlvouher . "</font>";
				$sub = '<br><br><form action="pakai" method="POST"><input type="hidden" name="voucher" value="' . $data['nopegawai'] . '" class="form-control">';
				if ($data['jml_voc'] == $data['limit_voc']) {
					$tb = '<b><img width="150" src="' . base_url('assets/images/voc/gagal.gif') . '"><br> ~Anda Telah Menggunakannya Bulan Ini~</b>';
				} else {
					$tb = '<img width="150" src="' . base_url('assets/images/voc/berhasil.gif') . '"><br><button class="btn btn-success btn-sm" type="submit" class="form-control"><span class="glyphicon glyphicon-send"></span> <b>Gunakan</b></button>
	  			</form>';
				}
				echo $dt . $sub . $tb;
			} else {
				echo 'Tidak ditemukan';
			}
			// }
		}
	}


	public function gunakangiv()
	{
		$id = $this->input->get('idvoc');
		$store_id = $this->session->userdata['store_id'];

		$data = array(
			'tglmasuk' => date('Y-m-d'),
			'outlet' => $store_id,
			'claim' => 1
		);

		$update = $this->model_vocpeg->updategiv($id, $data);
		if ($update == true) {
			$this->session->set_flashdata('success', 'Berhasil di Gunakan');
			redirect('voc_peg/scan', 'refresh');
		} else {
			$this->session->set_flashdata('error', 'Terjadi Kesalahan !!');
			redirect('voc_peg/scan', 'refresh');
		}
	}

	public function fetchData()
	{
		$var = $this->input->post('tgl');
		$tgl = str_replace('/', '-', $var);
		$hasil = explode(" - ", $tgl);
		$dari = date('Y-m-d', strtotime($hasil[0]));
		$sampai = date('Y-m-d', strtotime($hasil[1]));

		$data = $this->model_vocpeg->select_all_tgl($dari, $sampai);
		if ($data) {
			foreach ($data as $key => $pakai) {
				$result['data'][$key] = array(
					$pakai['tgl'],
					$pakai['nama'],
					$pakai['nopegawai'],
					$pakai['outlet']
				);
			}
			echo json_encode($result);
		} else {
			$result['data'] = array();
			echo json_encode($result);
		}
	}


	public function laporan()
	{
		$id = $this->input->post('id');
		$var = $this->input->post('tgl');
		//$tgl = "29/04/2021 - 29/04/2021";
		$tgl = str_replace('/', '-', $var);
		$hasil = explode(" - ", $tgl);
		$dari = date('Y-m-d', strtotime($hasil[0]));
		$sampai = date('Y-m-d', strtotime($hasil[1]));

		if ($id == 1) {
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

			$spreadsheet->getProperties()
				->setCreator("Fembi Nur Ilham")
				->setLastModifiedBy("Fembi Nur Ilham")
				->setSubject("Hasil Export Dari PRS System")
				->setDescription("Semoga Terbantu Dengan Adanya Ini")
				->setKeywords("office 2007 openxml php")
				->setCategory("Voucher");

			$sheet->getColumnDimension('A')->setAutoSize(true);
			$sheet->getColumnDimension('B')->setAutoSize(true);
			$sheet->getColumnDimension('C')->setAutoSize(true);
			$sheet->getColumnDimension('D')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->mergeCells('A1:D1');
			$sheet->setCellValue('A1', 'Data Voucher Dari ' . $dari . " Sampai " . $sampai);
			$sheet->setCellValue('A3', 'Tanggal');
			$sheet->setCellValue('B3', 'Nama');
			$sheet->setCellValue('C3', 'ID Pegawai');
			$sheet->setCellValue('D3', 'Lokasi Penukaran');

			$data = $this->model_vocpeg->select_all_tgl($dari, $sampai);

			$baris = 4;
			if ($data) {
				foreach ($data as $key => $value) {
					$sheet->setCellValue('A' . $baris, $value['tgl']);
					$sheet->setCellValue('B' . $baris, $value['nama']);
					$sheet->setCellValue('C' . $baris, $value['nopegawai']);
					$sheet->setCellValue('D' . $baris++, $value['outlet']);
				}

				$writer = new Xlsx($spreadsheet);
				header('Content-Disposition: attachment;filename="data.xlsx"');
				header('Content-Type: application/vnd.ms-excel');
				header('Cache-Control: max-age=0');
				$writer->save('php://output');
			} else {
				//$this->session->set_flashdata('error', 'Data Tidak Ditemukan');
				//redirect('orders/', 'refresh');
			}
		} else {
		}
	}


	public function pakai()
	{

		$store = $this->session->userdata('store');

		$voucher = $this->input->post('voucher');
		if ($voucher) {
			$idvoc = $this->model_vocpeg->cekvoc($voucher);
			if ($idvoc) {
				if ($idvoc['jml_voc'] <= $idvoc['limit_voc']) {
					$data = array(
						'jml_voc' => $idvoc['jml_voc'] + 1,
					);
					$data2 = array(
						'idpegawai' => $idvoc['idpegawai'],
						'nopegawai' => $idvoc['nopegawai'],
						'idakun' => $idvoc['id'],
						'nama' => $idvoc['nama'],
						'outlet' => $store,
						'tgl' => date('Y-m-d'),
					);
					$update = $this->model_vocpeg->updatejmlvoc($idvoc['id'], $data, $data2);
					if ($update == true) {
						$this->session->set_flashdata('success', 'Berhasil di Gunakan');
						redirect('voc_peg/scan', 'refresh');
					} else {
						$this->session->set_flashdata('error', 'Terjadi Kesalahan !!');
						redirect('voc_peg/scan', 'refresh');
					}
				} else {
					$this->session->set_flashdata('error', 'Voucher Telah Terpakai');
					redirect('voc_peg/scan', 'refresh');
				}
			} else {
				$this->session->set_flashdata('error', 'ID Pegawai Tidak di Temukan');
				redirect('voc_peg/scan', 'refresh');
			}
		}
	}

	public function ubahlimit()
	{
		$id = $this->input->post('id');
		$limit = $this->input->post('limit');
		$nama = $this->input->post('nama');

		if ($id && $limit && $nama) {
			$data = array(
				'limit_voc' => $limit,
			);

			$update = $this->model_vocpeg->ubahjmlvoc($id, $data);
			if ($update == true) {
				echo 1;
			} else {
				echo 500;
			}
		} else {
			echo 9;
		}
	}



	public function printDiv()
	{
		$id = $this->input->post('id');
		$idvoc = $this->model_vocpeg->voc_peg_dataid($id);

		if (!$id) {
			redirect('dashboard', 'refresh');
		}

		if ($idvoc) {
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
			<div class="wrapper" style="width: 80mm;height:unset;">
			  <section class="invoice">
			    <!-- /.row -->

			    <!-- Table row -->
			    <div class="row">
			      <div class="col-xs-12 table-responsive">
			        <table class="table"  style="font-size: 20px; width:100%;">
			        
			          <tbody>';
			$html .= '<tr style="border-bottom: solid;">
				            <td colspan="3" style="text-align: center;padding: 5px;line-height: normal;">
							Nama :
							</td>
				            <td colspan="3" style="text-align: center;padding: 5px;line-height: normal;">
							' . $idvoc['nama'] . '
							</td>
			          	</tr>
						  <tr style="border-bottom: solid;">
						  <td colspan="3" style="text-align: center;padding: 5px;line-height: normal;">
						  ID :
						  </td>
						  <td colspan="3" style="text-align: center;padding: 5px;line-height: normal;">
						  ' . $idvoc['nopegawai'] . '
						  </td>
						</tr>
						<tr style="border-bottom: solid;">
						<td colspan="3" style="text-align: center;padding: 5px;line-height: normal;">
						Tempat :
						</td>
						<td colspan="3" style="text-align: center;padding: 5px;line-height: normal;">
						' . $idvoc['outlet'] . '
						</td>
						</tr>
						<tr style="border-bottom: solid;">
						<td colspan="3" style="text-align: center;padding: 5px;line-height: normal;">
						Tanggal :
						</td>
						<td colspan="3" style="text-align: center;padding: 5px;line-height: normal;">
						' . $idvoc['tgl'] . '
						</td>
						<tr>';

			$html .= '</tbody>
			        </table>
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
}

/* End of file employe.php */
/* Location: ./application/controllers/employe.php */