<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
  {
    parent::__construct();
    
    $this->load->model('admin/Login_admin_model','',TRUE);
    
  }
	public function index()
	{
		$data["name"] = $this->db->get('admin_user')->row()->username ; 
	    $data["logo"] = $this->db->get('admin_user')->row()->admin_logo ;   
		
		$this->load->view('admin/login',$data);
	}
	  public function log(){
               
                        $email = $this->input->post('email');
                        $password = $this->input->post('password');
                        $password = $password ;
						$adminData = $this->Login_admin_model->get_single_row(TBL_ADMIN,array('email'=>$email,'password'=>$password));
						
						if(!empty($adminData)){
                                        //create array of data
                                $admin_data =array(
                                        'user_id'=>$adminData->id,
                                        'username'=>$adminData->username,
										'email'=>$adminData->email,
										'logo'=>$adminData->admin_logo,
                                        'logged_in'=> TRUE
                                       );
                             //ser session userdata
							   $logged_in = $this->session->set_userdata('admin_user',$admin_data);
                               redirect('admin/Home');
                        }else{
                                        //set error
                                $this->session->set_flashdata('login_failed','Invalid Username or Password');
                                redirect('admin/Login/');
                        }
               
        }

		public function logout() {
				$this->session->sess_destroy();
				redirect ('admin/Login/');
		}
}
