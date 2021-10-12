<?php

class Model_vocgif extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}



	public function select_all_tgl($dari, $sampai)
	{
		$sql = "SELECT * FROM voc_giv_data WHERE tglmasuk BETWEEN '$dari' AND '$sampai' ORDER BY  id DESC";

		$data = $this->db->query($sql);

		return $data->result_array();
	}

	public function givdata()
	{
		$sql = "SELECT * FROM voc_giv_data  ORDER BY outlet DESC, id DESC";

		$data = $this->db->query($sql);

		return $data->result_array();
	}




	public function namavoc($id)
	{
		$sql = "SELECT * FROM voc_giv_namavoc WHERE id = $id";

		$data = $this->db->query($sql);

		return $data->row_array();
	}


	public function namavocall()
	{
		$sql = "SELECT * FROM voc_giv_namavoc  ORDER BY id DESC";

		$data = $this->db->query($sql);

		return $data->result_array();
	}


	public function create($data)
	{
		if ($data) {
			$insert = $this->db->insert('voc_giv_namavoc', $data);
			return ($insert == true) ? true : false;
		}
	}
	public function validasinama($nama)
	{
		$this->db->where('nama', $nama);
		$data = $this->db->get('voc_giv_namavoc');
		return $data->num_rows();
	}


	public function createdata($data)
	{
		if ($data) {
			$insert = $this->db->insert('voc_giv_data', $data);
			return ($insert == true) ? true : false;
		}
	}
	public function cekvocer($kode)
	{
		$sql = " SELECT *
				 FROM voc_giv_data WHERE kode='$kode'";

		$data = $this->db->query($sql);

		return $data->num_rows();
	}

	public function ambilvocer($kode)
	{
		$sql = " SELECT *
				 FROM voc_giv_data WHERE kode='$kode'";

		$data = $this->db->query($sql);

		return $data->row_array();
	}

	public function select_asal($asal)
	{
		$sql = " SELECT *
				 FROM voc_giv_data WHERE asal = $asal  ORDER BY outlet DESC, id DESC";

		$data = $this->db->query($sql);

		return $data->result_array();
	}

	public function removenv($id)
	{
		if ($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('voc_giv_namavoc');
			return ($delete == true) ? true : false;
		}
	}


	public function cekdata($id)
	{
		$sql = " SELECT *
				 FROM voc_giv_data WHERE asal='$id' AND claim = 0";

		$data = $this->db->query($sql);

		return $data->num_rows();
	}
}
