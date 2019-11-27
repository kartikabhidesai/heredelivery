 <?php 
class Home_model extends CI_Model
{
 public function selectdata($tablename)
  {
  	$this->load->database();
  	$this->db->select('*');
  	$this->db->from($tablename);
	$this->db->order_by('id','desc');
  	$query=$this->db->get();
  	return $query->result();
  }
  
    public function wheredata($tablename,$where,$id)
  {
  	$this->load->database();
  	$this->db->select('*');
  	$this->db->from($tablename);
	//$where = "'".$where."' = ".$id ;
	$this->db->where($where,$id);
  	$query=$this->db->get();
  	return $query->result();
  }
  
  
   public function update_where($tbl='',$wh=array(),$data){ 

		$this->db->where($wh);
		$this->db->update($tbl,$data);
				
		return true;
	
	}
  
   public function detail($tablename,$id)
  {
  	$this->load->database();
  	$this->db->select('*');
  	$this->db->from($tablename);
	$this->db->where('id',$id);
  	$query=$this->db->get();
  	return $query->row();
  }
  
  public function wheredetail($tablename,$where,$id)
  {
  	$this->load->database();
  	$this->db->select('*');
  	$this->db->from($tablename);
	//$where = "'".$where."' = ".$id ;
	$this->db->where($where,$id);
  	$query=$this->db->get();
  	return $query->row();
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
	
//update query
  public function update($tablename,$id,$data)
  {
    $this->db->where('id',$id);
    $this->db->update($tablename,$data);
	return true;
  }	
  
  public function updatewhere($tablename,$where,$id,$data)
  {
    $this->db->where($where,$id);
    $this->db->update($tablename,$data);
  }	
  
  
   public function delete($tablename,$where,$services_id) 
  { 
	 if ($this->db->delete($tablename, $where."= ".$services_id)) 
	 { 
		return true; 
	 } 
  }
   public function get_tbl_data($tbl='',$wh=array()){ 

		$this->db->where($wh);
		$query = $this->db->get($tbl);
				
		return $query->result();
	
	}// get_tbl_data function end here!
	
	
	 public function get_tbl_data_order($tbl='',$wh=array()){ 

		$this->db->where($wh);
		$this->db->order_by('id','desc');
		$query = $this->db->get($tbl);
				
		return $query->result();
	
	}
	  
/*
* Function Name: get_single_row
* Desc.: This function get single row in table.
*/
	public function get_single_row($tbl='',$wh=array()){ 

		$this->db->where($wh);
		$query = $this->db->get($tbl);
				
		return $query->row();
	
	}// get_single_row function end here!
public function deleteall($tablename) 
      { 
         if ($this->db->delete($tablename)) 
		 { 
            return true; 
         } 
      }
	  
	   public function insert_images($data = array())
   {
	$insert = $this->db->insert_batch('home_gallery_img',$data);
	return $insert?true:false;
    
  }	
	  
	   public function count_all($tablename)
  {
      $this->load->database();
      $this->db->select('*');
      $this->db->from($tablename);
      $query=$this->db->get();
    return $query->result();
    
  }
  
  
}

