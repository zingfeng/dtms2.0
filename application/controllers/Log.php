<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends CI_Controller
{

    public function feedback_ksgv_detail()
    {
        $del = false;
        if (($_SESSION['role'] == 'admin') || ($_SESSION['role'] == 'manager')) {
            $del = true;
        }
        switch($_GET['type_ksgv']){
            case 'ksgv2':
                $type_ksgv = 'ksgv2';
                $list_quest_select = array(
                    '1. Về phương pháp giảng dạy', // 1
                    '2. Trình độ chuyên môn', //2
                    '3. Mức độ quan tâm học viên', // 3
                    '4. Mức độ truyền cảm hứng', // 4
                    '5. Mức độ tiến bộ của học viên', // 5
                    '6. Diện mạo - Tác phong giáo viên', // 6
                    '7. Bạn sẽ đánh giá giáo viên của mình bao nhiêu điểm', // 7
                );

                $list_quest_text = array(
                    '8. Mời bạn đóng góp thêm những điểm cần cải thiện để nâng cao chất lượng đào tạo/ mong muốn được hỗ trợ thêm?',
                );
                break;
            case 'dao_tao_onl':
                $type_ksgv = 'dao_tao_onl';
                $list_quest_ruler = array(
                    '1. TỐC ĐỘ giảng dạy có phù hợp không?', // 1
                    '2. Giảng viên có TƯƠNG TÁC nhiều với cá nhân không?', //2
                    '3. Giảng viên có MỞ RỘNG thêm kiến thức không?', // 3
                    '4. Giảng viên có hướng dẫn cách viết STUDENT BOOK không?', // 4
                    '5. Giảng viên có CUNG CẤP LƯỢNG TỪ VỰNG (glossary) mỗi buổi học hay không?', // 5
                    '6. Giảng viên có GIAO BÀI TẬP về nhà và KIỂM TRA đầy đủ hay không?', // 6
                    '7. Chất lượng đường truyền', // 7
                    '8. Mức độ dễ thao tác và sử dụng', // 7
                    '9. Chất lượng học online', // 7
                );
                $list_quest_select = array(
                    '10. Bạn sẽ đánh giá giáo viên của mình bao nhiêu điểm?', // 7
                );
                break;
            default:
                $type_ksgv = 'ksgv1';
                $list_quest_select = array(
                    '1. TỐC ĐỘ giảng dạy có phù hợp không?', // 1
                    '2. Giảng viên có TƯƠNG TÁC nhiều với cá nhân, tập thể không?', //2
                    '3. Giảng viên có TỰ TIN khi giảng dạy bằng slide hay không?', // 3
                    '4. Giảng viên có MỞ RỘNG thêm kiến thức TRÊN BẢNG không?', // 4
                    '5. Giảng viên có hướng dẫn cách viết STUDENT BOOK không?', // 5
                    '6. Giảng viên có CUNG CẤP LƯỢNG TỪ VỰNG (glossary) mỗi buổi học hay không?', // 6
                    '7. Giảng viên có CHUẨN BỊ KỸ BÀI và NẮM RÕ SLIDE không?', // 7
                    '8. Giảng viên có GIAO BÀI TẬP về nhà và KIỂM TRA đầy đủ hay không?', // 8
                    '9. Giảng viên có DI CHUYỂN LINH HOẠT trong lớp học (giữa máy tính/bảng và về phía học viên) không?',
                    '10. Bạn sẽ đánh giá giáo viên của mình bao nhiêu điểm',
                );
                $list_quest_text = array();
                break;
        }

        $this->load->model('Feedback_model', 'feedback');
        $this->load->model('Feed_upgrade_model', 'fu');

        $params['limit'] = 500;
        $params['type'] = $type_ksgv;
        $list_fb = $this->fu->get_feedback_ksgv($params);  // zfdev Viết lại phần filter trong model

        $location_info = $this->feedback->get_list_location();
        $arr_location_info = array();
        foreach ($location_info as $mono_location) {
            $arr_location_info[$mono_location['id']] = $mono_location['name'] . ' - Khu vực ' . $mono_location['area'];
        }
        // ==================================

        $data = array(
            'rows' => $list_fb,
            'location_info' => $location_info,
            'type_ksgv' => $type_ksgv,
            'list_quest_ruler' => $list_quest_ruler,
            'list_quest_select' => $list_quest_select,
            'list_quest_text' => $list_quest_text,
            'arr_location_info' => $arr_location_info,
            'del' => $del
        );
        $this->load->layout('feedback/feedback_ksgv_detail', $data, false,'layout_feedback');
    }

    public function export_feedback_ksgv_detail(){
        if (($_SESSION['role'] == 'admin') || ($_SESSION['role'] == 'manager')) {
            $del = true;
        }
        switch($_GET['type_ksgv']){
            case 'ksgv2':
                $type_ksgv = 'ksgv2';
                $list_quest_select = array(
                    '1. Về phương pháp giảng dạy', // 1
                    '2. Trình độ chuyên môn', //2
                    '3. Mức độ quan tâm học viên', // 3
                    '4. Mức độ truyền cảm hứng', // 4
                    '5. Mức độ tiến bộ của học viên', // 5
                    '6. Diện mạo - Tác phong giáo viên', // 6
                    '7. Bạn sẽ đánh giá giáo viên của mình bao nhiêu điểm', // 7
                );

                $list_quest_text = array(
                    '8. Mời bạn đóng góp thêm những điểm cần cải thiện để nâng cao chất lượng đào tạo/ mong muốn được hỗ trợ thêm?',
                );
                break;
            default:
                $type_ksgv = 'ksgv1';
                $list_quest_select = array(
                    '1. TỐC ĐỘ giảng dạy có phù hợp không?', // 1
                    '2. Giảng viên có TƯƠNG TÁC nhiều với cá nhân, tập thể không?', //2
                    '3. Giảng viên có TỰ TIN khi giảng dạy bằng slide hay không?', // 3
                    '4. Giảng viên có MỞ RỘNG thêm kiến thức TRÊN BẢNG không?', // 4
                    '5. Giảng viên có hướng dẫn cách viết STUDENT BOOK không?', // 5
                    '6. Giảng viên có CUNG CẤP LƯỢNG TỪ VỰNG (glossary) mỗi buổi học hay không?', // 6
                    '7. Giảng viên có CHUẨN BỊ KỸ BÀI và NẮM RÕ SLIDE không?', // 7
                    '8. Giảng viên có GIAO BÀI TẬP về nhà và KIỂM TRA đầy đủ hay không?', // 8
                    '9. Giảng viên có DI CHUYỂN LINH HOẠT trong lớp học (giữa máy tính/bảng và về phía học viên) không?',
                    '10. Bạn sẽ đánh giá giáo viên của mình bao nhiêu điểm',
                );
                $list_quest_text = array();
                break;
        }

        $this->load->model('Feedback_model', 'feedback');
        $this->load->model('Feed_upgrade_model', 'fu');

        $params['limit'] = 500;
        $params['type'] = $type_ksgv;
        $list_fb = $this->fu->get_feedback_ksgv($params);  // zfdev Viết lại phần filter trong model

        $location_info = $this->feedback->get_list_location();
        $arr_location_info = array();
        foreach ($location_info as $mono_location) {
            $arr_location_info[$mono_location['id']] = $mono_location['name'] . ' - Khu vực ' . $mono_location['area'];
        }
        // ==================================

//        $data = array(
//            'rows' => $list_fb,
//            'location_info' => $location_info,
//            'type_ksgv' => $type_ksgv,
//            'list_quest_select' => $list_quest_select,
//            'list_quest_text' => $list_quest_text,
//            'arr_location_info' => $arr_location_info,
//            'del' => $del
//        );
        // ================================== START EXPORT

        $this->load->library('PHPExcel');


        switch($_GET['type_ksgv']){
            case 'ksgv2':
                $filename = 'Feedback-KSGV-Lan2.xlsx';
                break;
            default:
                $filename = 'Feedback-KSGV-Lan1.xlsx';
        }
        $objPHPExcel = new PHPExcel();
        $i = 1;
        $baseRow = 1;

        foreach($list_fb as $mono_feedback) {
            $class_code_mono = $mono_feedback['class_code'];
            $time_end = $mono_feedback['time_end'];
            $name_feeder = $mono_feedback['name_feeder'];
            $age = $mono_feedback['age'];

            $list_teacher_text = '';

            $list_quest_total = array_merge($list_quest_select, $list_quest_text);


            $count = $baseRow + $i;
            if ($i == 1) {
                $objPHPExcel->getActiveSheet(0)
                    ->setCellValue('A' . $i, "ID")// index 0
                    ->setCellValue('B' . $i, "Mã lớp")// index 1
                    ->setCellValue('C' . $i, "Thời gian")// 2
                    ->setCellValue('D' . $i, "Tên")//3
                    ->setCellValue('E' . $i, "Tuổi"); // 4
                $num_index = 5;
                for ($kk = 0; $kk < count($list_quest_total); $kk++) {
                    $nameColumn = getNameFromNumber($num_index);
                    $stt_kk = $kk + 1;
                    $objPHPExcel->getActiveSheet(0)->setCellValue($nameColumn . $i, "Q" . $stt_kk);
                    $num_index++;
                }

                $nameColumn = getNameFromNumber($num_index);
                $objPHPExcel->getActiveSheet(0)->setCellValue($nameColumn . $i, "ĐTB");
            }

            $objPHPExcel->getActiveSheet()->insertNewRowBefore($count, 1);

            $objPHPExcel->getActiveSheet(0)
                ->setCellValue('A' . $count, $mono_feedback['id'])
                ->setCellValue('B' . $count, $class_code_mono)
                ->setCellValue('C' . $count, date('d/m/Y - H:i:s', $time_end))
                ->setCellValue('D' . $count, $name_feeder)
                ->setCellValue('E' . $count, $age);

            $detail = $mono_feedback['detail'];
            $detail_live = json_decode($detail, true);
            $mono__sum = 0;
            $mono__count = 0;

            $num_index = 5;
            for ($zz = 0; $zz < count($detail_live); $zz++) {
                $mono_detail = $detail_live[$zz];
                $type = $mono_detail[1];
                if ($type === 'select') {
                    $mono_point = $mono_detail[3];
                    if ($mono_point > 0) {
                        $mono__sum += $mono_point;
                        $mono__count++;
                    }
                    $nameColumn = getNameFromNumber($num_index);

                    $objPHPExcel->getActiveSheet(0)->setCellValue($nameColumn . $count, $mono_point);

                } else {
                    $content = $mono_detail[3];
                    $nameColumn = getNameFromNumber($num_index);

                    $objPHPExcel->getActiveSheet(0)->setCellValue($nameColumn . $count, $content);
                }
                $num_index++;
            }


            if ($mono__count > 0) {
                $dtb = round($mono__sum / $mono__count, 2);
            } else {
                $dtb = 0;
            }
            $nameColumn = getNameFromNumber($num_index);
            $objPHPExcel->getActiveSheet(0)->setCellValue($nameColumn . $count, $dtb);
        }

        $objPHPExcel->getActiveSheet()->setTitle($filename);
        $objPHPExcel->setActiveSheetIndex(0);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachement; filename="' . $filename . '"');
        ob_end_clean();
        return $objWriter->save('php://output');exit();

    }

    public function hom_thu_gop_y_detail(){
        $this->load->model('Feedback_model', 'feedback');
        $list_fb_homthu = $this->feedback->get_list_feedback_hom_thu_gop_y('');
        $location_info = $this->feedback->get_list_location();
        $arr_location_info = array();
        foreach ($location_info as $mono_location) {
            $arr_location_info[$mono_location['id']] = $mono_location['name'] . ' - Khu vực ' . $mono_location['area'];
        }

        $data = array(
            'rows' => $list_fb_homthu,
            'location_info' => $location_info,
        );
        $this->load->layout('feedback/feedback_homthugopy_detail', $data, false,'layout_feedback');
    }

    public function export_hom_thu_gop_y_detail(){
        $this->load->model('Feedback_model', 'feedback');
        $list_fb_homthu = $this->feedback->get_list_feedback_hom_thu_gop_y('');
        $location_info = $this->feedback->get_list_location();
        $arr_location_info = array();
        foreach ($location_info as $mono_location) {
            $arr_location_info[$mono_location['id']] = $mono_location['name'] . ' - Khu vực ' . $mono_location['area'];
        }

        $data = array(
            'rows' => $list_fb_homthu,
            'location_info' => $location_info,
        );


        $this->load->library('PHPExcel');

        $filename = 'Feedback-Hom-thu-gop-y.xlsx';
        $objPHPExcel = new PHPExcel();
        $i = 1;
        $baseRow = 1;

        foreach($list_fb_homthu as $mono_feedback) {
            $class_code_mono = $mono_feedback['class_code'];
            $time_end = $mono_feedback['time_end'];
            $name_feeder = $mono_feedback['name_feeder'];
            $detail = $mono_feedback['detail'];
            $detail_live = json_decode($detail,true);

            $comment = $detail_live[0][3];

            $count = $baseRow + $i;
            if ($i == 1) {
                $objPHPExcel->getActiveSheet(0)
                    ->setCellValue('A' . $i, "ID")// index 0
                    ->setCellValue('B' . $i, "Mã lớp")// index 1
                    ->setCellValue('C' . $i, "Thời gian")// 2
                    ->setCellValue('D' . $i, "Tên")//3
                    ->setCellValue('E' . $i, "Nội dung góp ý"); // 4
            }

            $objPHPExcel->getActiveSheet()->insertNewRowBefore($count, 1);
            $objPHPExcel->getActiveSheet(0)
                ->setCellValue('A' . $count, $mono_feedback['id'])
                ->setCellValue('B' . $count, $class_code_mono)
                ->setCellValue('C' . $count, date('d/m/Y - H:i:s', $time_end))
                ->setCellValue('D' . $count, $name_feeder)
                ->setCellValue('E' . $count, $comment);
        }

        $objPHPExcel->getActiveSheet()->setTitle($filename);
        $objPHPExcel->setActiveSheetIndex(0);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachement; filename="' . $filename . '"');
        ob_end_clean();
        return $objWriter->save('php://output');exit();

    }

    public function feedback_phone_detail_old(){
        guard();
        guard_admin_manager();

        $del = false;
        if (($_SESSION['role'] == 'admin') || ($_SESSION['role'] == 'manager')) {
            $del = true;
        }

        $this->load->model('Feedback_model', 'feedback');
        if(count($_REQUEST) > 0) {
            if (isset($_REQUEST['starttime'])) {
                $starttime = strtotime(strip_tags($_REQUEST['starttime']));
            }

            if (isset($_REQUEST['endtime'])) {
                $endtime = strtotime(strip_tags($_REQUEST['endtime']));
            }

            if (isset($_REQUEST['class'])) {
                $class_code = strip_tags($_REQUEST['class']);
            }

            if (isset($_REQUEST['location'])) {
                $location = $_REQUEST['location'];
                $location = json_decode($location, true);
            }

            if (isset($_REQUEST['area'])) {
                $area = $_REQUEST['area'];
                $area = json_decode($area, true);
            }
            // lazy code
            $list_feedback_phone_newestSS = $this->feedback->get_list_feedback_phone_filter(1000, $starttime, $endtime, $class_code, $area, $location);
        } else {
            $list_feedback_phone_newestSS = $this->feedback->get_list_feedback_phone_newest(1000);
        }


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


        $list_feedback_newest = $this->feedback->get_list_feedback_paper('', '', 'time_end');
        $list_feedback_newest = array_slice($list_feedback_newest, 0, 200); // 100 feed back mới nhất


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

        $data = array(
            'list_feedback_newest' => $list_feedback_newest, // feedback form
            'list_feedback_phone_newestSS' => $list_feedback_phone_newestSS,
            'array_class_code_feedback_phone_type' => $array_class_code_feedback_phone_type,
            'arr_info_class' => $arr_info_class,
            'location_info' => $location_info,
            'arr_location_id_to_location_info' => $arr_location_id_to_location_info,
            'arr_techer_id_to_teacher_info' => $arr_techer_id_to_teacher_info,
            'del' => $del,
        );

        $this->load->layout('feedback/feedback_phone_detail', $data, false, 'layout_feedback');
    }

    public function feedback_phone_detail(){
        guard();
        guard_admin_manager();

        $del = false;
        if (($_SESSION['role'] == 'admin') || ($_SESSION['role'] == 'manager')) {
            $del = true;
        }

        $this->load->model('Feedback_model', 'feedback');
        $this->load->model('Feed_upgrade_model', 'fu');

        $params = [];


        if(count($_REQUEST) > 0) {
            if (isset($_REQUEST['starttime'])) {
                $params['starttime'] = strtotime(strip_tags($_REQUEST['starttime']));
            }

            if (isset($_REQUEST['endtime'])) {
                $params['endtime'] = strtotime(strip_tags($_REQUEST['endtime']));
            }

            if (isset($_REQUEST['class'])) {
                $class_code = strip_tags($_REQUEST['class']);
                $params['class_code'] = $class_code;
            }

            if (isset($_REQUEST['teacher_name'])) {
                $teacher = strip_tags($_REQUEST['teacher_name']);
                $params['teacher_name'] = $teacher;
            }

            if (isset($_REQUEST['location'])) {
                $location = $_REQUEST['location'];
                $params['location'] = json_decode($location, true);
            }

            if (isset($_REQUEST['area'])) {
                $area = $_REQUEST['area'];
                $params['area'] = json_decode($area, true);
            }
        }
        $location_info = $this->feedback->get_list_location();
        $params['limit'] = 500;
        $list_fb_phone = $this->fu->get_fb_phone($params);
//        echo '<pre>';
//        print_r($list_fb_phone);
//        exit;

        $data = array(
            'rows' => $list_fb_phone,
            'del' => $del,
            'location_info' => $location_info
        );

        $this->load->layout('feedback/feedback_phone_detail', $data, false, 'layout_feedback');
    }

    public function export_list_feedback_phone_detail(){
        guard();
        guard_admin_manager();

        $del = false;
        if (($_SESSION['role'] == 'admin') || ($_SESSION['role'] == 'manager')) {
            $del = true;
        }

        $this->load->model('Feedback_model', 'feedback');
        $this->load->model('Feed_upgrade_model', 'fu');

        $params = [];


        $dataLink = '';
        if (isset($_REQUEST['starttime'])) {
            $params['starttime'] = strtotime(strip_tags($_REQUEST['starttime']));
            $dataLink .= '&starttime='.$params['starttime'];
        }

        if (isset($_REQUEST['endtime'])) {
            $params['endtime'] = strtotime(strip_tags($_REQUEST['endtime']));
            $dataLink .= '&endtime='.$params['endtime'];
        }

        if (isset($_REQUEST['class'])) {
            $class_code = strip_tags($_REQUEST['class']);
            $params['class_code'] = $class_code;
            $dataLink .= '&class='.$class_code;
        }

        if (isset($_REQUEST['location'])) {
            $location = $_REQUEST['location'];
            $dataLink .= '&location='.$location;
            $params['location'] = json_decode($location, true);
        }

        if (isset($_REQUEST['area'])) {
            $area = $_REQUEST['area'];
            $dataLink .= '&area='.$area;
            $params['area'] = json_decode($area, true);
        }

        $params['limit'] = 500;
        $list_fb_phone = $this->fu->get_list_feedback_phone_export($params);

        $filename = 'Feedback-Phone.xlsx';
        $this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel();
        $i = 1;
        $baseRow = 1;

        foreach($list_fb_phone as $keyEX => $mono_feedback_phone){
            $count = $baseRow + $i;
            $classLink = '';
            if(empty($_REQUEST['class'])){
                $classLink = '&class='.$mono_feedback_phone['class_code'];
            }
            if($i == 1){
                $objPHPExcel->getActiveSheet(0)
                    ->setCellValue('A'.$i, "STT")
                    ->setCellValue('B'.$i, "Lớp")
                    ->setCellValue('C'.$i, "Giảng viên")
                    ->setCellValue('D'.$i, "Cơ sở")
                    ->setCellValue('E'.$i, "Ngày nhận KS")
                    ->setCellValue('F'.$i, "Lần")
                    ->setCellValue('G'.$i, "Điểm trung bình")
                    ->setCellValue('H'.$i, "Chi tiết");
            }
            $objPHPExcel->getActiveSheet()->insertNewRowBefore($count,1);

            $objPHPExcel->getActiveSheet(0)
                ->setCellValue('A'.$count, $keyEX+1 )
                ->setCellValue('B'.$count, $mono_feedback_phone['class_code'])
                ->setCellValue('C'.$count, $mono_feedback_phone['teacher_name'])
                ->setCellValue('D'.$count, $mono_feedback_phone['name'].' - '.$mono_feedback_phone['area'])
                ->setCellValue('E'.$count, date('d/m/Y', $mono_feedback_phone['time']))
                ->setCellValue('F'.$count, $mono_feedback_phone['times'])
                ->setCellValue('G'.$count, $mono_feedback_phone['point'])
                ->setCellValue('H'.$count, 'https://dtms.aland.edu.vn/feedback/feedback_phone_detail?'.$classLink.$dataLink);
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

    public function export_list_feedback_phone_detail_old(){
//        ini_set('display_errors', 1);
//        ini_set('display_startup_errors', 1);
//        error_reporting(E_ALL);
        guard();
        guard_admin_manager();
        // md bootstrap
        // Quản lý danh sách lớp
        // Quản lý danh sách giảng viên
        // 1 view
        //
        $this->load->model('Feedback_model', 'feedback');

//        $this->_mark_all_class('');


        $top_class_ielts = $this->feedback->get_top_class_feedback_newest(15, 'ielts');
        $top_class_toeic = $this->feedback->get_top_class_feedback_newest(15, 'toeic');
        $top_class_giaotiep = $this->feedback->get_top_class_feedback_newest(15, 'giaotiep');
        $top_class_aland = $this->feedback->get_top_class_feedback_newest(15, 'aland');

        // lazy code
        $list_feedback_phone_newestSS = $this->feedback->get_list_feedback_phone_newest(100000);
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
            $res = $this->feedback->get_info_class_by_class_code($su_per_class_code);
            if( $res !== null){
                $arr_info_class[$su_per_class_code] = $res;
            }
        }

        $arr_new_feedback_form = array_merge($top_class_ielts,$top_class_toeic,$top_class_giaotiep,$top_class_aland);

        for ($i = 0; $i < count($arr_new_feedback_form); $i++) {
            $su_per_class_info = $arr_new_feedback_form[$i];
            $su_per_class_info_live = json_decode($su_per_class_info,true);
            $su_per_class_code = $su_per_class_info_live[1];
            if (isset($arr_info_class[$su_per_class_code])){continue; }
            $arr_info_class[$su_per_class_code] = $this->feedback->get_info_class_by_class_code($su_per_class_code);
        }

        //  [0] => ["ielts","Pre707"]

//        echo '<pre>'; print_r($array_class_code_feedback_phone_type); echo '</pre>'; exit;

        // =========== end lazy code

        $list_feedback_newest = $this->feedback->get_list_feedback_paper('', '', 'time_end');
        $list_feedback_newest = array_slice($list_feedback_newest, 0, 200); // 100 feed back mới nhất



        $list_feedback_phone_newest = $this->feedback->get_list_feedback_phone_newest(500);

//        echo '<pre>'; print_r($list_feedback_newest); echo '</pre>';
//        echo '<pre>'; print_r($list_feedback_phone_newest); echo '</pre>';
//        exit;

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
            'list_feedback_phone_newestSS' => $list_feedback_phone_newestSS,
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
        );
        $data = array_merge($data, $info);

        // ===============================================================
        // ===============================================================
        // ===============================================================
        // ===============================================================




        $filename = 'Feedback-Phone-'.date('d-m-Y').'.xlsx';
        $filename = 'Feedback-Phone.xlsx';
        $this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel();
        $i = 1;
        $baseRow = 1;

        foreach($list_feedback_phone_newestSS as $mono_feedback_phone){
            $class_code_mono = $mono_feedback_phone['class_code'];
            $time_end = $mono_feedback_phone['time'];
            $name_feeder = $mono_feedback_phone['name_feeder'];

            $list_teacher_text = '';

            if (isset($arr_info_class[$class_code_mono])){
                $list_teacher = $arr_info_class[$class_code_mono]['list_teacher'];
                if ( ($list_teacher != '')&&($list_teacher != 'null')){
                    $list_teacher_live = json_decode($list_teacher,true);
                    foreach ($list_teacher_live as $super_mono_teacher_id) {
                        $list_teacher_text .= $arr_techer_id_to_teacher_info[$super_mono_teacher_id]['name'].' ';
                    }
                }
            }



            $count = $baseRow + $i;
            if($i == 1){
                $objPHPExcel->getActiveSheet(0)
                    ->setCellValue('A'.$i, "ID")
                    ->setCellValue('B'.$i, "Thời gian")
                    ->setCellValue('C'.$i, "Ngày")
                    ->setCellValue('D'.$i, "Mã lớp")
                    ->setCellValue('E'.$i, "Giáo viên")
                    ->setCellValue('F'.$i, "Học viên")
                    ->setCellValue('G'.$i, "Điểm")
                    ->setCellValue('H'.$i, "Nhận xét");
            }
            $objPHPExcel->getActiveSheet()->insertNewRowBefore($count,1);

            $objPHPExcel->getActiveSheet(0)
                ->setCellValue('A'.$count, $mono_feedback_phone['id'] )
                ->setCellValue('B'.$count, date('d/m/Y - H:i:s', $time_end))
                ->setCellValue('C'.$count, date('d/m/Y', $time_end))
                ->setCellValue('D'.$count, $class_code_mono)
                ->setCellValue('E'.$count, $list_teacher_text)
                ->setCellValue('F'.$count, $name_feeder)
                ->setCellValue('G'.$count, $mono_feedback_phone['point'])
                ->setCellValue('H'.$count, $mono_feedback_phone['comment']);
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
