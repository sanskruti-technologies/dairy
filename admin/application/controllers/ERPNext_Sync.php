<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ERPNext_Sync extends CI_Controller {
	function __construct() {
		parent::__construct();
    $this->load->library('FrappeClient');

    $this->load->model('item');
    $this->load->model('customer');
	}
	public function index()	{
    $erpnext = new FrappeClient();
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
		}*/
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
		}
	}
}
