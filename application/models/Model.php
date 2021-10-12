<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model extends CI_Model
{
  private $table = 'penjualan_import';

  public function get($where)
  {
    return $this->db->get_where($this->table, $where);
  }

  public function getAll()
  {
    return $this->db->get($this->table);
  }

  public function getFields()
  {
    return $this->db->list_fields($this->table);
  }

  public function getCol()
  {
    return $this->db->get($this->table)->num_fields();
  }

  public function post($data)
  {
    $this->db->insert($this->table, $data);
  }

  public function update($where, $data)
  {
    $this->db->where('id', $where);
    $this->db->update($this->table, $data);
  }

  public function delete($where)
  {
    $this->db->where('id', $where);
    $this->db->delete($this->table);
  }

  public function post_batch($data)
  {
    $this->db->insert_batch($this->table, $data);
  }
}
