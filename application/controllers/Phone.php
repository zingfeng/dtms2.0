<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Phone extends CI_Controller
{

    public function index()
    {
        $this->load->model('Feedback_model', 'feedback');
        $data = array();
        if (isset($_REQUEST['class_code'])) {
            $class_code = $_REQUEST['class_code'];
            if ($this->feedback->check_class_code_exist($class_code)) {
                $info_class = $this->feedback->get_info_class_by_class_code($class_code);


                $list_teacher = json_decode($info_class['list_teacher'], true);
                $list_info_teacher = array();

                foreach ($list_teacher as $id_teacher) {
                    $info = $this->feedback->get_info_teacher($id_teacher);
                    array_push($list_info_teacher, $info);
                }

                $id_location = $info_class['id_location'];

                $info_location = $this->feedback->get_info_location_by_id($id_location);

                ///====================
                $table_phone_feedback = $this->get_view_list_feedback_phone($class_code);

                $max_times_feedback = $this->get_max_times_feedback_phone_class($class_code);
                ///====================

                $data = array(
                    'info_class' => $info_class,
                    'class_code' => $info_class['class_code'],
                    'more_info' => $info_class['more_info'],
                    'type' => $info_class['type'],
                    'id_location' => $info_class['id_location'],
                    'list_info_teacher' => $list_info_teacher,
                    'info_location' => $info_location,
                    'table_phone_feedback' => $table_phone_feedback,
                    'max_times_feedback' => $max_times_feedback,
                );

            } else {
                echo 'Thông tin mã lớp không hợp lệ ';
                exit;
            }
        } else {

            echo 'Truy cập không hợp lệ ';
            exit;
        }

        $this->load->layout('feedback/phone', $data, false, 'layout_feedback_tuvan');

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

    private function get_max_times_feedback_phone_class($class_code)
    {
        $this->load->model('Feedback_model', 'feedback');
        $max_times = 0;

        if ($this->feedback->check_class_code_exist($class_code)) {
            $list_phone_feedback = $this->feedback->get_list_phone_paper_by_class_code($class_code);

            foreach ($list_phone_feedback as $item) {
                $times = (int)$item['times'];
                $max_times = max($max_times, $times);
            }
        }

        return $max_times;
    }

}
