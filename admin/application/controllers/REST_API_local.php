<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class REST_API_local extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->library('FrappeClient');

		$this->load->model('item');
		$this->load->model('customer');
		$this->load->model('cart');
	}
	public function item_groups()	{
		$result_array = $this->item->get_item_groups();
		return json_encode($result_array);
	}
	public function items($search)	{
		$result_array = $this->item->get_items($search);
		return json_encode($result_array);
	}
	public function customers($search)	{
		$result_array = $this->customer->get_customers($search);
		return json_encode($result_array);
	}
	public function field_order($field_order_name)	{
		$erpnext = new FrappeClient();
		$result = $erpnext->get("Field Order",$field_order_name);
		$field_orders = $result->body->data;
		return json_encode($field_orders);
	}
	public function order_book($order_book_name){
		$username =  $_POST['username'];
		$password =  $_POST['password'];

		$erpnext = new FrappeClient();
		$result = $erpnext->get("Order Book",$order_book_name);
		$order_book = $result->body->data;
		return json_encode($order_book);
	}
	public function get_all_order_books(){
		$username =  $_POST['username'];
		$password =  $_POST['password'];

		$erpnext = new FrappeClient();

		$result = $erpnext->search("Order Book",array(),array("name","docstatus"));
		$order_book = $result->body->data;
		return json_encode($order_book);
	}
	public function get(){
		$search = NULL;
		$name = NULL;

		 $doctype=$_GET['doctype'];
		 if(isset($_GET['search'])){
			 $search=json_decode($_GET['search']);
		 }
		 if(isset($_GET['name'])){
			 $name=$_GET['name'];
		 }

		 switch ($doctype) {
		    case 'Item Group':
		        echo $this->item_groups();
		        break;
				case 'Item':
		        echo $this->items($search);
		        break;
				case 'Customer':
		        echo $this->customers($search);
		        break;
				case 'Cart':
					echo $this->cart();
					break;
				case 'Field Order':
					echo $this->field_order($name);
					break;
				case 'Order Book':
					echo $this->order_book($name);
					break;
				case 'Orders':
					//Fetch all Orders submitted by the user
					if($this->check_auth()){
						$username = $_POST['username'];
						echo json_encode($this->cart->get_orders($username));
					}else{
						echo "User Login Failed";
					}
					break;
	    }
	}

	public function add(){
		$doctype=$_GET['doctype'];
		$cart_array = $_POST;
		switch ($doctype) {
			 case 'Cart':
					 echo $this->add_to_cart($cart_array);
					 break;
		 }
	}

	public function update(){
		$doctype=$_GET['doctype'];
		$cart_id = NULL;
		if(isset($_GET['cart_id'])){
			$cart_id = $_GET['cart_id'];
		}

		$cart_array = $_POST;
		switch ($doctype) {
			 case 'Cart':
			 echo $this->update_cart($cart_array);
			 break;
			 case 'Cancel Cart':
			 echo $this->cancel_order($cart_id);
			 break;
		 }
	}
	public function cart(){
		$username =  $_POST['username'];
		$cart_id = $this->cart->get_open_cart($username);
		$cart = $this->cart->get_cart($cart_id);
		$cart_detail =  $this->cart->get_cart_detail($cart_id);
		$cart->items = $cart_detail;
		return $cart;
	}
	public function add_to_cart($cart_array){
		$username =  $cart_array['username'];
		$password =  $cart_array['password'];
		//Login using the username and password
		$erpnext = new FrappeClient($username,$password);
		//Create Cart if not already exists
		$cart_id = $this->cart->get_open_cart($username);
		if($cart_id == 0){
			$data = array();
			$data['customer'] = $cart_array['customer'];
			$data['order_period'] = $cart_array['order_period'];
			$data['order_date'] = $cart_array['order_date'];
			$data['order_time'] = $cart_array['order_time'];
			$data['order_status'] = $cart_array['order_status'];
			$data['cart_user'] = $username;
			$cart_id = $this->cart->insert_cart($data);
		}
		$cart_items = $cart_array['cart_items'];
		foreach($cart_items as $cart_item){
			$data = array();
			$data['cart_id'] = $cart_id;
			$data['item_code'] = $cart_item['item_code'];
			$data['qty'] = $cart_item['qty'];
			$data['rate'] = $cart_item['rate'];
			$data['amount'] = $cart_item['rate']*$cart_item['qty'];
			$data['gst_rate'] = $cart_item['gst_rate'];
			//Get GST Rate
			$gst_rate = $this->item->get_gst_rate($data['gst_rate']);
			$data['gst_amount'] = $data['amount']*$gst_rate/100;
			$data['grand_amount'] = $data['gst_amount']+$data['amount'];

			$cart_detail_id = $this->cart->insert_cart_item($data);
		}
		$cart = $this->cart();
		echo json_encode($cart);
	}
	function update_cart($cart_array){
		$username =  $cart_array['username'];
		$password =  $cart_array['password'];
		//Login using the username and password
		$erpnext = new FrappeClient($username,$password);

		$cart_id = $this->cart->get_open_cart($username);
		if($cart_id == 0){
			$data = array();
			$data['customer'] = $cart_array['customer'];
			$data['order_period'] = $cart_array['order_period'];
			$data['order_date'] = $cart_array['order_date'];
			$data['order_time'] = $cart_array['order_time'];
			$data['order_status'] = $cart_array['order_status'];
			$data['cart_user'] = $username;
			$cart_id = $this->cart->insert_cart($data);
		}else{
			$data = array();
			$data['customer'] = $cart_array['customer'];
			$data['order_period'] = $cart_array['order_period'];
			$data['order_date'] = $cart_array['order_date'];
			$data['order_time'] = $cart_array['order_time'];
			$data['order_status'] = $cart_array['order_status'];
			$data['cart_user'] = $username;
			$this->cart->update_cart($cart_id,$data);
		}
		$this->cart->clear_cart($cart_id);
		$cart_items = $cart_array['cart_items'];
		foreach($cart_items as $cart_item){
			$data = array();
			$data['cart_id'] = $cart_id;
			$data['item_code'] = $cart_item['item_code'];
			$data['qty'] = $cart_item['qty'];
			$data['rate'] = $cart_item['rate'];
			$data['amount'] = $cart_item['rate']*$cart_item['qty'];
			$data['gst_rate'] = $cart_item['gst_rate'];
			//Get GST Rate
			$gst_rate = $this->item->get_gst_rate($data['gst_rate']);
			$data['gst_amount'] = $data['amount']*$gst_rate/100;
			$data['grand_amount'] = $data['gst_amount']+$data['amount'];

			$cart_detail_id = $this->cart->insert_cart_item($data);
			$cart = $this->cart();
			echo json_encode($cart);
		}

	}
	public function cancel_order($cart_id){
		 $this->cart->cancel_order($cart_id);
		 return json_encode(array('status'=>'success'));
	}
	public function create_field_order($cart,$username,$password){
		$erpnext = new FrappeClient();
		$data = array();
		$data['customer'] = $cart->customer;
		$data['order_period'] = $cart->order_period;
		$data['date'] = $cart->order_date;
		$data['time'] = $cart->order_time;
		$data['submit_on_creation'] = 1;
		$data['docstatus'] = 1;
		$cart_items = $cart->items;

		$order_book_data = array();
		$order_book_data['field_orders'] = array();
		$field_orders = array();
		foreach ($cart_items as $cart_item) {
			$data['item_code'] =  $cart_item->item_code;
			$data['qty'] =  $cart_item->qty;
			$data['rate'] =  $cart_item->rate;
			$data['amount'] =  $cart_item->amount;
			$data['gst_rate'] =  $cart_item->gst_rate;
			$data['grand_total'] =  $cart_item->grand_amount;
			$result = $erpnext->insert("Field Order",$data);
			$field_order_name = $result->body->data->name;
			$field_orders[] = $field_order_name;
			array_push($order_book_data['field_orders'],array('customer'=>$cart->customer,
																											 'field_order'=>$field_order_name,
																											 'item_code'=>$cart_item->item_code,
																											 'qty'=>$cart_item->qty,
																											 'rate'=>$cart_item->rate,
																											 'amount'=>$cart_item->amount,
																											 'gst_rate'=>$cart_item->gst_rate,
																											 'grand_total'=>$cart_item->grand_amount
																						));
		}


		$order_book_data['from_date'] = $cart->order_date;
		//$order_book_data['submit_on_creation'] = 1;
		$order_book_data['docstatus'] = 1;
		//$result = $erpnext->insert("Order Book",$order_book_data);
		//$order_book_name = $result->body->data->name;*/
	  $order_book = array('field_orders' => $field_orders);
		echo json_encode($order_book);
	}
	public function check_auth(){
		if(isset($_POST['username']) && isset($_POST['password'])){
			$username = $_POST['username'];
			$password = $_POST['password'];
			try{
				$erpnext = new FrappeClient($username,$password);
				return TRUE;
			} catch (Exception $e) {
				return FALSE;
			}
		}else{
			return FALSE;
		}

		try{
			$erpnext = new FrappeClient($username,$password);
			echo $erpnext->body->full_name;
		} catch (Exception $e) {
		    echo "Auth fail";
		}

	}
	public function auth(){
		$data_array = $_POST;

		$username = $data_array['username'];
		$password = $data_array['password'];
		try{
			$erpnext = new FrappeClient($username,$password);
			echo $erpnext->body->full_name;
		} catch (Exception $e) {
		    echo "Auth fail";
		}

	}
	public function checkout_cart(){
		$data_array = $_POST;
		$username =  $data_array['username'];
		$password =  $data_array['password'];

		$cart_id = $this->cart->get_open_cart($username);
		if($cart_id != 0){
			$cart = $this->cart->get_cart($cart_id);
			$cart_detail =  $this->cart->get_cart_detail($cart_id);
			$cart->items = $cart_detail;

			$this->create_field_order($cart,$username,$password);
			$this->cart->checkout_cart($cart_id);
		}else{
			echo "Cart is Empty";
		}

	}
}
