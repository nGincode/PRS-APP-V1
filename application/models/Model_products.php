<?php

class Model_products extends CI_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_users');
	}

	/* get the brand data */
	public function getProductData($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM products where id = ? ORDER BY id DESC";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM products ORDER BY id DESC, sku DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function qtylow()
	{

		$sql = "SELECT * FROM products WHERE qty BETWEEN -1000000000 AND 10 ORDER BY qty ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function cekkadaluarsa()
	{
		$hariini = date('Y-m-d');
		$tglex = date('Y-m-d', strtotime($hariini . ' + 20 days'));

		$sql = "SELECT * FROM products WHERE kadaluarsa BETWEEN '$hariini' AND '$tglex' ORDER BY kadaluarsa ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getProductDatatampil($id)
	{
		$sql = "SELECT * FROM products WHERE ke LIKE  '%$id%' OR ke=0  ORDER BY name DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getActiveProductData($ke)
	{
		$sql = "SELECT * FROM products WHERE availability = 1 AND ke=0  OR ke LIKE '%$ke%'  ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function getActiveProductDataall()
	{
		$sql = "SELECT * FROM products WHERE availability = 1 ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if ($data) {
			$insert = $this->db->insert('products', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if ($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('products', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if ($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('products');
			return ($delete == true) ? true : false;
		}
	}

	public function countTotalProducts()
	{
		$sql = "SELECT * FROM products";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}


	public function getproduk()
	{
		$query = $this->db->query("SELECT products(tgl_input) as getproduk");
	}

	public function cetakpertanggal($tgl_awal, $tgl_akhir)
	{

		$query = $this->db->query("SELECT * FROM products WHERE tgl_input BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY tgl_input ASC");
		return $query->result();
	}



	//dashboard
	public function dsleaderall()
	{

		$sql = "SELECT * FROM products";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	//laporan masuk stock
	public function createstock($data)
	{
		if ($data) {
			$insert = $this->db->insert('products_l_stock_masuk', $data);
			return ($insert == true) ? true : false;
		}
	}
	public function getProductstockData($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM products_l_stock_masuk where id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM products_l_stock_masuk ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function cetakpertanggalmasukstock($tgl_awal, $tgl_akhir)
	{

		$query = $this->db->query("SELECT * FROM products_l_stock_masuk WHERE tgl_bmasuk BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY  tgl_bmasuk ASC");
		return $query->result();
	}

	public function kadaluarsa()
	{
		$sql = "SELECT * FROM products ORDER BY kadaluarsa DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function createlaporan()
	{
		$sql = "INSERT INTO products_l_harian (nama, sku, harga, qty, satuan, tgl ) SELECT name, sku, price, qty, satuan, trkhrup FROM products";
		$query = $this->db->query($sql);
		return ($query == true) ? true : false;
	}

	public function updatetgllaporan($data)
	{
		if ($data) {
			$sql = "UPDATE products SET trkhrup = '$data'";
			$update = $this->db->query($sql);
			return ($update == true) ? true : false;
		}
	}

	public function removelaporan($id)
	{
		if ($id) {
			$this->db->where('tgl', $id);
			$delete = $this->db->delete('products_l_harian');
			return ($delete == true) ? true : false;
		}
	}
	/* get the brand data */
	public function getlaporan($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM products_l_harian where id = ? ORDER BY id DESC";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM products_l_harian ORDER BY id DESC, sku DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function getlaporantgl($id)
	{
		$sql = "SELECT * FROM products_l_harian where tgl = '$id'";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}


	public function getbmasuktgl($id)
	{
		$sql = "SELECT * FROM products_l_stock_masuk where tgl_bmasuk = '$id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}
