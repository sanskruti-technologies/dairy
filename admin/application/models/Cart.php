<?php
class Cart extends CI_Model {
	public function __construct() {
		$this->load->database();
	}
	public function insert_cart($data){
		$this->db->insert('cart',$data);
		return $this->db->insert_id();
	}
	public function update_cart($cart_id,$data){
		$this->db->where('cart_id' ,$cart_id);
		$this->db->update('cart',$data);
	}
	public function clear_cart($cart_id){
		$this->db->delete('cart_detail', array('cart_id' => $cart_id));
	}
	public function insert_cart_item($data){
		//Check if Item already exists in cart
		$this->db->where('item_code' ,$data['item_code']);
		$query = $this->db->get('cart_detail');
		$result = $query->row();
		if($query->num_rows() > 0){
			$cart_detail_id = $result->cart_detail_id;
			$qty = $result->qty;
			$this->db->where('cart_detail_id', $cart_detail_id);
			$update_data['qty'] = $qty + $data['qty'];
			$this->db->update('cart_detail',$update_data);
		}else{
			$this->db->insert('cart_detail',$data);
			return $this->db->insert_id();
		}


	}
	public function get_orders($username){
		$this->db->where('cart_user' ,$username);
		$query = $this->db->get('cart');
		$carts = $query->result();

		foreach($carts as $cart ){
			$cart_id = $cart->cart_id;
			$cart_detail =  $this->get_cart_detail($cart_id);
			$cart->items = $cart_detail;
		}
		return $carts;
	}
	public function get_cart($cart_id){
		$this->db->where('cart_id' ,$cart_id);
		$query = $this->db->get('cart');
		$result = $query->row();
		return $result;
	}
	public function get_cart_detail($cart_id){
		$this->db->where('cart_id' ,$cart_id);
		$query = $this->db->get('cart_detail');
		$result = $query->result();
		return $result;
	}
	public function get_open_cart($username){
		$this->db->where('cart_user' ,$username);
		$this->db->where('is_cart_checkout' , 0);
		$query = $this->db->get('cart');

		if($query->num_rows() > 0){
			$result = $query->row();
			return $result->cart_id;
		}else{
			return 0;
		}

	}
	public function checkout_cart($cart_id){
		$data['is_cart_checkout'] = 1;
		$this->db->where('cart_id' ,$cart_id);
		$this->db->update('cart',$data);
	}

}
?>
