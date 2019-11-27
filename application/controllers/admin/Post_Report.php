<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post_Report extends CI_Controller {
	
	        function __construct()
			  {
				parent::__construct();
				
				 $this->load->model('admin/Home_model');
				
				 
			  }


public function index()
  {
     $data["view"]=$this->Home_model->get_tbl_data_order('report_post',array("is_delete"=>0));
     $this->load->view('admin/report_post',$data);
 }
 
 public function get_user($user_id)
 {
     $user_data=$this->Home_model->get_single_row('users',array("id"=>$user_id));
     if(!empty($user_data))
     {
         return $user_data->username;
     }
     else
     {
         $a="";
         return $a; 
     }
 }
 
 
 
   public function get_user_full_name($user_id)
 {
     $user_data=$this->Home_model->get_single_row('users',array("id"=>$user_id));
     if(!empty($user_data))
     {
         $a=$user_data->frist_name." ".$user_data->last_name;
     }
     else
     {
         $a="";
     }
     return $a;
 }
 
 
 public function view_post($post_id)
 {
       $data["view"]=$this->Home_model->get_single_row('post',array("id"=>$post_id));
        $this->load->view('admin/view_post',$data);
 }
 
 
 public function delete($id,$list_id)
    {
		$this->Home_model->update('post',$id,array("is_delete"=>1));
		$this->Home_model->update('report_post',$list_id,array("is_delete"=>1));
		 $update_notification=$this->Home_model->update_where('notification',array('post_id'=>$id),array('is_delete'=>1));
		$this->session->set_flashdata('message','Post Delete Successfully');
		redirect('admin/Post_Report');
    }
 
 public function delete_post($id)
 {
     	$this->Home_model->update('post',$id,array("is_delete"=>1));
     	$this->Home_model->updatewhere('report_post','post_id',$id,array("is_delete"=>1));
     	$update_notification=$this->Home_model->update_where('notification',array('post_id'=>$id),array('is_delete'=>1));
     		$this->session->set_flashdata('message','Post Delete Successfully');
		redirect('admin/Post_Report');
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
 
//  public function delete($id)
//     {
// 		$this->Home_model->delete('users','id',$id);
// 		$this->session->set_flashdata('message','User delete successfully');
// 		redirect('admin/Users');
//     }
	

    


  
      
}

