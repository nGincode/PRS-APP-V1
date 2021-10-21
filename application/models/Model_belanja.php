<?php

class Model_belanja extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	public function create($data)
	{
		if ($data) {
			$insert = $this->db->insert_batch('belanja_item', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function createbelanja($data)
	{
		if ($data) {
			$insert = $this->db->insert('belanja', $data);
			return ($insert == true) ? true : false;
		}
	}
	public function editbelanja($id, $data)
	{
		if ($data) {
			$this->db->where('id', $id);
			$insert = $this->db->update('belanja', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function getakhirbelanja()
	{
		$sql = "SELECT * FROM belanja ORDER BY id DESC LIMIT 1 ";
		$query = $this->db->query($sql);
		return $query->row_array();
	}


	public function getbelanjaid($id)
	{
		$sql = "SELECT * FROM belanja_item WHERE belanja_id=$id  ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function jumlahtgl($tgl)
	{
		$sql = " SELECT * FROM belanja WHERE tgl = '$tgl'";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function getbelanjaData($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM belanja WHERE id = ? ORDER BY id DESC, tgl DESC";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM belanja ORDER BY id DESC, tgl DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function belanjaData($tgl_awal, $tgl_akhir)
	{
		$sql = " SELECT DISTINCT tgl FROM belanja WHERE tgl  BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY tgl DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function databelanja($tgl, $tgl_awal, $tgl_akhir)
	{
		$sql = " SELECT * FROM belanja WHERE tgl='$tgl' AND tgl  BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY tgl DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function remove($id)
	{
		if ($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('belanja');


			$this->db->where('belanja_id', $id);
			$delete = $this->db->delete('belanja_item');


			return ($delete == true) ? true : false;
		}
	}


	public function paid($id)
	{
		$data = array(
			'paid' => 1,
		);
		$this->db->where('id', $id);
		$baca = $this->db->update('belanja', $data);
		return ($baca) ? true : false;
	}
}
