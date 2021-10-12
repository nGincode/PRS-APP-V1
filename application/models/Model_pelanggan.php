<?php

class Model_pelanggan extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}



	public function getpelangganid($store_id)
	{

		$sql = "SELECT * FROM pelanggan WHERE store_id = $store_id ORDER BY tgl DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function getpelanggan()
	{

		$sql = "SELECT * FROM pelanggan ORDER BY tgl DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function getpelanggantgl($tgl_awal, $tgl_akhir)
	{

		$sql = "SELECT * FROM pelanggan WHERE tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY tgl DESC, store ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function cektgl($tgl)
	{
		$sql = "SELECT * FROM pelanggan WHERE tgl = '$tgl'";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}


	public function create($data)
	{
		if ($data) {
			$insert = $this->db->insert('pelanggan', $data);
			return ($insert == true) ? true : false;
		}
	}




	public function delete($id)
	{
		$this->db->where('id', $id);
		$delete = $this->db->delete('pelanggan');
		return ($delete == true) ? true : false;
	}












	public function getomzetidedit($store_id, $id)
	{

		$sql = "SELECT * FROM omzet WHERE store_id = $store_id AND id=$id ORDER BY tgl ASC";
		$query = $this->db->query($sql);
		return $query->row_array();
	}






	public function edit($data, $id)
	{
		$this->db->where('id', $id);
		$insert = $this->db->update('omzet', $data);
		return ($insert == true) ? true : false;
	}
}
