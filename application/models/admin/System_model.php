<?php
class System_model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	function get_modul(){
		$this->db->select('name,unroles');
		$this->db->order_by('cate');
        $query = $this->db->get('module');
		return $query->result_array();
	}
    function get_setting(){
        $query = $this->db->get('setting',1);
        return $query->row_array();
    }
    function update_setting($data = array(),$id = 0){
        if (!empty($data) AND $id > 0){
            $this->db->where('id',$id);
            $this->db->update('setting',$data);
        }
    }
 }