<?php

class Feed_upgrade_model extends CI_Model{

    public function get_list_id_teacher_to_info($params = []){
        $this->db->select('teacher_id,name');
        $params =array_merge(array('limit' => 30), $params);
        if (isset($params['limit'])){
            $this->db->limit($params['limit']);
        }
        if (isset($params['teacher_name'])){
            $this->db->like('name', $params['teacher_name']);
        }
        if (isset($params['teacher_id_list'])){
            $this->db->where_in('teacher_id', $params['teacher_id_list']);
        }

        $query = $this->db->get('feedback_teacher');
        $teacher_info = $query->result_array();
        $teacher_id_to_name = array();
        for ($k = 0; $k < count($teacher_info); $k++) {
            $id_teacher = $teacher_info[$k]['teacher_id'];
            $teacher_id_to_name[$id_teacher] = $teacher_info[$k]['name'];
        }
        return $teacher_id_to_name;
    }

    public function get_list_bell($user_id_filter = null)
    {
        $this->db->select('feedback_bell.*, feedback_user.fullname, feedback_class.class_code');
        $this->db->from('feedback_bell');
        if (! is_null($user_id_filter)){
            $this->db->where('user_id_creat',$user_id_filter);
        }
        $this->db->join('feedback_user', 'feedback_bell.user_id_creat = feedback_user.id');
        $this->db->join('feedback_class', 'feedback_bell.class_id = feedback_class.class_id');
        $this->db->limit(100);
        $this->db->order_by('time', 'DESC');
        $query = $this->db->get();
        $arr_res = $query->result_array();
        return $arr_res;
    }

    public function get_class_info_where_in_teacher_id($arr_teacher_id,$class_info_select ){
        $this->db->select($class_info_select);
        $this->db->where_in('main_teacher', $arr_teacher_id);
        $this->db->order_by("main_teacher",'DESC');
        $query = $this->db->get('feedback_class');
        $arr_res = $query->result_array();

        $arr_teacher_id_to_list_class = [];
        for ($i = 0; $i < count($arr_res); $i++) {
            $main_teacher = $arr_res[$i]['main_teacher'];
            $arr_teacher_id_to_list_class[$main_teacher][] = $arr_res[$i];
        }
        return $arr_teacher_id_to_list_class;
    }

    public function get_point_fb_ksgv_by_list_class_code($list_class_code){
        if (count($list_class_code) == 0) return 0;

        $this->db->where_in('class_code',$list_class_code);
        $query = $this->db->get('feedback_ksgv');
        $data = $query->result_array();

        // =================

        $mono_point_about_teacher = []; // tính trung bình của từng lớp trước => class_code => list val

        foreach ($data as $mono) {
            $mono_record = json_decode($mono['detail'], true);
            $class_code_m = $mono['class_code'];
            foreach ($mono_record as $mono_quest) {
                $id_quest = $mono_quest[0];
//                $type = $mono_quest[1];
                $content = $mono_quest[2];
                $point = (int) $mono_quest[3];
                if (($id_quest == 209 && mb_strtolower(trim($content)) == '10. bạn sẽ đánh giá giáo viên của mình bao nhiêu điểm') ||
                    ($id_quest == 206 && mb_strtolower(trim($content)) == '7. bạn sẽ đánh giá giáo viên của mình bao nhiêu điểm')){
                    if (isset($mono_point_about_teacher[$class_code_m])){
                        $mono_point_about_teacher[$class_code_m][] = $point;
                    }else{
                        $mono_point_about_teacher[$class_code_m] = [$point];
                    }
                    break;
                }
            }
        }

        $list_fb_point_class = [];
        foreach ($mono_point_about_teacher as $class_code__ => $list_val){
            $list_fb_point_class[$class_code__] = tbc($list_val,false,5);
        }
        return $list_fb_point_class;
    }

    public function get_location_point_full(){
        $this->db->select("feedback_class.id_location,feedback_location.name, COUNT(feedback_class.class_id) AS 'soluonglop' , AVG(feedback_class.average_point) AS 'diemtrungbinh'");
        $this->db->from('feedback_class');
        $this->db->join('feedback_location', 'feedback_class.id_location=feedback_location.id', 'left');
        $this->db->group_by("feedback_class.id_location");
        $this->db->order_by("diemtrungbinh","desc");
        $r = $this->db->get();
        return $r->result_array();
    }

