<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Logs_model extends CI_Model {
	function __construct()
    {
        parent::__construct();
    }
    public function insertAction($params = array()){
    	$userProfile = $this->permission->getIdentity();
    	$params = array_merge(array(
    		'time' => time(),
    		'ip' => $_SERVER['REMOTE_ADDR'],
    		'user_id' => $userProfile['user_id'],
    	),$params);
        if (is_array($params['item_id'])) {
            foreach ($params['item_id'] as $key => $item_id) {
                $params_insert[] = array_merge($params,array('item_id'=> (int) $item_id));
            }
            $this->db->insert_batch('logs_action',$params_insert);
        }
        else {
            $this->db->insert('logs_action',$params);    
        }
    	
    }
    public function getAction($params= array()){
    	if ($params['user_id']) {
    		$this->db->get("user_id",$params['user_id']);
    	}
    	$this->db->order_by('time','DESC');
    	$query = $this->db->get('logs_action',50);
    	return $query->result_array();
    }
}