<?php

class Model_orders extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	public function getOrdersData($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM orders WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM orders ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getOrdersDatabyall($dari, $sampai)
	{
		$sql = "SELECT * FROM orders WHERE date_time BETWEEN $dari AND  $sampai ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getOrdersDatabyuserid($user_id)
	{
		$sql = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY id DESC";
		$query = $this->db->query($sql, array($user_id));
		return $query->result_array();
	}

	public function getOrdersDatabystoreid($store_id, $dari, $sampai)
	{
		$sql = "SELECT * FROM orders WHERE store_id = $store_id  AND date_time BETWEEN $dari AND $sampai ORDER BY id DESC";
		$query = $this->db->query($sql, array($store_id));
		return $query->result_array();
	}

	public function getOrdersDatabyoutlet($store_id, $dari, $sampai)
	{
		$sql = "SELECT * FROM orders WHERE store_id = $store_id AND date_time BETWEEN '$dari' AND '$sampai' ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getOrdersDatabystoreid1($tgl, $store_id)
	{
		$sql = "SELECT * FROM orders WHERE tgl_pesan = '$tgl' AND store_id = '$store_id'";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function getOrdersItemData($order_id = null)
	{
		if (!$order_id) {
			return false;
		}

		$sql = "SELECT * FROM orders_item WHERE order_id = ? ORDER BY nama_produk ASC";
		$query = $this->db->query($sql, array($order_id));
		return $query->result_array();
	}

	public function laporankeluar($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM orders_item where product_id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM orders_item ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function excel($id)
	{
		$sql = "SELECT * FROM orders_item where order_id = $id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function status_up($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM orders_item where order_id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->result_array();
		}
	}

	public function create()
	{
		$user_id = $this->session->userdata('id');
		$div = $this->session->userdata['divisi'];
		$store = $this->session->userdata('store');

		$timezone = new DateTimeZone('Asia/Jakarta');
		$date = new DateTime();
		$date->setTimeZone($timezone);

		if (!$div == 0) {
			$store_id = $this->session->userdata('store_id');
			$customer_address = $this->input->post('customer_address');
		} else {
			$add = $this->input->post('customer_address');
			$stores = $this->model_stores->getStoresData($add);
			$store_id = $add;
			$customer_address = $stores['name'];
		}

		$bill_no = 'BILPR-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4));


		//$dataambl = $this->model_orders->getOrdersDatabystoreid1($date->format('Y-m-d'), $store_id);
		//if ($dataambl < 2 or $div == 0) { Limit Order
		$data = array(
			'bill_no' => $bill_no,
			'customer_name' => $this->input->post('customer_name'),
			'customer_address' => $customer_address,
			'customer_phone' => $this->input->post('customer_phone'),
			'date_time' => strtotime($date->format('Y-m-d')),
			'tgl_pesan' =>  $date->format('Y-m-d'),
			'gross_amount' => $this->input->post('gross_amount_value'),
			'service_charge_rate' => $this->input->post('service_charge_rate'),
			'service_charge' => ($this->input->post('service_charge_value') > 0) ? $this->input->post('service_charge_value') : 0,
			'vat_charge_rate' => $this->input->post('vat_charge_rate'),
			'vat_charge' => ($this->input->post('vat_charge_value') > 0) ? $this->input->post('vat_charge_value') : 0,
			'net_amount' => $this->input->post('net_amount_value'),
			'discount' => $this->input->post('discount'),
			'paid_status' => 0,
			'user_id' => $user_id,
			'store_id' => $store_id,
			'store' => $store,
		);

		$this->db->insert('orders', $data);
		$order_id = $this->db->insert_id();

		$this->load->model('model_products');

		$count_product = count($this->input->post('product'));
		for ($x = 0; $x < $count_product; $x++) {

			$nama = $this->model_products->getProductData($this->input->post('product')[$x]);
			if ($nama) {
				$nmp =  $nama['name'];
			} else {
				$nmp = 'Tidak ditemukan';
			}

			$items = array(
				'order_id' => $order_id,
				'user_id' => $user_id,
				'store_id' => $store_id,
				'store' => $store,
				'baca' => 1,
				'product_id' => $this->input->post('product')[$x],
				'qty' => $this->input->post('qty')[$x],
				'satuan' => $this->input->post('satuan_value[]')[$x],
				'tgl_order' => $date->format('Y-m-d'),
				'rate' => $this->input->post('rate_value')[$x],
				'amount' => $this->input->post('amount_value')[$x],
				'nama_produk' => $nmp
			);

			$this->db->insert('orders_item', $items);
		}

		return ($order_id) ? $order_id : false;
		//} else {
		//	$this->session->set_flashdata('error', 'Maaf..! Anda Hanya Dapat Memesan 2x Sehari!!');
		//	redirect('orders/create', 'refresh');
		//};
	}

	public function countOrderItem($order_id)
	{
		if ($order_id) {
			$sql = "SELECT * FROM orders_item WHERE order_id = ?";
			$query = $this->db->query($sql, array($order_id));
			return $query->num_rows();
		}
	}

	public function update($id)
	{
		if ($id) {
			$user_id = $this->session->userdata('id');
			$div = $this->session->userdata('divisi');
			// fetch the order data 
			$timezone = new DateTimeZone('Asia/Jakarta');
			$date = new DateTime();
			$date->setTimeZone($timezone);

			if ($div == 0) {
				$waktu = strtotime($this->input->post('tgl_lap'));
			} else {
				$waktu = $this->input->post('tgl_lap');
			}

			$data = array(
				'customer_name' => $this->input->post('customer_name'),
				'customer_address' => $this->input->post('customer_address'),
				'customer_phone' => $this->input->post('customer_phone'),
				'date_time' => $waktu,
				'gross_amount' => $this->input->post('gross_amount_value'),
				'service_charge_rate' => $this->input->post('service_charge_rate'),
				'service_charge' => ($this->input->post('service_charge_value') > 0) ? $this->input->post('service_charge_value') : 0,
				'vat_charge_rate' => $this->input->post('vat_charge_rate'),
				'vat_charge' => ($this->input->post('vat_charge_value') > 0) ? $this->input->post('vat_charge_value') : 0,
				'net_amount' => $this->input->post('net_amount_value'),
				'discount' => $this->input->post('discount'),
				'paid_status' => $this->input->post('paid_status'),
			);

			$this->db->where('id', $id);
			$this->db->update('orders', $data);



			// now remove the order item data 
			$this->db->where('order_id', $id);
			$this->db->delete('orders_item');


			$user_id = $this->session->userdata('id');
			// now decrease the product qty
			$count_product = count($this->input->post('product'));
			for ($x = 0; $x < $count_product; $x++) {

				$produkid = $this->input->post('product')[$x];
				$product_data = $this->model_products->getProductData($produkid);
				$satuan = $product_data['satuan'];


				if ($this->input->post('qty')[$x]) {
					$qty = $this->input->post('qty')[$x];
				} else {
					$qty = $this->input->post('qtydeliv')[$x];
				}


				$nama = $this->model_products->getProductData($this->input->post('product')[$x]);
				if ($nama) {
					$nmp =  $nama['name'];
				} else {
					$nmp = 'Tidak ditemukan';
				}


				$items = array(
					'order_id' => $id,
					'user_id' => $user_id,
					'store_id' => $this->input->post('store_id')[$x],
					'store' => $this->input->post('store')[$x],
					'product_id' => $this->input->post('product')[$x],
					'tgl_order' => $this->input->post('tgl_order'),
					'qty' => $qty,
					'qtydeliv' => $this->input->post('qtydeliv')[$x],
					'satuan' => $satuan,
					'rate' => $this->input->post('rate_value')[$x],
					'amount' => $this->input->post('amount_value')[$x],
					'baca' => $this->input->post('baca')[$x],
					'status_up' => $this->input->post('status_up')[$x],
					'qtyarv' => $this->input->post('arv')[$x],
					'nama_produk' => $nmp
				);
				$this->db->insert('orders_item', $items);
			}

			return true;
		}
	}


	public function arv($id)
	{
		if ($id) {
			$user_id = $this->session->userdata('id');
			// now remove the order item data 
			$this->db->where('order_id', $id);
			$this->db->delete('orders_item');


			$user_id = $this->session->userdata('id');
			// now decrease the product qty
			$count_product = count($this->input->post('product'));
			for ($x = 0; $x < $count_product; $x++) {

				$produkid = $this->input->post('product')[$x];
				$product_data = $this->model_products->getProductData($produkid);
				$satuan = $product_data['satuan'];


				if ($this->input->post('qty')[$x]) {
					$qty = $this->input->post('qty')[$x];
				} else {
					$qty = 0;
				}


				$nama = $this->model_products->getProductData($this->input->post('product')[$x]);
				if ($nama) {
					$nmp =  $nama['name'];
				} else {
					$nmp = 'Tidak ditemukan';
				}


				$items = array(
					'order_id' => $id,
					'user_id' => $user_id,
					'store_id' => $this->input->post('store_id')[$x],
					'store' => $this->input->post('store')[$x],
					'product_id' => $this->input->post('product')[$x],
					'tgl_order' => $this->input->post('tgl_order'),
					'qty' => $qty,
					'qtydeliv' => $this->input->post('qtydeliv')[$x],
					'qtyarv' => $this->input->post('qtyarv')[$x],
					'satuan' => $satuan,
					'rate' => $this->input->post('rate_value')[$x],
					'amount' => $this->input->post('amount_value')[$x],
					'nama_produk' => $nmp
				);
				$this->db->insert('orders_item', $items);
			}

			return true;
		}
	}


	public function remove($id)
	{
		if ($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('orders');

			$this->db->where('order_id', $id);
			$delete_item = $this->db->delete('orders_item');
			return ($delete == true && $delete_item) ? true : false;
		}
	}

	public function countTotalPaidOrders()
	{
		$sql = "SELECT * FROM orders WHERE paid_status = ?";
		$query = $this->db->query($sql, array(1));
		return $query->num_rows();
	}

	public function countTotalnotPaidOrders()
	{
		$sql = "SELECT * FROM orders WHERE paid_status = ?";
		$query = $this->db->query($sql, array(0));
		return $query->num_rows();
	}

	public function useroutlet($id)
	{
		if ($id) {
			$sql = "SELECT * FROM users WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}
	}


	public function updateorderitem($data, $id)
	{
		if ($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('orders_item', $data);
			return ($update == true) ? true : false;
		}
	}

	public function updateorder($data, $id)
	{
		if ($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('orders', $data);
			return ($update == true) ? true : false;
		}
	}

	//dashboard 
	public function dsleader($ds_id)
	{

		if ($ds_id) {
			$sql = "SELECT * FROM orders WHERE store_id=$ds_id";
			$query = $this->db->query($sql);
			return $query->num_rows();
		}
	}

	public function dsleaderall()
	{

		$sql = "SELECT * FROM orders";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function cetakpertanggal($store_id, $tgl_awal, $tgl_akhir)
	{

		$query = $this->db->query("SELECT * FROM orders_item WHERE store_id = $store_id AND status_up=1 AND tgl_order BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY tgl_order ASC");
		return $query->result();
	}

	public function countbaca($baca)
	{
		$sql = "SELECT * FROM orders_item WHERE baca = $baca";
		$query = $this->db->query($sql, array(0));
		return $query->num_rows();
	}

	public function upbaca($id)
	{

		$data = array(
			'baca' => 0,
		);
		$baca = $this->db->update('orders_item', $data);
		return ($baca) ? true : false;
	}

	public function updateamount($sum, $idorder)
	{

		$data = array(
			'net_amount' => $sum,
			'gross_amount' => $sum
		);
		$this->db->where('id', $idorder);
		$update = $this->db->update('orders', $data);
		return ($update) ? true : false;
	}

	public function orderitemid($id)
	{
		$sql = "SELECT * FROM orders_item where id = $id";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function sumamount($idorder)
	{
		$sql = "SELECT SUM(amount) FROM orders_item where order_id = $idorder";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function getOrdersstore($tgl_awal, $tgl_akhir)
	{
		$sql = "SELECT DISTINCT store_id FROM orders_item WHERE status_up=1 AND tgl_order BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY tgl_order ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}
