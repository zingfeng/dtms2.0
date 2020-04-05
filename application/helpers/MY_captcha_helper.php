<?php
function get_captcha($name = 'captcha', $params = array()){
    $CI = &get_instance();
    $defaults = array('word' => substr(sha1(mt_rand()), 17, 4), 'img_path' => FCPATH.'captcha/', 'img_url' => base_url().'captcha/', 'img_width' => '90', 'img_height' => '30', 'font_path' => realpath('.'). '/'. SYSDIR.'/fonts/tahoma.ttf', 'expiration' => 7200
    	);
    //var_dump($defaults); die;

    $params = array_merge($defaults,$params);

    $CI->session->set_userdata($name,$params['word']);
    return create_captcha ($params);
}
function generateToken($key) {
	$CI = &get_instance();
    // generate a token from an unique value
	$token = md5($key.uniqid(microtime(), true));  
	// Write the generated token to the session variable to check it against the hidden field when the form is sent
	$CI->session->set_userdata('token_'.$key,$token); 
	return $token;
}
function verifyToken($key,$value) {
	$CI = &get_instance();
	return ($CI->session->userdata('token_'.$key) == $value) ? true : false;
}
