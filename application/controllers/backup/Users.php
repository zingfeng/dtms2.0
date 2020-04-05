<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends CI_Controller{
    protected $user_data;
    protected $username = '';
    public function __construct(){
        parent::__construct();
        $this->lang->load('frontend/users');
    }
/** =================================== LOGIN ========================================= **/
    public function login(){
        if (!$redirect_uri = $this->input->get("redirect_uri")) {
            $redirect_uri = urlencode(BASE_URL);
        }
        if ($this->permission->hasIdentity()){
            redirect($redirect_uri);
        }
        $this->load->library('form_validation');
        $error = 0;
        if ($input = $this->input->post()) {
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
                    $error = 3;
                }
                else {
                    if ($profile['active'] != 1) {
                        if ($profile['username'] && $profile['password'] == md5($profile['username'].$password)) {
                            $updateOldStatus = $this->users->update_old_users($profile['user_id'],$password);
                        }
                        /// check time of email 
                        $userCode = $this->users->getCode($profile['user_id'],1);
                        if (!$userCode || $userCode['create_time'] < time()) {
                            $sendmailResult = $this->_send_mail_active($profile['user_id'],1);
                        } // 15' 
                        $token = $this->security->generate_token_post($profile['user_id']);
                        return redirect('/users/reactive?user_id='.$profile['user_id'].'&token='.$token.'&redirect_uri='.$redirect_uri);
                    }
                    elseif ($profile['password'] === hash('sha256',$password)){
                        $this->permission->setIdentity($profile);
                        return redirect(urldecode($redirect_uri));
                    }
                    else {
                        $error = 3;
                    }
                }
            }
            
        }
        // set meta and config //
        $this->config->set_item("breadcrumb",array(array("name" => 'Đăng nhập')));
        $this->load->layout('users/login_form',array('error' => $error));
    }
    public function reactive() {
        if (!$redirect_uri = $this->input->get("redirect_uri")) {
            $redirect_uri = urlencode(BASE_URL);
        }
        $user_id = (int) $this->input->get('user_id'); 
        if ($this->permission->hasIdentity()){
            redirect(urldecode($redirect_uri));
        }
        if (!$this->security->verify_token_post($user_id,$this->input->get("token"))) {
            show_404();
        }
        $this->load->model('users_model','users');
        //// get profile user
        $userData = $this->users->getUserById($user_id);
        
        if (!$userData) {
            show_404();
        }
        $userCode = $this->users->getCode($user_id,1);
        if (!$userCode) {
            show_404();
        }

        $this->load->library('form_validation');
        $error = 0;
        if ($input = $this->input->post()) {
            
            $valid = array(
                array(
                    'field'   => 'code',
                    'label'   => 'Chuỗi mật mã',
                    'rules'   => 'required'
                    )
            );
            $this->form_validation->set_rules($valid);
            if ($this->form_validation->run() == true)
            {
                // get params
                $code = trim($this->input->post('code'));
                if ($code == $userCode['code']) {
                    $result = $this->users->activeUser($user_id);
                    if ($result) {
                        $this->permission->setIdentity($userData);
                        return redirect(urldecode($redirect_uri));
                    }
                }
            }
            
        }
        $data = array('userData' => $userData, 'userCode' => $userCode);
        // set meta and config //
        $this->config->set_item("breadcrumb",array(array("name" => 'Kích hoạt tài khoản')));
        $this->load->layout('users/reactive',$data);
    }
    /* =================================== LOGIN ========================================= **/
    public function class_login(){     
        if (!$redirect_uri = $this->input->get("redirect_uri")) {
            $redirect_uri = urlencode(BASE_URL);
        }
        if ($this->permission->hasIdentity('class')) {
            redirect(urldecode($redirect_uri));
        }
        $this->load->library('form_validation');
        $error = 0;
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $valid = array(
                array(
                    'field'   => 'username',
                    'label'   => 'Username',
                    'rules'   => 'required'
                    ),
                array(
                    'field'   => 'password',
                    'label'   => 'Mật khẩu',
                    'rules'   => 'required'
                    )
            );
            $this->form_validation->set_rules($valid);
            if ($this->form_validation->run() == true)
            {
                $this->load->model('users_model','users');
                $classDetail = $this->users->check_class_login($this->input->post('username'),$this->input->post('password'));
                if ($classDetail) {
                    $this->permission->setClassIdentity($classDetail);
                    return redirect(urldecode($redirect_uri));
                }
                $error = 1;
            }
            else {
                $error = 2;
            }

        }
        // set meta and config //
        $this->config->set_item("breadcrumb",array(array("name" => 'Đăng nhập')));
        $this->load->layout('users/class_login',array('redirect_uri' => urlencode($redirect_uri),'error' => $error));
    }

    public function class_logout(){
        // delete session
        $this->permission->clearIdentity('class');
        // redirect(BASE_URL);
    }
