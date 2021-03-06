<?php

class Category_model extends CI_Model
{
    function index($limit, $offset, $count=true)
    {
        $data=$this->db->get('categories', $limit, $offset);
        return $data->result();
    }

    function all(){
        $data=$this->db->get('categories');
        return $data->result();
    }

    function getParents(){
        $data=$this->db->get_where('categories');
        return $data->result();
    }

    public function get_count() {
        return $this->db->count_all('categories');
    }

	function create($data)
	{
		$this->db->insert("categories", $data);
	}

	function getCategory($id)
	{
		return $this->db->get_where('categories', array('id' => $id))->row_array();
	}

	function update($id, $data)
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
