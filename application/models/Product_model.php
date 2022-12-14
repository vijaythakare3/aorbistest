<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {
	public function getCategories(){

	}

	public function addProduct($data)
	{
		$this->db->insert('product', $data);
	}

	public function getProducts()
	{
		$this->db->select('p.*, c.name as category_name');
		$this->db->from('product p');
		$this->db->join('category c','p.categoryid = c.id','inner');
		$this->db->where('p.status=1');
		$query = $this->db->get();
		return  $query->result_array();

	}

	public function getProduct($id)
	{
		$this->db->select('c.*');
		$this->db->from('product c');
		$this->db->where('c.status=1');
		$this->db->where('c.id='.$id);
		$query = $this->db->get();
		return  $query->result_array();
	}
	
	public function updateProduct($update, $where){
		$this->db->set($update);
		$this->db->where($where);
		$this->db->update('product'); 
	}

	public function getParentChildren($parentid)
	{
		$this->db->select('c.id, c.name,c.parentid,p.name as parent_name');
		$this->db->from('category c');
		$this->db->join('category p','p.id = c.parentid','left');
		$this->db->where('c.status=1');
		$this->db->where('c.parentid='.$parentid);
		$query = $this->db->get();
		return  $query->result_array();
	}
	public function getCatgoryProducts($catid)
	{
		$this->db->select('p.name, p.price, p.productimage');
		$this->db->from('product p');
		$this->db->where('p.status=1');
		$this->db->where('p.categoryid='.$catid);
		$query = $this->db->get();
		return  $query->result_array();
	}

}
