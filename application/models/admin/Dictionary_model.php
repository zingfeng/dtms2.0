<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dictionary_model extends CI_Model {
	function __construct()
    {
        parent::__construct();
    }    
    //////////////////////////////////// CATEGORY /////////////////////////
    public function detail($id){
    	$this->db->where('dict_id',(int) $id);
    	$query = $this->db->get('dictionary',1);
    	return $query->row_array();
    }
    /**
    * @author: Namtq
    * @todo: Insert category
    */
    public function insert($input){
        // insert data
		$this->db->insert('dictionary',$input);
        $dict_id = (int)$this->db->insert_id();     
        // return 
        return $dict_id;
    }
    public function update($dict_id, $input){
		$this->db->where('dict_id',$dict_id);
		$this->db->update('dictionary',$input);
        $countRow = $this->db->affected_rows();
        return $countRow;
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
    /**
    * @author: namtq
    * @todo: Delete category
    */
    public function delete($cid = array()){
        if (is_numeric($cid)) {$cid = array($cid);}
		$this->db->where_in('dict_id',$cid);
        $this->db->delete('dictionary');
        $countRow = $this->db->affected_rows();
        return $countRow;
    }
}