<?php
defined('BASEPATH') or exit('No direct script access allowed');

require('./assets/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Pos extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'POS';

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

	public function index()
	{

		if (!in_array('viewpos', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$div = $this->session->userdata('divisi');
		$store_id = $this->session->userdata('store_id');
		$div = $this->session->userdata('divisi');
		$store = $this->session->userdata('store');
		$user_id = $this->session->userdata('id');

		$company = $this->model_company->getCompanyData(1);
		$this->data['company_data'] = $company;
		$this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
		$this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;

		if ($div == 0) {
			$this->data['products'] = $this->model_products->getProductData();
			$this->data['page_title'] = 'Tambah Order Dari Logistik';
		} else {
			$this->data['products'] = $this->model_products->getActiveProductData($store_id);
			$this->data['page_title'] = 'BUAT ORDER ' . $store;
		}

		$this->data['outlet'] = $store;
		$this->data['div'] = $div;
		$this->data['store_id'] = $store_id;
		$this->data['user'] = $this->model_users->getUserData($user_id);
		$this->data['store'] = $this->model_stores->getStoresoutlet();

		$this->render_template('pos/index', $this->data);
	}
}

/* End of file employe.php */
/* Location: ./application/controllers/employe.php */