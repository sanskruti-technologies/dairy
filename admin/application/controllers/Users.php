<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('user');


	}

	public function index()	{ 
		$isLoggedIn = $this->session->isLoggedIn;
		if (! isset ( $isLoggedIn ) || $isLoggedIn != TRUE) {
			redirect ( 'login' );
		} 
		$data['users'] = $this->user->get_user_details($this->session->username);
		$this->load->view('parts/header');
		$this->load->view('users/editProfile',$data);
		$this->load->view('parts/footer');
	}

	public function checkEmailExists($email)
	{
		//$oldId = $this->input->post("oldId");
        $oldId = $this->session->user_id;
        /*if(empty($oldId)){
            $result = $this->user->checkEmailExists($email);
        } else {*/
            $result = $this->user->checkEmailExists($email,$oldId);
        //}
        if(empty($result)){  return true; }
        else {  return false; }



		
	}

	/**
     * This function is used to add new brand to the system
     */
    function editProfileSave()
    {
            $this->load->library('form_validation');
			$oldId = $this->session->user_id;
            $this->form_validation->set_rules('firstName','First Name','trim|required');
			$this->form_validation->set_rules('email','email','trim|required|callback_checkEmailExists');
			if($this->form_validation->run() == FALSE)
            {
				$this->session->set_flashdata('error', 'First name / email field is blank');
                $this->index();
            }
            else
            {

                $firstName = trim($this->security->xss_clean($this->input->post('firstName')));
                $middleName = trim($this->security->xss_clean($this->input->post('middleName')));
				$lastName = trim($this->security->xss_clean($this->input->post('lastName')));
				$email = trim($this->security->xss_clean($this->input->post('email')));
				$password = trim($this->security->xss_clean($this->input->post('password')));
				$addressType = trim($this->security->xss_clean($this->input->post('addressType')));
				$address1 = trim($this->security->xss_clean($this->input->post('address1')));
				$address2 = trim($this->security->xss_clean($this->input->post('address2')));
				$city = trim($this->security->xss_clean($this->input->post('city')));
				$country = trim($this->security->xss_clean($this->input->post('country')));

					    if($oldId>0)
						{
							$Info = array('first_name'=> $firstName,'middle_name'=> $middleName,'last_name'=> $lastName,
										  'email'=> $email,'address_type'=> $addressType,'address_line1'=> $address1,
			  							  'address_line2'=> $address2,'city'=> $city,'country'=> $country,			
										  'modified_date'=>date('Y-m-d H:i:s'));
									
							$result = $this->user->editData($Info,$oldId);
							$page_id=$oldId;

						}

						
						if($result > 0)
						{	

								$this->session->set_flashdata('success', 'User updated successfully');
						}
						else
						{
							$this->session->set_flashdata('error', 'User Updation failed');
						}
					
				redirect('editProfile');
            }
        
    }
}
