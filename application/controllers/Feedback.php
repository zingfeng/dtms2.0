<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback extends CI_Controller
{

    public function index()
    {
        guard();
        guard_admin_manager();
        // md bootstrap
        // Quản lý danh sách lớp
        // Quản lý danh sách giảng viên
        // 1 view
        //
        $this->load->model('Feedback_model', 'feedback');

        // quá hạn khảo sát
        $feedback_notify = $this->feedback->get_list_class_out_of_date();

        // sắp tới khảo sát
        $feedback_survey = $this->feedback->get_list_class_survey();

        $top_class_ielts = $this->feedback->get_top_class_feedback_newest(15, 'ielts');
        $top_class_toeic = $this->feedback->get_top_class_feedback_newest(15, 'toeic');
        $top_class_giaotiep = $this->feedback->get_top_class_feedback_newest(15, 'giaotiep');
        $top_class_aland = $this->feedback->get_top_class_feedback_newest(15, 'aland');

        // lazy code
        $list_feedback_phone_newestSS = $this->feedback->get_list_feedback_phone_newest(100);
        $array_class_code_feedback_phone = array();
        $array_class_code_feedback_phone_type = array(); // ielts => array()
        for ($i = 0; $i < count($list_feedback_phone_newestSS); $i++) {
            $mono = $list_feedback_phone_newestSS[$i];
            $class_code_mono = $mono['class_code'];
            if (! in_array($class_code_mono,$array_class_code_feedback_phone)){
                array_push($array_class_code_feedback_phone,$class_code_mono);
            }
        }

        for ($i = 0; $i < count($array_class_code_feedback_phone); $i++) {
            $supermono_classcode = $array_class_code_feedback_phone[$i];
            if ($this->feedback->check_class_code_exist($supermono_classcode)){
                $info_class_super = $this->feedback->get_info_class_by_class_code($supermono_classcode);
                $type = $info_class_super['type'];
                if(! isset($array_class_code_feedback_phone_type[$type])){
                    $array_class_code_feedback_phone_type[$type] = array();
                }
                array_push($array_class_code_feedback_phone_type[$type],$supermono_classcode);
            }
        }

        // ======== Lấy điểm của lớp
        $arr_info_class = array(); // class_code => class_info

        for ($i = 0; $i < count($array_class_code_feedback_phone); $i++) {
            $su_per_class_code = $array_class_code_feedback_phone[$i];
            if (isset($arr_info_class[$su_per_class_code])){continue; }
            $arr_info_class[$su_per_class_code] = $this->feedback->get_info_class_by_class_code($su_per_class_code);
        }

        $arr_new_feedback_form = array_merge($top_class_ielts,$top_class_toeic,$top_class_giaotiep,$top_class_aland);

        for ($i = 0; $i < count($arr_new_feedback_form); $i++) {
            $su_per_class_info = $arr_new_feedback_form[$i];
            $su_per_class_info_live = json_decode($su_per_class_info,true);
            $su_per_class_code = $su_per_class_info_live[1];
            if (isset($arr_info_class[$su_per_class_code])){continue; }
            $arr_info_class[$su_per_class_code] = $this->feedback->get_info_class_by_class_code($su_per_class_code);
        }

        $list_feedback_newest = $this->feedback->get_list_feedback_paper('', '', 'time_end');
        $list_feedback_newest = array_slice($list_feedback_newest, 0, 100); // 100 feed back mới nhất

        $list_feedback_phone_newest = $this->feedback->get_list_feedback_phone_newest(100);

        $info = $this->feedback->get_all_info_system();

        $teacher_info = $this->feedback->get_list_info_teacher();
        $arr_techer_id_to_teacher_info = array();
        for ($i = 0; $i < count($teacher_info); $i++) {
            $mono_teacher_info = $teacher_info[$i];
            $arr_techer_id_to_teacher_info[$mono_teacher_info['teacher_id']] = $mono_teacher_info;
        }
        $location_info = $this->feedback->get_list_location();
        $arr_location_id_to_location_info = array();
        for ($i = 0; $i < count($location_info); $i++) {
            $mono_location_info = $location_info[$i];
            $arr_location_id_to_location_info[$mono_location_info['id']] = $mono_location_info;
        }

        $info_giaotiep = $this->feedback->get_all_info_system_by_type('giaotiep');
        $info_toeic = $this->feedback->get_all_info_system_by_type('toeic');
        $info_ielts = $this->feedback->get_all_info_system_by_type('ielts');
        $info_aland = $this->feedback->get_all_info_system_by_type('aland');
        $data = array(
            'list_feedback_newest' => $list_feedback_newest, // feedback form
            'list_feedback_phone_newest' => $list_feedback_phone_newest,
            'top_class_ielts' => $top_class_ielts,
            'top_class_toeic' => $top_class_toeic,
            'top_class_giaotiep' => $top_class_giaotiep,
            'top_class_aland' => $top_class_aland,
            'array_class_code_feedback_phone_type' => $array_class_code_feedback_phone_type,
            'arr_info_class' => $arr_info_class,
            'info_giaotiep' => $info_giaotiep,
            'info_toeic' => $info_toeic,
            'info_ielts' => $info_ielts,
            'info_aland' => $info_aland,
            'arr_location_id_to_location_info' => $arr_location_id_to_location_info,
            'arr_techer_id_to_teacher_info' => $arr_techer_id_to_teacher_info,
            'feedback_notify' => $feedback_notify,
            'feedback_survey' => $feedback_survey
        );
        $data = array_merge($data, $info);

        $this->load->layout('feedback/dashboard', $data, false, 'layout_feedback');
    }

    public function dashboard_tuvan()
    {
        guard();
        // md bootstrap
        // Quản lý danh sách lớp
        // Quản lý danh sách giảng viên
        // 1 view
        //
        $this->load->model('Feedback_model', 'feedback');
        $id_location = $_SESSION['id_location'];
        $list_class_code = $this->feedback->get_list_class_code_by_location($id_location);
        // $list_class_code = arr( [0] => array( 'class_code' =>
        $list_class_code_target = array();
        foreach ($list_class_code as $item) {
            array_push($list_class_code_target, $item['class_code']);
        }


        $list_feedback_newest = $this->feedback->get_list_feedback_paper('', '', 'time_end');

        $list_feedback_newest_suitable = array();
        foreach ($list_feedback_newest as $item_mono) {
            $class_code_mono = $item_mono['class_code'];
            if (in_array($class_code_mono, $list_class_code_target)) {
                array_push($list_feedback_newest_suitable, $item_mono);
            }
        }

        $list_feedback_newest = array_slice($list_feedback_newest_suitable, 0, 200); // 100 feed back mới nhất

        $info = $this->feedback->get_all_info_system();
        $data = array(
            'list_feedback_newest' => $list_feedback_newest,
        );
        $data = array_merge($data, $info);

        $this->load->layout('feedback/dashboard_tuvan', $data, false, 'layout_feedback_tuvan');

    }

    public function update_all_feedback_time() {
        $this->load->model('Feedback_model', 'feedback');
        $list_class_code = $this->feedback->get_list_class_code();
        foreach ($list_class_code as $mono_class_code) {
            $class_code = $mono_class_code['class_code'];
            if(empty($mono_class_code['time_feedback1']) || $mono_class_code['time_feedback1'] == null || empty($mono_class_code['time_feedback2']) || $mono_class_code['time_feedback2'] == null) {
                $data = $this->update_time_feedback($class_code, $mono_class_code);
                var_dump($data);
            }
        }
    }

    private function update_time_feedback($class_code, $detail_class = array()){
        $this->load->model('Feedback_model', 'feedback');
        if(count($detail_class) == 0) {
            $detail_class = $this->feedback->get_info_class_by_class_code($class_code);
        }
        $dayofweek = (int)date('w', strtotime($detail_class['opening_day']))+1;
        $time_feedback = new DateTime($detail_class['opening_day']);
        if($dayofweek < 6){
            $time_feedback1 = $time_feedback->modify('+11 day')->getTimestamp();
        }else {
            $time_feedback1 = $time_feedback->modify('+12 day')->getTimestamp();
        }
        $time_feedback2 = $time_feedback->modify('+25 day')->getTimestamp();
        $info = array(
            'class_id' => strip_tags($detail_class['class_id']),
            'time_feedback1' => $time_feedback1,
            'time_feedback2' => $time_feedback2
        );
        $status = $this->feedback->update_class($info);
        $data = array(
            'info' => $info,
            'staus' => $status
        );
        return $data;
    }

    public function login()
    {
        $this->load->model('Feedback_model', 'feedback');
        if (check_login()) {
            if (($_SESSION['role'] == 'admin') || ($_SESSION['role'] == 'manager')) {
                redirect('/feedback');
            } else {
                redirect('/feedback/class_tuvan');
            }
        }

        session_start();
        $data = array();
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            {
                // check tài khoản trong db
                $res = $this->feedback->checkPasswd($username, $password);
                if (!$res['result']) {
                    // Lỗi
                    $data['error'] = $res['message'];
                    echo $this->load->view('feedback/login', $data, true);
                } else {
                    // Thành công
                    $role = $res['role'];
                    $fullname = $res['fullname'];
                    $id_location = $res['id_location'];
                    $id = $res['id'];

                    $_SESSION['token'] = md5($username . '_feedback_sys_Aug_2019');
                    $_SESSION['username'] = $username;
                    $_SESSION['fullname'] = $fullname;
                    $_SESSION['role'] = $role;
                    $_SESSION['id_location'] = $id_location;
                    $_SESSION['id'] = $id;

                    if ($role == 'tuvan') {
                        redirect('/feedback/class_tuvan');
                    } else {
                        redirect('/feedback');
                    }
                }
            }
        } else {
//            $data['error'] = 'ko có gì';
            echo $this->load->view('feedback/login', $data, true);
        }

    }

    // ==========================

    // Quản lý danh sách tư vấn
    public function tuvan()
    {
        guard();
        guard_admin_manager();

        $this->load->model('Feedback_model', 'feedback');
        $location_info = $this->feedback->get_list_location();
        $tuvan_info = $this->feedback->get_list_tuvan();

        $location_list = array();

        foreach ($location_info as $mono_location) {
            $location_list[$mono_location['id']] = $mono_location;
        }

        $data = array(
            'location_info' => $location_info,
            'tuvan_info' => $tuvan_info,
            'location_list' => $location_list,
        );

        $this->load->layout('feedback/tuvan', $data, false, 'layout_feedback');
    }

    public function mark_point_class(){
        $this->load->model('Feedback_model', 'feedback');
        $data = array(
            'status' => 0,
            'average_point' => 0
        );
        if (isset($_POST['class_code'])) {
            $average_point = $this->feedback->mark_point_class($_POST['class_code']);
            $data = array(
                'status' => 1,
                'average_point' => $average_point
            );
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] == 1) {
            echo json_encode($data);
            exit;
        } else {
            return $data;
        }
    }

    // ========================== Receive feedback
    public function send_feedback()
    {
        $this->load->model('Feedback_model', 'feedback');
        if ($this->check_token()) {
            $info = array(
                'type' => strip_tags($this->input->post('type')), //   ieltsfighter - giaotiep - toeic - aland - slide
                'class_code' => strip_tags($this->input->post('class_code')), //
                'time_start' => (int)strip_tags($this->input->post('time_start')),
                'detail' => strip_tags($this->input->post('detail')),
                'name_feeder' => strip_tags($this->input->post('name_feeder')),
            );

            // TH hom thu gop y la ngoai le ko can validate
            var_dump($info['type']);
            echo '<pre>'; print_r($_REQUEST); echo '</pre>';

            if ($info['type'] === 'homthugopy'){
                $this->feedback->insert_feedback_paper_hom_thu_gop_y($info);
            }else{
                if ($this->_validate()) {
                    switch($info['type']){
                        case 'slide':
                            $this->feedback->insert_feedback_paper_slide($info);
                            break;
                        case 'ksgv1':
                        case 'ksgv2':
                        case 'dao_tao_onl':
                            $info['age'] = strip_tags($this->input->post('age'));
                            $this->feedback->insert_feedback_paper_ksgv($info);
                            break;
                        case 'zoom':
                            $this->feedback->insert_feedback_zoom($info);
                            break;
                        default:
                            $this->feedback->insert_feedback_paper($info);
                            break;
                    }
                    echo 'Ok';
                }
            }


        } else {
            echo 'Wrong token';
            exit;
        }
    }

    // ========================== Underground
    private function _validate()
    {
        $this->load->model('Feedback_model', 'feedback');
        if (isset($_POST['class_code'])) {
            // check class code exist or in time
            $res = $this->feedback->check_class_feedback_openning($_POST['class_code']);
            return $res;
        }
        return false;
    }

    private function check_token()
    {
        if (isset($_POST['token']) && (isset($_POST['time_start']))) {


            $token_feedback = $this->config->item('token_feedback');
            $token_formal = md5($token_feedback . $_POST['time_start']);
            if ($token_formal === $_POST['token']) {
                return true;
            }
        }
        return false;
    }

    public function log_send_report_tuvan(){
        guard();
        $user_id_filter = (int) $_SESSION['id'];
        $this->load->model('Feed_upgrade_model','fu');
        $r = $this->fu->get_list_bell($user_id_filter);
        $data = array(
            'get_list_bell' => $r,
        );
        $this->load->layout('feedback/log_send_report', $data, false, 'layout_feedback_tuvan');
    }

    public function log_send_report(){
        guard();
        guard_admin_manager();

        $this->load->model('Feed_upgrade_model','fu');
        $r = $this->fu->get_list_bell();
        $data = array(
            'get_list_bell' => $r,
        );

        $this->load->layout('feedback/log_send_report', $data, false, 'layout_feedback');
    }

    public function logout()
    {
        session_start();
        session_destroy();
        redirect('/feedback/login');
    }

}