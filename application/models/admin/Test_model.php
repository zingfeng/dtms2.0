<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Test_model extends CI_Model {
    private $_db_table = array(
        'test' => 'test',
        'test_question' => 'test_question',
        'test_question_answer' => 'test_question_answer',
        'test_logs' => 'test_logs',
        'users' => 'users',
        'test_result' => 'test_result'
    );
	function __construct()
    {
        parent::__construct();
    }
    public function lists($params = array()){
		$params = array_merge(array('limit' => 30,'offset' => 0),$params);
        if ($params['keyword']){
            $this->db->like('title',$params['keyword']);
        }
        if ($params['cate_id']){
            $this->db->where('original_cate',$params['cate_id']);
        }
        if ($params['user_id']) {
            $this->db->where('user_id',$params['user_id']);
        }
        $this->db->order_by('publish_time DESC, n.test_id DESC');
		$this->db->select('n.test_id,n.share_url,n.title,n.publish_time,n.publish,n.original_cate');
		$query = $this->db->get($this->_db_table['test'] .' as n',$params['limit'],$params['offset']);
		return $query->result_array();
    }
    public function get_list_by_arr_id($arrID){
        $this->db->where_in('test_id',$arrID);
        $this->db->select('test_id,title');
        $query = $this->db->get($this->_db_table['test']);
        return $query->result_array();
    }
    public function detail($id,$params = array()){
		$this->db->where('n.test_id',$id);
        if ($params['user_id']) {
            $this->db->where('n.user_id',$params['user_id']);
        }
    	$query = $this->db->get($this->_db_table['test'] . ' as n',1);
    	return $query->row_array();
    }
    public function insert($input){
        $profile = $this->permission->getIdentity();
    	$input['test'] = array_merge($input['test'],array(
            'user_id' => $profile['user_id'],
            'create_time' => time(),
            'update_time' => time(),
            'isclass' => ($input['group']) ? 1 : 0
        ));
    	$this->db->insert('test',$input['test']);
    	$test_id = (int)$this->db->insert_id();
        if (!$test_id) return false;
        // set share_url
        $this->db->set("share_url",'/test/'.set_alias_link($input['test']['title']).'-'.$test_id.'.html');
        $this->db->where("test_id",$test_id);
        $this->db->update($this->_db_table['test']);

        if ($input['group']) {
            $this->_update_test_to_group($test_id,$input['group']);
        }
        return $test_id;
    }
    public function update($test_id,$input){
        // set more input
        $input['test'] = array_merge($input['test'], array(
            'update_time' => time(),
            'share_url' => '/test/'.set_alias_link($input['test']['title']).'-'.$test_id.'.html',
            'isclass' => ($input['group']) ? 1 : 0
        ));
        // update test 
        $this->db->where('test_id',$test_id);
        $this->db->update($this->_db_table['test'],$input['test']);
        $countRow = $this->db->affected_rows();        
        // return result
        $this->_update_test_to_group($test_id,$input['group']);
        return $countRow;
    }
    /**
    * @author: namtq
    * @todo: Get all group of news
    * @param: news_id
    */
    public function get_group_by_test($test_id){
        $this->db->select('test_to_class.*,class.name');
        $this->db->where("test_id",$test_id);
        $this->db->join("class","test_to_class.class_id = class.class_id");
        $query = $this->db->get("test_to_class");
        return $query->result_array();
    }
    /**
    * @author: namtq
    * @todo: Update group for test
    * @param: (test_id, array class_id)
    */
    private function _update_test_to_group($test_id, $input) {
        // delete existed data
        $this->db->where('test_id',$test_id);
        $this->db->delete('test_to_class');
        if($input) {
            $input = array_unique($input);
            // insert new data
            foreach ($input as $class_id) {
                $dataInsert[] = array('test_id' => (int) $test_id, 'class_id' => (int) $class_id); 
            } 
            if ($dataInsert) {
                $this->db->insert_batch('test_to_class',$dataInsert);
            }
        }
    }
    /**
    * @author: namtq
    * @todo: Delete test
    * @param: test_id
    */
    public function delete($cid){
 		$cid = (is_array($cid)) ? $cid : (int) $cid;
        /** xoa test **/
        $this->db->where_in('test_id',$cid);
        $this->db->delete($this->_db_table['test']);
        $affected_rows =  $this->db->affected_rows();
        // check affected row
        return $affected_rows;
    }
    /////////////////////QUESTION////////////////////
    public function list_question($params){
        $this->db->select("*");
        $this->db->where('test_id',$params['test_id']);
        $this->db->order_by("ordering, question_id DESC");
        if (isset($params['parent_id']) && $params['parent_id'] !== array()) {
            $this->db->where_in('parent_id',$params['parent_id']);
        }
        $query = $this->db->get($this->_db_table['test_question']);
        return $query->result_array();
    }

    public function question_insert($input){
        $profile = $this->permission->getIdentity();
        $input = array_merge($input,array(
            'user_id' => $profile['user_id'],
            'create_time' => time(),
        ));
        $this->db->insert($this->_db_table['test_question'],$input);
        $question_id = (int)$this->db->insert_id();
        /// INSERT GROUP ////
        if ($input['group']) {
            $i = 1;
            foreach ($input['group'] as $key => $dt) {
                $inputData[] = array('title' => $dt['title'],'description' => $dt['description'], 'type' => $dt['type'],'ordering' => $i);
                $i ++;
            }
            if ($inputData) {
                $this->db->insert_batch('test_question_group',$inputData);
            }
        }

        return $question_id;
    }
    public function question_update($question_id,$input) {
        $this->db->where("question_id",$question_id);
        $this->db->update($this->_db_table['test_question'],$input);
        return TRUE;
    }
    public function question_delete($question_id) {
        $this->db->where_in('parent_id',$question_id);
        $this->db->where('parent_id != 0');
        $this->db->delete($this->_db_table['test_question']);

        $this->db->where_in("question_id",$question_id);
        $this->db->delete($this->_db_table['test_question']);
        return ($this->db->affected_rows()) ? TRUE : FALSE;

    }
    public function question_detail($question_id) {
        $this->db->where('question_id',$question_id);
        $query = $this->db->get($this->_db_table['test_question']);
        return $query->row_array();
    }
    public function get_answer_by_question($params = array()) {
        $this->db->where_in("question_id",$params['question_id']);
        $this->db->order_by("ordering");
        $query = $this->db->get($this->_db_table['test_question_answer']);
        return $query->result_array();
    }
    public function answer_insert($input = array()) {
        $this->db->insert('test_question_answer',$input['question']);
        $answer_id = (int)$this->db->insert_id();
        if ($answer_id && $input['answer']) {
            $this->answer_result_update($answer_id,$input['answer']);
        }
        return $answer_id;
    }
    public function answer_update($answer_id, $input = array()) {
        $this->db->where('answer_id',$answer_id);
        $this->db->update('test_question_answer',$input['question']);
        $result = ($this->db->affected_rows()) ? TRUE : FALSE;
        if ($input['answer']) {
            $this->answer_result_update($answer_id,$input['answer']);
        }
        return $result;
    }
    public function answer_delete($question_id) {
        $this->db->where_in("answer_id",$question_id);
        $this->db->delete('test_question_answer');
        return ($this->db->affected_rows()) ? TRUE : FALSE;
    }
    public function answer_detail($answer_id) {
        $this->db->where('answer_id',$answer_id);
        $query = $this->db->get('test_question_answer');
        return $query->row_array();
    }
    public function get_answer_result($answer_id){
        $this->db->where('answer_id',$answer_id);
        $this->db->order_by("ordering, answer_detail_id DESC");
        $query = $this->db->get('test_question_answer_result');
        return $query->result_array();
    }
    private function answer_result_update($answer_id,$arrInput) {
        $this->db->where('answer_id',$answer_id);
        $this->db->delete('test_question_answer_result');
        $arrData = array();
        $i = 1;
        foreach ($arrInput as $key => $input) {
            $arrData[] = array(
                'answer_id' => $answer_id,
                'answer' => $input,
                'ordering' => $i
            );
            $i ++;
        }
        $this->db->insert_batch('test_question_answer_result',$arrData);
    }
    
    //log test
    public function log_lists($params = array()) {
        $this->db->select('l.*,u.fullname,u.phone,u.email,u.user_id,t.title as test_title,t.test_id,t.share_url');
        $this->db->join($this->_db_table['test'].' as t','t.test_id = l.test_id','LEFT');
        $this->db->join($this->_db_table['users'].' as u','u.user_id = l.user_id');
        if ($params['test_id']) {
            $this->db->where('l.test_id',$params['test_id']);
        }
        if ($params['email']) {
            $this->db->where('u.email',$params['email']);
        }
        if ($params['from_date']) {
            $this->db->where('l.start_time >',$params['from_date']);
        }
        if ($params['to_date']) {
            $this->db->where('l.start_time <',$params['to_date']);
        }
        $this->db->order_by('logs_id', DESC);
        $query = $this->db->get($this->_db_table['test_logs'].' as l',$params['limit'],$params['offset']);
        return $query->result_array();
    }

    public function mark_lists($params = array()) {
        $this->db->select('l.*,u.fullname,u.phone,u.email,u.user_id,t.title as test_title,t.test_id,t.share_url');
        $this->db->join($this->_db_table['test'].' as t','t.test_id = l.test_id','LEFT');
        $this->db->join($this->_db_table['users'].' as u','u.user_id = l.user_id');
        if ($params['status']) {
            $this->db->where('l.status',$params['status']);
        }
        if ($params['test_type']) {
            $this->db->where('l.test_type',$params['test_type']);
        }
        if ($params['keyword']) {
             $this->db->like('t.title',$params['keyword']);
        }

        $this->db->where('l.status > ',0); // status = 1 ; 2
        $query = $this->db->get($this->_db_table['test_logs'].' as l',$params['limit'],$params['offset']);
        return $query->result_array();
    }

    public function log_delete($arrId) {
        if (!is_array($arrId)) {
            return false;
        }
        // delete log
        $this->db->where_in("logs_id",$arrId);
        $this->db->delete("test_logs");
        return $this->db->affected_rows();
    }
    public function get_question_by_test($params) {
        $params_default = array('limit' => 100, 'offset' => 0);
        $params = array_merge($params_default,$params);
        $this->db->select("*");
        $this->db->where("test_id", $params['test_id']);
        if (isset($params['parent'])) {
            $this->db->where("parent_id",0);
        }
        
        if ($params['type']) {
            $this->db->where_in('type',$params['type']);
        }
        $this->db->order_by("ordering, question_id ASC");
        $query = $this->db->get("test_question",$params['limit'],$params['offset']);
        $arrQuestion =  $query->result_array();
        return  $arrQuestion;
    }
    public function get_question_group($params) {
        $params_default = array('limit' => 100, 'offset' => 0);
        $params = array_merge($params_default,$params);
        $this->db->select("*");
        $this->db->where_in("parent_id", $params['parent_id']);
        $this->db->order_by("ordering, question_id DESC");
        $query = $this->db->get("test_question",$params['limit'],$params['offset']);
        $arrQuestion =  $query->result_array();
        foreach ($arrQuestion as $question) {
            $arrQuestionData[$question['parent_id']][$question['question_id']] = $question;
            $arrQuestionId[] = $question['question_id'];
        }
        if ($params['return_question_id_only'] == 1) {
            return $arrQuestionId;
        }
        $this->db->where_in('question_id',$arrQuestionId);
        $this->db->order_by('ordering, question_id');
        $query = $this->db->get('test_question_answer');
        $rows = $query->result_array();
        
        foreach ($rows as $key => $row) {
            $arrAnswerData[$row['question_id']][] = $row;
            $arrNumber[$row['question_id']] += $row['number_question'];
        }

        foreach ($arrQuestion as $question) {

            $question['question_answer'] = $arrAnswerData[$question['question_id']];
            $question['number_question'] = $arrNumber[$question['question_id']];
            $arrQuestionData[$question['parent_id']][$question['question_id']] = $question;
        }
        return $arrQuestionData;
    }
    //Get test log detail
    public function test_log_detail($params = array()){
        if ($params['logs_id']) {
            $this->db->where('n.logs_id',$params['logs_id']);
        }
        if ($params['user_id']) {
            $this->db->where('n.user_id',$params['user_id']);
        }
        if ($params['test_id']) {
            $this->db->where('n.test_id',$params['test_id']);
        }
        $query = $this->db->get($this->_db_table['test_logs'] . ' as n',1);
        return $query->row_array();
    }
    //Insert test log
    public function test_log_insert($input){
        // insert log
        $input = array_merge($input, array(
            'start_time' => time(),
            'end_time' => time(),
        ));
        $this->db->insert('test_logs',$input);
        return (int)$this->db->insert_id();
    }
    //Update test log
    public function test_log_update($logs_id, $input){
        // insert log
        $input = array_merge($input, array(
            'start_time' => time(),
            'end_time' => time(),
        ));
        $this->db->where('logs_id',$logs_id);
        $this->db->update('test_logs',$input);
        return $this->db->affected_rows();
    }
    //Get test log by array test id
    public function get_test_logs_by_test_id($arr_test_id){
        if(empty($arr_test_id)){
            return NULL;
        }
        $this->db->select('l.*,u.fullname, u.email, t.title');
        $this->db->where_in("l.test_id",$arr_test_id);
        $this->db->join("users as u","u.user_id = l.user_id");
        $this->db->join("test as t","t.test_id = l.test_id");
        $this->db->group_by("test_id, start_time");
        $query = $this->db->get("test_logs as l");
        return $query->result_array();
    }


    //////////////////////////TEST RESULT////////////////////////////////
    /*
    **  Danh sách kết quả bài test  
    */
    public function result_lists($type){
        if(!$type){
            return NULL;
        }
        $this->db->select('*');
        $this->db->where('type',$type);
        $this->db->order_by('score_min ASC');
        $query = $this->db->get($this->_db_table['test_result']);
        return $query->result_array();
    }
    //Get detail
    public function result_detail($id){
        $this->db->where('id',$id);
        $query = $this->db->get($this->_db_table['test_result'],1);
        return $query->row_array();
    }
    //Test result insert
    public function result_insert($input){
        // insert log
        $input = array_merge($input, array(
            'create_time' => time(),
            'update_time' => time(),
        ));
        $this->db->insert($this->_db_table['test_result'],$input);
        return (int)$this->db->insert_id();
    }
    //Update test log
    public function result_update($id, $input){
        // insert log
        $input = array_merge($input, array(
            'update_time' => time(),
        ));
        $this->db->where('id',$id);
        $this->db->update($this->_db_table['test_result'],$input);
        return $this->db->affected_rows();
    }
    //Test result delete
    public function result_delete($arrId) {
        if (!is_array($arrId)) {
            return false;
        }
        // delete log
        $this->db->where_in("id",$arrId);
        $this->db->delete($this->_db_table['test_result']);
        return $this->db->affected_rows();
    }

    /** LIST TEST FOR COURSE CLASS**/
    public function list_for_course_class($course_class_id,$options = array()){
        $options = array_merge(array('limit' => 10, "offset" => 0),$options);
        $this->db->join("course_class_to_test as ct","ct.test_id = t.test_id", 'LEFT');
        $this->db->where("ct.course_class_id",$course_class_id);
        $this->db->order_by("ct.ordering");
        $query = $this->db->get("test as t", $options['limit'], $options['offset']);
        return $query->result_array();
    }
}