<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Room extends CI_Controller{
	private $error = array();
    function __construct(){
		parent::__construct();
	}
	public function index(){
		$limit = 20;
		$this->load->model('admin/room_model','room');
		if ($this->input->post('delete') && $this->input->post('cid') && $this->permission->check_permission_backend(array('function'=>'delete')))
		{
			$this->room->delete();
		}
        /** PAGING **/
        $data['row'] = $this->room->lists();
		$this->load->layout('room/list',$data);
	}
	public function add(){
		$this->load->helper('form');
		$this->load->model('admin/room_model','room');
		if ($this->input->post('submit')){
            $this->_validation($rq);
			if ($this->form_validation->run() == true)
			{
                $this->room->insert();
                $this->session->set_userdata('success','add');
                redirect('room/add');
			}
		}
		$this->load->layout('room/form',$data);
	}
	public function edit($id = 0){
		$id = (int) $id;
		if ($id <= 0){
			show_404();
		}
		$this->load->helper('form');
		$this->load->model('admin/room_model','room');
		$row = $this->room->detail($id);
        if (empty($row)){
			show_404();
		}
		if ($this->input->post('submit')){
			$this->_validation();
			if ($this->form_validation->run() == true)
			{
                $this->room->update($id);
                $this->session->set_userdata('success','edit');
			    redirect(base64_decode($this->input->get("refer")));
			}
		}
		$data['row'] = $row;
		$this->load->layout('room/form',$data);
	}
	private function _validation(){
		$this->load->library('form_validation');
		$valid = array(
			array(
                 'field'   => 'name',
                 'label'   => 'Tên lớp',
                 'rules'   => 'required'
              ),
           	array(
                 'field'   => 'username',
                 'label'   => 'Tên đăng nhập',
                 'rules'   => 'required'
              ),
           	array(
                 'field'   => 'password',
                 'label'   => 'Mật khẩu',
                 'rules'   => 'required'
              ),
		);
  		$this->form_validation->set_rules($valid);
	}
}