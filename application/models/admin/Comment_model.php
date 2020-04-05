<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Comment_model extends CI_Model {
	function __construct()
    {
        parent::__construct();
    }
    public function lists($params = array()){
		$params = array_merge(array('parent_id' => 0,'limit' => 30,'offset' => 0), $params);
        $this->db->where("parent_id", $params['parent_id']);
        $this->db->join("users as u",'u.user_id = c.user_id');
        $this->db->join("news as n",'n.news_id = c.target_id', "LEFT");
        $this->db->join("course as cs",'cs.course_id = c.target_id', "LEFT");
        $this->db->join("course_class as cl",'cl.class_id = c.target_id', "LEFT");
        if ($params['from_date']) {
            $this->db->where('c.create_time >',$params['from_date']);
        }
        if ($params['to_date']) {
            $this->db->where('c.create_time <',$params['to_date']);
        }
        $this->db->order_by('status,comment_id DESC');
		$this->db->select('c.*, u.fullname, u.email, n.title as news_title, n.share_url as news_url, cs.title as course_title, cs.share_url as course_url, cl.title as class_title, cl.share_url as class_url');
		$query = $this->db->get('comment as c',$params['limit'],$params['offset']);
		return $query->result_array();
    }
    public function detail($id){
        $this->db->where('comment_id',$id);
        $query = $this->db->get('comment',1);
        return $query->row_array();
    }
    public function update($id,$status){
        $this->db->set("status",$status);
		$this->db->where("comment_id",$id); $this->db->update("comment");
    }
    public function delete(){
		$id = $this->input->post('cid');
		$this->db->where_in('comment_id',$id);
        $this->db->or_where_in('parent_id',$id);
		$this->db->delete('comment');
        return $this->db->affected_rows();
    }
    public function update_status($comment_id, $status){
        $this->db->where('comment_id',$comment_id);
        $this->db->set('status',$status);
        $this->db->update('comment');
        // check affected row
        return $this->db->affected_rows();
    }
}