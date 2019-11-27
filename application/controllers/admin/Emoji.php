<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emoji extends CI_Controller {
	
	        function __construct()
			  {
				parent::__construct();
				
				 $this->load->model('admin/Home_model');
				 
			  }


public function index()
  {
   $data["view"]=$this->Home_model->get_tbl_data('emoji',array());
    $this->load->view('admin/emoji',$data);
 }
 public function add()
 {
     if($this->input->post('add')=="save")
     {
          if(!empty($_FILES['emoji']['name']))
					{ 
					    $_FILES['emoji']['name']; 
						$_FILES['file']['name'] = $_FILES['emoji']['name'];
						$_FILES['file']['tmp_name'] = $_FILES['emoji']['tmp_name'] ;
						$_FILES['file']['size'] = $_FILES['emoji']['size'] ;
						$config['upload_path'] = 'uploads/emojies';
						$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc';
					 	$config['file_name'] = $_FILES['file']['name'];
						
						
						$photo=explode('.',$_FILES['emoji']['name']); 
						$ext = strtolower($photo[count($photo)-1]); 
						if (!empty($_FILES['emoji']['name'])) { 
						
							$curr_time = time(); 
							 $filename= $this->input->post('name')."_emoji_".time().".".$ext; 
							} 
						 $config['file_name'] = $filename; 
						
						//Load upload library and initialize configuration
						$this->load->library('upload',$config);
						$this->upload->initialize($config);
						
							if($this->upload->do_upload('file'))
							{
								 $uploadData = $this->upload->data();
								 $deal1image = "uploads/emojies/".$uploadData['file_name'];
							}else{
								$deal1image ='';
							}
					}else{
							$deal1image ='';
					}
      $array=array("name"=>$this->input->post('name'),'emoji'=>$deal1image);
                  $insert=$this->Home_model->insert('emoji',$array);
                  if($insert)
                  {
                     
                      $this->session->set_flashdata('message', 'Emoji add successfully');
                  }
                  
     }
     $this->load->view('admin/add_emoji');
 }
 public function edit($id)
 {
     if($this->input->post('update')=="save")
     {
         if(!empty($_FILES['emoji']['name']))
					{ 
					    $_FILES['emoji']['name']; 
						$_FILES['file']['name'] = $_FILES['emoji']['name'];
						$_FILES['file']['tmp_name'] = $_FILES['emoji']['tmp_name'] ;
						$_FILES['file']['size'] = $_FILES['emoji']['size'] ;
						$config['upload_path'] = 'uploads/emojies';
						$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc';
					 	$config['file_name'] = $_FILES['file']['name'];
						
						
						$photo=explode('.',$_FILES['emoji']['name']); 
						$ext = strtolower($photo[count($photo)-1]); 
						if (!empty($_FILES['emoji']['name'])) { 
						
							$curr_time = time(); 
							 $filename= $this->input->post('name')."_emoji_".time().".".$ext; 
							} 
						 $config['file_name'] = $filename; 
						
						//Load upload library and initialize configuration
						$this->load->library('upload',$config);
						$this->upload->initialize($config);
						
							if($this->upload->do_upload('file'))
							{
								 $uploadData = $this->upload->data();
								 $deal1image = "uploads/emojies/".$uploadData['file_name'];
							}else{
								$deal1image =$this->input->post('old_image');
							}
					}else{
							$deal1image =$this->input->post('old_image');
					}
      $array=array("name"=>$this->input->post('name'),'emoji'=>$deal1image);
                  $update=$this->Home_model->update('emoji',$id,$array);
                  if($update)
                  {
                     
                      $this->session->set_flashdata('message', 'Emoji update successfully');
                  }
     }
     $data["view"]=$this->Home_model->wheredetail('emoji','id',$id);
     $this->load->view('admin/add_emoji',$data);
 }
 
 public function delete($id)
 {
     $this->Home_model->delete('emoji','id',$id);
     $this->Home_model->delete('response','emoji_id',$id);
      $this->session->set_flashdata('message', 'Emoji have been delete Successfully');
      redirect('admin/Emoji');
 }
 
// 

// 
 
// public function status($id,$status)
//   {
	 
// 	  $arr =array('status'=>$status);
// 	  $up = $this->Home_model->update('users',$id,$arr);
// 	  if($up){
	      
// 	      redirect('admin/Customer');
// 	  }
	   
//  }

}

