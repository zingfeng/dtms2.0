<?php
/**
 * Created by PhpStorm.
 * User: Zingfeng-Dragon
 * Date: 29/7/2018
 * Time: 11:27 PM
 */

class Feedback_model extends CI_Model
{
    public function _tracking_func($func_name){
        $query = $this->db->where('func_name', $func_name)->limit(1)->get('func_tracking');
        $arr_res = $query->result_array();
        if ( is_array($arr_res) && (count($arr_res) > 0) ){
            $this->db->set('count', 'count + 1', FALSE);
            $this->db->where('func_name', $func_name);
            $this->db->update('func_tracking');
        }else{
            $data = [
                'func_name' => $func_name,
                'count' => 1
            ];
            $this->db->insert('func_tracking', $data);
        }
    }

    // INFO chung

    public function get_all_info_system()
    {
        $this->_tracking_func(__FUNCTION__);

        // count class,teacher , feedback,
        $count_class = $this->db->count_all('feedback_class');
        $count_teacher = $this->db->count_all('feedback_teacher');
        $count_paper = $this->db->count_all('feedback_paper');

        return array(
            'count_class' => $count_class,
            'count_teacher' => $count_teacher,
            'count_paper' => $count_paper,
        );

    }

    public function get_all_info_system_by_type($type)
    {
        $this->_tracking_func(__FUNCTION__);

        // count class,teacher , feedback,
        $count_class = $this->db->count_all('feedback_class');
        $count_teacher = $this->db->count_all('feedback_teacher');
        $count_paper = $this->db->count_all('feedback_paper');

        return array(
            'count_class' => $count_class,
            'count_teacher' => $count_teacher,
            'count_paper' => $count_paper,
        );

    }

    public function get_list_class_code($type = '')
    {
        $this->_tracking_func(__FUNCTION__);

        if ($type != '') {
            $this->db->where('type', $type);
        }

        $this->db->select('class_code'); //zfdev
        $this->db->limit(100);
        $query = $this->db->get('feedback_class');
        $arr_res = $query->result_array();
        return $arr_res;
    }

    public function get_list_class_out_of_date()
    {
        $this->_tracking_func(__FUNCTION__);


        $this->db->where('c.opening_day >', date("Y-m-d", strtotime("-3 month")));
        $this->db->where('c.time_feedback1 <=', strtotime(date("Y-m-d 23:59:59")));
        $this->db->where('fb.id', null);
        $this->db->where('ksgv.id', null);
        $this->db->select('c.class_id, c.type, c.class_code, c.list_teacher, c.opening_day, c.time_feedback1, c.time_feedback2, lo.name, lo.area');

        $this->db->join("feedback_phone as fb","fb.class_code = c.class_code", 'left');
        $this->db->join("feedback_ksgv as ksgv","ksgv.class_code = c.class_code", 'left');
        $this->db->join("feedback_location as lo","lo.id = c.id_location");

        $this->db->order_by('c.time_feedback1', 'DESC');
        $query = $this->db->get('feedback_class as c');
        $arr_res = $query->result_array();
        return $arr_res;
    }

    public function get_list_class_survey()
    {
        $this->_tracking_func(__FUNCTION__);


        $this->db->where('(c.time_feedback1 >'. strtotime(date("Y-m-d 23:59:59")) .' AND' . ' c.time_feedback1 <='. strtotime(date("Y-m-d", strtotime("+1 week"))) . ')');
        $this->db->or_where('(c.time_feedback2 >'. strtotime(date("Y-m-d 23:59:59")) .' AND' . ' c.time_feedback2 <='. strtotime(date("Y-m-d", strtotime("+1 week"))) . ')');
        $this->db->select('c.class_id, c.type, c.class_code, c.list_teacher, c.opening_day, c.time_feedback1, c.time_feedback2, lo.name, lo.area');

        $this->db->join("feedback_location as lo","lo.id = c.id_location");

        $this->db->order_by('c.time_feedback1', 'ASC');
        $query = $this->db->get('feedback_class as c');
        $arr_res = $query->result_array();
        return $arr_res;
    }

    public function get_list_class_code_by_location($id_location, $type = '')
    {
        $this->_tracking_func(__FUNCTION__);

        if ($type != '') {
            $this->db->where('type', $type);
        }
        $this->db->where('id_location', $id_location);
        $this->db->select('class_code');
        $this->db->limit(200);
        $query = $this->db->get('feedback_class');
        $arr_res = $query->result_array();
        return $arr_res;
    }

    public function get_list_class_code_opening($type = '')
    {
        $this->_tracking_func(__FUNCTION__);

        if ($type != '') {
            $this->db->where('type', $type);
        }

        $this->db->select('*');
        // ==========
        $this->db->limit(20);
        $this->db->where('time_end >', time());
        //=========
        $query = $this->db->get('feedback_class');
        $arr_res = $query->result_array();

        $arr_res_living = array();
        for ($i = 0; $i < count($arr_res); $i++) {
            array_push($arr_res_living, $arr_res[$i]);
        }

        return $arr_res_living;
    }

    public function get_list_class_info($type = '', $limit = 100)
    {
        $this->_tracking_func(__FUNCTION__);

        if ($type != '') {
            $this->db->where('type', $type);
        }
        $this->db->select('*');
        $this->db->limit($limit);
        $this->db->order_by('class_id', 'DESC');
        $query = $this->db->get('feedback_class');
        $arr_res = $query->result_array();
        return $arr_res;
    }

    public function get_list_class_code_zoom($limit = 300)
    {
        $this->_tracking_func(__FUNCTION__);
        $this->db->select('class_code');
        $this->db->limit($limit);
        $this->db->order_by('class_id', 'DESC');
        $query = $this->db->get('feedback_class');
        $arr_res = $query->result_array();
        return $arr_res;
    }
    public function get_list_class_code_zoom_filter($params)
    {
        $params = array_merge(array('limit' => 100, 'offset' => 0), $params);
        if ($params['keyword']){
            $this->db->like('class_code',$params['keyword']);
        }
        $this->db->select('class_code');
        $this->db->order_by('class_id', 'DESC');
        $query = $this->db->get('feedback_class', $params['limit'], $params['offset']);
        $arr_res = $query->result_array();
        return $arr_res;
    }

    public function get_list_class_filter($params)
    {
        $this->_tracking_func(__FUNCTION__);


        if ($params['type'] != '') {
            $this->db->where_in("type",$params['type']);
        }
        if ($params['class_code'] != '') {
            $this->db->like("class_code",$params['class_code']);
        }
        if ($params['location'] != '') {
            $this->db->where_in("id_location",$params['location']);
        }
        if (isset($params['min']) && $params['min'] !== '') {
            $this->db->where("average_point >=",$params['min']);
        }
        if (isset($params['max']) && $params['max'] !== '') {
            $this->db->where("average_point <=",$params['max']);
        }

        if((isset($params['fb_type']) && $params['fb_type'] == 'phone') && ((isset($params['starttime']) && $params['starttime'] > 0) || (isset($params['endtime']) && $params['endtime'] > 0))) {
            if(isset($params['starttime']) && $params['starttime'] > 0) {
                $this->db->where('fp.time > ', $params['starttime']);
            }
            if(isset($params['endtime']) && $params['endtime'] > 0) {
                $this->db->where('fp.time < ', $params['endtime'] + 86400);
            }
            $this->db->join("feedback_phone as fp","feedback_class.class_code = fp.class_code");
            $this->db->group_by('feedback_class.class_id');
        }

        if((isset($params['fb_type']) && $params['fb_type'] == 'ksgv') && ((isset($params['starttime']) && $params['starttime'] > 0) || (isset($params['endtime']) && $params['endtime'] > 0))) {
            if(isset($params['starttime']) && $params['starttime'] > 0) {
                $this->db->where('fk.time_end > ', $params['starttime']);
            }
            if(isset($params['endtime']) && $params['endtime'] > 0) {
                $this->db->where('fk.time_end < ', $params['endtime'] + 86400);
            }
            $this->db->join("feedback_ksgv as fk","feedback_class.class_code = fk.class_code");
            $this->db->group_by('feedback_class.class_id');
        }

        if (isset($params['limit']) ) {
            $this->db->limit($params['limit']);
        }else{
            $this->db->limit(500); // normal
        }

        if (isset($params['manager_email'])){
            $this->db->where_in('feedback_teacher.manager_email', $params['manager_email']);
            $this->db->join('feedback_teacher', 'feedback_class.main_teacher=feedback_teacher.teacher_id');
        }

        $this->db->select('feedback_class.*');
        $this->db->order_by('class_id', 'DESC');
        $query = $this->db->get('feedback_class');
        $arr_res = $query->result_array();
        return $arr_res;
    }

    public function get_list_class_info_by_time($type = '', $params = array())
    {
        $this->_tracking_func(__FUNCTION__);

        if ($type != '') {
            $this->db->where('type', $type);
        }
        if ((isset($params['min_opening'])) && ($params['min_opening'] != '')) {
            $this->db->where('opening_day >=', $params['min_opening']);
        }
        if (isset($params['max_opening']) && (($params['max_opening'] != ''))) {
            $this->db->where('opening_day <=', $params['max_opening']);
        }

        $this->db->select('*');
        $this->db->limit(300);
        $query = $this->db->get('feedback_class');
        $arr_res = $query->result_array();
        return $arr_res;
    }


