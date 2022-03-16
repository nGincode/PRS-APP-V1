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

	public function getdapro_bahanjadi($tgl_awal, $tgl_akhir)
	{

		$sql = "SELECT * FROM dapro_bahanjadi WHERE tgl BETWEEN '$tgl_awal' AND '$tgl_akhir'  ORDER BY tgl ASC";
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


	public function getdaprojadiid($id)
	{

		$sql = "SELECT * FROM dapro_bahanjadi WHERE id=$id";
		$query = $this->db->query($sql);
		return $query->row_array();
	}


	public function uploadsuksesitem($id)
	{
		$data = array(
			'up' => 1
		);
		$this->db->where('id', $id);
		$update = $this->db->update('dapro_bahanjadi', $data);
		return ($update == true) ? true : false;
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


	public function fetchbahanjaditgl($tglawal, $tglakhir)
	{

		if ($tglakhir) {
			$tgl =  "tgl BETWEEN '$tglawal' AND '$tglakhir'";
		} else {
			$tgl =  "tgl = '" . $tglawal . "'";
		}
		$sql = "SELECT DISTINCT idproduct FROM dapro_bahanjadi WHERE $tgl ORDER BY tgl ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function fetchbahanjaditglak($id, $tglawal, $tglakhir)
	{

		if ($tglakhir) {
			$tgl =  "tgl BETWEEN '$tglawal' AND '$tglakhir'";
		} else {
			$tgl =  "tgl = '" . $tglawal . "'";
		}

		$sql = "SELECT * FROM dapro_bahanjadi WHERE idproduct = $id AND $tgl ORDER BY tgl ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function fetchbahanbakutgl($tglawal, $tglakhir)
	{

		if ($tglakhir) {
			$tgl =  "tgl BETWEEN '$tglawal' AND '$tglakhir'";
		} else {
			$tgl =  "tgl = '" . $tglawal . "'";
		}

		$sql = "SELECT DISTINCT product_id FROM dapro_bahanbaku WHERE $tgl ORDER BY tgl ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function fetchbahankeluar($tglawal, $tglakhir)
	{

		if ($tglakhir) {
			$tgl =  "tgl BETWEEN '$tglawal' AND '$tglakhir'";
		} else {
			$tgl =  "tgl = '" . $tglawal . "'";
		}

		$sql = "SELECT DISTINCT product_id FROM dapro_bahanbaku WHERE keluar=1 AND $tgl ORDER BY tgl ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function fetchbahanbakutglak($id, $tglawal, $tglakhir)
	{


		if ($tglakhir) {
			$tgl =  "tgl BETWEEN '$tglawal' AND '$tglakhir'";
		} else {
			$tgl =  "tgl = '" . $tglawal . "'";
		}
		$sql = "SELECT * FROM dapro_bahanbaku WHERE product_id = $id AND $tgl ORDER BY tgl ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}




	public function fetchbahanjaditgl1($tglawal, $tglakhir)
	{

		if ($tglakhir) {
			$tgl =  "tgl BETWEEN '$tglawal' AND '$tglakhir'";
		} else {
			$tgl =  "tgl = '" . $tglawal . "'";
		}

		$sql = "SELECT DISTINCT idproduct FROM dapro_bahanjadi WHERE $tgl AND up = 1  ORDER BY tgl ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function fetchbahanjaditglak1($id, $tglawal, $tglakhir)
	{

		if ($tglakhir) {
			$tgl =  "tgl BETWEEN '$tglawal' AND '$tglakhir'";
		} else {
			$tgl =  "tgl = '" . $tglawal . "'";
		}

		$sql = "SELECT * FROM dapro_bahanjadi WHERE idproduct = $id AND $tgl AND up = 1  ORDER BY tgl ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function fetchbahanjaditglak2($id, $tglawal, $tglakhir)
	{

		if ($tglakhir) {
			$tgl =  "tgl BETWEEN '$tglawal' AND '$tglakhir'";
		} else {
			$tgl =  "tgl = '" . $tglawal . "'";
		}

		$sql = "SELECT * FROM dapro_bahanbaku WHERE product_id = $id AND $tgl  AND keluar=1  ORDER BY tgl ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}
