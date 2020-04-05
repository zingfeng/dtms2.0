<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Bootstrap {
	var $obj;
	private $_cpanel = '';
	function __construct() {
		$this->obj = &get_instance();
		$this->setdefine();
		$this->setconfig();
	}
	function setconfig() {
		$cp = trim($this->obj->router->directory, '/');
		$this->_cpanel = $cp;
		/////////// kiem tra permission ////////////

		$this->obj->config->set_item("index_page", $cp);
		$this->obj->config->set_item("default_lang", $this->obj->config->item("language"));
		define("SITE_URL", trim(site_url(), '/'));
		switch ($cp) {
		case 'admin':
			define('CPANEL', 'backend');
			$this->obj->load->library("permission", array('cpanel' => CPANEL));
			$this->backend();
			break;
		default:
			define('CPANEL', 'frontend');
			$this->obj->load->library("permission", array('cpanel' => CPANEL));
			$this->frontend();
		}
		$this->obj->config->set_item('layout', 'layout');
		$theme = FOLDER_VIEW . '/' . $this->obj->config->item("theme");
		$this->obj->config->set_item('img', STATIC_URL . 'theme/' . $theme . '/images/');
		$this->obj->config->set_item('js', STATIC_URL . 'theme/' . $theme . '/js/');
		$this->obj->config->set_item('css', STATIC_URL . 'theme/' . $theme . '/css/');
		$this->obj->config->set_item('font', STATIC_URL . 'theme/' . $theme . '/fonts/');
		$this->obj->config->set_item('theme', STATIC_URL . 'theme/' . $theme . '/');
		$this->obj->config->set_item('lib', STATIC_URL . 'theme/' . $theme . '/lib/');
	}
	// config cho FE
	function frontend() {

		$lang = $this->obj->input->get("lang");
		$multi_lang = $this->obj->config->item("multilang");
		/////////// set ngon ngu cho website
		if ($lang && array_key_exists($lang, $multi_lang)) {
			// lang same default lang
			if ($lang == $this->obj->config->item("language")) {
				redirect(uri_string(), 'location', 301);
			}
			$this->obj->config->set_item("index_page", $lang);
			$this->obj->config->set_item("language", $lang);
			$this->obj->config->set_item("lang", $multi_lang[$lang]);
		} else {
			$this->obj->config->set_item("lang", 1);
		}
		// detect device ///
		if (!$this->obj->session->userdata("device_env")) {
			$this->obj->load->library('user_agent');
			if ($this->obj->agent->is_mobile()) {
				$this->obj->session->set_userdata('device_env', 1);
			} else {
				$this->obj->session->set_userdata('device_env', 4);
			}
		}
		//define('DEVICE_ENV', 1);
		define('DEVICE_ENV', $this->obj->session->userdata('device_env'));
		////////////////////////////////
		define("FOLDER_VIEW", 'frontend');

		$this->obj->load->driver('cache', array('backup' => 'file'));
		$this->setting();
		$this->obj->config->set_item("menu_selected", array());

		$meta_seo = array(
			'seo_title' => $this->obj->config->item("seo_title"),
		);
		$this->obj->load->setData($meta_seo);
		$this->obj->load->setData('meta', array(
			'keyword' => $this->obj->config->item("seo_keyword"),
			'description' => $this->obj->config->item("seo_description"),
		));
		$this->obj->lang->load('frontend/common');
	}
	// config cho backend
	function backend() {
		$oauthConfig = $this->obj->config->item("web4u_oauth");
		if (!$this->obj->permission->hasIdentity() && ENVIRONMENT == 'development') {
			$this->obj->permission->setIdentity(array('user_id' => 48, 'site_role' => 'root'));
		}
		if (!$this->obj->permission->hasIdentity() && ($this->obj->router->class != 'users' || $this->obj->router->method != 'login')) {
			$session_id = session_id();
			redirect($oauthConfig['site'] . '/oauth/code?response_type=code&client_id=' . $oauthConfig['client_id'] . '&scope=email,profile,site_role&redirect_uri=' . urlencode(SITE_URL . '/users/login') . '&state=' . $session_id);
		}
		$this->obj->config->set_item("language", "vi");
		$lang = $this->obj->input->get("lang");
		$multi_lang = $this->obj->config->item("multilang");
		/////////// set ngon ngu cho website
		if ($lang && array_key_exists($lang, $multi_lang)) {
			$this->obj->session->set_userdata("lang", $multi_lang[$lang]);
			redirect(site_url());
		}
		if (!$this->obj->session->userdata("lang")) {
			$default_lang = $this->obj->config->item("default_lang");
			$this->obj->session->set_userdata("lang", $multi_lang[$default_lang]);
		}
		define("FOLDER_VIEW", 'backend');
		$this->obj->lang->load('backend/common');
		$this->obj->config->load('backend');
		$this->obj->config->load('data');

		$check = $this->obj->permission->check_permission_backend();
		if ($check == false) {
			die("Access Denied");
		}
		$this->obj->load->helper('admin_temp');
		$this->obj->load->setData('title', 'CDC Online Technology., JSC');
	}
	function setting() {
		$CI = &get_instance();
		$CI->load->model('common_model', 'common');
		$row = $CI->common->set_setting();
		if (!empty($row)) {
			foreach ($row as $key => $value) {
				$CI->config->set_item($key, $value);
			}
		}
		if (ENVIRONMENT == 'production') {
			$CI->load->library("statistic");
			$CI->config->set_item("hit_counter", $CI->statistic->hit_counter());
		}
	}
	function setdefine() {
		define("BASE_URL", trim(base_url(), '/'));
		define("UPLOAD_URL", BASE_URL . '/uploads/');
		// if(ip2long($_SERVER['REMOTE_ADDR']) % 10 <= 3) {
		// 	define("STATIC_URL", 'https://static1.aland.edu.vn/');
		// }elseif(ip2long($_SERVER['REMOTE_ADDR']) % 10 <= 6){
		// 	define("STATIC_URL", 'https://static2.aland.edu.vn/');
		// }else{
		// 	define("STATIC_URL", base_url());
		// }
		define("STATIC_URL", base_url());
		define("SITE_ID", 1);
	}
}