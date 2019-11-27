 <?php 
class V1_model extends CI_Model
{
 
  public function get_single_row($tbl='',$wh=array()){ 

		$this->db->where($wh);
		$query = $this->db->get($tbl);
				
		return $query->row();
	
	}// get_single_row function end here!
	public function get_tbl_data_inorder($tbl='',$wh=array()){ 

		$this->db->where($wh);
		$this->db->order_by("id", "desc");
		$query = $this->db->get($tbl);
				
		return $query->result();
	
	}// get_tbl_data function end here!	  
	 public function get_tbl_data($tbl='',$wh=array()){ 

		$this->db->where($wh);
		$query = $this->db->get($tbl);
				
		return $query->result();
	
	}// get_tbl_data function end here!
	 public function update_where($tbl='',$wh=array(),$data){ 

		$this->db->where($wh);
		$this->db->update($tbl,$data);
				
		return true;
	
	}// get_tbl_data function end here!
	 public function update($tablename,$id,$data)
  {
    $this->db->where('id',$id);
    $this->db->update($tablename,$data);
	return true;
  }	
   public function insert($tablename,$data)
       {
        
        $insert = $this->db->insert($tablename,$data);
        if($insert)
		{
            return $this->db->insert_id();
        }else{
            return false;    
        }
    }  
    
    public function delete($tablename,$where,$services_id) 
  { 
	 if ($this->db->delete($tablename, $where."= ".$services_id)) 
	 { 
		return true; 
	 } 
  }
  
  
  public function fetch_data($tablename,$wh,$limit, $id) {
	      $this->load->database();
	      $this->db->select('*');
		  if($id == 0) { $this->db->limit($limit);  }else{ $start = $id*$limit ; $this->db->limit($limit,$start); }
		  $this->db->from($tablename);
		  	$this->db->where($wh);
		  $this->db->order_by('id','DESC');
		  $query = $this->db->get();
	if ($query->num_rows() > 0) {
	     return $query->result() ;
	}
	else
	{
         return false;
	}
}

public function fetch_data_in($tablename,$where,$in_array,$limit, $id) {
	      $this->load->database();
	      $this->db->select('*');
		  if($id == 0) { $this->db->limit($limit);  }else{ $start = $id*$limit ; $this->db->limit($limit,$start); }
		  $this->db->from($tablename);
		  $this->db->where(array("is_delete"=>0));
		  $this->db->where_in($where, $in_array);
		  $this->db->order_by('id','DESC');
		  $query = $this->db->get();
	if ($query->num_rows() > 0) {
	     return $query->result() ;
	}
	else
	{
         return false;
	}
}


public function fetch_data_order($tablename,$wh,$limit, $id) {
	      $this->load->database();
	      $this->db->select('*');
		  if($id == 0) { $this->db->limit($limit);  }else{ $start = $id*$limit ; $this->db->limit($limit,$start); }
		  $this->db->from($tablename);
		  	$this->db->where($wh);
		  $this->db->order_by('id','DESC');
		  $query = $this->db->get();
	if ($query->num_rows() > 0) {
	     return $query->result() ;
	}
	else
	{
         return false;
	}
}



  
}