    public function insert_teacher($info)
    {
        $this->_tracking_func(__FUNCTION__);

        $plus = array(
            'time_creat' => time(),
        );
        $data = array_merge($info, $plus);
        $this->db->insert('feedback_teacher', $data);
    }

    public function update_teacher($info)
    {
        $this->_tracking_func(__FUNCTION__);

//        var_dump($info);
        $this->db->where('teacher_id', $info['teacher_id']);
        $this->db->replace('feedback_teacher', $info);
    }

    public function del_teacher($info)
    {
        $this->_tracking_func(__FUNCTION__);

        echo 'model del';
        $this->db->delete('feedback_teacher', array('teacher_id' => $info['teacher_id']));
    }

    public function insert_class($info)
    {
        $this->_tracking_func(__FUNCTION__);

        $this->db->select('class_id,class_code');
        $this->db->where('class_code',$info['class_code']);
        $this->db->limit(1);
        $query = $this->db->get('feedback_class');
        $arrClass = $query->result_array();

        if(count($arrClass) == 0){
            $this->db->insert('feedback_class', $info);
            return 1;
        }
        return 'Mã lớp đã tồn tại, hãy nhập mã lớp khác!';
    }

    public function update_class($info)
    {
        $this->_tracking_func(__FUNCTION__);

        $this->db->where('class_id', $info['class_id']);
        $this->db->update('feedback_class', $info);
        return 1;
    }

    public function del_class($info)
    {
        $this->_tracking_func(__FUNCTION__);

        $this->db->delete('feedback_class', array('class_id' => $info['class_id']));
    }

    public function get_info_teacher($teacher_id)
    {
        $this->_tracking_func(__FUNCTION__);

        $this->db->where('teacher_id', $teacher_id);
        $this->db->select('*');
        $query = $this->db->get('feedback_teacher');
        $arr_res = $query->result_array();
        return $arr_res[0];
    }

    public function get_list_info_teacher()
    {
        $this->_tracking_func(__FUNCTION__);

        $this->db->select('*');
//        $this->db->limit(300);
        $query = $this->db->get('feedback_teacher');
        $arr_res = $query->result_array();
        return $arr_res;
    }

    public function get_info_class_by_id_class($id_class)
    {
        $this->_tracking_func(__FUNCTION__);

        $this->db->where('class_id', $id_class);
        $this->db->select('*');
        $query = $this->db->get('feedback_class');
        $arr_res = $query->result_array();

        $mono_info = $arr_res[0];
        if (isset($mono_info['list_teacher'])) {
            $arr_techer_id = json_decode($mono_info['list_teacher'], true);
            $arr_techer_info = array();
            for ($i = 0; $i < count($arr_techer_id); $i++) {
                $info_teacher = $this->get_info_teacher($arr_techer_id[$i]);
                array_push($arr_techer_info, $info_teacher);
            }
            $arr_res[0]['list_teacher_info'] = $arr_techer_info;
        }
        // number_feedback

        $arr_res[0]['number_feedback'] = $this->get_number_feedback_form_by_class_code($mono_info['class_code']);
        return $arr_res[0];
    }

    public function get_number_feedback_form_by_class_code($class_code, $times = null)
    {
        $this->_tracking_func(__FUNCTION__);

        if(!empty($times) && $times > 0){
            $this->db->where('times', $times);
        }
        $this->db->where('class_code', $class_code);
        return $this->db->count_all_results('feedback_paper');
    }

    public function get_number_feedback_slide_by_class_code($class_code)
    {
        $this->_tracking_func(__FUNCTION__);

        $this->db->where('class_code', $class_code);
        return $this->db->count_all_results('feedback_slide');
    }

    public function get_number_feedback_ksgv_1_by_class_code($class_code)
    {
        $this->_tracking_func(__FUNCTION__);

        $this->db->where('class_code', $class_code);
        $this->db->where('type', 'ksgv1');
        return $this->db->count_all_results('feedback_ksgv');
    }

    public function get_number_feedback_ksgv_2_by_class_code($class_code)
    {
        $this->_tracking_func(__FUNCTION__);

        $this->db->where('class_code', $class_code);
        $this->db->where('type', 'ksgv2');
        return $this->db->count_all_results('feedback_ksgv');
    }

    public function get_number_feedback_online_by_class_code($class_code)
    {
        $this->_tracking_func(__FUNCTION__);

        $this->db->where('class_code', $class_code);
        $this->db->where('type', 'dao_tao_onl');
        return $this->db->count_all_results('feedback_ksgv');
    }


    public function get_number_feedback_phone_by_class_code($class_code, $times = null)
    {
        $this->_tracking_func(__FUNCTION__);

        if(!empty($times) && $times > 0){
            $this->db->where('times', $times);
        }
        $this->db->where('class_code', $class_code);
        return $this->db->count_all_results('feedback_phone');
    }

    public function get_number_feedback_homthugopy_by_class_code($class_code)
    {
        $this->_tracking_func(__FUNCTION__);

        if ($class_code != '') {
            $this->db->where('class_code', $class_code);
        }
        return $this->db->count_all_results('feedback_hom_thu_gop_y');
    }

    public function get_info_class_by_class_code($class_code)
    {
        $this->_tracking_func(__FUNCTION__);

        $this->db->where('class_code', $class_code);
        $this->db->select('*');
        $query = $this->db->get('feedback_class');
        $arr_res = $query->row_array();
        return $arr_res;
    }

    public function check_class_code_exist($class_code, $type = '')
    {
        $this->_tracking_func(__FUNCTION__);

        if ($type !== "") {
            $this->db->where('type', $type);
        }
        $class_code = trim(mb_strtolower($class_code));

//        $this->db->where('class_code',$class_code);
//        $this->db->select('*'); // - hehe
        $this->db->select('class_code');
        $this->db->limit(1);
        $this->db->where('class_code',$class_code);
        $query = $this->db->get('feedback_class');
        $arr_res = $query->result_array();
        if (count($arr_res) > 0){
            return true;
        }
        return false;

    }

    public function check_class_feedback_openning($class_code)
    {
        $this->_tracking_func(__FUNCTION__);

        $class_code = mb_strtolower($class_code);
        $this->db->where('class_code', $class_code);
        $this->db->select('*');
        $query = $this->db->get('feedback_class');
        $arr_res = $query->result_array();
        if (count($arr_res) == 0) {
            echo 'Wrong class code !';
            return false;
        }
        if (count($arr_res) > 1) {
            echo 'Class code duplicate !';
            return false;
        }
        $now_time = time();
        $time_start = $arr_res[0]['time_start'];
        $time_end = $arr_res[0]['time_end'];
        if ($time_start != 0) {
            if ($now_time < $time_start) {
                echo 'Lớp ' . $class_code . ' hiện tại chưa nhận feedback !';
                return false;
            }
        }
        if ($time_end != 0) {
            if ($now_time > $time_end) {
                echo 'Lớp ' . $class_code . ' đã quá hạn nhận feedback !';
                return false;
            }
        }
        return true;

    }

    // ====================== Tư vấn

    public function insert_tuvan($info)
    {
        $this->_tracking_func(__FUNCTION__);

        $plus = array(
            'time_creat' => time(),
            'role' => 'tuvan',
        );
        $data = array_merge($info, $plus);
        $this->db->insert('feedback_user', $data);
    }

    public function update_tuvan($info)
    {
        $this->_tracking_func(__FUNCTION__);

        $this->db->set('fullname', $info['fullname']);
        $this->db->set('username', $info['username']);
        $this->db->set('passwd', $info['passwd']);
        $this->db->set('id_location', $info['id_location']);
        $this->db->set('status', $info['status']);
        $this->db->set('role', 'tuvan');
        $this->db->where('id', $info['tuvan_id']);
        $this->db->update('feedback_user');
    }

    public function update_tuvan_active($info)
    {
        $this->_tracking_func(__FUNCTION__);

        $this->db->set('status', $info['status']);
        $this->db->where('id', $info['tuvan_id']);
        $this->db->update('feedback_user');
    }

    public function del_tuvan($info)
    {
        $this->_tracking_func(__FUNCTION__);

        $this->db->delete('feedback_user', array('id' => $info['tuvan_id']));
    }

    public function del_feedbackphone($info)
    {
        $this->_tracking_func(__FUNCTION__);

        if (($_SESSION['role'] == 'admin') || ($_SESSION['role'] == 'manager')) {

            $this->db->where('id', $info['id']);
            $this->db->select('class_code');
            $query = $this->db->get('feedback_phone');
            $arr_res = $query->result_array();

            $this->db->delete('feedback_phone', array('id' => $info['id']));
            $this->mark_point_class($arr_res[0]['class_code']);
        }
    }

    public function del_feedbackform($info)
    {
        $this->_tracking_func(__FUNCTION__);

        if (($_SESSION['role'] == 'admin') || ($_SESSION['role'] == 'manager')) {

            $this->db->where('id', $info['id']);
            $this->db->select('class_code');
            $query = $this->db->get('feedback_ksgv');
            $arr_res = $query->result_array();

            $this->db->delete('feedback_ksgv', array('id' => $info['id']));
            $this->mark_point_class($arr_res[0]['class_code']);
        }
    }

