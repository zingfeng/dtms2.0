<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher extends CI_Controller
{
    public function index()
    {
        guard();
        guard_admin_manager();
        $this->load->model('Feedback_model', 'feedback');
        $teacher_info = $this->feedback->get_list_info_teacher();
        $data = array(
            'teacher_info' => $teacher_info,
        );
        $this->load->layout('feedback/teacher', $data, false, 'layout_feedback');
    }

    public function teacher_point_old()
    {
        guard();
        guard_admin_manager();

        $params = array();
        if (isset($_REQUEST['min_opening'])) {
            $params['min_opening'] = strip_tags($_REQUEST['min_opening']);
        }

        if (isset($_REQUEST['max_opening'])) {
            $params['max_opening'] = strip_tags($_REQUEST['max_opening']);
        }

        $this->load->model('Feedback_model', 'feedback');

        $class_info_raw = $this->feedback->get_list_class_info_by_time('', $params);
        $class_info_raw = array_reverse($class_info_raw);
        $list_teacher_to_class = array(); // id_teacher => array(class_id, class_id )
        $list_class_id_to_area = array(); // Hiển thị giáo viên theo khu vực
        $list_location_id_to_area = array();

        // ===== Build $list_location_id_to_area
        $info_location = $this->feedback->get_list_location('');
        foreach ($info_location as $mono_info){
            $list_location_id_to_area[$mono_info['id']] = $mono_info['area'];
        }




        foreach ($class_info_raw as $item) {
            // Ẩn thông tin các lớp ko có tên giáo viên
            if ($item['list_teacher'] == 'null'){
                continue;
            }

            $list_teacher_mono = json_decode($item['list_teacher'], true);
            $class_id = $item['class_id'];
            $id_teacher_main = $list_teacher_mono[0];
            if (!isset($list_teacher_to_class[$id_teacher_main])) {
                $list_teacher_to_class[$id_teacher_main] = array();
            }
            array_push($list_teacher_to_class[$id_teacher_main], $class_id);
            $location_id_mono = $item['id_location'];
            $list_class_id_to_area[$class_id] = $list_location_id_to_area[$location_id_mono];
        }

        $class_info = array(); // id_class to class_info
        $point_teacher_arr = array();

        // FAKE
        $list_teacher_to_class = [
            1 => [
                169,225,669,673,789,1039,1396,1398
            ]
        ];
        // ================ GV So luong lop - 2; Chi tiet - lop
        foreach ($list_teacher_to_class as $id_teacher_mono => $list_id_class) {
            $sum = 0;
            $count = 0;

            for ($i = 0; $i < count($list_id_class); $i++) {

                $mono_id_class = $list_id_class[$i];
                $info_class = $this->feedback->get_info_class_by_id_class($mono_id_class);
                $class_info[$mono_id_class] = $info_class;

                // FAKE
                echo '<br>class code: '.$info_class['class_code'];
                // Get point teacher in feedback Form

                $data_single = $this->feedback->get_data____statistic_class_new($info_class['class_code']);
                $list_question_answer_form = $data_single['question'];

                $data_point_feedback_form_of_teacher = [];
                foreach ($list_question_answer_form as $item) {
                    if (($item['id_quest'] == 209 && mb_strtolower(trim($item['title'])) == '10. bạn sẽ đánh giá giáo viên của mình bao nhiêu điểm') || ($item['id_quest'] == 206 && mb_strtolower(trim($item['title'])) == '7. bạn sẽ đánh giá giáo viên của mình bao nhiêu điểm')){
                        $data_point_feedback_form_of_teacher = $item['data'];
                        echo '<br> *'.$info_class['class_code'];
                        break;
                    }
                }
                echo '<pre>';
                print_r($data_point_feedback_form_of_teacher);

                $sum_feedback_form = 0;
                $count_feedback_form = 0;
                foreach ($data_point_feedback_form_of_teacher as $mono_point => $mono_count){
                    $sum_feedback_form += $mono_point * $mono_count;
                    $count_feedback_form += $mono_count;
                }

                if ($count_feedback_form == 0){
                    $point_form = 0;
                }else{
                    $point_form = round($sum_feedback_form / $count_feedback_form,2);
                }
                echo '<br>$point_form : '.$point_form;
                // ===============================
                $point_phone = $info_class['point_phone'];
                $mono_sum = 0;
                $mono_count = 0;

                if ($point_form > 0) {
                    $mono_sum += $point_form;
                    $mono_count++;
                }

                if ($point_phone > 0) {
                    $mono_sum += $point_phone;
                    $mono_count++;
                }

                if ($mono_count > 0) {
                    $average_point = $mono_sum / $mono_count;
                    if ($average_point > 0) {
                        $sum += $average_point;
                        $count++;
                    }
                }
                echo '<br>$point_phone : '.$point_phone;
                echo '<br>AVERAGE : '.$average_point;
                echo '<hr>';

            }

            if ($count > 0) {
                $average_point_of_teacher = round($sum / $count, 2);
            } else {
                $average_point_of_teacher = 0;
            }
            echo '<hr>';echo '<hr>';
            echo '<br>$average_point_of_teacher : '.$average_point_of_teacher;
            $mono_teacher_info = array(
                'number_class' => $count,
                'average_point_of_teacher' => $average_point_of_teacher,
            );
            $point_teacher_arr[$id_teacher_mono] = $mono_teacher_info;
        }

        exit;

        $teacher_info = $this->feedback->get_list_info_teacher();

        $teacher_id_to_name = array();
        for ($k = 0; $k < count($teacher_info); $k++) {
            $id_teacher = $teacher_info[$k]['teacher_id'];
            $teacher_id_to_name[$id_teacher] = $teacher_info[$k]['name'];
        }

        $today = date('Y-m-d', time());
        $one_month = date('Y-m-d', time() - 1 * 30 * 24 * 60 * 60);
        $two_month = date('Y-m-d', time() - 2 * 30 * 24 * 60 * 60);
        $three_month = date('Y-m-d', time() - 3 * 30 * 24 * 60 * 60);
        $six_month = date('Y-m-d', time() - 6 * 30 * 24 * 60 * 60);
        $one_year = date('Y-m-d', time() - 365 * 24 * 60 * 60);

        $data = array(
            'class_info' => $class_info,
            'list_teacher_to_class' => $list_teacher_to_class,
            'teacher_info' => $teacher_info,
            'teacher_id_to_name' => $teacher_id_to_name,
            'point_teacher_arr' => $point_teacher_arr,
            'list_class_id_to_area' => $list_class_id_to_area,
            'today' => $today,
            'one_month' => $one_month,
            'two_month' => $two_month,
            'three_month' => $three_month,
            'six_month' => $six_month,
            'one_year' => $one_year,
        );

        $this->load->layout('feedback/teacher_point', $data, false, 'layout_feedback');
    }

    public function teacher_point()
    {
        guard();
        guard_admin_manager();
        $this->load->model('Feedback_model', 'feedback');
        $this->load->model('Feed_upgrade_model', 'fu');
        
        $list_manager = $this->fu->get_teacher_manager();
        $data_manager = array();
        foreach ($list_manager as $manager){
            if($manager['manager_email']){
                $data_manager[] = $manager['manager_email'];
            }
        }
        $params = array(
            'limit' => 30
        );

        if (isset($_REQUEST['min_opening'])) {
            $params['min_opening'] = strip_tags($_REQUEST['min_opening']);
        }
        if (isset($_REQUEST['max_opening'])) {
            $params['max_opening'] = strip_tags($_REQUEST['max_opening']);
        }
        if (isset($_REQUEST['teacher_name'])) {
            $params['teacher_name'] = strip_tags($_REQUEST['teacher_name']);
        }
        if (isset($_REQUEST['manager_email'])) {
            $params['manager_email'] = strip_tags($_REQUEST['manager_email']);
        }


        // 1. Lấy danh sách giáo viên trước đã
        // 2. Tìm các lớp liên quan đến các giáo viên này
        // 3. Điểm tính như thế nào ??
        // Dựa vào điểm feedback phone và 1 số câu hỏi chi tiết trong phần feedback ksgv

        // 1
        $list_teacher  = $this->fu->get_list_id_teacher_to_info($params);
        if($list_teacher){
            $arr_teacher_id = array_keys($list_teacher);
            $arr_teacher_id_to_list_class = $this->fu->get_class_info_where_in_teacher_id($arr_teacher_id,'class_id, class_code, type, point_phone, main_teacher', $params);

            $arr_info_view = [];
            foreach ($arr_teacher_id_to_list_class as $id_main_teacher => $list_class) {
                $arr_fb_phone_point = [];
                $arr_class_code = []; // classes belong to this teacher
                $arr_class_code_and_type = [];
                $number_class = count($list_class);

                for ($i = 0; $i < count($list_class); $i++) {
                    $mono_class = $list_class[$i];
                    $arr_fb_phone_point[$mono_class['class_code']] = $mono_class['point_phone'];
                    $arr_class_code[] = $mono_class['class_code'];
                    $arr_class_code_and_type[] = [$mono_class['class_code'],$mono_class['type']];
                }

                $point_fb_ksgv = $this->fu->get_point_fb_ksgv_by_list_class_code($arr_class_code);
                $average_point_of_1class = [];
                foreach ($arr_fb_phone_point as $m___class_code => $point_phone_mono){
                    if (isset($point_fb_ksgv[$m___class_code])){
                        $point_fb_ksgv_mono = $point_fb_ksgv[$m___class_code];
                        $average_point_of_1class[] = tbc([$point_fb_ksgv_mono,$point_phone_mono],false,10);
                    }else{
                        $average_point_of_1class[]  = $point_phone_mono;
                    }
                }
                $average_point_of_teacher = tbc ($average_point_of_1class);
                $arr_info_view[] = array(
                    'teacher_id' =>$id_main_teacher,
                    'teacher_info' => $list_teacher[$id_main_teacher],
                    'number_class' => $number_class,
                    'arr_class_code_and_type' => $arr_class_code_and_type,
                    'average_point_of_teacher' => $average_point_of_teacher,
                );
            }
        }

        $today = date('Y-m-d', time());
        $one_month = date('Y-m-d', time() - 1 * 30 * 24 * 60 * 60);
        $two_month = date('Y-m-d', time() - 2 * 30 * 24 * 60 * 60);
        $three_month = date('Y-m-d', time() - 3 * 30 * 24 * 60 * 60);
        $six_month = date('Y-m-d', time() - 6 * 30 * 24 * 60 * 60);
        $one_year = date('Y-m-d', time() - 365 * 24 * 60 * 60);

        $data = array(
            'arr_info_view' => $arr_info_view,
            'today' => $today,
            'one_month' => $one_month,
            'two_month' => $two_month,
            'three_month' => $three_month,
            'six_month' => $six_month,
            'one_year' => $one_year,
            'list_manager' => $data_manager,
        );

//        print_r($arr_info_view); exit;

        $this->load->layout('feedback/teacher_point', $data, false, 'layout_feedback');
    }

    // Export danh sách điểm của giáo viên
    public function export_teacher_point()
    {
        guard();
        guard_admin_manager();
        $this->load->model('Feedback_model', 'feedback');
        $this->load->model('Feed_upgrade_model', 'fu');

        $params = array();

        if (isset($_REQUEST['min_opening'])) {
            $params['min_opening'] = strip_tags($_REQUEST['min_opening']);
        }
        if (isset($_REQUEST['max_opening'])) {
            $params['max_opening'] = strip_tags($_REQUEST['max_opening']);
        }


        // 1. Lấy danh sách giáo viên trước đã
        // 2. Tìm các lớp liên quan đến các giáo viên này
        // 3. Điểm tính như thế nào ??
        // Dựa vào điểm feedback phone và 1 số câu hỏi chi tiết trong phần feedback ksgv

        // 1
        $list_teacher  = $this->fu->get_list_id_teacher_to_info();
        $arr_teacher_id = array_keys($list_teacher);
        $arr_teacher_id_to_list_class = $this->fu->get_class_info_where_in_teacher_id($arr_teacher_id,'class_id, class_code, type, point_phone, main_teacher', $params );

        $arr_info_view = [];
        foreach ($arr_teacher_id_to_list_class as $id_main_teacher => $list_class) {
            $arr_fb_phone_point = [];
            $arr_class_code = []; // classes belong to this teacher
            $arr_class_code_and_type = [];
            $number_class = count($list_class);

            for ($i = 0; $i < count($list_class); $i++) {
                $mono_class = $list_class[$i];
                $arr_fb_phone_point[$mono_class['class_code']] = $mono_class['point_phone'];
                $arr_class_code[] = $mono_class['class_code'];
                $arr_class_code_and_type[] = [$mono_class['class_code'],$mono_class['type']];
            }

            $point_fb_ksgv = $this->fu->get_point_fb_ksgv_by_list_class_code($arr_class_code);
            $average_point_of_1class = [];
            foreach ($arr_fb_phone_point as $m___class_code => $point_phone_mono){
                if (isset($point_fb_ksgv[$m___class_code])){
                    $point_fb_ksgv_mono = $point_fb_ksgv[$m___class_code];
                    $average_point_of_1class[] = tbc([$point_fb_ksgv_mono,$point_phone_mono],false,10);
                }else{
                    $average_point_of_1class[]  = $point_phone_mono;
                }
            }
            $average_point_of_teacher = tbc ($average_point_of_1class);
            $arr_info_view[] = array(
                'teacher_id' =>$id_main_teacher,
                'teacher_info' => $list_teacher[$id_main_teacher],
                'number_class' => $number_class,
                'arr_class_code_and_type' => $arr_class_code_and_type,
                'average_point_of_teacher' => $average_point_of_teacher,
            );
        }

//        $today = date('Y-m-d', time());
//        $one_month = date('Y-m-d', time() - 1 * 30 * 24 * 60 * 60);
//        $two_month = date('Y-m-d', time() - 2 * 30 * 24 * 60 * 60);
//        $three_month = date('Y-m-d', time() - 3 * 30 * 24 * 60 * 60);
//        $six_month = date('Y-m-d', time() - 6 * 30 * 24 * 60 * 60);
//        $one_year = date('Y-m-d', time() - 365 * 24 * 60 * 60);

//        $data = array(
//            'arr_info_view' => $arr_info_view,
//            'today' => $today,
//            'one_month' => $one_month,
//            'two_month' => $two_month,
//            'three_month' => $three_month,
//            'six_month' => $six_month,
//            'one_year' => $one_year,
//        );

        $filename = 'Export-teacher-'.date('d-m-Y').'.xlsx';
        $this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel();
        $i = 1;
        $baseRow = 1;
        foreach($arr_info_view as $m){
            $count = $baseRow + $i;
            if($i == 1){
                $objPHPExcel->getActiveSheet(0)
                    ->setCellValue('A'.$i, "ID")
                    ->setCellValue('B'.$i, "Tên giáo viên")
                    ->setCellValue('C'.$i, "Số lượng lớp")
                    ->setCellValue('D'.$i, "Điểm trung bình")
                    ->setCellValue('E'.$i, "Danh sách lớp")
                    ->setCellValue('F'.$i, "Xếp loại");
//                    ->setCellValue('G'.$i, "Khu vực");
            }
            $objPHPExcel->getActiveSheet()->insertNewRowBefore($count,1);
            // List class
            $xeploai = '';
            switch (true){
                case ($m['average_point_of_teacher'] >=9.5):
                    $xeploai = 'Xuất sắc';
                    break;
                case ($m['average_point_of_teacher'] >=9):
                    $xeploai = 'Giỏi';
                    break;
                case ($m['average_point_of_teacher'] >=8.6):
                    $xeploai = 'Khá';
                    break;
                case ($m['average_point_of_teacher'] >=8):
                    $xeploai = 'Trung bình';
                    break;
                default:
                    $xeploai = 'Yếu';
                    break;
            }
            $list_class = '';
            for ($i = 0; $i < count($m['arr_class_code_and_type']); $i++) {
                $class_info_mono = $m['arr_class_code_and_type'][$i];
                $list_class .= $class_info_mono[0].' | ';
            }

            if ($m['average_point_of_teacher'] == 0){
                $xeploai = '';
            }

            $objPHPExcel->getActiveSheet(0)
                ->setCellValue('A'.$count, $m['teacher_id'])
                ->setCellValue('B'.$count, $m['teacher_info'])
                ->setCellValue('C'.$count, $m['number_class'])
                ->setCellValue('D'.$count, $m['average_point_of_teacher'])
                ->setCellValue('E'.$count, $list_class)
                ->setCellValue('F'.$count, $xeploai);
//                ->setCellValue('G'.$count, $area_text);
            $i++;
        }
        $objPHPExcel->getActiveSheet()->setTitle($filename);
        $objPHPExcel->setActiveSheetIndex(0);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachement; filename="' . $filename . '"');
        ob_end_clean();
        return $objWriter->save('php://output');exit();

    }
    
    public function export_teacher_point_old()
    {
        guard();
        guard_admin_manager();

//        $this->_mark_all_class('');
        $params = array();
        if (isset($_REQUEST['min_opening'])) {
            $params['min_opening'] = strip_tags($_REQUEST['min_opening']);
        }

        if (isset($_REQUEST['max_opening'])) {
            $params['max_opening'] = strip_tags($_REQUEST['max_opening']);
        }

        $this->load->model('Feedback_model', 'feedback');
        $class_info_raw = $this->feedback->get_list_class_info_by_time('', $params);
        $class_info_raw = array_reverse($class_info_raw);
        $list_teacher_to_class = array(); // id_teacher => array(class_id, class_id )
        $list_class_id_to_area = array(); // Hiển thị giáo viên theo khu vực
        $list_location_id_to_area = array();

        // ===== Build $list_location_id_to_area
        $info_location = $this->feedback->get_list_location('');
        foreach ($info_location as $mono_info){
            $list_location_id_to_area[$mono_info['id']] = $mono_info['area'];
        }


        foreach ($class_info_raw as $item) {
            // Ẩn thông tin các lớp ko có tên giáo viên
            if ($item['list_teacher'] == 'null'){
                continue;
            }

            $list_teacher_mono = json_decode($item['list_teacher'], true);
            $class_id = $item['class_id'];
            $id_teacher_main = $list_teacher_mono[0];
            if (!isset($list_teacher_to_class[$id_teacher_main])) {
                $list_teacher_to_class[$id_teacher_main] = array();
            }
            array_push($list_teacher_to_class[$id_teacher_main], $class_id);
            $location_id_mono = $item['id_location'];
            $list_class_id_to_area[$class_id] = $list_location_id_to_area[$location_id_mono];
        }

        $class_info = array(); // id_class to class_info
        $point_teacher_arr = array();

        // ================ GV So luong lop - 2; Chi tiet - lop
        foreach ($list_teacher_to_class as $id_teacher_mono => $list_id_class) {
            $sum = 0;
            $count = 0;

            for ($i = 0; $i < count($list_id_class); $i++) {
                $mono_id_class = $list_id_class[$i];
                $info_class = $this->feedback->get_info_class_by_id_class($mono_id_class);
                $class_info[$mono_id_class] = $info_class;
                // point

                // Get point teacher in feedback Form

                $data_single = $this->feedback->get_data_statistic_class($info_class['class_code']);
                $list_question_answer_form = $data_single['question'];

                $data_point_feedback_form_of_teacher = [];
                foreach ($list_question_answer_form as $item) {
                    if (($item['type'] == 'select') && (mb_strtolower(trim($item['title'])) == 'giáo viên') ){
                        $data_point_feedback_form_of_teacher = $item['data'];
                        break;
                    }
                }

                $sum_feedback_form = 0;
                $count_feedback_form = 0;
                foreach ($data_point_feedback_form_of_teacher as $mono_point => $mono_count){
                    $sum_feedback_form += $mono_point * $mono_count;
                    $count_feedback_form += $mono_count;
                }
                $point_form = 0;
                if ($count_feedback_form == 0){
                    $point_form = 0;
                }else{
                    $point_form = round($sum_feedback_form / $count_feedback_form,2);
                }

                // ===============================


                $point_phone = $info_class['point_phone'];
                $mono_sum = 0;
                $mono_count = 0;
                if ($point_form > 0) {
                    $mono_sum += $point_form;
                    $mono_count++;
                }
                if ($point_phone > 0) {
                    $mono_sum += $point_phone;
                    $mono_count++;
                }
                if ($mono_count > 0) {
                    $average_point = $mono_sum / $mono_count;
                    if ($average_point > 0) {
                        $sum += $average_point;
                        $count++;
                    }
                }

            }

            if ($count > 0) {
                $average_point_of_teacher = round($sum / $count, 2);
            } else {
                $average_point_of_teacher = 0;
            }
            $mono_teacher_info = array(
                'number_class' => $count,
                'average_point_of_teacher' => $average_point_of_teacher,
            );
            $point_teacher_arr[$id_teacher_mono] = $mono_teacher_info;
        }
        ksort($list_teacher_to_class);

        $teacher_info = $this->feedback->get_list_info_teacher();

        $teacher_id_to_name = array();
        for ($k = 0; $k < count($teacher_info); $k++) {
            $id_teacher = $teacher_info[$k]['teacher_id'];
            $teacher_id_to_name[$id_teacher] = $teacher_info[$k]['name'];
        }

        $filename = 'Export-teacher-'.date('d-m-Y').'.xlsx';
        $this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel();
        $i = 1;
        $baseRow = 1;
        foreach($list_teacher_to_class as $id_teacher => $list_class_id){
            $count = $baseRow + $i;
            if($i == 1){
                $objPHPExcel->getActiveSheet(0)
                    ->setCellValue('A'.$i, "ID")
                    ->setCellValue('B'.$i, "Tên giáo viên")
                    ->setCellValue('C'.$i, "Số lượng lớp")
                    ->setCellValue('D'.$i, "Điểm trung bình")
                    ->setCellValue('E'.$i, "Danh sách lớp")
                    ->setCellValue('F'.$i, "Xếp loại")
                    ->setCellValue('G'.$i, "Khu vực");
            }
            $objPHPExcel->getActiveSheet()->insertNewRowBefore($count,1);
            // List class
            $list_class = "";
            $arr_area = [];

            for ($j = 0; $j < count($list_class_id); $j++) {
                $class_id_super_mono = $list_class_id[$j];
                $list_class .= $class_info[$class_id_super_mono]['class_code'];
                if($j < count($list_class_id) - 1) {
                    $list_class .= ' | ';
                }
                array_push($arr_area,$list_class_id_to_area[$class_id_super_mono]);
            }

            $arr_area = array_values(array_unique($arr_area));
            $area_text = '';
            for ($x = 0; $x < count($arr_area); $x++) {
                if ($x ==0 ){
                    $area_text .= $arr_area[$x];
                }else{
                    $area_text .= " | ".$arr_area[$x];
                }
            }

            switch (true){
                case ($point_teacher_arr[$id_teacher]['average_point_of_teacher'] >=9.5):
                    $xeploai = 'Xuất sắc';
                    break;
                case ($point_teacher_arr[$id_teacher]['average_point_of_teacher'] >=9):
                    $xeploai = 'Giỏi';
                    break;
                case ($point_teacher_arr[$id_teacher]['average_point_of_teacher'] >=8.6):
                    $xeploai = 'Khá';
                    break;
                case ($point_teacher_arr[$id_teacher]['average_point_of_teacher'] >=8):
                    $xeploai = 'Trung bình';
                    break;
                default:
                    $xeploai = 'Yếu';
                    break;
            }

            if ($point_teacher_arr[$id_teacher]['average_point_of_teacher'] == 0){
                $xeploai = '';
            }

            $objPHPExcel->getActiveSheet(0)
                ->setCellValue('A'.$count, $id_teacher)
                ->setCellValue('B'.$count, $teacher_id_to_name[$id_teacher])
                ->setCellValue('C'.$count, $point_teacher_arr[$id_teacher]['number_class'])
                ->setCellValue('D'.$count, $point_teacher_arr[$id_teacher]['average_point_of_teacher'])
                ->setCellValue('E'.$count, $list_class)
                ->setCellValue('F'.$count, $xeploai)
                ->setCellValue('G'.$count, $area_text);
            $i++;
        }
        $objPHPExcel->getActiveSheet()->setTitle($filename);
        $objPHPExcel->setActiveSheetIndex(0);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachement; filename="' . $filename . '"');
        ob_end_clean();
        return $objWriter->save('php://output');exit();

    }
}
