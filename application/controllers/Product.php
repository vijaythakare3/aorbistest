<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	public function index()
	{
		$hdata= array('title'=>'Add Product');

		$categories = array();
        $this->load->model("Product_model","product_model");

        //get categories with children, grand children etc
        $categories =  $this->getChildrenCategoies(0, $this->product_model);
        $catstr = $this->breadCrumb($categories);
		//associative sort to preserve key
		asort($catstr);
		
		$data = array(
			'categories' => $catstr,
			'error' => '',
		);
		if($this->input->post()){
			$this->load->library('form_validation');

            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('price', 'Price', 'required|greater_than_equal_to[0]');
            $this->form_validation->set_rules('categoryid', 'Category', 'required');

            if ($this->form_validation->run())
            {

				$config['upload_path']          = FCPATH.'uploads/';
                $config['allowed_types']        = 'JPEG|JPG|jpeg|jpg|png|PNG';

                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('image'))
                {
                    $data['error'] = $this->upload->display_errors();
                }
                else
                {
                    $image = $this->upload->data();
                    $imagename = $image['file_name'];
                }
                if($data['error']==''){
	                //add record
	                $add = array(
	                	'name'		=> $this->input->post("name"),
	                	'categoryid'=> $this->input->post("categoryid"),
	                	'price'		=> $this->input->post("price"),
	                	'productimage'=> $imagename,
	                );
	                $this->product_model->addProduct($add);
	          		redirect(base_url()."index.php/product/list");
                }
            }
		}
		$this->load->view('header',$hdata);
		$this->load->view('product/add',$data);
		$this->load->view('footer');
	}

	private function breadCrumb($categories){
        $catstr = [];
        //for each cateogry prepare menu string in array format
		foreach ($categories as $key => $cat) {
			if(isset($cat['children'])){
				$array = $this->catString($cat['children'], $cat['name']);//children, parentname
				$catstr = ($array + $catstr);
			}
			else{
				$catstr[ $cat['id'] ] = $cat['name'];
			}
		}
		return $catstr;
	}

	//prepare breadcrum string and return array
	private function catString($children, $parent){
		$main = [];
		foreach($children as $child){
			if(isset($child['children'])){
				$array = $this->catString($child['children'], $parent.'->'.$child['name']);//children, parentname
				$main = ($array+$main);
			}else{
				$main[ $child['id'] ] = $parent.'->'.$child['name'];
			}
		}
		return $main;
	}

	//recursive function
	private function getChildrenCategoies($parentid, $model){
	   	$categories = $model->getParentChildren( $parentid );
	   	$res = array();
	   	$name = array();
	   	if($categories){
		   	foreach ($categories as $key => &$value) {
		   		$name[] = $value['name']; 
		   		$res = $this->getChildrenCategoies($value['id'], $model);
		   		if($res){
		   			$value['children'] = $res;
		   		}
		   	}
	  
	   	}
	   	return $categories;
	}

	public function list(){
		$hdata= array('title'=>'Product List');
		
		$this->load->model("Product_model","product_model");
        $products = $this->product_model->getProducts();
		$data = array(
			'products' => $products
		);
		
		$this->load->view('header',$hdata);
		$this->load->view('product/list',$data);
		$this->load->view('footer');
	}

	public function edit($id){
		$hdata= array('title'=>'Edit Product');
		
		$this->load->model("Product_model","product_model");

        //get categories with children, grand children etc
        $categories =  $this->getChildrenCategoies(0, $this->product_model);
        $catstr = $this->breadCrumb($categories);
		//associative sort to preserve key
		asort($catstr);
		
        $details = $this->product_model->getProduct($id);
		$data = array(
			'categories' => $catstr,
			'id' => $id,
			'detail' => $details[0],
			'error'=>''
		);

		if($this->input->post()){
			$this->load->library('form_validation');

            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('price', 'Price', 'required|greater_than_equal_to[0]');
            $this->form_validation->set_rules('categoryid', 'Category', 'required');

            if ($this->form_validation->run())
            {
                //update record
                $update = array(
                	'name'		=> $this->input->post("name"),
                	'categoryid'=> $this->input->post("categoryid"),
                	'price'		=> $this->input->post("price"),
                );

            	if(!empty($_FILES['image']['name']) ){

					$config['upload_path']          = FCPATH.'uploads/';
	                $config['allowed_types']        = 'JPEG|JPG|jpeg|jpg|png|PNG';

	                $this->load->library('upload', $config);

	                if ( ! $this->upload->do_upload('image'))
	                {
	                    $data['error']= $this->upload->display_errors();
						print_r($error);
	                }
	                else
	                {
	                    $image = $this->upload->data();
                		$update['productimage'] = $image['file_name'];
	                }
            	}
            	if($data['error']==''){
	                $this->product_model->updateProduct($update, array('id'=> $id ) );
	          		redirect(base_url()."index.php/product/list");
            	}
            }
		}
		
		$this->load->view('header',$hdata);
		$this->load->view('product/edit',$data);
		$this->load->view('footer');
	}

	public function delete(){

		if($this->input->post()){
			$this->load->library('form_validation');

            $this->form_validation->set_rules('id', 'Id', 'required|is_natural_no_zero');

            if ($this->form_validation->run())
            {
				$this->load->model("Product_model","product_model");

                //update record
                $update = array(
                	'status'=> '0',
                	'update_date'=> date("Y-m-d H:i:s"),
                );
                $this->product_model->updateProduct($update,array('id'=>$this->input->post("id")));

				$return = array(
					'status'=> 'success',
					'message'=> 'Product deleted successfully',
				);
            }
            else{
				$return = array(
					'status'=> 'error',
					'message'=> 'Invalid record to delete',
				);
            }
		}else{
			$return = array(
				'status'=> 'error',
				'message'=> 'Invalid data',
			);
		}
		echo json_encode($return);
	}//end delete

	public function shop()
	{
		$hdata = array('title'=>'Shop Product');

        $this->load->model("Product_model","product_model");

        //get categories with children, grand children etc
        $categories =  $this->getChildrenCategoies(0, $this->product_model);
        $catstr = $this->breadCrumb($categories);
		//associative sort to preserve key
		asort($catstr);
		
		$data = array(
			'categories' => $catstr,
		);

		$this->load->view('header',$hdata);
		$this->load->view('product/shop',$data);
		$this->load->view('footer');	
	}

	public function getProducts($value='')
	{
		if($this->input->post()){
			$this->load->library('form_validation');

            $this->form_validation->set_rules('id', 'Id', 'required|is_natural_no_zero');

            if ($this->form_validation->run())
            {
				$this->load->model("Product_model","product_model");

                $records = $this->product_model->getCatgoryProducts($this->input->post("id"));

				$return = array(
					'status'=> 'success',
					'message'=> count($records).' products found',
					'data'=> $records,
				);
            }
            else{
				$return = array(
					'status'=> 'error',
					'message'=> 'Invalid category. Please select valid category',
				);
            }
		}else{
			$return = array(
				'status'=> 'error',
				'message'=> 'Invalid data',
			);
		}
		echo json_encode($return);
	

	}

}
