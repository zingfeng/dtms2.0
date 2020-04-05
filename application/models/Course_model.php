<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Course_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }
    public function detail($course_id,$option = array()){
        $this->db->select('n.*,t.name as teacher_name, t.description as teacher_description, t.images as teacher_images, t.share_url as teacher_share_url,v.title as video_title, v.images as video_images, v.vimeo_id, v.youtube_id');
        $this->db->where_in('n.course_id',$course_id);
        $this->db->where('n.publish',1);
        $this->db->join('expert as t','t.expert_id = n.teacher_id', 'LEFT');
        $this->db->join('video as v','v.video_id = n.video_id', 'LEFT');
        $query = $this->db->get('course as n');
        if (is_array($course_id)) {
            return $query->result_array();
        }
        else {
            return $query->row_array();
        }
    }
    public function getCourse($params = array()) {
        $params = array_merge(array('limit' => 10,'offset' => 0),$params);
        $this->db->where('c.publish',1);
        $this->db->select('c.*');
        if($params['price'] !== NULL){
            $this->db->where('c.price',$params['price']);
        }
        if($params['user_id']){
            $this->db->where('cu.user_id',$params['user_id']);
            $this->db->join('course_to_user as cu','cu.course_id = c.course_id');
        }
        $this->db->order_by('publish_time', DESC);
        if($params['limit'] == 1) { 
            $query = $this->db->get('course as c');
            return $query->row_array();
        }else{
            $query = $this->db->get('course as c',$params['limit'],$params['offset']);
            return $query->result_array();
        }
        
    }
    //////////////////TOPIC////////////////////////
    public function get_lists_topic($course_id){
        $this->db->select('topic_id,course_id,name,share_url,price,price_discount');
        $this->db->where('course_id',$course_id);
        $this->db->order_by('ordering');
        $query = $this->db->get('course_topic');
        return $query->result_array();
    }

    public function get_topic_detail($topic_id){
        $this->db->where_in('topic_id',$topic_id);
        $query = $this->db->get('course_topic as n');
        if (is_array($topic_id)) {
            return $query->result_array();
        }
        else {
            return $query->row_array();
        }
    }

    //////////////CLASS/////////////////////
    public function get_lists_class($arrID,$option = array()){
        $this->db->where_in('topic_id',$arrID);
        if($option['video_info']){
            $this->db->select('course_class.*,video.video_time');
            $this->db->join('video','video.video_id = course_class.video_id','LEFT');
        }
        if($option['user_id']){
            $this->db->select('course_class.*, uc.user_id');
            $this->db->join('users_to_class as uc','uc.class_id = course_class.class_id','LEFT');
            if($option['learned'] === 0){        //Chưa học
                $this->db->where('uc.user_id is NULL or uc.user_id <> '.$option['user_id']);
                $this->db->group_by('class_id');
            }elseif($option['learned'] == 1){
                $this->db->where('uc.user_id', $option['user_id']);     //Đã học
            }elseif($option['type']){
                $this->db->where('course_class.type', $option['type']);
            }elseif($option['all']){
                $this->db->group_by('class_id');
            }else{
                $this->db->where('(uc.user_id = ' . $option['user_id'] . ' or uc.user_id is NULL)');
            }
        }
        $query = $this->db->get('course_class');
        return $query->result_array();
    }

    public function get_class_detail($class_id){
        $this->db->select('n.*,v.title as video_title, v.images as video_images, v.vimeo_id, v.youtube_id');
        $this->db->where('class_id',$class_id);
        $this->db->join('video as v','v.video_id = n.video_id', 'LEFT');
        $query = $this->db->get('course_class as n');
        return $query->row_array();
    }

    /**
     * @author: Namtq
     * @desc: update số lần xem
     */
    public function count_hit($id){
        $this->db->where('course_id',$id);
        $this->db->set('hit','hit + 1',FALSE);
        $this->db->update('course');
    }

    /**
     * @author: Namtq
     * @todo: Get course by special
     * @param: array(position,limit,offset)
     */
    public function get_buildtop($params) {
        $params = array_merge(array("limit" => 10, "offset" => 0),$params);
        $this->db->select('p.course_id, p.title, p.description, p.share_url, p.images, p.price,p.number_lesson,p.rate,t.name as teacher_name, t.share_url as teacher_share_url');
        $this->db->where('b.position',$params['position']);
        $this->db->where('b.type','course');
        $this->db->join("course as p",'p.course_id = b.item_id');
        $this->db->join("teacher as t","t.teacher_id = p.teacher_id");
        $this->db->order_by('b.ordering');
        $query = $this->db->get('build_top as b',$params['limit'],$params['offset']);
        return $query->result_array();
    }

    public function get_cate_show_home(){
        $this->db->select('cate_id,name');
        $this->db->where('type',1);
        $this->db->where('show_home',1);
        $this->db->order_by('ordering','ASC');
        $query = $this->db->get('category');
        return $query->result_array();
    }

    //Get khóa học liên quan
    public function lists_related($params){
        $params_default = array("id" => 0, "course_id" => 0, "cate_id" => 0, "limit" => 10,"offset" => 0);
        $params = array_merge($params_default, $params);
        
        $this->db->select('n.course_id,n.title,n.images,n.description,n.share_url,n.original_cate,n.price,n.number_lesson,n.rate');
        $this->db->where('n.publish',1);
        if ($params['cate_id']){
            $this->db->join('course_to_cate as t','t.course_id = n.course_id');
            $this->db->where("t.cate_id", $params['cate_id']);
        }
        if($params['course_id']){
            $this->db->where('n.course_id <>'. $params['course_id']);
        }
        $this->db->order_by('publish_time','DESC');
        $query = $this->db->get('course as n',(int) $params['limit'],(int)$params['offset']);
        return $query->result_array();

        return $result;
    }

    //Lưu khóa học
    public function save_course_to_user($course_id, $user_id){
        $this->db->where('user_id',$user_id);
        $this->db->where('course_id',$course_id);
        $this->db->delete('course_to_user');

        $input = array(
            'course_id' => $course_id,
            'user_id' => $user_id,
        );
        // insert data
        $this->db->insert('course_to_user', $input);
        return TRUE;
    }

    public function get_course_to_user($user_id){
        $this->db->select('course_id');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('course_to_user');
        return $query->result_array();
    }

    //Get unit liên quan
    public function class_relate($params){
        $params_default = array("class_id" => 0, "topic_id" => 0, "limit" => 10,"offset" => 0);
        $params = array_merge($params_default, $params);

        $this->db->select('n.class_id,n.title,n.images,n.description,n.share_url');
        if ($params['topic_id']){
            $this->db->where("n.topic_id", $params['topic_id']);
        }
        switch ($params['type']) {
            case 'next':
                $this->db->where('class_id >',$params["class_id"]);
                break;
            case 'prev':
                $this->db->where('class_id <',$params["class_id"]);
                break;
            case 'present':
                $this->db->where('class_id =',$params["class_id"]);
                break;
            default:
                $this->db->where('class_id <>',$params["class_id"]);
                break;
        }
        $this->db->order_by('publish_time', $params['sort']);
        $query = $this->db->get('course_class as n',(int) $params['limit'],(int)$params['offset']);
        return $query->row_array();
    }
}