    public function checkPasswd($username, $passwd)
    {
        $this->_tracking_func(__FUNCTION__);

        if ((strlen(trim($username)) < 3) || (strlen(trim($passwd)) < 3)) {
            return array(
                'result' => false,
                'message' => 'Thông tin đăng nhập không hợp lệ'
            );
        }

        $this->db->where('username', $username);
        $this->db->where('passwd', $passwd);
        $this->db->where('status', 1);
        $this->db->select('*');
        $query = $this->db->get('feedback_user');
        $arr_res = $query->result_array();
        if (count($arr_res) == 1) {
            $focus = $arr_res[0];
            return array(
                'result' => true,
                'role' => $focus['role'],
                'fullname' => $focus['fullname'],
                'id_location' => $focus['id_location'],
                'id' => $focus['id'],
            );
        } else {
            return array(
                'result' => false,
                'message' => 'Thông tin đăng nhập không đúng'
            );
        }

    }

    public function get_list_tuvan($id_location = '')
    {
        $this->_tracking_func(__FUNCTION__);

        if ($id_location != '') {
            $this->db->where('id_location', $id_location);
        }
        $this->db->where('role', 'tuvan');
        $this->db->select('*');
        $query = $this->db->get('feedback_user');
        $arr_res = $query->result_array();
        return $arr_res;
    }

    public function get_info_user($user_id)
    {
        $this->_tracking_func(__FUNCTION__);

        $this->db->where('id', $user_id);
        $this->db->select('fullname, role');
        $query = $this->db->get('feedback_user');
        $arr_res = $query->result_array();
        return $arr_res[0];
    }

    // ====================== PHONE (khảo sát bằng điện thoại)

    public function insert_phone_paper($info)
    {
        $this->_tracking_func(__FUNCTION__);

        // Check trùng trước
        $this->db->where('class_code', $info['class_code']);
        $this->db->where('comment', $info['comment']);
        $this->db->select('*');
        $query = $this->db->get('feedback_phone');
        $arr_res = $query->result_array();
        if (count($arr_res) > 0) {
            // trùng
            return false;
        } else {
            $plus = array(
                'time' => time(),
            );
            $data = array_merge($info, $plus);
            $this->db->insert('feedback_phone', $data);

            $this->mark_point_class($info['class_code']);
            return true;
        }
    }

    public function get_list_phone_paper_by_class_code($class_code, $times = null)
    {
        $this->_tracking_func(__FUNCTION__);

        if(!empty($times) && $times > 0){
            $this->db->where('times', $times);
        }
        $this->db->where('class_code', $class_code);
        $this->db->select('*');
        $query = $this->db->get('feedback_phone');
        $arr_res = $query->result_array();

        return $arr_res;
    }

    public function get_report_phone_paper_by_class_code($class_code)
    {
        $this->_tracking_func(__FUNCTION__);

        $list_phone_feedback = $this->get_list_phone_paper_by_class_code($class_code);
        $count = count($list_phone_feedback);
        $total_point = 0;

        foreach ($list_phone_feedback as $item) {
            $point = $item['point'];
            $total_point += $point;
        }

        if ($count > 0) {
            $average_point = round($total_point / $count, 1);
        } else {
            $average_point = 0;
        }

        $arr_res = array(
            'count' => $count,
            'average_point' => $average_point,
        );
        return $arr_res;
    }

    public function get_list_feedback_phone_newest($limit = 100, $starttime = null, $endtime = null)
    {
        $this->_tracking_func(__FUNCTION__);

        if(!empty($starttime) && $starttime > 0) {
            $this->db->where('time <', $starttime);
        }
        if(!empty($endtime) && $endtime > 0) {
            $this->db->where('time < ', $endtime + 86400);
        }
        $this->db->limit($limit);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('feedback_phone');
        $arr_res = $query->result_array();
        return $arr_res;
    }


    //bộ lọc feedback phone theo thời gian (start - end), theo lớp và địa điểm
    public function get_list_feedback_phone_filter($limit = 100, $starttime = null, $endtime = null, $class = null, $area, $location)
    {
        $this->_tracking_func(__FUNCTION__);

        if(!empty($starttime) && $starttime > 0) {
            $this->db->where('fb.time >=', $starttime);
        }
        if(!empty($endtime) && $endtime > 0) {
            $this->db->where('fb.time < ', $endtime+86400);
        }
        if(!empty($class)) {
            $this->db->where('fb.class_code', $class);
        }

        $this->db->limit($limit);
        $this->db->order_by('id', 'DESC');
        $this->db->select('fb.*');
        $this->db->where_in("fc.id_location",$location);
        if(count($area) == 0){
            $area = array('0');
        }
        $this->db->where_in("fl.area",$area);
        $this->db->join("feedback_class as fc","fb.class_code = fc.class_code");
        $this->db->join("feedback_location as fl","fc.id_location = fl.id");
        $query = $this->db->get("feedback_phone as fb");

        $arr_res = $query->result_array();
        return $arr_res;
    }

    public function get_list_feedback_phone_export($limit = 100, $starttime = null, $endtime = null, $class = null, $area, $location)
    {
        $this->_tracking_func(__FUNCTION__);

        if(!empty($starttime) && $starttime > 0) {
            $this->db->where('fb.time >=', $starttime);
        }
        if(!empty($endtime) && $endtime > 0) {
            $this->db->where('fb.time < ', $endtime+86400);
        }
        if(!empty($class)) {
            $this->db->where('fb.class_code', $class);
        }

        $this->db->limit($limit);
        $this->db->order_by('fb.id', 'DESC');
        $this->db->group_by('fb.class_code, fb.times');
        $this->db->select('fb.id, fb.times, fc.class_code, fc.list_teacher, fl.name, fl.area, fb.time, AVG(fb.point) AS point');
//        $this->db->select('fb.times, fc.class_code, fc.list_teacher, fl.name, fl.area, fb.time, AVG(fb.point) AS point');
        $this->db->where_in("fc.id_location",$location);
        $this->db->where_in("fl.area",$area);
        $this->db->join("feedback_class as fc","fb.class_code = fc.class_code");
        $this->db->join("feedback_location as fl","fc.id_location = fl.id");
        $query = $this->db->get("feedback_phone as fb");

        $arr_res = $query->result_array();
        return $arr_res;
    }

    // ====================== POINT CLASS

    // điểm trung bình ->
    public function get_all_point_class_by_class_id($class_id)
    {
        $this->_tracking_func(__FUNCTION__);

        // 5 lần feed back phone
        $this->db->where('class_id', $class_id);
        $this->db->select('point, point_phone');
        $query = $this->db->get('feedback_class');
        $arr_res = $query->result_array();
        return $arr_res[0];
    }


    // ====================== PAPER

    public function get_top_class_feedback_newest($number_take, $type = '')
    {
        $this->_tracking_func(__FUNCTION__);

        $list_feedback_form_newest = $this->get_list_feedback_ksgv('', $type, 'time_end');

        $class_arr = array(); // json_encode([type,class_code])

        for ($i = 0; $i < count($list_feedback_form_newest); $i++) {
            if (count($class_arr) < $number_take) {
                $mono = $list_feedback_form_newest[$i];
                $type = $mono['type'];
                $class_code = $mono['class_code'];
//
//                if (!$this->check_class_code_exist($class_code)) {
//                    continue;
//                }
                $mono_json = json_encode(array($type, $class_code));
                if (!in_array($mono_json, $class_arr)) {
                    array_push($class_arr, $mono_json);
                }
            } else {
                break;
            }
        }
        return $class_arr;
    }

    public function insert_feedback_paper($info)
    {
        $this->_tracking_func(__FUNCTION__);

        $this->load->library('user_agent');

        $plus = array(
            'time_end' => time(),
            'ip' => $this->input->ip_address(),
            'browser' => $this->agent->browser() . ' ' . $this->agent->version()
        );
        $data = array_merge($info, $plus);
        $this->db->insert('feedback_paper', $data);
        $this->mark_point_class($info['class_code']);
    }

    public function insert_feedback_paper_ksgv($info)
    {
        $this->_tracking_func(__FUNCTION__);

        $this->load->library('user_agent');
        $plus = array(
            'time_end' => time(),
            'ip' => $this->input->ip_address(),
            'browser' => $this->agent->browser() . ' ' . $this->agent->version()
        );
        $data = array_merge($info, $plus);
        $this->db->insert('feedback_ksgv', $data);
        $this->mark_point_class($info['class_code']);
    }

    public function insert_feedback_paper_hom_thu_gop_y($info)
    {
        $this->_tracking_func(__FUNCTION__);

        $this->load->library('user_agent');

        $plus = array(
            'time_end' => time(),
            'ip' => $this->input->ip_address(),
            'browser' => $this->agent->browser() . ' ' . $this->agent->version()
        );
        $data = array_merge($info, $plus);
        $this->db->insert('feedback_hom_thu_gop_y', $data);
    }

    public function insert_feedback_paper_slide($info)
    {
        $this->_tracking_func(__FUNCTION__);

        $this->load->library('user_agent');

        $plus = array(
            'time_end' => time(),
            'ip' => $this->input->ip_address(),
            'browser' => $this->agent->browser() . ' ' . $this->agent->version()
        );
        $data = array_merge($info, $plus);
        $this->db->insert('feedback_slide', $data);
    }

