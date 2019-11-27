<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends CI_Controller {
	
	        function __construct()
			  {
				parent::__construct();
				
				 $this->load->model('admin/Home_model');
				
				 
			  }


public function index()
  {
     $data["view"]=$this->Home_model->get_tbl_data_order('post',array("is_delete"=>0));
     $this->load->view('admin/post',$data);
 }
 
 public function get_user($user_id)
 {
     $user_data=$this->Home_model->get_single_row('users',array("id"=>$user_id));
     if(!empty($user_data))
     {
         $a=$user_data->username;
     }
     else
     {
         $a="";
     }
     return $a;
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
         $a="Admin";
     }
     return $a;
 }
 
 
 public function add()
 {
	 if($this->input->post('add')){
	     
	     if(!empty($_FILES["image"]))
                {
                        foreach($_FILES["image"]["name"] as $filimgs => $fil)
        			   {
        				  $filed = $this->files("image",$filimgs) ; 
        				  if($filed)
        				  {
        				       
        				      $image[]=$filed;
        				  }
        			   }
        			    $image_str=implode(",",$image);
                }
                else
                {
                    
                    $image_str="";
                }
	
                $array=array('user_id'=>1,'post_text'=>$this->input->post('post_text'),'post_type'=>$this->input->post('post_type'),'image'=>$image_str,'created_on'=>date("Y-m-s H:i:s"));
                $this->Home_model->insert('post',$array);
                $this->session->set_flashdata('message','Post add successfully');
	 }
	 $this->load->view('admin/add_post');
 }
 
 
 
   public function files($name,$index)
  {
      if(!empty($_FILES[$name]['name'][$index]))
					{
					   
						$_FILES['file']['name'] = $_FILES[$name]['name'][$index];
						$_FILES['file']['tmp_name'] = $_FILES[$name]['tmp_name'][$index] ;
						$_FILES['file']['size'] = $_FILES[$name]['size'][$index] ;
						$config['upload_path'] = 'uploads/';
						$config['allowed_types'] = 'gif|jpg|png|jpeg';
					    $config['file_name'] = $_FILES['file']['name'];
				
						
						
						$photo=explode('.',$_FILES[$name]['name'][$index]); 
						$ext = strtolower($photo[count($photo)-1]); 
						if (!empty($_FILES[$name]['name'])) { 
					
							$curr_time = time(); 
							$filename= "_img_".time().".".$ext; 
							} 
						 $config['file_name'] = $filename; 
						
						//Load upload library and initialize configuration
						$this->load->library('upload',$config);
						$this->upload->initialize($config);
						
							if($this->upload->do_upload('file'))
							{
								 $uploadData = $this->upload->data();
							
								return $deal1image = "uploads/".$uploadData['file_name'];
							}else{
								return $deal1image = '';
							}
					}else{
					return	$deal1image = '' ;
					}
  }

 
 
 
 
 
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
		
		
        // 	
        	$this->Home_model->update('post',$id,array("is_delete"=>1));
     	$this->Home_model->updatewhere('report_post','post_id',$id,array("is_delete"=>1));
     	$update_notification=$this->Home_model->update_where('notification',array('post_id'=>$id),array('is_delete'=>1));
     		$this->session->set_flashdata('message','Post Delete Successfully');
        // 
		redirect('admin/Post');
    }
	

    


  
      
}

