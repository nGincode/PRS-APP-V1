<?php

class Model_ivn extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the brand data */


	//ambil data id
	public function getivnDataid($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM ivn where id = ? ORDER BY id DESC";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}
	}

	//ambil data Store
	public function getivnDatastore($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM ivn where store_id = ? ORDER BY divisi ASC";
			$query = $this->db->query($sql, array($id));
			return $query->result_array();
		}
	}
	public function getivnDatastorediv($id, $div)
	{
		if ($id) {
			$sql = "SELECT * FROM ivn where store_id = $id AND divisi=$div ORDER BY id DESC";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
	}

	//ambil data user_id
	public function getivnDatauser($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM ivn where user_id = ? ORDER BY id DESC";
			$query = $this->db->query($sql, array($id));
			return $query->result_array();
		}
	}

	//ambil data Semua
	public function getivnDatall()
	{
		$sql = "SELECT * FROM ivn ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array(); //kode khusus where
	}

	//ambil data laporan masuk Peruser
	public function getlaporaninputuser($id)
	{
		if ($id) {
			$sql = "SELECT * FROM ivn_lmasukb where user_id = ? ORDER BY id DESC";
			$query = $this->db->query($sql, array($id));
			return $query->result_array(); //kode khusus where
		}
	}

	//ambil data laporan masuk Peruser
	public function getlaporaninputstore($id)
	{
		if ($id) {
			$sql = "SELECT * FROM ivn_lmasukb where store_id = ? ORDER BY id DESC";
			$query = $this->db->query($sql, array($id));
			return $query->result_array(); //kode khusus where
		}
	}

	public function getlaporaninputstorediv($id, $div)
	{
		if ($id) {
			$sql = "SELECT * FROM ivn_lmasukb where store_id = $id AND divisi = $div ORDER BY id DESC";
			$query = $this->db->query($sql);
			return $query->result_array(); //kode khusus where
		}
	}

	public function getlaporaninput()
	{
		$sql = "SELECT * FROM ivn_lmasukb ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array(); //kode khusus where
	}

	public function create($data)
	{
		if ($data) {
			$insert = $this->db->insert('ivn', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if ($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('ivn', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if ($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('ivn');
			return ($delete == true) ? true : false;
		}
	}


	public function removebaru($id)
	{
		if ($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('ivn_lmasukb');
			return ($delete == true) ? true : false;
		}
	}
	public function removemasuk($id)
	{
		if ($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('ivn_lmasuk');
			return ($delete == true) ? true : false;
		}
	}
	public function removekeluar($id)
	{
		if ($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('ivn_lkeluar');
			return ($delete == true) ? true : false;
		}
	}
	public function removerusak($id)
	{
		if ($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('ivn_lrusak');
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




	//dashboard leader
	public function dsleader($ds_id)
	{

		if ($ds_id) {
			$sql = "SELECT * FROM ivn WHERE store_id=$ds_id";
			$query = $this->db->query($sql);
			return $query->num_rows();
		}
	}

	public function dsleaderall()
	{

		$sql = "SELECT * FROM ivn";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function dsleaderdiv($div, $store_id)
	{

		$sql = "SELECT * FROM ivn WHERE divisi='$div' AND store_id='$store_id'";
		$query = $this->db->query($sql);
		return $query->num_rows();
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






	//Laporan Keluar Inventaris
	public function createivnkeluar($data)
	{
		if ($data) {
			$insert = $this->db->insert('ivn_lkeluar', $data);
			return ($insert == true) ? true : false;
		}
	}
	public function getlaporankaluar($id)
	{
		if ($id) {
			$sql = "SELECT * FROM ivn_lkeluar where store_id = ? ORDER BY id DESC";
			$query = $this->db->query($sql, array($id));
			return $query->result_array(); //kode khusus where
		}
	}
	public function getlaporankaluardiv($id, $div)
	{
		if ($id) {
			$sql = "SELECT * FROM ivn_lkeluar where store_id = $id AND divisi = $div ORDER BY id DESC";
			$query = $this->db->query($sql);
			return $query->result_array(); //kode khusus where
		}
	}
	public function getlaporankaluarall()
	{
		$sql = "SELECT * FROM ivn_lkeluar ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	//Selesai




	//Laporan Inventaris Baru
	public function laporanbaru($data)
	{
		if ($data) {
			$insert = $this->db->insert('ivn_lmasukb', $data);
			return ($insert == true) ? true : false;
		}
	}
	public function cetakpertanggalbaru($tgl_awal, $tgl_akhir, $store_id)
	{
		$query = $this->db->query("SELECT * FROM ivn_lmasukb WHERE store_id = $store_id AND tgl_masuk  BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY tgl_masuk DESC");
		return $query->result_array();
	}
	//selesai











	//Laporan Inventaris Masuk
	public function createivn($data)
	{
		if ($data) {
			$insert = $this->db->insert('ivn_lmasuk', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function getivneditData($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM ivn where id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}
	}

	public function getlaporanmasukuser($id)
	{
		if ($id) {
			$sql = "SELECT * FROM ivn_lmasuk where user_id = ? ORDER BY id DESC";
			$query = $this->db->query($sql, array($id));
			return $query->result_array(); //kode khusus where
		}
	}

	public function getlaporanmasukstore($id)
	{
		if ($id) {
			$sql = "SELECT * FROM ivn_lmasuk where store_id = ? ORDER BY id DESC";
			$query = $this->db->query($sql, array($id));
			return $query->result_array(); //kode khusus where
		}
	}

	public function getlaporanmasukstorediv($id, $div)
	{
		if ($id) {
			$sql = "SELECT * FROM ivn_lmasuk where store_id = $id AND divisi = $div ORDER BY id DESC";
			$query = $this->db->query($sql);
			return $query->result_array(); //kode khusus where
		}
	}


	public function getlaporanmasuk()
	{
		$sql = "SELECT * FROM ivn_lmasuk  ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array(); //kode khusus where
	}

	public function cetakpertanggalmasukstore($tgl_awal, $tgl_akhir, $store_id)
	{

		$query = $this->db->query("SELECT * FROM ivn_lmasuk WHERE store_id = $store_id AND tgl_masuk BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY  tgl_masuk ASC");
		return $query->result_array();
	}
	//selesai








	//Laporan Inventaris Rusak

	public function createivnrusak($data)
	{
		if ($data) {
			$insert = $this->db->insert('ivn_lrusak', $data);
			return ($insert == true) ? true : false;
		}
	}
	public function getlaporanrusak($id)
	{
		if ($id) {
			$sql = "SELECT * FROM ivn_lrusak where store_id = ? ORDER BY id DESC";
			$query = $this->db->query($sql, array($id));
			return $query->result_array(); //kode khusus where
		}
	}
	public function getlaporanrusakdiv($id, $div)
	{
		if ($id) {
			$sql = "SELECT * FROM ivn_lrusak where store_id = $id AND divisi =$div ORDER BY id DESC";
			$query = $this->db->query($sql);
			return $query->result_array(); //kode khusus where
		}
	}
	public function getlaporanrusakall()
	{
		$sql = "SELECT * FROM ivn_lrusak ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function cetakpertanggalrusak($tgl_awal, $tgl_akhir, $store_id)
	{
		$query = $this->db->query("SELECT * FROM ivn_lrusak WHERE store_id = $store_id AND tgl_rusak BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY tgl_rusak DESC");
		return $query->result_array();
	}
	//selesai





	//Laporan Inventaris Keluar
	public function getlaporankeluar($id)
	{
		if ($id) {
			$sql = "SELECT * FROM ivn_lkeluar where user_id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->result_array(); //kode khusus where
		}
	}

	public function cetakpertanggalkeluar($tgl_awal, $tgl_akhir, $store_id)
	{
		$query = $this->db->query("SELECT * FROM ivn_lkeluar WHERE store_id = $store_id AND tgl_keluar BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY tgl_keluar DESC");
		return $query->result_array();
	}
	//selesai



	public function countarsip($user_id)
	{
		if ($user_id) {
			$sql = "SELECT * FROM ivn WHERE user_id = ?";
			$query = $this->db->query($sql, array($user_id));
			return $query->num_rows();
		}
	}



	public function arsip($user_id)
	{
		$sql = "INSERT INTO ivn_arsip (store, store_id, user_id, nama, bagian, keadaan, jumlah, bulan, tahun) SELECT store, store_id, user_id, nama, bagian, keadaan, jumlah, bulan, tahun FROM ivn WHERE user_id = $user_id";
		$query = $this->db->query($sql);
		return;
	}


	public function getarsip($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM ivn_arsip where store_id = ?  ORDER BY bulan ASC, bagian ASC, nama ASC, tahun DESC";
			$query = $this->db->query($sql, array($id));
			return $query->result_array(); //kode khusus where
		}

		$sql = "SELECT * FROM ivn_arsip ORDER BY bulan ASC, bagian ASC, nama ASC, tahun DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function ubahjmlmasuk($id, $data)
	{
		if ($data) {
			$this->db->where('id', $id);
			$update = $this->db->update('ivn_lmasuk', $data);
			return ($update == true) ? true : false;
		}
	}
	public function ubahhrgmasuk($id, $data)
	{
		if ($data) {
			$this->db->where('id', $id);
			$update = $this->db->update('ivn_lmasuk', $data);
			return ($update == true) ? true : false;
		}
	}
	public function ubahjmlbmasuk($id, $data)
	{
		if ($data) {
			$this->db->where('id', $id);
			$update = $this->db->update('ivn_lmasukb', $data);
			return ($update == true) ? true : false;
		}
	}
	public function ubahhrgbmasuk($id, $data)
	{
		if ($data) {
			$this->db->where('id', $id);
			$update = $this->db->update('ivn_lmasukb', $data);
			return ($update == true) ? true : false;
		}
	}
	public function ubahjmlkeluar($id, $data)
	{
		if ($data) {
			$this->db->where('id', $id);
			$update = $this->db->update('ivn_lkeluar', $data);
			return ($update == true) ? true : false;
		}
	}
	public function ubahhrgkeluar($id, $data)
	{
		if ($data) {
			$this->db->where('id', $id);
			$update = $this->db->update('ivn_lkeluar', $data);
			return ($update == true) ? true : false;
		}
	}
	public function ubahjmlrusak($id, $data)
	{
		if ($data) {
			$this->db->where('id', $id);
			$update = $this->db->update('ivn_lrusak', $data);
			return ($update == true) ? true : false;
		}
	}
	public function ubahhrgrusak($id, $data)
	{
		if ($data) {
			$this->db->where('id', $id);
			$update = $this->db->update('ivn_lrusak', $data);
			return ($update == true) ? true : false;
		}
	}
}
