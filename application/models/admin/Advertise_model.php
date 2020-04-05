<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Advertise_model extends CI_Model {
    private $_recursiveCate = array();
	function __construct()
    {
        parent::__construct();
    }
    public function lists($params = array()){
		$params = array_merge(array('limit' => 30,'offset' => 0),$params);
        if ($params['cate_id']){
            $this->db->where('cate_id',$params['cate_id']);
        }
        
        if (isset($params['publish'])) {
            $this->db->where('publish',$params['publish']);
        }
        $this->db->order_by('ordering, adv_id DESC');
		$query = $this->db->get('advertise',$params['limit'],$params['offset']);
		return $query->result_array();
    }
    public function detail($id,$params = array()){
		$this->db->where('adv_id',$id);
    	$query = $this->db->get('advertise');
    	return $query->row_array();
    }
    public function insert($input){
        $profile = $this->permission->getIdentity();
    	$input = array_merge($input,array(
            'user_id' => $profile['user_id'],
            'create_time' => time()
        ));
    	$this->db->insert('advertise',$input);
    	return $this->db->insert_id();
    }
    public function update($adv_id,$input){
        // update advertise 
        $this->db->where('adv_id',$adv_id);
        $this->db->update('advertise',$input);
        return $this->db->affected_rows();
        
    }
    /**
    * @author: namtq
    * @todo: Delete advertise
    * @param: adv_id
    */
    public function delete($cid){
 		$cid = (is_array($cid)) ? $cid : (int) $cid;
		$this->db->where_in('adv_id',$cid);
		$this->db->delete('advertise');
        return $this->db->affected_rows();
    }
}