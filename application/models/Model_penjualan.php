<?php

class Model_penjualan extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getitemresep($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM penjualan_item_resep WHERE id = ? ORDER BY id DESC";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM penjualan_item_resep ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function getitemprod($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM products WHERE id = ? ORDER BY id DESC";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM products Where tipe = 1";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function updateitemresepdata($id, $data)
	{
		if ($id && $data) {
			$this->db->where('id', $id);
			$update = $this->db->update('penjualan_item_resep', $data);
			return ($update == true) ? true : false;
		}
	}



	public function remove($id)
	{
		if ($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('penjualan_item_resep');
			return ($delete == true) ? true : false;
		}
	}



	public function removeitemresep($id)
	{
		if ($id) {
			$this->db->where('iditemresep', $id);
			$delete = $this->db->delete('penjualan_resep_id');
			return ($delete == true) ? true : false;
		}
	}



	public function create($data)
	{
		if ($data) {
			$insert = $this->db->insert('penjualan_item_resep', $data);
			return ($insert == true) ? true : false;
		}
	}


	public function createresep($data)
	{
		if ($data) {
			$insert = $this->db->insert('penjualan_resep', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function createitem($data)
	{

		if ($data) {
			$insert = $this->db->insert_batch('penjualan_resep_id', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function idresep()
	{
		$sql = "SELECT id FROM penjualan_resep ORDER BY id DESC Limit 1";
		$query = $this->db->query($sql);
		return $query->row_array();
	}



	public function getresep($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM penjualan_resep WHERE id = ? ORDER BY id DESC";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM penjualan_resep ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getresepitemid($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM penjualan_resep_id WHERE idpenjualanresep = ? ORDER BY iditemresep DESC";
			$query = $this->db->query($sql, array($id));
			return $query->result_array();
		}

		$sql = "SELECT * FROM penjualan_resep_id ORDER BY iditemresep DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function removepenjualan_resep_id($id)
	{
		if ($id) {
			$this->db->where('idpenjualanresep', $id);
			$delete = $this->db->delete('penjualan_resep_id');
			return ($delete == true) ? true : false;
		}
	}


	public function removepenjualan_resep($id)
	{
		if ($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('penjualan_resep');
			return ($delete == true) ? true : false;
		}
	}


	public function getimport($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM penjualan_import WHERE id = ? ORDER BY nama ASC";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM penjualan_import ORDER BY nama ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function getnamamenu($id)
	{

		$sql = "SELECT * FROM penjualan_resep WHERE nama_menu = '$id' ORDER BY nama_menu ASC";
		$query = $this->db->query($sql);
		return $query->row_array();
	}


	public function getnamaitemmenu($id)
	{

		$sql = "SELECT * FROM penjualan_item_resep WHERE nama = '$id'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}


	public function getnamamenustore($id)
	{


		if ($id) {
			$hasil = "WHERE store_id = '$id'";
		} else {
			$hasil = '';
		}
		$sql = "SELECT * FROM penjualan_resep  $hasil ORDER BY nama_menu ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}



	public function Updateitemresep($data)
	{
		if ($data) {
			$insert = $this->db->insert('penjualan_item_resep', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function getitemid($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM penjualan_resep_id WHERE iditemresep = ? ORDER BY iditemresep DESC";
			$query = $this->db->query($sql, array($id));
			return $query->result_array();
		}

		$sql = "SELECT * FROM penjualan_resep_id ORDER BY iditemresep DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getProductjadi()
	{
		$sql = "SELECT * FROM products where tipe = 2";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function removepenjualan_import()
	{
		$delete = $this->db->empty_table('penjualan_import');
		return ($delete == true) ? true : false;
	}

	public function getitemresepid($id)
	{
		$sql = "SELECT id,nama,satuan,harga FROM penjualan_item_resep WHERE id = $id ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->row_array();
	}


	public function cekresep($id)
	{
		$sql = "SELECT * FROM penjualan_resep_id WHERE iditemresep = $id";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}


	public function cekmenudupli($store, $id)
	{
		$sql = "SELECT * FROM penjualan_resep WHERE store_id = $store AND nama_menu = '$id'";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
}
