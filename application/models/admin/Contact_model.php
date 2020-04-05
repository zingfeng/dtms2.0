<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Contact_model extends CI_Model {
	function __construct()
    {
        parent::__construct();
    }
    public function lists($params = array()){
        $params = array_merge(array('limit' => 30,'offset' => 0),$params);
        if ($params['fullname']){
            $this->db->like('fullname',$params['fullname']);
        }
        if (isset($params['status'])) {
            $this->db->where('status',$params['status']);
        }
        if ($params['type']) {
            $this->db->where('type',$params['type']);
        }
        if ($params['from_date']) {
            $this->db->where('create_time >',$params['from_date']);
        }
        if ($params['to_date']) {
            $this->db->where('create_time <',$params['to_date']);
        }
        $this->db->order_by('contact_id DESC');

        $this->db->select('*');
        $query = $this->db->get('contact',$params['limit'],$params['offset']);
        return $query->result_array();
    }
    public function delete($cid){
    	$cid = (is_array($cid)) ? $cid : (int) $cid;
    	$this->db->where_in('contact_id',$cid);
		$this->db->delete('contact');
        // check affected row
        return $this->db->affected_rows();
    }
    public function update_status($cid){
        $cid = (is_array($cid)) ? $cid : (int) $cid;
        $this->db->where_in('contact_id',$cid);
        $this->db->set('status',1);
        $this->db->update('contact');
        // check affected row
        return $this->db->affected_rows();
    }
    public function subscribe($params = array()){
        $params = array_merge(array('limit' => 30,'offset' => 0),$params);
        $this->db->order_by('id DESC');

        $this->db->select('*');
        $query = $this->db->get('subcriber',$params['limit'],$params['offset']);
        return $query->result_array();
    }
    public function export($params){
        if ($params['fullname']){
            $this->db->like('fullname',$params['fullname']);
        }
        if (isset($params['status'])) {
            $this->db->where('status',$params['status']);
        }
        if ($params['type']) {
            $this->db->where('type',$params['type']);
        }
        if ($params['from_date']) {
            $this->db->where('create_time >',$params['from_date']);
        }
        if ($params['to_date']) {
            $this->db->where('create_time <',$params['to_date']);
        }
        $this->db->order_by('contact_id DESC');

        $this->db->select('*');
        $query = $this->db->get('contact');
        return $query->result_array();
    }


}