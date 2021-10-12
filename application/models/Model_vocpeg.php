<?php

class Model_vocpeg extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function select_all_employe()
	{
		$sql = "SELECT * FROM pegawai Where keluar=0  order by store_id DESC";
		$data = $this->db->query($sql);
		return $data->result();
	}

	public function voc_peg_data($id)
	{
		$sql = "SELECT * FROM voc_peg_data Where idpegawai='$id'  order by store_id DESC";
		$data = $this->db->query($sql);
		return $data->row_array();
	}

	public function datapegawai($id)
	{
		$sql = "SELECT * FROM pegawai Where id='$id'";
		$data = $this->db->query($sql);
		return $data->row_array();
	}

	public function create($data)
	{
		if ($data) {
			$insert = $this->db->insert('voc_peg_data', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function cek($id)
	{
		$this->db->where('nopegawai', $id);
		$data = $this->db->get('voc_peg_data');
		return $data->num_rows();
	}




	public function tampilnopegawai($id)
	{
		$sql = " SELECT *  FROM voc_peg_data WHERE nopegawai='$id' ";

		$data = $this->db->query($sql);

		return $data->row_array();
	}

	public function limit_voc()
	{
		$sql = "SELECT id, limit_voc FROM voc_peg_data";

		$data = $this->db->query($sql);

		return $data->result_array();
	}
	public function lj_voc()
	{
		$sql = "SELECT limit_voc, jml_voc FROM voc_peg_data";

		$data = $this->db->query($sql);

		return $data->result_array();
	}

	public function reset($id, $data)
	{
		if ($data) {

			$sql = "UPDATE voc_peg_data SET jml_voc='$data' WHERE id='$id' ";
			$data = $this->db->query($sql);
			return ($data == true) ? true : false;
		}
	}





	public function select_all_pakai()
	{
		$sql = "SELECT * FROM voc_peg_pakai ORDER BY id DESC";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_all($ses)
	{
		$sql = " SELECT *  FROM voc_peg_pakai where outlet ='$ses'  ORDER BY id DESC";

		$data = $this->db->query($sql);

		return $data->result();
	}
	public function select_all_tgl($dari, $sampai)
	{
		$sql = "SELECT * FROM voc_peg_pakai WHERE tgl BETWEEN '$dari' AND '$sampai' ORDER BY outlet DESC, tgl DESC";

		$data = $this->db->query($sql);

		return $data->result_array();
	}

	public function total_rows()
	{
		$data = $this->db->get('voc_peg_pakai');

		return $data->num_rows();
	}

	public function cekvoc($id)
	{
		$this->db->where('nopegawai', $id);
		$data = $this->db->get('voc_peg_data');
		return $data->row_array();
	}


	public function updatejmlvoc($id, $data, $data2)
	{
		if ($data && $data2) {
			$this->db->where('id', $id);
			$update = $this->db->update('voc_peg_data', $data);
			$update = $this->db->insert('voc_peg_pakai', $data2);
			return ($update == true) ? true : false;
		}
	}



	public function updategiv($id, $data)
	{
		if ($data) {
			$this->db->where('kode', $id);
			$update = $this->db->update('voc_giv_data', $data);
			return ($update == true) ? true : false;
		}
	}
}
