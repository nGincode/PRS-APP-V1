<?php

class Model_pegawai extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getpegawaiData($store_id)
	{

		$sql = "SELECT * FROM pegawai WHERE store_id = $store_id ORDER BY divisi ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function dsleader($store_id)
	{

		$sql = "SELECT * FROM pegawai WHERE store_id = $store_id";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}


	public function dsleaderall()
	{

		$sql = "SELECT * FROM pegawai";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function getpegawai()
	{

		$sql = "SELECT * FROM pegawai";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getpegawaiid($id)
	{

		$sql = "SELECT * FROM pegawai  WHERE id=$id ORDER BY divisi ASC";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function getapraisal()
	{

		$sql = "SELECT * FROM pegawai_apraisal ORDER BY store ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getabsenperid($id)
	{

		$sql = "SELECT * FROM pegawai_absen WHERE id=$id ";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function getabsenData($store_id)
	{

		$sql = "SELECT * FROM pegawai_absen WHERE store_id = $store_id AND waktu_masuk = 1 ORDER BY tgl DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function getabsen()
	{

		$sql = "SELECT * FROM pegawai_absen ORDER BY tgl DESC, nama DESC, id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getapresialData($store_id)
	{

		$sql = "SELECT * FROM pegawai_apraisal WHERE store_id = $store_id ORDER BY store_id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getapresialall()
	{

		$sql = "SELECT * FROM pegawai_apraisal ORDER BY store_id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getabsenDataid($store_id, $id)
	{

		$sql = "SELECT * FROM pegawai_absen WHERE store_id = $store_id AND id=$id ORDER BY divisi ASC, tgl ASC";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function getpegawaiDataid($id)
	{

		$sql = "SELECT * FROM pegawai WHERE id= $id ORDER BY divisi ASC";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function create($data)
	{
		if ($data) {
			$insert = $this->db->insert('pegawai', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function createapraisal($data)
	{
		if ($data) {
			$insert = $this->db->insert('pegawai_apraisal', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function edit($data, $id)
	{
		$this->db->where('id', $id);
		$insert = $this->db->update('pegawai', $data);
		return ($insert == true) ? true : false;
	}

	public function editabsen($data, $id)
	{
		$this->db->where('id', $id);
		$insert = $this->db->update('pegawai_absen', $data);
		return ($insert == true) ? true : false;
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$delete = $this->db->delete('pegawai');
		return ($delete == true) ? true : false;
	}


	public function removeappresial($id)
	{
		$this->db->where('id', $id);
		$delete = $this->db->delete('pegawai_apraisal');
		return ($delete == true) ? true : false;
	}

	public function deleteabsen($id)
	{
		$this->db->where('id', $id);
		$delete = $this->db->delete('pegawai_absen');
		return ($delete == true) ? true : false;
	}

	public function insertabsen($data)
	{
		$this->db->insert('pegawai_absen', $data);
		return $this->db->insert_id();
	}

	public function cekdulikatabsenm($tgl, $idpegawai, $waktu)
	{
		$sql = "SELECT * FROM pegawai_absen WHERE tgl = '$tgl' AND idpegawai = $idpegawai AND waktu_masuk = $waktu";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function ambiltanggalakhirmasuk($idpegawai, $waktu)
	{
		$sql = "SELECT * FROM pegawai_absen WHERE idpegawai = $idpegawai AND waktu_masuk = $waktu ORDER BY id DESC Limit 1";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function cekdulikatabsenk($tgl, $idpegawai, $waktu)
	{
		$sql = "SELECT * FROM pegawai_absen WHERE tgl = '$tgl' AND idpegawai = $idpegawai AND waktu_keluar = $waktu";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function excelabsensi($tgl_awal, $tgl_akhir, $store_id)
	{
		$query = $this->db->query("SELECT * FROM pegawai_absen WHERE store_id = $store_id AND tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' ");
		return $query->result_array();
	}

	public function excelabsensijudul($tgl_awal, $tgl_akhir, $store_id)
	{
		$query = $this->db->query("SELECT DISTINCT tgl FROM pegawai_absen WHERE store_id = $store_id AND tgl BETWEEN '$tgl_awal' AND '$tgl_akhir'");
		return $query->result_array();
	}

	public function namapegawai($store_id)
	{
		$query = $this->db->query("SELECT DISTINCT nama FROM pegawai_absen WHERE store_id = $store_id");
		return $query->result_array();
	}

	public function namapegawaiabsen($tgl_awal, $tgl_akhir, $store_id)
	{
		$query = $this->db->query("SELECT DISTINCT nama FROM pegawai WHERE store_id = $store_id AND tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY nama ASC");
		return $query->result_array();
	}

	public function excelmasuk($nama, $tgl, $store_id, $masuk)
	{
		$query = $this->db->query("SELECT * FROM pegawai_absen WHERE store_id = $store_id AND waktu_masuk = $masuk AND nama = '$nama' AND  tgl ='$tgl'");
		return $query->row_array();
	}

	public function excelkeluar($nama, $tgl, $store_id, $keluar)
	{
		$sql = "SELECT * FROM pegawai_absen WHERE store_id = $store_id AND nama = '$nama' AND waktu_keluar = $keluar AND tgl = '$tgl'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function Jumalahmasuk($nama, $tgl_awal, $tgl_akhir, $store_id, $masuk)
	{
		$sql = "SELECT * FROM pegawai_absen WHERE store_id = $store_id AND nama = '$nama' AND waktu_masuk = $masuk AND tgl BETWEEN '$tgl_awal' AND '$tgl_akhir'";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function terlambat($nama, $tgl_awal, $tgl_akhir, $store_id, $terlambat)
	{
		$sql = "SELECT * FROM pegawai_absen WHERE store_id = $store_id AND nama = '$nama' AND terlambat = $terlambat AND tgl BETWEEN '$tgl_awal' AND '$tgl_akhir'";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function jumlahlembur($nama, $tgl_awal, $tgl_akhir, $store_id, $lembur)
	{
		$sql = "SELECT * FROM pegawai_absen WHERE store_id = $store_id AND nama = '$nama' AND sift = $lembur AND tgl BETWEEN '$tgl_awal' AND '$tgl_akhir'";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function absenkeluar($store_id, $tgl, $pegawai)
	{

		$sql = "SELECT * FROM pegawai_absen WHERE store_id = $store_id AND tgl = '$tgl' AND idpegawai=$pegawai AND waktu_keluar = 1";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function absenkeluarkeof($tgl, $pegawai)
	{

		$sql = "SELECT * FROM pegawai_absen WHERE tgl = '$tgl' AND idpegawai=$pegawai AND waktu_keluar = 1";
		$query = $this->db->query($sql);
		return $query->row_array();
	}


	public function getabsenDatabystoreid($store_id, $dari, $sampai)
	{

		$sql = "SELECT * FROM pegawai_absen WHERE store_id = '$store_id' AND tgl BETWEEN '$dari' AND '$sampai' ORDER BY id DESC";
		$query = $this->db->query($sql, array($store_id));
		return $query->result_array();
	}


	public function getabsenDatabyoutlet($id, $dari, $sampai)
	{
		$sql = "SELECT * FROM pegawai_absen WHERE store_id = '$id' AND tgl BETWEEN '$dari' AND '$sampai' ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function getabsenDatabyall($dari, $sampai)
	{
		$sql = "SELECT * FROM pegawai_absen WHERE tgl BETWEEN '$dari' AND '$sampai' ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}



	public function getpegawaiDataaktiv($store_id)
	{

		$sql = "SELECT * FROM pegawai WHERE store_id = $store_id AND keluar = 0 ORDER BY divisi ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}
