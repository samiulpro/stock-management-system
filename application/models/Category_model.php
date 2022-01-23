<?php

class Category_model extends CI_Model
{
	function index()
	{
		$data = $this->db->get("categories");
		return $data->result();
	}

	function create($data)
	{
		$this->db->insert("categories", $data);
	}

	function get_category($id)
	{
		return $this->db->get_where('categories', array('id' => $id))->row_array();
	}

	function update_category($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('categories', $data);
	}

	function delete_category($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('categories');
	}
}
