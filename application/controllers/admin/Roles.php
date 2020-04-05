<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Roles extends CI_Controller {
	public $module = 'roles';
	public function __construct(){
		parent::__construct();
		$this->lang->load('backend/users');
		$this->load->setData('title',$this->lang->line('users_roles_title'));
	}
    ///////////////////////////////////// ROLE //////////////////////////////
    public function index(){
		if ($this->input->post('delete'))
		{
			return $this->_action('delete');
		}
		$this->load->setArray(array("isLists" => 1));
		$data = $this->_index();
		// render view
		$this->load->layout('roles/list',$data);
	}
	public function add(){
		if ($this->input->post('submit')) {
			return $this->_action('add');
		}
		$this->load->setArray(array("isForm" => 1));
		$this->load->layout('roles/form');
	}
	public function copy($id = 0) {
		$id = (int) $id;
        if ($this->input->post('submit')){
			return $this->_action('add');
		}
		$this->load->setArray(array("isForm" => 1));
		$data = $this->_edit($id);
		if (!$data) {
			show_404();
		}
		$this->load->layout('roles/form',$data);
	}
	public function edit($id) {
		$id = (int) $id;
		if ($this->input->post('submit')) {
			return $this->_action('edit',array('id' => $id));
		}
		$data = $this->_edit($id);
		$this->load->layout('roles/form',$data);
	}
	public function member_add() {
		$id = (int) $id;
		if ($this->input->post('submit')) {
			return $this->_action('member_add');
		}
		$data = $this->_member_add();
		$this->load->layout('roles/member_form',$data);
	}
	public function member_edit($member_id) {
		$member_id = (int) $member_id;
		if ($this->input->post('submit')) {
			return $this->_action('member_edit',array('id' => $member_id));
		}
		$data = $this->_member_edit($member_id);
		$this->load->layout('roles/member_form',$data);
	}
	public function member_index() {
		if ($this->input->post('delete'))
		{
			return $this->_action('member_delete');
		}
		$this->load->setArray(array("isLists" => 1));
		$data = $this->_member_index();
		// render view
		$this->load->layout('roles/member_index',$data);
	}
	
	public function _index(){
		$this->load->model('admin/roles_model','roles');
		// get array role
		$rows = $this->roles->lists();
		// set data
		return array('rows' => $rows);
	}
	public function _edit($id){
		$this->load->model('admin/roles_model','roles');
		$row = $this->roles->detail(intval($id));
		$row['permission'] = json_decode($row['permission'],TRUE);
		if (!$row) {
			show_404();
		}
		// set data to view
		return  array(
			'row' => $row
		);
	}
	public function _member_index() {
		// get array role
		$this->load->model('admin/roles_model','roles');
		// get array role
		$roles = $this->roles->lists();
		$arrRole = array();
		foreach ($roles as $key => $role) {
			$arrRole[$role['roles_id']] = $role;
		}
		// get array member role
		$rows = $this->roles->member_lists();
		// set data
		return array('rows' => $rows, 'arrRole' => $arrRole);
	}
	public function _member_add() {
		// get array role
		$this->load->model('admin/roles_model','roles');
		// get array role
		$rows = $this->roles->lists();
		// set data
		return array('arrRoles' => $rows);
	}
	public function _member_edit($member_id){
		$this->load->model('admin/roles_model','roles');
		$row = $this->roles->member_detail((int) $member_id);
		$arrRoles = $this->roles->lists();
		// set data to view
		return  array(
			'arrRoles' => $arrRoles,
			'row' => $row
		);
	}
	public function _action($action, $params = array()) {
		$this->load->model('admin/roles_model','roles');
		$this->load->model('admin/logs_model','logs');
		switch ($action) {
			case 'add':
			case 'edit':
				$this->load->library('form_validation');
				$valid = array(
					array(
		                 'field'   => 'name',
		                 'label'   => $this->lang->line('users_roles_name'),
		                 'rules'   => 'required'
		              )
				);
		  		$this->form_validation->set_rules($valid);
				if ($this->form_validation->run() == true)
				{
					$permission = $this->input->post('permission');
					$role = array();
					foreach ($permission as $key => $value) {
						if ($value > 0) {
							$role[$key] = $value;	
						}
					}
					$input = array(
						'name' => $this->input->post('name'),
						'permission' => json_encode($role)
					);
					if ($action == 'add') {
						$result = $this->roles->insert($input);
						if ($item_id = $result) {
							$html =$this->load->view('roles/form'); 
						}
					}
					else {
						if ($this->security->verify_token_post($params['id'],$this->input->post('token'))) {
							$result = $this->roles->update($params['id'],$input);	
						}
						if ($result) {
							$item_id = $params['id'];
							$html =$this->load->view('roles/form',$this->_edit($params['id'])); 
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
				$result = $this->roles->delete($arrId);
				if ($result) {
					// log action
	                $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $arrId));
	                // return result
					$html = $this->load->view('roles/list',$this->_index()); 
					return $this->output->set_output(json_encode(array('status' => 'success','html' => $html, 'result' => $result, 'message' => $this->lang->line("common_delete_success"))));
				}
			break;
			case 'member_add':
				$this->load->library('form_validation');
				$valid = array(
					array(
		                 'field'   => 'email',
		                 'label'   => $this->lang->line('users_email'),
		                 'rules'   => 'required|valid_email'
		              )
				);
		  		$this->form_validation->set_rules($valid);
				if ($this->form_validation->run() == true)
				{
					// get profile users
					$profile = $this->permission->getIdentity();
					// curl check email
					$email = $this->input->post('email');
					$role_id = (int) $this->input->post('role');
					// check email exists
					if ($this->roles->checkRoleByEmail($email)) {
						return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("users_roles_email_existed"), 'valid_rule' => array('email' => $this->lang->line("users_roles_email_existed")))));
					}
					// curl to account site
					$this->load->library("Curl");
					$configOauth = $this->config->item("web4u_oauth");
					$url = $configOauth['site'] . '/oauth/getuserbyemail';
					if (!$profile['access_token']) {
						return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("users_token_expire"))));
					}
					$data = $this->curl->simple_get($url,array('access_token' => $profile['access_token'],'email' => $email),array(CURLOPT_FAILONERROR => FALSE));
					$data = @json_decode($data,TRUE);
					if ($this->curl->info['http_code'] === 200){
						
						if ($data['status'] == 'error') {
							return $this->output->set_output(json_encode(array('status' => 'error','message' => $data['message'])));
						}
						$input = array(
							'member_id' => $data['data']['user_id'],
							'roles_id' => $role_id,
							'email' => $email
						);
						$result = $this->roles->member_insert($input);
						if ($result) {
							// log action
			                $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $input['member_id']));
			                // return result
							$html = $this->load->view('roles/member_form',$this->_member_add()); 
							return $this->output->set_output(json_encode(array('status' => 'success','html' => $html, 'result' => $result, 'message' => $this->lang->line("common_update_success"))));
						}
					}
					else {
						$message = ($data['error_description']) ? $data['error_description'] : $this->lang->line("common_server_account_error");
						return $this->output->set_output(json_encode(array('status' => 'error','message' => $message,'error_code' => $data)));
					}
				}
				else {
					return $this->output->set_output(json_encode(array('status' => 'error','valid_rule' => $this->form_validation->error_array(), 'message' => $this->lang->line("common_update_validator_error"))));
				}
			break;
			case 'member_edit':
				if ($this->security->verify_token_post($params['id'],$this->input->post('token'))) {
					$result = $this->roles->member_update($params['id'],array('roles_id' => (int) $this->input->post('role')));	
				}
				if ($result) {
					// log action
	                $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $params['id']));
	                // return result
					$html = $this->load->view('roles/member_form',$this->_member_edit($params['id'])); 
					return $this->output->set_output(json_encode(array('status' => 'success', 'html' => $html, 'result' => $result, 'message' => $this->lang->line("common_update_success"))));
				}
			break;
			case 'member_delete':
				$arrId = $this->input->post('cid');
				$arrId = (is_array($arrId)) ? array_map('intval', $arrId) : (int) $arrId;
				if (!$arrId) {
					return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_delete_min_select"))));
				}
				if (!$this->permission->check_permission_backend('delete')){
					return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_access_denied"))));
				}
				$result = $this->roles->member_delete($arrId);
				if ($result) {
					// log action
	                $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $arrId));
	                // return result
					$html = $this->load->view('roles/member_index',$this->_member_index()); 
					return $this->output->set_output(json_encode(array('status' => 'success','html' => $html, 'result' => $result, 'message' => $this->lang->line("common_delete_success"))));
				}
			break;
			default:
				# code...
				break;
		}	
		return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_no_row_update"))));
	}
}
?>