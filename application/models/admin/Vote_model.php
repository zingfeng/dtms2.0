<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Vote_model extends CI_Model {
	function __construct()
    {
        parent::__construct();
    }
    public function lists($param = array()){
        $paramdefaul = array('limit' => 20,'offset' => 0);
        $param = array_merge($paramdefaul,$param);
		$this->db->order_by('vote_id','DESC');
		$query = $this->db->get('vote_question',$param['limit'],$param['offset']);
		return $query->result_array();
    }
    public function detail($id){
    	$this->db->where('vote_id',$id);
    	$query = $this->db->get('vote_question',1);
    	$result = $query->row_array();
        if ($result){
            $this->db->where("vote_id",$id);
            $query = $this->db->get("vote_answer");
            $result['answer'] = $query->result_array();
            return $result;
        }
        else {
            return false;
        }
    }
    public function updateanswer($param) {
        $this->db->where("answer_id",$param['answer_id']);
        $this->db->set("name",$param['name']);
        $this->db->update('vote_answer');
    }
    public function deleteanswer($param) {
        $this->db->where("answer_id",$param['answer_id']);
        $this->db->delete('vote_answer');
    }
    public function insert(){
    	$input = $this->_input();
        $input['date_up'] = time();
		$this->db->insert('vote_question',$input);
        $voteid = (int)$this->db->insert_id();
        // insert answer
        $this->_answer_insert($voteid);

    }
    private function _answer_insert($voteid){
        $answer = $this->input->post('answer');
        $answer = array_filter($answer);
        if ($answer && $voteid > 0){
            foreach ($answer as $ans) {
                if ($ans) {
                    $input[] = array(
                        'vote_id' => $voteid,
                        'name'  => $ans
                    );
                }
            }
            if ($input){
                $this->db->where("vote_id",$voteid);
                $this->db->insert_batch('vote_answer',$input);
            }
        }
    }
    public function update($id){
    	$input = $this->_input();
		$this->db->where('vote_id',$id);
		$this->db->update('vote_question',$input);
        // edit menu
        $this->_answer_insert($id);
    }
    private function _input(){
		$input = array(
			'title' => $this->input->post('title'),
        );
		return $input;
    }
    public function delete(){
		$id = $this->input->post('cid');
		$this->db->where_in('vote_id',$id);
		$this->db->delete('vote_question');
		/** XOA DOC_TO_CATE **/
		$this->db->where_in('vote_id',$id);
		$this->db->delete('vote_answer');
    }
}