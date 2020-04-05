<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users_model extends CI_Model {
    private $_table_member = 'users';
    private $_table_member_active = 'users_active';
    private $_table_users_to_class = 'users_to_class';
    function __construct()
    {
        parent::__construct();
    }
/** =================================== LOGIN ========================================= **/
    /**
    * @author: namtq
    * @todo: Get profile by email
    * @param: array(email) 
    */
    public function getProfileByEmail($email,$option = array()){
        $this->db->where('email',$email);
        if (isset($option['active'])) {
            $this->db->where('active',$option['active']);
        }
        $query =  $this->db->get($this->_table_member);
        return $query->row_array();
    }
    /**
    * @author: namtq
    * @todo: Get profile by id
    * @param: user_id int
    */
    public function getUserById($user_id,$option = array()){
        $this->db->where('user_id',$user_id);
        if (isset($option['active'])) {
            $this->db->where('active',1);
        }
        $query =  $this->db->get($this->_table_member);
        $result = $query->row_array();

        $result['avatar'] = getAvatarLink($result['avatar']);


        return $result;
    }
    /** 
    * @author: namtq
    * @param: array() profile, code random string
    * @todo: register user and send token
    * @return: user_id (int)
    */
    public function register($input = ''){
        $input = array(
            'fullname' => $input['fullname'],
            'email' => $input['email'],
            'address' => $input['address'],
            'phone' => $input['phone'],
            'password' => hash('sha256',$input['password']),
            'active' => (int) $input['active'],
            'sex' => (int) $input['sex'],
            'city_id' => (int) $input['city_id'],
            'birthday' => $input['birthday'],
            'create_time' => time(),
            'update_time' => time()
        );
        $this->db->insert($this->_table_member,$input);
        $user_id = $this->db->insert_id();
        return $user_id;
    }
    /** 
    * @author: namtq
    * @param: user_id int, type int (1: active, 2: forgot password)
    * @todo: generate random key and save
    * @return: code
    */
    public function sendCode($user_id,$type = 1) {
        $this->load->helper('string');
        $code = random_string('md5');
        $active = array(
            'user_id' => $user_id,
            'create_time' => time(),
            'code' => $code,
            'type' => $type
        );
        // count to check
        $this->db->where('type',$type);
        $this->db->where('user_id',$user_id);
        $count = $this->db->count_all_results($this->_table_member_active);
        if ($count > 0) {
            // update if existed
            $this->db->where('type',$type);
            $this->db->where('user_id',$user_id);
            $this->db->update($this->_table_member_active,$active);
        }
        else {
            $this->db->insert($this->_table_member_active,$active);
        }
        
        return $code;
    }
    /** 
    * @author: namtq
    * @param: user_id int, type int (1: active, 2: forgot password)
    * @todo: Check code exists
    * @return: int
    */
    public function getCode($user_id,$type, $option = array()) {
        $this->db->where('type',$type);
        $this->db->where('user_id',$user_id);
        $query = $this->db->get($this->_table_member_active);
        return $query->row_array();
    }
    /** 
    * @author: namtq
    * @param: user_id int, type int (1: active, 2: forgot password)
    * @todo: delete active code
    */
    public function deleteCode($user_id,$type) {
        $this->db->where('user_id',$user_id);
        $this->db->where('type',$type);
        $this->db->delete($this->_table_member_active);
    }
    // kiem tra user da dang nhap lop hoc chua
    public function check_class_login($username,$password){
        $this->db->where("username",$username);
        $this->db->where("password",base64_encode($password));
        $query = $this->db->get("class",1);
        return $query->row_array();
    }
    /** 
    * @author: namtq
    * @param: user_id int, profile array()
    * @todo: Update profile data
    * @return: 0 or 1
    */
    public function updateProfile($user_id, $profile = array()){
        if (!$user_id) {
            return false;
        }
        $input = array(
            'fullname' => $profile['fullname'],
            'address' => $profile['address'],
            'sex' => (int) $profile['sex'],
            'phone' => $profile['phone'],
            'birthday' => $profile['birthday'],
            'city_id' => $profile['city_id'],
            'update_time' => time(),
        );
        $this->db->where('user_id',$user_id);
        $this->db->update($this->_table_member,$input);
        return $this->db->affected_rows();
    }
    /** 
    * @author: namtq
    * @param: user_id int, profile array()
    * @todo: Update profile data by social
    * @return: 0 or 1
    */
    public function updateProfileSocial($input,$user_id = 0) {
        if (!$user_id) {
            $input = array_merge($input,array(
                'create_time' => time(),
                'update_time' => time()
            ));
            $this->db->insert($this->_table_member,$input);
            $user_id = $this->db->insert_id();
            return $user_id;
        }
        else {
            $this->db->where('user_id',$user_id);
            $this->db->update($this->_table_member,$input);
            return $this->db->affected_rows();
        }
        
    }
    /** 
    * @author: namtq
    * @param: user_id int, password string
    * @todo: Update password profile
    * @return: 0 or 1
    */
    public function updatePassword($user_id, $new_password){
        $this->db->set("password",hash('sha256',$new_password));
        $this->db->where('user_id',$user_id);
        $this->db->update($this->_table_member,$input);
        return $this->db->affected_rows();
    }
    /** 
    * @author: namtq
    * @param: user_id int, profile array()
    * @todo: Update profile data
    * @return: 0 or 1
    */
    public function activeUser($user_id) {
        $this->db->set('active',1);
        $this->db->where('user_id',$user_id);
        $this->db->update($this->_table_member);
        $affect =  $this->db->affected_rows();
        if ($affect > 0) {
            // delete code active
            $this->deleteCode($user_id,1);
        }
        return $affect;
    }

    public function getCity(){
        $this->db->order_by('name','ASC');
        $query = $this->db->get('city');
        return $query->result_array();
    }

    public function get_user_by_email($email) {
        //$this->db->select();
        $this->db->where('email',$email);
        $query = $this->db->get($this->_table_member);
        return $query->row_array();
    }
    public function insert_from_social($input) {
        $userProfile = $this->get_user_by_email($input['email']);
        // neu user da ton tai
        if ($userProfile) {
            // update active
            if ($userProfile['active'] == 0) {
                $this->activeUser($userProfile['user_id']);
            }
            return $userProfile;
        }
        // insert user
        else {
            $this->db->insert($this->_table_member,$input);
            $userid = (int)$this->db->insert_id();
            return $this->getUserById($userid,array('active' => 1));
        }
    }
    public function update_old_users($userId,$password) {
        $this->db->set('username','');
        $this->db->set('password',hash('sha256',$password));
        $this->db->where('user_id',$userId);
        $this->db->update('users');
        return $this->db->affected_rows();
    }

    public function save_users_to_class($user_id, $class_id){
        if($this->check_users_to_class($user_id, $class_id)){
            return TRUE;
        }
        $input = array(
            'user_id' => $user_id,
            'class_id' => $class_id
        );
        $this->db->insert($this->_table_users_to_class, $input);
        return $this->db->insert_id();
    }

    private function check_users_to_class($user_id, $class_id){
        $this->db->where('user_id', $user_id);
        $this->db->where('class_id', $class_id);
        $query = $this->db->get($this->_table_users_to_class);
        return $query->row_array();
    }

    public function setUserAvatar($user_id, $avatar){
        $this->db->where('user_id', $user_id);
        $this->db->set('avatar', $avatar);
        $this->db->update('users');
    }
}