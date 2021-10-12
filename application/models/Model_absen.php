<?php 

class Model_absen extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}



	public function getabsen() 
	{

		$sql = "SELECT * FROM asbensi_terlambat ORDER BY tgl DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}




	public function getabsentgl($tglawal, $tglakhir) 
	{

		$sql = "SELECT * FROM asbensi_terlambat WHERE  tgl BETWEEN '$tglawal' AND '$tglakhir' ORDER BY tgl DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('asbensi_terlambat', $data);
			return ($insert == true) ? true : false;
		}
	}



	public function delete($id)
	{
		$this->db->where('id', $id);
		$delete = $this->db->delete('asbensi_terlambat');
		return ($delete == true) ? true : false;
	}






}