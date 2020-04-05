<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Seo_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }
    public function recent_test($limit){
        $this->db->where("publish",1);
        $this->db->where("original_cate >",0);
        $this->db->order_by("test_id","DESC");
        $query = $this->db->get("test");
        return $query->result_array();
    }
    public function recent_news($limit){
        $this->db->where("publish",1);
        $this->db->where("original_cate >",0);
        $this->db->order_by("news_id","DESC");
        $query = $this->db->get("news");
        return $query->result_array();
    }
}