    public function insert_feedback_zoom($info)
    {
        $this->_tracking_func(__FUNCTION__);
        $this->load->library('user_agent');
        $plus = array(
            'time_end' => time(),
            'ip' => $this->input->ip_address(),
            'browser' => $this->agent->browser() . ' ' . $this->agent->version()
        );
        $data = array_merge($info, $plus);
        $this->db->insert('feedback_zoom', $data);
    }

    public function insert_feedback_luyen_de($info)
    {
        $this->load->library('user_agent');
        $plus = array(
            'time_end' => time(),
            'ip' => $this->input->ip_address(),
            'browser' => $this->agent->browser() . ' ' . $this->agent->version()
        );
        $data = array_merge($info, $plus);
        $this->db->insert('feedback_luyende', $data);

        // Update thêm số lượng đăng ký
        if (isset($info['class_code'])){
            $this->db->where('class_code', $info['class_code']);
            $query = $this->db->get('feedback_luyende');
            $arr_res = $query->result_array();
            $number = count($arr_res);

            $this->db->set('number_luyen_de', $number);
            $this->db->where('class_code', $info['class_code']);
            $this->db->update('feedback_class');
        }

    }

    public function insert_feedback_thicuoiky($info)
    {
        $this->load->library('user_agent');
        $plus = array(
            'time_end' => time(),
            'ip' => $this->input->ip_address(),
            'browser' => $this->agent->browser() . ' ' . $this->agent->version()
        );
        $data = array_merge($info, $plus);
        $this->db->insert('feedback_thicuoiky', $data);

        // Update thêm số lượng đăng ký
        if (isset($info['class_code'])){
            $this->db->where('class_code', $info['class_code']);
            $query = $this->db->get('feedback_thicuoiky');
            $arr_res = $query->result_array();
            $number = count($arr_res);

            $this->db->set('number_thicuoiky', $number);
            $this->db->where('class_code', $info['class_code']);
            $this->db->update('feedback_class');
        }

    }
    
    public function get_list_feedback_paper($class_code = '', $type = '', $order = '')
    {
        $this->_tracking_func(__FUNCTION__);

        if ($class_code != '') {
            $this->db->where('class_code', $class_code);
        }

        if ($type != '') {
            $this->db->where('type', $type);
        }

        if ($order != '') {
            $this->db->order_by($order, 'DESC');
        }

        $this->db->limit(300);
        $query = $this->db->get('feedback_paper');
        $arr_res = $query->result_array();
        return $arr_res;
    }

    public function get_list_feedback_ksgv($class_code = '', $type = '', $order = '')
    {
        $this->_tracking_func(__FUNCTION__);

        if ($class_code != '') {
            $this->db->where('class_code', $class_code);
        }

        if ($type != '') {
            $this->db->where('type', $type);
        }

        if ($order != '') {
            $this->db->order_by($order, 'DESC');
        }

        $this->db->limit(300);

        $query = $this->db->get('feedback_ksgv');
        $arr_res = $query->result_array();
        return $arr_res;
    }

    public function get_list_feedback_hom_thu_gop_y($class_code = '', $order = '')
    {
        $this->_tracking_func(__FUNCTION__);

        if ($class_code != '') {
            $this->db->where('class_code', $class_code);
        }

        if ($order != '') {
            $this->db->order_by($order, 'DESC');
        }
        $this->db->order_by('id', 'DESC');
        $this->db->limit(500);
        $query = $this->db->get('feedback_hom_thu_gop_y');
        $arr_res = $query->result_array();
        return $arr_res;
    }

    public function get_list_feedback_slide($class_code = '', $type = '', $order = '')
    {
        $this->_tracking_func(__FUNCTION__);

        if ($class_code != '') {
            $this->db->where('class_code', $class_code);
        }

        if ($type != '') {
            $this->db->where('type', $type);
        }

        if ($order != '') {
            $this->db->order_by($order, 'DESC');
        }
        $this->db->limit(300);
        $query = $this->db->get('feedback_slide');
        $arr_res = $query->result_array();
        return $arr_res;
    }

    // deprecated
    public function get_data_statistic_class_new($class_code)
    {
        $this->_tracking_func(__FUNCTION__);

        $data = $this->get_list_feedback_ksgv($class_code);
        $arr_name = array();
        $arr_time_length = array();

        $arr_data_question_total = array();
        $arr_info_question = array();

        $data_question_list = array();

        foreach ($data as $mono) {
            $time_start = $mono['time_start'];
            $time_end = $mono['time_end'];

            $timelength = $time_end - $time_start;
            $arr_time_length[] = $timelength;

            $name_feeder = $mono['name_feeder'];
            $arr_name[] = $name_feeder;

            $detail = json_decode($mono['detail'], true);
            foreach ($detail as $mono_detail) {
                $id_quest = $mono_detail[0];
                $type = $mono_detail[1];
                $content = $mono_detail[2];
                $value = (string)$mono_detail[3];
                if (!isset($arr_info_question[$id_quest])) {
                    $arr_info_question[$id_quest] = array(
                        'type' => $type,
                        'title' => $content,
                    );
                }

                switch ($type) {
                    case 'ruler':
                        if (!isset($data_question_list[$id_quest])) {
                            $data_question_list[$id_quest] = array(
                                '1' => 0,
                                '2' => 0,
                                '3' => 0,
                                '4' => 0,
                                '5' => 0,
                            );
                        }
                        $now_count_list = $data_question_list[$id_quest];
                        if (array_key_exists($value, $now_count_list)) {
                            $now_count = $now_count_list[$value];
                            $now_count_list[$value] = $now_count + 1;
                        }
                        $data_question_list[$id_quest] = $now_count_list;
                        break;
                    case 'select':
                        if (!isset($data_question_list[$id_quest])) {
                            $data_question_list[$id_quest] = array(
                                '1' => 0,
                                '2' => 0,
                                '3' => 0,
                                '4' => 0,
                                '5' => 0,
                                '6' => 0,
                                '7' => 0,
                                '8' => 0,
                                '9' => 0,
                                '10' => 0,
                            );
                        }
                        $now_count_list = $data_question_list[$id_quest];
                        if (array_key_exists($value, $now_count_list)) {
                            $now_count = $now_count_list[$value];
                            $now_count_list[$value] = $now_count + 1;
                        }
                        $data_question_list[$id_quest] = $now_count_list;
                        break;
                    case 'radio':
                        if (!isset($data_question_list[$id_quest])) {
                            $data_question_list[$id_quest] = array(
                                '0' => 0,
                                '1' => 0,
                            );
                        }
                        $now_count_list = $data_question_list[$id_quest];
                        if (array_key_exists($value, $now_count_list)) {
                            $now_count = $now_count_list[$value];
                            $now_count_list[$value] = $now_count + 1;
                        }
                        $data_question_list[$id_quest] = $now_count_list;
                        break;
                    case 'text':
                        if (!isset($data_question_list[$id_quest])) {
                            $data_question_list[$id_quest] = array();
                        }
                        $now_count_list = $data_question_list[$id_quest];

                        if (trim($value) !== '') {
                            array_push($now_count_list, $value);
                        }
                        $data_question_list[$id_quest] = $now_count_list;
                        break;
                    default:
                }

            }
        }

        foreach ($arr_info_question as $id_quest => $info_arr) {
            $arr_client = array(
                'id_quest' => $id_quest,
                'data' => $data_question_list[$id_quest],
            );
            $x = array_merge($arr_client, $info_arr);

            array_push($arr_data_question_total, $x);
        }

        return array(
            'question' => $arr_data_question_total,
            'name' => $arr_name,
            'time' => $arr_time_length,
        );
    }

    // =============== zfdev đang rà soát tới đây

