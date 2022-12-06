<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$hdata= array('title'=>'Add Category');

		$categories = array();
        $this->load->model("Category_model","category_model");
        $categories = $this->category_model->getCategories();
		$data = array(
			'categories' => $categories
		);
		if($this->input->post()){
			$this->load->library('form_validation');

            $this->form_validation->set_rules('name', 'Name', 'required');

            if ($this->form_validation->run())
            {
                //add record
                $add = array(
                	'name'=> $this->input->post("name"),
                	'parentid'=> $this->input->post("parent")
                );
                $this->category_model->addCategory($add);
          		redirect(base_url()."index.php/category/list");
            }
		}
		$this->load->view('header',$hdata);
		$this->load->view('category/add',$data);
		$this->load->view('footer');
	}
	public function list(){
		$hdata= array('title'=>'Category List');
		
		$this->load->model("Category_model","category_model");
        $categories = $this->category_model->getCategories();
		$data = array(
			'categories' => $categories
		);
		
		$this->load->view('header',$hdata);
		$this->load->view('category/list',$data);
		$this->load->view('footer');
	}

	public function edit($id){
		$hdata= array('title'=>'Edit Category');
		
		$this->load->model("Category_model","category_model");
        $categories = $this->category_model->getCategories();
        $details = $this->category_model->getCategory($id);
		$data = array(
			'categories' => $categories,
			'id' => $id,
			'detail' => $details[0]
		);

		if($this->input->post()){
			$this->load->library('form_validation');

            $this->form_validation->set_rules('name', 'Name', 'required');

            if ($this->form_validation->run())
            {
                //update record
                $update = array(
                	'name'=> $this->input->post("name"),
                	'parentid'=> $this->input->post("parent"),
                	'update_date'=> date("Y-m-d H:i:s"),
                );
                $this->category_model->updateCategory($update,array('id'=>$id));
          		redirect(base_url()."index.php/category/list");
            }
		}
		
		$this->load->view('header',$hdata);
		$this->load->view('category/edit',$data);
		$this->load->view('footer');
	}

	public function delete(){

		if($this->input->post()){
			$this->load->library('form_validation');

            $this->form_validation->set_rules('id', 'Id', 'required|is_natural_no_zero');

            if ($this->form_validation->run())
            {
				$this->load->model("Category_model","category_model");

				//check if current category has any sub category.
                $res = $this->category_model->getParentChildren( $this->input->post("id") );

                if(empty($res)){
	                //update record
	                $update = array(
	                	'status'=> '0',
	                	'update_date'=> date("Y-m-d H:i:s"),
	                );
	                $this->category_model->updateCategory($update,array('id'=>$this->input->post("id")));

					$return = array(
						'status'=> 'success',
						'message'=> 'Record deleted successfully',
					);
                }else{
					$return = array(
						'status'=> 'error',
						'message'=> 'First delete child categories.',
					);
                }
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
