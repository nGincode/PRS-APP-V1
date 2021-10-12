<?php 

class Model_omzet extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}



	public function getomzetid($store_id) 
	{

		$sql = "SELECT * FROM omzet WHERE store_id = $store_id ORDER BY tgl ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function getomzetidedit($store_id, $id) 
	{

		$sql = "SELECT * FROM omzet WHERE store_id = $store_id AND id=$id ORDER BY tgl ASC";
		$query = $this->db->query($sql);
		return $query->row_array();
	}



	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('omzet', $data);
			return ($insert == true) ? true : false;
		}
	}



	public function delete($id)
	{
		$this->db->where('id', $id);
		$delete = $this->db->delete('omzet');
		return ($delete == true) ? true : false;
	}



	public function cektgl($tgl)
	{
		$sql = "SELECT * FROM omzet WHERE tgl = '$tgl'";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}



	public function edit($data,$id)
	{
			$this->db->where('id', $id);
			$insert = $this->db->update('omzet', $data);
			return ($insert == true) ? true : false;
	}





}