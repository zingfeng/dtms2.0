<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Test_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }
    public function get_score_text($question_correct) {
        $question_correct = ($question_correct < 3.5) ? 3.5 : $question_correct;
        $arrScore = array(
            3.5 => 'Có vẻ bạn chưa nắm rõ về bài thi IELTS lắm. Aland khuyên bạn hãy dành thời gian học lại thật tốt các kiến thức nền tảng trước khi bắt đầu luyện thi IELTS nhé',
            4 => 'Bạn có một kiến thức nền tảng khá vững và bắt đầu luyện thi IELTS tốt rồi. Aland khuyên bạn nên tập trung từng kỹ năng để cải thiện điểm số một cách nhanh nhất nhé.',
            6 => 'Thật tuyệt, bạn đạt điểm số cao hơn 60% các thí sinh Việt Nam rồi đấy. Hãy chăm chỉ luyện tập và làm thật nhiều đề thi IELTS nữa để tăng điểm số nhé bạn',
            7.5 => 'Tuyệt vời! Xin chúc mừng bạn đã trở thành một “cao thủ” IELTS và đạt điểm số cao hơn 90% các thí sinh luyện thi IELTS Việt Nam. Hãy thử một số phương pháp sau để tăng điểm số thêm cao hơn nữa nhé' 
        );
        $score_convert = '';
        foreach ($arrScore as $q => $score) {
            if ($question_correct >= $q) {
                //echo $question_correct . '-'.$q . '-'.$score.'<br>';
                $score_convert = $score;
            }
            else {
                break;
            }
        }
        return $score_convert;
    }
    public function get_score($question_correct) {
        $arrScore = array(
            0 => 1,
            1 => 2,
            3 => 2.5,
            4 => 3,
            7 => 3.5,
            10 => 4,
            13 => 4.5,
            16 => 5,
            20 => 5.5,
            23 => 6,
            27 => 6.5,
            30 => 7,
            33 => 7.5,
            35 => 8,
            37 => 8.5,
            39 => 9
        );
        $score_convert = 0;
        foreach ($arrScore as $q => $score) {
            if ($question_correct >= $q) {
                //echo $question_correct . '-'.$q . '-'.$score.'<br>';
                $score_convert = $score;
            }
            else {
                break;
            }
        }
        return $score_convert;
    }
    public function get_total_by_cate($params) {
        $this->db->where('original_cate',$params['cate_id']);
        $this->db->order_by('test_id','DESC');
        if ($params['excluse']) {
            $this->db->where_not_in('test_id',$params['excluse']);
        }
        return $this->db->count_all_results("test");
    }

    public function get_test_by_cate($params) {
        // type = writing

        $params_default = array('limit' => 10, 'offset' => 0,'isclass' => 0);
        $params = array_merge($params_default,$params);
        $this->db->select("test_id,title,images,share_url,total_users,total_hit");
        $this->db->where('original_cate',$params['cate_id']);
        $this->db->where('isclass',$params['isclass']);
        $this->db->order_by('test_id','DESC');
        if ($params['excluse']) {
            $this->db->where_not_in('test_id',$params['excluse']);
        }
        $query = $this->db->get("test as c",$params['limit'],$params['offset']);
        return $query->result_array();
    }

    public function get_test_by_cate_by_type($params) {
        // type = writing
        $test_id = (int) $params['excluse']; // Tường minh
        $cate_id = $params['cate_id']; // Tường minh
        $type = (int) $params['type'];
        // type = 3 ->> writing
        // type = 4 ->> speaking

        $params_default = array('limit' => 10, 'offset' => 0,'isclass' => 0);
        $params = array_merge($params_default,$params);
        $this->db->select("test_id,title,images,share_url,total_users,total_hit");
        $this->db->where('original_cate',$params['cate_id']);
        $this->db->where('isclass',$params['isclass']);
        $this->db->order_by('test_id','DESC');
        if ($params['excluse']) {
            $this->db->where_not_in('test_id',$params['excluse']);
        }
        $query = $this->db->get("test as c",$params['limit'],$params['offset']);
        $list_test_id =  $query->result_array();

        $arr_res = array(); // id_test , url
        for ($i = 0; $i < count($list_test_id); $i++) {
            $test_id_mono = (int) $list_test_id[$i]['test_id'];
            // check xem test_id_mono này có dạng bài tương tự không
            // SELECT * FROM `test_question` WHERE type=3
            $this->db->select("question_id");
            $this->db->where('type',$type); // Câu hỏi dạng
            $this->db->where('test_id',$test_id_mono); // Câu hỏi dạng
            $query2 = $this->db->get("test_question");
            $arr_res_mono = $query2->result_array();
            if (count($arr_res_mono) > 0){
                array_push($arr_res,$list_test_id[$i]);
            }
        }

        return  $arr_res     ;
    }




    public function get_latest($params) {
        $params_default = array('limit' => 10, 'offset' => 0);
        $params = array_merge($params_default,$params);
        $this->db->select("test_id,title,images,share_url,total_users");
        if (isset($params['isclass'])) {
            $this->db->where('isclass',$params['isclass']);
        }
        $this->db->order_by('test_id','DESC');
        $query = $this->db->get("test",$params['limit'],$params['offset']);
        return $query->result_array();
    }
    public function get_test_detail($params) {
        $this->db->select('test_id,title,share_url,description,images,original_cate,create_time,isclass,type,publish_time,total_hit,author');
        $this->db->where("test_id",$params['test_id']);
        $this->db->where("publish",1);
        $query = $this->db->get("test");
        return $query->row_array();
    }
    public function get_question_by_test($params) {
        $params_default = array('limit' => 100, 'offset' => 0);
        $params = array_merge($params_default,$params);
        $this->db->select("*");
        $this->db->where("test_id", $params['test_id']);
        if (isset($params['parent'])) {
            $this->db->where("parent_id",0);
        }
        
        if ($params['type']) {
            $this->db->where_in('type',$params['type']);
        }
        $this->db->order_by("ordering, question_id ASC");
        $query = $this->db->get("test_question",$params['limit'],$params['offset']);
        $arrQuestion =  $query->result_array();
        return  $arrQuestion;
    }
    public function get_question_group($params) {
        $params_default = array('limit' => 100, 'offset' => 0);
        $params = array_merge($params_default,$params);
        $this->db->select("*");
        $this->db->where_in("parent_id", $params['parent_id']);
        $this->db->order_by("ordering, question_id DESC");
        $query = $this->db->get("test_question",$params['limit'],$params['offset']);
        $arrQuestion =  $query->result_array();
        foreach ($arrQuestion as $question) {
            $arrQuestionData[$question['parent_id']][$question['question_id']] = $question;
            $arrQuestionId[] = $question['question_id'];
        }
        if ($params['return_question_id_only'] == 1) {
            return $arrQuestionId;
        }
        $this->db->where_in('question_id',$arrQuestionId);
        $this->db->order_by('ordering, question_id');
        $query = $this->db->get('test_question_answer');
        $rows = $query->result_array();
        
        foreach ($rows as $key => $row) {
            $arrAnswerData[$row['question_id']][] = $row;
            $arrNumber[$row['question_id']] += $row['number_question'];
        }

        foreach ($arrQuestion as $question) {

            $question['question_answer'] = $arrAnswerData[$question['question_id']];
            $question['number_question'] = $arrNumber[$question['question_id']];
            $arrQuestionData[$question['parent_id']][$question['question_id']] = $question;
        }
        return $arrQuestionData;
    }
    public function get_answer_result_by_question_id($arrQuestionId = array()) {
        $this->db->where_in('question_id',$arrQuestionId);
        $this->db->order_by('ordering, question_id');
        $query = $this->db->get('test_question_answer');
        $rows = $query->result_array();
        $arrAnswerId = array();
        foreach ($rows as $key => $testAnswer) {
            $arrAnswerId[] = $testAnswer['answer_id'];
        }
        return $this->get_answer_result($arrAnswerId);
    }
    public function get_answer_result($arrAnswerId = array()) {
        $this->db->where_in('answer_id',$arrAnswerId);
        $this->db->order_by('answer_id,ordering');
        $query = $this->db->get("test_question_answer_result");
        return $query->result_array();
    }
    
    /** LIST FOR MEMBER CLASSS **/
    public function list_for_class($role,$options = array()){
        $offset = ($page - 1) * $limit;
        if ($options['cate']){
            $this->db->join("test_to_cate as c","c.test_id = r.test_id");
            $this->db->where_in("c.cate_id",$options['cate']);
        }
        if($options['excluse']) {
            $this->db->where_not_in('r.test_id',$options['excluse']);
        }
        if($options['type']) {
            $this->db->where('type',$options['type']);
        }
        $this->db->distinct();
        $this->db->join("test as n","n.test_id = r.test_id");
        $this->db->select("r.test_id,n.title,n.description,n.images,n.share_url");
        $this->db->where("publish",1);
        $this->db->where("r.class_id",$role);
        $this->db->order_by("r.test_id","DESC");
        $query = $this->db->get("test_to_class as r",$options['limit'],$options['offset']);
        return $query->result_array();
    }
    public function count_list_for_class($role,$options = array()){
        if ($options['cate']){
            $this->db->join("test_to_cate as c","c.test_id = r.test_id");
            $this->db->where_in("c.cate_id",$options['cate']);
        }
        $this->db->join("test as n","n.test_id = r.test_id");
        $this->db->where("publish",1);
        $this->db->where("r.class_id",$role);
        return $this->db->count_all_results("test_to_class as r");
    }
    public function count_all_test() {
        $this->db->where('isclass',0);
        $this->db->where('publish',1);
        return $this->db->count_all_results("test");
    }
    public function check_test_role($test_id,$role){
        $this->db->where("test_id",$test_id);
        $this->db->where("class_id",$role);
        return $this->db->count_all_results("test_to_class");
    }
    /**
    * @todo: Cap nhat ket qua bai test sau khi xong
    */
    public function test_logs_insert($params) {
        
        if (is_array($params['answer_list'])) {
            $params['answer_list'] = json_encode($params['answer_list']);
        }
        if (is_array($params['score_detail'])) {
            $params['score_detail'] = json_encode($params['score_detail']);
        }
        // insert log
        $input = array(
            'start_time' => $params['start_time'],
            'end_time' => time(),
            'timestamp_fulltest' => $params['timestamp_fulltest'],
            'test_id' => $params['test_id'],
            'test_type' => $params['test_type'],
            'user_id' => $params['user_id'],
            'score' => (int) $params['score'],
            'score_detail' => $params['score_detail'],
            'answer_list' => $params['answer_list'],
        );
        $this->db->insert('test_logs',$input);
        return (int)$this->db->insert_id();
    }
    /**
    * @todo: Gửi yêu cầu chấm bài 
    */
    public function test_logs_update($logs_id, $input) {
        // update test logs
        $this->db->where('logs_id',$logs_id);
        $this->db->update('test_logs',$input['test_logs']);
        $countRow = $this->db->affected_rows();        
        // return result
        return $countRow;
    }
    /**
    * @todo: Them du lieu log truoc
    */
    public function get_test_logs_detail($log_id) {
        $this->db->where("logs_id",$log_id);
        $query = $this->db->get("test_logs");
        return $query->row_array();
    }
    /**
    * @todo: Get list log test by timestamp_fulltest
    */
    public function get_fulltest_by_timestamp($timestamp_fulltest) {
        if(empty($timestamp_fulltest)){
            return FALSE;
        }
        $this->db->where("timestamp_fulltest",$timestamp_fulltest);
        $query = $this->db->get("test_logs");
        return $query->result_array();
    }
    // incre test list
    public function incre_hit($params) {
        $this->db->set('total_hit','total_hit + 1',FALSE);
        $this->db->where('test_id',$params['test_id']);
        $this->db->update('test');
    }

    /** LIST TEST FOR COURSE **/
    public function list_for_course($course_id,$options = array()){
        $options = array_merge(array('limit' => 10, "offset" => 0),$options);
        $this->db->join("course_to_test as ct","ct.test_id = t.test_id", 'LEFT');
        $this->db->where("ct.course_id",$course_id);
        $this->db->order_by("ct.ordering");
        $query = $this->db->get("test as t", $options['limit'], $options['offset']);
        return $query->result_array();
    }

    /** LIST TEST FOR COURSE CLASS**/
    public function list_for_course_class($course_class_id,$options = array()){
        $options = array_merge(array('limit' => 10, "offset" => 0),$options);
        $this->db->join("course_class_to_test as ct","ct.test_id = t.test_id", 'LEFT');
        $this->db->where("ct.course_class_id",$course_class_id);
        $this->db->order_by("ct.ordering");
        $query = $this->db->get("test as t", $options['limit'], $options['offset']);
        return $query->result_array();
    }

    public function getResult_and_Suggest_byPoint($type_input, $point)
    {
        $result_final = '';
        $suggest_final = '';
        $arr_conf = array(
            1 =>'listening',
            2 =>'reading',
            3 =>'writing',
            4 =>'speaking',
        );

        if (isset($arr_conf[$type_input])) {
            $type = $arr_conf[$type_input]; // reading listening ...

            $this->db->select('*');
            $this->db->where('type', $type);
            $this->db->order_by('score_min', 'ASC');
            $query = $this->db->get('test_result');
            $list_rule = $query->result_array();
            if (is_array($list_rule)) {
                for ($i = 0; $i < count($list_rule); $i++) {
                    $mono_rule = $list_rule[$i];
                    $from_point = (float)$mono_rule['score_min'];
                    $to_point = (float)$mono_rule['score_max'];
                    $result = $mono_rule['result'];
                    $suggest = $mono_rule['suggest'];

                    if ($i == count($list_rule) ){
                        // last situation
                        $result_final = $result;
                        $suggest_final = $suggest;
                        break;
                    }

                    if (($from_point <= $point) && ($point <= $to_point)) {
                        $result_final = $result;
                        $suggest_final = $suggest;
                        break;
                    }

                }
            }
        }
        return array($result_final,$suggest_final);
    }
//    public function getListTestByIdUser($id_user){
//        $this->db->where('user_id',$id_user);
//        $this->db->select('*');
//        $query = $this->db->get('test_logs');
//        $arr_res = $query->result_array();
//        return $arr_res;
//    }

} 