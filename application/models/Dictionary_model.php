<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dictionary_model extends CI_Model {
	function __construct()
    {
        parent::__construct();
    }
    public function lists($params = array()){
        $params = array_merge(array('limit' => 30,'offset' => 0),$params);
        $this->db->select('*');
        if ($params['keyword']) {
            $this->db->like('word_en',$params['keyword']);
        }
        if ($params['arr_dict']) {
            $this->db->where_in('dict_id',$params['arr_dict']);
        }
        $this->db->order_by('dict_id','DESC');
        $query = $this->db->get('dictionary',$params['limit'],$params['offset']);
        return $query->result_array();
    }
}