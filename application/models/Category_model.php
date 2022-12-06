<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

	public function addCategory($data)
	{
		$this->db->insert('category', $data);
	}

	public function getCategories()
	{
		$this->db->select('c.*, p.name as parent_name, count(pd.id) as products');
		$this->db->from('category c');
		$this->db->join('category p','p.id=c.parentid','left');
		$this->db->join('product pd','pd.categoryid=c.id','left');
		$this->db->where('c.status=1');
		$this->db->group_by('c.id');
		$query = $this->db->get();
		return  $query->result_array();

	}

	public function getCategory($id)
	{
		$this->db->select('c.*');
		$this->db->from('category c');
		$this->db->where('c.status=1');
		$this->db->where('c.id='.$id);
		$query = $this->db->get();
		return  $query->result_array();
	}

	public function getParentChildren($parentid)
	{
		$this->db->select('c.*');
		$this->db->from('category c');
		$this->db->where('c.status=1');
		$this->db->where('c.parentid='.$parentid);
		$query = $this->db->get();
		return  $query->result_array();
	}
	
	public function updateCategory($update, $where){
		$this->db->set($update);
		$this->db->where($where);
		$this->db->update('category'); 
	}
}
