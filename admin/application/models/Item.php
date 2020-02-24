<?php
class item extends CI_Model {
  public function __construct() {
      $this->load->database();
  }
  public function insert_item($data){
		$this->db->insert('items',$data);
	}
  public function get_items($search = NULL){
    if(!empty($search)){
      foreach ($search as $srch) {
          $this->db->where($srch[1].$srch[2],$srch[3]);
      }

    }
    $query = $this->db->get('items');
		$result = $query->result_array();
    return $result;
  }
  public function insert_item_group($data){
		$this->db->insert('item_groups',$data);
	}
  public function get_item_groups(){
    $query = $this->db->get('item_groups');
    $result = $query->result_array();
    return $result;
  }
  public function insert_item_tax_template($data){
    $this->db->insert('item_tax_template',$data);
    return $this->db->insert_id();
  }
  public function insert_item_tax_template_detail($data){
    $this->db->insert('item_tax_template_detail',$data);
    return $this->db->insert_id();
  }
  public function get_gst_rate($gst_rate_name){
    $this->db->where('item_tax_name',$gst_rate_name);
    $query = $this->db->get('item_tax_template');
    $item_tax_template = $query->row_array();
    $item_tax_id = $item_tax_template['item_tax_id'];

    $this->db->where('item_tax_id',$item_tax_id);
    $query = $this->db->get('item_tax_template_detail');
    $item_tax_template_detail = $query->result_array();
    $item_tax_rate = 0;
    foreach($item_tax_template_detail as $detail){
      $item_tax_rate = $item_tax_rate + $detail['item_tax_rate'];
    }
    return $item_tax_rate;
  }
}
?>