/** ======================================= REGISTER ===================================== **/
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
                    ),
                array(
                    'field'   => 'captcha',
                    'label'   => 'Mã bảo mật',
                    'rules'   => 'required|matches_str['.$this->session->userdata('register').']'
                    ),
                array(
                    'field'   => 'accept-terms',
                    'label'   => 'Điều khoản',
                    'rules'   => 'required'
                    )
                );
            $this->form_validation->set_rules($valid);
            // get new captcha
            $this->load->helper('captcha');
            $captcha = get_captcha('register');
            //Csrf
            $csrf = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash(),
            );
            if ($this->form_validation->run() == true)
            {
                $input = $this->input->post();
                ///////
                $emailUser = $input['email'];
                $this->load->model('users_model','users');
                // check email existed
                if ($profile = $this->users->getProfileByEmail($emailUser)){
                    if ($profile) {
                        return $this->output->set_output(json_encode(array('status' => 'error','message' => array('email' => 'Email đã tồn tại'),'captcha' => $captcha['image'],'csrf_hash' => $csrf['hash'])));
                    }                 
                }
                else {
                    // insert user
                    $user_id = $this->users->register($input);
                }
                // send mail with token
                if ($user_id > 0) {
                    // get code and save code
                    $this->_send_mail_active($user_id,1);
                    $token = $this->security->generate_token_post($user_id);
                    $url = SITE_URL .'/users/reactive?user_id='.$user_id.'&token='.$token;
                    return $this->output->set_output(json_encode(array('status' => 'success','message' => 'Đăng ký tài khoản thành công','redirect_uri' => $url,'csrf_hash' => $csrf['hash'])));
                }
                
                return $this->output->set_output(json_encode(array('status' => 'error','message' => array('email' => 'Có lỗi hệ thống vui lòng thử lại'),'captcha' => $captcha['image'],'csrf_hash' => $csrf['hash'])));     
            }
            else {
                return $this->output->set_output(json_encode(array('status' => 'error','message' => $this->form_validation->error_array(),'captcha' => $captcha['image'],'csrf_hash' => $csrf['hash'])));
            }
        }
        $this->load->helper('captcha');
        $captcha = get_captcha('register');
        $data = array(
            'captcha' => $captcha['image'],
            'redirect_uri' => urlencode($redirect_uri)
        );
        // set meta and config //
        $this->config->set_item("breadcrumb",array(array("name" => 'Đăng ký')));
        $this->load->layout('users/register',$data);
    }
    private function _send_mail_active($user_id,$type = 1) {
        if (!$user_id) {
            return false;
        }
        $this->load->model('users_model','users');
        $userProfile = $this->users->getUserById($user_id);
        $code = $this->users->sendCode($user_id,$type);
        // check flush form by token
        $token = md5($user_id.$code.$this->config->item('token_key_random'));
        // get link active
        if ($type == 1) {
            $link = SITE_URL . '/users/activecode?user_id='.$user_id.'&code='.$code.'&token='.$token.'&type=1';
            $html = $this->load->view('users/mail/register',array('fullname' => $userProfile['fullname'],'link' => $link, 'code' => $code,'token' => $token),TRUE);
            return send_mail($userProfile['email'],'Aland English\'s account - Login',$html);    
        }else if($type == 2){       //Reset pass
            $code = $this->users->sendCode($user_id,2);
            $token = md5($user_id.$code.$this->config->item('token_key_random'));
            // get link active
            $link = SITE_URL . '/users/new_password?user_id='.$user_id.'&code='.$code.'&token='.$token;
            $html = $this->load->view('users/mail/new_pass',array('fullname' => $userProfile['fullname'],'link' => $link, 'code' => $code,'token' => $token),TRUE);
            return send_mail($userProfile['email'],'Aland English\'s forgot password',$html);    
        }
    }
