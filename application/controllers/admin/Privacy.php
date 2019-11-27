<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Privacy extends CI_Controller {
	
	        function __construct()
			  {
				parent::__construct();
				
				 $this->load->model('admin/Home_model');
				 
			  }


public function index()
  {
	        if($this->input->post('add')){
		
			$arr = array('detail'=>$this->input->post('detail'));
			$insert = $this->Home_model->insert('privacy',$arr);	
            if($insert){
				$this->session->set_flashdata('message', 'Page detail has been added successfully');
			    redirect('admin/Privacy');
			}else{
				$this->session->set_flashdata('errmessage', 'Some problem occured please try after some time');
			    redirect('admin/Privacy');
			}			
			
		}
		 if($this->input->post('update')){
		
			$arr = array('detail'=>$this->input->post('detail'));
			$insert = $this->Home_model->update('privacy',1,$arr);	
            if($insert){
				$this->session->set_flashdata('message', 'Page detail has been Updated successfully');
			    redirect('admin/Privacy');
			}else{
				$this->session->set_flashdata('errmessage', 'Some problem occured please try after some time');
			    redirect('admin/Privacy');
			}			
			
		}
	    $data["page"]="Privacy";
		$data["view"] = $this->Home_model->get_single_row('privacy',array());
	    $this->load->view('admin/privacy',$data);
 }

 
   
}

