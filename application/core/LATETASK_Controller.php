<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class LATETASK_Controller extends CI_Controller {

     public function __construct() 
        {
           parent::__construct();
		   
		 }
   
  
   public function load_template($viewName,$data = array())
      {
		    
			 $this->load->view('header',$data);
		     $this->load->view($viewName,$data);
    	     $this->load->view('footer',$data);
     }
	 
}
/* End of file welcome.php */
/* Location: ./application/Core/MY_Controller */