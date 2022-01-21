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


	public function getbelanjaterima()
	{
		$sql = "SELECT * FROM belanja WHERE status=1  ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function getbelanjaterimabyall($tgl_awal, $tgl_akhir, $store_id)
	{
		$sql = "SELECT * FROM belanja WHERE gudang_id=$store_id AND status=1 AND tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY id DESC ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getbarangjadibyall($tgl_awal, $tgl_akhir)
	{
		$sql = "SELECT * FROM dapro_bahanjadi WHERE  tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY id DESC ";
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
	public function getbelanjaDataBelanja($id)
	{

		$sql = "SELECT * FROM belanja WHERE gudang_id = $id ORDER BY id DESC, tgl DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function belanjaData($tgl_awal, $tgl_akhir)
	{
		$sql = " SELECT * FROM belanja WHERE tgl  BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY tgl DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function belanjaDatagudang($tgl_awal, $tgl_akhir, $id)
	{
		$sql = " SELECT * FROM belanja WHERE gudang_id = $id AND tgl  BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY tgl DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function databelanja($tgl, $tgl_awal, $tgl_akhir)
	{
		$sql = " SELECT * FROM belanja_item WHERE tgl='$tgl' AND tgl  BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY tgl DESC";
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

	public function uploadsukses($id)
	{
		$data = array(
			'upload' => 1
		);
		$this->db->where('id', $id);
		$update = $this->db->update('belanja', $data);
		return ($update == true) ? true : false;
	}
	public function uploadsuksesitem($id)
	{
		$data = array(
			'upload' => 1
		);
		$this->db->where('id', $id);
		$update = $this->db->update('belanja_item', $data);
		return ($update == true) ? true : false;
	}

	public function bekukan($id)
	{
		$data = array(
			'status' => 1
		);
		$this->db->where('id', $id);
		$update = $this->db->update('belanja', $data);
		return ($update == true) ? true : false;
	}
	public function ubahjumlah($id, $harga)
	{
		$data = array(
			'total' => $harga
		);
		$this->db->where('id', $id);
		$update = $this->db->update('belanja', $data);
		return ($update == true) ? true : false;
	}
}
