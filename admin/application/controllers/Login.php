<?php

//defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library('session');
	}
	public function index()	{
		$this->load->view('login/login');
	}

	public function loginMe(){
		
		$this->load->model('user');
		$username= $this->security->xss_clean($this->input->post('userName'));
		$result=$this->user->is_username_exist($username);
		
		  if(!empty($result))
            
            {
                
                $sessionArray = array('user_id'=>$result->user_id,                    
                                        'username'=>$result->username,
                                        'user_type'=>$result->user_type,
                                      
										'name'=>$result->first_name." ".$result->last_name,
                                       
                                        'isLoggedIn' => TRUE
                                );

                $this->session->set_userdata($sessionArray);

                //unset($sessionArray['userId'], $sessionArray['isLoggedIn'], $sessionArray['lastLogin']);

				 
			   redirect('itemListing');

				
				
            }
            else
            {
                $this->session->set_flashdata('error', 'Username mismatch');
                
                redirect('/login');
            }
			
	}


	public function Logout()	{
		$this->session->sess_destroy();
		$this->load->view('login/login');
		
	}


}
