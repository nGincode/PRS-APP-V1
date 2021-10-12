<?php 

class Model_pelaporan extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}



//ambil data user_id
	public function getpelaporanuser($id)
	{
        if($id) {
			$sql = "SELECT * FROM pelaporan where user_id = ?  ORDER BY id DESC";
			$query = $this->db->query($sql, array($id));
			return $query->result_array(); //kode khusus where
		}
	}

//ambil data store_id
	public function getpelaporanstore($id)
	{
        if($id) {
			$sql = "SELECT * FROM pelaporan where store_id = ?  ORDER BY id DESC";
			$query = $this->db->query($sql, array($id));
			return $query->result_array(); //kode khusus where
		}
	}


//ambil data divisi
	public function getpelaporandiv($id, $div)
	{
        if($id) {
			$sql = "SELECT * FROM pelaporan where store_id = $id AND divisi = $div  ORDER BY id DESC";
			$query = $this->db->query($sql);
			return $query->result_array(); //kode khusus where
		}
	}

//ambil data seluruh
	public function getpelaporanseluruh()
	{
			$sql = "SELECT * FROM pelaporan  ORDER BY id DESC";
			$query = $this->db->query($sql);
			return $query->result_array(); 
	}
//ambil data id
		public function getpelaporanid($id = null)
	{
		  if($id) {
			$sql = "SELECT * FROM pelaporan where id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}
	}





	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('pelaporan', $data);
			return ($insert == true) ? true : false;
		}
	}
	
	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('pelaporan', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('pelaporan');
			return ($delete == true) ? true : false;
		}
	}


	
}