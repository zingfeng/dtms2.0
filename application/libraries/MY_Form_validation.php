<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Form_validation extends CI_Form_validation{
	protected $_error_prefix			= '<div class="form_error">';
	protected $_error_suffix			= '</div>';
	public function is_spaces($str){
		return (strpos($str,' ') === false) ? true : false;
	}
	public function matches_str($str,$code){
		return ($str !== $code) ? FALSE : TRUE;
	}
}
?>