<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Course_model extends CI_Model {
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
        if (isset($params['publish'])) {
            $this->db->where('publish',$params['publish']);
        }
        if($params['user_id']){
            $this->db->join("course_to_teacher_offline as t",'t.course_id = n.course_id');
            $this->db->where('t.teacher_id',$params['user_id']);
        }
        $this->db->order_by('publish_time DESC, n.course_id DESC');
        $this->db->where("n.lang",$this->session->userdata("lang"));
		$this->db->select('n.course_id,n.share_url,n.title,n.sku,n.publish_time,n.hit,n.publish,n.original_cate,n.price');
		$query = $this->db->get('course as n',$params['limit'],$params['offset']);
		return $query->result_array();
    }
    public function detail($id,$params = array()){
		$this->db->where('n.course_id',$id);
        if ($params['user_id']) {
            $this->db->where('n.user_id',$params['user_id']);
        }
    	$query = $this->db->get('course as n',1);
    	return $query->row_array();
    }
    public function insert($input){
        $profile = $this->permission->getIdentity();
    	$input['course'] = array_merge($input['course'],array(
            'user_id' => $profile['user_id'],
            'create_time' => time(),
            'update_time' => time(),
            'lang' => $this->session->userdata("lang")
        ));
    	$this->db->insert('course',$input['course']);
    	$course_id = (int)$this->db->insert_id();
        if (!$course_id) return false;
        // update share url
        // get original cate
        $orgCateId = $input['course']['original_cate'];
        $cateorg = 'page';
        if ($orgCateId > 0){
            $cateorg = $this->cate_detail($orgCateId);
            $cateorg = set_alias_link($cateorg['name']);
        }
        // set share_url
        $this->db->set("share_url",'/khoa-hoc/'.$cateorg.'/'.set_alias_link($input['course']['title']).'-'.$course_id.'.html');
        $this->db->where("course_id",$course_id);
        $this->db->update('course');
        // insert tags
        if ($input['tags']){
            $this->_update_course_to_tags($course_id,$input['tags']);
        }
        //update course to documents
        $this->_update_course_to_documents($course_id,$input['documents']);
        //update course to test
        $this->_update_course_to_test($course_id,$input['test']);
        //update course to teacher
        $this->_update_course_to_teacher($course_id,$input['teacher']);
        // insert course to cate
        $arrCateId = ($input['category']) ? array_merge($input['category'],array($orgCateId)) : array($orgCateId);        
        $this->_update_course_to_cate($course_id,$arrCateId);
        return $course_id;
    }
    public function update($course_id,$input){
        // get original cate
        $orgCateId = $input['course']['original_cate'];
        if ($orgCateId > 0){
            $cateorg = $this->cate_detail($orgCateId);
            $cateorg = set_alias_link($cateorg['name']);
        }
        // set more input
        $input['course'] = array_merge($input['course'], array(
            'update_time' => time(),
            'share_url' => '/khoa-hoc/'.$cateorg.'/'.set_alias_link($input['course']['title']).'-'.$course_id.'.html'
        ));
        // update course 
        $this->db->where('course_id',$course_id);
        $this->db->update('course',$input['course']);
        $countRow = $this->db->affected_rows();
        // insert tags
        if ($input['tags']){
            $this->_update_course_to_tags($course_id,$input['tags']);
        }
        //update course to documents
        $this->_update_course_to_documents($course_id,$input['documents']);
        //update course to test
        $this->_update_course_to_test($course_id,$input['test']);
        //update course to teacher
        $this->_update_course_to_teacher($course_id,$input['teacher']);
        $this->_update_course_to_teacher_offline($course_id,$input['teacher_offline']);


        // insert course to cate
        $arrCateId = ($input['category']) ? array_merge($input['category'],array($orgCateId)) : array($orgCateId);        
        $this->_update_course_to_cate($course_id,$arrCateId);
        // return result
        return $countRow;
    }
    
    /**
    * @author: namtq
    * @todo: Delete course
    * @param: course_id
    */
    public function delete($cid){
 		$cid = (is_array($cid)) ? $cid : (int) $cid;
        // xoa course 
        $this->db->where_in('course_id',$cid);
        $this->db->delete('course');
        $affected_rows =  $this->db->affected_rows();
        // xoa course t0 cate 
        $this->db->where_in('course_id',$cid);
        $this->db->delete('course_to_cate');
        $this->db->where_in('course_id',$cid);
        $this->db->delete('course_topic');
        return $affected_rows;
    }

    /**
    * @todo: Update tag - course
    * @param: array(course, input[tag_new,tag_exist] ) 
    */
    private function _update_course_to_tags($course_id, $input){
        // delete old data
        $this->db->where('course_id',$course_id);
        $this->db->delete('course_to_tags');
        if (!$input['tag_new'] && !$input['tag_exist']) {
            return TRUE;
        }
        // insert new data
        $tagsExist = $input['tag_exist'];
        // check add push id tag new
        if ($input['tag_new']) {
            foreach ($input['tag_new'] as $tagName) {
                $this->db->where('name',$tagName);
                $query = $this->db->get('tags');
                $row = $query->row_array();
                // neu tag do da ton tai
                if ($row) {
                    $tagsExist[] = $row['tag_id'];
                }
                // neu tag do chua ton tai
                else {
                    $arrInput = array('name' => $tagName);
                    $this->db->insert('tags',$arrInput);
                    $tagId = (int)$this->db->insert_id();
                    // update share_url
                    if ($tagId) {
                        $this->db->set('share_url','/tag/'.set_alias_link($tagName).'-'.$tagId.'.html');
                        $this->db->where('tag_id',$tagId);
                        $this->db->update('tags');
                        // push id to array
                        $tagsExist[] = $tagId;
                    }
                }
            }
        }
        if ($tagsExist){
            $tagsExist = array_unique($tagsExist);
            $i = 1;
            $input = array();
            foreach ($tagsExist as $tagId) {
                if ($tagId <= 0) continue;
                $input[] = array(
                    'tag_id' => $tagId,
                    'course_id' => $course_id,
                    'ordering' => $i
                );
                $i ++;
            }
            if ($input) {
                $this->db->insert_batch('course_to_tags',$input);
            }
        }
    }

    /**
    * @author: namtq
    * @todo: Get all tag of course
    * @param: news_id
    */
    public function get_tags_by_course($course_id){
        $this->db->select("t.name,t.tag_id");
        $this->db->where('n.course_id',$course_id);
        $this->db->join("tags as t",'t.tag_id = n.tag_id');
        $query = $this->db->get("course_to_tags as n");
        return $query->result_array();
    }
    
    //////////////////////////////////// CATEGORY /////////////////////////
    public function cate_detail($id){
    	$this->db->where('cate_id',$id);
    	$query = $this->db->get('category',1);
    	return $query->row_array();
    }
    public function topic_detail($id){
        $this->db->where('topic_id',$id);
        $query = $this->db->get('course_topic',1);
        return $query->row_array();
    }
    /**
    * @author: Namtq
    * @todo: Insert category
    */
    public function topic_insert($input){
        $input = array_merge($input, array(
            'lang' => $this->session->userdata("lang"),
            'create_time' => time(),
            'update_time' => time()
        ));
        // insert data
		$this->db->insert('course_topic',$input);
        $topicid = (int)$this->db->insert_id();
        // update share_url
        $this->db->where("topic_id",$topicid);
        $this->db->set("share_url",'/'.set_alias_link($input['name']).'-pl'.$topicid.'.html');
        $this->db->update("course_topic");
        // return 
        return $topicid;
    }
    public function topic_update($topic_id, $input){
    	$input = array_merge($input, array(
            'update_time' => time(),
            'share_url' => '/'.trim(set_alias_link($input['name']),'/').'-pl'.$topic_id.'.html'
        ));
       
		$this->db->where('topic_id',$topic_id);
		$this->db->update('course_topic',$input);
        $countRow = $this->db->affected_rows();
        // edit menu
        return $countRow;
    }
    /**
    * @author: namtq
    * @todo: Delete category
    */
    public function topic_delete($cid = array()){
		if (is_numeric($cid)) {$cid = array($cid);}
        $countRow = false;
        if ($cid) {
            $cid = array_unique($cid);
            $this->db->where_in('topic_id',$cid);
            $this->db->delete('course_topic');
            $countRow = $this->db->affected_rows();

            //delete course_class
            $this->db->where_in('topic_id',$cid);
            $this->db->delete('course_class');
            
        }
        return $countRow;
    }

    ////////////////CLASSS//////////
    public function class_insert($input){
        $profile = $this->permission->getIdentity();
        $input['class'] = array_merge($input['class'],array(
            'user_id' => $profile['user_id'],
            'create_time' => time(),
            'update_time' => time(),
            'lang' => $this->session->userdata("lang")
        ));
        $this->db->insert('course_class',$input['class']);
        $class_id = (int)$this->db->insert_id();
        if (!$class_id) return false;
        // set share_url
        if(!$input['class']['share_url']){
            $this->db->where("class_id", $class_id);
            $this->db->set("share_url",'/bai-hoc/'.set_alias_link($input['class']['title']).'-'.$class_id.'.html');
            $this->db->update('course_class');
        }
        
        if ($class_id && $input['documents']) {
            $this->_update_course_class_to_documents(array('class_id' => $class_id, 'documents' => $input['documents']));
        }
        //update course class to test
        if ($class_id && $input['test']) {
            $this->_update_course_class_to_test($class_id, $input['test']);
        }
        return $class_id;
    }
    public function class_update($class_id, $input){
        $input['class'] = array_merge($input['class'], array(
            'update_time' => time(),
        ));
        if(!$input['class']['share_url']){
            $input['class']['share_url'] = '/bai-hoc/'.set_alias_link($input['class']['title']).'-'.$class_id.'.html';
        }
        $this->db->where('class_id',$class_id);
        $this->db->update('course_class',$input['class']);
        $countRow = $this->db->affected_rows();
        if ($countRow) {
            $this->_update_course_class_to_documents(array('class_id' => $class_id, 'documents' => $input['documents']));
        }
        //update course class to test
        if ($class_id && $input['test']) {
            $this->_update_course_class_to_test($class_id, $input['test']);
        }
        // edit menu
        return $countRow;
    }
    /**
    * @todo: Delete class
    */
    public function class_delete($cid = array()){
        if (is_numeric($cid)) {$cid = array($cid);}
        $countRow = false;
        if ($cid) {
            $cid = array_unique($cid);
            $this->db->where_in('class_id',$cid);
            $this->db->delete('course_class');
            $countRow = $this->db->affected_rows();
        }
        return $countRow;
    }
     /**
    * @todo: Update điểm cho học viên
    */
    public function class_point_update($test_id, $arrPoint = array()){
        $countRow = false;
        if ($cid) {
            $cid = array_unique($cid);
            $this->db->where_in('class_id',$cid);
            $this->db->delete('course_class');
            $countRow = $this->db->affected_rows();
        }
        return $countRow;
    }

    /**
    * @author: namtq
    * @todo: update document for course class
    * @param: array(int class_id, arr document_id)
    */
    private function _update_course_class_to_documents($input) {
        // delete 
        $this->db->where('class_id',$input['class_id']);
        $this->db->delete('course_class_to_documents');
        // insert
        
        if ($input['documents']) {
            $i = 1;
            foreach ($input['documents'] as $doc_id) {
                $dataInsert[] = array('class_id' => (int) $input['class_id'], 'document_id' => (int) $doc_id, 'ordering' => $i); 
                $i ++;
            } 
            if ($dataInsert) {
                $this->db->insert_batch('course_class_to_documents',$dataInsert);
            }
        }
    }
    //////////////////////// END CLASS///////////
    public function get_topic_by_course($course_id){
        $this->db->where('course_id',$course_id);
        $this->db->order_by('ordering');
        $query = $this->db->get('course_topic');
        return $query->result_array();
    }

    public function get_class_by_topic($topic_id){
        $this->db->where('topic_id',$topic_id);
        $query = $this->db->get('course_class');
        return $query->result_array();
    }

    public function get_class_by_arrtopic($arrID = array()){
        $this->db->where_in('topic_id',$arrID);
        $this->db->select('n.*, count(ct.course_class_id) as count_test');
        $this->db->join('course_class_to_test as ct','n.class_id = ct.course_class_id', 'LEFT');
        $this->db->group_by('n.class_id');
        $query = $this->db->get('course_class as n');
        return $query->result_array();
    }

    public function class_detail($id){
        $this->db->where('class_id',$id);
        $query = $this->db->get('course_class',1);
        return $query->row_array();
    }

    /**
    * @author: namtq
    * @todo: Get all course special
    * @param: position
    */
    public function get_buildtop($params = array()) {
        $this->db->select('n.course_id, n.title,n.original_cate');
        $this->db->where('position',$params['position']);
        $this->db->where('b.type','course');
        $this->db->join('course as n','n.course_id = b.item_id');
        $this->db->where('b.lang',$this->session->userdata("lang"));
        $this->db->order_by('b.ordering');
        $query = $this->db->get("build_top as b");
        return $query->result_array();
    }
    /**
    * @author: namtq
    * @todo: Set order all build top course
    * @param: position
    */
    public function update_buildtop($arrId,$position) {
        if (!$position) {
            return false;
        }
        // delete old data
        $this->db->where('position',$position);
        $this->db->where('type','course');
        $this->db->where('lang',$this->session->userdata('lang'));
        $this->db->delete('build_top');
        // insert new data
        $i = 1;
        if ($arrId) {
            $arrId = array_unique($arrId);
            foreach ($arrId as $key => $arrId) {
                $input[] = array(
                    'type' => 'course',
                    'lang' => $this->session->userdata('lang'),
                    'position' => $position,
                    'item_id' => $arrId,
                    'ordering' => $i
                );
                $i++;
            }
            $this->db->insert_batch('build_top',$input);
        }
        return $i;
    }

    private function _update_course_to_documents($course_id, $input) {
        // delete existed data
        $this->db->where('course_id',$course_id);
        $this->db->delete('course_to_documents');
        $input = is_array($input) ? $input : array($input);
        $input = array_unique($input);
        // insert new data
        $i = 1;
        foreach ($input as $document_id) {
            $dataInsert[] = array('course_id' => (int) $course_id, 'document_id' => (int) $document_id,'ordering' => $i);
            $i++; 
        } 
        if ($dataInsert) {
            $this->db->insert_batch('course_to_documents',$dataInsert);
        }
    }

    private function _update_course_to_test($course_id, $input) {
        // delete existed data
        $this->db->where('course_id',$course_id);
        $this->db->delete('course_to_test');
        $input = is_array($input) ? $input : array($input);
        $input = array_unique($input);
        // insert new data
        $i = 1;
        foreach ($input as $test_id) {
            $dataInsert[] = array('course_id' => (int) $course_id, 'test_id' => (int) $test_id,'ordering' => $i);
            $i++; 
        } 
        if ($dataInsert) {
            $this->db->insert_batch('course_to_test',$dataInsert);
        }
    }

    //Course to teacher
    private function _update_course_to_teacher($course_id, $input) {
        // delete existed data
        $this->db->where('course_id',$course_id);
        $this->db->delete('course_to_teacher');
        $input = is_array($input) ? $input : array($input);
        $input = array_unique($input);
        // insert new data
        $i = 1;
        foreach ($input as $teacher_id) {
            $dataInsert[] = array('course_id' => (int) $course_id, 'teacher_id' => (int) $teacher_id,'ordering' => $i);
            $i++; 
        } 
        if ($dataInsert) {
            $this->db->insert_batch('course_to_teacher',$dataInsert);
        }
    }

    private function _update_course_to_teacher_offline($course_id, $input) {
        // delete existed data
        $this->db->where('course_id',$course_id);
        $this->db->delete('course_to_teacher_offline');
        $input = is_array($input) ? $input : array($input);
        $input = array_unique($input);
        // insert new data
        $i = 1;
        foreach ($input as $teacher_id) {
            $dataInsert[] = array('course_id' => (int) $course_id, 'teacher_id' => (int) $teacher_id,'ordering' => $i);
            $i++;
        }
        if ($dataInsert) {
            $this->db->insert_batch('course_to_teacher_offline',$dataInsert);
        }
    }

    private function _update_course_class_to_test($course_class_id, $input) {
        // delete existed data
        $this->db->where('course_class_id',$course_class_id);
        $this->db->delete('course_class_to_test');
        $input = is_array($input) ? $input : array($input);
        $input = array_unique($input);
        // insert new data
        $i = 1;
        foreach ($input as $test_id) {
            $dataInsert[] = array('course_class_id' => (int) $course_class_id, 'test_id' => (int) $test_id,'ordering' => $i);
            $i++; 
        } 
        if ($dataInsert) {
            $this->db->insert_batch('course_class_to_test', $dataInsert);
        }
    }


    /**
    * @author: namtq
    * @todo: Insert course to Cate
    * @param: array(id1,id2) 
    */
    private function _update_course_to_cate($course_id, $input) {
        // delete existed data
        $this->db->where('course_id',$course_id);
        $this->db->delete('course_to_cate');
        $input = array_unique($input);
        // insert new data
        foreach ($input as $cate_id) {
            $dataInsert[] = array('course_id' => (int) $course_id, 'cate_id' => (int) $cate_id); 
        } 
        if ($dataInsert) {
            $this->db->insert_batch('course_to_cate',$dataInsert);
        }
    }

    /**
    * @author: namtq
    * @todo: Get all cate of course
    * @param: course_id
    */
    public function get_cate_by_course($course_id){
        $this->db->select('cate_id');
        $this->db->where('course_id',$course_id);
        $query = $this->db->get('course_to_cate');
        return $query->result_array();
    }
    
    //Hoanv
    public function get_documents_by_course($course_id){
        $this->db->select('n.news_id, n.title');
        $this->db->join('news as n', 'n.news_id = cd.document_id');
        $this->db->where('cd.course_id',$course_id);
        $query = $this->db->get('course_to_documents as cd');
        return $query->result_array();
    }

    public function get_test_by_course($course_id){
        $this->db->select('n.test_id, n.title');
        $this->db->join('test as n', 'n.test_id = ct.test_id');
        $this->db->where('ct.course_id',$course_id);
        $query = $this->db->get('course_to_test as ct');
        return $query->result_array();
    }

    public function get_test_by_course_class($course_class_id){
        $this->db->select('n.test_id, n.title');
        $this->db->join('test as n', 'n.test_id = ct.test_id');
        $this->db->where('ct.course_class_id',$course_class_id);
        $query = $this->db->get('course_class_to_test as ct');
        return $query->result_array();
    }

    /////////////////////COURSE TO USERS //////////////////////////
    public function get_users_by_course($course_id, $params = array()){
        $this->db->join('users as n', 'n.user_id = cu.user_id');
        $this->db->where('cu.course_id',$course_id);
        if($params['test_id']){             //Trường hợp chấm điểm của bài test
            $this->db->join('test_logs as tl', 'tl.user_id = cu.user_id and tl.test_id = '.$params['test_id']);
            $this->db->select('cu.course_id, n.user_id, n.fullname, n.email, n.active, n.phone, n.create_time, tl.score as point');
        }else{
            $this->db->select('cu.course_id, n.user_id, n.fullname, n.email, n.active, n.phone, n.create_time');
        }
        $query = $this->db->get('course_to_user as cu');
        return $query->result_array();
    }

    public function insert_course_to_user($course_id, $user_id){
        $this->db->where('course_id',$course_id);
        $this->db->where('user_id',$user_id);
        $query = $this->db->get('course_to_user',1);
        if($query->row_array()){
            return false;
        }
        $input = array(
            'course_id' => $course_id,
            'user_id' => $user_id,
        );
        $this->db->insert('course_to_user', $input);
        return TRUE;
    }

    public function users_delete($arrId){
        if(is_array($arrId)){
            foreach ($arrId as $item) {
                list($course_id, $user_id) = explode('|', $arrId);
                $this->db->where('course_id',$course_id);
                $this->db->where('user_id',$user_id);
                $this->db->delete('course_to_user');
            }
        }else{
            list($course_id, $user_id) = explode('|', $arrId);
            $this->db->where('course_id',$course_id);
            $this->db->where('user_id',$user_id);
            $this->db->delete('course_to_user');
        }
        return $course_id;
    }

    /**
    * @author: hoanguyen
    * @todo: Get all score of users in course
    * @param: arr_user_id: array; $arr_test_id: array
    */
    public function get_user_score_by_course($arr_user_id = array(), $arr_test_id = array()){
        if(empty($arr_user_id) || empty($arr_test_id)){
            return NULL;
        }
        $this->db->select('t.*');
        $this->db->join('(SELECT max(logs_id) as maxlog FROM test_logs where user_id in ('.implode(',', $arr_user_id).') and test_id in ('.implode(',', $arr_test_id).') GROUP BY user_id, test_id) as tl','t.logs_id = tl.maxlog');
        $this->db->group_by('user_id, test_id');
        $query = $this->db->get('test_logs as t');
        return $query->result_array();
    }
}