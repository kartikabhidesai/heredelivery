<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About_us extends CI_Controller {
	
	        function __construct()
			  {
				parent::__construct();
				
				 $this->load->model('admin/Home_model');
				 
			  }


public function index()
  {
	        if($this->input->post('add')){
		
			$arr = array('detail'=>$this->input->post('detail'));
			$insert = $this->Home_model->insert('about_us',$arr);	
            if($insert){
				$this->session->set_flashdata('message', 'Page detail has been added successfully');
			    redirect('admin/About_us');
			}else{
				$this->session->set_flashdata('errmessage', 'Some problem occured please try after some time');
			    redirect('admin/About_us');
			}			
			
		}
		 if($this->input->post('update')){
		
			$arr = array('detail'=>$this->input->post('detail'));
			$insert = $this->Home_model->update('about_us',1,$arr);	
            if($insert){
				$this->session->set_flashdata('message', 'Page detail has been Updated successfully');
			    redirect('admin/About_us');
			}else{
				$this->session->set_flashdata('errmessage', 'Some problem occured please try after some time');
			    redirect('admin/About_us');
			}			
			
		}
	    $data["page"]="About_us";
		$data["view"] = $this->Home_model->get_single_row('about_us',array());
	    $this->load->view('admin/about_us',$data);
 }

 
   
}

