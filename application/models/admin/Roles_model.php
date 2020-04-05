<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Roles_model extends CI_Model {
	private $_table_member_roles = 'permission_roles';
	private $_table_member_to_roles = 'permission_member_to_roles';
	function __construct()
    {
		parent::__construct();
    }
    function checkRoleByEmail($email) {
    	$this->db->where('email',$email);
    	return $this->db->count_all_results($this->_table_member_to_roles);
    }
    function member_insert($input){
    	$input['create_time'] = time();
		$this->db->insert($this->_table_member_to_roles,$input);
		return (int) $input['member_id'];
	}
	function member_update($member_id, $input) {
		$this->db->where('member_id',$member_id);
		$this->db->set('roles_id',$input['roles_id']);
		$this->db->update($this->_table_member_to_roles);
		return $this->db->affected_rows();
	}
	function member_delete($cid) {
		$cid = (is_array($cid)) ? $cid : (int) $cid;
		$this->db->where_in('member_id',$cid);
		$this->db->delete($this->_table_member_to_roles);
		return $this->db->affected_rows();
	}
	function member_lists() {
		$this->db->order_by('create_time','DESC');
		$query = $this->db->get($this->_table_member_to_roles);
		return $query->result_array();
	}
	function member_detail($member_id) {
		$this->db->where("member_id",$member_id);
		$query = $this->db->get($this->_table_member_to_roles);
		return $query->row_array();
	}
    function getRoleByUser($member_id) {
    	$this->db->select('r.name,r.permission');
    	$this->db->where('t.member_id',$member_id);
    	$this->db->join($this->_table_member_roles . ' as r','r.roles_id = t.roles_id');
    	$query = $this->db->get($this->_table_member_to_roles. ' as t');
    	$row = $query->row_array();
    	if ($row) {
    		$row['permission'] = json_decode($row['permission'],TRUE);
    	}
    	return $row;
    }
    function detail($id){
		$this->db->where('roles_id',$id);
		$query = $this->db->get($this->_table_member_roles,1);
		return $query->row_array();
	}
	function lists(){
		$this->db->select('roles_id,name');
		$query = $this->db->get($this->_table_member_roles);
		return $query->result_array();
	}
	function insert($input){
		$this->db->insert($this->_table_member_roles,$input);
		return (int) $this->db->insert_id();
	}
	function update($role_id,$input){
		$this->db->where('roles_id',$role_id);
		$this->db->update($this->_table_member_roles,$input);
		return $this->db->affected_rows();
	}
	function delete($cid){
		$cid = (is_array($cid)) ? $cid : (int) $cid;
		$this->db->where_in('roles_id',$cid);
		$this->db->delete($this->_table_member_roles);
		return $this->db->affected_rows();
	}
}