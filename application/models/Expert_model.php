<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Expert_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }
    public function detail($expert_id){
        $this->db->where_in('expert_id',$expert_id);
        $query = $this->db->get('expert');
        return $query->row_array();
    }
    public function get_expert($params = array()) {
        $params = array_merge(array('limit' => 10,'offset' => 0),$params);
        $this->db->where('publish',1);
        $query = $this->db->get('expert',$params['limit'],$params['offset']);
        return $query->result_array();
    }

    public function lists_teacher_by_course_id($course_id){
        if(!$course_id){
            return NULL;
        }
        $this->db->select("n.expert_id as teacher_id, n.name as teacher_name, n.images, n.description, n.share_url");
        $this->db->where('ct.course_id', $course_id);
        $this->db->join('course_to_teacher as ct', 'ct.teacher_id = n.expert_id');
        $query = $this->db->get('expert as n');
        return $query->result_array();
    }
}