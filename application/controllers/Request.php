<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request extends CI_Controller
{
    public function index()
    {
        if (check_login() !== true) {
            echo 'wrong token';
            exit;
        }

        $this->load->model('Feedback_model', 'feedback');
        // check security

        if (isset($_POST['optcod'])) {
            switch ($_POST['optcod']) {
                case 'insert_tuvan':

                    if (($_POST['tuvan_active_insert'] == true) || ($_POST['tuvan_active_insert'] == 'true')) {
                        $_POST['tuvan_active_insert'] = 1;
                    } else {
                        $_POST['tuvan_active_insert'] = 0;
                    }

                    $info = array(
                        'fullname' => strip_tags($_POST['name_tuvan_insert']),
                        'username' => strip_tags($_POST['username_tuvan_insert']),
                        'passwd' => strip_tags($_POST['password_tuvan_insert']),
                        'id_location' => strip_tags($_POST['location']),
                        'status' => strip_tags($_POST['tuvan_active_insert']),
                    );
                    $this->feedback->insert_tuvan($info);
                    break;
                case 'edit_tuvan':
                    if (($_POST['tuvan_active_insert'] == true) || ($_POST['tuvan_active_insert'] == 'true')) {
                        $_POST['tuvan_active_insert'] = 1;
                    } else {
                        $_POST['tuvan_active_insert'] = 0;
                    }

                    $info = array(
                        'tuvan_id' => (int)strip_tags($_POST['tuvan_id']),
                        'fullname' => strip_tags($_POST['name_tuvan_insert']),
                        'username' => strip_tags($_POST['username_tuvan_insert']),
                        'passwd' => strip_tags($_POST['password_tuvan_insert']),
                        'id_location' => (int)strip_tags($_POST['location']),
                        'status' => (int)strip_tags($_POST['tuvan_active_insert']),
                    );

                    $this->feedback->update_tuvan($info);
                    break;
                case 'del_tuvan':
                    $info = array(
                        'tuvan_id' => (int)strip_tags($_POST['id']),
                    );
                    var_dump($info);
                    $this->feedback->del_tuvan($info);
                    break;
                case 'tuvan_active':
                    if (trim($_POST['action_status']) == 'deactive') {
                        $status_target = 0;
                    } else {
                        $status_target = 1;
                    }
                    $info = array(
                        'tuvan_id' => (int)strip_tags($_POST['id']),
                        'status' => $status_target,
                    );
                    $this->feedback->update_tuvan_active($info);
                    break;

                // ============= phone
                case 'insert_phone_feedback':
                    $info = array(
                        'name_feeder' => strip_tags($this->input->post('name_feeder')),
                        'user_id_creat' => $_SESSION['id'],
                        'point' => strip_tags($this->input->post('point')),
                        'class_code' => strip_tags($this->input->post('class_code')),
                        'type' => strip_tags($this->input->post('type')),
                        'comment' => strip_tags($this->input->post('comment')),
                        'times' => strip_tags($this->input->post('times_feeder')),
                    );

                    $res = $this->feedback->insert_phone_paper($info);
                    if ($res === true ){
                        $this->input_gg_sheets($info);
                        echo 'ok';
                    }else{
                        echo 'Thông tin không hợp lệ do nội dung nhận xét trùng !';
                    }

                    break;
                case 'del_feedbackphone':
                    if (($_SESSION['role'] == 'admin') || ($_SESSION['role'] == 'manager')) {
                        $info = array(
                            'id' => (int)strip_tags($_POST['id']),
                        );
                        var_dump($info);
                        $this->feedback->del_feedbackphone($info);
                    } else {
                        var_dump('Bạn không có quyền xóa feedback');
                    }
                    break;
                case 'del_feedbackform':
                    if (($_SESSION['role'] == 'admin') || ($_SESSION['role'] == 'manager')) {
                        $info = array(
                            'id' => (int)strip_tags($_POST['id']),
                        );
                        var_dump($info);
                        $this->feedback->del_feedbackform($info);
                    } else {
                        var_dump('Bạn không có quyền xóa feedback');
                    }
                    break;
                // =============
                case 'insert_teacher':
                    $aland = 0;
                    $giaotiep = 0;
                    $toeic = 0;
                    $ielts = 0;
                    if (strip_tags($_POST['teacher_giaotiep_insert']) === 'true') {
                        $giaotiep = 1;
                    }
                    if (strip_tags($_POST['teacher_toeic_insert']) === 'true') {
                        $toeic = 1;
                    }
                    if (strip_tags($_POST['teacher_ielts_insert']) === 'true') {
                        $ielts = 1;
                    }
                    if (strip_tags($_POST['teacher_aland_insert']) === 'true') {
                        $aland = 1;
                    }
                    $info = array(
                        'name' => strip_tags($_POST['name_teacher_insert']),
                        'info' => strip_tags($_POST['info_teacher_insert']),
                        'email' => strip_tags($_POST['email_teacher_insert']),
                        'manager_email' => strip_tags($_POST['manager_email_insert']),
                        'giaotiep' => $giaotiep,
                        'toeic' => $toeic,
                        'ielts' => $ielts,
                        'aland' => $aland,
                        'avatar' => '',
                    );
                    $this->feedback->insert_teacher($info);
                    break;
                case 'edit_teacher':
                    $aland = 0;
                    $giaotiep = 0;
                    $toeic = 0;
                    $ielts = 0;
                    if (strip_tags($_POST['teacher_giaotiep_insert']) === 'true') {
                        $giaotiep = 1;
                    }
                    if (strip_tags($_POST['teacher_toeic_insert']) === 'true') {
                        $toeic = 1;
                    }
                    if (strip_tags($_POST['teacher_ielts_insert']) === 'true') {
                        $ielts = 1;
                    }
                    if (strip_tags($_POST['teacher_aland_insert']) === 'true') {
                        $aland = 1;
                    }
                    $info = array(
                        'teacher_id' => (int)strip_tags($_POST['teacher_id']),
                        'name' => strip_tags($_POST['name_teacher_insert']),
                        'info' => strip_tags($_POST['info_teacher_insert']),
                        'email' => strip_tags($_POST['email_teacher_insert']),
                        'manager_email' => strip_tags($_POST['manager_email_insert']),
                        'giaotiep' => $giaotiep,
                        'toeic' => $toeic,
                        'ielts' => $ielts,
                        'aland' => $aland,
                        'avatar' => ''
                    );

                    $this->feedback->update_teacher($info);
                    break;
                case 'del_teacher':
                    $info = array(
                        'teacher_id' => (int)strip_tags($_POST['teacher_id']),
                    );
                    var_dump($info);
                    $this->feedback->del_teacher($info);
                    break;
                case 'insert_class':
                    // change time date to timestamp
                    $time_start = strip_tags($_POST['class_from_date']);
                    //  $time_start = strftime('%Y-%m-%dT%H:%M:%S', strtotime($time_start));

                    $time_start = strtotime($time_start);
                    $time_end = strip_tags($_POST['class_to_date']);
                    $time_end = strtotime($time_end);

                    $info = array(
                        'type' => strip_tags($_POST['class_type']),
                        'class_code' => strip_tags($_POST['class_code']),
                        'id_location' => (int)strip_tags($_POST['id_location']),
                        'list_teacher' => json_encode($_POST['class_teacher']),
                        'more_info' => strip_tags($_POST['class_more_info']),
                        'opening_day' => strip_tags($_POST['class_opening_date']),
                        'time_start' => $time_start,
                        'time_end' => $time_end,
                        'level' => strip_tags($_POST['level']),
                    );
                    // main_teacher
                    if (count($_POST['class_teacher']) > 0){
                        $info['main_teacher'] = $_POST['class_teacher'][0];
                    }else{
                        $info['main_teacher'] = null;
                    }

                    $status = $this->feedback->insert_class($info);
                    if($status == 1) {
                        $this->update_time_feedback($_POST['class_code']);
                    }
                    echo $status;
                    break;
                case 'edit_class':
                    $time_start = strip_tags($_POST['class_from_date']);
                    $time_start = strtotime($time_start);
                    $time_end = strip_tags($_POST['class_to_date']);
                    $time_end = strtotime($time_end);

                    $info = array(
                        'class_id' => strip_tags($_POST['class_id']),
                        'type' => strip_tags($_POST['class_type']),
                        'id_location' => (int)strip_tags($_POST['id_location']),
                        'list_teacher' => json_encode($_POST['class_teacher']),
                        'more_info' => strip_tags($_POST['class_more_info']),
                        'opening_day' => strip_tags($_POST['class_opening_date']),
                        'time_start' => $time_start,
                        'time_end' => $time_end,
                        'level' => strip_tags($_POST['level']),
                    );

                    // main_teacher
                    if (count($_POST['class_teacher']) > 0){
                        $info['main_teacher'] = $_POST['class_teacher'][0];
                    }else{
                        $info['main_teacher'] = null;
                    }

                    $status = $this->feedback->update_class($info);
                    if($status == 1) {
                        $detail_class = $this->feedback->get_info_class_by_id_class($_POST['class_id']);
                        $this->update_time_feedback($detail_class['class_code'], $detail_class);
                    }
                    echo $status;
                    break;
                case 'edit_time_class': // Thay đổi sĩ số lớp

                    $time_start = strip_tags($_POST['class_from_date']);
                    $time_start = strtotime($time_start);
                    $time_end = strip_tags($_POST['class_to_date']);
                    $time_end = strtotime($time_end);
                    $number_student = (int) $_POST['number_student'];

                    $info = array(
                        'class_id' => strip_tags($_POST['class_id']),
                        'time_start' => $time_start,
                        'time_end' => $time_end,
                        'number_student' => $number_student,
                    );
                    $this->db->where('class_id',$info['class_id']);
                    $this->db->set('time_start', $time_start);
                    $this->db->set('time_end', $time_end);
                    $this->db->set('number_student', $number_student);
                    $this->db->update('feedback_class');
                    echo json_encode(array(
                        'status' => 'success'
                    ));
                    break;

                case 'del_class':
                    $info = array(
                        'class_id' => (int)strip_tags($_POST['class_id']),
                    );
                    $this->feedback->del_class($info);
                    break;
                case 'insert_location':
                    $info = array(
                        'name' => strip_tags($_POST['name_location_insert']),
                        'area' => strip_tags($_POST['area']),
                        'brand' => strip_tags($_POST['brand'])
                    );
                    $this->feedback->insert_location($info);
                    break;
                case 'edit_location':
                    $info = array(
                        'id' => strip_tags($_POST['id']),
                        'name' => strip_tags($_POST['name_location_insert']),
                        'area' => strip_tags($_POST['area']),
                        'brand' => strip_tags($_POST['brand'])
                    );
                    $this->feedback->edit_location($info);
                    break;
                case 'del_location':
                    $info = array(
                        'id' => strip_tags($_POST['id']),
                    );
                    $this->feedback->del_location($info);

                    break;
                case 'refresh_table_phone_feedback':
                    echo $this->get_view_list_feedback_phone($_REQUEST['class_code']);
                    break;
                case 'ringthebell':
                    // ring_the_bell
                    $info = array(
                        'class_id' => $_REQUEST['class_id'],
                        'type' => $_REQUEST['type'],
                        'user_id_creat' => $_SESSION['id'],
                        'status' => 0,
                    );
                    $this->feedback->ring_the_bell($info);
//                    $this->script_handle_bell_1_times(); // zffix
                    break;
            }
        }


    }

    // === API lấy link feedback zoom
    public function get_url_fb_zoom(){
        if (isset($_POST['class_code'])){
            // return link
            $key = 'fb_zoom_!@#';
            $my_time = time();
            $hash = hash('ripemd160', ($my_time.$key));
            $url = 'https://qlcl.imap.edu.vn/feedback/zoom?my_class='.$_POST['class_code'].'&my_time='.$my_time.'&my_token='.$hash;
            echo json_encode([
                'status' => 'success',
                'url' => $url,
            ]);
            exit;
        }
        $this->load->model('Feedback_model','fb');
        $class_code = $this->fb->get_list_class_code_zoom(10);

        $data = array(
            'class_code' => $class_code,
        );

        $this->load->view('feedback/get_link_feedback_zoom', $data, false);
    }

    /**
     * @return object
     */
    public function suggest_class_code_zoom(){
        $keyword = $this->input->get("term");
        $page = (int) $this->input->get('page');
        $page = ($page > 1) ? $page : 1;
        $limit = 100;
        $offset = ($page - 1) * $limit;
        $this->load->model('Feedback_model','fb');
        $params = array('limit' => $limit,'keyword' => $keyword,'offset' => $offset);
        $arrClass = $this->fb->get_list_class_code_zoom_filter($params);
        $data = $option = array();
        if (count($arrClass) > $limit) {
            $option['nextpage'] = true;
            unset($arrClass[$limit]);
        }
        foreach ($arrClass as $key => $class) {
            $data[] = array('id' => $class['class_code'], 'text' => $class['class_code'],'item_id' => $class['class_code']);
        }
        return $this->output->set_output(json_encode(array('status' => 'success','data' => $data,'option' => $option)));
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


    private function get_view_list_feedback_phone($class_code)
    {
        $this->load->model('Feedback_model', 'feedback');

        if ($this->feedback->check_class_code_exist($class_code)) {
            $list_phone_feedback = $this->feedback->get_list_phone_paper_by_class_code($class_code);

            $arr_times_val = array();
            foreach ($list_phone_feedback as $mono) {
                if (!in_array($mono['times'], $arr_times_val)) {
                    array_push($arr_times_val, $mono['times']);
                }
            }

            $full_times_info = array();

            for ($i = 0; $i < count($arr_times_val); $i++) {
                $times_focus = $arr_times_val[$i];
                $info_user = array();
                $total_point = 0;
                $count_point = 0;

                foreach ($list_phone_feedback as $item) {

                    if ($item['times'] != $times_focus) {
                        continue;
                    }

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
                );

            }

            $table_phone_feedback = $this->load->view('feedback/list_phone_feedback', array(
                'arr_times_val' => array_reverse($arr_times_val),
                'list_phone_feedback' => $list_phone_feedback,
                'full_times_info' => $full_times_info,
                'class_code' => $class_code,
                'info_user' => $info_user,
            ), true);

            return $table_phone_feedback;
        }

        return '';
    }
    public function input_gg_sheets($info)
    {
        $this->load->model('Feed_upgrade_model','fu');
        $client = getClientGoogle();
        $service = new Google_Service_Sheets($client);
        $spreadsheetId = '1nlWc1N8RFE5RJk2NmQSuyMVWL_VsgYh9kstoLQLMZLI';
        $teacher = $this->fu->get_teacher_by_class_code($info['class_code']);
        $location = $this->fu->get_location_by_class_code($info['class_code']);
        $arr_insert = array('Phone', $info['class_code'], $teacher['manager_email'], $teacher['name'], $info['name_feeder'], $location['name'].' - '.$location['area'], date('d/m/Y', time()), $info['times'], (int)$info['point'], $info['comment'], 'https://qlcl.imap.edu.vn/feedback/feedback_phone_detail?class='.$info['class_code']);

        $values_insert = [
            $arr_insert
        ];
        // import to google sheet
        $range_insert= "Sheet1"; // cái này để chọn khu vực ghi mới, update full: 'LadiPage!A1:N1'
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
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        return $result;
    }
}
