<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	
	        function __construct()
			  {
				parent::__construct();
				
				 $this->load->model('admin/Home_model');
				
				 
			  }


public function index()
  {
     $data["view"]=$this->Home_model->selectdata('users');
     $this->load->view('admin/users',$data);
 }
 
 public function is_plus($user_id,$action)
 {
     $futureDate=date('Y-m-d', strtotime('+1 year'));
     
     
      if($action=="1")
      {
           $this->Home_model->update('users',$user_id,array("is_plus"=>$action,"is_plus_enddate"=>$futureDate));
           $this->session->set_flashdata('message','Plus add successfully');
      }
      else
      {
           $this->Home_model->update('users',$user_id,array("is_plus"=>$action,"is_plus_enddate"=>"0000-00-00"));
           $this->session->set_flashdata('message','Plus Remove successfully');
      }
     redirect('admin/Users');
 }
 
//  public function add()
//  {
// 	 if($this->input->post('add')){
	
//                 $array=array('english_name'=>$this->input->post('english_name'),'french_name'=>$this->input->post('french_name'));
//                 $this->Home_model->insert('users',$array);
//                 $this->session->set_flashdata('message','Specific skills add successfully');
// 	 }
// 	 $this->load->view('admin/users');
//  }
 
//  public function edit($id)
//  {
//       if($this->input->post('update')=="save"){
//                 $array=array('english_name'=>$this->input->post('english_name'),'french_name'=>$this->input->post('french_name'));
//                 $this->Home_model->update('users',$id,$array);
//                 $this->session->set_flashdata('message','User update successfully');
           
// 	 }
// 	 $data["view"]=$this->Home_model->get_single_row('users',array("id"=>$id));
// 	 $this->load->view('admin/users',$data);
//  }
 
 public function delete($id)
    {
		$this->Home_model->delete('users','id',$id);
		$this->Home_model->delete('chat','sender_id',$id);
		$this->Home_model->delete('chat','receiver_id',$id);
		
		
			$this->Home_model->delete('friend_list','user_id_from',$id);
			$this->Home_model->delete('friend_list','user_id_to',$id);
			
				$this->Home_model->delete('response','user_id',$id);
		
	
	        $this->Home_model->update_where('comment',array('user_id'=>$id),array('is_delete'=>1));
		    $this->Home_model->update_where('notification',array('receiver_id'=>$id),array('is_delete'=>1));
		    $this->Home_model->update_where('notification',array('from_id'=>$id),array('is_delete'=>1));
		    
		    $this->Home_model->update_where('post',array('user_id'=>$id),array('is_delete'=>1));
		    $this->Home_model->update_where('report_comment',array('user_id'=>$id),array('is_delete'=>1));
		     $this->Home_model->update_where('report_post',array('user_id'=>$id),array('is_delete'=>1));
		    
		    
		    
		
		$this->session->set_flashdata('message','User delete successfully');
		redirect('admin/Users');
    }
	

    


  
      
}

