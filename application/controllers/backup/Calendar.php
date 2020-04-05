<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Calendar extends CI_Controller{
    function __construct(){
		parent::__construct();
        $this->lang->load('frontend/module');

        $this->config->set_item("breadcrumb",array(array("name" => "Lịch học")));
        $this->config->set_item("menu_select",array('item_mod' => 'calendar', 'item_id' => 0));
        $this->config->set_item("mod_access",array("name" => "calendar"));
	}
    public function register() {
        if (!$this->input->post('submit')) {
            return $this->output->set_output(json_encode(array('status' => 'error','message' => 'Chưa nhập thông tin')));
        }
        $this->load->library('form_validation');
        $valid = array(
            array(
                'field'   => 'fullname',
                'label'   => $this->lang->line('contact_fullname'),
                'rules'   => 'required'
                ),
            array(
                'field'   => 'phone',
                'label'   => $this->lang->line('contact_phone'),
                'rules'   => 'required|numeric'
                ),
            array(
                'field'   => 'captcha',
                'label'   => $this->lang->line('contact_captcha'),
                'rules'   => 'required|matches_str['.$this->session->userdata('contact_captcha').']'
                ),

        );
        $this->form_validation->set_rules($valid);
        if ($this->form_validation->run()){
            $input = array(
                'calendar_id' => $this->input->post('calendar_id'),
                'location_id' => $this->input->post('location_id'),
                'fullname' => $this->input->post('fullname'),
                'phone' => $this->input->post('phone')
            );
            $this->load->model('calendar_model','calendar');
            $this->calendar->insert($input);
            // render captcha
            $this->load->helper('captcha');
            $captcha = get_captcha("contact_captcha");
            // 
            return $this->output->set_output(json_encode(array('status' => 'success','captcha' => $captcha['image'],'message' => 'Gửi thông tin thành công')));
        }
        else {
            // render captcha
            $this->load->helper('captcha');
            $captcha = get_captcha("contact_captcha");
            return $this->output->set_output(json_encode(array('status' => 'error','valid_rule' => $this->form_validation->error_array(),'captcha' => $captcha['image'], 'message' => $this->lang->line("common_update_validator_error"))));
        }
    }
    public function index(){
    	$this->load->config('data');
    	$this->load->model('calendar_model','calendar');
        $this->load->model('news_model','news');
    	$rows = $this->calendar->get_all();
    	foreach ($rows as $key => $row) {
    		$arrCalendar[$row['location']][] = $row;
    	}
        // get calendar khoa hoc
        $course = $this->news->get_category(array('parent' => 0, 'style' => 4));
        foreach ($course as $key => $course) {
            $arrCourse[$course['cate_id']] = $course;
        }
        // render captcha
        $this->load->helper('captcha');
        $captcha = get_captcha("contact_captcha");
    	$data = array(
    		'rows' => $arrCalendar,
    		'arrLocation' => $this->config->item('brand_location'),
            'captcha' => $captcha['image'],
            'arrCourse' => $arrCourse
    	);
        $this->load->layout('calendar/index',$data);
    }
}
