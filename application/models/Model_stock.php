<?php

class Model_stock extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	//ambil data divisi nama stock
	public function getstocknamediv($id, $bg)
	{
		if ($id) {
			$sql = "SELECT * FROM stock_databarang where bagian = $bg and store_id = $id  ORDER BY id DESC";
			$query = $this->db->query($sql);
			return $query->result_array(); //kode khusus where
		}
	}

	public function databarang($data)
	{
		if ($data) {
			$insert = $this->db->insert('stock_databarang', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function updatestock($data, $id)
	{
		if ($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('stock', $data);
			return ($update == true) ? true : false;
		}
	}

	public function updatestockperproduk($data, $id)
	{
		if ($data && $id) {
			$this->db->where('produk_id', $id);
			$update = $this->db->update('stock', $data);
			return ($update == true) ? true : false;
		}
	}

	public function createstock($data)
	{
		if ($data) {
			$insert = $this->db->insert_batch('stock', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function validasisama($produk_id, $tgl)
	{
		$sql = "SELECT * FROM stock WHERE produk_id = '$produk_id' AND tgl = '$tgl'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function getstockDatabyid($id)
	{
		$sql = "SELECT * FROM stock WHERE id =' $id'";
		$query = $this->db->query($sql, array($id));
		return $query->row_array();
	}

	public function getstockdiv($id, $bg, $dari, $sampai)
	{
		if ($id) {
			$sql = "SELECT * FROM stock where bagian = '$bg' and store_id = '$id' AND tgl BETWEEN '$dari' AND '$sampai' ORDER BY id DESC";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
	}

	public function getstockDatabyuserid($user_id)
	{
		$sql = "SELECT * FROM stock WHERE user_id = '$user_id'";
		$query = $this->db->query($sql, array($user_id));
		return $query->result_array();
	}
	public function getstockDatabystoreid($store_id, $dari, $sampai)
	{
		$sql = "SELECT * FROM stock WHERE store_id = '$store_id' AND tgl BETWEEN '$dari' AND '$sampai' ORDER BY tgl DESC, produk_id DESC";
		$query = $this->db->query($sql, array($store_id));
		return $query->result_array();
	}

	public function getstockDatabyall($dari, $sampai)
	{
		$sql = "SELECT * FROM stock WHERE tgl BETWEEN '$dari' AND '$sampai' ORDER BY tgl DESC, produk_id DESC ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getstockDatabyoutlet($id, $dari, $sampai)
	{
		$sql = "SELECT * FROM stock WHERE store_id = '$id' AND tgl BETWEEN '$dari' AND '$sampai' ORDER BY tgl DESC, produk_id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getnamastock($bagian, $user_id = null)
	{
		if ($user_id) {
			$sql = "SELECT * FROM stock_databarang WHERE bagian = '$bagian' AND user_id = '$user_id' ORDER BY id DESC, nama_produk DESC";
			$query = $this->db->query($sql, array($bagian, $user_id));
			return $query->result_array();
		}
	}

	public function getnamastockall()
	{
		$sql = "SELECT * FROM stock_databarang ORDER BY id DESC, nama_produk DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getnamastockstore($store_id = null)
	{
		if ($store_id) {
			$sql = "SELECT * FROM stock_databarang WHERE  store_id = '$store_id' ORDER BY id DESC, nama_produk DESC";
			$query = $this->db->query($sql, array($store_id));
			return $query->result_array();
		}
	}

	public function getnamastockid($id = null)
	{

		if ($id) {
			$sql = "SELECT * FROM stock_databarang where id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM stock_databarang ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getstockbar($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM stock WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM stock ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getstockData($id = null)
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

	public function getnamastockidstore($bagian, $store_id, $kategory)
	{

		if ($bagian) {
			$sql = "SELECT * FROM stock_databarang where bagian = $bagian AND store_id = $store_id AND kategori = $kategory";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
	}

	public function remove($id)
	{
		if ($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('stock');
			return ($delete == true) ? true : false;
		}
	}

	public function exclaporan($outlet, $bagian, $tgl_awal, $tgl_akhir)
	{
		if ($bagian) {
			$proses1 = " bagian = " . $bagian . " and";
		} else {
			$proses1 = '';
		}

		if ($outlet) {
			$proses = "store_id = " . $outlet . " and";
		} else {
			$proses = '';
		}


		$sql = "SELECT * FROM stock WHERE $proses $proses1 tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY produk_id ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function view_data($tgl, $store_id, $bagian)
	{
		$sql = "SELECT * FROM stock WHERE tgl = '$tgl' AND store_id = '$store_id' AND bagian = '$bagian' ORDER BY produk_id ASC, tgl ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function view_data2($bagian, $store_id)
	{
		$sql = "SELECT * FROM stock_databarang WHERE bagian = $bagian AND store_id = $store_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function view_data3($bagian, $store_id, $tglawal, $tglakhir)
	{
		if ($bagian) {
			$b = 'bagian = ' . $bagian . ' AND';
		} else {
			$b = '';
		}
		$sql = "SELECT * FROM stock WHERE $b store_id = $store_id AND tgl BETWEEN '$tglawal' AND '$tglakhir' ORDER BY produk_id ASC, tgl ASC, bagian ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function view_tambah($bagian, $store_id)
	{
		$sql = "SELECT * FROM stock_databarang WHERE bagian = $bagian AND store_id = $store_id ORDER BY produk_id ASC, tgl ASC";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function view_akm($outlet, $tgl_awal, $tgl_akhir)
	{



		if ($outlet) {
			$proses = "store_id = " . $outlet . " and";
		} else {
			$proses = '';
		}

		$sql = "SELECT DISTINCT produk_id FROM stock WHERE $proses tgl BETWEEN '$tgl_awal' AND '$tgl_akhir'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function view_audit($bagian, $outlet, $tgl_awal, $tgl_akhir)
	{



		if ($outlet) {
			$proses = "store_id = " . $outlet . " and";
		} else {
			$proses = '';
		}

		$sql = "SELECT * FROM stock WHERE $proses  tgl BETWEEN '$tgl_awal' AND '$tgl_akhir'  and bagian = $bagian  and status > 0 or status < 0 and $proses  tgl BETWEEN '$tgl_awal' AND '$tgl_akhir'  and bagian = $bagian  ORDER BY nama_produk ASC, tgl ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function nama_produk($outlet, $bagian, $tgl_awal, $tgl_akhir)
	{


		if ($bagian) {
			$proses1 = " bagian = " . $bagian . " and";
		} else {
			$proses1 = '';
		}

		if ($outlet) {
			$proses = "store_id = " . $outlet . " and";
		} else {
			$proses = '';
		}
		$sql = "SELECT DISTINCT produk_id FROM stock WHERE $proses $proses1 tgl BETWEEN '$tgl_awal' AND '$tgl_akhir'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function ket($outlet, $bagian, $tgl_awal, $tgl_akhir)
	{


		if ($bagian) {
			$proses1 = " bagian = " . $bagian . " and";
		} else {
			$proses1 = '';
		}

		if ($outlet) {
			$proses = "store_id = " . $outlet . " and";
		} else {
			$proses = '';
		}
		$sql = "SELECT * FROM stock WHERE $proses $proses1 tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY tgl ASC ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function a_unit($produk_id, $outlet, $bagian, $tgl_awal, $tgl_akhir)
	{


		if ($bagian) {
			$proses1 = " bagian = " . $bagian . " and";
		} else {
			$proses1 = '';
		}

		if ($outlet) {
			$proses = "store_id = " . $outlet . " and";
		} else {
			$proses = '';
		}
		$sql = "SELECT a_unit FROM stock WHERE produk_id=$produk_id AND $proses $proses1 tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY id ASC LIMIT 1 ";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function uom($produk_id, $outlet, $bagian, $tgl_awal, $tgl_akhir)
	{


		if ($bagian) {
			$proses1 = " bagian = " . $bagian . " and";
		} else {
			$proses1 = '';
		}

		if ($outlet) {
			$proses = "store_id = " . $outlet . " and";
		} else {
			$proses = '';
		}
		$sql = "SELECT DISTINCT uom FROM stock WHERE produk_id=$produk_id AND $proses $proses1 tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function harga($produk_id, $outlet, $bagian, $tgl_awal, $tgl_akhir)
	{


		if ($bagian) {
			$proses1 = " bagian = " . $bagian . " and";
		} else {
			$proses1 = '';
		}

		if ($outlet) {
			$proses = "store_id = " . $outlet . " and";
		} else {
			$proses = '';
		}
		$sql = "SELECT DISTINCT harga FROM stock WHERE produk_id=$produk_id AND $proses $proses1 tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function t_unit($produk_id, $outlet, $bagian, $tgl_awal, $tgl_akhir)
	{


		if ($bagian) {
			$proses1 = " bagian = " . $bagian . " and";
		} else {
			$proses1 = '';
		}

		if ($outlet) {
			$proses = "store_id = " . $outlet . " and";
		} else {
			$proses = '';
		}
		$sql = "SELECT sum(t_unit) FROM stock WHERE produk_id=$produk_id AND $proses $proses1 tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY id DESC LIMIT 1 ";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function s_unit($produk_id, $outlet, $bagian, $tgl_awal, $tgl_akhir)
	{


		if ($bagian) {
			$proses1 = " bagian = " . $bagian . " and";
		} else {
			$proses1 = '';
		}

		if ($outlet) {
			$proses = "store_id = " . $outlet . " and";
		} else {
			$proses = '';
		}
		$sql = "SELECT s_unit FROM stock WHERE produk_id=$produk_id AND $proses $proses1 tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY id DESC LIMIT 1 ";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function unit($produk_id, $outlet, $bagian, $tgl_awal, $tgl_akhir)
	{


		if ($bagian) {
			$proses1 = " bagian = " . $bagian . " and";
		} else {
			$proses1 = '';
		}

		if ($outlet) {
			$proses = "store_id = " . $outlet . " and";
		} else {
			$proses = '';
		}
		$sql = "SELECT sum(unit) FROM stock WHERE produk_id=$produk_id AND $proses $proses1 tgl BETWEEN '$tgl_awal' AND '$tgl_akhir'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function reg($produk_id, $outlet, $bagian, $tgl_awal, $tgl_akhir)
	{


		if ($bagian) {
			$proses1 = " bagian = " . $bagian . " and";
		} else {
			$proses1 = '';
		}

		if ($outlet) {
			$proses = "store_id = " . $outlet . " and";
		} else {
			$proses = '';
		}
		$sql = "SELECT sum(reg) FROM stock WHERE produk_id=$produk_id AND $proses $proses1 tgl BETWEEN '$tgl_awal' AND '$tgl_akhir'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function pakai($produk_id, $outlet, $bagian, $tgl_awal, $tgl_akhir)
	{


		if ($bagian) {
			$proses1 = " bagian = " . $bagian . " and";
		} else {
			$proses1 = '';
		}

		if ($outlet) {
			$proses = "store_id = " . $outlet . " and";
		} else {
			$proses = '';
		}
		$sql = "SELECT sum(status) FROM stock WHERE produk_id=$produk_id AND $proses $proses1 tgl BETWEEN '$tgl_awal' AND '$tgl_akhir'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function tglawal($produk_id, $tgl_awal, $tgl_akhir)
	{

		$sql = "SELECT tgl FROM stock WHERE produk_id=$produk_id AND tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY id ASC LIMIT 1 ";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function produkid($produk_id)
	{
		$sql = "SELECT * FROM stock where produk_id=$produk_id ORDER BY id DESC LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function produkstock($produk_id)
	{
		$sql = "SELECT * FROM stock where produk_id=$produk_id";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function update($data, $id)
	{
		if ($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('stock_databarang', $data);
			return ($update == true) ? true : false;
		}
	}

	public function removedb($id)
	{
		if ($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('stock_databarang');
			return ($delete == true) ? true : false;
		}
	}

	public function tglstock($bagian, $store_id)
	{
		$sql = "SELECT tgl FROM stock WHERE bagian = $bagian AND store_id = $store_id ORDER BY id DESC LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
}
