<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Items extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('session');

		$this->load->helper('form');
		$this->load->helper('url');

		$this->load->model('item');
	}
	public function index()	{
		$isLoggedIn = $this->session->isLoggedIn;
		if (! isset ( $isLoggedIn ) || $isLoggedIn != TRUE) {
			redirect ( 'login' );
		} 
		$data['items'] = $this->item->get_items();
		$this->load->view('parts/header');
		$this->load->view('items/browse',$data);
		$this->load->view('parts/footer');
	}
	public function item_groups(){
		$isLoggedIn = $this->session->isLoggedIn;
		if (! isset ( $isLoggedIn ) || $isLoggedIn != TRUE) {
			redirect ( 'login' );
		} 
		$data['item_groups'] = $this->item->get_item_groups();
		$this->load->view('parts/header');
		$this->load->view('items/browse_group',$data);
		$this->load->view('parts/footer');
	}

}