    public function get_data_statistic_class($class_code)
    {
        $this->_tracking_func(__FUNCTION__);

        $data = $this->get_list_feedback_ksgv($class_code);
        $arr_name = array();
        $arr_time_length = array();

        $arr_data_question_total = array();
        $arr_info_question = array();

        $data_question_list = array();

        foreach ($data as $mono) {
            $time_start = $mono['time_start'];
            $time_end = $mono['time_end'];

            $timelength = $time_end - $time_start;
            $arr_time_length[] = $timelength;

            $name_feeder = $mono['name_feeder'];
            $arr_name[] = $name_feeder;

            $detail = json_decode($mono['detail'], true);
//            echo '<pre>';print_r($detail); echo '</pre>';
            foreach ($detail as $mono_detail) {
                $id_quest = $mono_detail[0];
                $type = $mono_detail[1];
                $content = $mono_detail[2];
                $value = (string)$mono_detail[3];
                if (!isset($arr_info_question[$id_quest])) {
                    $arr_info_question[$id_quest] = array(
                        'type' => $type,
                        'title' => $content,
                    );
                }

                switch ($type) {
                    case 'ruler':
                        if (!isset($data_question_list[$id_quest])) {
                            $data_question_list[$id_quest] = array(
                                '1' => 0,
                                '2' => 0,
                                '3' => 0,
                                '4' => 0,
                                '5' => 0,
                            );
                        }
                        $now_count_list = $data_question_list[$id_quest];
                        if (array_key_exists($value, $now_count_list)) {
                            $now_count = $now_count_list[$value];
                            $now_count_list[$value] = $now_count + 1;
                        }
                        $data_question_list[$id_quest] = $now_count_list;
                        break;
                    case 'select':
                        if (!isset($data_question_list[$id_quest])) {
                            $data_question_list[$id_quest] = array(
                                '1' => 0,
                                '2' => 0,
                                '3' => 0,
                                '4' => 0,
                                '5' => 0,
                                '6' => 0,
                                '7' => 0,
                                '8' => 0,
                                '9' => 0,
                                '10' => 0,
                            );
                        }
                        $now_count_list = $data_question_list[$id_quest];
                        if (array_key_exists($value, $now_count_list)) {
                            $now_count = $now_count_list[$value];
                            $now_count_list[$value] = $now_count + 1;
                        }
                        $data_question_list[$id_quest] = $now_count_list;
                        break;
                    case 'radio':
                        if (!isset($data_question_list[$id_quest])) {
                            $data_question_list[$id_quest] = array(
                                '0' => 0,
                                '1' => 0,
                            );
                        }
                        $now_count_list = $data_question_list[$id_quest];
                        if (array_key_exists($value, $now_count_list)) {
                            $now_count = $now_count_list[$value];
                            $now_count_list[$value] = $now_count + 1;
                        }
                        $data_question_list[$id_quest] = $now_count_list;
                        break;
                    case 'text':
                        if (!isset($data_question_list[$id_quest])) {
                            $data_question_list[$id_quest] = array();
                        }
                        $now_count_list = $data_question_list[$id_quest];

                        if (trim($value) !== '') {
                            array_push($now_count_list, $value);
                        }
                        $data_question_list[$id_quest] = $now_count_list;
                        break;
                    default:
                }

            }
        }

//        echo '<pre>';
//        print_r($data_question_list);
//        echo '</pre>';

        foreach ($arr_info_question as $id_quest => $info_arr) {
            $arr_client = array(
                'id_quest' => $id_quest,
                'data' => $data_question_list[$id_quest],
            );
            $x = array_merge($arr_client, $info_arr);
            //            $info_arr = array(
//                'type' => 'ruler',
//                'title' => $title,
//            );

            array_push($arr_data_question_total, $x);
        }

        return array(
            'question' => $arr_data_question_total,
            'name' => $arr_name,
            'time' => $arr_time_length,
        );
    }

    public function mark_point_class_old($class_code)
    {

        $this->_tracking_func(__FUNCTION__);

        $data = $this->get_list_feedback_paper($class_code);

        $arr_info_question = array();
        $data_question_list = array();

        foreach ($data as $mono) {
            $detail = json_decode($mono['detail'], true);
            foreach ($detail as $mono_detail) {
                $id_quest = $mono_detail[0];
                $type = $mono_detail[1];
                $content = $mono_detail[2];
                $value = (string)$mono_detail[3];
                if (!isset($arr_info_question[$id_quest])) {
                    $arr_info_question[$id_quest] = array(
                        'type' => $type,
                        'title' => $content,
                    );
                }

                switch ($type) {
                    case 'select':
                        if (!isset($data_question_list[$id_quest])) {
                            $data_question_list[$id_quest] = array(
                                '1' => 0,
                                '2' => 0,
                                '3' => 0,
                                '4' => 0,
                                '5' => 0,
                                '6' => 0,
                                '7' => 0,
                                '8' => 0,
                                '9' => 0,
                                '10' => 0,
                            );
                        }
                        $now_count_list = $data_question_list[$id_quest];
                        if (array_key_exists($value, $now_count_list)) {
                            $now_count = $now_count_list[$value];
                            $now_count_list[$value] = $now_count + 1;
                        }
                        $data_question_list[$id_quest] = $now_count_list;
                        break;
                    default:
                }

            }
        }

        $arr_diem_trung_binh = array();

        foreach ($data_question_list as $id_question => $mono_question_list) {
            $sum = 0;
            $count = 0;
            foreach ($mono_question_list as $point => $number) {
                $point_int = (int)$point;
                $sum += $point_int * $number;
                $count += $number;
            }
            if ($count != 0) {
                $arr_diem_trung_binh[$id_question] = $sum / $count;
            } else {
                $arr_diem_trung_binh[$id_question] = 0;
            }
        }

        $sum_point_class = 0;
        $count_question = 0;
        foreach ($arr_diem_trung_binh as $id_question => $point) {
            if ($point > 0) {
                $count_question++;
                $sum_point_class += $point;
            }
        }

        if ($count_question != 0) {
            $average_point_class = round($sum_point_class / $count_question, 2);
        } else {
            $average_point_class = 0;
        }

        // Thêm feedback phone
        $list_feedback_phone = $this->get_list_phone_paper_by_class_code($class_code);
        $list_feedback_phone_1 = $this->get_list_phone_paper_by_class_code($class_code, 1);
        $list_feedback_phone_2 = $this->get_list_phone_paper_by_class_code($class_code, 2);

        $count_phone = count($list_feedback_phone);
        $count_phone_1 = count($list_feedback_phone_1);
        $count_phone_2 = count($list_feedback_phone_2);
        $sum_phone_point = 0;
        $sum_phone_point_1 = 0;
        $sum_phone_point_2 = 0;
        foreach ($list_feedback_phone as $item) {
            $sum_phone_point += $item['point'];
        }
        foreach ($list_feedback_phone_1 as $item1) {
            $sum_phone_point_1 += $item1['point'];
        }

        foreach ($list_feedback_phone_2 as $item2) {
            $sum_phone_point_2 += $item2['point'];
        }

        if ($count_phone == 0) {
            $average_phone = 0;
        } else {
            $average_phone = round($sum_phone_point / $count_phone, 2);
        }

        if ($count_phone_1 == 0) {
            $average_phone_1 = 0;
        } else {
            $average_phone_1 = round($sum_phone_point_1 / $count_phone_1, 2);
        }

        if ($count_phone_2 == 0) {
            $average_phone_2 = 0;
        } else {
            $average_phone_2 = round($sum_phone_point_2 / $count_phone_2, 2);
        }
        if($count_question + $count_phone > 0){
            $average_point = round(($sum_point_class + $sum_phone_point) / ($count_question + $count_phone), 2);
        }else {
            $average_point = 0;
        }

        $this->db->set('point_phone', $average_phone, FALSE); // feedback phone
        $this->db->set('point_phone1', $average_phone_1, FALSE); // feedback phone 1
        $this->db->set('point_phone2', $average_phone_2, FALSE); // feedback phone 2
        $this->db->set('point', $average_point_class, FALSE); // feedback form
        $this->db->set('average_point', $average_point, FALSE); // điểm trung bình feedback form + feedback phone
        $this->db->where('class_code', $class_code);
        $this->db->update('feedback_class');

        return $average_point_class;
    }

    public function mark_point_class_paper($class_code)
    {

        $this->_tracking_func(__FUNCTION__);

        $data = $this->get_list_feedback_paper($class_code);

        $arr_info_question = array();
        $data_question_list = array();

        foreach ($data as $mono) {
            $detail = json_decode($mono['detail'], true);
            foreach ($detail as $mono_detail) {
                $id_quest = $mono_detail[0];
                $type = $mono_detail[1];
                $content = $mono_detail[2];
                $value = (string)$mono_detail[3];
                if (!isset($arr_info_question[$id_quest])) {
                    $arr_info_question[$id_quest] = array(
                        'type' => $type,
                        'title' => $content,
                    );
                }

                switch ($type) {
                    case 'select':
                        if (!isset($data_question_list[$id_quest])) {
                            $data_question_list[$id_quest] = array(
                                '1' => 0,
                                '2' => 0,
                                '3' => 0,
                                '4' => 0,
                                '5' => 0,
                                '6' => 0,
                                '7' => 0,
                                '8' => 0,
                                '9' => 0,
                                '10' => 0,
                            );
                        }
                        $now_count_list = $data_question_list[$id_quest];
                        if (array_key_exists($value, $now_count_list)) {
                            $now_count = $now_count_list[$value];
                            $now_count_list[$value] = $now_count + 1;
                        }
                        $data_question_list[$id_quest] = $now_count_list;
                        break;
                    default:
                }

            }
        }

        $arr_diem_trung_binh = array();

        foreach ($data_question_list as $id_question => $mono_question_list) {
            $sum = 0;
            $count = 0;
            foreach ($mono_question_list as $point => $number) {
                $point_int = (int)$point;
                $sum += $point_int * $number;
                $count += $number;
            }
            if ($count != 0) {
                $arr_diem_trung_binh[$id_question] = $sum / $count;
            } else {
                $arr_diem_trung_binh[$id_question] = 0;
            }
        }

        $sum_point_class = 0;
        $count_question = 0;
        foreach ($arr_diem_trung_binh as $id_question => $point) {
            if ($point > 0) {
                $count_question++;
                $sum_point_class += $point;
            }
        }

        if ($count_question != 0) {
            $average_point_class = round($sum_point_class / $count_question, 2);
        } else {
            $average_point_class = 0;
        }

        // Thêm feedback phone
        $list_feedback_phone = $this->get_list_phone_paper_by_class_code($class_code);
        $list_feedback_phone_1 = $this->get_list_phone_paper_by_class_code($class_code, 1);
        $list_feedback_phone_2 = $this->get_list_phone_paper_by_class_code($class_code, 2);

        $count_phone = count($list_feedback_phone);
        $count_phone_1 = count($list_feedback_phone_1);
        $count_phone_2 = count($list_feedback_phone_2);
        $sum_phone_point = 0;
        $sum_phone_point_1 = 0;
        $sum_phone_point_2 = 0;
        foreach ($list_feedback_phone as $item) {
            $sum_phone_point += $item['point'];
        }
        foreach ($list_feedback_phone_1 as $item1) {
            $sum_phone_point_1 += $item1['point'];
        }

        foreach ($list_feedback_phone_2 as $item2) {
            $sum_phone_point_2 += $item2['point'];
        }

        if ($count_phone == 0) {
            $average_phone = 0;
        } else {
            $average_phone = round($sum_phone_point / $count_phone, 2);
        }

        if ($count_phone_1 == 0) {
            $average_phone_1 = 0;
        } else {
            $average_phone_1 = round($sum_phone_point_1 / $count_phone_1, 2);
        }

        if ($count_phone_2 == 0) {
            $average_phone_2 = 0;
        } else {
            $average_phone_2 = round($sum_phone_point_2 / $count_phone_2, 2);
        }
        if($count_question + $count_phone > 0){
            $average_point = round(($sum_point_class + $sum_phone_point) / ($count_question + $count_phone), 2);
        }else {
            $average_point = 0;
        }

//        $this->db->set('point_phone', $average_phone, FALSE); // feedback phone
//        $this->db->set('point_phone1', $average_phone_1, FALSE); // feedback phone 1
//        $this->db->set('point_phone2', $average_phone_2, FALSE); // feedback phone 2
//        $this->db->set('point', $average_point_class, FALSE); // feedback form
//        $this->db->set('average_point', $average_point, FALSE); // điểm trung bình feedback form + feedback phone
//        $this->db->where('class_code', $class_code);
//        $this->db->update('feedback_class');

        return $average_point_class;
    }

