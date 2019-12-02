<?php

defined('BASEPATH') OR exit('No direct script access allowed');
define('API_ACCESS_KEY', 'AAAAR9x0A88:APA91bGm4vhNV_ouxSmT4I1PR7IK7jZdEyE8QkRKnMmX3Z4mRLlMsFSLfP-q5OPcNEvxb3yg1qee7BmJtg0aZPwg-oNSzF5Nq6WxJW0Nru4CdDwvD7z0JFmZmnFX4tJxI28wM28GgnpI');

class V1 extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('api/V1_model');
        $this->load->library('email');
    }

    public function index() {
        echo "Silence is Golden";
    }

    public function files($name, $index) {
        if (!empty($_FILES[$name]['name'][$index])) {

            $_FILES['file']['name'] = $_FILES[$name]['name'][$index];
            $_FILES['file']['tmp_name'] = $_FILES[$name]['tmp_name'][$index];
            $_FILES['file']['size'] = $_FILES[$name]['size'][$index];
            $config['upload_path'] = 'uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] = $_FILES['file']['name'];



            $photo = explode('.', $_FILES[$name]['name'][$index]);
            $ext = strtolower($photo[count($photo) - 1]);
            if (!empty($_FILES[$name]['name'])) {

                $curr_time = time();
                $filename = "_img_" . time() . "." . $ext;
            }
            $config['file_name'] = $filename;

            //Load upload library and initialize configuration
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {
                $uploadData = $this->upload->data();

                return $deal1image = "uploads/" . $uploadData['file_name'];
            } else {
                return $deal1image = '';
            }
        } else {
            return $deal1image = '';
        }
    }

    public function registration() {

        $this->form_validation->set_rules('username', 'username', 'required');
        // $this->form_validation->set_rules('phone_number', 'phone_number', 'required');
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');
        $this->form_validation->set_rules('frist_name', 'frist_name', 'required');
        $this->form_validation->set_rules('last_name', 'last_name', 'required');
        $this->form_validation->set_rules('device_token', 'device_token', 'required');
        if ($this->form_validation->run() == TRUE) {
            $this->form_validation->set_rules('email', 'email', 'required|is_unique[users.email]');
            if ($this->form_validation->run() == TRUE) {
                $this->form_validation->set_rules('username', 'username', 'required|is_unique[users.username]');
                if ($this->form_validation->run() == TRUE) {
                    $arr = array("username" => $this->input->post('username'), 
                                "frist_name" => $this->input->post('frist_name'), 
                                "last_name" => $this->input->post('last_name'),
                                "phone_number" => $this->input->post('phone_number') ?: '', 
                                "email" => $this->input->post('email'),
                                "password" => sha1($this->input->post('password')), 
                                "created_on" => date("Y-m-d H:i:s"), 
                                "device_token" => $this->input->post('device_token')
                            );
                    $insert_id = $this->V1_model->insert('users', $arr);
                    $data = $this->V1_model->get_single_row('users', array("id" => $insert_id));
                    $array1['status'] = true;
                    $array1['message'] = "registration successfully";
                    $array1['data'] = $data;
                } else {
                    $array1['status'] = false;
                    $array1['message'] = "This username is already registered";
                }
            } else {
                $array1['status'] = false;
                $array1['message'] = "This email is already registered";
            }
        } else {
            $message = strip_tags(validation_errors());
            $array1['status'] = false;
            $array1['message'] = $message;
        }
        echo json_encode($array1);
    }

    public function login() {
        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');
        $this->form_validation->set_rules('device_token', 'device_token', 'required');
        if ($this->form_validation->run() == TRUE) {
            $data = $this->V1_model->get_single_row('users', array("username" => $this->input->post('username'), "password" => sha1($this->input->post('password'))));
            if (!empty($data)) {
                $this->V1_model->update_where('users', array("id" => $data->id), array("device_token" => $this->input->post('device_token')));
                $data1 = $this->V1_model->get_single_row('users', array("id" => $data->id));
                $array1['status'] = true;
                $array1['message'] = "login";
                $array1['data'] = $data1;
            } else {
                $array1['status'] = false;
                $array1['message'] = "invalid user";
            }
        } else {
            $message = strip_tags(validation_errors());
            $array1['status'] = false;
            $array1['message'] = $message;
        }
        echo json_encode($array1);
    }

    public function add_post() {

        $this->form_validation->set_rules('user_id', 'user_id', 'required');
        if ($this->input->post('post_type') != "location") {
            
        }

        $this->form_validation->set_rules('post_type', 'post_type', 'required');
        if ($this->form_validation->run() == TRUE) {
            if ($this->input->post('post_type') == "pic") {
                //
                if (!empty($_FILES["image"])) {
                    foreach ($_FILES["image"]["name"] as $filimgs => $fil) {
                        $filed = $this->files("image", $filimgs);
                        if ($filed) {

                            $image[] = $filed;
                        }
                    }
                    $image_str = implode(",", $image);
                } else {

                    $image_str = "";
                }
                //
                if (!empty($image_str)) {

                    $array = array("user_id" => $this->input->post('user_id'), 'title' => $this->input->post('title') ?: '',
                        "image" => $image_str, 'post_text' => $this->input->post('post_text') ?: '', "post_type" => $this->input->post('post_type'), "created_on" => date("Y-m-d H:i:s"));
                    $insert_id = $this->V1_model->insert('post', $array);
                    if ($insert_id) {
                        $data = $this->V1_model->get_single_row('post', array('id' => $insert_id));
                        $array1["status"] = true;
                        $array1["message"] = "Post Added Successfully";
                        $array1["data"] = $data;
                    } else {
                        $array1["status"] = false;
                        $array1["message"] = "Issue Occurred";
                    }
                } else {
                    $array1["status"] = false;
                    $array1["message"] = "Please you sent image in this fomets gif,jpg,png,jpeg,pdf,doc";
                }
            } elseif ($this->input->post('post_type') == "location") {
                if ($this->input->post('latitude') && $this->input->post('longitude') && $this->input->post('address')) {

                    //
                    if (!empty($_FILES["image"])) {
                        foreach ($_FILES["image"]["name"] as $filimgs => $fil) {
                            $filed = $this->files("image", $filimgs);
                            if ($filed) {

                                $image[] = $filed;
                            }
                        }
                        if (!empty($image)) {
                            $image_str = implode(",", $image);
                        }
                    } else {
                        $image_str = "";
                    }
                    //

                    $array = array("user_id" => $this->input->post('user_id'), "address" => $this->input->post('address'), "whos_with" => $this->input->post('whos_with') ?: '',
                        "latitude" => $this->input->post('latitude'), "longitude" => $this->input->post('longitude'), "image" => $image_str ?: '',
                        "post_type" => $this->input->post('post_type'), "created_on" => date("Y-m-d H:i:s"));
                    $insert_id = $this->V1_model->insert('post', $array);
                    if ($insert_id) {

                        /////
                        if (!empty($this->input->post('whos_with'))) {
                            $arr_attempt_id = explode(",", $this->input->post('whos_with'));
                            foreach ($arr_attempt_id as $at) {
                                $this->V1_model->insert('notification', array("receiver_id" => $at, "post_id" => $insert_id, "response_id" => 0,
                                    "from_id" => $this->input->post('user_id'), "action" => "attach", "created_on" => date("Y-m-d H:i:s")));
                                $this->attach_notification($this->input->post('user_id'), $at, $insert_id, "attach", "post");
                            }
                        }
                        ////


                        $data = $this->V1_model->get_single_row('post', array('id' => $insert_id));
                        $array1["status"] = true;
                        $array1["message"] = "Post Added Successfully";
                        $array1["data"] = $data;
                    } else {
                        $array1["status"] = false;
                        $array1["message"] = "Issue Occurred";
                    }
                } else {
                    $array1["status"] = false;
                    $array1["message"] = "Please latitude and  longitude";
                }
            } elseif ($this->input->post('post_type') == "link") {

                $array = array("user_id" => $this->input->post('user_id'), "post_text" => $this->input->post('post_text') ?: '', 'link' => $this->input->post('link') ?: '',
                    'title' => $this->input->post('title') ?: '', "post_type" => $this->input->post('post_type'), "created_on" => date("Y-m-d H:i:s"));
                $insert_id = $this->V1_model->insert('post', $array);
                if ($insert_id) {
                    $data = $this->V1_model->get_single_row('post', array('id' => $insert_id));
                    $array1["status"] = true;
                    $array1["message"] = "Post Added Successfully";
                    $array1["data"] = $data;
                } else {
                    $array1["status"] = false;
                    $array1["message"] = "Issue Occurred";
                }
            } else {
                //
                if (!empty($_FILES["image"])) {
                    foreach ($_FILES["image"]["name"] as $filimgs => $fil) {
                        $filed = $this->files("image", $filimgs);
                        if ($filed) {

                            $image[] = $filed;
                        }
                    }
                    if (!empty($image)) {
                        $image_str = implode(",", $image);
                    }
                } else {
                    $image_str = "";
                }
                //
                $array = array("user_id" => $this->input->post('user_id'), "post_text" => $this->input->post('post_text') ?: '', "image" => $image_str ?: '',
                    "post_type" => $this->input->post('post_type'), "created_on" => date("Y-m-d H:i:s"));
                $insert_id = $this->V1_model->insert('post', $array);
                if ($insert_id) {
                    $data = $this->V1_model->get_single_row('post', array('id' => $insert_id));
                    $array1["status"] = true;
                    $array1["message"] = "Post Added Successfully";
                    $array1["data"] = $data;
                } else {
                    $array1["status"] = false;
                    $array1["message"] = "Issue Occurred";
                }
            }
        } else {
            $message = strip_tags(validation_errors());
            $array1['status'] = false;
            $array1['message'] = $message;
        }
        echo json_encode($array1);
    }

    /* post update s */

    public function update_post() {
        $this->form_validation->set_rules('post_id', 'post_id', 'required');
        $this->form_validation->set_rules('user_id', 'user_id', 'required');
        if ($this->form_validation->run() == TRUE) {
            $post_chk = $this->V1_model->get_single_row('post', array("id" => $this->input->post('post_id'), "user_id" => $this->input->post('user_id')));
            if (!empty($post_chk)) {
                //////////////////////////////////////////
                if ($this->input->post('post_type') == "pic") {
                    //
                    if (!empty($_FILES["image"])) {
                        foreach ($_FILES["image"]["name"] as $filimgs => $fil) {
                            $filed = $this->files("image", $filimgs);
                            if ($filed) {

                                $image[] = $filed;
                            }
                        }
                        $image_str = implode(",", $image);
                    } else {

                        $image_str = "";
                    }
                    //
                    if (!empty($image_str)) {

                        $array = array("user_id" => $this->input->post('user_id'), 'title' => $this->input->post('title') ?: '',
                            "image" => $image_str, 'post_text' => $this->input->post('post_text') ?: '', "post_type" => $this->input->post('post_type'), "created_on" => date("Y-m-d H:i:s"));
                        $update = $this->V1_model->update_where('post', array('id' => $post_chk->id), $array);
                        if ($update) {
                            $data = $this->V1_model->get_single_row('post', array('id' => $post_chk->id));
                            $array1["status"] = true;
                            $array1["message"] = "Post Update Successfully";
                            $array1["data"] = $data;
                        } else {
                            $array1["status"] = false;
                            $array1["message"] = "Issue Occurred";
                        }
                    } else {
                        $array1["status"] = false;
                        $array1["message"] = "Please you sent image in this fomets gif,jpg,png,jpeg,pdf,doc";
                    }
                } elseif ($this->input->post('post_type') == "location") {
                    if ($this->input->post('latitude') && $this->input->post('longitude') && $this->input->post('address')) {

                        //
                        if (!empty($_FILES["image"])) {
                            foreach ($_FILES["image"]["name"] as $filimgs => $fil) {
                                $filed = $this->files("image", $filimgs);
                                if ($filed) {

                                    $image[] = $filed;
                                }
                            }
                            if (!empty($image)) {
                                $image_str = implode(",", $image);
                            }
                        } else {
                            $image_str = "";
                        }
                        //
                        //
                             $array = array("user_id" => $this->input->post('user_id'), "address" => $this->input->post('address'), "whos_with" => $this->input->post('whos_with') ?: '',
                            "latitude" => $this->input->post('latitude'), "longitude" => $this->input->post('longitude'), "image" => $image_str ?: '',
                            "post_type" => $this->input->post('post_type'), "created_on" => date("Y-m-d H:i:s"));
                        $update = $this->V1_model->update_where('post', array('id' => $post_chk->id), $array);
                        if ($update) {
                            $data = $this->V1_model->get_single_row('post', array('id' => $post_chk->id));
                            $array1["status"] = true;
                            $array1["message"] = "Post Update Successfully";
                            $array1["data"] = $data;
                        } else {
                            $array1["status"] = false;
                            $array1["message"] = "Issue Occurred";
                        }
                    } else {
                        $array1["status"] = false;
                        $array1["message"] = "Please latitude and  longitude";
                    }
                } elseif ($this->input->post('post_type') == "link") {

                    $array = array("user_id" => $this->input->post('user_id'), "post_text" => $this->input->post('post_text') ?: '', 'link' => $this->input->post('link') ?: '',
                        'title' => $this->input->post('title') ?: '', "post_type" => $this->input->post('post_type'), "created_on" => date("Y-m-d H:i:s"));
                    $update = $this->V1_model->update_where('post', array('id' => $post_chk->id), $array);
                    if ($update) {
                        $data = $this->V1_model->get_single_row('post', array('id' => $post_chk->id));
                        $array1["status"] = true;
                        $array1["message"] = "Post Update Successfully";
                        $array1["data"] = $data;
                    } else {
                        $array1["status"] = false;
                        $array1["message"] = "Issue Occurred";
                    }
                } else {
                    //
                    if (!empty($_FILES["image"])) {
                        foreach ($_FILES["image"]["name"] as $filimgs => $fil) {
                            $filed = $this->files("image", $filimgs);
                            if ($filed) {

                                $image[] = $filed;
                            }
                        }
                        if (!empty($image)) {
                            $image_str = implode(",", $image);
                        }
                    } else {
                        $image_str = "";
                    }
                    //
                    $array = array("user_id" => $this->input->post('user_id'), "post_text" => $this->input->post('post_text') ?: '', "image" => $image_str ?: '',
                        "post_type" => $this->input->post('post_type'), "created_on" => date("Y-m-d H:i:s"));
                    $update = $this->V1_model->update_where('post', array('id' => $post_chk->id), $array);
                    if ($update) {
                        $data = $this->V1_model->get_single_row('post', array('id' => $post_chk->id));
                        $array1["status"] = true;
                        $array1["message"] = "Post Update Successfully";
                        $array1["data"] = $data;
                    } else {
                        $array1["status"] = false;
                        $array1["message"] = "Issue Occurred";
                    }
                }
                //////////////////////////////////////////
            } else {
                $array1["status"] = false;
                $array1["message"] = "No Post found";
            }
        } else {
            $message = strip_tags(validation_errors());
            $array1['status'] = false;
            $array1['message'] = $message;
        }
        echo json_encode($array1);
    }

    /* post update e */

    /* upload image s */

    public function upload_profile() {
        if (!empty($_FILES['profile']['name'])) {
            $_FILES['profile']['name'];
            $_FILES['file']['name'] = $_FILES['profile']['name'];
            $_FILES['file']['tmp_name'] = $_FILES['profile']['tmp_name'];
            $_FILES['file']['size'] = $_FILES['profile']['size'];
            $config['upload_path'] = 'uploads/profile';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] = $_FILES['file']['name'];


            $photo = explode('.', $_FILES['profile']['name']);
            $ext = strtolower($photo[count($photo) - 1]);
            if (!empty($_FILES['profile']['name'])) {

                $curr_time = time();
                $filename = "profile_" . time() . "." . $ext;
            }
            $config['file_name'] = $filename;

            //Load upload library and initialize configuration
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {
                $uploadData = $this->upload->data();
                $deal1image = "uploads/profile/" . $uploadData['file_name'];

                // 		 if(!empty($this->input->post('old_image')))
                // 		 {
                // 		     unlink($this->input->post('old_image'));
                // 		 }
            } else {
                $deal1image = "";
            }
        } else {
            $deal1image = "";
        }
        return $deal1image;
    }

    /* upload image e */

    public function upload_image_loc() {
        if (!empty($_FILES['image']['name'])) {
            $_FILES['image']['name'];
            $_FILES['file']['name'] = $_FILES['image']['name'];
            $_FILES['file']['tmp_name'] = $_FILES['image']['tmp_name'];
            $_FILES['file']['size'] = $_FILES['image']['size'];
            $config['upload_path'] = 'uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc';
            $config['file_name'] = $_FILES['file']['name'];


            $photo = explode('.', $_FILES['image']['name']);
            $ext = strtolower($photo[count($photo) - 1]);
            if (!empty($_FILES['image']['name'])) {

                $curr_time = time();
                $filename = "_img_" . time() . "." . $ext;
            }
            $config['file_name'] = $filename;

            //Load upload library and initialize configuration
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {
                $uploadData = $this->upload->data();
                $deal1image = "uploads/" . $uploadData['file_name'];

                // 		 if(!empty($this->input->post('old_image')))
                // 		 {
                // 		     unlink($this->input->post('old_image'));
                // 		 }
            } else {
                $deal1image = "";
            }
        } else {
            $deal1image = "";
        }
        return $deal1image;
    }

    /* search user s */

    public function search_user() {
        $this->form_validation->set_rules('search', 'search', 'required');
        $this->form_validation->set_rules('user_id', 'user_id', 'required');
        if ($this->form_validation->run() == TRUE) {
            $search = $this->input->post('search');
            $user_id = $this->input->post('user_id');
            $user_data = $this->db->query("SELECT * FROM users WHERE  id!='$user_id' &&(username LIKE '%$search%'|| frist_name LIKE '%$search%'|| last_name LIKE '%$search%'|| email LIKE '%$search%' || phone_number LIKE '%$search%')")->result();
            if (!empty($user_data)) {
                foreach ($user_data as $ud) {
                    $val["id"] = $ud->id;
                    $val["full_name"] = $ud->frist_name . " " . $ud->last_name;
                    $val["username"] = $ud->username;
                    $val["phone_number"] = $ud->phone_number;
                    $val["email"] = $ud->email;
                    $val["device_token"] = $ud->device_token;
                    $val["created_on"] = $ud->created_on;
                    $val["profile"] = $ud->profile;
                    $val["is_plus"] = $ud->is_plus;
                    $friend_status = $this->chk_friend_status($user_id, $ud->id);
                    $val["friend_status"] = $friend_status;
                    $val1[] = $val;
                }
                $array1['status'] = true;
                $array1['message'] = "Search Result";
                $array1['data'] = $val1;
            } else {
                $array1['status'] = false;
                $array1['message'] = "Data Not Found";
            }
        } else {
            $message = strip_tags(validation_errors());
            $array1['status'] = false;
            $array1['message'] = $message;
        }
        echo json_encode($array1);
    }

    /* search user e */

    /* check friend status s */

    private function chk_friend_status($user_id_from, $user_id_to) {
        $chk1 = $this->db->query("SELECT * FROM friend_list WHERE (user_id_from='$user_id_from' && user_id_to='$user_id_to' && is_accept='1' && is_block_by_from='0' && is_block_by_to='0') ||(user_id_from='$user_id_to' && user_id_to='$user_id_from' && is_accept='1' && is_block_by_from='0' && is_block_by_to='0') ")->row();
        $chk2 = $this->db->query("SELECT * FROM friend_list WHERE user_id_from='$user_id_from' && user_id_to='$user_id_to' && is_accept='0' && is_block_by_from='0' && is_block_by_to='0'")->row();
        $chk3 = $this->db->query("SELECT * FROM friend_list WHERE user_id_from='$user_id_to' && user_id_to='$user_id_from' && is_accept='0' && is_block_by_from='0' && is_block_by_to='0'")->row();
        if (!empty($chk1)) {
            $status = "is_friend";
        } elseif (!empty($chk2)) {
            $status = "request_my_side";
        } elseif (!empty($chk3)) {
            $status = "request_user_side";
        } else {
            $chk7 = $this->db->query("SELECT * FROM friend_list WHERE (user_id_from='$user_id_from' && user_id_to='$user_id_to') ||(user_id_from='$user_id_to' && user_id_to='$user_id_from' )")->row();
            if (!empty($chk7)) {
                if ($chk7->is_block_by_to == "1") {
                    $status = "is_block_by_to";
                } else {
                    $status = "is_block_by_from";
                }
            } else {
                $status = "no_request";
            }
        }
        return $status;
    }

    /* check friend status e */

    /* send friend request s */

    public function send_friend_request() {
        $this->form_validation->set_rules('user_id_to', 'user_id_to', 'required');
        $this->form_validation->set_rules('user_id_from', 'user_id_from', 'required');
        if ($this->form_validation->run() == TRUE) {
            $user_id_to = $this->input->post('user_id_to');
            $user_id_from = $this->input->post('user_id_from');
            $chk = $this->db->query("SELECT * FROM friend_list WHERE (user_id_from='$user_id_from' && user_id_to='$user_id_to') ||(user_id_from='$user_id_to' && user_id_to='$user_id_from') ")->row();
            if (!empty($chk)) {
                $chk1 = $this->db->query("SELECT * FROM friend_list WHERE (user_id_from='$user_id_from' && user_id_to='$user_id_to' && is_accept='1') ||(user_id_from='$user_id_to' && user_id_to='$user_id_from' && is_accept='1') ")->row();
                $chk2 = $this->db->query("SELECT * FROM friend_list WHERE user_id_from='$user_id_from' && user_id_to='$user_id_to' && is_accept='0'")->row();
                $chk3 = $this->db->query("SELECT * FROM friend_list WHERE user_id_from='$user_id_to' && user_id_to='$user_id_from' && is_accept='0'")->row();
                if (!empty($chk1)) {
                    $array1['status'] = false;
                    $array1['message'] = "You are Already Friend ";
                } elseif (!empty($chk2)) {
                    $array1['status'] = false;
                    $array1['message'] = "You Already Send Friend Request";
                } elseif (!empty($chk3)) {
                    $array1['status'] = false;
                    $array1['message'] = "This User Already Send You Friend, Request Please Check Your Friend Request list";
                } else {
                    $array1['status'] = true;
                    $array1['message'] = "Friend Request Send Successfully";
                    $this->V1_model->update_where('friend_list', array('id' => $chk->id), array("is_accept" => 0, "user_id_from" => $this->input->post('user_id_from'),
                        "user_id_to" => $this->input->post('user_id_to'), "updated_on" => date("Y-m-d H:i:s")));
                    /* send notification */
                    $this->request_notification($this->input->post('user_id_to'), $this->input->post('user_id_from'), $chk->id, "Request");
                    $this->V1_model->insert('notification', array("receiver_id" => $this->input->post('user_id_to'),
                        "post_id" => 0, "response_id" => 0, "from_id" => $this->input->post('user_id_from'), "action" => "Request", "created_on" => date("Y-m-d H:i:s")));

                    /**/
                }
            } else {

                $array = array("user_id_from" => $user_id_from, "user_id_to" => $user_id_to, "created_on" => date("Y-m-d H:i:s"));
                $insert_id = $this->V1_model->insert('friend_list', $array);
                if ($insert_id) {
                    /* send notification */
                    $this->request_notification($this->input->post('user_id_to'), $this->input->post('user_id_from'), $insert_id, "Request");
                    /**/
                    $array1['status'] = true;
                    $array1['message'] = "Friend Request Send Successfully";
                } else {
                    $array1['status'] = false;
                    $array1['message'] = "issue occured";
                }
            }
        } else {
            $message = strip_tags(validation_errors());
            $array1['status'] = false;
            $array1['message'] = $message;
        }
        echo json_encode($array1);
    }

    /* send friend request e */

    /* accept reject s */

    public function accept_reject_cancel() {
        $this->form_validation->set_rules('user_id_from', 'user_id_from', 'required');
        $this->form_validation->set_rules('user_id_to', 'user_id_to', 'required');
        $this->form_validation->set_rules('action', 'action', 'required');
        if ($this->form_validation->run() == TRUE) {
            $user_id_from = $this->input->post('user_id_from');
            $user_id_to = $this->input->post('user_id_to');
            $chk = $this->db->query("SELECT * FROM friend_list WHERE (user_id_from='$user_id_from' && user_id_to='$user_id_to') ||(user_id_from='$user_id_to' && user_id_to='$user_id_from') ")->row();
            if (!empty($chk)) {
                if ($this->input->post('action') < 3) {
                    $this->V1_model->update_where('friend_list', array('id' => $chk->id), array('is_accept' => $this->input->post('action')));
                    if ($this->input->post('action') == 1) {
                        $this->V1_model->insert('notification', array("receiver_id" => $chk->user_id_from,
                            "post_id" => 0, "response_id" => 0, "from_id" => $chk->user_id_to, "action" => "accept", "created_on" => date("Y-m-d H:i:s")));
                        $message = "Accepted User Request";
                        /* send notification */
                        $this->request_notification($user_id_to, $user_id_from, $chk->id, "Accept");
                        /**/
                    } else {
                        $message = "Reject User Request";
                    }
                    $array1['status'] = true;
                    $array1['message'] = $message;
                } else {
                    if ($chk->is_accept == 1) {
                        $message = "Unfriend Successfully";
                    } else {
                        $message = "Cancel User Request";
                    }
                    $this->V1_model->delete('friend_list', 'id', $chk->id);
                    $array1['status'] = true;
                    $array1['message'] = $message;
                }
            } else {
                $array1['status'] = false;
                $array1['message'] = "No data Found";
            }
        } else {
            $message = strip_tags(validation_errors());
            $array1['status'] = false;
            $array1['message'] = $message;
        }
        echo json_encode($array1);
    }

    /* accept reject e */


    /* friend list s */

    public function friend_list() {
        $this->form_validation->set_rules('user_id', 'user_id', 'required');
        if ($this->form_validation->run() == TRUE) {
            $chk_user = $this->V1_model->get_single_row('users', array("id" => $this->input->post('user_id')));
            if (!empty($chk_user)) {
                /* $friend_id_to s */
                $friend_id_to = $this->V1_model->get_tbl_data('friend_list', array("user_id_from" => $this->input->post('user_id'), "is_accept" => 1));
                if (!empty($friend_id_to)) {
                    foreach ($friend_id_to as $f_to) {
                        $f_to_arr[] = $f_to->user_id_to;
                    }

                    $f_to_str = implode(",", $f_to_arr);

                    /* $friend_id_from s */
                    $friend_id_from = $this->V1_model->get_tbl_data('friend_list', array("user_id_to" => $this->input->post('user_id'), "is_accept" => 1));
                    if (!empty($friend_id_from)) {
                        foreach ($friend_id_from as $f_from) {
                            $f_from_arr[] = $f_from->user_id_from;
                        }
                        $f_from_str = implode(",", $f_from_arr);

                        $friends_id = $f_to_str . "," . $f_from_str;
                    } else {
                        $friends_id = $f_to_str;
                    }
                } else {
                    /* $friend_id_from s */
                    $friend_id_from = $this->V1_model->get_tbl_data('friend_list', array("user_id_to" => $this->input->post('user_id'), "is_accept" => 1));
                    if (!empty($friend_id_from)) {
                        foreach ($friend_id_from as $f_from) {
                            $f_from_arr[] = $f_from->user_id_from;
                        }
                        $f_from_str = implode(",", $f_from_arr);

                        $friends_id = $f_from_str;
                    } else {
                        $friends_id = "";
                    }
                }

                if (!empty($friends_id)) {
                    $data = $this->db->query("SELECT * FROM users WHERE id IN($friends_id)")->result();
                    if (!empty($data)) {
                        foreach ($data as $da) {
                            $val["id"] = $da->id;
                            $val["full_name"] = $da->frist_name . " " . $da->last_name;
                            $val["username"] = $da->username;
                            $val["phone_number"] = $da->phone_number;
                            $val["email"] = $da->email;
                            $val["profile"] = $da->profile;
                            $val["is_plus"] = $da->is_plus;
                            $val["device_token"] = $da->device_token;
                            $val["created_on"] = $da->created_on;

                            $user_id = $this->input->post('user_id');
                            $contact_id = $da->id;
                            $chk = $this->db->query("SELECT * FROM friend_list WHERE (user_id_from='$user_id' && user_id_to='$contact_id' && is_accept='1') ||(user_id_from='$contact_id' && user_id_to='$user_id' && is_accept='1') ")->row();
                            if ($chk->user_id_from == $user_id) {
                                $val['is_block_by_me'] = $chk->is_block_by_from;
                                $val['is_block_by_friend'] = $chk->is_block_by_to;
                            } else {
                                $val['is_block_by_friend'] = $chk->is_block_by_from;
                                $val['is_block_by_me'] = $chk->is_block_by_to;
                            }

                            $val1[] = $val;
                        }
                        $array1['status'] = true;
                        $array1['total_friend'] = count($data);
                        $array1['data'] = $val1;
                    } else {
                        $array1['status'] = false;
                        $array1['message'] = "No friend In Your Friendlist";
                    }
                } else {
                    $array1['status'] = false;
                    $array1['message'] = "No friend In Your Friendlist";
                }
            } else {
                $array1['status'] = false;
                $array1['message'] = "Invalid User Id";
            }
        } else {
            $message = strip_tags(validation_errors());
            $array1['status'] = false;
            $array1['message'] = $message;
        }
        echo json_encode($array1);
    }

    /* friend list e */


    /* friend request list s */

    public function friend_request_list() {
        $this->form_validation->set_rules('user_id', 'user_id', 'required');
        if ($this->form_validation->run() == TRUE) {
            $chk_user = $this->V1_model->get_single_row('users', array("id" => $this->input->post('user_id')));
            if (!empty($chk_user)) {
                $request_id_from = $this->V1_model->get_tbl_data('friend_list', array("user_id_to" => $this->input->post('user_id'), "is_accept" => 0));
                if (!empty($request_id_from)) {
                    foreach ($request_id_from as $r_f) {
                        $request_arr[] = $r_f->user_id_from;
                    }

                    $request_str = implode(",", $request_arr);

                    $request_data = $this->db->query("SELECT * FROM users WHERE id IN($request_str)")->result();
                    if (!empty($request_data)) {
                        $array1['status'] = true;
                        $array1['total_request'] = count($request_data);
                        $array1['data'] = $request_data;
                    } else {
                        $array1['status'] = false;
                        $array1['message'] = "You Have Not Any Friend Request";
                    }
                } else {
                    $array1['status'] = false;
                    $array1['message'] = "You Have Not Any Friend Request";
                }
            } else {
                $array1['status'] = false;
                $array1['message'] = "Invalid User Id";
            }
        } else {
            $message = strip_tags(validation_errors());
            $array1['status'] = false;
            $array1['message'] = $message;
        }
        echo json_encode($array1);
    }

    /* friend request list e */

    /* give_reaction s */

    public function give_reaction() {
        $this->form_validation->set_rules('user_id', 'user_id', 'required');
        $this->form_validation->set_rules('post_id', 'post_id', 'required');
        $this->form_validation->set_rules('emoji_id', 'emoji_id', 'required');
        if ($this->form_validation->run() == TRUE) {
            $chk_user = $this->V1_model->get_single_row('users', array("id" => $this->input->post('user_id')));
            if (!empty($chk_user)) {
                $chk_post = $this->V1_model->get_single_row('post', array("id" => $this->input->post('post_id')));
                if (!empty($chk_post)) {
                    $chk_response = $this->V1_model->get_single_row('response', array("post_id" => $this->input->post('post_id'), "user_id" => $this->input->post('user_id')));
                    if (!empty($chk_response)) {
                        $reaction = $this->input->post('emoji_id');
                        if ($chk_response->emoji_id == $reaction) {
                            $delete = $this->V1_model->delete('response', 'id', $chk_response->id);
                            if ($delete) {
                                /* add  delte notification  s */
                                //$this->V1_model->delete('notification','response_id',$chk_response->id);
                                $del = $chk_response->id;
                                $this->db->query("DELETE FROM notification WHERE response_id='$del' && action!='comment' ");
                                /* delete notification */
                                //$data=$this->V1_model->get_tbl_data_inorder('response',array("post_id"=>$this->input->post('post_id')));
                                //
                                $emoji_data = $this->V1_model->get_tbl_data('emoji', array());
                                if (!empty($emoji_data)) {
                                    foreach ($emoji_data as $ed) {
                                        $eval["id"] = $ed->id;
                                        $eval["name"] = $ed->name;
                                        $eval["emoji"] = $ed->emoji;
                                        $total_emoji = $this->V1_model->get_tbl_data_inorder('response', array("post_id" => $this->input->post('post_id'), "emoji_id" => $ed->id));
                                        if (!empty($total_emoji)) {
                                            foreach ($total_emoji as $te) {
                                                $tval["id"] = $te->id;
                                                $tval["post_id"] = $te->post_id;
                                                $tval["user_id"] = $te->user_id;
                                                $responser_data = $this->V1_model->get_single_row('users', array("id" => $te->user_id));
                                                $tval["responser_full_name"] = $responser_data->frist_name . " " . $responser_data->last_name;
                                                $tval["responser_username"] = $responser_data->username;
                                                $tval["responser_profile"] = $responser_data->profile;
                                                $tval["emoji_id"] = $te->emoji_id;
                                                $tval["emoji_image"] = $this->V1_model->get_single_row('emoji', array("id" => $te->emoji_id));
                                                ;
                                                $tval["created_on"] = $te->created_on;
                                                $tval["updated_on"] = $te->updated_on;
                                                $tval1[] = $tval;
                                            }
                                            $eval["responser_data"] = $tval1;
                                            unset($tval1);
                                        } else {
                                            $eval["responser_data"] = array();
                                        }
                                        $eval["total_emoji"] = count($total_emoji);
                                        $eval1[] = $eval;
                                    }
                                    $array1["total_response"] = $eval1;
                                    unset($eval1);
                                } else {
                                    $array1["total_response"] = array();
                                }
                                //
                                $array1['status'] = true;
                                $array1['message'] = "Reaction Remove";
                                //$array1["data"]=$tval1;
                            } else {
                                $array1['status'] = false;
                                $array1['message'] = "issue occurred";
                            }
                        } else {
                            $update = $this->V1_model->update('response', $chk_response->id, array("emoji_id" => $reaction, "updated_on" => date("Y-m-d H:i:s")));
                            if ($update) {

                                /* add notification  s */
                                //$this->V1_model->delete('notification','response_id',$chk_response->id);
                                $del = $chk_response->id;
                                $this->db->query("DELETE FROM notification WHERE response_id='$del' && action!='comment' ");
                                if ($chk_post->user_id != $this->input->post('user_id')) {
                                    /*                                     * send notification */
                                    $this->send_notification($this->input->post('user_id'), $chk_post->user_id, $chk_response->id, $this->input->post('post_id'), "response", "response");
                                    /** send notification */
                                    $this->V1_model->insert('notification', array("receiver_id" => $chk_post->user_id,
                                        "post_id" => $this->input->post('post_id'), "response_id" => $chk_response->id, "from_id" => $this->input->post('user_id'), "action" => $this->input->post('emoji_id'), "created_on" => date("Y-m-d H:i:s")));
                                }
                                /* add notification  e */
                                // $data=$this->V1_model->get_tbl_data_inorder('response',array("post_id"=>$this->input->post('post_id')));
                                //
                            $emoji_data = $this->V1_model->get_tbl_data('emoji', array());
                                if (!empty($emoji_data)) {
                                    foreach ($emoji_data as $ed) {
                                        $eval["id"] = $ed->id;
                                        $eval["name"] = $ed->name;
                                        $eval["emoji"] = $ed->emoji;
                                        $total_emoji = $this->V1_model->get_tbl_data_inorder('response', array("post_id" => $this->input->post('post_id'), "emoji_id" => $ed->id));
                                        if (!empty($total_emoji)) {
                                            foreach ($total_emoji as $te) {
                                                $tval["id"] = $te->id;
                                                $tval["post_id"] = $te->post_id;
                                                $tval["user_id"] = $te->user_id;
                                                $responser_data = $this->V1_model->get_single_row('users', array("id" => $te->user_id));
                                                $tval["responser_full_name"] = $responser_data->frist_name . " " . $responser_data->last_name;
                                                $tval["responser_username"] = $responser_data->username;
                                                $tval["responser_profile"] = $responser_data->profile;
                                                $tval["emoji_id"] = $te->emoji_id;
                                                $tval["emoji_image"] = $this->V1_model->get_single_row('emoji', array("id" => $te->emoji_id));
                                                ;
                                                $tval["created_on"] = $te->created_on;
                                                $tval["updated_on"] = $te->updated_on;
                                                $tval1[] = $tval;
                                            }
                                            $eval["responser_data"] = $tval1;
                                            unset($tval1);
                                        } else {
                                            $eval["responser_data"] = array();
                                        }
                                        $eval["total_emoji"] = count($total_emoji);
                                        $eval1[] = $eval;
                                    }
                                    $array1["total_response"] = $eval1;
                                    unset($eval1);
                                } else {
                                    $array1["total_response"] = array();
                                }
                                //
                                $array1['status'] = true;
                                $array1['message'] = $this->input->post('emoji_id');
                                //$array1["data"]=$tval1;
                            } else {
                                $array1['status'] = false;
                                $array1['message'] = "issue occurred";
                            }
                        }
                    } else {
                        $insert_id = $this->V1_model->insert('response', array("post_id" => $this->input->post('post_id'),
                            "user_id" => $this->input->post('user_id'), "emoji_id" => $this->input->post('emoji_id'), "created_on" => date("Y-m-d H:i:s")));
                        if ($insert_id) {
                            /* add notification  s */
                            if ($chk_post->user_id != $this->input->post('user_id')) {
                                /*                                 * send notification */
                                $this->send_notification($this->input->post('user_id'), $chk_post->user_id, $insert_id, $this->input->post('post_id'), "response", "response");
                                /** send notification */
                                $this->V1_model->insert('notification', array("receiver_id" => $chk_post->user_id,
                                    "post_id" => $this->input->post('post_id'), "response_id" => $insert_id, "from_id" => $this->input->post('user_id'), "action" => $this->input->post('emoji_id'), "created_on" => date("Y-m-d H:i:s")));
                            }
                            /* add notification  e */
                            // $data=$this->V1_model->get_tbl_data_inorder('response',array("post_id"=>$this->input->post('post_id')));
                            //
                          $emoji_data = $this->V1_model->get_tbl_data('emoji', array());
                            if (!empty($emoji_data)) {
                                foreach ($emoji_data as $ed) {
                                    $eval["id"] = $ed->id;
                                    $eval["name"] = $ed->name;
                                    $eval["emoji"] = $ed->emoji;
                                    $total_emoji = $this->V1_model->get_tbl_data_inorder('response', array("post_id" => $this->input->post('post_id'), "emoji_id" => $ed->id));
                                    if (!empty($total_emoji)) {
                                        foreach ($total_emoji as $te) {
                                            $tval["id"] = $te->id;
                                            $tval["post_id"] = $te->post_id;
                                            $tval["user_id"] = $te->user_id;
                                            $responser_data = $this->V1_model->get_single_row('users', array("id" => $te->user_id));
                                            $tval["responser_full_name"] = $responser_data->frist_name . " " . $responser_data->last_name;
                                            $tval["responser_username"] = $responser_data->username;
                                            $tval["responser_profile"] = $responser_data->profile;
                                            $tval["emoji_id"] = $te->emoji_id;
                                            $tval["emoji_image"] = $this->V1_model->get_single_row('emoji', array("id" => $te->emoji_id));
                                            ;
                                            $tval["created_on"] = $te->created_on;
                                            $tval["updated_on"] = $te->updated_on;
                                            $tval1[] = $tval;
                                        }
                                        $eval["responser_data"] = $tval1;
                                        unset($tval1);
                                    } else {
                                        $eval["responser_data"] = array();
                                    }
                                    $eval["total_emoji"] = count($total_emoji);
                                    $eval1[] = $eval;
                                }
                                $array1["total_response"] = $eval1;
                                unset($eval1);
                            } else {
                                $array1["total_response"] = array();
                            }
                            //
                            $array1['status'] = true;
                            $array1['message'] = $this->input->post('emoji_id');
                            //$array1["data"]=$tval1;
                        } else {
                            $array1['status'] = false;
                            $array1['message'] = "issue occurred";
                        }
                    }
                } else {
                    $array1['status'] = false;
                    $array1['message'] = "Invalid Post Id";
                }
            } else {
                $array1['status'] = false;
                $array1['message'] = "Invalid User Id";
            }
        } else {
            $message = strip_tags(validation_errors());
            $array1['status'] = false;
            $array1['message'] = $message;
        }
        echo json_encode($array1);
    }

    /* give_reaction e */

    /* give comment s */

    public function give_comment() {
        $this->form_validation->set_rules('user_id', 'user_id', 'required');
        $this->form_validation->set_rules('post_id', 'post_id', 'required');
        $this->form_validation->set_rules('comment', 'comment', 'required');
        if ($this->form_validation->run() == TRUE) {
            $chk_user = $this->V1_model->get_single_row('users', array("id" => $this->input->post('user_id')));
            if (!empty($chk_user)) {
                $chk_post = $this->V1_model->get_single_row('post', array("id" => $this->input->post('post_id')));
                if (!empty($chk_post)) {
                    $insert_id = $this->V1_model->insert("comment", array("user_id" => $this->input->post('user_id'), "post_id" => $this->input->post('post_id'),
                        "comment" => $this->input->post('comment'), "created_on" => date("Y-m-d H:i:s")));
                    if ($insert_id) {
                        if ($chk_post->user_id != $this->input->post('user_id')) {
                            /*                             * send notification */
                            $this->send_notification($this->input->post('user_id'), $chk_post->user_id, $insert_id, $this->input->post('post_id'), "comment", "comment");
                            /** send notification */
                            /* add notification  s */
                            $this->V1_model->insert('notification', array("receiver_id" => $chk_post->user_id,
                                "post_id" => $this->input->post('post_id'), "response_id" => $insert_id, "from_id" => $this->input->post('user_id'), "action" => "comment", "created_on" => date("Y-m-d H:i:s")));
                        }
                        /* add notification  e */
                        $data = $this->V1_model->get_tbl_data_inorder('comment', array("post_id" => $this->input->post('post_id'), "is_delete" => 0));
                        if (!empty($data)) {
                            foreach ($data as $da) {
                                $val["id"] = $da->id;
                                $val["user_id"] = $da->user_id;
                                $val["post_id"] = $da->post_id;
                                $commenter_data = $this->V1_model->get_single_row('users', array("id" => $da->user_id));
                                $val["commenter_full_name"] = $commenter_data->frist_name . " " . $commenter_data->last_name;
                                $val["commenter_username"] = $commenter_data->username;
                                $val["commenter_profile"] = $commenter_data->profile;
                                $val["comment"] = $da->comment;
                                $val["created_on"] = $da->created_on;
                                $val["time_ago"] = $this->time_elapsed_string($da->created_on);
                                $val1[] = $val;
                            }
                            $array1['status'] = true;
                            $array1['data'] = $val1;
                        } else {
                            
                        }
                    } else {
                        $array1['status'] = false;
                        $array1['message'] = "Issue Occurred";
                    }
                } else {
                    $array1['status'] = false;
                    $array1['message'] = "Invalid Post Id";
                }
            } else {
                $array1['status'] = false;
                $array1['message'] = "Invalid User Id";
            }
        } else {
            $message = strip_tags(validation_errors());
            $array1['status'] = false;
            $array1['message'] = $message;
        }
        echo json_encode($array1);
    }

    /* give comment e */

    public function attach_notification($user_from, $user_to, $post_id, $title, $table) {
        #API access key from Google API's Console
        //define( 'API_ACCESS_KEY','AAAAgtueR_I:APA91bFbIii20DMXpxO5k0tW9Y5f7IyvdVlzS-dQNKR-gqVuOgoDClSPDkyBXUa_0H1oWWQm9jDPvb3cjMyuEW-tVOStGaUdr_GK0yYLIFmMAHeL1YGJXnOD_Fc8gdzBHWHOxEoGd-rg');
        //	define( 'API_ACCESS_KEY','AAAAR9x0A88:APA91bGm4vhNV_ouxSmT4I1PR7IK7jZdEyE8QkRKnMmX3Z4mRLlMsFSLfP-q5OPcNEvxb3yg1qee7BmJtg0aZPwg-oNSzF5Nq6WxJW0Nru4CdDwvD7z0JFmZmnFX4tJxI28wM28GgnpI');
        $usrid = $this->V1_model->get_single_row("post", array('id' => $post_id))->user_id;
        $userData = $this->V1_model->get_single_row("users", array('id' => $user_to));
        $token = $userData->device_token;
        // if($userData->notification_status=="on"||$title=="comment")
        // {
        //$token='elf8Vfybmt4:APA91bEBD6zwNUwcZ_xTJSvpL-cgCd2dWUIwPoLKjaSA3pvcPyG2c5WLJooiGH2Ej44fX4Khgbyyn3SU4_DMserWCxjjPjWn6059Q5f7phCCe1Qo0Zhh0BCliND13ytLeq7ULJg0sUkt';
        $registrationIds = $token;
        $chatData = $this->V1_model->get_single_row($table, array('id' => $post_id));
        $chatdata = $chatData;
        $uArr["userData"] = $userData;
        $uArr["msgData"] = $chatdata;

        $userfrom = $this->V1_model->get_single_row("users", array('id' => $user_from));

        $body = $userfrom->frist_name . " " . $userfrom->last_name . "Tagged You On Post";

        $body1 = json_decode('"' . $body . '"');




        #prep the bundle
        $msg = array
            (
            'body' => $body1,
            'title' => $title,
            'icon' => '',
            'sound' => 'default',
            'click_action' => $title,
        );

        $fields = array
            (
            'to' => $registrationIds,
            'data' => $uArr,
            'notification' => $msg
        );


        $headers = array
            (
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );
        //	echo json_encode( $fields );exit;
        #Send Reponse To FireBase Server	
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        #Echo Result Of FireBase Server
        //echo $result;
        //}
    }

    public function send_notification($user_from, $user_to, $insert_id, $post_id, $title, $table) {
        #API access key from Google API's Console
        //define( 'API_ACCESS_KEY','AAAAgtueR_I:APA91bFbIii20DMXpxO5k0tW9Y5f7IyvdVlzS-dQNKR-gqVuOgoDClSPDkyBXUa_0H1oWWQm9jDPvb3cjMyuEW-tVOStGaUdr_GK0yYLIFmMAHeL1YGJXnOD_Fc8gdzBHWHOxEoGd-rg');
        //define( 'API_ACCESS_KEY','AAAAR9x0A88:APA91bGm4vhNV_ouxSmT4I1PR7IK7jZdEyE8QkRKnMmX3Z4mRLlMsFSLfP-q5OPcNEvxb3yg1qee7BmJtg0aZPwg-oNSzF5Nq6WxJW0Nru4CdDwvD7z0JFmZmnFX4tJxI28wM28GgnpI');
        $usrid = $this->V1_model->get_single_row("post", array('id' => $post_id))->user_id;
        $userData = $this->V1_model->get_single_row("users", array('id' => $user_to));
        $token = $userData->device_token;
        if ($userData->notification_status == "on" || $title == "comment") {
            //$token='elf8Vfybmt4:APA91bEBD6zwNUwcZ_xTJSvpL-cgCd2dWUIwPoLKjaSA3pvcPyG2c5WLJooiGH2Ej44fX4Khgbyyn3SU4_DMserWCxjjPjWn6059Q5f7phCCe1Qo0Zhh0BCliND13ytLeq7ULJg0sUkt';
            $registrationIds = $token;
            $chatData = $this->V1_model->get_single_row($table, array('id' => $insert_id));
            $chatdata = $chatData;
            $uArr["userData"] = $userData;
            $uArr["msgData"] = $chatdata;

            $userfrom = $this->V1_model->get_single_row("users", array('id' => $user_from));
            if ($title == "response") {
                $body = $userfrom->frist_name . " " . $userfrom->last_name . " Give response On your Post";
            } else {
                $body = $userfrom->frist_name . " " . $userfrom->last_name . " Commented On your Post";
            }

            $body1 = json_decode('"' . $body . '"');


            #prep the bundle
            $msg = array
                (
                'body' => $body1,
                'title' => $title,
                'icon' => '',
                'sound' => 'default',
                'click_action' => $title,
            );

            $fields = array
                (
                'to' => $registrationIds,
                'data' => $uArr,
                'notification' => $msg
            );


            $headers = array
                (
                'Authorization: key=' . API_ACCESS_KEY,
                'Content-Type: application/json'
            );
            //	echo json_encode( $fields );exit;
            #Send Reponse To FireBase Server	
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            curl_close($ch);
            #Echo Result Of FireBase Server
            //echo $result;
        }
    }

    //
    ////
    public function request_notification($user_to, $user_from, $insert_id, $title) {
        #API access key from Google API's Console
        //define( 'API_ACCESS_KEY','AAAAgtueR_I:APA91bFbIii20DMXpxO5k0tW9Y5f7IyvdVlzS-dQNKR-gqVuOgoDClSPDkyBXUa_0H1oWWQm9jDPvb3cjMyuEW-tVOStGaUdr_GK0yYLIFmMAHeL1YGJXnOD_Fc8gdzBHWHOxEoGd-rg');
        //define( 'API_ACCESS_KEY','AAAAR9x0A88:APA91bGm4vhNV_ouxSmT4I1PR7IK7jZdEyE8QkRKnMmX3Z4mRLlMsFSLfP-q5OPcNEvxb3yg1qee7BmJtg0aZPwg-oNSzF5Nq6WxJW0Nru4CdDwvD7z0JFmZmnFX4tJxI28wM28GgnpI');
        //$usrid = $this->V1_model->get_single_row("post",array('id'=>$post_id))->user_id;
        $userData = $this->V1_model->get_single_row("users", array('id' => $user_to));
        $token = $userData->device_token;
        if ($userData->notification_status == "on" || $title == "Request") {
            //$token='elf8Vfybmt4:APA91bEBD6zwNUwcZ_xTJSvpL-cgCd2dWUIwPoLKjaSA3pvcPyG2c5WLJooiGH2Ej44fX4Khgbyyn3SU4_DMserWCxjjPjWn6059Q5f7phCCe1Qo0Zhh0BCliND13ytLeq7ULJg0sUkt';
            $registrationIds = $token;
            $chatData = $this->V1_model->get_single_row('friend_list', array('id' => $insert_id));
            $chatdata = $chatData;
            $uArr["userData"] = $userData;
            $uArr["msgData"] = $chatdata;

            $userfrom = $this->V1_model->get_single_row("users", array('id' => $user_from));
            if ($title == "Request") {
                $body = $userfrom->frist_name . " " . $userfrom->last_name . " Sent You Friend Request";
            } else {
                $body = $userfrom->frist_name . " " . $userfrom->last_name . " Accepted Your Friend Request";
            }


            $body1 = json_decode('"' . $body . '"');

            #prep the bundle
            $msg = array
                (
                'body' => $body1,
                'title' => $title,
                'icon' => '',
                'sound' => 'default',
                'click_action' => 'request',
            );

            $fields = array
                (
                'to' => $registrationIds,
                'data' => $uArr,
                'notification' => $msg
            );


            $headers = array
                (
                'Authorization: key=' . API_ACCESS_KEY,
                'Content-Type: application/json'
            );
            //	echo json_encode( $fields );exit;
            #Send Reponse To FireBase Server	
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            curl_close($ch);
            #Echo Result Of FireBase Server
            //echo $result;
        }
    }

    ////
    /////////
    public function chat_notification($user_to, $user_from, $insert_id, $title, $body) {
        #API access key from Google API's Console
        //define( 'API_ACCESS_KEY','AAAAgtueR_I:APA91bFbIii20DMXpxO5k0tW9Y5f7IyvdVlzS-dQNKR-gqVuOgoDClSPDkyBXUa_0H1oWWQm9jDPvb3cjMyuEW-tVOStGaUdr_GK0yYLIFmMAHeL1YGJXnOD_Fc8gdzBHWHOxEoGd-rg');
        //	define( 'API_ACCESS_KEY','AAAAR9x0A88:APA91bGm4vhNV_ouxSmT4I1PR7IK7jZdEyE8QkRKnMmX3Z4mRLlMsFSLfP-q5OPcNEvxb3yg1qee7BmJtg0aZPwg-oNSzF5Nq6WxJW0Nru4CdDwvD7z0JFmZmnFX4tJxI28wM28GgnpI');
        //$usrid = $this->V1_model->get_single_row("post",array('id'=>$post_id))->user_id;
        $userData = $this->V1_model->get_single_row("users", array('id' => $user_to));
        $token = $userData->device_token;

        //	$token='ffIdq80Rm5A:APA91bG68ZQF0jnehstGJlJOviaE7Hl6iX66MQlORzYfugGxGWfFUallvuUUg7i7QlgY9e0HtqMpoKkV6O_oq7mDxSclpnhsEEXz8dJOOPaNAs50m7MJDsavkkgCgZ3Qf9r-M1t0K0VP';
        //if($userData->notification_status=="on")
        //{
        //$token='elf8Vfybmt4:APA91bEBD6zwNUwcZ_xTJSvpL-cgCd2dWUIwPoLKjaSA3pvcPyG2c5WLJooiGH2Ej44fX4Khgbyyn3SU4_DMserWCxjjPjWn6059Q5f7phCCe1Qo0Zhh0BCliND13ytLeq7ULJg0sUkt';
        $registrationIds = $token;
        $chatData = $this->V1_model->get_single_row('chat', array('id' => $insert_id));
        $chat_data = $this->V1_model->get_tbl_data('chat', array("id" => $insert_id));
        $chatdata = $chatData;
        //$uArr["userData"] = $userData;
        $uArr["msgData"] = $chat_data;

        $userfrom = $this->V1_model->get_single_row("users", array('id' => $user_from));

        $full_name = $userfrom->frist_name . " " . $userfrom->last_name;
        //
        // $full_name1=utf8_encode($full_name);
        //
		        	if ($chatData->type == "text") {
            $in_body = $chatData->msg;
        } else {
            $in_body = "File";
        }


        $body1 = json_decode('"' . $in_body . '"');
        $full_name1 = json_decode('"' . $full_name . '"');

        #prep the bundle
        $msg = array
            (
            'body' => $body1,
            'title' => $full_name1,
            'icon' => '',
            'sound' => 'default',
            'click_action' => 'request',
        );
        // 
        // 

        $fields = array
            (
            'to' => $registrationIds,
            'data' => $uArr,
            'notification' => $msg
        );


        $headers = array
            (
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );
        //	echo json_encode( $fields );exit;
        #Send Reponse To FireBase Server	
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        #Echo Result Of FireBase Server
        //echo $result;
        // }
    }

    /////////
    public function fcm_test() {
        // API access key from Google API's Console
        define('API_ACCESS_KEY', 'AAAAR9x0A88:APA91bGm4vhNV_ouxSmT4I1PR7IK7jZdEyE8QkRKnMmX3Z4mRLlMsFSLfP-q5OPcNEvxb3yg1qee7BmJtg0aZPwg-oNSzF5Nq6WxJW0Nru4CdDwvD7z0JFmZmnFX4tJxI28wM28GgnpI');


        $registrationIds = array("EC24B751-A21F-4925-A750-1B02801AB965");

// prep the bundle
        $msg = array
            (
            'message' => 'here is a message. message',
            'title' => 'This is a title. title',
            'subtitle' => 'This is a subtitle. subtitle',
            'tickerText' => 'Ticker text here...Ticker text here...Ticker text here',
            'vibrate' => 1,
            'sound' => 1
        );

        $fields = array
            (
            'registration_ids' => $registrationIds,
            'data' => $msg
        );

        $headers = array
            (
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);

        echo $result;
    }

    /*  update device token start  */



    /*     * block user s* */

    public function block_user() {
        if ($this->input->post('user_id') && $this->input->post('friend_id') && $this->input->post('action') != "") {
            $action = $this->input->post('action');
            $user_id_from = $this->input->post('user_id');
            $user_id_to = $this->input->post('friend_id');
            $chk = $this->db->query("SELECT * FROM friend_list WHERE (user_id_from='$user_id_from' && user_id_to='$user_id_to') ||(user_id_from='$user_id_to' && user_id_to='$user_id_from') ")->row();
            //$chk=$this->V1_model->get_single_row('friend_list',array("user_id_to"=>$this->input->post('user_id'),"user_id_from"=>$this->input->post('sender_id')));
            if (!empty($chk)) {
                if ($chk->user_id_from == $user_id_from) {
                    $arr = array("is_block_by_from" => $action, "updated_on" => date("Y-m-d H:i:s"));

                    $update = $this->V1_model->update('friend_list', $chk->id, $arr);
                    if ($update) {
                        $data = $this->V1_model->get_single_row('friend_list', array('id' => $chk->id));
                        $array1["status"] = true;
                        if ($action == 1) {
                            $message = "Block User Successfully ";
                        } else {
                            $message = "Unblock User Successfully ";
                        }
                        $array1["message"] = $message;
                        $array1["data"] = $data;
                    } else {
                        $array1["status"] = false;
                        $array1["message"] = "please try again later";
                    }
                } else {
                    $arr = array("is_block_by_to" => $action, "updated_on" => date("Y-m-d H:i:s"));

                    $update = $this->V1_model->update('friend_list', $chk->id, $arr);
                    if ($update) {
                        $data = $this->V1_model->get_single_row('friend_list', array('id' => $chk->id));
                        $array1["status"] = true;
                        if ($action == 1) {
                            $message = "Block User Successfully ";
                        } else {
                            $message = "Unblock User Successfully ";
                        }
                        $array1["message"] = $message;
                        $array1["data"] = $data;
                    } else {
                        $array1["status"] = false;
                        $array1["message"] = "please try again later";
                    }
                }
            } else {
                $array1["status"] = false;
                $array1["message"] = "no data found";
            }
        } else {
            $array1["status"] = false;
            $array1["message"] = "Please fill all field";
        }
        echo json_encode($array1);
    }

    /*     * block user e* */

