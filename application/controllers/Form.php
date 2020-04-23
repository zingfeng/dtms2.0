<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form extends CI_Controller
{

    public function giaotiep()
    {
        $this->load->model('Feedback_model', 'feedback');

        $location_info = $this->feedback->get_list_location();
        $arr_location_info = array();
        foreach ($location_info as $mono_location) {
            $arr_location_info[$mono_location['id']] = $mono_location['name'] . ' - Khu vực ' . $mono_location['area'];
        }


        $info_class = array();
        $list_info_class = array();
        if (isset($_GET['my_class'])) {
            $class_code = mb_strtolower($_GET['my_class']);
            if ($this->feedback->check_class_code_exist($class_code, 'giaotiep')) {
                $info_class = $this->feedback->get_info_class_by_class_code($class_code);
            }
        } else {
            $list_info_class = $this->feedback->get_list_class_code_opening('giaotiep');
        }

        $list_quest_ruler = array(
            'Về Giảng viên' => array(
                'Trình độ chuyên môn',
                'Phương pháp giảng dạy',
                'Mức độ quan tâm học viên',
                'Mức độ truyền cảm hứng',
                'Mức độ tăng khả năng giao tiếp',
            ),

            'Về Giáo trình và Slides' => array(
                'Bố cục trình bày',
                'Mức độ kiến thức',
            ),
            'Đội ngũ trợ giảng' => array(
                'Mức độ đánh giá buổi offline',
                'Thái độ chăm sóc học viên',
                'Trình độ chuyên môn',
            ),
            'Đội ngũ tư vấn' => array(
                'Tư vấn đầy đủ lộ trình, nội dung, quy định của khóa học',
                'Tư vấn về các chương trình khuyến mãi, hoạt động ngoại khóa (nếu có), phát đầy đủ tài liệu',
                'Thái độ chăm sóc học viên, hỗ trợ học viên qua Group Facebook',
                'Thông báo lịch học, lịch thi, lịch nghỉ học, xếp lịch học bù kịp thời',
            ),
            'Cơ sở vật chất' => array(
                'Chất lượng về cơ sở vật chất',
            ),
        );


        $list_quest_select = array(
            'Giáo viên',
            'Tư vấn',
            'Slides và giáo trình',
        );

        $list_quest_text = array(
            'Đóng góp ý kiến cụ thể để nâng cao chất lượng đào tạo và dịch vụ tại Ms Hoa Giao Tiếp',
        );

        $list_quest_radio = array(
            'Bạn có muốn tiếp tục học tại Ms Hoa Giao Tiếp ở Level cao hơn không?',
        );

        $time_start = time();

        $token_feedback = $this->config->item('token_feedback');
        $token = md5($token_feedback . $time_start);


        $data = array(
            'type_class' => 'giaotiep',
            'time_start' => $time_start,
            'token' => $token,
            'info_class' => $info_class,
            'list_info_class' => $list_info_class,
            'list_quest_ruler' => $list_quest_ruler,
            'list_quest_select' => $list_quest_select,
            'list_quest_text' => $list_quest_text,
            'list_quest_radio' => $list_quest_radio,
        );

        $this->load->view('feedback/feedback_giaotiep', $data, false);
    }

    public function ielts()
    {
        $this->load->model('Feedback_model', 'feedback');
        $location_info = $this->feedback->get_list_location();
        $arr_location_info = array();
        foreach ($location_info as $mono_location) {
            $arr_location_info[$mono_location['id']] = $mono_location['name'] . ' - Khu vực ' . $mono_location['area'];
        }

        $info_class = array();
        $list_info_class = array();
        if (isset($_GET['my_class'])) {
            $class_code = mb_strtolower($_GET['my_class']);
            if ($this->feedback->check_class_code_exist($class_code, 'ielts')) {
                $info_class = $this->feedback->get_info_class_by_class_code($class_code);
            }
        } else {
            $list_info_class = $this->feedback->get_list_class_code_opening('ielts');
        }

        $list_quest_ruler = array(
            'Về Giảng viên' => array(
                'Trình độ chuyên môn',
                'Phương pháp giảng dạy',
                'Mức độ quan tâm học viên',
                'Mức độ truyền cảm hứng',
                'Mức độ tăng khả năng giao tiếp',
            ),

            'Về Giáo trình và Slides' => array(
                'Bố cục trình bày',
                'Mức độ kiến thức',
            ),

            'Đội ngũ tư vấn' => array(
                'Tư vấn đầy đủ lộ trình, nội dung, quy định của khóa học',
                'Tư vấn về các chương trình khuyến mãi, hoạt động ngoại khóa (nếu có), phát đầy đủ tài liệu',
                'Thái độ chăm sóc học viên, hỗ trợ học viên qua Group Facebook',
                'Thông báo lịch học, lịch thi, lịch nghỉ học, xếp lịch học bù kịp thời',
            ),
            'Cơ sở vật chất' => array(
                'Chất lượng về cơ sở vật chất',
            ),
        );

        $list_quest_select = array(
            'Giáo viên',
            'Tư vấn',
        );

        $list_quest_text = array(
            'Đóng góp ý kiến cụ thể để nâng cao chất lượng đào tạo và dịch vụ tại IELTS Fighter',
        );

        $list_quest_radio = array(
            'Bạn có muốn tiếp tục học tại IELTS Fighter ở Level cao hơn không?',
        );

        $time_start = time();

        $token_feedback = $this->config->item('token_feedback');
        $token = md5($token_feedback . $time_start);


        $data = array(
            'type_class' => 'ielts',
            'time_start' => $time_start,
            'token' => $token,
            'info_class' => $info_class,
            'list_info_class' => $list_info_class,
            'list_quest_ruler' => $list_quest_ruler,
            'list_quest_select' => $list_quest_select,
            'list_quest_text' => $list_quest_text,
            'list_quest_radio' => $list_quest_radio,
            'arr_location_info' => $arr_location_info,
        );

        $this->load->view('feedback/feedback_ielts', $data, false);
    }

    public function toeic()
    {
        $this->load->model('Feedback_model', 'feedback');

        $location_info = $this->feedback->get_list_location();
        $arr_location_info = array();
        foreach ($location_info as $mono_location) {
            $arr_location_info[$mono_location['id']] = $mono_location['name'] . ' - Khu vực ' . $mono_location['area'];
        }

        $info_class = array();
        $list_info_class = array();
        if (isset($_GET['my_class'])) {
            $class_code = mb_strtolower($_GET['my_class']);
            if ($this->feedback->check_class_code_exist($class_code, 'toeic')) {
                $info_class = $this->feedback->get_info_class_by_class_code($class_code);
            }
        } else {
            $list_info_class = $this->feedback->get_list_class_code_opening('toeic');
        }

        $list_quest_ruler = array(
            'Về Giảng viên' => array(
                'Trình độ chuyên môn',
                'Phương pháp giảng dạy',
                'Mức độ quan tâm học viên',
                'Mức độ truyền cảm hứng',
                'Mức độ tăng kỹ năng làm bài',
            ),

            'Về nội dung Giáo trình và Slides' => array(
                'Tính chính xác, khoa học về nội dung kiến thức, chính tả, từ ngữ…',
                'Ngắn gọn nhưng đầy đủ nội dung và làm nổi bật được trọng tâm của bài học',
                'Kiến thức được tổ chức có hệ thống và thể hiện được tính kết nối',
            ),
            'Về hình thức Giáo trình và Slides' => array(
                'Giao diện đảm bảo chuyên nghiệp, hệ thống và tính nhất quán. Phông nền hài hòa với chữ, màu sắc và nội dung',
                'Chữ và các công thức/mẫu câu được thiết kế thống nhất, cân đối; các phương tiện trực quan (phim, mô phỏng, hình ảnh) có chất lượng tốt, đẹp mắt, hài hòa',
                'Có sự phối hợp hài hòa, khoa học màu sắc trong toàn bộ bài giảng.',
                'Hệ thống hiệu ứng phù hợp (Các hiệu ứng hình ảnh, màu sắc, âm thanh, chuyển động được sử dụng hợp lí)',
            ),

            'Tương tác giữa Giáo viên và Slides' => array(
                'Giải thích, giảng giải đầy đủ các đầu mục kiến thức trong slides; phân bổ thời gian hợp lí cho từng phần, từng khâu',
                'Phối hợp nhịp nhàng giữa slides và ghi bảng, với hoạt động tương tác giữa học viên và giáo viên',
                'Nhịp độ trình chiếu và triển khai bài dạy vừa phải, phù hợp với việc ghi chép và sự tiếp thu của học viên',
            ),
            'Đội ngũ tư vấn' => array(
                'Tư vấn đầy đủ lộ trình, nội dung, quy định của khóa học',
                'Tư vấn về các chương trình khuyến mãi, hoạt động ngoại khóa (nếu có), phát đầy đủ tài liệu',
                'Thái độ chăm sóc học viên, hỗ trợ học viên qua Group Facebook',
                'Thông báo lịch học, lịch thi, lịch nghỉ học, xếp lịch học bù kịp thời',
            ),
            'Cơ sở vật chất' => array(
                'Chất lượng về cơ sở vật chất',
            ),
        );


        $list_quest_select = array(
            'Giáo viên',
            'Tư vấn',
            'Slides và giáo trình',
        );

        $list_quest_text = array(
            'Đóng góp ý kiến cụ thể để nâng cao chất lượng đào tạo và dịch vụ tại Ms Hoa TOEIC',
        );

        $list_quest_radio = array(
            'Bạn có muốn tiếp tục học tại Ms Hoa TOEIC ở Level cao hơn không?',
        );

        $time_start = time();

        $token_feedback = $this->config->item('token_feedback');
        $token = md5($token_feedback . $time_start);


        $data = array(
            'type_class' => 'toeic',
            'time_start' => $time_start,
            'token' => $token,
            'info_class' => $info_class,
            'list_info_class' => $list_info_class,
            'list_quest_ruler' => $list_quest_ruler,
            'list_quest_select' => $list_quest_select,
            'list_quest_text' => $list_quest_text,
            'list_quest_radio' => $list_quest_radio,
            'arr_location_info' => $arr_location_info,
        );

        $this->load->view('feedback/feedback_toeic', $data, false);

    }

    public function aland()
    {
        $this->load->model('Feedback_model', 'feedback');
        $location_info = $this->feedback->get_list_location();
        $arr_location_info = array();
        foreach ($location_info as $mono_location) {
            $arr_location_info[$mono_location['id']] = $mono_location['name'] . ' - Khu vực ' . $mono_location['area'];
        }

        $info_class = array();
        $list_info_class = array();
        if (isset($_GET['my_class'])) {
            $class_code = mb_strtolower($_GET['my_class']);
            if ($this->feedback->check_class_code_exist($class_code, 'ielts')) {
                $info_class = $this->feedback->get_info_class_by_class_code($class_code);
            }
        } else {
            $list_info_class = $this->feedback->get_list_class_code_opening('ielts');
        }

        $list_quest_ruler = array(
            'Về Giảng viên' => array(
                'Trình độ chuyên môn',
                'Phương pháp giảng dạy',
                'Mức độ quan tâm học viên',
                'Mức độ truyền cảm hứng',
                'Mức độ tăng khả năng giao tiếp',
            ),

            'Về Giáo trình và Slides' => array(
                'Bố cục trình bày',
                'Mức độ kiến thức',
            ),

            'Đội ngũ tư vấn' => array(
                'Tư vấn đầy đủ lộ trình, nội dung, quy định của khóa học',
                'Tư vấn về các chương trình khuyến mãi, hoạt động ngoại khóa (nếu có), phát đầy đủ tài liệu',
                'Thái độ chăm sóc học viên, hỗ trợ học viên qua Group Facebook',
                'Thông báo lịch học, lịch thi, lịch nghỉ học, xếp lịch học bù kịp thời',
            ),
            'Cơ sở vật chất' => array(
                'Chất lượng về cơ sở vật chất',
            ),
        );


        $list_quest_select = array(
            'Giáo viên',
            'Tư vấn',
        );

        $list_quest_text = array(
            'Đóng góp ý kiến cụ thể để nâng cao chất lượng đào tạo và dịch vụ tại Aland',
        );

        $list_quest_radio = array(
            'Bạn có muốn tiếp tục học tại Aland ở Level cao hơn không?',
        );

        $time_start = time();

        $token_feedback = $this->config->item('token_feedback');
        $token = md5($token_feedback . $time_start);


        $data = array(
            'type_class' => 'ielts',
            'time_start' => $time_start,
            'token' => $token,
            'info_class' => $info_class,
            'list_info_class' => $list_info_class,
            'list_quest_ruler' => $list_quest_ruler,
            'list_quest_select' => $list_quest_select,
            'list_quest_text' => $list_quest_text,
            'list_quest_radio' => $list_quest_radio,
            'arr_location_info' => $arr_location_info,
        );

        $this->load->view('feedback/feedback_aland', $data, false);
    }

    public function slide()
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $this->load->model('Feedback_model', 'feedback');
        $location_info = $this->feedback->get_list_location();
        $arr_location_info = array();
        foreach ($location_info as $mono_location) {
            $arr_location_info[$mono_location['id']] = $mono_location['name'] . ' - Khu vực ' . $mono_location['area'];
        }

        $info_class = array();
        $list_info_class = array();
        if (isset($_GET['my_class'])) {
            $class_code = mb_strtolower($_GET['my_class']);
            if ($this->feedback->check_class_code_exist($class_code, '')) {
                $info_class = $this->feedback->get_info_class_by_class_code($class_code);
            }
        } else {
            $list_info_class = $this->feedback->get_list_class_code_opening('');
        }

        $list_quest_select = array(
            'Về Giảng viên' => array(
                'TỐC ĐỘ giảng dạy có phù hợp không?', // 1
                'Giảng viên có TƯƠNG TÁC nhiều với cá nhân, tập thể không?', //2
                'Giảng viên có TỰ TIN khi giảng dạy bằng slide hay không?', // 3
                'Giảng viên có MỞ RỘNG thêm kiến thức TRÊN BẢNG không?', // 4
                'Giảng viên có hướng dẫn cách viết STUDENT BOOK không?', // 5
                'Giảng viên có CUNG CẤP LƯỢNG TỪ VỰNG (glossary) mỗi buổi học hay không?', // 6
                'Giảng viên có CHUẨN BỊ KỸ BÀI và NẮM RÕ SLIDE không?', // 7
                'Giảng viên có GIAO BÀI TẬP về nhà và KIỂM TRA đầy đủ hay không?', // 8
                'Giảng viên có DI CHUYỂN LINH HOẠT trong lớp học (giữa máy tính/bảng và về phía học viên) không?',
                'Bạn sẽ đánh giá giáo viên của mình bao nhiêu điểm trên thang điểm 10',
            ),
        );


        $list_quest_ruler = array(

        );

        $list_quest_text = array(
            'Đóng góp khác cho giáo viên',
        );
//
//        $list_quest_radio = array(
//            'Bạn có muốn tiếp tục học tại IELTS Fighter ở Level cao hơn không?',
//        );

        $list_quest_radio_LEVELS = array(
            array(
                'id_quest' => 500,
                'question' => array('Bạn cảm thấy thích học bằng bảng thông thường hay Slide ?',' style="" '),
                'levels' => array(
                    // value => text
                    0 => 'Slide',
                    1 => 'Bảng',
                    2 => 'Slide kết hợp bảng',
                ),
            ),

        );


        $time_start = time();

        $token_feedback = $this->config->item('token_feedback');
        $token = md5($token_feedback . $time_start);


        $data = array(
            'type_class' => 'slide',
            'time_start' => $time_start,
            'token' => $token,
            'info_class' => $info_class,
            'list_info_class' => $list_info_class,
            'list_quest_ruler' => $list_quest_ruler,
            'list_quest_select' => $list_quest_select,
            'list_quest_text' => $list_quest_text,
            'list_quest_radio_LEVELS' => $list_quest_radio_LEVELS,
            'arr_location_info' => $arr_location_info,
        );

        $this->load->view('feedback/feedback_slide', $data, false);
    }

    public function ksgv_lan1()
    {

        $this->load->model('Feedback_model', 'feedback');
        $location_info = $this->feedback->get_list_location();
        $arr_location_info = array();
        foreach ($location_info as $mono_location) {
            $arr_location_info[$mono_location['id']] = $mono_location['name'] . ' - Khu vực ' . $mono_location['area'];
        }

        $info_class = array();
        $list_info_class = array();
        if (isset($_GET['my_class'])) {
            $class_code = mb_strtolower($_GET['my_class']);
            if ($this->feedback->check_class_code_exist($class_code, '')) {
                $info_class = $this->feedback->get_info_class_by_class_code($class_code);
            }
        } else {
            $list_info_class = $this->feedback->get_list_class_code_opening('');
        }

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


        $list_quest_ruler = array(

        );

        $list_quest_text = array(
//            'Đóng góp khác cho giáo viên',
        );
//
//        $list_quest_radio = array(
//            'Bạn có muốn tiếp tục học tại IELTS Fighter ở Level cao hơn không?',
//        );

        $list_quest_radio_LEVELS = array(
//            array(
//                'id_quest' => 500,
//                'question' => array('Bạn cảm thấy thích học bằng bảng thông thường hay Slide ?',' style="" '),
//                'levels' => array(
//                    // value => text
//                    0 => 'Slide',
//                    1 => 'Bảng',
//                    2 => 'Slide kết hợp bảng',
//                ),
//            ),

        );


        $time_start = time();

        $token_feedback = $this->config->item('token_feedback');
        $token = md5($token_feedback . $time_start);

        // ===========
        $list_teacher = $info_class['list_teacher'];
        $name_teacher = '';
        try {
            $list_teacher_live = json_decode($list_teacher,true);
            if (isset($list_teacher_live[0])){
                $teacher_id = $list_teacher_live[0];
                $info_teacher = $this->feedback-> get_info_teacher($teacher_id);
                $name_teacher = $info_teacher['name'];
            }else{
                $name_teacher = '';
            }

        } catch (Exception $e) {
//            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        $info_class['name_teacher'] = $name_teacher;
        // =============

        $data = array(
            'type_class' => 'ksgv1',
            'time_start' => $time_start,
            'token' => $token,
            'info_class' => $info_class,
            'list_info_class' => $list_info_class,
            'list_quest_ruler' => $list_quest_ruler,
            'list_quest_select' => $list_quest_select,
            'list_quest_text' => $list_quest_text,
            'list_quest_radio_LEVELS' => $list_quest_radio_LEVELS,
            'arr_location_info' => $arr_location_info,
        );
//        echo '<pre>';
//        print_r($data);
//        echo '</pre>'; exit;

        $this->load->view('feedback/feedback_ksgv1', $data, false);
    }

    public function ksgv_lan2()
    {

        $this->load->model('Feedback_model', 'feedback');
        $location_info = $this->feedback->get_list_location();
        $arr_location_info = array();
        foreach ($location_info as $mono_location) {
            $arr_location_info[$mono_location['id']] = $mono_location['name'] . ' - Khu vực ' . $mono_location['area'];
        }

        $info_class = array();
        $list_info_class = array();
        if (isset($_GET['my_class'])) {
            $class_code = mb_strtolower($_GET['my_class']);
            if ($this->feedback->check_class_code_exist($class_code, '')) {
                $info_class = $this->feedback->get_info_class_by_class_code($class_code);
            }
        } else {
            $list_info_class = $this->feedback->get_list_class_code_opening('');
        }

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
        $list_quest_ruler = array(

        );



//        $list_quest_radio = array(
//            'Bạn có muốn tiếp tục học tại IELTS Fighter ở Level cao hơn không?',
//        );

        $list_quest_radio_LEVELS = array(
//            array(
//                'id_quest' => 500,
//                'question' => array('Bạn cảm thấy thích học bằng bảng thông thường hay Slide ?',' style="" '),
//                'levels' => array(
//                    // value => text
//                    0 => 'Slide',
//                    1 => 'Bảng',
//                    2 => 'Slide kết hợp bảng',
//                ),
//            ),

        );


        $time_start = time();

        $token_feedback = $this->config->item('token_feedback');
        $token = md5($token_feedback . $time_start);

        // ===========
        $list_teacher = $info_class['list_teacher'];
        $name_teacher = '';
        try {
            $list_teacher_live = json_decode($list_teacher,true);
            if (isset($list_teacher_live[0])){
                $teacher_id = $list_teacher_live[0];
                $info_teacher = $this->feedback-> get_info_teacher($teacher_id);
                $name_teacher = $info_teacher['name'];
            }else{
                $name_teacher = '';
            }

        } catch (Exception $e) {
//            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        $info_class['name_teacher'] = $name_teacher;
        // =============

        $data = array(
            'type_class' => 'ksgv2',
            'time_start' => $time_start,
            'token' => $token,
            'info_class' => $info_class,
            'list_info_class' => $list_info_class,
            'list_quest_ruler' => $list_quest_ruler,
            'list_quest_select' => $list_quest_select,
            'list_quest_text' => $list_quest_text,
            'list_quest_radio_LEVELS' => $list_quest_radio_LEVELS,
            'arr_location_info' => $arr_location_info,
        );

        $this->load->view('feedback/feedback_ksgv2', $data, false);
    }

    public function hom_thu_gop_y()
    {

        $this->load->model('Feedback_model', 'feedback');
        $location_info = $this->feedback->get_list_location();
        $arr_location_info = array();
        foreach ($location_info as $mono_location) {
            $arr_location_info[$mono_location['id']] = $mono_location['name'] . ' - Khu vực ' . $mono_location['area'];
        }

        $info_class = array();
        $list_info_class = array();
        $class_code = '';
        if (isset($_GET['my_class'])) {
            $class_code = mb_strtolower($_GET['my_class']);
            if ($this->feedback->check_class_code_exist($class_code, '')) {
                $info_class = $this->feedback->get_info_class_by_class_code($class_code);
            }
        }
        $list_quest_text = array(
            'Ý kiến đóng góp'
        );


        $list_quest_radio_LEVELS = array(
        );


        $time_start = time();

        $token_feedback = $this->config->item('token_feedback');
        $token = md5($token_feedback . $time_start);


        $data = array(
            'type_class' => 'homthugopy',
            'class_code' => $class_code,
            'time_start' => $time_start,
            'token' => $token,
            'info_class' => $info_class,
            'list_info_class' => $list_info_class,
            'list_quest_text' => $list_quest_text,
            'list_quest_radio_LEVELS' => $list_quest_radio_LEVELS,
            'arr_location_info' => $arr_location_info,
        );

        $this->load->view('feedback/feedback_hom_thu_gop_y', $data, false);
    }

    public function zoom()
    {
        $this->load->model('Feedback_model', 'feedback');

        $info_class = array();
        $list_info_class = array();
        if  (isset($_GET['my_class']) && (isset($_GET['my_time'])) && (isset($_GET['my_token'])) ) {
            $class_code = mb_strtolower($_GET['my_class']);
            if ($this->feedback->check_class_code_exist($class_code, '')) {
                $info_class = $this->feedback->get_info_class_by_class_code($class_code);
            }
            $my_time = $_GET['my_time'];
            $my_token = $_GET['my_token'];
            if ($this->checkTokenZoom($my_time,$my_token)){
                $myday = date('d/m/Y',$my_time);
                $nowday = date('d/m/Y',time());
                if ($myday != $nowday){
                    echo 'Link feedback đã hết hạn !';
                    exit;
                }

            }else{
                echo 'Truy cập không hợp lệ, URL không đúng.';
                exit;
            }
        } else{
            echo 'Truy cập không hợp lệ, URL không đúng.';
            exit;
        }

        $list_quest_select = array(
            'Bạn cho giáo viên trong giờ học hôm nay bao nhiêu điểm ?',
        );

        $list_quest_ruler = array(
            'Về giờ học' => array(
                'Bạn có hài lòng với giờ học này không ?'
            ),
        );

        $list_quest_text = array(
        );

        $list_quest_radio_LEVELS = array(
        );

        $time_start = time();

        $token_feedback = $this->config->item('token_feedback');
        $token = md5($token_feedback . $time_start);

        $data = array(
            'type_class' => 'zoom',
            'time_start' => $time_start,
            'myday' => $myday,
            'token' => $token,
            'info_class' => $info_class,
            'list_info_class' => $list_info_class,
            'list_quest_ruler' => $list_quest_ruler,
            'list_quest_select' => $list_quest_select,
            'list_quest_text' => $list_quest_text,
            'list_quest_radio_LEVELS' => $list_quest_radio_LEVELS,
        );

        $this->load->view('feedback/feedback_zoom', $data, false);
    }

    private function checkTokenZoom($my_time,$my_token){
        $key = 'fb_zoom_!@#';
        $hash = hash('ripemd160', ($my_time.$key));
        return ($hash == $my_token);
    }

    public function dao_tao_online()
    {
        $this->load->model('Feedback_model', 'feedback');

        $location_info = $this->feedback->get_list_location();
        $arr_location_info = array();
        foreach ($location_info as $mono_location) {
            $arr_location_info[$mono_location['id']] = $mono_location['name'] . ' - Khu vực ' . $mono_location['area'];
        }

        $info_class = array();
        $list_info_class = array();
        if (isset($_GET['my_class'])) {
            $class_code = mb_strtolower($_GET['my_class']);
            $info_class = $this->feedback->get_info_class_by_class_code($class_code);
        } else {
            $list_info_class = $this->feedback->get_list_class_code_opening('toeic');
        }

        $list_quest_ruler = array(
            'Về Giảng viên' => array(
                'TỐC ĐỘ giảng dạy có phù hợp không?',
                'Giảng viên có TƯƠNG TÁC nhiều với cá nhân không?',
                'Giảng viên có MỞ RỘNG thêm kiến thức không?',
                'Giảng viên có hướng dẫn cách viết STUDENT BOOK không?',
                'Giảng viên có CUNG CẤP LƯỢNG TỪ VỰNG (glossary) mỗi buổi học hay không?',
                'Giảng viên có GIAO BÀI TẬP về nhà và KIỂM TRA đầy đủ hay không?'
            ),

            'Về chất lượng ứng dụng và học online' => array(
                'Chất lượng đường truyền',
                'Mức độ dễ thao tác và sử dụng',
                'Chất lượng học online'
            ),
        );


        $list_quest_select = array(
            'Bạn sẽ đánh giá giáo viên của mình bao nhiêu điểm?'
        );

        $time_start = time();

        $token_feedback = $this->config->item('token_feedback');
        $token = md5($token_feedback . $time_start);

        $data = array(
            'type_class' => 'dao_tao_onl',
            'time_start' => $time_start,
            'token' => $token,
            'info_class' => $info_class,
            'list_info_class' => $list_info_class,
            'list_quest_ruler' => $list_quest_ruler,
            'list_quest_select' => $list_quest_select,
            'arr_location_info' => $arr_location_info,
        );

        $this->load->view('feedback/feedback_dao_tao_online', $data, false);
    }

}
