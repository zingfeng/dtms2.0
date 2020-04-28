<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bell extends CI_Controller
{

    public function script_handle_bell_1_times()
    {
        if (!is_cli()) exit;
        error_reporting( E_ALL );
        ini_set('display_errors', 1);

        $this->load->database();

        try {
            $this->action_handle_bell();
        }
        catch(Exception $e) {
            echo 'Time: '.time().' Message: ' .$e->getMessage();
        }

        $this->db->where('site_id',1);
        $this->db->set('last_time_live_cron_email', time());
        $query = $this->db->update('setting');
        $this->db->close();
    }

    public function script_handle_bell()
    {
        if (!is_cli()) exit;
        error_reporting( E_ALL );
        ini_set('display_errors', 1);
        while (true) {
            $this->load->database();
            try {
                $this->action_handle_bell();
                echo '.';
            }
            catch(Exception $e) {
                echo 'Time: '.time().' Message: ' .$e->getMessage();
            }

            //
            $this->db->where('site_id',1);
            $this->db->set('last_time_live_cron_email', time());
            $query = $this->db->update('setting');
            $this->db->close();
            sleep(120);

        }
    }

    private function action_handle_bell()
    {
        $this->load->model('Feedback_model', 'feedback');

        // gửi email trong danh sách chờ
        $this->db->where('status', 0);
        $this->db->select('*');
        $query = $this->db->get('feedback_bell');
        $arr_res = $query->result_array();
        foreach ($arr_res as $mono_res) {
            $bell_id = $mono_res['id'];
            $class_id = $mono_res['class_id'];
            $user_id_creat = $mono_res['user_id_creat'];
            // HANDLE SEND EMAIL
            $this->send_report_one_class($class_id, $user_id_creat);
            // - END HANDLE SEND EMAIL
            $this->feedback->change_status($bell_id, 1);
        }

    }

    /**
     * @param $class_id
     * @param $user_id_creat
     * @param bool $test Nếu $test = true thì chỉ gửi cho Email Test
     * @return |null
     */
    private function send_report_one_class($class_id, $user_id_creat, $test = false)
    {
        // Email Test
        $email_receive_test = array('huyhieu.it@imap.edu.vn');
        $email_cc_test = array('huyhieu.finance@gmail.com');

        //=================================================================

        $this->load->model('Feedback_model', 'feedback');

        // TOTAL INFO CLASS
        $info_class = $this->feedback->get_info_class_by_id_class($class_id);

        // INFO LOCATION
        $id_location = $info_class['id_location'];
        $info_location = $this->feedback->get_info_location_by_id($id_location);

        // INFO TEACHER
        $teacher_id = $info_class['main_teacher'];
        $teacher_email = '';
        $email_bcc = array();
        $teacher_info = $this->feedback->get_info_teacher($teacher_id);
        if($teacher_info){
            $teacher_email = $teacher_info['email'];
            $email_bcc = array('thanhdat.it@imap.edu.vn','huyhieu.it@imap.edu.vn');
            if(isset($teacher_info['manager_email'])){
                $email_bcc = array_merge(array($teacher_info['manager_email']), $email_bcc);
            }
        }
        if ($teacher_email == '') {
            $email_to = array($email_bcc[0]);
            unset($email_bcc[0]);
        } else {
            $email_to = array($teacher_email);
        }

        // POINT CLASS
        $count = 0;
        if ($info_class['point'] > 0) {
            $count++;
        }
        if ($info_class['point_phone'] > 0) {
            $count++;
        }
        if ($count > 0) {
            $average_point = $info_class['average_point'];
        } else {
            return null;
        }

        switch (true) {
            case ($average_point >= 9.5):
                $xeploai = 'Xuất sắc';
                break;
            case ($average_point >= 9):
                $xeploai = 'Giỏi';
                break;
            case ($average_point >= 8.6):
                $xeploai = 'Khá';
                break;
            case ($average_point >= 8):
                $xeploai = 'Trung bình';
                break;
            default:
                $xeploai = 'Yếu';
                break;
        }

        if ($average_point == 0) {
            return null;
        }

        // INFO TYPE CLASS
        switch ($info_class['type']) {
            case 'toeic':
                $type_text = 'TOEIC';
                break;
            case 'ielts':
                $type_text = 'IELTS FIGHTER';
                break;
            case 'aland':
                $type_text = 'ALAND';
                break;
            case 'giaotiep':
                $type_text = 'MS HOA GIAO TIẾP';
                break;
            default:
                $type_text = "IMAP";
        }

        $email_title = '[' . $xeploai . '] ' . $info_class['class_code'] . ' - CS: ' . $info_location['name'] . ' - GV: ' . $teacher_info['name'];

        $open_day_y_m_d = $info_class['opening_day'];
        $open_day = substr($open_day_y_m_d, 8, 2) . '/' . substr($open_day_y_m_d, 5, 2) . '/' . substr($open_day_y_m_d, 0, 4);

        // INFO HUMAN REQUEST SEND EMAIL
        $name_request_send_email = $this->feedback->get_info_user($user_id_creat);
        $token_view = $this->feedback->get_token_view_class($info_class['class_code']);

        // DETAIL POINT PHONE FEEDBACK
        $detail_feedback_phone = $this->feedback->get_mark_point_feedback_phone_all_time($info_class['class_code']);
        $detail_feedback_form = $this->feedback->get_mark_point_feedback_form_all_time($info_class['class_code']);
        $detail_feedback_phone_text = '';
        $detail_feedback_form_text = '';
        if (count($detail_feedback_phone)> 0){
            foreach ($detail_feedback_phone as $keyFBP => $feedbackPhone){
                $detail_feedback_phone_text .=
                    '<p style=" font-weight: bold; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Điểm Feedback Phone lần '.$keyFBP.' (ngày '.date('d/m/Y',$feedbackPhone['time_newest']).'): '.$feedbackPhone['average_point'].
                    ' ( '.$feedbackPhone['count'].' lượt phản hồi) </p>';
            }
        }
        if (is_array($detail_feedback_form) && count($detail_feedback_form) > 0) {
            foreach ($detail_feedback_form as $keyFBF => $fbForm) {
                if($keyFBF == 'ksgv1'){
                    $keyFBF  = 1;
                }
                if($keyFBF == 'ksgv2'){
                    $keyFBF  = 2;
                }
                $detail_feedback_form_text .=
                    '<p style=" font-weight: bold; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Điểm Feedback Form lần '.$keyFBF.' : '.$fbForm['average_point'].
                    ' ( '.$fbForm['count'].' lượt phản hồi) </p>';
            }
        }

        $content_email = '
            <h4>Dear '.$teacher_info['name'].',</h4>
            <p>Dưới đây là tổng hợp kết quả Feedback lớp <b>' . $info_class['class_code'] . '</b></p>
            <p>- Cơ sở: ' . $info_location['name'] . '</p>
            <p>- Ngày khai giảng: ' . $open_day . '</p>
            <p>- Giáo viên: ' . $teacher_info['name'] . '</p>
            <div style="margin: 20px 50px 20px 20px; border: 1px solid green; border-radius: 5px; padding: 10px;">
            <h3 style="color:rgb(255,81,81)"><b>Kết quả Feedback lớp <b>' . $info_class['class_code'] . ': ' . $average_point . ' điểm - Xếp loại: ' . $xeploai . '</b></h3>   
            <p>Trong đó: </p>
            <p>&#8226; Điểm Feedback Phone: ' . $info_class['point_phone'] . '</p>'.$detail_feedback_phone_text.'
            <p>&#8226; Điểm Feedback Form: ' . $info_class['point'] . '</p>'.$detail_feedback_form_text.'
            <p>&#8226; Điểm trung bình Feedback: ' . $info_class['average_point'] . '</p>

            <h3>Báo cáo chi tiết vui lòng xem tại <a href="https://dtms.aland.edu.vn/feedback/statistic/' . $info_class['class_code'] . '?token='.$token_view.'" target="_blank">https://dtms.aland.edu.vn</a>.</h3>
            </div>
            
            <p><i>Email này được hệ thống tạo và gửi tự động dưới yêu cầu của nhân viên tư vấn <b>' . $name_request_send_email['fullname'] . '</b>.</i></p>
            <p>Trân trọng</p>
        ';

        $arr_recveive = $email_to; // $email_to
        $CI = &get_instance();

        // get config email server
        $emailServer = $CI->config->item('email_server');
        $count = count($emailServer);
        $randInt = rand(0, $count - 1);
        $emailServer = $emailServer[$randInt];

        // TEST EMAIL
        if ($test != false){
            // Đang ở chế độ Test
            $arr_recveive = $email_receive_test;
            $email_bcc = $email_cc_test;
        }

        // load library
        $config = array(
            'smtp_host' => $emailServer['host'],
            'smtp_user' => $emailServer['email'],
            'smtp_pass' => $emailServer['password'],
            'smtp_port' => $emailServer['port'],
            'mailtype' => 'html',
            'protocol' => 'smtp',
            'newline' => "\r\n",
        );
        $CI->load->library('email', $config);
        $CI->email->clear();
        $CI->email->from($config['smtp_user'], 'IMAP khảo sát chất lượng');
        $CI->email->to($arr_recveive);
        $CI->email->subject($email_title);
        $CI->email->cc($email_bcc);
        $CI->email->message($content_email);
        $CI->email->send(TRUE);
//        echo $CI->email->print_debugger();
    }
}
