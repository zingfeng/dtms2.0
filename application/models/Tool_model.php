<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tool_model extends CI_Model {
    private $_table_old = 'mshoatoeic_old';
    function __construct()
    {
        parent::__construct();
    }
    //advertise
    public function get_advertise(){
    	$dbv1 = $this->load->database($this->_table_old, TRUE); 
    	$query = $dbv1->get('advertise');
    	return $query->result_array();
    }
    public function insert_advertise($input){
        //Xóa hết dữ liệu cũ
        $this->db->empty_table('advertise');
        //Insert
    	$this->db->insert_batch('advertise',$input);
    }

    //advertise_cate
    public function get_advertise_cate(){
    	$dbv1 = $this->load->database($this->_table_old, TRUE);
    	$query = $dbv1->get('advertise_cate');
    	return $query->result_array();
    }
    public function insert_advertise_cate($input){
        //Xóa hết dữ liệu cũ
        $this->db->empty_table('advertise_cate');
        //Insert
    	$this->db->insert_batch('advertise_cate',$input);
    }

    //contact
    public function get_contact(){
    	$dbv1 = $this->load->database($this->_table_old, TRUE);
    	$query = $dbv1->get('contact');
    	return $query->result_array();
    }
    public function insert_contact($input){
        //Xóa hết dữ liệu cũ
        $this->db->empty_table('contact');
        //Insert
    	$this->db->insert_batch('contact',$input);
    }

    //member
    public function empty_member(){
        $this->db->empty_table('users');
    }
    public function get_member($limit,$offset){
    	$dbv1 = $this->load->database($this->_table_old, TRUE);
    	$query = $dbv1->get('member',$limit,$offset);
    	return $query->result_array();
    }
    public function insert_member($input){
    	$this->db->insert_batch('users',$input);
    }
    //class
    public function get_class(){
    	$dbv1 = $this->load->database($this->_table_old, TRUE);
    	$query = $dbv1->get('class');
    	return $query->result_array();
    }
    public function insert_class($input){
        //Xóa hết dữ liệu cũ
        $this->db->empty_table('class');
        //Insert
    	$this->db->insert_batch('class',$input);
    }

    //tag
    public function get_tags(){
    	$dbv1 = $this->load->database($this->_table_old, TRUE);
    	$query = $dbv1->get('tags');
    	return $query->result_array();
    }
    public function insert_tags($input){
        //Xóa hết dữ liệu cũ
        $this->db->empty_table('tags');
        //Insert
    	$this->db->insert_batch('tags',$input);
    }
    //news cate
    public function get_news_cate(){
    	$dbv1 = $this->load->database($this->_table_old, TRUE);
    	$query = $dbv1->get('news_cate');
    	return $query->result_array();
    }
    public function insert_news_cate($input){
        //Xóa hết dữ liệu cũ
        $this->db->empty_table('news_cate');
        //Insert
    	$this->db->insert_batch('news_cate',$input);
    }

    //news cate
    public function empty_news_to_cate(){
        $this->db->empty_table('news_to_cate');
    }
    public function get_news_to_cate($params = array()){
        $params = array_merge(array(
            'limit' => 100,
            'offset' => 0,
        ), $params);
    	$dbv1 = $this->load->database($this->_table_old, TRUE);
    	$query = $dbv1->get('news_to_cate', $params['limit'], $params['offset']);
    	return $query->result_array();
    }
    public function insert_news_to_cate($input){
    	$this->db->insert_batch('news_to_cate',$input);
    }
    //Update database old
    public function update_news_to_cate($arr_news_id){
        $dbv1 = $this->load->database($this->_table_old, TRUE);
        $dbv1->where_in('news_id',$arr_news_id);
        $dbv1->update('news_to_cate', array('converted' => 1));
        $dbv1->affected_rows();
    }

    //news to role
    public function get_news_to_class(){
    	$dbv1 = $this->load->database($this->_table_old, TRUE);
    	$query = $dbv1->get('news_to_role');
    	return $query->result_array();
    }
    public function insert_news_to_class($input){
        //Xóa dữ liệu cũ
        $this->db->empty_table('news_to_class');
        //Insert
    	$this->db->insert_batch('news_to_class',$input);
    }
    //news to tags
    public function get_news_to_tags(){
    	$dbv1 = $this->load->database($this->_table_old, TRUE);
        $dbv1->join('news as n','n.news_id = nt.news_id');
        $dbv1->join('tags as t','t.tag_id = nt.tag_id');
    	$query = $dbv1->get('news_to_tags as nt');
    	return $query->result_array();
    }
    public function insert_news_to_tags($input){
        //Xóa dữ liệu cũ
        $this->db->empty_table('news_to_tags');
        //Insert
    	$this->db->insert_batch('news_to_tags',$input);
    }
    //news
    public function empty_news(){
        $this->db->empty_table('news');
    }
    public function get_news($params = array()){
        $params = array_merge(array(
            'limit' => 100,
            'offset' => 0,
        ), $params);
    	$dbv1 = $this->load->database($this->_table_old, TRUE);
    	$query = $dbv1->get('news', $params['limit'], $params['offset']);
    	return $query->result_array();
    }
    public function insert_news($input){
    	$this->db->insert_batch('news',$input);
    }
    //Update database old
    public function update_news($arr_news_id){
        $dbv1 = $this->load->database($this->_table_old, TRUE);
        $dbv1->where_in('news_id',$arr_news_id);
        $dbv1->update('news', array('converted' => 1));
        $dbv1->affected_rows();
    }

    ////////////////////////////////////TEST///////////////////////////////////////////
    //test cate
    public function get_test_cate(){
        $dbv1 = $this->load->database($this->_table_old, TRUE);
        $dbv1->where('cate_id > 0');
        $query = $dbv1->get('question_cate');
        return $query->result_array();
    }
    public function insert_test_cate($input){
        //Xóa hết dữ liệu cũ
        $this->db->empty_table('test_cate');
        //Insert
        $this->db->insert_batch('test_cate',$input);
    }

    public function empty_test(){
        $this->db->empty_table('test');
    }
    public function get_full_test($params = array()){
        $params = array_merge(array(
            'limit' => 100,
            'offset' => 0,
        ), $params);
        $dbv1 = $this->load->database($this->_table_old, TRUE);
        $query = $dbv1->get('question_full', $params['limit'], $params['offset']);
        return $query->result_array();
    }
    public function get_test($params = array()){
        $params = array_merge(array(
            'limit' => 100,
            'offset' => 0,
        ), $params);
        $dbv1 = $this->load->database($this->_table_old, TRUE);
        if($params['parent'] == 0){                 //Trường hợp là bài test
            $dbv1->where('q.parent', $params['parent']);
        }else{                                      //Trường hợp là question
            $dbv1->where('q.parent > 0');
        }
        $dbv1->where('q.converted', 0);           //Chỉ lấy những bài test không thuộc full test
        $dbv1->join('question_test as qt', 'q.parent = qt.qtest_id', 'left');
        $dbv1->select('q.*,qt.part as part_parent');
        $query = $dbv1->get('question_test as q', $params['limit'], $params['offset']);
        return $query->result_array();
    }
    public function insert_test($input){
        $this->db->insert_batch('test', $input);
    }
    //Update database old
    public function update_test_converted($arr_test_id, $params = array()){
        $params = array_merge(array('converted' => 1), $params);
        $dbv1 = $this->load->database($this->_table_old, TRUE);
        if(!empty($arr_test_id)){
            $dbv1->where_in('qtest_id', $arr_test_id);
        }else{
            $dbv1->where('qtest_id > 1');
        }
        $dbv1->update('question_test', $params);
        $dbv1->affected_rows();
    }

    //Convert question
    public function empty_question(){
        $this->db->empty_table('question');
    }
    public function get_question($params = array()){
        $params = array_merge(array(
            'limit' => 100,
            'offset' => 0,
        ), $params);
        $dbv1 = $this->load->database($this->_table_old, TRUE);
        $dbv1->join("(SELECT a.qtest_id,a.part,a.parent, b.part AS 'part_parent' FROM question_test AS a LEFT JOIN question_test AS b on a.parent = b.qtest_id)".' as qt','qt.qtest_id = q.test_id');
        if($params['test_id']){
            $dbv1->where('q.test_id', $params['test_id']);
        }
        if($params['converted'] !== null){
            $dbv1->where('q.converted', $params['converted']);
        }
        $dbv1->select('q.*,qt.part,qt.part_parent,qt.parent as test_parent');
        $query = $dbv1->get('question as q', $params['limit'], $params['offset']);
        return $query->result_array();
    }
    public function insert_question($input){
        $this->db->insert_batch('question',$input);
    }
    public function get_fulltest_contain_part($part_id){
        $dbv1 = $this->load->database($this->_table_old, TRUE);
        $dbv1->where('type in (1, 2)');             //Chỉ lấy fulltest và mini test
        $dbv1->where('(part1='.$part_id.' or part2='.$part_id.' or part3='.$part_id.' or part4='.$part_id.' or part5='.$part_id.' or part6='.$part_id.' or part7='.$part_id.')');
        $query = $dbv1->get('question_full', 1);
        return $query->row_array();
    }
    //Update database old
    public function update_question($arr_question_id, $params = array()){
        $params = array_merge(array('converted' => 1), $params);
        $dbv1 = $this->load->database($this->_table_old, TRUE);
        if(!empty($arr_question_id)){
            $dbv1->where_in('question_id', $arr_question_id);
        }else{
            $dbv1->where('question_id > 1');
        }
        $dbv1->update('question', $params);
        $dbv1->affected_rows();
    }

    //Convert question answer
    public function empty_question_answer(){
        $this->db->empty_table('question_answer');
    }
    public function get_question_answer($params = array()){
        $params = array_merge(array(
            'limit' => 100,
            'offset' => 0,
        ), $params);
        $dbv1 = $this->load->database($this->_table_old, TRUE);
        if($params['converted'] !== null){
            $dbv1->where('converted', $params['converted']);
        }
        if($params['list_question_id']){
            $dbv1->where_in('question_id', $params['list_question_id']);
        }
        $query = $dbv1->get('question_answer', $params['limit'], $params['offset']);
        return $query->result_array();
    }
    public function insert_question_answer($input){
        $this->db->insert_batch('question_answer',$input);
    }
    //Update database old
    public function update_question_answer($arr_id, $params = array()){
        $params = array_merge(array('converted' => 1), $params);
        $dbv1 = $this->load->database($this->_table_old, TRUE);
        if(!empty($arr_id)){
            $dbv1->where_in('id', $arr_id);
        }else{
            $dbv1->where('id > 1');
        }
        $dbv1->update('question_answer', $params);
        $dbv1->affected_rows();
    }

    //Block
    public function get_block(){
        $dbv1 = $this->load->database($this->_table_old, TRUE);
        $query = $dbv1->get('block');
        return $query->result_array();
    }
    public function insert_block($input){
        //Xóa hết dữ liệu cũ
        $this->db->empty_table('block');
        //Insert
        $this->db->insert_batch('block',$input);
    }

    //Block
    public function get_block_to_module(){
        $dbv1 = $this->load->database($this->_table_old, TRUE);
        $dbv1->join('block as b','b.block_id = bm.block_id');
        $dbv1->select('bm.*');
        $query = $dbv1->get('block_to_module as bm');
        return $query->result_array();
    }
    public function insert_block_to_module($input){
        //Xóa hết dữ liệu cũ
        $this->db->empty_table('block_to_module');
        //Insert
        $this->db->insert_batch('block_to_module',$input);
    }

    //Menu
    public function get_menus(){
        $dbv1 = $this->load->database($this->_table_old, TRUE);
        $query = $dbv1->get('menus');
        return $query->result_array();
    }
    public function insert_menus($input){
        //Xóa hết dữ liệu cũ
        $this->db->empty_table('menus');
        //Insert
        $this->db->insert_batch('menus',$input);
    }

    //fulltest to role
    public function get_fulltest_to_role(){
        $dbv1 = $this->load->database($this->_table_old, TRUE);
        $query = $dbv1->get('fulltest_to_role');
        return $query->result_array();
    }
    public function insert_test_to_class($input){
        //Xóa dữ liệu cũ
        $this->db->empty_table('test_to_class');
        //Insert
        $this->db->insert_batch('test_to_class',$input);
    }

    public function get_list_permission_member_to_role($params = array()){
             $params = array_merge(array('limit' => 30,'offset' => 0),$params);
                if ($params['keyword']) {
                    $this->db->like('email',$params['keyword']);
                }

             $this->db->select('member_id,email');
             $this->db->order_by('member_id','DESC');
             $this->db->limit($params['limit'],$params['offset']);
             $query = $this->db->get('permission_member_to_roles');
             return $query->result_array();
         }
}