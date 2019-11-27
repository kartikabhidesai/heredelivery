<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_us extends CI_Controller {
	
	        function __construct()
			  {
				parent::__construct();
				
				 $this->load->model('admin/Home_model');
				 
			  }


public function index()
  {
	        if($this->input->post('add')){
		
			$arr = array('detail'=>$this->input->post('detail'));
			$insert = $this->Home_model->insert('contact_us',$arr);	
            if($insert){
				$this->session->set_flashdata('message', 'Page detail has been added successfully');
			    redirect('admin/Contact_us');
			}else{
				$this->session->set_flashdata('errmessage', 'Some problem occured please try after some time');
			    redirect('admin/Contact_us');
			}			
			
		}
		 if($this->input->post('update')){
		
			$arr = array('detail'=>$this->input->post('detail'));
			$insert = $this->Home_model->update('contact_us',1,$arr);	
            if($insert){
				$this->session->set_flashdata('message', 'Page detail has been Updated successfully');
			    redirect('admin/Contact_us');
			}else{
				$this->session->set_flashdata('errmessage', 'Some problem occured please try after some time');
			    redirect('admin/Contact_us');
			}			
			
		}
	    $data["page"]="Contact_us";
		$data["view"] = $this->Home_model->get_single_row('contact_us',array());
	    $this->load->view('admin/contact_us',$data);
 }

 
   
}

