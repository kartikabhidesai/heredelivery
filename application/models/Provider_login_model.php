<?php
class Provider_login_model extends CI_Model{

  public function login_user($email){
    
	    $this->load->database();
		$this->db->select('*');
		$this->db->from('service_provider');
		$where = "username ='".$email."' or email = '".$email."'" ;
		$this->db->where($where);
		$query=$this->db->get();
		return $query->row();				   
		  
      }
	  
  public function user_data($email,$password){
    
	    $this->load->database();
		$this->db->select('*');
		$this->db->from('service_provider');
		$where = '(username ="'.$email.'" or email = "'.$email.'")' ;
        $this->db->where($where);
		$this->db->where('password',sha1($password));
		$query=$this->db->get();
		return $query->row();
	 }
	 
   	 public function user_($id){
    
	    $this->load->database();
		$this->db->select('*');
		$this->db->from('service_provider');
		$this->db->where('id',$id);
		$query=$this->db->get();
		return $query->row();
	 }
	 
	  public function user_up($data,$id){
    
	    $this->db->where('id',$id);
		$this->db->update("service_provider",$data) ;
		return true ;
	 }	 

	
}