//   public function notification_list()
//   {
//       $this->form_validation->set_rules('user_id', 'user_id', 'required');
//         if($this->form_validation->run() == TRUE)
//         {
//              $notification=$this->V1_model->get_tbl_data_inorder('notification',array("receiver_id"=>$this->input->post('user_id'),"is_delete"=>0));
//              if(!empty($notification))
//              {
//                  foreach($notification as $no)
//                  {
//                      $val["receiver_id"]=$no->receiver_id;
//                      $val["post_id"]=$no->post_id;
//                      if($no->action!="accept")
//                      {
//                          $val["post_data"]=$this->V1_model->get_single_row('post',array("id"=>$no->post_id));
//                      }
//                      $val["from_id"]=$no->from_id;
//                      $val["from_user_data"]=$this->V1_model->get_single_row('users',array("id"=>$no->from_id));
//                      $val["action"]=$no->action;
//                      if($no->action=="comment")
//                      {
//                          $val["action_data"]=$this->V1_model->get_single_row('comment',array("id"=>$no->response_id));
//                      }
//                      elseif($no->action=="accept")
//                      {
//                          $val["action_data"]=array();
//                      }
//                      else
//                      {
//                          $val["action_data"]=$this->V1_model->get_single_row('response',array("id"=>$no->response_id));
//                      }
//                      $val["created_on"]=$no->created_on;
//                      $val1[]=$val;
//                  }
//                   $array1["status"] = true;
//                   $array1["data"] =$val1;
//              }
//              else
//              {
//                  $array1["status"] = false ;
//                  $array1["message"] = "no data found" ;
//              }
//         }
//         else
//         {
//              $message = strip_tags(validation_errors());
//               $array1['status'] = false; 
//               $array1['message'] = $message;
//         }
//         echo json_encode($array1);
//   }
    ////
    public function new_notification_list() {
        $this->form_validation->set_rules('user_id', 'user_id', 'required');
        if ($this->form_validation->run() == TRUE) {
            $notification = $this->V1_model->get_tbl_data_inorder('notification', array("receiver_id" => $this->input->post('user_id'), "is_delete" => 0));
            if (!empty($notification)) {
                foreach ($notification as $no) {
                    $val["receiver_id"] = $no->receiver_id;
                    $val["post_id"] = $no->post_id;
                    $val["from_id"] = $no->from_id;
                    $from_user = $this->V1_model->get_single_row('users', array("id" => $no->from_id));
                    $val["from_username"] = $from_user->username;
                    $val["full_name"] = $from_user->frist_name . " " . $from_user->last_name;
                    //  $val["action"]=$no->action;
                    if ($no->action == "comment") {
                        $val["action"] = $no->action;
                        $val["notification_type"] = $no->action;
                        $val["detail"] = $from_user->frist_name . " " . $from_user->last_name . " Commented On Your Post ";
                    } elseif ($no->action == "accept") {
                        $val["action"] = $no->action;
                        $val["notification_type"] = $no->action;
                        $val["detail"] = $from_user->frist_name . " " . $from_user->last_name . " Accepted Your Friend Request ";
                    } elseif ($no->action == "Request") {
                        $val["action"] = $no->action;
                        $val["notification_type"] = $no->action;
                        $val["detail"] = $from_user->frist_name . " " . $from_user->last_name . " Send You Friend Request ";
                    } elseif ($no->action == "attach") {
                        $val["action"] = $no->action;
                        $val["notification_type"] = $no->action;
                        $val["detail"] = $from_user->frist_name . " " . $from_user->last_name . " Tagged You On Post";
                    } else {
                        $val["action"] = $this->V1_model->get_single_row('emoji', array("id" => $no->action))->name;
                        $val["notification_type"] = "response";
                        $val["detail"] = $from_user->frist_name . " " . $from_user->last_name . "  Give Response On Your Post ";
                    }
                    $val["is_view"] = $no->is_view;
                    $val["created_on"] = $no->created_on;
                    $val1[] = $val;
                }

                $array1["status"] = true;
                $array1["data"] = $val1;
            } else {
                $array1["status"] = false;
                $array1["message"] = "no data found";
            }
        } else {
            $message = strip_tags(validation_errors());
            $array1['status'] = false;
            $array1['message'] = $message;
        }
        echo json_encode($array1);
    }

    ////

    public function add_view_notification() {
        $this->form_validation->set_rules('notification_id', 'notification_id', 'required');
        if ($this->form_validation->run() == TRUE) {
            $notification = $this->V1_model->get_single_row('notification', array("id" => $this->input->post('notification_id')));
            if (!empty($notification)) {
                $update = $this->V1_model->update('notification', $notification->id, array("is_view" => 1));
                if (!empty($update)) {
                    $data = $this->V1_model->get_single_row('notification', array("id" => $notification->id));
                    $array1['status'] = true;
                    $array1['message'] = "View Notication";
                    $array1["data"] = $data;
                } else {
                    $array1['status'] = false;
                    $array1['message'] = "issue Occurred";
                }
            } else {
                $array1["status"] = false;
                $array1["message"] = "invalid notification_id ";
            }
        } else {
            $message = strip_tags(validation_errors());
            $array1['status'] = false;
            $array1['message'] = $message;
        }
        echo json_encode($array1);
    }

    public function view_post() {
        $this->form_validation->set_rules('user_id', 'user_id', 'required');
        $this->form_validation->set_rules('page', 'page', 'required');
        if ($this->form_validation->run() == TRUE) {
            $chk_user = $this->V1_model->get_single_row('users', array("id" => $this->input->post('user_id')));
            if (!empty($chk_user)) {
                /* $friend_id_to s */
                $friend_id_to = $this->V1_model->get_tbl_data('friend_list', array("user_id_from" => $this->input->post('user_id'), "is_accept" => 1, "is_block_by_to" => 0, "is_block_by_from" => 0));
                if (!empty($friend_id_to)) {
                    foreach ($friend_id_to as $f_to) {
                        $f_to_arr[] = $f_to->user_id_to;
                    }

                    $f_to_str = implode(",", $f_to_arr);

                    /* $friend_id_from s */
                    $friend_id_from = $this->V1_model->get_tbl_data('friend_list', array("user_id_to" => $this->input->post('user_id'), "is_accept" => 1, "is_block_by_from" => 0, "is_block_by_to" => 0));
                    if (!empty($friend_id_from)) {
                        foreach ($friend_id_from as $f_from) {
                            $f_from_arr[] = $f_from->user_id_from;
                        }
                        $f_from_str = implode(",", $f_from_arr);

                        $friends_id = $f_to_str . "," . $f_from_str;
                    } else {
                        $friends_id = $f_to_str;
                    }
                } else {
                    /* $friend_id_from s */
                    $friend_id_from = $this->V1_model->get_tbl_data('friend_list', array("user_id_to" => $this->input->post('user_id'), "is_accept" => 1));
                    if (!empty($friend_id_from)) {
                        foreach ($friend_id_from as $f_from) {
                            $f_from_arr[] = $f_from->user_id_from;
                        }
                        $f_from_str = implode(",", $f_from_arr);

                        $friends_id = $f_from_str;
                    } else {
                        $friends_id = "";
                    }
                }
                if (!empty($friends_id)) {
                    $friends_ids = $friends_id . "," . $this->input->post('user_id');
                } else {
                    $friends_ids = $this->input->post('user_id');
                }

                if (!empty($friends_ids)) {
                    $friends_ids1 = $friends_ids . ",1";
                    $fr_array = explode(",", $friends_ids1);
                    $data = $this->V1_model->fetch_data_in('post', 'user_id', $fr_array, '5', $this->input->post('page'));
                    //$data=$this->db->query("SELECT * FROM post WHERE user_id IN($friends_ids) ORDER BY id DESC")->result();
                    if (!empty($data)) {
                        foreach ($data as $da) {
                            $val["post_id"] = $da->id;
                            $val["user_id"] = $da->user_id;
                            $user_dataa = $this->V1_model->get_single_row('users', array("id" => $da->user_id));
                            if (!empty($user_dataa)) {
                                $val["user_data"] = $user_dataa;
                            } else {
                                $val["user_data"] = array();
                            }
                            $val["post_type"] = $da->post_type;
                            $val["post_text"] = $da->post_text;
                            $val["address"] = $da->address;
                            $val["latitude"] = $da->latitude;
                            $val["longitude"] = $da->longitude;
                            $val["created_on"] = $da->created_on;
                            $val["time_ago"] = $this->time_elapsed_string($da->created_on);
                            if (!empty($da->whos_with)) {
                                $whos_with_id = explode(",", $da->whos_with);
                                unset($vaal);
                                foreach ($whos_with_id as $ww) {

                                    $vaal[] = $this->V1_model->get_single_row('users', array("id" => $ww))->username;
                                }
                            } else {
                                $vaal = array();
                                $whos_with_id = array();
                            }
                            $val["whos_with"] = $vaal;

                            $val["whos_with_id"] = $whos_with_id;
                            if (!empty($da->image)) {
                                $img = explode(",", $da->image);
                            } else {
                                $img = array();
                            }
                            $val["image"] = $img;
                            $val["link"] = $da->link;
                            $val["title"] = $da->title;
                            $comment = $this->V1_model->get_tbl_data_inorder('comment', array("post_id" => $da->id, "is_delete" => 0));
                            if (!empty($comment)) {
                                foreach ($comment as $ct) {
                                    $cval["id"] = $ct->id;
                                    $cval["user_id"] = $ct->user_id;
                                    $commenter_data = $this->V1_model->get_single_row('users', array("id" => $ct->user_id));
                                    $cval["commenter_full_name"] = $commenter_data->frist_name . " " . $commenter_data->last_name;
                                    $cval["commenter_username"] = $commenter_data->username;
                                    $cval["commenter_profile"] = $commenter_data->profile;
                                    $cval["post_id"] = $ct->post_id;
                                    $cval["comment"] = $ct->comment;
                                    $cval["created_on"] = $ct->created_on;
                                    $cval["time_ago"] = $this->time_elapsed_string($ct->created_on);
                                    $cval1[] = $cval;
                                }
                                $val["comment_data"] = $cval1;
                                unset($cval1);
                            } else {
                                $val["comment_data"] = array();
                            }

                            $val["total_comment"] = count($comment);
                            $response = $this->V1_model->get_tbl_data_inorder('response', array("post_id" => $da->id));
                            //$val["response_data"]=$response;

                            $emoji_data = $this->V1_model->get_tbl_data('emoji', array());
                            if (!empty($emoji_data)) {
                                foreach ($emoji_data as $ed) {
                                    $eval["id"] = $ed->id;
                                    $eval["name"] = $ed->name;
                                    $eval["emoji"] = $ed->emoji;
                                    $total_emoji = $this->V1_model->get_tbl_data_inorder('response', array("post_id" => $da->id, "emoji_id" => $ed->id));
                                    if (!empty($total_emoji)) {
                                        foreach ($total_emoji as $te) {
                                            $tval["id"] = $te->id;
                                            $tval["post_id"] = $te->post_id;
                                            $tval["user_id"] = $te->user_id;
                                            $responser_data = $this->V1_model->get_single_row('users', array("id" => $te->user_id));
                                            $tval["responser_full_name"] = $responser_data->frist_name . " " . $responser_data->last_name;
                                            $tval["responser_username"] = $responser_data->username;
                                            $tval["responser_profile"] = $responser_data->profile;
                                            $tval["emoji_id"] = $te->emoji_id;
                                            $tval["emoji_image"] = $this->V1_model->get_single_row('emoji', array("id" => $te->emoji_id));
                                            ;
                                            $tval["created_on"] = $te->created_on;
                                            $tval["updated_on"] = $te->updated_on;
                                            $tval1[] = $tval;
                                        }
                                        $eval["responser_data"] = $tval1;
                                        unset($tval1);
                                    } else {
                                        $eval["responser_data"] = array();
                                    }
                                    $eval["total_emoji"] = count($total_emoji);
                                    $eval1[] = $eval;
                                }
                                $val["total_response"] = $eval1;
                                unset($eval1);
                            } else {
                                $val["total_response"] = array();
                            }

                            $my_response = $this->V1_model->get_single_row('response', array("post_id" => $da->id, "user_id" => $this->input->post('user_id')));
                            if (!empty($my_response)) {
                                $val["my_response"] = $my_response->emoji_id;
                            } else {
                                $val["my_response"] = 0;
                            }


                            $val1[] = $val;
                        }
                        $array1['status'] = true;
                        $array1['data'] = $val1;
                    } else {
                        $array1['status'] = false;
                        $array1['message'] = "No Post Found";
                    }
                } else {
                    //////////////////////////////////////////////////
                    $friends_ids1 = "1";
                    $fr_array = explode(",", $friends_ids1);
                    $data = $this->V1_model->fetch_data_in('post', 'user_id', $fr_array, '5', $this->input->post('page'));
                    //$data=$this->db->query("SELECT * FROM post WHERE user_id IN($friends_ids) ORDER BY id DESC")->result();
                    if (!empty($data)) {
                        foreach ($data as $da) {
                            $val["post_id"] = $da->id;
                            $val["user_id"] = $da->user_id;
                            $user_dataa = $this->V1_model->get_single_row('users', array("id" => $da->user_id));
                            if (!empty($user_dataa)) {
                                $val["user_data"] = $user_dataa;
                            } else {
                                $val["user_data"] = array();
                            }

                            $val["post_type"] = $da->post_type;
                            $val["post_text"] = $da->post_text;
                            $val["address"] = $da->address;
                            $val["latitude"] = $da->latitude;
                            $val["longitude"] = $da->longitude;
                            $val["created_on"] = $da->created_on;
                            $val["time_ago"] = $this->time_elapsed_string($da->created_on);
                            if (!empty($da->whos_with)) {
                                $whos_with_id = explode(",", $da->whos_with);
                                unset($vaal);
                                foreach ($whos_with_id as $ww) {

                                    $vaal[] = $this->V1_model->get_single_row('users', array("id" => $ww))->username;
                                }
                            } else {
                                $vaal = array();
                                $whos_with_id = array();
                            }
                            $val["whos_with"] = $vaal;

                            $val["whos_with_id"] = $whos_with_id;
                            if (!empty($da->image)) {
                                $img = explode(",", $da->image);
                            } else {
                                $img = array();
                            }
                            $val["image"] = $img;
                            $val["link"] = $da->link;
                            $val["title"] = $da->title;
                            $comment = $this->V1_model->get_tbl_data_inorder('comment', array("post_id" => $da->id, "is_delete" => 0));
                            if (!empty($comment)) {
                                foreach ($comment as $ct) {
                                    $cval["id"] = $ct->id;
                                    $cval["user_id"] = $ct->user_id;
                                    $commenter_data = $this->V1_model->get_single_row('users', array("id" => $ct->user_id));
                                    $cval["commenter_full_name"] = $commenter_data->frist_name . " " . $commenter_data->last_name;
                                    $cval["commenter_username"] = $commenter_data->username;
                                    $cval["commenter_profile"] = $commenter_data->profile;
                                    $cval["post_id"] = $ct->post_id;
                                    $cval["comment"] = $ct->comment;
                                    $cval["created_on"] = $ct->created_on;
                                    $cval["time_ago"] = $this->time_elapsed_string($ct->created_on);
                                    $cval1[] = $cval;
                                }
                                $val["comment_data"] = $cval1;
                                unset($cval1);
                            } else {
                                $val["comment_data"] = array();
                            }

                            $val["total_comment"] = count($comment);
                            $response = $this->V1_model->get_tbl_data_inorder('response', array("post_id" => $da->id));
                            //$val["response_data"]=$response;

                            $emoji_data = $this->V1_model->get_tbl_data('emoji', array());
                            if (!empty($emoji_data)) {
                                foreach ($emoji_data as $ed) {
                                    $eval["id"] = $ed->id;
                                    $eval["name"] = $ed->name;
                                    $eval["emoji"] = $ed->emoji;
                                    $total_emoji = $this->V1_model->get_tbl_data_inorder('response', array("post_id" => $da->id, "emoji_id" => $ed->id));
                                    if (!empty($total_emoji)) {
                                        foreach ($total_emoji as $te) {
                                            $tval["id"] = $te->id;
                                            $tval["post_id"] = $te->post_id;
                                            $tval["user_id"] = $te->user_id;
                                            $responser_data = $this->V1_model->get_single_row('users', array("id" => $te->user_id));
                                            $tval["responser_full_name"] = $responser_data->frist_name . " " . $responser_data->last_name;
                                            $tval["responser_username"] = $responser_data->username;
                                            $tval["responser_profile"] = $responser_data->profile;
                                            $tval["emoji_id"] = $te->emoji_id;
                                            $tval["emoji_image"] = $this->V1_model->get_single_row('emoji', array("id" => $te->emoji_id));
                                            ;
                                            $tval["created_on"] = $te->created_on;
                                            $tval["updated_on"] = $te->updated_on;
                                            $tval1[] = $tval;
                                        }
                                        $eval["responser_data"] = $tval1;
                                        unset($tval1);
                                    } else {
                                        $eval["responser_data"] = array();
                                    }
                                    $eval["total_emoji"] = count($total_emoji);
                                    $eval1[] = $eval;
                                }
                                $val["total_response"] = $eval1;
                                unset($eval1);
                            } else {
                                $val["total_response"] = array();
                            }

                            $my_response = $this->V1_model->get_single_row('response', array("post_id" => $da->id, "user_id" => $this->input->post('user_id')));
                            if (!empty($my_response)) {
                                $val["my_response"] = $my_response->emoji_id;
                            } else {
                                $val["my_response"] = 0;
                            }


                            $val1[] = $val;
                        }
                        $array1['status'] = true;
                        $array1['data'] = $val1;
                    } else {
                        $array1['status'] = false;
                        $array1['message'] = "No Post Found";
                    }
                    //////////////////////////////////////////////////
                }
            } else {
                $array1['status'] = false;
                $array1['message'] = "Invalid User Id";
            }
        } else {
            $message = strip_tags(validation_errors());
            $array1['status'] = false;
            $array1['message'] = $message;
        }
        echo json_encode($array1);
    }

    /* friend list e */

    ///
    public function view_response() {
        $this->form_validation->set_rules('user_id', 'user_id', 'required');
        $this->form_validation->set_rules('post_id', 'post_id', 'required');
        if ($this->form_validation->run() == TRUE) {

            $emoji_data = $this->V1_model->get_tbl_data('emoji', array());
            if (!empty($emoji_data)) {
                ////
                $all_emoji = $this->V1_model->get_tbl_data_inorder('response', array("post_id" => $this->input->post('post_id')));
                if (!empty($all_emoji)) {
                    //$atval1["total_count"]=count($all_emoji);
                    foreach ($all_emoji as $ae) {
                        $aval["id"] = $ae->id;
                        $aval["post_id"] = $ae->post_id;
                        $aval["user_id"] = $ae->user_id;
                        $responser_data = $this->V1_model->get_single_row('users', array("id" => $ae->user_id));
                        $aval["responser_full_name"] = $responser_data->frist_name . " " . $responser_data->last_name;
                        $aval["responser_username"] = $responser_data->username;
                        $aval["responser_profile"] = $responser_data->profile;
                        $aval["emoji_id"] = $ae->emoji_id;
                        $aval["emoji_image"] = $this->V1_model->get_single_row('emoji', array("id" => $ae->emoji_id));
                        ;
                        $aval["created_on"] = $ae->created_on;
                        $aval["updated_on"] = $ae->updated_on;
                        $atval1[] = $aval;
                    }
                    $array1["all_responser_count"] = count($all_emoji);
                    $array1["all_responser_data"] = $atval1;

                    //unset($tval1);
                } else {
                    $array1["all_responser_data"] = array();
                    $array1["all_responser_count"] = 0;
                }
                ////
                foreach ($emoji_data as $ed) {
                    $eval["id"] = $ed->id;
                    $eval["name"] = $ed->name;
                    $eval["emoji"] = $ed->emoji;


                    $total_emoji = $this->V1_model->get_tbl_data_inorder('response', array("post_id" => $this->input->post('post_id'), "emoji_id" => $ed->id));
                    if (!empty($total_emoji)) {
                        foreach ($total_emoji as $te) {
                            $tval["id"] = $te->id;
                            $tval["post_id"] = $te->post_id;
                            $tval["user_id"] = $te->user_id;
                            $responser_data = $this->V1_model->get_single_row('users', array("id" => $te->user_id));
                            $tval["responser_full_name"] = $responser_data->frist_name . " " . $responser_data->last_name;
                            $tval["responser_username"] = $responser_data->username;
                            $tval["responser_profile"] = $responser_data->profile;
                            $tval["emoji_id"] = $te->emoji_id;
                            $tval["emoji_image"] = $this->V1_model->get_single_row('emoji', array("id" => $te->emoji_id));
                            ;
                            $tval["created_on"] = $te->created_on;
                            $tval["updated_on"] = $te->updated_on;
                            $tval1[] = $tval;
                        }
                        $eval["responser_data"] = $tval1;
                        unset($tval1);
                    } else {
                        $eval["responser_data"] = array();
                    }
                    $eval["total_emoji"] = count($total_emoji);
                    $eval1[] = $eval;
                }
                $array1["total_response"] = $eval1;
                unset($eval1);
            } else {
                $array1["total_response"] = array();
            }

            $array1['status'] = true;
            //$array1['data'] = $val;
        } else {
            $message = strip_tags(validation_errors());
            $array1['status'] = false;
            $array1['message'] = $message;
        }
        echo json_encode($array1);
    }

    ///

    public function update_profile() {
        $this->form_validation->set_rules('user_id', 'user_id', 'required');
        $this->form_validation->set_rules('what_change', 'what_change', 'required');
        if ($this->input->post('what_change') != "profile") {
            $this->form_validation->set_rules('field', 'field', 'required');
        }

        if ($this->form_validation->run() == TRUE) {

            $chk = $this->V1_model->get_single_row('users', array("id" => $this->input->post('user_id')));
            if (!empty($chk)) {
                if ($this->input->post('what_change') == "profile") {
                    $profile = $this->upload_profile();
                    if (!empty($profile)) {
                        if (!empty($chk->profile)) {
                            unlink($chk->profile);
                        }
                        $update = $this->V1_model->update('users', $chk->id, array("profile" => $profile));
                        if (!empty($update)) {
                            $data = $this->V1_model->get_single_row('users', array("id" => $chk->id));
                            $array1['status'] = true;
                            $array1['message'] = "Profile Change  Successfully";
                            $array1["data"] = $data;
                        } else {
                            $array1['status'] = false;
                            $array1['message'] = "issue Occurred";
                        }
                    } else {
                        $array1['status'] = false;
                        // $array1['message'] = "Please you sent image in this fomets gif,jpg,png,jpeg"; 
                    }
                } elseif ($this->input->post('what_change') == "phone_number") {
                    $update = $this->V1_model->update('users', $chk->id, array("phone_number" => $this->input->post('field')));
                    if (!empty($update)) {
                        $data = $this->V1_model->get_single_row('users', array("id" => $chk->id));
                        $array1['status'] = true;
                        $array1['message'] = "Phone Number Change  Successfully";
                        $array1["data"] = $data;
                    } else {
                        $array1['status'] = false;
                        $array1['message'] = "Issue Occurred";
                    }
                } elseif ($this->input->post('what_change') == "notification") {
                    $update = $this->V1_model->update('users', $chk->id, array("notification_status" => $this->input->post('field')));
                    if (!empty($update)) {
                        $data = $this->V1_model->get_single_row('users', array("id" => $chk->id));
                        $array1['status'] = true;
                        if ($this->input->post('field') == "on") {
                            $message = "Notification On";
                        } else {
                            $message = "Notification Off";
                        }
                        $array1['message'] = $message;
                        $array1["data"] = $data;
                    } else {
                        $array1['status'] = false;
                        $array1['message'] = "Issue Occurred";
                    }
                } elseif ($this->input->post('what_change') == "full_name") {

                    $field = explode(",", $this->input->post('field'));


                    $update = $this->V1_model->update('users', $chk->id, array("frist_name" => $field[0] ?: '', "last_name" => $field[1] ?: ''));
                    if (!empty($update)) {
                        $data = $this->V1_model->get_single_row('users', array("id" => $chk->id));
                        $array1['status'] = true;
                        $array1['message'] = "Frist Name Change  Successfully";
                        $array1["data"] = $data;
                    } else {
                        $array1['status'] = false;
                        $array1['message'] = "Issue Occurred";
                    }
                } else {
                    $array1['status'] = false;
                    $array1['message'] = "Please Send Correct String In What_change Parameter ";
                }
            } else {
                $array1['status'] = false;
                $array1['message'] = "invalid user id";
            }
        } else {
            $message = strip_tags(validation_errors());
            $array1['status'] = false;
            $array1['message'] = $message;
        }
        echo json_encode($array1);
    }

    public function post_detail() {
        $this->form_validation->set_rules('user_id', 'user_id', 'required');
        $this->form_validation->set_rules('post_id', 'post_id', 'required');
        if ($this->form_validation->run() == TRUE) {
            $chk_user = $this->V1_model->get_single_row('users', array("id" => $this->input->post('user_id')));
            if (!empty($chk_user)) {
                $chk_post = $this->V1_model->get_single_row('post', array("id" => $this->input->post('post_id')));
                if (!empty($chk_post)) {
                    ////////////////////////////////////////////////////////

                    $val["post_id"] = $chk_post->id;
                    $val["user_id"] = $chk_post->user_id;
                    $user_dataa = $this->V1_model->get_single_row('users', array("id" => $chk_post->user_id));
                    if (!empty($user_dataa)) {
                        $val["user_data"] = $user_dataa;
                    } else {
                        $val["user_data"] = array();
                    }
                    $val["post_type"] = $chk_post->post_type;
                    $val["post_text"] = $chk_post->post_text;
                    $val["address"] = $chk_post->address;
                    $val["latitude"] = $chk_post->latitude;
                    $val["longitude"] = $chk_post->longitude;
                    $val["created_on"] = $chk_post->created_on;
                    $val["time_ago"] = $this->time_elapsed_string($chk_post->created_on);
                    if (!empty($chk_post->whos_with)) {
                        $whos_with_id = explode(",", $chk_post->whos_with);
                        unset($vaal);
                        foreach ($whos_with_id as $ww) {

                            $vaal[] = $this->V1_model->get_single_row('users', array("id" => $ww))->username;
                        }
                    } else {
                        $vaal = array();
                        $whos_with_id = array();
                    }
                    $val["whos_with"] = $vaal;

                    $val["whos_with_id"] = $whos_with_id;
                    if (!empty($chk_post->image)) {
                        $img = explode(",", $chk_post->image);
                    } else {
                        $img = array();
                    }
                    $val["image"] = $img;
                    $val["link"] = $chk_post->link;
                    $val["title"] = $chk_post->title;
                    $comment = $this->V1_model->get_tbl_data_inorder('comment', array("post_id" => $chk_post->id, "is_delete" => 0));
                    if (!empty($comment)) {
                        foreach ($comment as $ct) {
                            $cval["id"] = $ct->id;
                            $cval["user_id"] = $ct->user_id;
                            $commenter_data = $this->V1_model->get_single_row('users', array("id" => $ct->user_id));
                            $cval["commenter_full_name"] = $commenter_data->frist_name . " " . $commenter_data->last_name;
                            $cval["commenter_username"] = $commenter_data->username;
                            $cval["commenter_profile"] = $commenter_data->profile;
                            $cval["post_id"] = $ct->post_id;
                            $cval["comment"] = $ct->comment;
                            $cval["created_on"] = $ct->created_on;
                            $cval["time_ago"] = $this->time_elapsed_string($ct->created_on);
                            $cval1[] = $cval;
                        }
                        $val["comment_data"] = $cval1;
                        unset($cval1);
                    } else {
                        $val["comment_data"] = array();
                    }

                    $val["total_comment"] = count($comment);
                    $response = $this->V1_model->get_tbl_data_inorder('response', array("post_id" => $chk_post->id));
                    //$val["response_data"]=$response;

                    $emoji_data = $this->V1_model->get_tbl_data('emoji', array());
                    if (!empty($emoji_data)) {
                        foreach ($emoji_data as $ed) {
                            $eval["id"] = $ed->id;
                            $eval["name"] = $ed->name;
                            $eval["emoji"] = $ed->emoji;
                            $total_emoji = $this->V1_model->get_tbl_data_inorder('response', array("post_id" => $chk_post->id, "emoji_id" => $ed->id));
                            if (!empty($total_emoji)) {
                                foreach ($total_emoji as $te) {
                                    $tval["id"] = $te->id;
                                    $tval["post_id"] = $te->post_id;
                                    $tval["user_id"] = $te->user_id;
                                    $responser_data = $this->V1_model->get_single_row('users', array("id" => $te->user_id));
                                    $tval["responser_full_name"] = $responser_data->frist_name . " " . $responser_data->last_name;
                                    $tval["responser_username"] = $responser_data->username;
                                    $tval["responser_profile"] = $responser_data->profile;
                                    $tval["emoji_id"] = $te->emoji_id;
                                    $tval["emoji_image"] = $this->V1_model->get_single_row('emoji', array("id" => $te->emoji_id));
                                    ;
                                    $tval["created_on"] = $te->created_on;
                                    $tval["updated_on"] = $te->updated_on;
                                    $tval1[] = $tval;
                                }
                                $eval["responser_data"] = $tval1;
                                unset($tval1);
                            } else {
                                $eval["responser_data"] = array();
                            }
                            $eval["total_emoji"] = count($total_emoji);
                            $eval1[] = $eval;
                        }
                        $val["total_response"] = $eval1;
                        unset($eval1);
                    } else {
                        $val["total_response"] = array();
                    }

                    $my_response = $this->V1_model->get_single_row('response', array("post_id" => $chk_post->id, "user_id" => $this->input->post('user_id')));
                    if (!empty($my_response)) {
                        $val["my_response"] = $my_response->emoji_id;
                    } else {
                        $val["my_response"] = 0;
                    }





                    $array1['status'] = true;
                    $array1['data'] = $val;
                    ////////////////////////////////////////////////////////
                } else {
                    $array1['status'] = false;
                    $array1['message'] = "invalid post id";
                }
            } else {
                $array1['status'] = false;
                $array1['message'] = "invalid user id";
            }
        } else {
            $message = strip_tags(validation_errors());
            $array1['status'] = false;
            $array1['message'] = $message;
        }
        echo json_encode($array1);
    }

    public function someone_profile() {
        $this->form_validation->set_rules('user_id', 'user_id', 'required');
        $this->form_validation->set_rules('page', 'page', 'required');
        $this->form_validation->set_rules('someone_profile_id', 'someone_profile_id', 'required');
        if ($this->form_validation->run() == TRUE) {
            $chk_user = $this->V1_model->get_single_row('users', array("id" => $this->input->post('user_id')));
            if (!empty($chk_user)) {
                $chk_someone = $this->V1_model->get_single_row('users', array("id" => $this->input->post('someone_profile_id')));
                if (!empty($chk_someone)) {
                    $array1["status"] = true;
                    $array1["profile_data"] = $chk_someone;
                    $user_id_from = $this->input->post('user_id');
                    $user_id_to = $this->input->post('someone_profile_id');
                    $friend_status = $this->chk_friend_status($user_id_from, $user_id_to);
                    $array1["friend_status"] = $friend_status;
                    $chk1 = $this->db->query("SELECT * FROM friend_list WHERE (user_id_from='$user_id_from' && user_id_to='$user_id_to' && is_accept='1') ||(user_id_from='$user_id_to' && user_id_to='$user_id_from' && is_accept='1') ")->row();
                    $data = $this->V1_model->fetch_data('post', array("user_id" => $this->input->post('someone_profile_id'), "is_delete" => 0), '5', $this->input->post('page'));
                    //
                    //$data=$this->V1_model->fetch_data_in('post','user_id',$fr_array,'5',$this->input->post('page'));
                    //$data=$this->db->query("SELECT * FROM post WHERE user_id IN($friends_ids) ORDER BY id DESC")->result();
                    if (!empty($chk1) || $user_id_from == $user_id_to || $user_id_to == "1") {
                        if (!empty($data)) {
                            foreach ($data as $da) {
                                $val["post_id"] = $da->id;
                                $val["user_id"] = $da->user_id;
                                $val["user_data"] = $this->V1_model->get_single_row('users', array("id" => $da->user_id));
                                $val["post_type"] = $da->post_type;
                                $val["post_text"] = $da->post_text;
                                $val["address"] = $da->address;
                                $val["latitude"] = $da->latitude;
                                $val["longitude"] = $da->longitude;
                                $val["created_on"] = $da->created_on;
                                $val["time_ago"] = $this->time_elapsed_string($da->created_on);
                                if (!empty($da->whos_with)) {
                                    $whos_with_id = explode(",", $da->whos_with);
                                    unset($vaal);
                                    foreach ($whos_with_id as $ww) {

                                        $vaal[] = $this->V1_model->get_single_row('users', array("id" => $ww))->username;
                                    }
                                } else {
                                    $vaal = array();
                                    $whos_with_id = array();
                                }
                                $val["whos_with"] = $vaal;

                                $val["whos_with_id"] = $whos_with_id;
                                if (!empty($da->image)) {
                                    $img = explode(",", $da->image);
                                } else {
                                    $img = array();
                                }
                                $val["image"] = $img;
                                $val["link"] = $da->link;
                                $val["title"] = $da->title;
                                $comment = $this->V1_model->get_tbl_data_inorder('comment', array("post_id" => $da->id, "is_delete" => 0));
                                if (!empty($comment)) {
                                    foreach ($comment as $ct) {
                                        $cval["id"] = $ct->id;
                                        $cval["user_id"] = $ct->user_id;
                                        $commenter_data = $this->V1_model->get_single_row('users', array("id" => $ct->user_id));
                                        $cval["commenter_full_name"] = $commenter_data->frist_name . " " . $commenter_data->last_name;
                                        $cval["commenter_username"] = $commenter_data->username;
                                        $cval["commenter_profile"] = $commenter_data->profile;
                                        $cval["post_id"] = $ct->post_id;
                                        $cval["comment"] = $ct->comment;
                                        $cval["created_on"] = $ct->created_on;
                                        $cval1[] = $cval;
                                    }
                                    $val["comment_data"] = $cval1;
                                    unset($cval1);
                                } else {
                                    $val["comment_data"] = array();
                                }

                                $val["total_comment"] = count($comment);
                                $response = $this->V1_model->get_tbl_data_inorder('response', array("post_id" => $da->id));
                                //$val["response_data"]=$response;

                                $emoji_data = $this->V1_model->get_tbl_data('emoji', array());
                                if (!empty($emoji_data)) {
                                    foreach ($emoji_data as $ed) {
                                        $eval["id"] = $ed->id;
                                        $eval["name"] = $ed->name;
                                        $eval["emoji"] = $ed->emoji;
                                        $total_emoji = $this->V1_model->get_tbl_data_inorder('response', array("post_id" => $da->id, "emoji_id" => $ed->id));
                                        if (!empty($total_emoji)) {
                                            foreach ($total_emoji as $te) {
                                                $tval["id"] = $te->id;
                                                $tval["post_id"] = $te->post_id;
                                                $tval["user_id"] = $te->user_id;
                                                $responser_data = $this->V1_model->get_single_row('users', array("id" => $te->user_id));
                                                $tval["responser_full_name"] = $responser_data->frist_name . " " . $responser_data->last_name;
                                                $tval["responser_username"] = $responser_data->username;
                                                $tval["responser_profile"] = $responser_data->profile;
                                                $tval["emoji_id"] = $te->emoji_id;
                                                $tval["emoji_image"] = $this->V1_model->get_single_row('emoji', array("id" => $te->emoji_id));
                                                ;
                                                $tval["created_on"] = $te->created_on;
                                                $tval["updated_on"] = $te->updated_on;
                                                $tval1[] = $tval;
                                            }
                                            $eval["responser_data"] = $tval1;
                                            unset($tval1);
                                        } else {
                                            $eval["responser_data"] = array();
                                        }
                                        $eval["total_emoji"] = count($total_emoji);
                                        $eval1[] = $eval;
                                    }
                                    $val["total_response"] = $eval1;
                                    unset($eval1);
                                } else {
                                    $val["total_response"] = array();
                                }

                                $my_response = $this->V1_model->get_single_row('response', array("post_id" => $da->id, "user_id" => $this->input->post('user_id')));
                                if (!empty($my_response)) {
                                    $val["my_response"] = $my_response->emoji_id;
                                } else {
                                    $val["my_response"] = 0;
                                }


                                $val1[] = $val;
                            }
                            $array1['status'] = true;
                            $array1['data'] = $val1;
                        } else {
                            $array1['status'] = true;
                            $array1['message'] = "No Post Found";
                        }
                    } else {
                        $array1['status'] = true;
                    }
                    //
                } else {
                    $array1['status'] = false;
                    $array1['message'] = "invalid someone_profile_id";
                }
            } else {
                $array1['status'] = false;
                $array1['message'] = "invalid user id";
            }
        } else {
            $message = strip_tags(validation_errors());
            $array1['status'] = false;
            $array1['message'] = $message;
        }
        echo json_encode($array1);
    }

    public function total_data() {
        $this->form_validation->set_rules('user_id', 'user_id', 'required');
        if ($this->form_validation->run() == TRUE) {
            $chk_user = $this->V1_model->get_single_row('users', array("id" => $this->input->post('user_id')));
            if (!empty($chk_user)) {
                //
                /* $friend_id_to s */
                $friend_id_to = $this->V1_model->get_tbl_data('friend_list', array("user_id_from" => $this->input->post('user_id'), "is_accept" => 1));
                if (!empty($friend_id_to)) {
                    foreach ($friend_id_to as $f_to) {
                        $f_to_arr[] = $f_to->user_id_to;
                    }

                    $f_to_str = implode(",", $f_to_arr);

                    /* $friend_id_from s */
                    $friend_id_from = $this->V1_model->get_tbl_data('friend_list', array("user_id_to" => $this->input->post('user_id'), "is_accept" => 1));
                    if (!empty($friend_id_from)) {
                        foreach ($friend_id_from as $f_from) {
                            $f_from_arr[] = $f_from->user_id_from;
                        }
                        $f_from_str = implode(",", $f_from_arr);

                        $friends_id = $f_to_str . "," . $f_from_str;
                    } else {
                        $friends_id = $f_to_str;
                    }
                } else {
                    /* $friend_id_from s */
                    $friend_id_from = $this->V1_model->get_tbl_data('friend_list', array("user_id_to" => $this->input->post('user_id'), "is_accept" => 1));
                    if (!empty($friend_id_from)) {
                        foreach ($friend_id_from as $f_from) {
                            $f_from_arr[] = $f_from->user_id_from;
                        }
                        $f_from_str = implode(",", $f_from_arr);

                        $friends_id = $f_from_str;
                    } else {
                        $friends_id = "";
                    }
                }

                $array1["status"] = true;
                if (!empty($friends_id)) {
                    $data = $this->db->query("SELECT * FROM users WHERE id IN($friends_id)")->result();
                    $array1["total_friend"] = count($data);
                } else {
                    $array1["total_friend"] = 0;
                }
                $request_id_from = $this->V1_model->get_tbl_data('friend_list', array("user_id_to" => $this->input->post('user_id'), "is_accept" => 0));
                $array1["total_request"] = count($request_id_from);
                //
            } else {
                $array1['status'] = false;
                $array1['message'] = "invalid user id";
            }
        } else {
            $message = strip_tags(validation_errors());
            $array1['status'] = false;
            $array1['message'] = $message;
        }
        echo json_encode($array1);
    }

    /*        Chat start     */

    public function upload_msg_image() {
        if (!empty($_FILES['msg']['name'])) {
            $_FILES['msg']['name'];
            $_FILES['file']['name'] = $_FILES['msg']['name'];
            $_FILES['file']['tmp_name'] = $_FILES['msg']['tmp_name'];
            $_FILES['file']['size'] = $_FILES['msg']['size'];
            $config['upload_path'] = 'uploads/chat/';
            $config['allowed_types'] = '*';
            $config['file_name'] = $_FILES['file']['name'];


            $photo = explode('.', $_FILES['msg']['name']);
            $ext = strtolower($photo[count($photo) - 1]);
            if (!empty($_FILES['msg']['name'])) {

                $curr_time = time();
                $filename = "msg_" . time() . "." . $ext;
            }
            $config['file_name'] = $filename;

            //Load upload library and initialize configuration
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {
                $uploadData = $this->upload->data();
                $deal1image = "uploads/chat/" . $uploadData['file_name'];

                // 		 if(!empty($this->input->post('old_image')))
                // 		 {
                // 		     unlink($this->input->post('old_image'));
                // 		 }
            } else {
                $deal1image = "";
            }
        } else {
            $deal1image = "";
        }
        return $deal1image;
    }

    public function chat() {

        if ($this->input->post('sender_id') && $this->input->post('receiver_id') && ($this->input->post('msg') || !empty($_FILES['msg']['name'])) && $this->input->post('type')) {
            $sender = $this->input->post('sender_id');
            $receiver = $this->input->post('receiver_id');

            $chk = $this->db->query("select * from friend_list where (user_id_from = " . $sender . " AND user_id_to =" . $receiver . "
		    AND is_accept=1 AND is_block_by_from=0 AND is_block_by_to=0) || (user_id_from = " . $receiver . " AND user_id_to =" . $sender . " AND is_accept=1 AND is_block_by_from=0 AND is_block_by_to=0 )")->row();
            if (!empty($chk)) {
                $chat_id = $chk->id;
                if ($this->input->post('type') == "image" || $this->input->post('type') == "audio" || $this->input->post('type') == "video") {
                    $msg = $this->upload_msg_image();
                    $body = "Image";
                } else {
                    $msg = $this->input->post('msg');
                    $body = $this->input->post('msg');
                }
                $chatData = array('friend_id' => $chat_id, 'sender_id' => $sender, 'receiver_id' => $receiver, 'msg' => $msg, 'type' => $this->input->post('type'), 'created_on' => date('Y-m-d H:i:s'));
                $insert = $this->V1_model->insert('chat', $chatData);
                $chat_data = $this->V1_model->get_tbl_data('chat', array("id" => $insert));
                ///
                $this->chat_notification($receiver, $sender, $insert, "Message", $body);
                ////

                if ($insert) {

                    $array1["status"] = true;
                    $array1["message"] = "Message Send";
                    $array1["data"] = $chat_data;
                } else {
                    $array1["status"] = false;
                    $array1["message"] = "Not updated some issue occured";
                }
            } else {

                /*   $dta = array('sender_id'=>$sender,'receiver_id'=>$receiver,'created_on'=>date('Y-m-d H:i:s'));
                  $ins = $this->V1_model->insert('chat_id',$dta);
                  $chatData = array('chat_id'=>$ins,'sender_id'=>$sender,'receiver_id'=>$receiver,'msg'=>$msg,'created_on'=>date('Y-m-d H:i:s'));
                  $insert = $this->V1_model->insert('chat',$chatData);
                  //$this->chat_notification($sender,$receiver,$msg,$chatData,"sendmsg") ;
                  if($insert){
                  $array1["status"] = true;
                  $array1["message"] = "Message send";
                  $array1["data"] = $chatData;

                  }else{
                  $array1["status"] = false;
                  $array1["Mmssage"] = "Not updated some issue occured";
                  } */

                $chk2 = $this->db->query("select * from friend_list where (user_id_from = " . $sender . " AND user_id_to =" . $receiver . ") || (user_id_from = " . $receiver . " AND user_id_to =" . $sender . " )")->row();
                if (!empty($chk2)) {
                    if ($chk2->user_id_from == $sender) {
                        if ($chk2->is_accept == 1) {
                            if ($chk2->is_block_by_from == 1) {
                                $mssg = "You Block This User ";
                            } else {
                                $mssg = "User Block You ";
                            }
                        } elseif ($chk2->is_accept == 0) {
                            $mssg = "User Not Accept Your friend Request ";
                        } else {
                            $mssg = "No Friend";
                        }
                    } else {
                        if ($chk2->is_accept == 1) {
                            if ($chk2->is_block_by_to == 1) {
                                $mssg = "You Block This User ";
                            } else {
                                $mssg = "User Block You ";
                            }
                        } elseif ($chk2->is_accept == 0) {
                            $mssg = " Your Not  Accept User friend Request ";
                        } else {
                            $mssg = "No Friend";
                        }
                    }
                } else {
                    $mssg = "No Friend";
                }
                $array1["status"] = false;
                $array1["message"] = $mssg;
            }
        } else {

            $array1["status"] = false;
            $array1["message"] = "please fill all field";
            //$array1["data"] = array() ; 
        }
        echo json_encode($array1);
    }

    public function showchat() {
        if ($this->input->post('sender_id') && $this->input->post('receiver_id')) {
            $sender = $this->input->post('sender_id');
            $receiver = $this->input->post('receiver_id');

            $chk = $this->db->query("select * from friend_list where (user_id_from = " . $sender . " AND user_id_to =" . $receiver . ") || (user_id_from = " . $receiver . " AND user_id_to =" . $sender . " )")->row();
            if (!empty($chk)) {
                $chat_id = $chk->id;
                //$chatData = $this->V1_model->get_tbl_data('chat',array('friend_id'=>$chat_id));
                $chatData = $this->V1_model->fetch_data_order('chat', array("friend_id" => $chat_id), '10', $this->input->post('page'));

                if ($chatData) {
                    $array1["status"] = true;
                    $array1["message"] = "All chat data";
                    $array1["data"] = array_reverse($chatData);
                } else {
                    $array1["status"] = false;
                    $array1["message"] = "No Chat found";
                }
            } else {
                $array1["status"] = false;
                $array1["message"] = "No Chat found";
            }
        } else {

            $array1["status"] = false;
            $array1["message"] = "please fill all field";
        }
        echo json_encode($array1);
    }

    /*        Chat End     */

    public function about_us() {
        $about_us = $this->V1_model->get_single_row('about_us', array("id" => 1));
        if (!empty($about_us)) {
            $array1["status"] = true;
            $array1["data"] = $about_us;
        } else {
            $array1["status"] = false;
            $array1["message"] = "No Data Found";
        }
        echo json_encode($array1);
    }

    public function privacy() {
        $privacy = $this->V1_model->get_single_row('privacy', array("id" => 1));
        if (!empty($privacy)) {
            $array1["status"] = true;
            $array1["data"] = $privacy;
        } else {
            $array1["status"] = false;
            $array1["message"] = "No Data Found";
        }
        echo json_encode($array1);
    }

    public function term() {
        $terms = $this->V1_model->get_single_row('terms', array("id" => 1));
        if (!empty($terms)) {
            $array1["status"] = true;
            $array1["data"] = $terms;
        } else {
            $array1["status"] = false;
            $array1["message"] = "No Data Found";
        }
        echo json_encode($array1);
    }

    public function contact_us() {
        $contact_us = $this->V1_model->get_single_row('contact_us', array("id" => 1));
        if (!empty($contact_us)) {
            $array1["status"] = true;
            $array1["data"] = $contact_us;
        } else {
            $array1["status"] = false;
            $array1["message"] = "No Data Found";
        }
        echo json_encode($array1);
    }

    public function emoji_list() {
        $Emoji = $this->V1_model->get_tbl_data('emoji', array());
        if (!empty($Emoji)) {
            $array1["status"] = true;
            $array1["data"] = $Emoji;
        } else {
            $array1["status"] = false;
            $array1["message"] = "No Data Found";
        }
        echo json_encode($array1);
    }

    public function change_password() {
        $this->form_validation->set_rules('user_id', 'user_id', 'required');
        $this->form_validation->set_rules('old_password', 'old_password', 'required');
        $this->form_validation->set_rules('new_password', 'new_password', 'required');
        if ($this->form_validation->run() == TRUE) {

            $user_chk = $this->V1_model->get_single_row('users', array("id" => $this->input->post('user_id')));
            if (!empty($user_chk)) {

                if ($user_chk->password == sha1($this->input->post('old_password'))) {
                    $update = $this->V1_model->update_where('users', array("id" => $user_chk->id), array("password" => sha1($this->input->post('new_password'))));
                    if ($update) {
                        $array1["status"] = true;
                        $array1["message"] = "Password Change Successfully";
                    } else {
                        $array1["status"] = false;
                        $array1["message"] = "Issue Occurred";
                    }
                } else {
                    $array1["status"] = false;
                    $array1["message"] = "Old Password Not Match";
                }https://img-resize.com/view/598b899016c05240032a5c8c7b8f9a7f.jpg
            } else {
                $array1["status"] = false;
                $array1["message"] = "Invalid user id";
            }
        } else {
            $message = strip_tags(validation_errors());
            $array1['status'] = false;
            $array1['message'] = $message;
        }
        echo json_encode($array1);
    }

    public function report_post() {
        $this->form_validation->set_rules('user_id', 'user_id', 'required');
        $this->form_validation->set_rules('post_id', 'post_id', 'required');
        if ($this->form_validation->run() == TRUE) {
            $user_chk = $this->V1_model->get_single_row('users', array("id" => $this->input->post('user_id')));
            if (!empty($user_chk)) {
                $post_chk = $this->V1_model->get_single_row('post', array("id" => $this->input->post('post_id')));
                if (!empty($post_chk)) {
                    $array = array("user_id" => $this->input->post('user_id'), "reason" => $this->input->post('reason') ?: '', "post_id" => $this->input->post('post_id'), "created_on" => date("Y-m-d H:i:s"));
                    $insert_id = $this->V1_model->insert('report_post', $array);
                    if ($insert_id) {
                        $array1["status"] = true;
                        $array1["message"] = "Your Report Submitted";
                    } else {
                        $array1["status"] = false;
                        $array1["message"] = "Issue Occurred";
                    }
                } else {
                    $array1["status"] = false;
                    $array1["message"] = "Invalid post id";
                }
            } else {
                $array1["status"] = false;
                $array1["message"] = "Invalid user id";
            }
        } else {
            $message = strip_tags(validation_errors());
            $array1['status'] = false;
            $array1['message'] = $message;
        }
        echo json_encode($array1);
    }

    public function report_comment() {
        $this->form_validation->set_rules('user_id', 'user_id', 'required');
        $this->form_validation->set_rules('comment_id', 'comment_id', 'required');
        if ($this->form_validation->run() == TRUE) {
            $user_chk = $this->V1_model->get_single_row('users', array("id" => $this->input->post('user_id')));
            if (!empty($user_chk)) {
                $comment_chk = $this->V1_model->get_single_row('comment', array("id" => $this->input->post('comment_id')));
                if (!empty($comment_chk)) {
                    $array = array("user_id" => $this->input->post('user_id'), "comment_id" => $this->input->post('comment_id'), "created_on" => date("Y-m-d H:i:s"));
                    $insert_id = $this->V1_model->insert('report_comment', $array);
                    if ($insert_id) {
                        $array1["status"] = true;
                        $array1["message"] = "Your Report Submitted";
                    } else {
                        $array1["status"] = false;
                        $array1["message"] = "Issue Occurred";
                    }
                } else {
                    $array1["status"] = false;
                    $array1["message"] = "Invalid post id";
                }
            } else {
                $array1["status"] = false;
                $array1["message"] = "Invalid user id";
            }
        } else {
            $message = strip_tags(validation_errors());
            $array1['status'] = false;
            $array1['message'] = $message;
        }
        echo json_encode($array1);
    }

    /* edit comment s */

    public function edit_comment() {
        $this->form_validation->set_rules('comment_id', 'comment_id', 'required');
        $this->form_validation->set_rules('user_id', 'user_id', 'required');
        $this->form_validation->set_rules('comment', 'comment', 'required');
        if ($this->form_validation->run() == TRUE) {
            $comment_chk = $this->V1_model->get_single_row('comment', array("id" => $this->input->post('comment_id'), "user_id" => $this->input->post('user_id')));
            if (!empty($comment_chk)) {
                $update = $this->V1_model->update_where('comment', array('id' => $comment_chk->id), array('comment' => $this->input->post('comment')));
                if ($update) {
                    $data = $this->V1_model->get_single_row('comment', array("id" => $comment_chk->id));
                    $array1["status"] = true;
                    $array1["message"] = "Comment Update Successfully";
                    $array1["data"] = $data;
                } else {
                    $array1["status"] = false;
                    $array1["message"] = "Issue occurred";
                }
            } else {
                $array1["status"] = false;
                $array1["message"] = "No comment found";
            }
        } else {
            $message = strip_tags(validation_errors());
            $array1['status'] = false;
            $array1['message'] = $message;
        }
        echo json_encode($array1);
    }

    /* edit comment e */


    /* delete comment s */

    public function delete_comment() {
        $this->form_validation->set_rules('comment_id', 'comment_id', 'required');
        $this->form_validation->set_rules('user_id', 'user_id', 'required');
        if ($this->form_validation->run() == TRUE) {
            $comment_chk = $this->V1_model->get_single_row('comment', array("id" => $this->input->post('comment_id'), "user_id" => $this->input->post('user_id')));
            if (!empty($comment_chk)) {
                $update = $this->V1_model->update_where('comment', array('id' => $comment_chk->id), array('is_delete' => 1));
                if ($update) {
                    $update_notification = $this->V1_model->update_where('notification', array('action' => 'comment', 'response_id' => $comment_chk->id), array('is_delete' => 1));
                    //$data=$this->V1_model->get_single_row('comment',array("id"=>$comment_chk->id));
                    $array1["status"] = true;
                    $array1["message"] = "Comment Delete Successfully";
                    //$array1["data"]=$data;
                } else {
                    $array1["status"] = false;
                    $array1["message"] = "Issue occurred";
                }
            } else {
                $array1["status"] = false;
                $array1["message"] = "No comment found";
            }
        } else {
            $message = strip_tags(validation_errors());
            $array1['status'] = false;
            $array1['message'] = $message;
        }
        echo json_encode($array1);
    }

    /* delete comment e */


    /* edit comment s */

    public function delete_post() {
        $this->form_validation->set_rules('post_id', 'post_id', 'required');
        $this->form_validation->set_rules('user_id', 'user_id', 'required');
        if ($this->form_validation->run() == TRUE) {
            $post_chk = $this->V1_model->get_single_row('post', array("id" => $this->input->post('post_id'), "user_id" => $this->input->post('user_id')));
            if (!empty($post_chk)) {
                $update = $this->V1_model->update_where('post', array('id' => $post_chk->id), array('is_delete' => 1));
                if ($update) {
                    $update_notification = $this->V1_model->update_where('notification', array('post_id' => $post_chk->id), array('is_delete' => 1));
                    // $data=$this->V1_model->get_single_row('post',array("id"=>$post_chk->id));
                    $array1["status"] = true;
                    $array1["message"] = "Post Delete Successfully";
                    // $array1["data"]=$data;
                } else {
                    $array1["status"] = false;
                    $array1["message"] = "Issue occurred";
                }
            } else {
                $array1["status"] = false;
                $array1["message"] = "No Post found";
            }
        } else {
            $message = strip_tags(validation_errors());
            $array1['status'] = false;
            $array1['message'] = $message;
        }
        echo json_encode($array1);
    }

    /* edit comment e */

//
    public function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'min',
            's' => 'sec',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                //
                if ($v == "min" || $v == "sec") {
                    $s = ".";
                } else {
                    $s = "s";
                }
                //
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? $s : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full)
            $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

//
}
