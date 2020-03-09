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

	public function is_username_exist($name){
		$this->db->where('username' ,$name);
		$query = $this->db->get('users');
		$result = $query->row();
		return $result;
	}

	public function checkEmailExists($email,$userId){
		$this->db->where('email' ,$email);
		if($userId != 0){
            $this->db->where("user_id !=", $userId);
        }
		$query = $this->db->get('users');
		
		$result = $query->row();
		return $result;
	}



	public function get_user_details($name){
		$this->db->where('username' ,$name);
		$query = $this->db->get('users');
		$result = $query->row();
		return $result;
	}

	 /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $member_id : This is user id
     */
    function editData($Info, $id)
    {
        $this->db->where('user_id', $id);
        $this->db->update('users', $Info);
        
        return TRUE;
    }

}
?>
