<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Speaking_model extends CI_Model {
    public $type_to_question = array(
                                    1 => array(1,2),
                                    2 => array(3),
                                    3 => array(4,5,6),
                                    4 => array(7,8,9),
                                    5 => array(10),
                                    6 => array(11),
                                );
	function __construct()
    {
        parent::__construct();
    }
    public function lists_point($limit = 10){
        $offset = 0;
        $array = $this->input->get(NULL);
        if (!empty($array)){
            if (array_key_exists('page',$array)){
                $offset = ($array['page'] - 1) * $limit;
            }
        }
        $this->db->select("u.*,t.name as test_name,m.username");
        $this->db->join("speaking_test as t","t.test_id = u.test_id");
        $this->db->join("member as m","m.user_id = u.user_id");
        if ($array['username']){
            $this->db->where("m.username",$array['username']);
        }
        if ($array['testid']){
            $this->db->where("u.test_id",(int)$array['testid']);
        }
        $this->db->group_by("u.time,u.test_id");
        $this->db->order_by("time DESC");
        $query = $this->db->get("speaking_question_to_user as u",$limit + 1,$offset);
        return $query->result_array();
    }
    public function update_point_teacher($record_id,$point,$comment){
        $this->db->set("point_teacher",$point);
        $this->db->set("comment_teacher",$comment);
        $this->db->where("record_id",$record_id);
        $this->db->update("speaking_question_to_user");
        // luu log
        $input = array(
            'user_id'   => $this->session->userdata("userid"),
            'action'    => 1,
            'time'      => time(),
            'param'    => json_encode(array("record_id" => $record_id,"point" => $point))
        );
        $this->db->insert("member_logs",$input);
    }

    public function lists($limit = 10){
		$offset = 0;
        $array = $this->input->get(NULL);
        if (!empty($array)){
            if (array_key_exists('page',$array)){
                $offset = ($array['page'] - 1) * $limit;
            }
        }
        $this->db->order_by('speaking_id','DESC');
		$query = $this->db->get('speaking',$limit+1,$offset);
		return $query->result_array();
    }
    public function detail($id,$select = null){
    	$this->db->where('speaking_id',$id);
    	$query = $this->db->get('speaking',1);
    	return $query->row_array();
    }
    public function insert(){
    	$input = $this->_input();
		$input2 = array(
            'user_id'   => $this->session->userdata('userid'),
            'date_up'   => time()
			);
		$input = array_merge($input,$input2);
    	$this->db->insert('speaking',$input);
    	$id = (int)$this->db->insert_id();
        // update share url
        $share_url = '/speaking/'.set_alias_link($input['title']).'-'.$id.'.html';
        $this->db->where('speaking_id',$id);
        $this->db->set('share_url',$share_url);
        $this->db->update('speaking');
        return $id;
    }
    public function update($id){
		$input = $this->_input();
        // update share_url 
        $share_url = '/speaking/'.set_alias_link($input['title']).'-'.$id.'.html';
        $input['share_url'] = $share_url;
		$this->db->where('speaking_id',$id);
		$this->db->update('speaking',$input);
    }

    public function delete(){
    	/** Liet ke danh sach file va anh can xoa **/
		$id = $this->input->post('cid');
 		/** xoa speaking **/
		$this->db->where_in('speaking_id',$id);
		$this->db->delete('speaking');
        return $row;
    }
    private function _input(){
		$input = array(
			'title' => $this->input->post('title'),
			'content' => $this->input->post('content'),
            'prepare_time' => intval($this->input->post('prepare_time')),
            'response_time' => intval($this->input->post('response_time')),
            'answer_text' => $this->input->post('answer_text'),
            'images' => $this->input->post('images'),
            'sound' => $this->input->post('sound'),
            'answer_sound' => $this->input->post('answer_sound'),
            'publish' => $this->input->post('publish'),
		);
		return $input;
    }
}