/** ===================================== PROFILE ==================================== **/
    /////////////TRANG HỌC VIÊN/////////////////////////////////
    public function profile($class_id = '', $alias = ''){
        if (!$this->permission->hasIdentity()){
            redirect(BASE_URL.'/dang-nhap.html');
        }
        $profile = $this->permission->getIdentity();
        $this->load->model('users_model','users');
        $this->load->model('course_model','course');
        $this->load->model('test_model','test');
        //Thông tin user
        $row = $this->users->getUserById($profile['user_id'],array('active' => true));
        if (empty($row)){
            show_404();
        }
        //Thông tin khóa học của user
        $course = $this->course->getCourse(array('user_id' => $profile['user_id'], 'limit' => 1));
        if (empty($course)){
            show_404();
        }
        //get chuyen de
        $arrTopic = $this->course->get_lists_topic($course['course_id']);
        foreach($arrTopic as $topic){  
            $arrTopicId[] = (int)$topic['topic_id']; 
        }
        //get bai hoc
        if($arrTopicId){
            $params = array('user_id' => $profile['user_id']);
            if($this->input->get('learned') !== NULL){
                $params['learned'] = (int) $this->input->get('learned');
            }else{
                $params['all'] = 1;
            }
            if($this->input->get('type') !== NULL){
                $params['type'] = (int) $this->input->get('type');
            }
            $arrData = $this->course->get_lists_class($arrTopicId, $params);
            foreach($arrData as $class){
                if(empty($class_id)){
                    $class_id = $class['class_id'];
                }
                $arrClass[$class['topic_id']][] = $class;
            }
        }

        //Get detail video 
        $classDetail = $this->course->get_class_detail($class_id);
        $arrTest = $this->test->list_for_course_class($class_id);
        if($arrTest){
            $this->load->config("data");
            $arr_test_type = $this->config->item('test_type');
            foreach ($arrTest as $key => $test) {
                foreach ($arr_test_type as $type_id => $type_name) {
                    // Check question
                    $arrQuestion = $this->test->get_question_by_test(array('test_id' => $test['test_id'], 'type' => $type_id, 'limit' => 200));
                    if($arrQuestion){
                        $arrTest[$key]['test_list'][] = $type_name;
                    }
                }
            }
        }

        //Get array teacher 
        $this->load->model('expert_model','expert');
        $arrTeacher = $this->expert->lists_teacher_by_course_id($course['course_id']);

        //Lưu trạng thái user đã học
        $this->users->save_users_to_class($profile['user_id'], $class_id); 

        $data = array(
            'row' => $row,
            'course' => $course,
            'arrTopic' => $arrTopic,
            'arrClass' => $arrClass,
            'arrTeacher' => $arrTeacher,
            'classDetail' => $classDetail,
            'arrTest' => $arrTest,
        );
        $this->load->layout('users/profile',$data);
    }
    
    /////////////CHỈNH SỬA THÔNG TIN CÁ NHÂN////////////////////
    public function updateprofile(){
        if (!$this->permission->hasIdentity()){
            redirect(BASE_URL.'/dang-nhap.html');
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
            //Csrf
            $csrf = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash(),
            );
            if ($this->form_validation->run() == true)
            {
                $input = $this->input->post();
                $this->users->updateProfile($profile['user_id'],$input);
                return $this->output->set_output(json_encode(array('status' => 'success','message' => 'Cập nhật thông tin cá nhân thành công','csrf_hash' => $csrf['hash'])));
            } else {
                return $this->output->set_output(json_encode(array('status' => 'error','message' => $this->form_validation->error_array(),'csrf_hash' => $csrf['hash'])));
            }
        }
        $row = $this->users->getUserById($profile['user_id'],array('active' => true));
        if (empty($row)){
            show_404();
        }
        $this->config->set_item("breadcrumb",array(array("name" => 'Thông tin cá nhân')));
        $data = array(
            'row' => $row,
            'arrCity' => $this->users->getCity(),
        );
        $this->load->layout('users/update_profile',$data);
    }

    public function updatepassword(){
        if (!$this->permission->hasIdentity()){
            redirect(BASE_URL.'/dang-nhap.html');
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
            //Csrf
            $csrf = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash(),
            );
            if ($this->form_validation->run() == true)
            {
                $row = $this->users->getUserById($profile['user_id'],array('active' => true));                
                $input = $this->input->post();
                if($row['password'] != hash('sha256',$input['old_password'])){
                    return $this->output->set_output(json_encode(array('status' => 'error','message' => array('old_password' => 'Mật khẩu cũ không chính xác'),'csrf_hash' => $csrf['hash'])));   
                }
                $this->users->updatePassword($profile['user_id'],$input['password']);
                return $this->output->set_output(json_encode(array('status' => 'success','message' => 'Thay đổi mật khẩu thành công','csrf_hash' => $csrf['hash'])));
            } else {
                return $this->output->set_output(json_encode(array('status' => 'error','message' => $this->form_validation->error_array(),'csrf_hash' => $csrf['hash'])));
            }
        }
        $row = $this->users->getUserById($profile['user_id'],array('active' => true));
        if (empty($row)){
            show_404();
        }
        $this->config->set_item("breadcrumb",array(array("name" => 'Đổi mật khẩu')));
        $data = array(
            'row' => $row,
        );
        $this->load->layout('users/update_password',$data);
    }
