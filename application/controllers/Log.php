<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends CI_Controller
{
    public function feedback_ksgv_detail()
    {
        guard();
        $del = false;
        if (($_SESSION['role'] == 'admin') || ($_SESSION['role'] == 'manager')) {
            $del = true;
        }
        if (isset($_REQUEST['location'])) {
            $params['location'] = json_decode($_REQUEST['location'], true);
        }
        if (isset($_REQUEST['area'])) {
            $params['area'] = json_decode($_REQUEST['area'], true);
        }
        if (isset($_REQUEST['class_code'])) {
            $params['class_code'] = strip_tags($_REQUEST['class_code']);
        }
        if (isset($_REQUEST['manager_email'])) {
            $params['manager_email'] = strip_tags($_REQUEST['manager_email']);
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
                    '1. TỐC ĐỘ giảng dạy có phù hợp không?',
                    '2. Giảng viên có TƯƠNG TÁC nhiều với cá nhân không?',
                    '3. Giảng viên có MỞ RỘNG thêm kiến thức không?',
//                    '4. Giảng viên có hướng dẫn cách viết STUDENT BOOK không?',
                    '4. Giảng viên có CUNG CẤP LƯỢNG TỪ VỰNG (glossary) mỗi buổi học hay không?',
                    '5. Giảng viên có GIAO BÀI TẬP về nhà và KIỂM TRA đầy đủ hay không?',
                    '6. Chất lượng đường truyền',
//                    '8. Mức độ dễ thao tác và sử dụng',
                    '7. Chất lượng học online',
                );
                $list_quest_select = array(
                    '8. Bạn sẽ đánh giá giáo viên của mình bao nhiêu điểm?',
                )
                ;$list_quest_text = array(
                    '9. Bạn có đóng góp gì cho giáo viên và trung tâm không?',
                );
                break;
            case 'giua_ky_off':
                $type_ksgv = 'giua_ky_off';
                $list_quest_ruler = array(
                    '1. TỐC ĐỘ giảng dạy có phù hợp không?',
                    '2. Giảng viên có TƯƠNG TÁC nhiều với cá nhân không?',
                    '3. Giảng viên có MỞ RỘNG thêm kiến thức không?',
                    '4. Giảng viên có CUNG CẤP LƯỢNG TỪ VỰNG (glossary) mỗi buổi học hay không?',
                    '5. Giảng viên có GIAO BÀI TẬP về nhà và KIỂM TRA đầy đủ hay không?',
                );
                $list_quest_select = array(
                    '6. Bạn sẽ đánh giá giáo viên của mình bao nhiêu điểm?',
                )
                ;$list_quest_text = array(
                    '7. Bạn có đóng góp gì cho giáo viên và trung tâm không?',
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

        $list_manager = $this->fu->get_teacher_manager();
        $data_manager = array();
        foreach ($list_manager as $manager){
            if($manager['manager_email']){
                $data_manager[] = $manager['manager_email'];
            }
        }

        $params['limit'] = 500;
        $params['type_ksgv'] = $type_ksgv;
        $list_fb = $this->fu->get_feedback_ksgv($params);  // zfdev Viết lại phần filter trong model

        $location_info = $this->feedback->get_list_location();
        $arr_location_info = array();
        foreach ($location_info as $mono_location) {
            $arr_location_info[$mono_location['id']] = $mono_location['name'] . ' - Khu vực ' . $mono_location['area'];
        }

        $data = array(
            'rows' => $list_fb,
            'location_info' => $location_info,
            'type_ksgv' => $type_ksgv,
            'list_quest_ruler' => $list_quest_ruler,
            'list_quest_select' => $list_quest_select,
            'list_quest_text' => $list_quest_text,
            'arr_location_info' => $arr_location_info,
            'list_manager' => $data_manager,
            'del' => $del
        );
        if (($_SESSION['role'] == 'admin') || ($_SESSION['role'] == 'manager')) {
            $this->load->layout('feedback/feedback_ksgv_detail', $data, false, 'layout_feedback');
        } else {
            $this->load->layout('feedback/feedback_ksgv_detail', $data, false, 'layout_feedback_tuvan');
        }
    }

    public function export_feedback_ksgv_detail(){
        $alphabet = range('A', 'Z');
        guard();

        if (isset($_REQUEST['location'])) {
            $params['location'] = json_decode($_REQUEST['location'], true);
            $dataLink .= '&location='.$_REQUEST['location'];
        }
        if (isset($_REQUEST['area'])) {
            $params['area'] = json_decode($_REQUEST['area'], true);
            $dataLink .= '&area='.$_REQUEST['area'];
        }
        if (isset($_REQUEST['class_code'])) {
            $params['class_code'] = strip_tags($_REQUEST['class_code']);
            $dataLink .= '&class_code='.$_REQUEST['class_code'];
        }
        if (isset($_REQUEST['manager_email'])) {
            $params['manager_email'] = strip_tags($_REQUEST['manager_email']);
            $dataLink .= '&manager_email='.$_REQUEST['manager_email'];
        }
        $this->load->model('Feedback_model', 'feedback');
        $this->load->model('Feed_upgrade_model', 'fu');

        $list_manager = $this->fu->get_teacher_manager();
        $data_manager = array();
        foreach ($list_manager as $manager){
            if($manager['manager_email']){
                $data_manager[] = $manager['manager_email'];
            }
        }

        $params['limit'] = 1000;
        $params['type_ksgv'] = $type_ksgv;
        $list_fb = $this->fu->get_feedback_ksgv($params);  // zfdev Viết lại phần filter trong model

        $location_info = $this->feedback->get_list_location();
        $arr_location_info = array();
        foreach ($location_info as $mono_location) {
            $arr_location_info[$mono_location['id']] = $mono_location['name'] . ' - Khu vực ' . $mono_location['area'];
        }

        $this->load->library('PHPExcel');

        switch($_GET['type_ksgv']){
            case 'ksgv2':
                $filename = 'Feedback-Cuoi_ky.xlsx';
                break;
            case 'dao_tao_onl':
            case 'giua_ky_off':
                $filename = 'Feedback-Giua_ky.xlsx';
                break;
            default:
                $filename = 'Feedback-KSGV-Lan1.xlsx';
        }
        $objPHPExcel = new PHPExcel();
        $i = 1;
        $baseRow = 1;

        foreach($list_fb as $keyEX => $mono_feedback){
            $count = $baseRow + $i;
            $classLink = '';
            if(empty($_REQUEST['class_code'])){
                $classLink .= '&class_code='.$mono_feedback['class_code'];
            }
            switch ($mono_feedback['type']) {
                case 'ksgv2':
                    $type = 'Cuối kỳ';
                    break;
                case 'dao_tao_onl':
                case 'giua_ky_off':
                    $type = 'Giữa kỳ';
                    break;
                default:
                    $type = '';
            }
            $classLink .= '&type_ksgv='.$mono_feedback['type'];

            $detail = $mono_feedback['detail'];
            $detail_live = json_decode($detail,true);

            if($i == 1){
                $objPHPExcel->getActiveSheet(0)->setCellValue('A'.$i, "STT");
                $objPHPExcel->getActiveSheet(0)->setCellValue('B'.$i, "Loại khảo sát");
                $objPHPExcel->getActiveSheet(0)->setCellValue('C'.$i, "Lớp");
                $objPHPExcel->getActiveSheet(0)->setCellValue('D'.$i, "Giảng viên");
                $objPHPExcel->getActiveSheet(0)->setCellValue('E'.$i, "Người feedback");
                $objPHPExcel->getActiveSheet(0)->setCellValue('F'.$i, "Thời gian");

                $alpha = 6;
                $qt = 1;
                foreach ($detail_live as $keyDetail => $detail) {
                    if(count($detail_live) > 9) {
                        // Bỏ câu hỏi số 4 và số 8
                        if ( ($keyDetail == 3) || ($keyDetail == 7)){
                            continue;
                        }
                    }
                    $objPHPExcel->getActiveSheet(0)->setCellValue($alphabet[$alpha].$i, "Q".$qt);
                    $alpha++;
                    $qt++;
                }

                $objPHPExcel->getActiveSheet(0)->setCellValue($alphabet[$alpha].$i, "Điểm trung bình");
                $objPHPExcel->getActiveSheet(0)->setCellValue($alphabet[$alpha+1].$i, "Chi tiết");
            }
            $objPHPExcel->getActiveSheet()->insertNewRowBefore($count,1);

            $mono__sum = 0;
            $mono__count = 0;
            $x = 0;

            $objPHPExcel->getActiveSheet(0)->setCellValue('A'.$count, $keyEX+1 );
            $objPHPExcel->getActiveSheet(0)->setCellValue('B'.$count, $type);
            $objPHPExcel->getActiveSheet(0)->setCellValue('C'.$count, $mono_feedback['class_code']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('D'.$count, $mono_feedback['teacher_name']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('E'.$count, $mono_feedback['name_feeder']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('F'.$count, date('d/m/Y - H:i:s', $mono_feedback['time_end']));

            foreach ($detail_live as $keyDetail2 => $detail) {
                if(count($detail_live) > 9) {
                    // Bỏ câu hỏi số 4 và số 8
                    if ( ($keyDetail2 == 3) || ($keyDetail2 == 7)){
                        continue;
                    }
                }

                $type = $detail[1];
                if ($type === 'select'){
                    $mono_point = (int)$detail[3];
                    if ($mono_point > 0){
                        $mono__sum += $mono_point;
                        $mono__count ++;
                    }
                }elseif($type === 'ruler'){
                    $mono_point = (int)$detail[3]*2;
                    if ($mono_point > 0){
                        $mono__sum += $mono_point;
                        $mono__count ++;
                    }
                }else{
                    $content = $detail[3];
                    $mono_point = $content;
                }
                $objPHPExcel->getActiveSheet(0)->setCellValue($alphabet[$x+5].$count, $mono_point);
                // check nếu k có câu trả lời dạng text thì hiển thị cột rỗng tránh lỗi bảng
                if(count($detail_live) > 9 && $keyDetail2 == 9) {
                    if($keyDetail2 == 9){
                        $objPHPExcel->getActiveSheet(0)->setCellValue($alphabet[$x+5].$count, '');
                    }
                }
                $x++;
            }
            if ($mono__count > 0){
                $point_round = round($mono__sum / $mono__count,2);
            }else{
                $point_round = 0;
            }
            $objPHPExcel->getActiveSheet(0)->setCellValue($alphabet[$x+5].$count, $point_round);
            $objPHPExcel->getActiveSheet(0)->setCellValue($alphabet[$x+6].$count, 'https://qlcl.imap.edu.vn/feedback/feedback_ksgv_detail?'.$classLink.$dataLink);
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

    public function hom_thu_gop_y_detail(){
        guard();
        $this->load->model('Feedback_model', 'feedback');
        $params['class_code'] = '';
        if (isset($_REQUEST['class'])) {
            $class_code = strip_tags($_REQUEST['class']);
            $params['class_code'] = $class_code;
        }
        $list_fb_homthu = $this->feedback->get_list_feedback_hom_thu_gop_y($params['class_code']);
        $location_info = $this->feedback->get_list_location();

        $arr_location_info = array();
        foreach ($location_info as $mono_location) {
            $arr_location_info[$mono_location['id']] = $mono_location['name'] . ' - Khu vực ' . $mono_location['area'];
        }

        $data = array(
            'rows' => $list_fb_homthu,
            'location_info' => $location_info,
        );
        if (($_SESSION['role'] == 'admin') || ($_SESSION['role'] == 'manager')) {
            $this->load->layout('feedback/feedback_homthugopy_detail', $data, false, 'layout_feedback');
        } else {
            $this->load->layout('feedback/feedback_homthugopy_detail', $data, false, 'layout_feedback_tuvan');
        }
    }

    public function export_hom_thu_gop_y_detail(){
        guard();
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

    public function feedback_phone_detail(){
        guard();
        $del = false;
        if (($_SESSION['role'] == 'admin') || ($_SESSION['role'] == 'manager')) {
            $del = true;
        }

        $this->load->model('Feedback_model', 'feedback');
        $this->load->model('Feed_upgrade_model', 'fu');

        $list_manager = $this->fu->get_teacher_manager();
        $data_manager = array();
        foreach ($list_manager as $manager){
            if($manager['manager_email']){
                $data_manager[] = $manager['manager_email'];
            }
        }

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

            if (isset($_REQUEST['manager_email'])) {
                $params['manager_email'] = strip_tags($_REQUEST['manager_email']);
            }
        }
        $location_info = $this->feedback->get_list_location();
        $params['limit'] = 500;
        $list_fb_phone = $this->fu->get_fb_phone($params);

        $data = array(
            'rows' => $list_fb_phone,
            'del' => $del,
            'location_info' => $location_info,
            'list_manager' => $data_manager,
        );
        if (($_SESSION['role'] == 'admin') || ($_SESSION['role'] == 'manager')) {
            $this->load->layout('feedback/feedback_phone_detail', $data, false, 'layout_feedback');
        } else {
            $this->load->layout('feedback/feedback_phone_detail', $data, false, 'layout_feedback_tuvan');
        }
    }

    public function export_list_feedback_phone_detail(){
        guard();
        guard_admin_manager();

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
                    ->setCellValue('B'.$i, "Loại khảo sát")
                    ->setCellValue('C'.$i, "Lớp")
                    ->setCellValue('D'.$i, "Giảng viên")
                    ->setCellValue('E'.$i, "Người Feedback")
                    ->setCellValue('F'.$i, "Cơ sở")
                    ->setCellValue('G'.$i, "Ngày nhận KS")
                    ->setCellValue('H'.$i, "Lần")
                    ->setCellValue('I'.$i, "Điểm")
                    ->setCellValue('J'.$i, "Nội dung")
                    ->setCellValue('K'.$i, "Chi tiết");
            }
            $objPHPExcel->getActiveSheet()->insertNewRowBefore($count,1);

            $objPHPExcel->getActiveSheet(0)
                ->setCellValue('A'.$count, $keyEX+1 )
                ->setCellValue('B'.$count, 'Phone')
                ->setCellValue('C'.$count, $mono_feedback_phone['class_code'])
                ->setCellValue('D'.$count, $mono_feedback_phone['teacher_name'])
                ->setCellValue('E'.$count, $mono_feedback_phone['name_feeder'])
                ->setCellValue('F'.$count, $mono_feedback_phone['name'].' - '.$mono_feedback_phone['area'])
                ->setCellValue('G'.$count, date('d/m/Y', $mono_feedback_phone['time']))
                ->setCellValue('H'.$count, $mono_feedback_phone['times'])
                ->setCellValue('I'.$count, $mono_feedback_phone['point'])
                ->setCellValue('J'.$count, $mono_feedback_phone['comment'])
                ->setCellValue('K'.$count, 'https://qlcl.imap.edu.vn/feedback/feedback_phone_detail?'.$classLink.$dataLink);
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

    public function export_list_feedback_group_by_class(){
        guard();
        $this->load->model('Feedback_model', 'feedback');
        $this->load->model('Feed_upgrade_model', 'fu');

        $params = [];
        $params_ksgv = [];

        if(count($_REQUEST) > 0) {
            if (isset($_REQUEST['starttime'])) {
                $params['starttime'] = strtotime(strip_tags($_REQUEST['starttime']));
            }
            if (isset($_REQUEST['endtime'])) {
                $params['endtime'] = strtotime(strip_tags($_REQUEST['endtime']));
            }
            if (isset($_REQUEST['type'])) {
                $type = strip_tags($_REQUEST['type']);
                $params['class_type'] = $type;
            }
            if (isset($_REQUEST['fb_type'])) {
                $fb_type = strip_tags($_REQUEST['fb_type']);
                $params['fb_type'] = $fb_type;
            }
            if (isset($_REQUEST['type_ksgv'])) {
                $type_ksgv = strip_tags($_REQUEST['type_ksgv']);
                $params_ksgv['type_ksgv'] = $type_ksgv;
                $params['type_ksgv'] = $type_ksgv;
            }

            if (isset($_REQUEST['class'])) {
                $class_code = strip_tags($_REQUEST['class']);
                $params['class_code'] = $class_code;
            }

            if (isset($_REQUEST['teacher_name'])) {
                $teacher = strip_tags($_REQUEST['teacher_name']);
                $params['teacher_name'] = $teacher;
            }

            if (isset($_REQUEST['manager_email'])) {
                $params['manager_email'] = strip_tags($_REQUEST['manager_email']);
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
        $arrLocation = array();
        foreach ($location_info as $keyLoca => $location) {
            $arrLocation[$location['id']] = $location;
        }
        if(count($params) == 0) {
            $params['limit'] = 500;
        }
        $params = array_merge(array('fb_type' => 'phone'), $params);

        $filename = 'Feedback-Group-By-Class.xlsx';
        $this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel();
        $i = 1;
        $baseRow = 1;

        if($fb_type == 'phone') {
            $point_by_class = $list_fb = $this->fu->get_list_feedback_phone_export_by_class($params);
            $text_F = 'Lần';
        }else {
            $list_fb = $this->fu->get_feedback_ksgv($params);  // zfdev Viết lại phần filter trong model
            $text_F = 'Loại';
            $point_by_class = array();
            foreach ($list_fb as $keyfb => $fb){
                $data_fb = json_decode($fb['detail'], true);
                if($fb['type'] == 'ksgv2'){
                    if((int)$data_fb[6][3] > 0) {
                        $point_by_class[$fb['class_code']]['total_point'] = (int)$point_by_class[$fb['class_code']]['total_point']+(int)$data_fb[6][3];
                        $point_by_class[$fb['class_code']]['count_point'] = (int)$point_by_class[$fb['class_code']]['count_point']+1;
                    }
                }
                if ($fb['type'] == 'dao_tao_onl'){
                    if((int)$data_fb[9][3] > 0) {
                        $point_by_class[$fb['class_code']]['total_point'] = (int)$point_by_class[$fb['class_code']]['total_point']+(int)$data_fb[9][3];
                        $point_by_class[$fb['class_code']]['count_point'] = (int)$point_by_class[$fb['class_code']]['count_point']+1;
                    }
                }
                if ($fb['type'] == 'giua_ky_off'){
                    if((int)$data_fb[7][3] > 0) {
                        $point_by_class[$fb['class_code']]['total_point'] = (int)$point_by_class[$fb['class_code']]['total_point']+(int)$data_fb[7][3];
                        $point_by_class[$fb['class_code']]['count_point'] = (int)$point_by_class[$fb['class_code']]['count_point']+1;
                    }
                }
                $point_by_class[$fb['class_code']]['class_code'] = $fb['class_code'];
                $point_by_class[$fb['class_code']]['teacher_name'] = $fb['teacher_name'];
                $point_by_class[$fb['class_code']]['time_end'] = $fb['time_end'];
                $point_by_class[$fb['class_code']]['type'] = $fb['type'];
                $point_by_class[$fb['class_code']]['location'] = $fb['name'] .' - '.$fb['area'];
            }
        }

        foreach($point_by_class as $keyEX => $mono_feedback){
            $count = $baseRow + $i;
            if($i == 1){
                $objPHPExcel->getActiveSheet(0)
                    ->setCellValue('A' . $i, "STT")
                    ->setCellValue('B' . $i, "Loại khảo sát")
                    ->setCellValue('C' . $i, "Lớp")
                    ->setCellValue('D' . $i, "Giảng viên")
                    ->setCellValue('E' . $i, "Cơ sở")
                    ->setCellValue('F' . $i, "Ngày nhận KS")
                    ->setCellValue('G' . $i, $text_F)
                    ->setCellValue('H' . $i, "Điểm trung bình")
                    ->setCellValue('I' . $i, "Chi tiết");

            }
            $objPHPExcel->getActiveSheet()->insertNewRowBefore($count,1);
            if($fb_type == 'phone') {
                $objPHPExcel->getActiveSheet(0)
                    ->setCellValue('A' . $count, $keyEX + 1)
                    ->setCellValue('B' . $count, 'Phone')
                    ->setCellValue('C' . $count, $mono_feedback['class_code'])
                    ->setCellValue('D' . $count, $mono_feedback['teacher_name'])
                    ->setCellValue('E' . $count, $mono_feedback['name'] . ' - ' . $mono_feedback['area'])
                    ->setCellValue('F' . $count, date('d/m/Y', $mono_feedback['time']))
                    ->setCellValue('G' . $count, $mono_feedback['times'])
                    ->setCellValue('H' . $count, $mono_feedback['point'])
                    ->setCellValue('I' . $count, 'https://qlcl.imap.edu.vn/feedback/feedback_phone_detail?class='.$mono_feedback['class_code']);
            } else {
                switch ($mono_feedback['type']) {
                    case 'ksgv2':
                        $type = 'Cuối kỳ';
                        break;
                    case 'giua_ky_off':
                    case 'dao_tao_onl':
                        $type = 'Giữa kỳ';
                        break;
                    default:
                        $type = '';
                }
                $objPHPExcel->getActiveSheet(0)
                    ->setCellValue('A' . $count, $keyEX + 1)
                    ->setCellValue('B' . $count, $type)
                    ->setCellValue('C' . $count, $mono_feedback['class_code'])
                    ->setCellValue('D' . $count, $mono_feedback['teacher_name'])
                    ->setCellValue('E' . $count, $mono_feedback['location'])
                    ->setCellValue('F' . $count, date('d/m/Y', $mono_feedback['time_end']))
                    ->setCellValue('G' . $count, $mono_feedback['type'])
                    ->setCellValue('H' . $count, $mono_feedback['total_point']/$mono_feedback['count_point'])
                    ->setCellValue('I' . $count, 'https://qlcl.imap.edu.vn/feedback/feedback_ksgv_detail?class_code='.$mono_feedback['class_code'].'&type_ksgv='.$mono_feedback['type']);
            }
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

    function luyen_de(){
        guard();

        $del = false;
        if (($_SESSION['role'] == 'admin') || ($_SESSION['role'] == 'manager')) {
            $del = true;
        }

        $this->load->model('Feedback_model', 'feedback');
        $this->load->model('Feed_upgrade_model', 'fu');


        if (isset($_REQUEST['starttime'])) {
            $params['starttime'] = strtotime(strip_tags($_REQUEST['starttime']));
        }

        if (isset($_REQUEST['endtime'])) {
            $params['endtime'] = strtotime(strip_tags($_REQUEST['endtime']));
        }

        if (isset($_REQUEST['class'])) {
            $class_code = strip_tags($_REQUEST['class']);
            $params['class_code'] = $class_code;
        }else{
            echo 'Truy cập không hợp lệ'; exit;
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
        $level = '';
        if (isset($_REQUEST['level'])) {
            $level =  $_REQUEST['level'];
        }

        $info_class = $this->feedback->get_info_class_by_class_code($class_code);
        $info_luyende = $this->fu->get_log_luyende_class($class_code,$level,['limit'=> 200]);
        $location_info = $this->feedback-> get_info_location_by_id($info_class['id_location']);

        $level_text = [
            'nang_cao' => 'Nâng cao',
            'co_ban' => 'Cơ bản',
        ];
        $shift_text = [
            's_t7' => 'Sáng thứ 7',
            'c_t7' => 'Chiều thứ 7',
            's_cn' => 'Sáng CN',
        ];
        $data = array(
            'rows' => $info_luyende,
            'location_info' => $location_info,
            'info_class' => $info_class,
            'level_text' => $level_text,
            'shift_text' => $shift_text,
            'del' => $del,

        );
//        echo '<pre>'; print_r($data); exit;

        $this->load->layout('feedback/feedback_luyen_de_detail', $data, false, 'layout_feedback');

    }

    /**
     * Hàm export log đăng ký luyện đề theo area
     * @return .xlsx file
     * @throws PHPExcel_Exception
     * @throws PHPExcel_Reader_Exception
     * @throws PHPExcel_Writer_Exception
     */
    public function export_list_feedback_luyende_by_area(){
        guard();
        guard_admin_manager();

        $this->load->model('Feed_upgrade_model', 'fu');

        $params = [];

        if (isset($_REQUEST['area'])) {
            $area = $_REQUEST['area'];
            $params['area'] = $area;
        }

        $params['limit'] = 500;
        $list_fb_ld = $this->fu->get_log_luyende_filter_by_class($params);

        $filename = 'Feedback-LuyenDe.xlsx';
        $this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel();
        $i = 1;
        $baseRow = 1;

        foreach($list_fb_ld as $keyEX => $mono_feedback_ld){
            $count = $baseRow + $i;
            $classLink = '';
            $number_off = (int)$mono_feedback_ld['number_student']-((int)$mono_feedback_ld['number_student_coban']+(int)$mono_feedback_ld['number_student_nangcao']+(int)$mono_feedback_ld['number_student_giaotiep']);
            if($number_off <= 0) {
                $number_off = 0;
            }
            if(empty($_REQUEST['class'])){
                $classLink = '&class='.$mono_feedback_ld['class_code'];
            }
            if($i == 1){
                $objPHPExcel->getActiveSheet(0)
                    ->setCellValue('A'.$i, "STT")
                    ->setCellValue('B'.$i, "Cơ sở")
                    ->setCellValue('C'.$i, "Level")
                    ->setCellValue('D'.$i, "Lớp")
                    ->setCellValue('E'.$i, "Giáo viên")
                    ->setCellValue('F'.$i, "Ngày kết thúc")
                    ->setCellValue('G'.$i, "Sĩ số lớp")
                    ->setCellValue('H'.$i, "Số lượng HV đăng ký level cơ bản")
                    ->setCellValue('I'.$i, "Số lượng HV đăng ký level nâng cao ")
                    ->setCellValue('J'.$i, "Số lượng HV đăng ký lớp giao tiếp ")
                    ->setCellValue('K'.$i, "Số lượng HV chưa đăng ký")
                    ->setCellValue('L'.$i, "Danh sách đăng ký")
                    ->setCellValue('M'.$i, "Ti lệ HV đăng ký học");
            }
            $objPHPExcel->getActiveSheet()->insertNewRowBefore($count,1);

            $objPHPExcel->getActiveSheet(0)
                ->setCellValue('A'.$count, $keyEX+1 )
                ->setCellValue('B'.$count, $mono_feedback_ld['loca_name'])
                ->setCellValue('C'.$count, $mono_feedback_ld['level'])
                ->setCellValue('D'.$count, $mono_feedback_ld['class_code'])
                ->setCellValue('E'.$count, $mono_feedback_ld['teacher_name'])
                ->setCellValue('F'.$count, date('d/m/Y', $mono_feedback_ld['time_end_class']))
                ->setCellValue('G'.$count, $mono_feedback_ld['number_student'])
                ->setCellValue('H'.$count, $mono_feedback_ld['number_student_coban'])
                ->setCellValue('I'.$count, $mono_feedback_ld['number_student_nangcao'])
                ->setCellValue('J'.$count, $mono_feedback_ld['number_student_giaotiep'])
                ->setCellValue('K'.$count, $number_off)
                ->setCellValue('L'.$count, 'https://qlcl.imap.edu.vn/log/luyen_de?'.$classLink)
                ->setCellValue('M'.$count, ($number_off > 0 && (int)$mono_feedback_ld['number_student'] > 0) ? ((($mono_feedback_ld['number_student'] - $number_off) / (int)$mono_feedback_ld['number_student'])*100).'%' : 0);
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

    /**
     * Hàm export log đăng ký luyện đề theo area
     * @return .xlsx file
     * @throws PHPExcel_Exception
     * @throws PHPExcel_Reader_Exception
     * @throws PHPExcel_Writer_Exception
     */
    public function export_list_feedback_luyende_by_type(){
        guard();
        guard_admin_manager();
        $this->load->model('Feed_upgrade_model', 'fu');

        $shift_text = [
            's_t7' => 'Sáng thứ 7',
            'c_t7' => 'Chiều thứ 7',
            's_cn' => 'Sáng CN',
        ];
        $params = [];

        if (isset($_REQUEST['type'])) {
            $type = $_REQUEST['type'];
            $params['type'] = $type;
        }

        if (isset($_REQUEST['level'])) {
            $level = $_REQUEST['level'];
            $params['level'] = $level;
        }

        $params['limit'] = 1000;
        $list_fb_ld = $this->fu->get_log_luyende_filter($params);

        $filename = 'Feedback-LuyenDe.xlsx';
        $this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel();
        $i = 1;
        $baseRow = 1;

        foreach($list_fb_ld as $keyEX => $mono_feedback_ld){
            $count = $baseRow + $i;
            if($i == 1){
                $objPHPExcel->getActiveSheet(0)
                    ->setCellValue('A'.$i, "STT")
                    ->setCellValue('B'.$i, "Họ và tên")
                    ->setCellValue('C'.$i, "Số điện thoại")
                    ->setCellValue('D'.$i, "Email")
                    ->setCellValue('E'.$i, "Ngày sinh")
                    ->setCellValue('F'.$i, "Cơ sở")
                    ->setCellValue('G'.$i, "Lớp")
                    ->setCellValue('H'.$i, "Khung giờ học");
            }
            $objPHPExcel->getActiveSheet()->insertNewRowBefore($count,1);

            $objPHPExcel->getActiveSheet(0)
                ->setCellValue('A'.$count, $keyEX+1 )
                ->setCellValue('B'.$count, $mono_feedback_ld['hoten'])
                ->setCellValue('C'.$count, $mono_feedback_ld['phone'])
                ->setCellValue('D'.$count, $mono_feedback_ld['email'])
                ->setCellValue('E'.$count, '')
                ->setCellValue('F'.$count, $mono_feedback_ld['location'].' - '.$mono_feedback_ld['area'])
                ->setCellValue('G'.$count, $mono_feedback_ld['class_code'])
                ->setCellValue('H'.$count, $shift_text[$mono_feedback_ld['shift']]);
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

    /**
     * Lớp trang mới, hiển thị danh sách lớp và số lượng feedback, có action view tới list fb phone từng lớp
     * @input string type, default: phone
     * @input string class_code,
     * @input string teacher,
     * @input string loaction,
     * @input string area,
     * @output list class + total feedback phone
     */
    public function list_feedback_group_by_class()
    {
        guard();
        $this->load->model('Feedback_model', 'feedback');
        $this->load->model('Feed_upgrade_model', 'fu');

        $params = [];
        $params_ksgv = [];
        $params_phone = [];

        if(count($_REQUEST) > 0) {

            if (isset($_REQUEST['starttime'])) {
                $params['starttime'] = $params_phone['starttime'] = $params_ksgv['starttime'] = strtotime(strip_tags($_REQUEST['starttime']));
            }

            if (isset($_REQUEST['endtime'])) {
                $params['endtime'] = $params_phone['endtime'] = $params_ksgv['endtime'] = strtotime(strip_tags($_REQUEST['endtime']));
            }

            if (isset($_REQUEST['type'])) {  // type class : toeic, giaotiep, ielts, ...
                $type = strip_tags($_REQUEST['type']);
                $params['type'] = $type;
            }
            if (isset($_REQUEST['fb_type'])) { // type feedback: phone, ksgv, ....
                $fb_type = strip_tags($_REQUEST['fb_type']);
                $params['fb_type'] = $fb_type;
            }
            if (isset($_REQUEST['type_ksgv'])) { // type ksgv: ksgv1, ksgv2, dao_tao_onl,...
                $type_ksgv = strip_tags($_REQUEST['type_ksgv']);
                $params_ksgv['type_ksgv'] = $type_ksgv;
                $params['type_ksgv'] = $type_ksgv;
            }

            if (isset($_REQUEST['class'])) {
                $class_code = strip_tags($_REQUEST['class']);
                $params['class_code'] = $class_code;
            }

            if (isset($_REQUEST['teacher_name'])) {
                $teacher = strip_tags($_REQUEST['teacher_name']);
                $params['teacher_name'] = $teacher;
            }

            if (isset($_REQUEST['manager_email'])) {
                $params['manager_email'] = strip_tags($_REQUEST['manager_email']);
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
        $arrLocation = array();
        foreach ($location_info as $keyLoca => $location) {
            $arrLocation[$location['id']] = $location;
        }
        $params['limit'] = 500;
        $params = array_merge(array('fb_type' => 'phone'), $params);
        $list_class = $this->feedback->get_list_class_filter($params);
        $list_class_ids = array();
        if(count($list_class) > 0) {
            foreach ($list_class as $keyClass => $class) {
                $list_class_ids[] = $class['class_id'];
            }
        }
        if($fb_type == 'phone') {
            $params_phone = array_merge(array('class_id' => $list_class_ids), $params_phone);
            $list_total = $this->fu->get_total_fb_phone_by_class($params_phone);
        }else {
            $params_ksgv = array_merge(array('class_id' => $list_class_ids), $params_ksgv);
            $params_ksgv = array_merge(array('type_ksgv' => $fb_type), $params_ksgv);
            $list_total = $this->fu->get_total_fb_ksgv_by_class($params_ksgv);
        }

        $arrTotalFB = array();
        foreach ($list_total as $keyTotal => $total) {
            $arrTotalFB[$total['class_id']] = $total;
        }
        $list_teacher = $this->feedback->get_list_info_teacher();
        foreach ($list_teacher as $key => $teacher) {
            $arrTeacher[$teacher['teacher_id']] = $teacher;
        }

        $list_manager = $this->fu->get_teacher_manager();
        $data_manager = array();
        foreach ($list_manager as $manager){
            if($manager['manager_email']){
                $data_manager[] = $manager['manager_email'];
            }
        }

        $data = array(
            'rows' => $list_class,
            'arrLocation' => $arrLocation,
            'location_info' => $location_info,
            'arr_teacher' => $arrTeacher,
            'arr_total' => $arrTotalFB,
            'fb_type' => $fb_type,
            'list_manager' => $data_manager,
            'type_ksgv' => ($params_ksgv['type_ksgv'])?$params_ksgv['type_ksgv']:'',
        );
        if (($_SESSION['role'] == 'admin') || ($_SESSION['role'] == 'manager')) {
            $this->load->layout('feedback/list_feedback_group_by_class', $data, false, 'layout_feedback');
        } else {
            $this->load->layout('feedback/list_feedback_group_by_class', $data, false, 'layout_feedback_tuvan');
        }
    }

    /**
     * Hàm export log đăng ký thi cuôi kỳ theo area
     * @return .xlsx file
     * @throws PHPExcel_Exception
     * @throws PHPExcel_Reader_Exception
     * @throws PHPExcel_Writer_Exception
     */
    public function export_list_thicuoiky_by_area(){
        guard();
        guard_admin_manager();

        $this->load->model('Feed_upgrade_model', 'fu');

        $params = [];

        if (isset($_REQUEST['area'])) {
            $area = $_REQUEST['area'];
            $params['area'] = $area;
        }

        $list_fb_ld = $this->fu->get_log_thicuoiky_filter_by_class($params);

        $filename = 'Feedback-ThiCuoiKy.xlsx';
        $this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel();
        $i = 1;
        $baseRow = 1;

        foreach($list_fb_ld as $keyEX => $mono_feedback_ld){
            $count = $baseRow + $i;
            $classLink = '';
            $number_off = (int)$mono_feedback_ld['number_student']-(int)$mono_feedback_ld['number_thicuoiky'];
            if($number_off <= 0) {
                $number_off = 0;
            }
            if(empty($_REQUEST['class'])){
                $classLink = '&class='.$mono_feedback_ld['class_code'];
            }
            if($i == 1){
                $objPHPExcel->getActiveSheet(0)
                    ->setCellValue('A'.$i, "STT")
                    ->setCellValue('B'.$i, "Cơ sở")
                    ->setCellValue('C'.$i, "Lớp")
                    ->setCellValue('D'.$i, "Giáo viên")
                    ->setCellValue('E'.$i, "Ngày kết thúc")
                    ->setCellValue('F'.$i, "Sĩ số lớp")
                    ->setCellValue('G'.$i, "Số lượng HV đăng ký")
                    ->setCellValue('H'.$i, "Số lượng HV chưa đăng ký")
                    ->setCellValue('I'.$i, "Danh sách đăng ký")
                    ->setCellValue('J'.$i, "Ti lệ HV đăng ký học");
            }
            $objPHPExcel->getActiveSheet()->insertNewRowBefore($count,1);

            $objPHPExcel->getActiveSheet(0)
                ->setCellValue('A'.$count, $keyEX+1 )
                ->setCellValue('B'.$count, $mono_feedback_ld['loca_name'])
                ->setCellValue('C'.$count, $mono_feedback_ld['class_code'])
                ->setCellValue('D'.$count, $mono_feedback_ld['teacher_name'])
                ->setCellValue('E'.$count, date('d/m/Y', $mono_feedback_ld['time_end_class']))
                ->setCellValue('F'.$count, $mono_feedback_ld['number_student'])
                ->setCellValue('G'.$count, $mono_feedback_ld['number_thicuoiky'])
                ->setCellValue('H'.$count, $number_off)
                ->setCellValue('I'.$count, 'https://qlcl.imap.edu.vn/log/thi_cuoi_ky?'.$classLink)
                ->setCellValue('J'.$count, ($number_off > 0 && (int)$mono_feedback_ld['number_student'] > 0) ? ((($mono_feedback_ld['number_student'] - $number_off) / (int)$mono_feedback_ld['number_student'])*100).'%' : 0);
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

    /**
     * Hàm export log đăng ký thi cuối kỳ by type // toeic, giaotiep, ielts, ...
     * @return .xlsx file
     * @throws PHPExcel_Exception
     * @throws PHPExcel_Reader_Exception
     * @throws PHPExcel_Writer_Exception
     */
    public function export_list_thicuoiky_by_type(){
        guard();
        guard_admin_manager();
        $this->load->model('Feed_upgrade_model', 'fu');

        $shift_text = [
            's_04' => '09:00 Thứ 5, ngày 04/06/2020',
            's_06' => '09:00 Thứ 7, ngày 06/06/2020',
            'c_06' => '14:00 Thứ 7, ngày 06/06/2020',
            'c_09' => '14:00 Thứ 3, ngày 09/06/2020',
            's_11' => '09:00 Thứ 5, ngày 11/06/2020',
            's_13' => '09:00 Thứ 7, ngày 13/06/2020',
            'c_13' => '14:00 Thứ 7, ngày 13/06/2020',
        ];
        $params = [];

        if (isset($_REQUEST['type'])) {
            $type = $_REQUEST['type'];
            $params['type'] = $type;
        }

        if (isset($_REQUEST['class'])) {
            $class_code = strip_tags($_REQUEST['class']);
            $params['class_code'] = $class_code;
        }

        $list_fb_ld = $this->fu->get_log_thicuoiky_filter($params);

        $filename = 'Feedback-ThiCuoiKy.xlsx';
        $this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel();
        $i = 1;
        $baseRow = 1;

        foreach($list_fb_ld as $keyEX => $mono_feedback_ld){
            $count = $baseRow + $i;
            if($i == 1){
                $objPHPExcel->getActiveSheet(0)
                    ->setCellValue('A'.$i, "STT")
                    ->setCellValue('B'.$i, "Họ và tên")
                    ->setCellValue('C'.$i, "Số điện thoại")
                    ->setCellValue('D'.$i, "Email")
                    ->setCellValue('E'.$i, "Cơ sở")
                    ->setCellValue('F'.$i, "Lớp")
                    ->setCellValue('G'.$i, "Lịch thi");
            }
            $objPHPExcel->getActiveSheet()->insertNewRowBefore($count,1);

            $objPHPExcel->getActiveSheet(0)
                ->setCellValue('A'.$count, $keyEX+1 )
                ->setCellValue('B'.$count, $mono_feedback_ld['hoten'])
                ->setCellValue('C'.$count, $mono_feedback_ld['phone'])
                ->setCellValue('D'.$count, $mono_feedback_ld['email'])
                ->setCellValue('E'.$count, $mono_feedback_ld['location'].' - '.$mono_feedback_ld['area'])
                ->setCellValue('F'.$count, $mono_feedback_ld['class_code'])
                ->setCellValue('G'.$count, $shift_text[$mono_feedback_ld['shift']]);
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

    function thi_cuoi_ky(){
        guard();
        $this->load->model('Feed_upgrade_model', 'fu');
        $shift_text = [
            's_04' => '09:00 Thứ 5, ngày 04/06/2020',
            's_06' => '09:00 Thứ 7, ngày 06/06/2020',
            'c_06' => '14:00 Thứ 7, ngày 06/06/2020',
            'c_09' => '14:00 Thứ 3, ngày 09/06/2020',
            's_11' => '09:00 Thứ 5, ngày 11/06/2020',
            's_13' => '09:00 Thứ 7, ngày 13/06/2020',
            'c_13' => '14:00 Thứ 7, ngày 13/06/2020',
        ];
        $params = [];
        if (isset($_REQUEST['class'])) {
            if (isset($_REQUEST['class'])) {
                $class_code = strip_tags($_REQUEST['class']);
                $params['class_code'] = $class_code;
            }else{
                echo 'Truy cập không hợp lệ'; exit;
            }
        }

        $list_fb_ld = $this->fu->get_log_thicuoiky_filter($params);

        $data = array(
            'rows' => $list_fb_ld,
            'shift_text' => $shift_text,
        );

        $this->load->layout('feedback/thicuoiky_detail', $data, false, 'layout_feedback');

    }

}
