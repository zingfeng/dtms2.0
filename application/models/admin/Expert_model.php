<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Expert_model extends CI_Model {
	function __construct()
    {
        parent::__construct();
    }    
    //////////////////////////////////// CATEGORY /////////////////////////
    public function detail($id){
    	$this->db->where('expert_id',(int) $id);
    	$query = $this->db->get('expert',1);
    	return $query->row_array();
    }
    /**
    * @author: Namtq
    * @todo: Insert category
    */
    public function insert($input){
        $input = array_merge($input, array(
            'create_time' => time(),
            'update_time' => time()
        ));
        // insert data
		$this->db->insert('expert',$input);
        $expert_id = (int)$this->db->insert_id();
        // update share_url
        $this->db->where("expert_id",$expert_id);
        $this->db->set("share_url",'/expert/'.set_alias_link($input['name']).'-'.$expert_id.'.html');
        $this->db->update("expert");
        // return 
        return $expert_id;
    }
    public function update($expert_id, $input){
        
    	$input = array_merge($input, array(
            'update_time' => time(),
            'share_url' => '/expert/'.set_alias_link($input['name']).'-'.$expert_id.'.html'
        ));       
		$this->db->where('expert_id',$expert_id);
		$this->db->update('expert',$input);
        $countRow = $this->db->affected_rows();
        return $countRow;
    }
    public function lists($params = array()){
        $params = array_merge(array('limit' => 30,'offset' => 0),$params);
        $this->db->select('*');
        if ($params['keyword']){
            $this->db->like('name', $params['keyword']);
        }
        $query = $this->db->get('expert',$params['limit'],$params['offset']);
        return $query->result_array();
    }
    /**
    * @author: namtq
    * @todo: Delete category
    */
    public function delete($cid = array()){
        if (is_numeric($cid)) {$cid = array($cid);}
		$this->db->where_in('expert_id',$cid);
        $this->db->delete('expert');
        $countRow = $this->db->affected_rows();
        return $countRow;
    }

    public function get_teacher_by_course($course_id){
        $this->db->select('n.expert_id, n.name');
        $this->db->join('expert as n', 'n.expert_id = ct.teacher_id');
        $this->db->where('ct.course_id',$course_id);
        $query = $this->db->get('course_to_teacher as ct');
        return $query->result_array();
    }

    public function get_teacher_offline_by_course($course_id){
        $this->db->select('p.member_id, p.email');
        $this->db->join('permission_member_to_roles as p', 'p.member_id = ct.teacher_id');
        $this->db->where('ct.course_id',$course_id);
        $query = $this->db->get('course_to_teacher_offline as ct');
        return $query->result_array();
    }


}