<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Group_model extends CI_Model {
    private $_recursiveCate = array();
    function __construct()
    {
        parent::__construct();
    }
    public function lists($params = array()){
        $params = array_merge(array('limit' => 100,'offset' => 0),$params);
        if ($params['name']){
            $this->db->like('name',$params['name']);
        }
        $this->db->order_by('create_time DESC');
        $query = $this->db->get('class',$params['limit'],$params['offset']);
        return $query->result_array();
    }
    public function detail($id,$params = array()){
        $this->db->where('class_id',$id);
        $query = $this->db->get('class');
        return $query->row_array();
    }
    public function insert($input){
        $input = array_merge($input,array(
            'create_time' => time()
        ));
        $this->db->insert('class',$input);
        return $this->db->insert_id();
    }
    public function update($id,$input){
        // update class 
        $this->db->where('class_id',$id);
        $this->db->update('class',$input);
        return $this->db->affected_rows();
    }
    public function list_users($input) {
        $this->db->select("c.class_id,u.user_id,u.email,u.fullname");
        $this->db->where('c.class_id',$input['class_id']);
        $this->db->join('users as u','u.user_id = c.user_id');
        $query = $this->db->get('users_to_class as c',$input['limit'],$input['offset']);
        return $query->result_array();
    }
    public function insert_users_to_class($input) {
        $input = array(
            'class_id' => $input['class_id'],
            'user_id' => $input['user_id']
        );
        $result = $this->db->insert('users_to_class',$input);
        return $result;
    }
    /**
    * @author: namtq
    * @todo: Delete class
    * @param: adv_id
    */
    public function delete($cid){
        $cid = (is_array($cid)) ? $cid : (int) $cid;
        $this->db->where_in('class_id',$cid);
        $this->db->delete('class');
        return $this->db->affected_rows();
    }
    public function get_group_by_full($id){
        $this->db->where("full_id",$id);
        $query = $this->db->get("fulltest_to_role");
        return $query->result_array();
    }
    public function get_group_by_test($id){
        $this->db->select('test_to_class.*,class.name');
        $this->db->where("test_to_class.test_id",$id);
        $this->db->join("class","class.id = test_to_class.class_id");
        $query = $this->db->get("test_to_class");
        return $query->result_array();
    }

    public function get_list_expert()
    {
        $this->db->select('expert_id,name');
        $query = $this->db->get("expert");
        return $query->result_array();
    }
}