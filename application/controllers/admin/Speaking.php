<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Speaking extends CI_Controller{

    function __construct(){
		parent::__construct();
		$this->load->setData('title','Quản lý bài nói');

	}
    public function point(){
        $limit = 20;
		$this->load->model('speaking_model','speaking');
        /** FILTER **/
        $this->load->helper('form');
        $filter['data'][] = 'Thành viên: '.form_input('username',$this->input->get('username'));
        $filter['data'][] = 'Mã bài test: '.form_input('testid',$this->input->get('testid'));
        $data['filter'] = $this->load->view("common/data_filter",$filter);

		$data['row'] = $this->speaking->lists_point($limit);
        //var_dump('<pre>',$data['row']); die;
		/** PAGING **/
		$config['total_rows'] = count($data['row']);
  		$config['per_page'] = $limit;
  		$this->load->library('paging',$config);
  		$data['paging'] = $this->paging->create_links();
		unset($data['row'][$limit]);

		$this->load->layout('speaking/point_list',$data);
    }
    public function point_detail(){
        $point = (int) $this->input->post("point");
        $comment = strip_tags($this->input->post("comment"));
        $record_id = (int) $this->input->post("record_id");
        $arr['result'] = 'success';
        if ($record_id < 1) {
            $arr['result'] = 'error';
            $arr['data'] = 'Không tìm thấy bài viết bạn chấm';
        }
        if ($point < 1) {
            $arr['result'] = 'error';
            $arr['data'] = 'Điểm không được chấm bằng 0';
        }
        if ($arr['result'] == 'success'){
            $arr['data'] = 'Đã lưu thông tin';
            $this->load->model('speaking_model','speaking');
            $this->speaking->update_point_teacher($record_id,$point,$comment);
        }
        $this->output->set_output(json_encode($arr));
    }
	public function index(){
        $limit = 20;
		$this->load->model('admin/speaking_model','speaking');
		if ($this->input->post('delete') && $this->input->post('cid') && $this->permission->check_permission_backend('','delete'))
		{
			$this->speaking->delete();
            $this->session->set_userdata('success','delete');
		}
		$data['row'] = $this->speaking->lists($limit);
		/** PAGING **/
		$config['total_rows'] = count($data['row']);
  		$config['per_page'] = $limit;
  		$this->load->library('paging',$config);
  		$data['paging'] = $this->paging->create_links();
		unset($data['row'][$limit]);

		$this->load->layout('speaking/list',$data);
	}
	public function add(){
        // load model
		$this->load->model('admin/speaking_model','speaking');
		if ($this->input->post('speaking_submit')){
			$this->_validation();
			if ($this->form_validation->run() == true)
			{
                
                $this->speaking->insert();
                $this->session->set_userdata('success','add');
                redirect('speaking/add');
			}
		}
		$row = set_array('content','title','images','sound');
		$data = $this->_form($row);
		$this->load->layout('speaking/form',$data);
	}
    public function edit($id = 0){
        $id = intval($id);
        if ($id <= 0){
			show_404();
		}
        //load model
		$this->load->model('admin/speaking_model','speaking');
        // get detail speaking
        $row = $this->speaking->detail(intval($id));

		if (empty($row)){
			show_404();
		}
        if ($this->input->post('speaking_submit')){
			$this->_validation();
			if ($this->form_validation->run() == true)
			{
                $this->speaking->update($id);
                $this->session->set_userdata('success','edit');
			    redirect(base64_decode($this->input->get("refer")));
			}
		}
		$data = $this->_form($row);
        $data['row'] = $row;
		$this->load->layout('speaking/form',$data);
	}

	private function _form($row = array()){
        // load form
		$this->load->helper('form');
		$data['error_upload'] = $this->error['upload'];
		$data['title'] = form_input('title',set_value('title',$row['title']));
        $data['content'] = form_detail('content',$row['content'],array("height" => '200'));
        $data['prepare_time'] = form_input('prepare_time',set_value('prepare_time',$row['prepare_time']));
        $data['response_time'] = form_input('response_time',set_value('response_time',$row['response_time']));
        $data['answer_text'] = form_detail('answer_text',$row['answer_text'],array("height" => '200'));
        $data['answer_sound'] = form_upload('answer_sound','','size="50"');
        $data['publish'] = form_checkbox('publish',1,$row['publish']);
		$data['submit'] = form_submit('speaking_submit',$this->lang->line('common_save'));
		return $data;
	}
	private function _validation(){
		$this->load->library('form_validation');
		$valid = array(
			array(
                 'field'   => 'title',
                 'label'   => 'Tiêu đề',
                 'rules'   => 'required'
              )
		);
  		$this->form_validation->set_rules($valid);
	}
    //////////////////////////////////////// TEST ///////////////////
    public function test_index(){
        $limit = 20;
		$this->load->model('speaking_model','speaking');
		if ($this->input->post('delete') && $this->input->post('cid') && $this->permission->check_permission_backend('','test_delete'))
		{
			$row = $this->speaking->test_delete();
            $this->session->set_userdata('success','delete');
		}
        /** FILTER **/
        $this->load->helper('form');
        $level = get_level();
        array_unshift($level,'Tất cả');
        $pass = get_password();
        $password[null] = 'Tất cả';
        $password[0] = 'Không có password';
        foreach ($pass as $key => $pass) {
            $password[$key] = $pass['name'];
        }
        $passselect = ($this->input->get('password')) ? (int) $this->input->get("password") : null;
        $filter['data'][] = 'Level: '.form_dropdown('level',$level,$this->input->get('level'));
        $filter['data'][] = 'Part: '.form_dropdown('part',array(''=>'Tất cả',0 => 0,1=>1,2=>2,3=>3,4=>4,5=>5,6=>6),$this->input->get('part'));
        $filter['data'][] = 'Password: '.form_dropdown('password',$password,$passselect);
        $data['filter'] = $this->load->view("common/data_filter",$filter);

		$data['row'] = $this->speaking->test_lists($limit);
		/** PAGING **/
		$config['total_rows'] = count($data['row']);
  		$config['per_page'] = $limit;
  		$this->load->library('paging',$config);
  		$data['paging'] = $this->paging->create_links();
		unset($data['row'][$limit]);

		$this->load->layout('speaking/test_list',$data);
    }
    public function test_add(){
        // load model
		$this->load->model('speaking_model','speaking');
		if ($this->input->post('test_submit')){
			$this->_test_validation();
			if ($this->form_validation->run() == true)
			{

                $this->speaking->test_insert();
                $this->session->set_userdata('success','add');
                redirect('speaking/test_add');
			}
		}
		$row = set_array('name',array('role' => array(0)));
		$data = $this->_test_form($row);
		$this->load->layout('speaking/test_form',$data);
    }
    public function test_edit($id){
        $id = intval($id);
        if ($id <= 0){
			show_404();
		}
        //load model
		$this->load->model('speaking_model','speaking');
		$row = $this->speaking->test_detail(intval($id));
		if (empty($row)){
			show_404();
		}
        //////////// role edit ///////////
		$role = $this->speaking->get_role_by_testid($id);
        if (!empty($role)){
            foreach ($role as $role){
                $row['role'][] = $role['role_id'];
            }
        }
        else{
            $row['role'] = array(0);
        }
        ////////// end role edit //////////
        if ($this->input->post('test_submit')){
			$this->_test_validation();
			if ($this->form_validation->run() == true)
			{
                $this->speaking->test_update($id);
                $this->session->set_userdata('success','edit');
			    //redirect(base64_decode($this->input->get("refer")));
			}
		}
		$data = $this->_test_form($row);
		$this->load->layout('speaking/test_form',$data);
    }
    private function _test_form($row = array()){
        // load form
        $limit_per_cate = 30;
		$this->load->helper('form');
        // lay nhung loai part
        $part = get_speaking_type();
        $select[0] = 'Fulltest - 0';
        foreach ($part as $keys => $value){
            $select[$keys] = $value . ' - '. $keys;
        }
        $keys = array_keys($part);
        $data['fulllevel'] = get_level();

        /////////////////// GROUP /////////////
        $this->load->model("group_model",'group');
        $r = $this->group->lists();
        $role[0] = 'Tất cả quyền hạn';
        foreach ($r as $r){
            $role[$r['id']] = $r['name'];
        }
        $roleselect = $row['role'];
        $data['role'] = form_multiselect('role_id[]',$role,$roleselect);
        //////////////// END GROUP ///////////
        $password = get_password();
        $arrpass[0] = 'Không đặt password';
        foreach ($password as $key => $pass){
            $arrpass[$key] = $pass['name'];
        }
        $data['password'] = form_dropdown('password',$arrpass,(int)$row['password']);
        $data['suggest'] = $this->speaking->get_latest_question($limit_per_cate);
        $data['level'] = form_dropdown('level',get_level(),$row['level']);
		$data['error_upload'] = $this->error['upload'];
		$data['name'] = form_input('name',set_value('name',$row['name']));
		//// part 1
        $data['type'] = form_dropdown('type',$select,$row['type'],'onchange="change_type_test(this.value)" id="speaking_type"');
        $data['jstype'] = json_encode($this->speaking->type_to_question);
        for ($i = 1; $i <= 11; $i++){
            $data['question_'.$i] = form_input('question_'.$i,set_value('question_'.$i,$row['question_'.$i]));
        }

		$data['submit'] = form_submit('test_submit',$this->lang->line('common_save'));
		return $data;
    }
    private function _test_validation(){
		$this->load->library('form_validation');
		$valid = array(
			array(
                 'field'   => 'name',
                 'label'   => 'Tên',
                 'rules'   => 'required'
              )
		);
  		$this->form_validation->set_rules($valid);
	}
}