/** ======================================= COMMON =============================== **/
    public function logout(){
        // delete session
        $this->permission->clearIdentity();
        // delete cookie
        $this->load->helper('cookie');
        delete_cookie(USER_REMEMBER_PASSWORD);
        redirect(BASE_URL);
    }
/** ================================== FORGOT PASS ================================ **/
    public function forgotpass(){
        if ($this->input->post()){
            $this->load->library('form_validation');
            $valid = array(
                array(
                    'field'   => 'email',
                    'label'   => $this->lang->line('users_email'),
                    'rules'   => 'required|valid_email'
                    ),
                array(
                    'field'   => 'captcha',
                    'label'   => $this->lang->line('users_captcha'),
                    'rules'   => 'required|matches_str['.$this->session->userdata('forgotpass').']'
                    )
                );
            $this->form_validation->set_rules($valid);
            // get new captcha
            $this->load->helper('captcha');
            $captcha = get_captcha('forgotpass');
            //Csrf
            $csrf = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash(),
            );
            if ($this->form_validation->run() == true)
            {
                $this->load->model('users_model','users');
                $email = $this->input->post('email');
                $profile = $this->users->getProfileByEmail($email,array('active' => 1));
                if (!$profile) {
                    return $this->output->set_output(json_encode(array('status' => 'error','message' => array('email' => 'Email không tồn tại hoặc chưa kích hoạt'),'captcha' => $captcha['image'],'csrf_hash' => $csrf['hash'])));
                }
                // send mail forgot pass
                $this->_send_mail_active($profile['user_id'], 2);

                return $this->output->set_output(json_encode(array('status' => 'success','message' => 'Thông tin đặt lại mật khẩu đã được gửi vào email của bạn.','captcha' => $captcha['image'],'csrf_hash' => $csrf['hash'])));  
            }
            else {
                return $this->output->set_output(json_encode(array('status' => 'error','message' => $this->form_validation->error_array(),'captcha' => $captcha['image'],'csrf_hash' => $csrf['hash'])));
            }
        }
        $this->load->helper('captcha');
        $captcha = get_captcha('forgotpass');
        $data = array(
            'captcha' => $captcha['image']
        );
        $this->config->set_item("breadcrumb",array(array("name" => 'Quên mật khẩu')));
        $this->load->layout('users/forgot_pass',$data);
    }
    public function new_password(){
        if ($result === 'success') {
            return $this->load->layout('users/result',array('message' => 'Please relogin to accept of your changes'));
        }
        if ($this->permission->hasIdentity()){
            redirect(SITE_URL);
        }
        $user_id = (int) $this->input->get('user_id');
        $code = $this->input->get("code");
        $token = $this->input->get('token');
        // check token
        if ($token != md5($user_id.$code.$this->config->item('token_key_random'))) {
            return $this->output->set_output(json_encode(array('status' => 'error','message' => 'Mã bảo mật không chính xác')));
        }
        if ($this->input->post()){
            $this->load->library('form_validation');
            $valid = array(
                array(
                    'field'   => 'password',
                    'label'   => $this->lang->line('users_password'),
                    'rules'   => 'required|min_length[3]|max_length[40]'
                    ),
                array(
                    'field'   => 'repassword',
                    'label'   => $this->lang->line('users_password_confirm'),
                    'rules'   => 'required|matches[password]'
                    ),
                array(
                    'field'   => 'captcha',
                    'label'   => $this->lang->line('users_captcha'),
                    'rules'   => 'required|matches_str['.$this->session->userdata('register').']'
                    )
                );
            $this->form_validation->set_rules($valid);
            // get new captcha
            $this->load->helper('captcha');
            $captcha = get_captcha('register');
            //Csrf
            $csrf = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash(),
            );
            if ($this->form_validation->run() == true)
            {
                $this->load->model('users_model','users');
                // check code exist
                $arrCode = $this->users->getCode($user_id,2);
                if (!$arrCode || $arrCode['code'] !== $code) {
                    return $this->output->set_output(json_encode(array('status' => 'error','message' => array('code' => 'Mã kích hoạt không đúng'),'captcha' => $captcha['image'],'csrf_hash' => $csrf['hash'])));   
                }
                $userProfile = $this->users->getUserById($user_id);
                if (!$userProfile) {
                    return $this->output->set_output(json_encode(array('status' => 'error','message' => array('code' => 'Không tìm thấy thông tin thành viên'),'captcha' => $captcha['image'],'csrf_hash' => $csrf['hash'])));   
                }
                if ($userProfile['password'] == md5($this->input->post('password')) || $result = $this->users->updatePassword($user_id,$this->input->post("password"))) {
                    // set session
                    $this->permission->setIdentity($userProfile);
                    // delete code
                    $this->users->deleteCode($user_id,2);
                    return $this->output->set_output(json_encode(array('status' => 'success','user_id' => $user_id,'redirect_uri' => SITE_URL . '/users/new_password/success','csrf_hash' => $csrf['hash'])));
                }
                
                return $this->output->set_output(json_encode(array('status' => 'error','message' => array('password' => 'Có lỗi hệ thống vui lòng thử lại'),'captcha' => $captcha['image'],'csrf_hash' => $csrf['hash'])));      
            }
            else {
                return $this->output->set_output(json_encode(array('status' => 'error','message' => $this->form_validation->error_array(),'captcha' => $captcha['image'],'csrf_hash' => $csrf['hash'])));
            }
        }
        $this->load->helper('captcha');
        $captcha = get_captcha('register');
        $data = array(
            'captcha' => $captcha['image'],
            'redirect_uri' => urldecode($redirect_uri)
        );
        $this->config->set_item("breadcrumb",array(array("name" => 'Đặt lại mật khẩu')));
        $this->load->layout('users/new_pass',$data);
    }
