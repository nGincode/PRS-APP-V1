<?php

class Model_dapro extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}



	public function getdapro_bahanbaku($tgl_awal, $tgl_akhir)
	{

		$sql = "SELECT * FROM dapro_bahanbaku WHERE tipe = 1 AND tgl BETWEEN '$tgl_awal' AND '$tgl_akhir'  ORDER BY tgl ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getdapro_bahanjadi()
	{

		$sql = "SELECT * FROM dapro_bahanjadi";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getorders_item($tgl_awal, $tgl_akhir, $store_id)
	{

		$sql = "SELECT * FROM orders_item WHERE store_id=$store_id and tgl_laporan BETWEEN '$tgl_awal' AND '$tgl_akhir'  ORDER BY tgl_laporan ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function getdaproid($id)
	{

		$sql = "SELECT * FROM dapro_bahanbaku WHERE product_id=$id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function status_up($id)
	{

		$sql = "SELECT * FROM orders_item WHERE id=$id";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function uporder($data, $id)
	{
		if ($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('orders_item', $data);
			return ($update == true) ? true : false;
		}
	}

	public function upbahanmetah($data)
	{
		if ($data) {
			$insert = $this->db->insert('dapro_bahanbaku', $data);
			return ($insert == true) ? true : false;
		}
	}


	public function insertbahanjadi($data)
	{
		if ($data) {
			$insert = $this->db->insert('dapro_bahanjadi', $data);
			return ($insert == true) ? true : false;
		}
	}




	public function getproduct_id()
	{

		$sql = "SELECT DISTINCT product_id, nama_produk FROM dapro_bahanbaku";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getitemresep($id)
	{
		$sql = "SELECT * FROM penjualan_resep_id WHERE idpenjualanresep = $id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getresepstore()
	{
		$sql = "SELECT * FROM penjualan_resep WHERE store_id=7";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}
