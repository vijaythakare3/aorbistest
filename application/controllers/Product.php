<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	public function index()
	{
		$hdata= array('title'=>'Add Product');

		$categories = array();
        $this->load->model("Product_model","product_model");

        //get categories with parent, grand parent etc
        //
        $categories =  $this->getParent(0, $this->product_model);

        	// $categories = $this->product_model->getCategories();

		// foreach ($categories as $key => $value) {
		// 	echo $value['name'].'->';
		// 	if(isset($value['children'])){
		// 		echo $str = $this->catString($value['children']);
		// 	}else{
		// 		return $value['name']."|";
		// 	}
		// 	echo "<br>";
		// }

		// echo $this->catString($categories);

		// print_r("<pre>");
		// print_r($categories);
		// exit;

		$data = array(
			'categories' => $categories
		);
		if($this->input->post()){
			$this->load->library('form_validation');

            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('price', 'Price', 'required');
            // $this->form_validation->set_rules('categoryid', 'Category', 'required');
            // $this->form_validation->set_rules('image', 'Image', 'required');

            if ($this->form_validation->run())
            {

				$config['upload_path']          = FCPATH.'uploads/';
				// $config['upload_path']          = FCPATH.'application\uploads\\';
                $config['allowed_types']        = 'JPEG|JPG|jpeg|jpg|png|PNG';

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('image'))
                {
                    $error = array('error' => $this->upload->display_errors());
					print_r($error);
                }
                else
                {
                    $image = $this->upload->data();
                    $imagename = $image['file_name'];
                }

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
		$this->load->view('header',$hdata);
		$this->load->view('product/add',$data);
		$this->load->view('footer');
	}

	// private function catString($categories){
	// 	foreach ($categories as $key => $value) {
	// 		echo $value['name'];
	// 		if(isset($value['children'])){
	// 			echo '->';
	// 			$this->catString($value['children']);
	// 		}else{
	// 			echo $value['name']."|";
	// 		}
	// 	}
	// }

	//recursive function
	private function getParent($parentid, $model){
	   	$categories = $model->getParentChildren( $parentid );
	   	$res = array();
	   	$name = array();
	   	if($categories){
		   	foreach ($categories as $key => &$value) {
		   		$name[] = $value['name']; 
		   		$res = $this->getParent($value['id'], $model);
		   		if($res){
		   			$value['children'] =$res;
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
        $categories = $this->product_model->getCategories();
        $details = $this->product_model->getProduct($id);
		$data = array(
			'categories' => $categories,
			'id' => $id,
			'detail' => $details[0]
		);

		if($this->input->post()){
			$this->load->library('form_validation');

            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('price', 'Price', 'required');
            // $this->form_validation->set_rules('categoryid', 'Category', 'required');
            // $this->form_validation->set_rules('image', 'Image', 'required');

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
					// $config['upload_path']          = FCPATH.'application\uploads\\';
	                $config['allowed_types']        = 'JPEG|JPG|jpeg|jpg|png|PNG';

	                $this->load->library('upload', $config);

	                if ( ! $this->upload->do_upload('image'))
	                {
	                    $error = array('error' => $this->upload->display_errors());
						print_r($error);
	                }
	                else
	                {
	                    $image = $this->upload->data();
                		$update['productimage'] = $image['file_name'];
	                }
            	}

                $this->product_model->updateProduct($update, array('id'=> $id ) );
          		redirect(base_url()."index.php/product/list");
            }
		}
		
		$this->load->view('header',$hdata);
		$this->load->view('product/edit',$data);
		$this->load->view('footer');
	}

	public function delete(){

		if($this->input->post()){
			$this->load->library('form_validation');

            $this->form_validation->set_rules('id', 'Id', 'required');

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
}
