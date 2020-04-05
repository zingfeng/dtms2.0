<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class MY_Loader extends CI_Loader{
	var $_queue = array();
    var $_registry = array();
	var $data = array();
    var $position = array();
    protected $_block;
	function __construct(){
		parent::__construct();
		$ci                      = get_instance();
        $class                   = strtolower(get_class($ci));
        $this->_registry[$class] = &$ci;
        $this->_queue[]          = &$this->_registry[$class];
 	}
    function layout($view, $data=null, $return = FALSE, $layout = '')
    {
    	$CI = &get_instance();
        //// load block ////
        if (CPANEL == 'frontend') {
            $CI->load->model('common_model','common');
            $CI->common->get_all_block();
        }
        
        ///////////////////
		if ($view != ''){
			$this->data['content_for_layout'] = $this->view($view,$data,true);
		}
		else{
			$this->data['content_for_layout'] = $data;
		}
        //$this->controller('common/index');
		if ($layout == ''){
            $layout = $CI->config->item('layout');
		}
        $this->view($layout , $this->data, false);
        if (ENVIRONMENT == 'development'){
            $sections = array(
                'config'  => false,
                'http_headers' => false,
                'query_toggle_count' => 50
                );

            $CI->output->set_profiler_sections($sections);
            $CI->output->enable_profiler(true);
        }
    }
    function view($view, $vars = array(), $return = TRUE)
	{
		$CI = &get_instance();
		$view = FOLDER_VIEW.'/'.$view;
		return $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_prepare_view_vars($vars), '_ci_return' => $return));
	}
    /**
     * $potion = array(
	 * 			'left' => 'data_left'),
	 * 			'right => 'data_right'
	 * 			);
     */
    function setData($position,$data = ''){
    	if (is_array($position)){
    		foreach ($position as $key => $value){
                $this->data[$key] = (array_key_exists($key,$this->position)) ? $this->position[$key] : $value;
    		}
    	}
    	else{
    	   $this->data[$position] = (array_key_exists($position,$this->position)) ? $this->position[$position] :  $data;
   	    }
    }
    /**
     * $pre: TRUE, FALSE - Position push data on array() - default end
     */
    function setArray($position,$data = array(),$pre = FALSE){

        if (is_array($position)){
            foreach ($position as $key => $value){
                $this->setArray($key,$value);
            }
            return true;
        }

        if (array_key_exists($position,$this->data)){
            //echo 456;
            $d = $this->data[$position];
            if (!is_array($d)){
                $d = array($d);
            }
            if ($pre == TRUE){
                array_unshift($d,$data);
            }
            else{
                array_push($d,$data);
            }
            $this->data[$position] = $d;
        }
        else{
            $this->data[$position] = array($data);
        }
    }
    public function get_block($position){
        return get_array($this->data[$position]);
    }
    function push_section($position, $namespane ,$value) {
        $this->section[$position][$namespane] = $value;
    }
    function get_section($position) {
        $arrSection = $this->section[$position];
        $str = '';
        if ($arrSection)
        foreach ($arrSection as $key => $value) {
            $str .= $value;
        }
        return $str;
    }
}