<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Room_model extends CI_Model {
	private $_table_room = 'rooms';
	private $_table_room_to_source = 'rooms_to_source';
    function __construct()
    {
        parent::__construct();
    }
    public function login($params = array()){
    	$this->db->select('room_id,name');
    	$this->db->where('username',$params['username']);
    	$this->db->where('password',$params['password']);
    	$query = $this->db->get($this->_table_room);
    	return $query->row_array();
    }
    public function getSourceByRoom($params = array()){
    	$params = array_merge(array('limit' => 10, 'offset' => 0),$params);
    	$this->db->where('r.type',$params['type']);
    	$this->db->where('r.room_id',$params['room_id']);
        
        switch ($params['type']) {
            case 1:
                if ($params['cate_id']) {
                    $this->db->join('news_to_cate as c','c.news_id = r.source_id');
                    $this->db->where('c.cate_id',$params['cate_id']);
                }
                $this->db->select('n.news_id,n.title,n.images,n.description,n.share_url,n.date_up');
                $this->db->join("news as n","n.news_id = r.source_id");
                $this->db->order_by("n.date_up DESC");
                break;
            case 2:
                if ($params['cate_id']) {
                    $this->db->join('test_to_cate as c','c.test_id = r.source_id');
                    $this->db->where('c.cate_id',$params['cate_id']);
                }
                else {
                    $this->db->where("t.score",1);
                }
                $this->db->select('t.test_id,t.title,t.images,t.share_url,t.total_users,t.total_hit');
                $this->db->join("test as t","t.test_id = r.source_id");
                $this->db->order_by("t.date_up DESC");
                break;
        }
    	$query = $this->db->get($this->_table_room_to_source. ' as r',$params['limit'],$params['offset']);
    	return $query->result_array();
    }
    public function totalSourceByRoom($params = array()){
    	$params = array_merge(array('limit' => 10, 'offset' => 0),$params);
    	$this->db->where('type',$params['type']);
    	$this->db->where('room_id',$params['room_id']);
         if ($params['cate_id']) {
            switch ($params['type']) {
                case 1:
                    $this->db->join('news_to_cate as c','c.news_id = r.source_id');
                    $this->db->where('c.cate_id',$params['cate_id']);
                    break;
                case 2:
                    $this->db->join('test_to_cate as c','c.test_id = r.source_id');
                    $this->db->where('c.cate_id',$params['cate_id']);
                    break;
            }
        }
        else {
            $this->db->where("t.score",1);
            $this->db->join("test as t","t.test_id = r.source_id");
        }
        $this->db->order_by('r.source_id','DESC');
    	return $this->db->count_all_results($this->_table_room_to_source .' as r');
    }
    public function checkSourceByRoom($params) {
        if (!$params['type'] || !$params['room_id'] || !$params['source_id']) {
            return false;
        }
        $this->db->where('type',$params['type']);
        $this->db->where('room_id',$params['room_id']);
        $this->db->where('source_id',$params['source_id']);
        return $this->db->count_all_results($this->_table_room_to_source);
    }
}