    public function mark_point_class($class_code)
    {
        $this->_tracking_func(__FUNCTION__);

        // ============== FEEDBACK FORM
        $data = $this->get_list_feedback_ksgv($class_code);

        $arr_info_question = array();

        $data_question_list = array();

        foreach ($data as $mono) {
            $detail = json_decode($mono['detail'], true);
            foreach ($detail as $mono_detail) {
                $id_quest = $mono_detail[0];
                $type = $mono_detail[1];
                $content = $mono_detail[2];
                $value = (string)$mono_detail[3];
                if (!isset($arr_info_question[$id_quest])) {
                    $arr_info_question[$id_quest] = array(
                        'type' => $type,
                        'title' => $content,
                    );
                }

                switch ($type) {
                    case 'select':
                        if (!isset($data_question_list[$id_quest])) {
                            $data_question_list[$id_quest] = array(
                                '1' => 0,
                                '2' => 0,
                                '3' => 0,
                                '4' => 0,
                                '5' => 0,
                                '6' => 0,
                                '7' => 0,
                                '8' => 0,
                                '9' => 0,
                                '10' => 0,
                            );
                        }
                        $now_count_list = $data_question_list[$id_quest];
                        if (array_key_exists($value, $now_count_list)) {
                            $now_count = $now_count_list[$value];
                            $now_count_list[$value] = $now_count + 1;
                        }
                        $data_question_list[$id_quest] = $now_count_list;
                        break;
                    default:
                }
            }
        }

        $arr_diem_trung_binh = array();
        foreach ($data_question_list as $id_question => $mono_question_list) {
            $sum = 0;
            $count = 0;
            foreach ($mono_question_list as $point => $number) {
                $point_int = (int)$point;
                $sum += $point_int * $number;
                $count += $number;
            }
            if ($count != 0) {
                $arr_diem_trung_binh[$id_question] = $sum / $count;
            } else {
                $arr_diem_trung_binh[$id_question] = 0;
            }
        }

        $sum_point_class = 0;
        $count_question = 0;
        foreach ($arr_diem_trung_binh as $id_question => $point) {
            if ($point > 0) {
                $count_question++;
                $sum_point_class += $point;
            }
        }

        if ($count_question != 0) {
            $average_point_class = round($sum_point_class / $count_question, 2);
        } else {
            $average_point_class = 0;
        }
        // ==============

        // Thêm feedback phone
        $list_feedback_phone = $this->get_list_phone_paper_by_class_code($class_code);
        $list_feedback_phone_1 = $this->get_list_phone_paper_by_class_code($class_code, 1);
        $list_feedback_phone_2 = $this->get_list_phone_paper_by_class_code($class_code, 2);
        $list_feedback_phone_3 = $this->get_list_phone_paper_by_class_code($class_code, 3);
        $list_feedback_phone_4 = $this->get_list_phone_paper_by_class_code($class_code, 4);
        $count_phone = count($list_feedback_phone);
        $count_phone_1 = count($list_feedback_phone_1);
        $count_phone_2 = count($list_feedback_phone_2);
        $count_phone_3 = count($list_feedback_phone_3);
        $count_phone_4 = count($list_feedback_phone_4);

        $sum_phone_point = 0;
        $sum_phone_point_1 = 0;
        $sum_phone_point_2 = 0;
        $sum_phone_point_3 = 0;
        $sum_phone_point_4 = 0;
        foreach ($list_feedback_phone as $item) {
            $sum_phone_point += $item['point'];
        }
        foreach ($list_feedback_phone_1 as $item1) {
            $sum_phone_point_1 += $item1['point'];
        }

        foreach ($list_feedback_phone_2 as $item2) {
            $sum_phone_point_2 += $item2['point'];
        }

        foreach ($list_feedback_phone_3 as $item3) {
            $sum_phone_point_3 += $item3['point'];
        }


        foreach ($list_feedback_phone_4 as $item4) {
            $sum_phone_point_4 += $item4['point'];
        }


        if ($count_phone == 0) {
            $average_phone = 0;
        } else {
            $average_phone = round($sum_phone_point / $count_phone, 2);
        }
        if ($count_phone_1 == 0) {
            $average_phone_1 = 0;
        } else {
            $average_phone_1 = round($sum_phone_point_1 / $count_phone_1, 2);
        }

        if ($count_phone_2 == 0) {
            $average_phone_2 = 0;
        } else {
            $average_phone_2 = round($sum_phone_point_2 / $count_phone_2, 2);
        }

        if ($count_phone_3 == 0) {
            $average_phone_3 = 0;
        } else {
            $average_phone_3 = round($sum_phone_point_3 / $count_phone_3, 2);
        }

        if ($count_phone_4 == 0) {
            $average_phone_4 = 0;
        } else {
            $average_phone_4 = round($sum_phone_point_4 / $count_phone_4, 2);
        }


        // Thêm feedback KSGV lần 1
        $average_ksgv1 = 0;
        $data_ksgv1 = $this->get_list_feedback_ksgv($class_code, 'ksgv1');
        $count_ksgv1 = count($data_ksgv1);

        // ============== FEEDBACK
        $data = $data_ksgv1;
        $arr_info_question = array();
        $data_question_list = array();

        foreach ($data as $mono) {
            $detail = json_decode($mono['detail'], true);
            foreach ($detail as $mono_detail) {
                $id_quest = $mono_detail[0];
                $type = $mono_detail[1];
                $content = $mono_detail[2];
                $value = (string)$mono_detail[3];
                if (!isset($arr_info_question[$id_quest])) {
                    $arr_info_question[$id_quest] = array(
                        'type' => $type,
                        'title' => $content,
                    );
                }

                switch ($type) {
                    case 'select':
                        if (!isset($data_question_list[$id_quest])) {
                            $data_question_list[$id_quest] = array(
                                '1' => 0,
                                '2' => 0,
                                '3' => 0,
                                '4' => 0,
                                '5' => 0,
                                '6' => 0,
                                '7' => 0,
                                '8' => 0,
                                '9' => 0,
                                '10' => 0,
                            );
                        }
                        $now_count_list = $data_question_list[$id_quest];
                        if (array_key_exists($value, $now_count_list)) {
                            $now_count = $now_count_list[$value];
                            $now_count_list[$value] = $now_count + 1;
                        }
                        $data_question_list[$id_quest] = $now_count_list;
                        break;
                    default:
                }

            }
        }

        $arr_diem_trung_binh = array();
        foreach ($data_question_list as $id_question => $mono_question_list) {
            $sum = 0;
            $count = 0;
            foreach ($mono_question_list as $point => $number) {
                $point_int = (int)$point;
                $sum += $point_int * $number;
                $count += $number;
            }
            if ($count != 0) {
                $arr_diem_trung_binh[$id_question] = $sum / $count;
            } else {
                $arr_diem_trung_binh[$id_question] = 0;
            }
        }

        $sum_point_class_1 = 0;
        $count_question_1 = 0;
        foreach ($arr_diem_trung_binh as $id_question => $point) {
            if ($point > 0) {
                $count_question_1++;
                $sum_point_class_1 += $point;
            }
        }

        if ($count_question_1 != 0) {
            $average_point_class_1 = round($sum_point_class_1 / $count_question_1, 2);
        } else {
            $average_point_class_1 = 0;
        }

        $average_ksgv1 = $average_point_class_1;
        // ==============

        // Thêm feedback KSGV lần 2
        $average_ksgv2 = 0;
        $data_ksgv2 = $this->get_list_feedback_ksgv($class_code, 'ksgv2');
        $count_ksgv2 = count($data_ksgv2);
        // ============== FEEDBACK
        $data = $data_ksgv2;
        $arr_info_question = array();
        $data_question_list = array();

        foreach ($data as $mono) {
            $detail = json_decode($mono['detail'], true);
            foreach ($detail as $mono_detail) {
                $id_quest = $mono_detail[0];
                $type = $mono_detail[1];
                $content = $mono_detail[2];
                $value = (string)$mono_detail[3];
                if (!isset($arr_info_question[$id_quest])) {
                    $arr_info_question[$id_quest] = array(
                        'type' => $type,
                        'title' => $content,
                    );
                }

                switch ($type) {
                    case 'select':
                        if (!isset($data_question_list[$id_quest])) {
                            $data_question_list[$id_quest] = array(
                                '1' => 0,
                                '2' => 0,
                                '3' => 0,
                                '4' => 0,
                                '5' => 0,
                                '6' => 0,
                                '7' => 0,
                                '8' => 0,
                                '9' => 0,
                                '10' => 0,
                            );
                        }
                        $now_count_list = $data_question_list[$id_quest];
                        if (array_key_exists($value, $now_count_list)) {
                            $now_count = $now_count_list[$value];
                            $now_count_list[$value] = $now_count + 1;
                        }
                        $data_question_list[$id_quest] = $now_count_list;
                        break;
                    default:
                }
            }
        }

        $arr_diem_trung_binh = array();
        foreach ($data_question_list as $id_question => $mono_question_list) {
            $sum = 0;
            $count = 0;
            foreach ($mono_question_list as $point => $number) {
                $point_int = (int)$point;
                $sum += $point_int * $number;
                $count += $number;
            }
            if ($count != 0) {
                $arr_diem_trung_binh[$id_question] = $sum / $count;
            } else {
                $arr_diem_trung_binh[$id_question] = 0;
            }
        }

        $sum_point_class_2 = 0;
        $count_question_2 = 0;
        foreach ($arr_diem_trung_binh as $id_question => $point) {
            if ($point > 0) {
                $count_question_2++;
                $sum_point_class_2 += $point;
            }
        }

        if ($count_question_2 != 0) {
            $average_point_class_2 = round($sum_point_class_2 / $count_question_2, 2);
        } else {
            $average_point_class_2 = 0;
        }

        $average_ksgv2 = $average_point_class_2;
        // ==============

        // Thêm feedback online
        $data_online = $this->get_list_feedback_ksgv($class_code, 'dao_tao_onl');
        $count_feedback_online = count($data_online);
        // ============== FEEDBACK
        $arr_info_question = array();
        $data_question_list = array();

        foreach ($data_online as $mono) {
            $detail = json_decode($mono['detail'], true);
            foreach ($detail as $mono_detail) {
                $id_quest = $mono_detail[0];
                $type = $mono_detail[1];
                $content = $mono_detail[2];
                $value = (string)$mono_detail[3];
                if (!isset($arr_info_question[$id_quest])) {
                    $arr_info_question[$id_quest] = array(
                        'type' => $type,
                        'title' => $content,
                    );
                }

                switch ($type) {
                    case 'select':
                        if (!isset($data_question_list[$id_quest])) {
                            $data_question_list[$id_quest] = array(
                                '1' => 0,
                                '2' => 0,
                                '3' => 0,
                                '4' => 0,
                                '5' => 0,
                                '6' => 0,
                                '7' => 0,
                                '8' => 0,
                                '9' => 0,
                                '10' => 0,
                            );
                        }
                        $now_count_list = $data_question_list[$id_quest];
                        if (array_key_exists($value, $now_count_list)) {
                            $now_count = $now_count_list[$value];
                            $now_count_list[$value] = $now_count + 1;
                        }
                        $data_question_list[$id_quest] = $now_count_list;
                        break;
                    default:
                }
            }
        }

        $arr_diem_trung_binh = array();
        foreach ($data_question_list as $id_question => $mono_question_list) {
            $sum = 0;
            $count = 0;
            foreach ($mono_question_list as $point => $number) {
                $point_int = (int)$point;
                $sum += $point_int * $number;
                $count += $number;
            }
            if ($count != 0) {
                $arr_diem_trung_binh[$id_question] = $sum / $count;
            } else {
                $arr_diem_trung_binh[$id_question] = 0;
            }
        }
        $sum_point_class_onl = 0;
        $count_question_onl = 0;
        foreach ($arr_diem_trung_binh as $id_question => $point) {
            if ($point > 0) {
                $count_question_onl++;
                $sum_point_class_onl += $point;
            }
        }

        if ($count_question_onl != 0) {
            $average_point_class_onl = round($sum_point_class_onl / $count_question_onl, 2);
        } else {
            $average_point_class_onl = 0;
        }

        if($count_question + $count_phone > 0){
            $average_point = round(($sum_point_class + $sum_phone_point) / ($count_question + $count_phone), 2);
        }else {
            $average_point = 0;
        }

        $average_online = $average_point_class_onl;

        $number_feedback_homthugopy = $this->get_number_feedback_homthugopy_by_class_code($class_code);


        $this->db->set('point_ksgv1', $average_ksgv1, FALSE); // feedback phone
        $this->db->set('point_ksgv2', $average_ksgv2, FALSE); // feedback phone
        $this->db->set('point_online', $average_online, FALSE); // feedback online
        $this->db->set('point_phone', $average_phone, FALSE); // feedback phone
        $this->db->set('point_phone1', $average_phone_1, FALSE); // feedback phone 1
        $this->db->set('point_phone2', $average_phone_2, FALSE); // feedback phone 2
        $this->db->set('point_phone3', $average_phone_3, FALSE); // feedback phone 2
        $this->db->set('point_phone4', $average_phone_4, FALSE); // feedback phone 2
        $this->db->set('average_point', $average_point, FALSE); // điểm trung bình feedback form + feedback phone
        $this->db->set('point', $average_point_class, FALSE); // feedback form

        $this->db->set('number_feedback_phone', $count_phone, FALSE); // feedback form
        $this->db->set('number_feedback_phone_1', $count_phone_1, FALSE); // feedback form
        $this->db->set('number_feedback_phone_2', $count_phone_2, FALSE); // feedback form
        $this->db->set('number_feedback_phone_3', $count_phone_3, FALSE); // feedback form
        $this->db->set('number_feedback_phone_4', $count_phone_4, FALSE); // feedback form
        $this->db->set('number_feedback_ksgv1', $count_ksgv1, FALSE); // feedback form
        $this->db->set('number_feedback_ksgv2', $count_ksgv2, FALSE); // feedback form
        $this->db->set('number_feedback_online', $count_feedback_online, FALSE); // feedback form
        $this->db->set('number_feedback_homthugopy', $number_feedback_homthugopy, FALSE); // feedback form







        $this->db->where('class_code', $class_code);
        $this->db->update('feedback_class');

        return $average_point;
    }

