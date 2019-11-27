<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	        function __construct()
			  {
				parent::__construct();
				
				 $this->load->model('admin/Home_model');
				 
			  }


public function index()
  {
	   
     $data["post"]=$this->Home_model->get_tbl_data('post',array());
     $data["users"]=$this->Home_model->get_tbl_data('users',array());
      $data["is_plus"]=$this->Home_model->get_tbl_data('users',array("is_plus"=>1));
    $this->load->view('admin/home',$data);
 }

// public function events(){
// 	$data['view']= $this->db->query("select * from events")->result() ;
// 	$this->load->view('admin/add_event',$data);
// }
// public function add_event(){
// 	$data['view']= '' ;
// 	$this->load->view('admin/add_event',$data);
// }
  
  
//   public function profile()
//   {
// 	  $this->load->model('admin/Login_admin_model') ;
// 	  $adminc = $this->Login_admin_model->user_() ;
// 	  if($this->input->post('userSubmit'))
// 	  {
		  
// 		 if($this->input->post('old_password'))
// 		{ 
// 		     if($this->input->post('old_password') == $adminc->password)
// 			 {
// 			 $user_ar = array('username' => $this->input->post('username'),
// 							 'email' => $this->input->post('email'),
// 							 'web_email' => $this->input->post('web_email'),
// 							 //'currency' => $this->input->post('currency'),
// 							 'password' => $this->input->post('password')
// 							 );
							 
// 				  $this->Login_admin_model->user_up($user_ar) ;	
// 				  $this->session->set_flashdata("successmessage","Data Updated") ;		 
// 			 }
// 			 else
// 			 {
// 		       $this->session->set_flashdata("message","Old password is wrong") ;
// 			 }
// 		}
// 		else
// 		{
// 		 $user_ar = array('username' => $this->input->post('username'),
// 						 'email' => $this->input->post('email'),
// 						 'web_email' => $this->input->post('web_email'),
// 						// 'currency' => $this->input->post('currency'),
// 						  ) ;
// 			 $this->Login_admin_model->user_up($user_ar) ;
// 			 $this->session->set_flashdata("successmessage","Data Updated") ;					  
// 		}
// 	  }
// 	  $data["view"] = $this->Login_admin_model->user_() ;
//       $this->load->view('admin/profile_setting',$data) ;
//   }
  
//   	public function change_password()
// 	{ 
// 	    $this->load->view('admin/change_password');
// 	}
	
// 	public function change_password_update()
// 	{
// 		$password=$this->input->post('password');
// 		$rpassword=$this->input->post('rpassword');
// 		if($password==$rpassword)
// 		{
// 		   $this->session->set_flashdata('message','Password Update successfully');
		   
// 		    $id=$this->session->userdata["admin_user"]["user_id"];
// 		   $password_data = array('password' => $password );
// 		   $this->Home_model->update('admin_user',$id,$password_data);
// 		}
// 		else
// 		{ 
// 			$this->session->set_flashdata('errmessage','Re-Password not match');
// 		}
// 	    redirect('admin/Home/change_password');
// 	}
	
// 	public function forget_password()
// 	{
// 	     if($this->input->post('forget'))
// 	    { 
// 	    $email= $this->input->post('email');
// 		//$bsd= base64_encode ($email);
// 		$chk=$this->Home_model->wheredetail('admin_user','email',$email);
//     		if($chk)
//     		{
//                 $id= $this->db->get_where('admin_user',['email'=>$email])->row()->id;
//                 $to = $email;
//                 $subject = "Forget password";
//                 $txt = "http://doudegajaora.com/permaflex/admin/Home/change_for_pass/$id;";
//                 $headers = "From: ";
//                 mail($to,$subject,$txt,$headers);
//     		}
//     		else
//     		{
//     		    $this->session->set_flashdata('errmessage','this email not registered');
//     		}
		
// 	    }
// 		$this->load->view('admin/forget');
// 	}

// 	public function change_for_pass($id)
// 	{  
	         
	     
// 	    if($this->input->post('set'))
// 	    {
//     	        $password=$this->input->post('password');
//     	        $id=$this->input->post('id');
//     		$rpassword=$this->input->post('rpassword');
//         		if($password==$rpassword)
//         		{
//         		   $this->session->set_flashdata('message','Password Update successfully');
        		   
        		    
//         		   $password_data = array('password' => $password );
//         		   $this->Home_model->update('admin_user',$id,$password_data);
//         		}
//         		else
//         		{ 
//         			$this->session->set_flashdata('errmessage','Re-Password not match');
//         		}
//     	    }
	    
// 	    $this->load->view('admin/email_forget',$id);
// 	}
	

	



  
      
}

