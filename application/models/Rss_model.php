<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rss_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }
    public function recent_post($limit){
        $this->db->where("publish",1);
        $this->db->where("original_cate >",0);
        $this->db->order_by("news_id","DESC");
        $query = $this->db->get("news");
        return $query->result_array();
    }
}