    public function get_mark_point_feedback_phone_all_time($class_code)
    {
        $this->_tracking_func(__FUNCTION__);

        // Thêm feedback phone
        $list_phone_feedback = $this->get_list_phone_paper_by_class_code($class_code);

        $arr_times_val = array();
        foreach ($list_phone_feedback as $mono) {
            if (!in_array($mono['times'], $arr_times_val)) {
                array_push($arr_times_val, $mono['times']);
            }
        }

        $full_times_info = array();

        for ($i = 0; $i < count($arr_times_val); $i++) {
            $times_focus = $arr_times_val[$i];
            $time_newest = 0;
            $info_user = array();
            $total_point = 0;
            $count_point = 0;

            foreach ($list_phone_feedback as $item) {

                if ($item['times'] != $times_focus) {
                    continue;
                }
                $time_newest = max($time_newest, $item['time']);
                $id_user = $item['user_id_creat'];
                $mono_info = $this->feedback->get_info_user($id_user);
                $info_user[$id_user] = $mono_info;

                $point = $item['point'];
                $total_point += $point;
                $count_point++;
            }

            if ($count_point > 0) {
                $average_point = round($total_point / $count_point, 1);
            } else {
                $average_point = 0;
            }

            $full_times_info[$times_focus] = array(
                'count' => $count_point,
                'average_point' => $average_point,
                'time_newest' => $time_newest,
            );

        }

        return $full_times_info;
    }

