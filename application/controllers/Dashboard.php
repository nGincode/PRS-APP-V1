<?php

class Dashboard extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Dashboard';

		$this->load->model('model_products');
		$this->load->model('model_orders');
		$this->load->model('model_users');
		$this->load->model('model_stores');
		$this->load->model('model_ivn');
		$this->load->model('model_pegawai');
		$this->load->model('model_pengadaan');
	}

	/* 
	* It only redirects to the manage category page
	* It passes the total product, total paid orders, total users, and total stores information
	into the frontend.
	*/
	public function index()
	{
		//Session 
		$div = $this->session->userdata('divisi');
		$group_id = $this->session->userdata('group_id');
		$store_id = $this->session->userdata('store_id');

		//Admin System
		$this->data['total_users'] = $this->model_users->countTotalUsers();
		$this->data['total_stores'] = $this->model_stores->countTotalStores();

		//Admin Logistik
		$this->data['total_products'] = $this->model_products->countTotalProducts();
		$this->data['total_paid_orders'] = $this->model_orders->countTotalPaidOrders();
		$this->data['total_paid_notorders'] = $this->model_orders->countTotalnotPaidOrders();
		$this->data['dataproducts'] = $this->model_products->getProductData();

		//dasboard office
		$this->data['total_products_dsall'] = $this->model_products->dsleaderall();
		$this->data['total_paid_orders_dsall'] = $this->model_orders->dsleaderall();
		$this->data['total_ivn_dsall'] = $this->model_ivn->dsleaderall();
		$this->data['total_pegawai_dsall'] = $this->model_pegawai->dsleaderall();
		$this->data['total_pengadaan_dsall'] = $this->model_pengadaan->dsleaderall();

		//dasboard outlet
		$this->data['total_paid_orders_ds'] = $this->model_orders->dsleader($store_id);
		$this->data['total_ivn_ds'] = $this->model_ivn->dsleader($store_id);
		$this->data['total_pegawai_ds'] = $this->model_pegawai->dsleader($store_id);
		$this->data['total_pengadaan_ds'] = $this->model_pengadaan->dsleader($store_id);

		//dasboard div
		$this->data['total_ivn_dsdiv'] = $this->model_ivn->dsleaderdiv($div, $store_id);
		$this->data['total_pengadaan_dsdiv'] = $this->model_pengadaan->dsleaderdiv($div, $store_id);

		if ($div == 0) {
			$is_admin = 1;
			$this->data['group_id'] = $group_id;
			//Logistik & office
			$this->data['is_admin'] = $is_admin;
			$this->render_template('dashboard', $this->data);
			return;
		} elseif ($div == 11) {
			$is_admin = 2;
			//leader
			$this->data['is_admin'] = $is_admin;
			$this->render_template('dashboard', $this->data);
			return;
		} else {
			$is_admin = 3;
			//divisi
			$this->data['is_admin'] = $is_admin;
			$this->render_template('dashboard', $this->data);
			return;
		}



		//update harga logistik
		$prdct = $this->model_products->getProductData();

		$hrgbr = [];
		$hrgskrng = [];
		foreach ($prdct as $key => $v) {

			$hrgitem = $this->model_belanja->getbelanjaterimabyallid(mktime(0, 0, 0, date("n"), date("j") + 7, date("Y")), date('Y-m-d'), $v['id']);

			$jmlhrg = 0;

			foreach ($hrgitem as $h) {
				$cekbelanja = $this->model_belanja->getbelanjaData($h['belanja_id']);
				if ($cekbelanja['status'] && $h['harga']) {
					$jmlhrg += $h['harga'];
				}
			}

			if ($jmlrow = count($hrgitem)) {
				$jl = ceil($jmlhrg / $jmlrow); //jumlah
				$persen = $jl * 0.1;
				$hargacek = round($jl + $persen);
			} else {
				$hargacek = $jmlhrg;
			}

			$hrgbr[] = $hargacek;

			$hrgskrng[] = $v['price'];
		}

		$cekarray = 0;
		foreach ($hrgskrng as $itung => $k) {
			if ($k != $hrgbr[$itung]) {
				$cekarray += 1;
			}
		}

		if ($cekarray) {
			foreach ($prdct as $key => $value) {

				$hrgitem = $this->model_belanja->getbelanjaterimabyallid(mktime(0, 0, 0, date("n"), date("j") + 7, date("Y")), date('Y-m-d'), $value['id']);

				$jmlhrg = 0;

				foreach ($hrgitem as $h) {
					$cekbelanja = $this->model_belanja->getbelanjaData($h['belanja_id']);
					if ($cekbelanja['status'] && $h['harga']) {
						$jmlhrg += $h['harga'];
					}
				}

				if ($jmlrow = count($hrgitem)) {
					$jl = ceil($jmlhrg / $jmlrow); //jumlah
					$persen = $jl * 0.1;
					$hargacek = $jl + $persen;
				} else {
					$hargacek = $jmlhrg;
				}




				///untuk eksekusi
				$product_data = $this->model_products->getProductData($value['id']);
				if ($product_data['price'] == $hargacek) {
					$price = $product_data['price'];
					$harga = $product_data['price_old'];
					$tgl = $product_data['price_tgl'];
				} else {
					$tgl = date('Y-m-d');
					$harga = $product_data['price'];
					$price = $hargacek;
				}

				$data = array(
					'price' => $price,
					'price_old' => $harga,
					'price_tgl' => $tgl
				);

				$this->model_products->update($data, $value['id']);
			}
		}
	}
}
