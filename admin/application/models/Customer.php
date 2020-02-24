<?php
class Customer extends CI_Model {
  public function __construct() {
      $this->load->database();
  }
  public function insert_customer($data){
		$this->db->insert('customers',$data);
	}
  public function get_customers($search = NULL){
    if(!empty($search)){
      foreach ($search as $srch) {
          $this->db->where($srch[1].$srch[2],$srch[3]);
      }
    }
    $query = $this->db->get('customers');
		$result = $query->result_array();
    return $result;
  }
}
?>
