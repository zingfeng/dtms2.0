<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users_model extends CI_Model {
	private $_table_member_roles = 'permission_roles';
	private $_table_member_to_roles = 'permission_member_to_roles';
	private $_table_users = 'users';
	function __construct()
    {
		parent::__construct();
    }
    public function lists($params = array()){
    	$params = array_merge(array('limit' => 30,'offset' => 0),$params);
        
		$this->db->select('user_id,email,fullname,active,create_time');
		if (isset($params['active'])){
			$this->db->where("active",$params['active']);
		}
		if (isset($params['email'])){
			$this->db->where("email",$params['email']);
		}
		if ($params['from_date']) {
            $this->db->where('create_time >',$params['from_date']);
        }
        if ($params['to_date']) {
            $this->db->where('create_time <',$params['to_date']);
        }
        if ($params['keyword']) {
            $this->db->like('fullname',$params['keyword']);
        }
		$this->db->order_by('user_id','DESC');
		$this->db->limit($params['limit'],$params['offset']);
		$query = $this->db->get($this->_table_users);
		return $query->result_array();
    }
    
	function detail($id){
		$this->db->where('user_id',$id);
		$query = $this->db->get($this->_table_users);
		return $query->row_array();
	}
	function get_user_by_email($email) {
		$this->db->where('email',$email);
		$query = $this->db->get($this->_table_users);
		return $query->row_array();
	}
	function delete($cid){
		$cid = (is_array($cid)) ? $cid : (int) $cid;
		$this->db->where_in('user_id',$cid);
		$this->db->delete($this->_table_users);
		return $this->db->affected_rows();
	}
	function get_users_by_id($arrUsers = array()) {
		if(empty($arrUsers)){
			return NULL;
		}
    	$this->db->select("member_id, email");
    	$this->db->where_in('member_id', $arrUsers);
		$query = $this->db->get($this->_table_member_to_roles);
		return $query->result_array();
    }

    public function update($user_id,$input){
        // set more input
        $input = array_merge($input, array(
            'update_time' => time(),
        ));
        // update course 
        $this->db->where('user_id',$user_id);
        $this->db->update('users',$input);
        $countRow = $this->db->affected_rows();
        // return result
        return $countRow;
    }

    public function insert($input){
    	// set more input
        $input = array_merge($input, array(
            'create_time' => time(),
            'update_time' => time(),
        ));
        $this->db->insert('users',$input);
    	return (int)$this->db->insert_id();
    }


}