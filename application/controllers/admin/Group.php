<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Group extends CI_Controller{
	public $module = 'group';
	function __construct(){
		parent::__construct();
		$this->load->setData('title','Lớp học');

	}
	public function index(){
		if ($this->input->post('delete'))
		{
			return $this->_action('delete');
		}
		$this->load->setArray(array("isLists" => 1));
		$data = $this->_index();
		// render view
		$this->load->layout('group/index',$data);
	}
	public function add(){
		// load model
		if ($this->input->post('submit')){
			return $this->_action('add');
		}
		$this->load->setArray(array("isForm" => 1));
		// get data
		$data = $this->_add();
		$this->load->layout('group/form',$data);
	}
	public function add_users($class_id) {
		// load model
		if ($this->input->post('submit')){
			return $this->_action('add_users',array('class_id' => $class_id));
		}
		$this->load->setArray(array("isForm" => 1));
		// get data
		$data = $this->_add_users($class_id);
		$this->load->layout('group/form_users',$data);
	}
	public function index_users($class_id) {
		if ($this->input->post('delete'))
		{
			return $this->_action('delete_user');
		}
		$this->load->setArray(array("isLists" => 1));
		$data = $this->_index_users($class_id);
		// render view
		$this->load->layout('group/index_users',$data);
	}
	public function edit($id = 0){
		$id = (int) $id;
		if ($this->input->post('submit')){
			return $this->_action('edit',array('id' => $id));
		}
		$this->load->setArray(array("isForm" => 1));
		$data = $this->_edit($id);
		if (!$data) {
			show_404();
		}
		$this->load->layout('group/form',$data);
	}
	private function _index(){
		$limit = $this->config->item("limit_item");
		$this->load->model('admin/group_model','group');
		// get level of user 
		$page = (int) $this->input->get('page');
		$offset = ($page > 1) ? ($page - 1) * $limit : 0;
		$params = array('limit' => $limit + 1,'offset' => $offset);
		////////////////// FITER /////////
		$params_filter = array_filter(array(
			'name' => $this->input->get('name'),
			),'filter_item');
		$params = array_merge($params,$params_filter);
		// get data
		$rows = $this->group->lists($params);
		/** PAGING **/
		$config['total_rows'] = count($rows);
		$config['per_page'] = $limit;
		$this->load->library('paging',$config);
		$paging = $this->paging->create_links();
		unset($rows[$limit]);

		// set limit
		$this->load->setArray(array("isLists" => 1));
		// set data
		return array('rows' => $rows, 'paging' => $paging,'filter' => $params_filter);
	}
	private function _index_users($class_id){
		$this->load->model('admin/group_model','group');
		// get level of user 
		$page = (int) $this->input->get('page');
		$offset = ($page > 1) ? ($page - 1) * $limit : 0;
		$params = array('class_id' => $class_id, 'limit' => $limit + 1,'offset' => $offset);
		////////////////// FITER /////////
		$params_filter = array_filter(array(
			'email' => $this->input->get('email'),
			),'filter_item');
		$params = array_merge($params,$params_filter);
		// get data
		$rows = $this->group->list_users($params);
		// get group detail
		$classDetail = $this->group->detail($class_id);
		/** PAGING **/
		$config['total_rows'] = count($rows);
		$config['per_page'] = $limit;
		$this->load->library('paging',$config);
		$paging = $this->paging->create_links();
		unset($rows[$limit]);

		// set limit
		$this->load->setArray(array("isLists" => 1));
		// set data
		return array('rows' => $rows, 'classDetail' => $classDetail, 'paging' => $paging,'filter' => $params_filter);
	}
	private function _add() {
        $this->load->model('admin/group_model','group');
        // row detail
        $arrExpert = $this->group->get_list_expert();
        if (!$arrExpert) {
            return array();
        }
        return  array(
            'arrExpert' => $arrExpert
        );

	}
	private function _add_users($class_id) {
		$this->load->model('admin/group_model','group');
		$classDetail = $this->group->detail($class_id);
		if (!$classDetail) {
			show_404();
		}
		return array('row' => $classDetail);
	}
	private function _edit($id) {
		$this->load->model('admin/group_model','group');
		// row detail
		$row = $this->group->detail($id,$params);
        $arrExpert = $this->group->get_list_expert();

		if ( (!$row ) || (!$arrExpert) ) {
			return array();
		}
		return  array(
			'row' => $row,
            'arrExpert' => $arrExpert
			);
	}
	
	public function _action($action, $params = array()) {
		$this->load->model('admin/group_model','group');
		$this->load->model('admin/logs_model','logs');
		switch ($action) {
			case 'add':

			case 'edit':
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
						)
					);
				if ($action == 'add') {
					$valid[] = array(
						'field'   => 'password',
						'label'   => 'Mật khẩu',
						'rules'   => 'required'
					);
				}
				$this->form_validation->set_rules($valid);
				if ($this->form_validation->run() == true)
				{
					$input = array(
						'name' => $this->input->post('name'),
						'code_class' => $this->input->post('code_class'),
                        'target' => $this->input->post('target'),
                        'input_level' => $this->input->post('input_level'),
						'output_level' => $this->input->post('output_level'),
						'date_start' => $this->input->post('date_start'),
						'date_end' => $this->input->post('date_end'),
						'support' => $this->input->post('support'),
						'username' => $this->input->post('username'),
						'expert' => $this->input->post('expert'),
                        );
					if ($password = $this->input->post('password')) {
						$input['password'] = base64_encode($password);
					}
					if ($action == 'add') {
						$result = $this->group->insert($input);
						if ($item_id = $result) {
							$html =$this->load->view('group/form',$this->_add()); 
						}
					}
					else {
						if ($this->security->verify_token_post($params['id'],$this->input->post('token'))) {
							$result = $this->group->update($params['id'],$input);	
						}
						if ($result) {
							$item_id = $params['id'];
							$html =$this->load->view('group/form',$this->_edit($params['id'])); 
						}
					}
					if ($result) {
						// log action
                        $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $item_id));
                        // return result
						return $this->output->set_output(json_encode(array('status' => 'success', 'html' => $html, 'result' => $result, 'message' => $this->lang->line("common_update_success"))));
					}
				}
				else{
					return $this->output->set_output(json_encode(array('status' => 'error','valid_rule' => $this->form_validation->error_array(), 'message' => $this->lang->line("common_update_validator_error"))));
				}
			break;
			case 'delete':
				$arrId = $this->input->post('cid');
				$arrId = (is_array($arrId)) ? array_map('intval', $arrId) : (int) $arrId;
				if (!$arrId) {
					return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_delete_min_select"))));
				}
				if (!$this->permission->check_permission_backend('delete')){
					return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_access_denied"))));
				}
				$result = $this->group->delete($arrId);
				
				if ($result) {
					// log action
		            $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $arrId));
					// return html
					$html = $this->load->view('group/index',$this->_index()); 
					return $this->output->set_output(json_encode(array('status' => 'success','html' => $html, 'result' => $result, 'message' => $this->lang->line("common_delete_success"))));
				}
			break;
			case 'add_users':
				$this->load->library('form_validation');
				$valid = array(
					array(
						'field'   => 'email',
						'label'   => 'Tên lớp',
						'rules'   => 'required|valid_email'
						)
					);
				$this->form_validation->set_rules($valid);
				if ($this->form_validation->run() == true)
				{	
					$this->load->model('admin/users_model','users');
					$userData = $this->users->get_user_by_email($this->input->post('email'));
					if (!$userData) {
						return $this->output->set_output(json_encode(array('status' => 'error', 'message' => "Không tìm thấy user tương ứng")));
					}
					/////// CHECK USERS //////////
					$input = array('user_id' =>$userData['user_id'], 'class_id' => $params['class_id']);
					$result = $this->group->insert_users_to_class($input);
					if ($result) {
						// log action
                        $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $userData['user_id']));
                        // return result
                        $html =$this->load->view('group/form_users',$this->_add_users($params['class_id'])); 
						return $this->output->set_output(json_encode(array('status' => 'success', 'html' => $html, 'result' => $result, 'message' => $this->lang->line("common_update_success"))));
					}
					
				}
				else{
					return $this->output->set_output(json_encode(array('status' => 'error','valid_rule' => $this->form_validation->error_array(), 'message' => $this->lang->line("common_update_validator_error"))));
				}
			break;
			case 'delete_users':
				$arrId = $this->input->post('cid');
				$arrId = (is_array($arrId)) ? array_map('intval', $arrId) : (int) $arrId;
				if (!$arrId) {
					return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_delete_min_select"))));
				}
				if (!$this->permission->check_permission_backend('delete_users')){
					return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_access_denied"))));
				}
				$result = $this->group->delete_users($arrId);

				var_dump($arrId, $result);
				exit;
				
				if ($result) {
					// log action
		            $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $arrId));
					// return html
					$html = $this->load->view('group/index_users',$this->_index_users()); 
					return $this->output->set_output(json_encode(array('status' => 'success','html' => $html, 'result' => $result, 'message' => $this->lang->line("common_delete_success"))));
				}
			break;
		}	
		return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_no_row_update"))));
	}
}