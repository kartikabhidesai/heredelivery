<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('admin/Home_model');
        $this->load->model('front/Register_model','this_model');
    }

    public function index() {
        
            if($this->input->post()){
                $result = $this->this_model->adduser($this->input->post());
                if ($result == "done") {
                    $json_response['status'] = 'success';
                    $json_response['message'] = 'Your account created successfully.';
                    $json_response['redirect'] = base_url();
                } 
                if ($result == "wrong") {
                    $json_response['status'] = 'error';
                    $json_response['message'] = 'Something goes to wrong.';
                }
                if ($result == "userexits") {
                    $json_response['status'] = 'error';
                    $json_response['message'] = 'User name already exists.';
                }
                if ($result == "emailexist") {
                    $json_response['status'] = 'error';
                    $json_response['message'] = 'Email address already exists.';
                }
                echo json_encode($json_response);
                exit();
            }
            $data['title']='Login - Mushroom';
            $data['meta']='LASER ART - Mushroom';
            $data['page'] = 'front/pages/login'; 
            $data['js'] = array(
                'login.js',
                'ajaxfileupload.js',
                'jquery.form.min.js',
            );
            $data['js_plugin'] = array(
            );
            $data['css'] = array(            
            );
            $data['css_plugin'] = array(
            );
            $data['init'] = array(  
                'Login.init()',
            );
            $this->load->view("front/layout/admin_layout", $data); 
    }

}
