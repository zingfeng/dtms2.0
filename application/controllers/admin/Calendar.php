<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Calendar extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->setData('title','Lịch học');
		$this->load->config('data');
	}
	public function register(){
		$limit = 20;
		$this->load->model('admin/calendar_model','calendar');
		if ($this->input->post('delete') && $this->input->post('cid') && $this->permission->check_permission_backend(array('function'=>'register')))
		{
			$this->calendar->delete_register();
		}
		if ($this->input->post('change_status') && $this->input->post('cid') && $this->permission->check_permission_backend(array('function'=>'register')))
		{
			$this->calendar->change_status();
		}
		
		/** FILTER **/
		$this->load->helper('form');
        $arrLocation[0] = 'Địa điểm học';
        $arrLocation = array_merge($arrLocation,$this->config->item("brand_location"));
        $filter['data'][] = form_dropdown('location',$arrLocation,$this->input->get('location'));
        $data['filter'] = $this->load->view("common/data_filter",$filter);
        /** PAGING **/
        $rows = $this->calendar->register_lists($limit);
        $config['total_rows'] = count($rows);
  		$config['per_page'] = $limit;
  		$this->load->library('paging',$config);
  		$data['paging'] = $this->paging->create_links();
        /** DATA **/
        unset($rows[$limit]);
        $data['row'] = $rows;
        foreach ($rows as $key => $row) {
        	$arrCalendar[] = $row['calendar_id'];
        }
        if ($arrCalendar) {
        	$arrCal = $this->calendar->get_calendar_by_id($arrCalendar);
        	foreach ($arrCal as $key => $arrCal) {
        		$data['arrCalendar'][$arrCal['calendar_id']] = $arrCal;
        	}
        	
        }
		$this->load->layout('calendar/register',$data);
	}
	public function index(){
		$limit = 20;
		$this->load->model('admin/calendar_model','calendar');
		if ($this->input->post('delete') && $this->input->post('cid') && $this->permission->check_permission_backend(array('function'=>'delete')))
		{
			$this->calendar->delete();
		}
		/** FILTER **/
		$this->load->helper('form');
        $arrLocation[0] = 'Địa điểm học';
        $arrLocation = array_merge($arrLocation,$this->config->item("brand_location"));
        $filter['data'][] = form_dropdown('location',$arrLocation,$this->input->get('location'));
        $data['filter'] = $this->load->view("common/data_filter",$filter);
        /** PAGING **/
        $data['row'] = $this->calendar->lists($limit);
        $config['total_rows'] = count($data['row']);
  		$config['per_page'] = $limit;
  		$this->load->library('paging',$config);
  		$data['paging'] = $this->paging->create_links();
        /** DATA **/
        unset($data['row'][$limit]);
		$this->load->layout('calendar/list',$data);
	}
	public function add(){
		$this->load->model('admin/calendar_model','calendar');
		if ($this->input->post('adv_submit')){
            $this->_validation($rq);
			if ($this->form_validation->run() == true)
			{
				//for ($i=0; $i < 10; $i++) 
                $this->calendar->insert();
                $this->session->set_userdata('success','add');
                redirect('calendar/add');
			}
		}
		$row = set_array(array('start_time'=>time()));
		$data = $this->_form($row);
		$this->load->layout('calendar/form',$data);
	}
	public function edit($id = 0){
		if ($id <= 0 OR !is_numeric($id)){
			show_404();
		}
		$this->load->model('admin/calendar_model','calendar');
		$row = $this->calendar->detail(intval($id));
        if (empty($row)){
			show_404();
		}
		if ($this->input->post('adv_submit')){
			$this->_validation();
			if ($this->form_validation->run() == true)
			{
                $this->calendar->update(intval($id));
                $this->session->set_userdata('success','edit');
			    redirect(base64_decode($this->input->get("refer")));
			}
		}
		$data = $this->_form($row);
		$this->load->layout('calendar/form',$data);
	}
	private function _form($row = array()){
		$this->load->helper('form');
		// add static
        $static[] = js('jquery-ui-1.10.0.custom.min.js');
        $static[] = link_tag('jquery-ui.css');
        $this->load->setArray("footer",$static);
        //////////// get course /////
        $this->load->model('admin/news_model','news');
		// get calendar khoa hoc
        $arrCourse = $this->news->cate_lists(array('parent' => 0, 'style' => 4));
        foreach ($arrCourse as $key => $course) {
        	$optionCourse[$course['cate_id']] = $course['name'];
        }

		$data['name'] = form_dropdown('name',$optionCourse ,$row['name']);
		$data['class'] = form_input('class',set_value('class',$row['class']));
		$data['date'] = form_input('date',set_value('date',$row['date']));
		$data['time'] = form_input('time',set_value('time',$row['time']));
		$data['start_time'] = form_input('start_time',set_value('start_time',date('d/m/Y',$row['start_time'])));
		$data['price'] = form_input('price',set_value('price',$row['price']));
		$data['location'] = form_dropdown('location',$this->config->item('brand_location'),$row['location']);
		$data['submit'] = form_submit('adv_submit',$this->lang->line('common_save'));
		return $data;
	}
	private function _validation($ext = array()){
		$this->load->library('form_validation');
		$valid = array(
			array(
                 'field'   => 'name',
                 'label'   => 'Khóa học',
                 'rules'   => 'required'
              ),
           	array(
                 'field'   => 'class',
                 'label'   => 'Lớp',
                 'rules'   => 'required'
              ),
           	array(
                 'field'   => 'start_time',
                 'label'   => 'Ngày bắt đầu',
                 'rules'   => 'required'
              ),
		);
        if (!empty($ext)){
            array_push($valid,$ext);
        }
  		$this->form_validation->set_rules($valid);
	}
}