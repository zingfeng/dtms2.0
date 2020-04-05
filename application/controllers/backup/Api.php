<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Api extends CI_Controller{
    function __construct(){
		parent::__construct();
	}


    /**
    *   Get all cate
    *   @params (int) cate_id 
    */
    public function test_cate($cateid = 0){
        $cateid = (int)$cateid;
        $this->load->model('test_model','test');
        if($cateid){          
            $cate = $this->test->get_cate_detail(array('cate_id' => $cateid)); 
            $cate['child'] = $this->test->get_sub_cate($cateid);
            $arrCate = array($cate);
        } else {
            $arrCate = $this->test->get_all_cate();
            $arrCate = $this->test->recursiveCate($arrCate);
        }
        
        $data = array(
            'arrCate' => $arrCate,
            'cateid' => $cateid,
        );

        // return data
        return $this->output->set_output(json_encode(array('status' => 'success', 'data' => $data)));
    }

    /**
    *   Get list test in cate
    *   @params (int) cate_id 
    */
    public function test_list($cateid = 0){
    	$cateid = (int) $cateid;
        $this->load->model('test_model','test');
        // get cate detail
        $cate = $this->test->get_cate_detail(array('cate_id' => $cateid));
        if(empty($cate)){
        	 return $this->output->set_output(json_encode(array('status' => 'error', 'message' => 'Cate Id không đúng')));
        }

        $limit = (int) $this->input->get('limit') ? : 10;
        $page = (int) $this->input->get('page') ? : 1;
   		$offset = ($page > 1) ? ($page - 1) * $limit : 0;
   		$params = array('limit' => $limit, 'offset' => $offset);

        // get test by cate
        $params = array('cate_id' => $cateid,'limit' => 0);        // data

        $data['rows'] = $this->test->get_test_by_cate($params); 
        $data['cate'] = $cate;

        // return data
        return $this->output->set_output(json_encode(array('status' => 'success', 'data' => $data)));
    }

    /**
    *   Get test detail
    *   @params (int) test_id 
    */
    public function test_detail($id){
    	$id = (int) $id;
        $this->load->model('test_model','test');
        $this->load->model('category_model','category');
        // get detail test 
        $testDetail = $this->test->get_test_detail(array('test_id' => $id));
        if (empty($testDetail)){
            return $this->output->set_output(json_encode(array('status' => 'error', 'message' => 'Id bài test không tồn tại')));
        }
        // get cate detail
        $cate = $this->category->detail($testDetail['original_cate']);

        // get question
        $limit = (int) $this->input->get('limit') ? : 200;
        $page = (int) $this->input->get('page') ? : 1;
        $offset = ($page - 1) * $limit;
        $question = $this->test->get_question_by_test(array('test_id' => $id,'limit' => $limit + 1, 'offset' => $offset));
        // get arrQuestionId
        foreach ($question as $key => $item) {
            $arrQuestionId[] = $item['question_id'];
        }
        // get answer
        $answer = $this->test->get_answer_by_question(array('question_id' => $arrQuestionId));
        $i = 0;
        foreach ($answer as $key => $value) {
            $data['answer'][$value['question_id']][] = $value;
        }
        // set data to view
        $data['test'] = $testDetail;
        $data['question'] = $question;
        
        // return data
        return $this->output->set_output(json_encode(array('status' => 'success', 'data' => $data)));
    }

    /**
    *   Get result
    *   @method post
    *   @params(array) question
    *   @params(array) answer
    */
    public function result() {
        $this->load->model('test_model','test');
        // get test detail
        $test_id = (int) $this->input->post('test_id');
        $testDetail = $this->test->get_test_detail(array('test_id' => $test_id));
        if (!$testDetail) {
            return $this->output->set_output(json_encode(array('status' => 'error','message' => 'Không đúng thông tin bài test')));
        }
        $output = array('status' => 'error','message' => 'Chưa nhập thông tin trả lời');
        $arrUserAnswer = $this->input->post('answer');
        $result_md5 = $this->input->post('result');
        $arrQuestionId = array_map('intval', $this->input->post('question'));

        if ($arrQuestionId) {
            // get detail question
            $arrQuestion = $this->test->get_question_by_id(array('question_id' => $arrQuestionId,'test_id' => $test_id));
            // get detail answer
            $arrAnswer = $this->test->get_answer_by_question(array('question_id' => $arrQuestionId, 'correct' => 1));
            foreach ($arrAnswer as $key => $answer) {
                $arrCorrect[$answer['question_id']][$answer['answer_id']] = $answer;
            }
            // check total question answer
            $output['total_answer'] = 0;
            $output['total_question'] = 0;
            //Kết quả của học viên
            $result = 0;
            foreach ($arrQuestion as $key => $question) {
                // get user answer + result by question_id
                $userAnswer = $arrUserAnswer[$question['question_id']];
                $answerCorrect = $arrCorrect[$question['question_id']];

                if (!$answerCorrect) {
                    return $this->output->set_output(json_encode(array('status' => 'error', 'message' => 'Câu hỏi không chính xác')));
                }
                //Set correct
                $keyCorrect = array_keys($answerCorrect);
                $output['keyCorrect'][$question['question_id']] = $keyCorrect;

                $output['total_question'] += count($keyCorrect);

                if (!$userAnswer) {
                    // save missing answer
                    $output['missing'][] = $question['question_id'];
                    continue;
                }
                else {
                    if ($question['type'] == 1 && count($userAnswer) != count($answerCorrect)) {
                        $output['missing'][] = $question['question_id'];
                    }
                }
                //$output['result'] = $keyCorrect;
                $output['correct'][$question['question_id']] = $output['incorrect'][$question['question_id']] = array();
                foreach ($userAnswer as $u) {
                    if (in_array($u, $keyCorrect)) {
                        $output['correct'][$question['question_id']][] = (int) $u;
                        $result ++;
                    }
                    else {
                        $output['incorrect'][$question['question_id']][] = (int) $u;
                    }
                }
            }
            $output['result'] = $result;        //Kết quả của học viên

            if ($testDetail['score'] == 1) {
                // So answer tra loi dung
                $output['count_answer_correct'] = 0;
                if($output['correct']){
                    foreach ($output['correct'] as $key => $correct) {
                        $output['count_answer_correct'] += count($correct);
                    }
                }

                $output['count_question_correct'] = count(array_diff(array_keys($output['correct']), array_keys($output['incorrect'])));
                // get barem score
                $test_barem = @json_decode($testDetail['score_params'],TRUE);
                // sort key min to max to get final score
                krsort($test_barem); 
                $output['final_score'] = 0;
                foreach ($test_barem as $key => $value) {
                    if ($output['count_answer_correct'] >= $key) {
                        $output['final_score'] = $value;
                        break;
                    }
                }
                // get total_score 
                $arrScore = array_values($test_barem);
                $output['total_score'] = $arrScore[0];
                // check score review
                $cateDetail = $this->test->get_cate_detail(array('cate_id' => $testDetail['cate_id']));

                $barem_comment = @json_decode($cateDetail['score_comment']);
                $output['comment'] = '';
                if ($barem_comment){
                    foreach ($barem_comment as $key => $value) {
                        if ($output['final_score'] >= $key) {
                            $output['comment'] = $value;
                            break;
                        }
                    }
                }
                //$timeUse = time() - (int) $this->session->userdata('start_time_'.$id);
                // log test 
                // $this->test->log_test(array('test_id' => $test_id,'score' => $output['final_score'],'answer' => '','incorrect' => $output['incorrect']));
            } 
            // 
            $output['status']  = 'success';
            unset($output['message']);
        }

        return $this->output->set_output(json_encode($output));
    }    

    /**
    *   Get cate news
    *   @params (int) cate_id 
    */
    public function news_list($cate_id = 0){
        $cate_id = intval($cate_id);
        if ($cate_id <= 0){
            return $this->output->set_output(json_encode(array('status' => 'error', 'message' => 'Cate id không tồn tại')));
        }
        // instance
        $limit = (int) $this->input->get('limit') ? : 10;
        $page = (int) $this->input->get('page') ? : 1;
        $offset = ($page > 1) ? ($page - 1) * $limit : 0;
        $params = array('limit' => $limit, 'offset' => $offset);
        $this->load->model('news_model','news');
        // GET CATE DETAIL
        $cate = $this->news->get_cate_detail($cate_id);
        if (empty($cate)){
            return $this->output->set_output(json_encode(array('status' => 'error', 'message' => 'Thể loại không tồn tại')));
        }
        // set data
        $data = array(
            'cate' => $cate,
            'arrNews' => $this->news->lists_by_cate_rule1($params),
        );
        
        return $this->output->set_output(json_encode(array('status' => 'success', 'data' => $data)));
    }

    /**
    *   Get cate news
    *   @params (int) $id
    */
    public function news_detail($id = 0){
        $id = (int) $id;
        $this->load->model('news_model','news');
        $detail = $this->news->detail($id);
        if (empty($detail)){
            return $this->output->set_output(json_encode(array('status' => 'error', 'message' => 'Tin tức không tồn tại')));
        }
        $data['row'] = $detail;
        // neu can lay category info
        $cate = $this->news->get_cate_detail($detail['original_cate']);
        // set data
        $data = array(
            'cate' => $cate,
            'relate' => $this->news->relate(array("cate_id" => $detail['original_cate'], "news_id" => $id,'limit' => 4)),
            'newsDetail' => $detail,
        );
        // update count hit
        $this->news->count_hit($id);
        // render data
        return $this->output->set_output(json_encode(array('status' => 'success', 'data' => $data)));
    }

    //////////////////////////////////////USER/////////////////////////////////////////////////////////
    public function login(){
        if (!$redirect_uri = $this->input->get("redirect_uri")) {
            $redirect_uri = BASE_URL;
        }
        if ($this->permission->hasIdentity()){
            return $this->output->set_output(json_encode(array('status' => 'success','redirect_uri' => $redirect_uri)));
        }
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $valid = array(
                array(
                    'field'   => 'email',
                    'label'   => 'Email',
                    'rules'   => 'required|valid_email'
                    ),
                array(
                    'field'   => 'password',
                    'label'   => 'Mật khẩu',
                    'rules'   => 'required|min_length[3]|max_length[40]'
                    )
            );
            $this->form_validation->set_rules($valid);
            if ($this->form_validation->run() == true)
            {
                // get params
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                // get profile by email
                $this->load->model('users_model','users');
                $profile = $this->users->getProfileByEmail($email);
                if (!$profile) {
                    return $this->output->set_output(json_encode(array('status' => 'error','message' =>'Email không tồn tại')));
                }
                if ($profile['active'] != 1) {
                    return $this->output->set_output(json_encode(array('status' => 'error', 'email' => 'Tài khoản chưa được kích hoạt')));
                }
                if ($profile['password'] !== md5($password)) {
                    return $this->output->set_output(json_encode(array('status' => 'error','message' => 'Mật khẩu không đúng')));
                }
                // set session
                $this->permission->setIdentity($profile);
                return $this->output->set_output(json_encode(array('status' => 'success','redirect_uri' => $redirect_uri)));
            }
            else{
                $error_msg = '';
                foreach ($this->form_validation->error_array() as $error) {
                    $error_msg .= $error.'; ';
                }
                return $this->output->set_output(json_encode(array('status' => 'error','message' => $error_msg)));
            }
        }
        return $this->output->set_output(json_encode(array('status' => 'error','message' => 'Sai phương thức truyền dữ liệu')));
    }

    public function register(){
        if ($this->permission->hasIdentity()){
            redirect(BASE_URL);
        }
        if ($this->input->post()){
            $this->load->library('form_validation');
            $valid = array(
                array(
                    'field'   => 'fullname',
                    'label'   => 'Họ và tên',
                    'rules'   => 'required|min_length[3]|max_length[40]'
                    ),
                array(
                    'field'   => 'password',
                    'label'   => 'Mật khẩu',
                    'rules'   => 'required|min_length[3]|max_length[40]'
                    ),
                array(
                    'field'   => 'repassword',
                    'label'   => 'Nhập lại mật khẩu',
                    'rules'   => 'required|matches[password]'
                    ),
                array(
                    'field'   => 'email',
                    'label'   => 'Email',
                    'rules'   => 'required|valid_email'
                    ),
                array(
                    'field'   => 'phone',
                    'label'   => 'Số điện thoại',
                    'rules'   => 'required'
                    )
                );
            $this->form_validation->set_rules($valid);
            if ($this->form_validation->run() == true)
            {
                $input = $this->input->post();
                ///////
                $emailUser = $input['email'];
                $this->load->model('users_model','users');
                // check email existed
                if ($profile = $this->users->getProfileByEmail($emailUser)){
                    if ($profile) {
                        return $this->output->set_output(json_encode(array('status' => 'error','message' => 'Email đã tồn tại')));
                    }                 
                }
                else {
                    // insert user
                    $user_id = $this->users->register($input);
                }
                // send mail with token
                if ($user_id > 0) {
                    // get code and save code
                    $code = $this->users->sendCode($user_id,1);
                    // check flush form by token
                    $token = md5($user_id.$code.$this->config->item('token_key_random'));
                    // get link active
                    // $link = SITE_URL . '/users/activecode?user_id='.$user_id.'&code='.$code.'&token='.$token.'&type=1';
                    $data = array(
                        'user_id' => $user_id,
                        'code' => $code,
                        'token' => $token,
                    );
                    //$html = $this->load->view('users/email/register',array('fullname' => $input['fullname'],'link' => $link, 'code' => $code,'token' => $token),TRUE);
                    //send_mail($input['email'],'Giovani\'s account - login',$html);
                    return $this->output->set_output(json_encode(array('status' => 'success','message' => 'Đăng ký tài khoản thành công', 'data' => $data)));
                }
                return $this->output->set_output(json_encode(array('status' => 'error','message' => 'Có lỗi hệ thống vui lòng thử lại')));     
            }
            else {
                $error_msg = '';
                foreach ($this->form_validation->error_array() as $error) {
                    $error_msg .= $error.'; ';
                }
                return $this->output->set_output(json_encode(array('status' => 'error','message' => $error_msg)));
            }
        }
        return $this->output->set_output(json_encode(array('status' => 'error', 'message' => 'Sai phương thức truyền dữ liệu'))); 
    }

    public function activecode($user = '',$code = ''){
        $token = $this->input->get('token');
        $user_id = $this->input->get('user_id');
        $code = $this->input->get('code');
        $type = $this->input->get('type');
        // check token 
        if ($token != md5($user_id.$code.$this->config->item('token_key_random'))) {
            return $this->output->set_output(json_encode(array('status' => 'error','message' => 'Mã token không chính xác')));
        }
        // get model users
        $this->load->model('users_model','users');
        $arrCode = $this->users->getCode($user_id,$type);
        if (!$arrCode || $arrCode['code'] !== $code) {
           return $this->output->set_output(json_encode(array('status' => 'error','message' => 'Mã token không chính xác')));
        }
        switch ($type) {
            case 1:
                $this->users->activeUser($user_id);
                return $this->output->set_output(json_encode(array('status' => 'success','message' => 'Success ! Your account has been activated')));
                break;
        }
    }

    public function logout(){
        // delete session
        $this->permission->clearIdentity();
        // delete cookie
        $this->load->helper('cookie');
        delete_cookie(USER_REMEMBER_PASSWORD);
        return $this->output->set_output(json_encode(array('status' => 'success','message' => 'Logout success')));
    }

    public function profile(){
        if (!$this->permission->hasIdentity()){
            return $this->output->set_output(json_encode(array('status' => 'error','message' => 'Bạn chưa đăng nhập')));
        }
        $profile = $this->permission->getIdentity();
        $this->load->model('users_model','users');
        if ($this->input->post()){
            $this->load->library('form_validation');
            $valid = array(
                array(
                    'field'   => 'fullname',
                    'label'   => 'Họ và tên',
                    'rules'   => 'required|min_length[3]|max_length[40]'
                    ),
                array(
                    'field'   => 'phone',
                    'label'   => 'Số điện thoại',
                    'rules'   => 'required'
                    ),
                array(
                    'field'   => 'sex',
                    'label'   => 'Giới tính',
                    'rules'   => 'required'
                    ),
                array(
                    'field'   => 'city_id',
                    'label'   => 'Tỉnh/Thành Phố',
                    'rules'   => 'required'
                    ),
                );
            $this->form_validation->set_rules($valid);
            if ($this->form_validation->run() == true)
            {
                $input = $this->input->post();
                $this->users->updateProfile($profile['user_id'],$input);
                return $this->output->set_output(json_encode(array('status' => 'success','message' => 'Cập nhật thông tin cá nhân thành công')));
            } else {
                $error_msg = '';
                foreach ($this->form_validation->error_array() as $error) {
                    $error_msg .= $error.'; ';
                }
                return $this->output->set_output(json_encode(array('status' => 'error','message' => $error_msg)));
            }
        }
        $row = $this->users->getUserById($profile['user_id'],array('active' => true));
        if (empty($row)){
            return $this->output->set_output(json_encode(array('status' => 'error','message' => 'Không có thông tin thành viên')));
        }
        return $this->output->set_output(json_encode(array('status' => 'success','data' => $row)));
    }

    public function updatepassword(){
        if (!$this->permission->hasIdentity()){
            return $this->output->set_output(json_encode(array('status' => 'error','message' => 'Bạn chưa đăng nhập')));
        }
        $profile = $this->permission->getIdentity();
        $this->load->model('users_model','users');
        if ($this->input->post()){
            $this->load->library('form_validation');
            $valid = array(
                array(
                    'field'   => 'old_password',
                    'label'   => 'Mật khẩu cũ',
                    'rules'   => 'required|min_length[3]|max_length[40]'
                    ),
                array(
                    'field'   => 'password',
                    'label'   => 'Mật khẩu mới',
                    'rules'   => 'required|min_length[3]|max_length[40]'
                    ),
                array(
                    'field'   => 'repassword',
                    'label'   => 'Nhập lại mật khẩu',
                    'rules'   => 'required|matches[password]'
                    ),
                );
            $this->form_validation->set_rules($valid);
            if ($this->form_validation->run() == true)
            {
                $row = $this->users->getUserById($profile['user_id'],array('active' => true));                
                $input = $this->input->post();
                if($row['password'] != md5($input['old_password'])){
                    return $this->output->set_output(json_encode(array('status' => 'error','message' => 'Mật khẩu cũ không chính xác')));   
                }
                $this->users->updatePassword($profile['user_id'],$input['password']);
                return $this->output->set_output(json_encode(array('status' => 'success','message' => 'Thay đổi mật khẩu thành công')));
            } else {
                $error_msg = '';
                foreach ($this->form_validation->error_array() as $error) {
                    $error_msg .= $error.'; ';
                }
                return $this->output->set_output(json_encode(array('status' => 'error','message' => $error_msg)));
            }
        }
        return $this->output->set_output(json_encode(array('status' => 'error','message' => 'Lỗi phương thức truyền dữ liệu')));
    }
}