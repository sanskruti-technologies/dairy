<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->helper('form');
		$this->load->helper('url');

		  $this->load->model('customer');
	}
	public function index()	{
		$data['customers'] = $this->customer->get_customers();
		$this->load->view('parts/header');
		$this->load->view('customers/browse',$data);
		$this->load->view('parts/footer');
	}
}