    public function get_mark_point_feedback_form_all_time($class_code)
    {
        $this->_tracking_func(__FUNCTION__);

        $data_ksgv = $this->get_list_feedback_ksgv($class_code);
        $arr_times_val = array();
        $feedback_ksgv = array();
        foreach ($data_ksgv as $keyKSGV => $mono) {
            if (!in_array($mono['type'], $arr_times_val)) {
                array_push($arr_times_val, $mono['type']);
            }
            $feedback_ksgv[$mono['type']][] = $mono;
        }
        // ============== FEEDBACK
        $arr_info_question = array();
        $data_question_list = array();
        $average_ksgv = 0;
        if(count($feedback_ksgv) > 0) {
            foreach ($feedback_ksgv as $typefeedback => $ksgv) {
                foreach ($ksgv as $mono) {
                    $detail = json_decode($mono['detail'], true);
                    foreach ($detail as $mono_detail) {
                        $id_quest = $mono_detail[0];
                        $type = $mono_detail[1];
                        $content = $mono_detail[2];
                        $value = (string)$mono_detail[3];
                        if (!isset($arr_info_question[$id_quest])) {
                            $arr_info_question[$id_quest] = array(
                                'type' => $type,
                                'title' => $content,
                            );
                        }

                        switch ($type) {
                            case 'select':
                                if (!isset($data_question_list[$id_quest])) {
                                    $data_question_list[$id_quest] = array(
                                        '1' => 0,
                                        '2' => 0,
                                        '3' => 0,
                                        '4' => 0,
                                        '5' => 0,
                                        '6' => 0,
                                        '7' => 0,
                                        '8' => 0,
                                        '9' => 0,
                                        '10' => 0,
                                    );
                                }
                                $now_count_list = $data_question_list[$id_quest];
                                if (array_key_exists($value, $now_count_list)) {
                                    $now_count = $now_count_list[$value];
                                    $now_count_list[$value] = $now_count + 1;
                                }
                                $data_question_list[$id_quest] = $now_count_list;
                                break;
                            default:
                        }
                    }
                }
                $arr_diem_trung_binh = array();
                foreach ($data_question_list as $id_question => $mono_question_list) {
                    $sum = 0;
                    $count = 0;
                    foreach ($mono_question_list as $point => $number) {
                        $point_int = (int)$point;
                        $sum += $point_int * $number;
                        $count += $number;
                    }
                    if ($count != 0) {
                        $arr_diem_trung_binh[$id_question] = $sum / $count;
                    } else {
                        $arr_diem_trung_binh[$id_question] = 0;
                    }
                }
                $sum_point_class = 0;
                $count_question = 0;
                foreach ($arr_diem_trung_binh as $id_question => $point) {
                    if ($point > 0) {
                        $count_question++;
                        $sum_point_class += $point;
                    }
                }
                if ($count_question != 0) {
                    $average_point_class = round($sum_point_class / $count_question, 2);
                } else {
                    $average_point_class = 0;
                }
                $average_ksgv[$typefeedback] = array(
                    'average_point' => $average_point_class,
                    'count' => $count_question,
                );
            }
        }

        return $average_ksgv;
    }

    public function mark_point_all_class($type = '')
    {
        $this->_tracking_func(__FUNCTION__);

//        $this->mark_down_last_id_feedback_phone_and_form(); // relate to type ?
        $list_class_code = $this->get_list_class_code($type);
        foreach ($list_class_code as $mono_class_code) {
            $class_code = $mono_class_code['class_code'];
            $this->mark_point_class($class_code);
        }
    }

    public function mark_point_all_class_smart()
    {

        $this->_tracking_func(__FUNCTION__);

        $info_last_time_mark_point = $this->get_last_time_max_id_feedback_phone_and_form();


        $arr_id_max_now = $this->get_now_feedback_phone_and_form();
//        $feedback_paper_id_max = $arr_id_max_now['feedback_paper_id_max'];
//        $feedback_phone_id_max = $arr_id_max_now['feedback_phone_id_max'];

        $last_feedback_paper_id_max = $info_last_time_mark_point['last_feedback_paper_id_max'];
        $last_feedback_phone_id_max = $info_last_time_mark_point['last_feedback_phone_id_max'];

        $arr_class_code = [];

        // ===========================
        $this->db->where('id >', $last_feedback_paper_id_max);
        $this->db->select('class_code');
        $query = $this->db->get('feedback_paper');
        $arr_res1 = $query->result_array();
        // ===========================
        foreach ($arr_res1 as $item) {
            array_push($arr_class_code, $item['class_code']);
        }

        // ===========================
        $this->db->where('id >', $last_feedback_phone_id_max);
        $this->db->select('class_code');
        $query = $this->db->get('feedback_phone');
        $arr_res2 = $query->result_array();
        foreach ($arr_res2 as $item) {
            array_push($arr_class_code, $item['class_code']);
        }

        $list_class_code = array_values(array_unique($arr_class_code));

        foreach ($list_class_code as $mono_class_code) {
            $class_code = $mono_class_code['class_code'];
            $this->mark_point_class($class_code);
        }

        $this->mark_down_last_id_feedback_phone_and_form($arr_id_max_now);
    }

    public function mark_down_last_id_feedback_phone_and_form($arr_id_max_now)
    {
        $this->_tracking_func(__FUNCTION__);

        $this->db->set('last_feedback_paper_id_max', $arr_id_max_now['feedback_paper_id_max'], FALSE);
        $this->db->set('last_feedback_phone_id_max', $arr_id_max_now['feedback_phone_id_max'], FALSE);
        $this->db->where('site_id', 1);
        $this->db->update('setting');
    }

    public function get_last_time_max_id_feedback_phone_and_form()
    {
        $this->_tracking_func(__FUNCTION__);

        $this->db->where('site_id', 1);
        $this->db->select('last_feedback_paper_id_max,last_feedback_phone_id_max');
        $query = $this->db->get('setting');
        $arr_res = $query->result_array();
        return $arr_res[0];
    }

    public function get_now_feedback_phone_and_form()
    {
        $this->_tracking_func(__FUNCTION__);

        $this->db->select_max('id');
        $query = $this->db->get('feedback_paper');  // Produces: SELECT MAX(age) as age FROM members
        $res = $query->result_array();
        $feedback_paper_id_max = (int)$res[0]['id'];

        $this->db->select_max('id');
        $query = $this->db->get('feedback_phone');  // Produces: SELECT MAX(age) as age FROM members
        $res = $query->result_array();
        $feedback_phone_id_max = (int)$res[0]['id'];

        return [
            'feedback_paper_id_max' => $feedback_paper_id_max,
            'feedback_phone_id_max' => $feedback_phone_id_max,
        ];
    }


    // Location

    public function get_list_location($area = '')
    {
        $this->_tracking_func(__FUNCTION__);

        if ($area != '') {
            $this->db->where('area', $area);
        }
        $this->db->order_by('area', 'ASC');

        $query = $this->db->get('feedback_location');
        $arr_res = $query->result_array();
        return $arr_res;
    }

    public function insert_location($info)
    {
        $this->_tracking_func(__FUNCTION__);

//        $info = array(
//            'name' => $name,
//            'area' => $area,
//        );
        $this->db->insert('feedback_location', $info);
    }

    public function edit_location($info)
    {
        $this->_tracking_func(__FUNCTION__);

        $this->db->where('id', $info['id']);
        $this->db->replace('feedback_location', $info);
    }

    public function del_location($info)
    {
        $this->_tracking_func(__FUNCTION__);

        $this->db->delete('feedback_location', array('id' => $info['id']));
    }

    public function get_info_location_by_id($id_location)
    {
        $this->_tracking_func(__FUNCTION__);

        $this->db->where('id', $id_location);
        $this->db->select('*');
        $query = $this->db->get('feedback_location');
        $arr_res = $query->result_array();
        return $arr_res[0];
    }


    // RING THE BELL

    public function ring_the_bell($info)
    {
        $this->_tracking_func(__FUNCTION__);

        $plus = array(
            'time' => time(),
        );
        $data = array_merge($info, $plus);
        $this->db->insert('feedback_bell', $data);
    }

    public function change_status($bell_id, $status)
    {
        $this->_tracking_func(__FUNCTION__);

        $this->db->set('status', $status, FALSE); // feedback form
        $this->db->where('id', $bell_id);
        $this->db->update('feedback_bell');
    }

    public function get_list_bell()
    {
        $this->_tracking_func(__FUNCTION__);

//            $this->db->where('id_noti',$id_noti);
        $this->db->select('*');
        $this->db->limit(1000);
        $this->db->order_by('time', 'DESC');
        $query = $this->db->get('feedback_bell');
        $arr_res = $query->result_array();
        return $arr_res;
    }

    // TOKEN VIEW FOR Teacher
    public function get_token_view_class($class_code)
    {
        $this->_tracking_func(__FUNCTION__);

        $this->db->where('class_code', $class_code);
        $this->db->select('*');
        $query = $this->db->get('feedback_token');
        $arr_res = $query->result_array();
        if (count($arr_res) > 0) {
            return $arr_res[0]['token'];
        } else {
            return $this->generate_new_token_view_class_if_not_exist($class_code);
        }
    }

    public function generate_new_token_view_class_if_not_exist($class_code)
    {
        $this->_tracking_func(__FUNCTION__);

        $this->db->where('class_code', $class_code);
        $this->db->select('*');
        $query = $this->db->get('feedback_token');
        $arr_res = $query->result_array();
        if (count($arr_res) > 0) {
            return $arr_res[0]['token'];
        } else {
            $token = generateRandomString(10) . time();
            $info = array(
                'class_code' => $class_code,
                'token' => $token,
            );
            $this->db->insert('feedback_token', $info);
            return $token;
        }
    }

    public function check_token_view_class_statics($class_code, $token)
    {
        $this->_tracking_func(__FUNCTION__);

        $formal_token = $this->get_token_view_class($class_code);
        if ($token == $formal_token) {
            return true;
        } else {
            return false;
        }
    }

}


