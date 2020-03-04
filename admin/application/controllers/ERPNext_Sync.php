<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ERPNext_Sync extends CI_Controller {
	function __construct() {
		parent::__construct();
    $this->load->library('FrappeClient');

    $this->load->model('item');
    $this->load->model('customer');
    $this->load->model('user');
	}
	public function sync_users(){
		$erpnext = new FrappeClient();
		//Users
		$is_first_sync = 1;
		$user_start_point = 0;

		if($is_first_sync == 1){
			$start_point = $user_start_point;
			$length = 10;

			$loop = TRUE;
			while($loop){
				$list_of_fields = array('name','username','email','first_name','middle_name','last_name');
				$result = $erpnext->search("User",array(),$list_of_fields,$start_point,$length);
				$erpnext_users = $result->body->data;
				if(!empty($erpnext_users)){
					foreach($erpnext_users as $erpnext_user){
						if(!$this->user->is_exist( $erpnext_user->name)){
							$data = array();
							$data['name'] = $erpnext_user->name;
							$data['username'] = $erpnext_user->username;
							$data['email'] = $erpnext_user->email;
							$data['first_name'] = $erpnext_user->first_name;
							$data['middle_name'] = $erpnext_user->middle_name;
							$data['last_name'] = $erpnext_user->last_name;

							$username = $erpnext_user->name;
							//Customers
							$list_of_fields = array('name','mobile_no','email_id','customer_primary_address','user');
							$result = $erpnext->search("Customer",array(array("Customer","user","=",$username)),$list_of_fields,$start_point,$length);
							if(isset($result->body->data)){
								$erpnext_customer = $result->body->data;
								if(!empty($erpnext_customer)){
									$data['email'] = $erpnext_customer[0]->email_id;
									$data['mobile_no'] = $erpnext_customer[0]->mobile_no;
									$data['doctype_name'] = $erpnext_customer[0]->name;
									$data['user_type'] = "Customer";

									$address_name = $erpnext_customer[0]->customer_primary_address;
									if($address_name != ""){
										$result = $erpnext->get("Address",$address_name);
										if(isset($result->body->data)){
											$erpnext_address = $result->body->data;
											if(!empty($erpnext_address)){
												$data['adress_name'] = $address_name;
												$data['address_type'] = $erpnext_address->address_type;
												$data['address_line1'] = $erpnext_address->address_line1;
												$data['address_line2'] = $erpnext_address->address_line2;
												$data['city'] = $erpnext_address->city;
												$data['country'] = $erpnext_address->country;
											}
										}
									}

									$this->user->insert_user($data);
								}

							}
							//Employees
							$list_of_fields = array('name','cell_number','prefered_email','permanent_address','user_id');
							$result = $erpnext->search("Employee",array(array("Employee","user_id","=",$username)),$list_of_fields,$start_point,$length);
							if(isset($result->body->data)){
								$erpnext_employee = $result->body->data;
								if(!empty($erpnext_employee)){

									$data['email'] = $erpnext_employee[0]->prefered_email;
									$data['mobile_no'] = $erpnext_employee[0]->cell_number;
									$data['doctype_name'] = $erpnext_employee[0]->name;
									$data['user_type'] = "Employee";
									$data['address'] = $erpnext_employee[0]->permanent_address;
									$this->user->insert_user($data);
								}
							}



						}
					}
				}else{
					$loop = FALSE;
				}
				$start_point = $start_point + $length;
			}
		}
	}
	public function sync_customer(){
		$erpnext = new FrappeClient();
		//Customers
		$start_point = 0;
    $length = 1000;

    $list_of_fields = array('customer_name','customer_type','customer_group','user','territory','link_with_distributor');
		$result = $erpnext->search("Customer",array(),$list_of_fields,$start_point,$length);
		$erpnext_customers = $result->body->data;
		foreach($erpnext_customers as $erpnext_customer){
      $data = array();
      $data['customer_name'] = $erpnext_customer->customer_name;
      $data['customer_type'] = $erpnext_customer->customer_type;
      $data['customer_group'] = $erpnext_customer->customer_group;
      $data['territory'] = $erpnext_customer->territory;
      $data['link_with_distributor'] = $erpnext_customer->link_with_distributor;
      $data['username'] = $erpnext_customer->user;
      $this->customer->insert_customer($data);
    }
	}
	public function index()	{
    /*$erpnext = new FrappeClient();
		/*
		//Items
		$is_first_sync = 1;
		$item_start_point = 0;

		if($is_first_sync == 1){
			$start_point = $item_start_point;
			$length = 39;

			$loop = TRUE;
			/*while($loop){*//*
		    $list_of_fields = array('item_name','name','item_group','image','standard_rate');
				$result = $erpnext->search("Item",array(),$list_of_fields,$start_point,$length);
				$erpnext_items = $result->body->data;
		    //if(!empty($erpnext_items)){
			    foreach($erpnext_items as $erpnext_item){
			      $data = array();
			      $data['item_name'] = $erpnext_item->item_name;
			      $data['item_group'] = $erpnext_item->item_group;
			      $data['image'] = $erpnext_item->image;
			      $data['standard_rate'] = $erpnext_item->standard_rate;
			      $data['name'] = $erpnext_item->name;
			      $this->item->insert_item($data);
			    }
				/*}else{
					$loop = FALSE;
				}
				$start_point = $start_point + $length;
			}*//*
		}
		*/
		/*

		*/
		/*
		//Item Groups
		$start_point = 0;
    $length = 50;

    $list_of_fields = array('item_group_name','name','parent_item_group');
		$result = $erpnext->search("Item Group",array(),$list_of_fields,$start_point,$length);
		$erpnext_customers = $result->body->data;
		foreach($erpnext_customers as $erpnext_customer){
      $data = array();
      $data['item_group_name'] = $erpnext_customer->item_group_name;
      $data['name'] = $erpnext_customer->name;
      $data['parent_item_group'] = $erpnext_customer->parent_item_group;
      $this->item->insert_item_group($data);
		}*//*
		//Item Tax template
		$start_point = 0;
    $length = 50;

		$list_of_fields = array('name','title');
		$result = $erpnext->search("Item Tax Template",array(),$list_of_fields,$start_point,$length);
		$erpnext_item_tax_templates = $result->body->data;
		foreach($erpnext_item_tax_templates as $erpnext_item_tax_template){
			$data = array();
			$data['item_tax_name'] = $erpnext_item_tax_template->name;
			$data['item_tax_title'] = $erpnext_item_tax_template->title;
			$item_tax_id = $this->item->insert_item_tax_template($data);

			$result = $erpnext->get("Item Tax Template",$erpnext_item_tax_template->name);
			$item_tax_template = $result->body->data;
			$taxes = $item_tax_template->taxes;

			foreach ($taxes as $tax) {
				$data = array();
				$data['item_tax_id'] = $item_tax_id;
				$data['item_tax'] = $tax->tax_type;
				$data['item_tax_rate'] = $tax->tax_rate;
				$item_tax_id = $this->item->insert_item_tax_template_detail($data);
			}
		}*/
	}
}
