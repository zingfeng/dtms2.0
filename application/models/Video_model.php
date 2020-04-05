<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Video_model extends CI_Model {
	function __construct()
    {
        parent::__construct();
    }
    
    public function get_detail_by_id($video_id){
    	$this->db->select("video_id,title,description,images,duration,vimeo_id,youtube_id");
        $this->db->where('video_id',$video_id);
        $query = $this->db->get('video');
        return $query->row_array();
    }
}