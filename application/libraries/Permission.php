<?php class Permission {
    private $_router = array();
    private $_cache_allow = array();
    private $_instance = null;
    private $_identity_name = '_user_identity';
    private $_identity_class_name = '_user_class_identity';
    function __construct($params = array()){
        if (!$params['cpanel']) {
            show_error('Permission not set cpanel');
        }
        $this->_identity_name = $params['cpanel'].$this->_identity_name;
        $CI = &get_instance();
        $this->_instance = $CI;
        $this->_router = array('class' => $CI->router->class, "function" => $CI->router->method);
    }
    public function get_user_id() {
        $CI = $this->_instance;
        $profile = $CI->session->userdata($this->_identity_name);
        return $profile['user_id'];
    }
    public function clearIdentity($id = '') {
        $CI = $this->_instance;
        if ($id == 'class') {
            $CI->session->unset_userdata($this->_identity_class_name);
        }
        else {
            $CI->session->unset_userdata($this->_identity_name);
        }
    }
    public function hasIdentity($id = ''){
        $CI = $this->_instance;
        if ($id == 'class') {
            return $CI->session->has_userdata($this->_identity_class_name);
        }
        else {
            return $CI->session->has_userdata($this->_identity_name);
        }
    }
    public function getIdentity(){
        $CI = $this->_instance;
        return $CI->session->userdata($this->_identity_name);
    }
    public function setIdentity($profile = array()){
        $CI = $this->_instance;
        $profile_session = array(
            'user_id' => $profile['user_id'],
            'fullname' => $profile['fullname'],
            'email' => $profile['email'],
            'avatar' => getAvatarLink($profile['avatar']),
        );
        if ($profile['site_role']) {
            $profile_session['site_role'] = $profile['site_role'];
        }
        if ($profile['permission']) {
            $profile_session['permission'] = $profile['permission'];
            $profile_session['role'] = $profile['role'];
        }
        if ($profile['access_token']) {
            $profile_session['access_token'] = $profile['access_token'];
        }
        return $CI->session->set_userdata($this->_identity_name,$profile_session);
    }
    public function setClassIdentity($profile = array()){
        $CI = $this->_instance;
        $profile_session = array(
            'class_id' => $profile['class_id'],
            'name' => $profile['name']
        );
        return $CI->session->set_userdata($this->_identity_class_name,$profile);
    }
    public function getClassIdentity(){
        $CI = &get_instance();
        if (!$this->hasIdentity()){
            redirect('users/login?redirect_uri='.urlencode(current_url()));
        }
        if ($class_id = $CI->session->userdata($this->_identity_class_name)) {
            return $class_id;
        }
        else {
            return redirect('users/class_login?redirect_uri='.urlencode(current_url()));
        }
    }
    public function getId() {
        $CI = $this->_instance;
        $userData = $this->getIdentity();
        return $userData['user_id'];
    }
    /**
     * @desc: Check permission of action
     * @param: namtq
     */
    public function check_permission_backend($input = ''){
        // check root
        $profile = $this->getIdentity();
        if ($profile['site_role'] === 'root') {
            return true;
        }
        // set function & class
        $function = $this->_router['function'];
        $class = $this->_router['class'];
        if ($input && !is_array($input)) {
            $function = $input;
        }
        else {
            if (isset($input['function'])) $function = $input['function'];
            if (isset($input['function'])) $class = $input['class'];
        }
        // caching 
        if (isset($this->_cache_allow[$class][$function])) {
            return true;
        }
        // check user session ignore login page
        if ($class == 'users' && in_array($function, array('login','logout'))) {
            return true;
        }
        if ($profile['permission'] && $class == 'users' && in_array($function, array('dashboard'))) {
            return true;
        }
        // get level of user
        $userLevel = $this->get_level_user($class);
        if (!$userLevel) {
            return false;
        }
        
        // get role of system
        $arrFunction = $this->get_permission_by_level($userLevel,$class);
        //var_dump($class,$permission,$arrFunction); die;
        if (in_array($function, $arrFunction)) {
            $this->_cache_allow[$class][$function] = 1;
            return true;
        }
        return false;
    }
    /**
     * @desc: Check permission of module
     * @author: namtq
     * @param: class name
     */
    public function has_level_user($module = '') {
        $module = ($module) ? $module : $this->_router['class'];
        $profile = $this->getIdentity();
        if ($profile['site_role'] === 'root') {
            return true;
        }
        return isset($profile['permission'][$module]);
    }
    /**
     * @todo: get permission of module
     * @author: namtq
     * @param: class name
     */
    public function get_level_user($module = '') {
        $module = ($module) ? $module : $this->_router['class'];
        $profile = $this->getIdentity();
        return $profile['permission'][$module];
    }
    /**
     * @todo: get all function member is accessed
     * @author: namtq
     * @param: class name / level of member
     */
    private function get_permission_by_level($level, $module = '') {
        $module = ($module) ? $module : $this->_router['class'];
        $level = (int) $level;
        $rolesSystem = $this->_instance->config->item("admin_role");
        $rolesSystem = $rolesSystem[$module];
        $arrFunction = array();
        for ($i = 1; $i <= $level; $i ++) {
            $arr = (is_array($rolesSystem['permission'][$i]['permission'])) ? $rolesSystem['permission'][$i]['permission'] : array($rolesSystem['permission'][$i]['permission']);
            $arrFunction = array_merge($arrFunction,$arr);
        }
        return $arrFunction;
    }
}
?>