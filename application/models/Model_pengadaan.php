<?php

class Model_pengadaan extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	public function dsleader($store_id)
	{

		$sql = "SELECT * FROM pengadaan WHERE store_id = $store_id";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function dsleaderall()
	{
		$sql = "SELECT * FROM pengadaan";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}


	public function dsleaderdiv($div, $store_id)
	{

		$sql = "SELECT * FROM pengadaan WHERE divisi = '$div' AND store_id = '$store_id'";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	//ambil data user_id
	public function getpengadaanuser($id)
	{
		if ($id) {
			$sql = "SELECT * FROM pengadaan where user_id = ?  ORDER BY id DESC";
			$query = $this->db->query($sql, array($id));
			return $query->result_array(); //kode khusus where
		}
	}

	//ambil data store_id
	public function getpengadaanstore($id)
	{
		if ($id) {
			$sql = "SELECT * FROM pengadaan where store_id = ?  ORDER BY id DESC";
			$query = $this->db->query($sql, array($id));
			return $query->result_array(); //kode khusus where
		}
	}


	//ambil data divisi
	public function getpengadaandiv($id, $div)
	{
		if ($id) {
			$sql = "SELECT * FROM pengadaan where store_id = $id AND divisi = $div  ORDER BY id DESC";
			$query = $this->db->query($sql);
			return $query->result_array(); //kode khusus where
		}
	}

	//ambil data seluruh
	public function getpengadaanseluruh()
	{
		$sql = "SELECT * FROM pengadaan  ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	//ambil data id
	public function getpengadaanid($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM pengadaan where id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}
	}





	public function create($data)
	{
		if ($data) {
			$insert = $this->db->insert('pengadaan', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if ($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('pengadaan', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if ($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('pengadaan');
			return ($delete == true) ? true : false;
		}
	}
}