/** ============================================= ACTIVE ================================ **/
    public function activecode($user = '',$code = ''){
        $token = $this->input->get('token');
        $user_id = $this->input->get('user_id');
        $code = $this->input->get('code');
        $type = $this->input->get('type');
        // check token 
        if ($token != md5($user_id.$code.$this->config->item('token_key_random'))) {
            return $this->load->layout('users/result',array('message' => 'Mã token không chính xác'));
        }
        // get model users
        $this->load->model('users_model','users');
        $arrCode = $this->users->getCode($user_id,$type);
        if (!$arrCode || $arrCode['code'] !== $code) {
            return $this->load->layout('users/result',array('message' => 'Mã kích hoạt không chính xác'));
        }
        switch ($type) {
            case 1:
                $this->users->activeUser($user_id);
                return $this->load->layout('users/result',array('message' => 'Success ! Your account has been activated'));
                break;
        }
    }
    public function social($type = ''){
        if ($type == 'facebook') {
            $this->load->library('Facebook');
            $helper = $this->facebook->getRedirectLoginHelper();
            if (!$this->input->get('code')) {
                $permissions = array('email', 'public_profile'); // optional
                $loginUrl = $helper->getLoginUrl(SITE_URL.'/users/social/facebook', $permissions);
                redirect($loginUrl);
            } else {
                try {
                    $accessToken = $helper->getAccessToken();
                } catch(Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                    echo 'Graph returned an error: ' . $e->getMessage();
                    exit;
                } catch(Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                    echo 'Facebook SDK returned an error: ' . $e->getMessage();
                    exit;
                }

                if (! isset($accessToken)) {
                    if ($helper->getError()) {
                        header('HTTP/1.0 401 Unauthorized');
                        echo "Error: " . $helper->getError() . "\n";
                        echo "Error Code: " . $helper->getErrorCode() . "\n";
                        echo "Error Reason: " . $helper->getErrorReason() . "\n";
                        echo "Error Description: " . $helper->getErrorDescription() . "\n";
                    } else {
                        header('HTTP/1.0 400 Bad Request');
                        echo 'Bad request';
                    }
                    exit;
                }
                $accessToken = $accessToken->getValue();

                try {
              // Returns a `Facebook\FacebookResponse` object
                    $response = $this->facebook->get('/me?fields=id,name,email', $accessToken);
                } catch(Facebook\Exceptions\FacebookResponseException $e) {
                    echo 'Graph returned an error: ' . $e->getMessage();
                    exit;
                } catch(Facebook\Exceptions\FacebookSDKException $e) {
                    echo 'Facebook SDK returned an error: ' . $e->getMessage();
                    exit;
                }

                $facebookUser = $response->getGraphUser();
                if (!$facebookUser['email']) {
                    echo 'Bạn cần phải public email chúng tôi mới có thể có thông tin'; exit;
                }
                $this->load->model('users_model','users');
                $profile = $this->users->getProfileByEmail($facebookUser['email']);
            // insert data
                if (!$profile){
                    $input = array(
                        'facebook_id' => $facebookUser['id'],
                        'fullname' => $facebookUser['name'],
                        'email' => $facebookUser['email'],
                        'active' => 1
                        );
                    $user_id = $this->users->updateProfileSocial($input);
                    $this->permission->setIdentity(array('user_id' => $user_id,'fullname' => $input['fullname'],'email' => $input['email']));
                    redirect(BASE_URL);
                }elseif ($profile['facebook_id'] != $facebookUser['id']) {
                    $input = array(
                        'facebook_id' => $facebookUser['id'],
                        'active' => 1
                        );
                    $this->users->updateProfileSocial($input,$profile['user_id']);
                    $this->permission->setIdentity($profile);
                    redirect(BASE_URL);
                }
                else {
                    die("ok");
                }
            }
        } elseif ($type == 'google') {
            $socialConfig = $this->config->item("social_app");

            $code = $this->input->get('code');
            // redirect to google account
            if (!$code) {
                redirect('https://accounts.google.com/o/oauth2/auth?client_id='. $socialConfig['google']['app_id'] .'&response_type=code&scope=email&redirect_uri='.urlencode(SITE_URL . '/users/social/google'));
            }
            // Get access token info
            $google_access_token_uri = 'https://accounts.google.com/o/oauth2/token';
            $postData = array(
                'client_id' => $socialConfig['google']['app_id'],
                'client_secret' => $socialConfig['google']['app_secret'],
                'redirect_uri' => SITE_URL . '/users/social/google',
                'grant_type' => 'authorization_code',
                'code' => $code
            );
            $this->load->library('Curl');
            $response = $this->curl->simple_post($google_access_token_uri , $postData); 
            if (!$response ) {
                die("Error: Code invalid");
            }
            $response = json_decode($response,TRUE);
            $access_token = $response['access_token'];
            if (!$access_token){
                die("Access token false");
            }
            // Get user's infomation
            $urlInfo = 'https://www.googleapis.com/plus/v1/people/me?access_token='.$access_token;
            $googleUser = $this->curl->simple_get($urlInfo);
            if (!$googleUser) {
                die("Error: Not get access token");
            }
            $googleUser = json_decode($googleUser,TRUE);
            if (!$googleUser['id']) {
                die("error");
            }
            if (!$googleUser['emails'][0]['value']) {
                echo 'You have to share your email'; exit;
            }
            $this->load->model('users_model','users');
            $profile = $this->users->getProfileByEmail($googleUser['emails'][0]['value']);
        // insert data
            if (!$profile){
                $input = array(
                    'google_id' => $googleUser['id'],
                    'fullname' => $googleUser['displayName'],
                    'email' => $googleUser['emails'][0]['value'],
                    'active' => 1
                    );
                $user_id = $this->users->updateProfileSocial($input);
                $this->permission->setIdentity(array('user_id' => $user_id,'fullname' => $input['fullname'],'email' => $input['email']));
                redirect(BASE_URL);
            }elseif ($profile['facebook_id'] != $googleUser['id']) {
                $input = array(
                    'google_id' => $googleUser['id'],
                    'active' => 1
                    );
                $this->users->updateProfileSocial($input,$profile['user_id']);
                $this->permission->setIdentity($profile);
                redirect(BASE_URL);
            }
            else {
                die("ok");
            }
        }
    }

    public function loginsocial($type){
        $this->load->library("Curl","curl");
        $this->load->model("users_model","users");

        $code = $this->input->get("code");
        $refer = ($this->input->get('state')) ? $this->input->get('state') : BASE_URL;
        if (!$code) {
            die("Lỗi kết nối");
        }
        if ($type == 'facebook') {
            $this->load->library('Curl', 'curl');
            // Get access token info
            $facebook_url = 'https://graph.facebook.com/oauth/access_token';
            $params = array(
              'client_id' => $this->config->item("facebook_app_id"),
              //'type'          => 'client_cred',
              'client_secret' => $this->config->item("facebook_app_secret"),
              'redirect_uri' => BASE_URL.'/users/loginsocial/facebook',
              'code' => $code
            );   
            $facebook_url = $facebook_url .'?'.http_build_query($params); 
            $response = $this->curl->simple_post($facebook_url);

            if (strpos($response, 'access_token') === false) {
                die("Lỗi không tạo được token key");
            }
            $access_token = @json_decode($response,TRUE);
            // Get user's infomation
            $urlInfo = 'https://graph.facebook.com/me?access_token='.$access_token['access_token'].'&fields=name,email,gender';

            $response = $this->curl->simple_post($urlInfo);

            // decode json user
            $facebookUser = json_decode($response,TRUE);
            if (!empty($facebookUser['error']) || empty($facebookUser['id'])) {
                die("Không tồn tại user này");
            }
            if (empty($facebookUser['email'])) {
                die("Bạn phải cho phép chúng tôi truy cập vào tài khoản email để tạo tài khoản");
            } 
            $input = array(
                'fullname' => $facebookUser['name'],
                'email' => $facebookUser['email'],
                'active' => 1,
                'facebook_id' => $facebookUser['id'],
                // 'social_type' => 1,
                'sex' => ($facebookUser['gender'] == 'male') ? 1 : 0,
                'create_time' => time(),
                // 'last_logined' => time(),
                'update_time' => time()
            );
            $userProfile = $this->users->insert_from_social($input);
            /// set session //
            $this->permission->setIdentity($userProfile);
            redirect($refer);
        }
        elseif ($type == 'google') {
            $google_access_token_uri = 'https://accounts.google.com/o/oauth2/token';
            $postData = array(
                'client_id' => $this->config->item("google_app_id"),
                'client_secret' => $this->config->item("google_app_secret"),
                'redirect_uri' => BASE_URL.'/users/loginsocial/google',
                'grant_type' => 'authorization_code',
                'code' => $code
            );
            $this->load->library('Curl', 'curl');
            $response = $this->curl->simple_post($google_access_token_uri, $postData);
            if (!$response) {
                die("Không tạo được token key");
            }

            $response     = json_decode($response, TRUE);
            $access_token = $response['access_token'];
            if (!$access_token) {
                die("token key lỗi");
            }
            // Get user's infomation
            $urlInfo    = 'https://www.googleapis.com/plus/v1/people/me?access_token=' . $access_token;
            $googleUser = $this->curl->simple_get($urlInfo);
            if (!$googleUser) {
                die("không tôn tại user này");
            }
            $googleUser = json_decode($googleUser, TRUE);
            if (!$googleUser['id'] || !$googleUser['emails'][0]['value']) {
                die("Bạn phải public email để chúng tôi có thể xác minh tài khoản");
            }

            $input       = array(
                'fullname' => $googleUser['displayName'] ? $googleUser['displayName'] : explode("@", $googleUser['emails'][0]['value'])[0],
                'email' => $googleUser['emails'][0]['value'],
                'active' => 1,
                'google_id' => $googleUser['id'],
                // 'social_type' => 2,
                'sex' => ($googleUser['gender'] == 'male') ? 1 : 0,
                'create_time' => time(),
                // 'last_logined' => time(),
                'update_time' => time()
            );
            
            $userProfile = $this->users->insert_from_social($input);
            /// set session //
            $this->permission->setIdentity($userProfile);

            redirect($refer);
        }
    }

    public function upload_Mp3(){
        $config['upload_path']          = 'uploads/sound_user/';
        $config['allowed_types']        = '*';
        $config['max_size']             = 1024000; // KB
        $this->load->library('upload', $config);

        // File name
        $timeNow = time();
        $randomStr = $this->generateRandomString(10);
        $fileName = $randomStr.$timeNow;
        $config['file_name']             = $fileName.'.wav'; // lấy tên File

        $this->upload->initialize($config); // Load lại config vì trong đó có file name mới


        if ( ! $this->upload->do_upload('blob_file'))
        {
            $error = array('error' => $this->upload->display_errors());
            echo json_encode($error);
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $ret = [];
            array_push($ret,$data['upload_data']['file_name']);
            // $config['upload_path'] = 'uploads/sound_user/';
            echo json_encode($ret);
        }
    }

    public function del_Mp3(){
        if ($this->input->post('del_mp3') == 'del_temp'){
            $file_name = $this->input->post('file_name');
            $myFile = 'uploads/sound_user/'.$file_name;
            unlink($myFile) or die("Couldn't delete file");
            echo 'success deleted '.$file_name;
        }
    }

    private function generateRandomString($length = 10) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function changeImage()
    {


        $profile = $this->permission->getIdentity();
        if ($profile){

        }else{
            $redirect_uri = current_url();
            if($queryString = $_SERVER['QUERY_STRING']){
                $redirect_uri .= '?'.$queryString;
            }
            $redirect_uri = SITE_URL.'/users/login?redirect_uri='.urlencode($redirect_uri);
            redirect($redirect_uri);
        }

            switch ($_REQUEST['type']) {
                case "avarta":
                    // Các thuộc tính ratio, kích thước tối thiểu được set trong JS, file main.js
                    $typeCode = 'avarta';
                    $type_text = "Thay đổi Ảnh đại diện";
                    break;
                case "cover":
                    // Các thuộc tính ratio, kích thước tối thiểu được set trong JS, file main.js
                    $typeCode = 'cover';
                    $type_text = "Thay đổi Ảnh bìa";
                    break;
                case "profile":
                    $typeCode = 'profile';
                    $type_text = "Thay đổi Ảnh hồ sơ";
                    break;
                default:
                    $typeCode = 'avarta';
                    $type_text = "Thay đổi Ảnh đại diện";
                    break;

            }

            $data['typeCode'] = $typeCode;
            $data['type_text'] = $type_text;

            $this->load->view('users/changeImage', $data,false);
    }


    public function upload_pic_crop()
    {

        $profile = $this->permission->getIdentity();
        if ($profile){

        }else{
            echo 'Wrong Identity'; exit;
        }
        $user_id = $profile['user_id'];


        {
            $config['upload_path']          = 'uploads/images/avarta';
            $config['allowed_types']        = 'gif|jpg|png|jpeg|GIF|JPG|PNG|JPEG';
            // Nếu ko có phần viết hoa sẽ lỗi khi upload từ hệ điều hành IOS
            $config['max_size']             = 1024000; // KB
            $this->load->library('upload', $config);
        }

        // File name
        $timeNow = time();
        $randomStr = $this->generateRandomString(15);
        $fileName = $randomStr.$timeNow;
        $config['file_name']             = $fileName; // lấy tên File

        $this->upload->initialize($config); // Load lại config vì trong đó có file name mới

        if ( ! $this->upload->do_upload('INPUT_FILE_NAME'))
        {
            $error = array('error' => $this->upload->display_errors());
            var_dump($error);
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $ret = [];
            array_push($ret,$data['upload_data']['file_name']);

            // Tạo key Passcode
            $key_passCode = md5('Passcode_img'.$data['upload_data']['file_name']."A".$user_id);

            array_push($ret,$key_passCode);
            echo json_encode($ret);

        }
    }

    public function crop_pic_basic_Cl() //Cl - Client
    {
        $profile = $this->permission->getIdentity();
        if ($profile){

        }else{
            echo 'Wrong Identity'; exit;
        }
        $user_id = $profile['user_id'];

        $typeCode = $_REQUEST["typeCode"];

        $passCode = $_REQUEST["passCode"];
        $src_name = $_REQUEST["src_name"];
        $dataWidth = $_REQUEST["dataWidth"];
        $dataHeight = $_REQUEST["dataHeight"];
        $dataX = $_REQUEST["dataX"];
        $dataY = $_REQUEST["dataY"];

//         Check pass code
        $passCode_shadow = md5('Passcode_img'.$src_name."A".$user_id);

        if ($passCode !== $passCode_shadow)
        {
            echo "Passcode wrong !";
            exit();
        }

        $pathOldFile = './uploads/images/avarta/'.$src_name;
        $new_file_name = "crop_new_".$src_name;
        $pathNewFile = './uploads/images/avarta/crop/'.$new_file_name;

        $res_crop = $this->resize_prep($pathOldFile,$pathNewFile,$dataX,$dataY,$dataWidth,$dataHeight);
        if ($res_crop !== true)
        {
            var_dump($res_crop);
            exit();
        }

        // change avarta
        $full_img_path = $pathNewFile;
        $this->load->model('Users_model','users');
        $this->users->setUserAvatar($user_id,$new_file_name);

        echo json_encode(array(true,$full_img_path)); // $new_file_name


//        switch ($typeCode)
//        {
//            case "avarta":
//                break;
//            case "cover":
//                break;
//            case "formal_avarta":
//                break;
//            default:
//        }

    }

    private function resize_prep($path_old_file, $path_new_file,$X_coor,$Y_coor,$width,$height){
        $this->load->library('image_lib');
//        $config['image_library'] = 'imagemagick';
        $config['image_library'] = 'gd2';
        $config['library_path'] = '/usr/bin';
        $config['source_image'] = $path_old_file;
        $config['create_thumb'] = FALSE;
        $config['maintain_ratio'] = FALSE;
        $config['x_axis'] = $X_coor;
        $config['y_axis'] = $Y_coor;
        $config['width'] = $width;
        $config['height'] = $height;
        $config['new_image'] = $path_new_file; // new filename

        $this->image_lib->initialize($config);

        if (!$this->image_lib->crop()){
            return $this->image_lib->display_errors();
        }else{
            return true;
        }
    }


}