<?php
class User extends CI_Model {
	public function __construct() {
		$this->load->database();
	}
	public function insert_user($data){
		$this->db->insert('users',$data);
		return $this->db->insert_id();
	}
	public function is_exist($name){
		$this->db->where('name' ,$name);
		$query = $this->db->get('users');
		$result = $query->row();
		if($query->num_rows() > 0){
			return TRUE;
		}else{
			return FALSE;
		}
	}
}
?>
