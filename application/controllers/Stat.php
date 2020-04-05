<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stat extends CI_Controller
{
    public function statistic($class_code)
    {
//        guard();
        $this->load->model('Feedback_model', 'feedback');
        $teacher_permission = false;

        if (check_login()) {

        } else {
            if ($this->input->get('token')){
                //        https://dtms.aland.edu.vn/feedback/statistic/Pre2570?token=abcd
                $token = $this->input->get('token');
                $res_check = $this->feedback->check_token_view_class_statics($class_code,$token);
                if (! $res_check){
                    echo 'Token view không hợp lệ';
                    exit;
                }else{
                    $teacher_permission = true;
                }

            }else{
                redirect('/feedback/login');

            }
        }

        if (!$this->feedback->check_class_code_exist($class_code)) {
            echo 'Mã lớp không hợp lệ';
            exit;
        }

        $data_single = $this->feedback->get_data_statistic_class($class_code);

        $data = array(
            'singleview' => $data_single['question'],
            'time' => $data_single['time'],
        );

//        echo '<pre>'; print_r($data); echo '</pre>'; exit;

        $time_list = $data_single['time'];
        // Time trung bình
        $total_time = 0;
        foreach ($time_list as $time_mono) {
            $total_time += $time_mono;
        }
        $average_time = round($total_time / (count($time_list)), 1);
        $view_feedback_phone = $this->get_view_list_feedback_phone($class_code);

        $info_class = $this->feedback->get_info_class_by_class_code($class_code);
        $list_teacher = $info_class['list_teacher'];
        $teacher_info = array();
        if ( ($list_teacher!= '') && ($list_teacher !='null') ){
            $list_teacher_live = json_decode($list_teacher,true);
            for ($i = 0; $i < count($list_teacher_live); $i++) {
                $mono_teacher_id = $list_teacher_live[$i];
                $info_teacher____ = $this->feedback->get_info_teacher($mono_teacher_id);
                array_push($teacher_info,$info_teacher____);
            }
        }

        $id_location__ = $info_class['id_location'];
        $info_location = $this->feedback->get_info_location_by_id($id_location__);


//        var_dump($view_feedback_phone); exit;

        $this->load->layout('feedback/report/report_class', array(
            'teacher_permission' => $teacher_permission,
            'view_feedback_phone' => $view_feedback_phone,
            'data' => $data,
            'info_class' => $info_class,
            'teacher_info' => $teacher_info,
            'info_location' => $info_location,
            'name_list' => $data_single['name'],
            'time_list' => $time_list,
            'class_code' => $class_code,
            'average_time' => $average_time,
            'title_header' => "Feedback ".$class_code,


        ), false, 'layout_feedback');

    }

    public function statistic_tuvan($class_code)
    {
        guard();
        $this->load->model('Feedback_model', 'feedback');
        if (!$this->feedback->check_class_code_exist($class_code)) {
            echo 'Mã lớp không hợp lý';
            exit;
        }

        $data_single = $this->feedback->get_data_statistic_class($class_code);

        $data = array(
            'singleview' => $data_single['question'],
            'time' => $data_single['time'],
        );

        $time_list = $data_single['time'];
        // Time trung bình
        $total_time = 0;
        foreach ($time_list as $time_mono) {
            $total_time += $time_mono;
        }
        $average_time = round($total_time / (count($time_list)), 1);

        $view_feedback_phone = $this->get_view_list_feedback_phone($class_code);


        $this->load->layout('feedback/report/report_class', array(
            'view_feedback_phone' => $view_feedback_phone,
            'data' => $data,
            'name_list' => $data_single['name'],
            'time_list' => $time_list,
            'class_code' => $class_code,
            'average_time' => $average_time,
            'title_header' => "Feedback ".$class_code,

        ), false, 'layout_feedback_tuvan');

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


}