    public function get_fb_phone($params){
        if (isset($params['limit'])){
            $this->db->limit($params['limit']);
        }

        if (isset($params['teacher_name'])){
            $this->db->like('feedback_teacher.name', $params['teacher_name']);
        }
        if (isset($params['class_code'])){
            if (is_array($params['class_code'])){
                $this->db->where_in('feedback_phone.class_code',$params['class_code']);
            }else{
                $this->db->where('feedback_phone.class_code',$params['class_code']);
            }
        }
        if(!empty($params['starttime']) && $params['starttime'] > 0) {
            $this->db->where('feedback_phone.time >', $params['starttime']);
        }
        if(!empty($params['endtime']) && $params['endtime'] > 0) {
            $this->db->where('feedback_phone.time < ', $params['endtime'] + 86400);
        }
        if (isset($params['location']) && count($params['location']) > 0){
            $this->db->where_in("feedback_class.id_location",$params['location']);
        }

        $this->db->from('feedback_phone');
        $this->db->join('feedback_class', 'feedback_phone.class_code=feedback_class.class_code');
        $this->db->join('feedback_teacher', 'feedback_class.main_teacher=feedback_teacher.teacher_id');

        if (isset($params['area']) && count($params['area']) > 0){
            $this->db->where_in("feedback_location.area",$params['area']);
            $this->db->join('feedback_location','feedback_class.id_location = feedback_location.id');
        }
        $this->db->select("feedback_phone.id, feedback_phone.class_code, feedback_phone.times,feedback_phone.time, feedback_phone.comment, feedback_phone.point, feedback_phone.name_feeder, feedback_class.main_teacher,feedback_class.id_location, feedback_teacher.name ");

        $this->db->order_by("feedback_phone.id",'DESC');
        $r = $this->db->get();
        return $r->result_array();
    }

    public function get_list_feedback_phone_export($params)
    {
        if(!empty($params['starttime']) && $params['starttime'] > 0) {
            $this->db->where('fb.time >', $params['starttime']);
        }
        if(!empty($params['endtime']) && $params['endtime'] > 0) {
            $this->db->where('fb.time < ', $params['endtime'] + 86400);
        }
        if (isset($params['teacher_name'])){
            $this->db->like('ft.name', $params['teacher_name']);
        }
        if (isset($params['class_code'])){
            if (is_array($params['class_code'])){
                $this->db->where_in('fb.class_code',$params['class_code']);
            }else{
                $this->db->where('fb.class_code',$params['class_code']);
            }
        }

        if (isset($params['limit'])){
            $this->db->limit($params['limit']);
        }

        $this->db->group_by('fb.class_code');
        $this->db->select('MAX(fb.times) as times,MAX(fb.time) as time, ft.name as teacher_name, fc.class_code, fl.name, fl.area, AVG(fb.point) AS point');
        $this->db->join("feedback_class as fc","fb.class_code = fc.class_code");
        if (isset($params['location']) && count($params['location']) > 0){
            $this->db->where_in("fc.id_location",$params['location']);
        }
        if (isset($params['area']) && count($params['area']) > 0){
            $this->db->where_in("fl.area",$params['area']);
            $this->db->join("feedback_location as fl","fc.id_location = fl.id");
        }
        $this->db->order_by("fb.id","desc");
        $this->db->join('feedback_teacher as ft', 'fc.main_teacher=ft.teacher_id');
        $query = $this->db->get("feedback_phone as fb");
        $arr_res = $query->result_array();
        return $arr_res;
    }

    public function get_feedback_ksgv($params){
        $this->db->order_by("fk.id","desc");
        if (isset($params['limit'])){
            $this->db->limit($params['limit']);
        }
        // type
        if (isset($params['type'])){
            $this->db->where('fk.type',$params['type']);
        }

        $this->db->join("feedback_class as fc","fk.class_code = fc.class_code");
        $this->db->join("feedback_location as fl","fc.id_location = fl.id");

        if (isset($params['location']) && count($params['location']) > 0){
            $this->db->where_in("fc.id_location",$params['location']);
        }
        if (isset($params['area']) && count($params['area']) > 0){
            $this->db->where_in("fl.area",$params['area']);
        }
        if (isset($params['class_code'])){
            $this->db->where('fk.class_code',$params['class_code']);
        }
        $this->db->join('feedback_teacher as ft', 'fc.main_teacher=ft.teacher_id');
        $this->db->select("fk.*, fl.name, fl.area, ft.name as teacher_name");

        $r = $this->db->get('feedback_ksgv as fk');
        return $r->result_array();
    }
}
