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
        if (isset($params['manager_email'])){
            $this->db->where_in('manager_email', $params['manager_email']);
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

    public function get_class_info_where_in_teacher_id($arr_teacher_id,$class_info_select, $params = array() ){
        $this->db->select($class_info_select);
        if($arr_teacher_id && count($arr_teacher_id) > 0) {
            $this->db->where_in('main_teacher', $arr_teacher_id);
        }
        if ((isset($params['min_opening'])) && ($params['min_opening'] != '')) {
            $this->db->where('opening_day >=', $params['min_opening']);
        }
        if (isset($params['max_opening']) && (($params['max_opening'] != ''))) {
            $this->db->where('opening_day <=', $params['max_opening']);
        }
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
        if (isset($params['manager_email'])){
            $this->db->where_in('feedback_teacher.manager_email', $params['manager_email']);
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

    public function get_list_feedback_phone_export_by_class($params)
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
        $this->db->select('MAX(fb.times) as times,MAX(fb.time) as time, MAX(ft.name) as teacher_name, ft.manager_email as manager_email, fc.class_code, fl.name, fl.area, AVG(fb.point) AS point');
        $this->db->join("feedback_class as fc","fb.class_code = fc.class_code");
        if (isset($params['location']) && count($params['location']) > 0){
            $this->db->where_in("fc.id_location",$params['location']);
        }
        if (isset($params['area']) && count($params['area']) > 0){
            $this->db->where_in("fl.area",$params['area']);
        }
        $this->db->join("feedback_location as fl","fc.id_location = fl.id");
        $this->db->order_by("MAX(fb.id)","desc");
        $this->db->join('feedback_teacher as ft', 'fc.main_teacher=ft.teacher_id');
        $query = $this->db->get("feedback_phone as fb");
        $arr_res = $query->result_array();
        return $arr_res;
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
        $this->db->select('fb.times as times, fb.time as time, fb.comment, ft.name as teacher_name, ft.manager_email as manager_email, fc.class_code, fl.name, fl.area, fb.point, fb.name_feeder');
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

        if(!empty($params['starttime']) && $params['starttime'] > 0) {
            $this->db->where('fk.time_end >', $params['starttime']);
        }
        if(!empty($params['endtime']) && $params['endtime'] > 0) {
            $this->db->where('fk.time_end < ', $params['endtime'] + 86400);
        }

        // type
        if (isset($params['type_ksgv'])){
            $this->db->where('fk.type',$params['type_ksgv']);
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
        $this->db->select("fk.*, fl.name, fl.area, ft.name as teacher_name, ft.manager_email as manager_email");
        if (isset($params['manager_email'])){
            $this->db->where_in('ft.manager_email', $params['manager_email']);
        }
        $r = $this->db->get('feedback_ksgv as fk');
        return $r->result_array();
    }

    public function get_teacher_manager(){
        $this->db->where('manager_email is not null');
        $this->db->group_by('manager_email');
        $this->db->select("manager_email");
        $r = $this->db->get('feedback_teacher');
        return $r->result_array();
    }

    /**
     * Hàm get log đăng ký luyện đề cho chi tiết 1 lớp học (có chọn level co_ban - nang_cao)
     * Nếu ko truyền vào class_code thì sẽ lấy theo thứ tự mới nhất
     * @param string $class_code
     * @param string $level
     * @param array $option (limit => 100)
     * @return array
     */
    public function get_log_luyende_class($class_code='',$level='',$option=array()){
        if ($class_code != ''){
            $this->db->where('class_code',$class_code);
        }

        if ($level != ''){
            $this->db->where('level',$level);
        }

        if (isset($option['limit'])){
            $this->db->limit($option['limit']);
        }
        $r = $this->db->get('feedback_luyende');
        return $r->result_array();

    }


    /**
     * Hàm get log đăng ký luyện đề theo params truyền vào
     * by HieuTH
     * @param $params array(area,limit)
     * @return array group by class
     */
    public function get_log_luyende_filter_by_class($params = array()){
        $params = array_merge(array('limit' => 500 ), $params);
        if (isset($params['limit'])){
            $this->db->limit($params['limit']);
        }
        $this->db->select("fc.level, fc.class_code, ft.name as teacher_name, flo.name as loca_name, fc.time_end as time_end_class, fc.number_student, COUNT(IF(fld.level NOT IN ('co_ban', 'nang_cao'),1,null)) AS number_student_giaotiep, COUNT(IF(fld.level='co_ban',1,null)) AS number_student_coban, COUNT(IF(fld.level='nang_cao',1,null)) AS number_student_nangcao");
        $this->db->join("feedback_class as fc","fc.class_code = fld.class_code");
        if (isset($params['area'])){
            $this->db->where("flo.area",$params['area']);
        }
        $this->db->join("feedback_location as flo","fc.id_location = flo.id");
        $this->db->join("feedback_teacher as ft","ft.teacher_id = fc.main_teacher");
        $this->db->group_by('fc.class_code');
        $r = $this->db->get('feedback_luyende as fld');
        return $r->result_array();

    }


    /**
     * Hàm get log đăng ký luyện đề theo params truyền vào
     * by HieuTH
     * @param $params array(type,level)
     * @return array
     */
    public function get_log_luyende_filter($params = array()){
        $params = array_merge(array('limit' => 500 ), $params);
        if (isset($params['limit'])){
            $this->db->limit($params['limit']);
        }
        if (isset($params['type'])){
            $this->db->where("fld.type",$params['type']);
        }
        if (isset($params['level'])){
            $this->db->where("fld.level",$params['level']);
        }
        $this->db->select("fld.class_code, fld.hoten, fld.phone, fld.email, fld.shift, flo.name as location, flo.area");
        $this->db->join("feedback_class as fc","fc.class_code = fld.class_code");
        $this->db->join("feedback_location as flo","fc.id_location = flo.id");
        $this->db->order_by("fld.id","desc");
        $r = $this->db->get('feedback_luyende as fld');
        return $r->result_array();

    }


    /**
     * Hàm get số lượng fb phone theo từng lớp
     * @param $params (course_id)
     * by HieuTH
     * @return array
     */
    public function get_total_fb_phone_by_class($params = array()){
        $this->db->select("fc.class_id, COUNT(fc.class_id) AS number_fb");
        $this->db->join("feedback_class as fc","fc.class_code = fp.class_code");
        if (isset($params['class_id'])){
            $this->db->where_in('fc.class_id', $params['class_id']);
        }
        if(!empty($params['starttime']) && $params['starttime'] > 0) {
            $this->db->where('fp.time >', $params['starttime']);
        }
        if(!empty($params['endtime']) && $params['endtime'] > 0) {
            $this->db->where('fp.time < ', $params['endtime'] + 86400);
        }
        $this->db->group_by('fc.class_id');
        $r = $this->db->get('feedback_phone as fp');
        return $r->result_array();
    }


    /**
     * Hàm get số lượng fb ksgv theo từng lớp
     * @param $params (course_id)
     * by HieuTH
     * @return array
     */
    public function get_total_fb_ksgv_by_class($params = array()){
        $this->db->select("fc.class_code, fc.class_id, COUNT(fc.class_id) AS number_fb");
        $this->db->join("feedback_class as fc","fc.class_code = fk.class_code");
        if (isset($params['class_id'])){
            if (is_array($params['class_id'])){
                if(count($params['class_id']) > 0) {
                    $this->db->where_in('fc.class_id', $params['class_id']);
                }
            }else{
                $this->db->where('fc.class_id',$params['class_id']);
            }

        }if (isset($params['type_ksgv'])){
            $this->db->where('fk.type', $params['type_ksgv']);
        }
        if(!empty($params['starttime']) && $params['starttime'] > 0) {
            $this->db->where('fk.time_end > ', $params['starttime']);
        }
        if(!empty($params['endtime']) && $params['endtime'] > 0) {
            $this->db->where('fk.time_end < ', $params['endtime'] + 86400);
        }
        $this->db->group_by('fc.class_id');
        $r = $this->db->get('feedback_ksgv as fk');
        return $r->result_array();
    }

    /**
     * Hàm get log đăng ký thi cuối kỳ theo params truyền vào
     * by HieuTH
     * @param $params array(area)
     * @return array group by class
     */
    public function get_log_thicuoiky_filter_by_class($params = array()){
        $this->db->select("fc.class_code, ft.name as teacher_name, flo.name as loca_name, fc.time_end as time_end_class, fc.number_student, fc.number_thicuoiky");
        $this->db->join("feedback_class as fc","fc.class_code = ftck.class_code");
        if (isset($params['area'])){
            $this->db->where("flo.area",$params['area']);
        }
        if (isset($params['class_code'])){
            $this->db->where("fc.class_code",$params['class_code']);
        }
        $this->db->join("feedback_location as flo","fc.id_location = flo.id");
        $this->db->join("feedback_teacher as ft","ft.teacher_id = fc.main_teacher");
        $this->db->group_by('fc.class_code');
        $r = $this->db->get('feedback_thicuoiky as ftck');
        return $r->result_array();
    }

    /**
     * Hàm get log đăng ký thi cuối kỳ theo params truyền vào
     * by HieuTH
     * @param $params array(type)
     * @return array
     */
    public function get_log_thicuoiky_filter($params = array()){
        if (isset($params['type'])){
            $this->db->where("ftck.type",$params['type']);
        }
        if (isset($params['class_code'])){
            $this->db->where("fc.class_code",$params['class_code']);
        }
        $this->db->select("ftck.class_code, ftck.hoten, ftck.phone, ftck.email, ftck.shift, flo.name as location, flo.area");
        $this->db->join("feedback_class as fc","fc.class_code = ftck.class_code");
        $this->db->join("feedback_location as flo","fc.id_location = flo.id");
        $this->db->order_by("ftck.id","desc");
        $r = $this->db->get('feedback_thicuoiky as ftck');
        return $r->result_array();
    }

    public function get_teacher_by_class_code($class_code)
    {
        $this->db->join("feedback_teacher as ft","fc.main_teacher = ft.teacher_id");
        $this->db->where("fc.class_code",$class_code);
        $this->db->select("ft.*");
        $r = $this->db->get('feedback_class as fc');
        return $r->row_array();
    }

    public function get_location_by_class_code($class_code)
    {
        $this->db->join("feedback_location as fl","fc.id_location = fl.id");
        $this->db->where("fc.class_code",$class_code);
        $this->db->select("fl.*");
        $r = $this->db->get('feedback_class as fc');
        return $r->row_array();
    }

    public function get_type_class_by_class_code($class_code)
    {
        $this->db->where('class_code', $class_code);
        $this->db->select('type');
        $query = $this->db->get('feedback_class');
        $arr_res = $query->row_array();
        return $arr_res;
    }

}
