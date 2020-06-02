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

            // Luyện đề tách riêng và ko liên quan đến ngày nhận feedback của lớp
            if ($info['type'] === 'luyende'){

                $info = [
                    'type' => $this->input->post('type_class'),
                    'class_code' => $this->input->post('class_code'),
                    'hoten' => $this->input->post('hoten'),
                    'phone' => $this->input->post('phone'),
                    'email' => $this->input->post('email'),
                    'level' => $this->input->post('level'),
                    'shift' => $this->input->post('shift'),
                ];
                $info_gg_sheets = [
                    'type' => strip_tags($this->input->post('type')),
                    'type_class' => $this->input->post('type_class'),
                    'class_code' => $this->input->post('class_code'),
                    'hoten' => $this->input->post('hoten'),
                    'phone' => $this->input->post('phone'),
                    'email' => $this->input->post('email'),
                    'level' => $this->input->post('level'),
                    'shift' => $this->input->post('shift'),
                ];

                $this->feedback->insert_feedback_luyen_de($info);
                $this->input_gg_sheets($info_gg_sheets);
                var_dump($info['type']);
                echo '<pre>'; print_r($_REQUEST); echo '</pre>';
                exit;
            }

            // Danh sách đăng ký
            if ($info['type'] === 'thicuoiky'){
                $dataCheck = array(
                    'class_code' => $this->input->post('class_code'),
                    'email' => $this->input->post('email'),
                );
                $check = $this->feedback->check_thicuoiky($dataCheck);
                if(count($check) > 0) {
                    echo json_encode(array('error' => true, 'message' => 'Bạn đã đăng ký trước đó'));
                    exit();
                }
                $info = [
                    'type' => $this->input->post('type_class'),
                    'class_code' => $this->input->post('class_code'),
                    'hoten' => $this->input->post('hoten'),
                    'phone' => $this->input->post('phone'),
                    'email' => $this->input->post('email'),
                    'shift' => $this->input->post('shift'),
                ];
                $info_gg_sheets = [
                    'type' => strip_tags($this->input->post('type')),
                    'type_class' => $this->input->post('type_class'),
                    'class_code' => $this->input->post('class_code'),
                    'hoten' => $this->input->post('hoten'),
                    'phone' => $this->input->post('phone'),
                    'email' => $this->input->post('email'),
                    'shift' => $this->input->post('shift'),
                ];
                $this->feedback->insert_feedback_thicuoiky($info);
                $this->input_gg_sheets($info_gg_sheets);
                echo json_encode(array('error' => false, 'message' => 'Đăng ký thành công'));
                exit();
            }

            if ($info['type'] === 'homthugopy'){
                $this->feedback->insert_feedback_paper_hom_thu_gop_y($info);
                $this->input_gg_sheets($info);
                echo json_encode(array('error' => false, 'message' => 'Đăng ký thành công'));
                exit();
            }

            if ($info['type'] === 'hocviengopy'){
                $info = array_merge(array('phone' => (int)strip_tags($this->input->post('phone')), 'location' => (int)strip_tags($this->input->post('location'))), $info);
                $this->feedback->insert_feedback_paper_hom_thu_gop_y($info);
                $this->input_gg_sheets($info);
                echo json_encode(array('error' => false, 'message' => 'Gửi thành công'));
                exit();
            }
            else{
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
                            $this->input_gg_sheets($info);
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

    public function suggest_class_code(){
        $keyword = $this->input->get("term");
        $location = (int)$this->input->get("location_id");
        $page = (int) $this->input->get('page');
        $page = ($page > 1) ? $page : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $this->load->model('Feedback_model', 'fb');
        $params = array('limit' => $limit,'keyword' => $keyword,'offset' => $offset,'id_location' => $location);
        $arrClass = $this->fb->get_list_class_code_opening_filter($params);
        $totalClass = $this->fb->total_list_class_code_opening_filter($params);
        $data = $option = array();
        if ($totalClass > $page*$limit) {
            $option['nextpage'] = true;
            unset($arrClass[$limit]);
        }
        foreach ($arrClass as $key => $class) {
            $data[] = array('id' => $class['class_code'], 'text' => $class['class_code'],'item_id' => $class['class_code']);
        }
        return $this->output->set_output(json_encode(array('status' => 'success','data' => $data,'option' => $option)));
    }
    public function suggest_location(){
        $keyword = $this->input->get("term");
        $page = (int) $this->input->get('page');
        $page = ($page > 1) ? $page : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $this->load->model('Feedback_model', 'fb');
        $params = array('limit' => $limit,'keyword' => $keyword,'offset' => $offset);
        $arrLocation = $this->fb->get_list_location_filter($params);
        $totalLocation = $this->fb->total_list_location($params);
        $data = $option = array();
        if ($totalLocation > $page*$limit) {
            $option['nextpage'] = true;
            unset($arrLocation[$limit]);
        }
        foreach ($arrLocation as $key => $location) {
            $data[] = array('id' => $location['id'], 'text' => $location['name'].' - '.$location['area'],'item_id' => $location['id']);
        }
        return $this->output->set_output(json_encode(array('status' => 'success','data' => $data,'option' => $option)));
    }
    public function input_gg_sheets($info)
    {
        $this->load->model('Feed_upgrade_model','fu');
        $client = getClientGoogle();
        $service = new Google_Service_Sheets($client);
        switch($info['type']){
            case 'luyende':
                $shift_text = [
                    's_t7' => 'Sáng thứ 7',
                    'c_t7' => 'Chiều thứ 7',
                    's_cn' => 'Sáng CN',
                ];
                $location = $this->fu->get_location_by_class_code($info['class_code']);
                $spreadsheetId = '1jGJmYnSkkuwNNs9cYbokywzLQkOGMvCjYzy8smnHVD0';
                $arr_insert = array($info['hoten'], $info['phone'], $info['email'], $location['name'].' - '.$location['area'], $info['class_code'], $shift_text[$info['shift']]);
                $values_insert = [
                    $arr_insert
                ];
                break;
            case 'thicuoiky':
                $shift_text = [
                    's_04' => '09:00 Thứ 5, ngày 04/06/2020',
                    's_06' => '09:00 Thứ 7, ngày 06/06/2020',
                    'c_06' => '14:00 Thứ 7, ngày 06/06/2020',
                    'c_09' => '14:00 Thứ 3, ngày 09/06/2020',
                    's_11' => '09:00 Thứ 5, ngày 11/06/2020',
                    's_13' => '09:00 Thứ 7, ngày 13/06/2020',
                    'c_13' => '14:00 Thứ 7, ngày 13/06/2020',
                ];
                $location = $this->fu->get_location_by_class_code($info['class_code']);
                $spreadsheetId = '1kDEtnNqqh4BvagIRXhM8uFthU35yo9Cxlf8AK7rwClg';
                $arr_insert = array($info['hoten'], $info['phone'], $info['email'], $location['name'].' - '.$location['area'], $info['class_code'], $shift_text[$info['shift']]);
                $values_insert = [
                    $arr_insert
                ];
                break;
            case 'homthugopy':
                $spreadsheetId = '1dqHV1M0s1fw5LgYCmrTgZOKAuK8BD1VMO2lANPhbW0k';
                $detail_live = json_decode($info['detail']);
                $comment = $detail_live[0][3];
                $arr_insert = array($info['class_code'], date('d/m/Y', time()), $info['name_feeder'], $comment);
                $values_insert = [
                    $arr_insert
                ];
                break;
            case 'hocviengopy':
                $spreadsheetId = '1dqHV1M0s1fw5LgYCmrTgZOKAuK8BD1VMO2lANPhbW0k';
                $detail_live = json_decode($info['detail']);
                $comment = $detail_live[0][3];
                $location = $this->fu->get_location_by_class_code($info['class_code']);
                $teacher = $this->fu->get_teacher_by_class_code($info['class_code']);
                $type_class = $this->fu->get_type_class_by_class_code($info['class_code']);
                $arr_insert = array($location['name'].' - '.$location['area'], $info['class_code'], $teacher['manager_email'],$teacher['name'],$info['name_feeder'],$info['phone'], date('d/m/Y', time()), $info['name_feeder'], $comment,'https://qlcl.imap.edu.vn/feedback/hom_thu_gop_y_detail?class='.$info['class_code']);
                $range_insert = $type_class['type'];
                $values_insert = [
                    $arr_insert
                ];
                break;
            case 'ksgv2':
                $spreadsheetId = '1ODlEKHavL4xLGRqZA_xFM_qsI5uL2ovDN2cqQQq1jtk';
                $classLink = 'https://qlcl.imap.edu.vn/feedback/feedback_ksgv_detail?class_code='.$info['class_code'].'&type_ksgv='.$info['type'];
                $arr_insert = [$info['type'],$info['class_code']];
                $teacher = $this->fu->get_teacher_by_class_code($info['class_code']);
                $arr_insert = array_merge($arr_insert, array($teacher['manager_email'],$teacher['name'],$info['name_feeder'], date('d/m/Y', time())));
                $detail_live = json_decode($info['detail']);
                $mono__sum = 0;
                $mono__count = 0;
                foreach ($detail_live as $keyDetail => $detail) {
                    if(count($detail_live) > 9) {
                        // Bỏ câu hỏi số 4 và số 8
                        if ( ($keyDetail == 3) || ($keyDetail == 7)){
                            continue;
                        }
                    }

                    $type = $detail[1];
                    if ($type === 'select'){
                        $mono_point = (int)$detail[3];
                        if ($mono_point >0){
                            $mono__sum += $mono_point;
                            $mono__count ++;
                        }
                    }elseif($type === 'ruler'){
                        $mono_point = (int)$detail[3]*2;
                        if ($mono_point >0){
                            $mono__sum += $mono_point;
                            $mono__count ++;
                        }
                    }else{
                        $content = $detail[3];
                        $mono_point = $content;
                    }
                    $arr_insert = array_merge($arr_insert, array($mono_point));
                    // check nếu k có câu trả lời dạng text thì hiển thị cột rỗng tránh lỗi bảng
                    if(count($detail_live) > 9 && $keyDetail == 9) {
                        if($keyDetail == 9){
                            $arr_insert = array_merge($arr_insert, array(''));
                        }
                    }
                    $x++;
                }
                if ($mono__count > 0){
                    $point_round = round($mono__sum / $mono__count,2);
                }else{
                    $point_round = 0;
                }
                $arr_insert = array_merge($arr_insert, array((int)$point_round, $classLink));
                $values_insert = [
                    $arr_insert
                ];
                break;
            case 'dao_tao_onl':
                $spreadsheetId = '1UehwKmNe5U7v5RkAX0suplh-5o_iCwrVSYMH2OzcI3s';
                $classLink = 'https://qlcl.imap.edu.vn/feedback/feedback_ksgv_detail?class_code='.$info['class_code'].'&type_ksgv='.$info['type'];
                $arr_insert = [$info['type'],$info['class_code']];
                $teacher = $this->fu->get_teacher_by_class_code($info['class_code']);
                $arr_insert = array_merge($arr_insert, array($teacher['manager_email'],$teacher['name'],$info['name_feeder'], date('d/m/Y', time())));
                $detail_live = json_decode($info['detail']);
                $mono__sum = 0;
                $mono__count = 0;
                foreach ($detail_live as $keyDetail => $detail) {
                    if(count($detail_live) > 9) {
                        // Bỏ câu hỏi số 4 và số 8
                        if ( ($keyDetail == 3) || ($keyDetail == 7)){
                            continue;
                        }
                    }

                    $type = $detail[1];
                    if ($type === 'select'){
                        $mono_point = (int)$detail[3];
                        if ($mono_point >0){
                            $mono__sum += $mono_point;
                            $mono__count ++;
                        }
                    }elseif($type === 'ruler'){
                        $mono_point = (int)$detail[3]*2;
                        if ($mono_point >0){
                            $mono__sum += $mono_point;
                            $mono__count ++;
                        }
                    }else{
                        $content = $detail[3];
                        $mono_point = $content;
                    }
                    $arr_insert = array_merge($arr_insert, array($mono_point));
                    // check nếu k có câu trả lời dạng text thì hiển thị cột rỗng tránh lỗi bảng
                    if(count($detail_live) > 9 && $keyDetail == 9) {
                        if($keyDetail == 9){
                            $arr_insert = array_merge($arr_insert, array(''));
                        }
                    }
                    $x++;
                }
                if ($mono__count > 0){
                    $point_round = round($mono__sum / $mono__count,2);
                }else{
                    $point_round = 0;
                }
                $arr_insert = array_merge($arr_insert, array((int)$point_round, $classLink));
                $values_insert = [
                    $arr_insert
                ];
                break;

            default:
                return true;
                break;
        }

        // data update
        /*
        $values_insert_true = array(
            array(
                'Y',
            ),
        );
        $body_true = new Google_Service_Sheets_ValueRange([
            'values' => $values_insert_true
        ]);

        $values_insert_false = array(
            array(
                'N',
            ),
        );
        $body_false = new Google_Service_Sheets_ValueRange([
            'values' => $values_insert_false
        ]);

        $params = [
            'valueInputOption' => 'RAW'
        ];
        // end data update

        // get from google sheet
        $range = 'Sheet1';
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();
//        var_dump($values); die;
        foreach ($values as $key => $value){
            if($value[14] && $value[14] == 'Y'){ // update Column O = N if data column O = Y
                $r[$key] = $service->spreadsheets_values->update($spreadsheetId,$range.'!O'.($key+1),$body_false,$params);
            } else { // update Column O = Y if data column O = N or = null
                $r[$key] = $service->spreadsheets_values->update($spreadsheetId,$range.'!O'.($key+1),$body_true,$params);
            }
        }
        var_dump($r,$values); die;
        */
        // import to google sheet
        if(empty($range_insert)) {
            $range_insert= "Sheet1"; // cái này để chọn khu vực ghi mới, update full: 'LadiPage!A1:N1'
        }
        $body = new Google_Service_Sheets_ValueRange([
            'values' => $values_insert
        ]);
        $params = [
            'valueInputOption' => 'RAW'
        ];
        $insert = [ // cái này dành cho ghi mới
            'insertDataOption' => 'INSERT_ROWS'
        ];
        try {
            $result = $service->spreadsheets_values->append($spreadsheetId,$range_insert,$body,$params,$insert); // cái này ghi mới dữ liệu
//            $result = $service->spreadsheets_values->update($spreadsheetId,$range_insert,$body,$params); // cái này update dữ liệu
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        return $result;
        // end import to google sheet

        //get from google sheet
        /*
        if (empty($values)) {
            print "No data found.\n";
        } else {
            print "Name, Major:\n";
            foreach ($values as $row) {
                // Print columns A and E, which correspond to indices 0 and 4.
                printf("%s, %s\n", $row[0], $row[4]);
            }
        } */
        // end get from google sheet
    }
}