<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends CI_Controller {
    public $module = 'users';
	public function __construct(){
		parent::__construct();
		$this->lang->load('backend/users');
		$this->load->setData('title',$this->lang->line('users_title'));
	}
	public function dashboard() {
		$this->load->layout('users/dashboard');
	}
	public function index(){
		if ($this->input->post('delete'))
		{
			return $this->_action('delete');
		}
		$this->load->setArray(array("isLists" => 1));
		$data = $this->_index();
		// render view
		$this->load->layout('users/list',$data);
	}
	private function _index(){
		$limit = $this->config->item("limit_item");
		$this->load->model('admin/users_model','users');
		// get level of user 
		$page = (int) $this->input->get('page');
		$offset = ($page > 1) ? ($page - 1) * $limit : 0;
		$params = array('limit' => $limit + 1,'offset' => $offset);
		////////////////// FITER /////////
		$params_filter = array_filter(array(
			'email' => $this->input->get('email'),
			'active' => $this->input->get('active'),
			'from_date' => ($fromdate = $this->input->get('from_date')) ? convert_datetime($fromdate) : (time() - 6*30*3600*24), // 6 thang
			'to_date' => ($todate = $this->input->get('to_date')) ? convert_datetime($todate) : time()
		),'filter_item');
		$params = array_merge($params,$params_filter);
		// get data
		$rows = $this->users->lists($params);
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
	public function add(){
        if ($this->input->post('submit')){
			return $this->_action('add');
		}
		$this->load->setArray(array("isForm" => 1));
		
		$this->load->layout('users/form');
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
		$this->load->layout('users/form',$data);
	}
	public function _edit($id = 0) {
		$this->load->model('admin/users_model','users');
		$row = $this->users->detail($id);
		if (!$row) {
			return array();
		}
		return  array(
			'row' => $row
		);
	}
	public function login(){
		$configOauth = $this->config->item("web4u_oauth");
		$url = $configOauth['site'].'/oauth/token';
        $this->load->library('Curl');
        $postData = array(
            'client_id' => $configOauth['client_id'],
            'client_secret' => $configOauth['client_secret'],
            'redirect_uri' => urlencode(SITE_URL.'/users/login'),
            'grant_type' => 'authorization_code',
            'code' => $this->input->get('code')
        );
        $data = $this->curl->simple_post($url,$postData,array(CURLOPT_FAILONERROR => FALSE));
        $data = json_decode($data,TRUE);
        if ($this->curl->info['http_code'] === 200 && $access_token = $data['access_token']) {
            $url = $configOauth['site'] . '/oauth/resource';
            $data = $this->curl->simple_get($url,array('access_token' => $access_token),array(CURLOPT_FAILONERROR => FALSE));
            $data = json_decode($data,TRUE);
            if ($this->curl->info['http_code'] === 200 && $data) {
            	// site root
            	$data['access_token'] = $access_token;
            	if ($data['site_role'] == 'root') {
            		$this->permission->setIdentity($data);
            		redirect(SITE_URL);
            	}
            	else {
            		$this->load->model("admin/roles_model","roles");
            		$permission = $this->roles->getRoleByUser($data['user_id']);
	            	if ($permission) {
	            		$data['permission'] = $permission['permission'];
	            		$data['role'] = $permission['name'];
	            		// set session
		            	$this->permission->setIdentity($data);
		            	redirect(SITE_URL);
	            	}
	            	else {
	            		$data['error_description'] = 'Access Denied';
	            	}
            	}
            }
        }
        // if false oauth2
        $session_id = session_id();
        $data['configOauth'] = $configOauth;
        $data['redirect_uri'] = urlencode(SITE_URL);
        $this->load->view('users/login',$data,FALSE);
		
	}
    public function logout(){
    	$configOauth = $this->config->item("web4u_oauth");
        $this->permission->clearIdentity();
        redirect($configOauth['site'].'/users/logout?redirect_uri='.urlencode(BASE_URL));
    }
	public function _action($action, $params = array()) {
		$this->load->model('admin/users_model','users');
		$this->load->model('admin/logs_model','logs');
		switch ($action) {
			case 'profile':
			case 'edit':
			case 'add':
				$this->load->library('form_validation');
				$valid = array(
		           	array(
		                 'field'   => 'email',
		                 'label'   => $this->lang->line('users_email'),
		                 'rules'   => 'required'
		            ),
		          	array(
		                 'field'   => 'fullname',
		                 'label'   => $this->lang->line('users_fullname'),
		                 'rules'   => 'required'
		            ),
		  		);
		  		$this->form_validation->set_rules($valid);
				if ($this->form_validation->run() == true)
				{
					$row = $this->users->detail($params['id']);
					$input = array(
						'fullname' => $this->input->post('fullname'),
						'password' => $this->input->post('password'),
						'email' => $this->input->post('email'),
					);
					if($action == "add"){
						if($this->users->get_user_by_email($input['email'])){
							return $this->output->set_output(json_encode(array('status' => 'error', 'message' => 'Email đã tồn tại trong hệ thống')));
						}

						$input = array_merge($input, array(
							'active' => 1,
							'password' => hash('sha256','123456'),
							'sex' => (int) $this->input->post("sex"),
				            'address' => $this->input->post("address"),
				            'phone' => $this->input->post("phone"),
				            'birthday' => (int) convert_datetime($this->input->post('birthday')),
						));
					}

					if ($this->permission->check_permission_backend('edit') && $action == 'edit') {
						$input = array_merge($input, array(
							'active' => (int) $this->input->post('active')
				        ));
				        if ($this->security->verify_token_post($params['id'],$this->input->post('token'))) {
							$result = $this->users->update($params['id'],$input);	
						}
					}else{
						$result = $this->users->insert($input);	
					}
					
					if ($result) {
						// log action
                        $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $params['id']));
                        // return result
						$html =$this->load->view('users/form',$this->_edit($params['id'])); 
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
				$result = $this->users->delete($arrId);
				
				if ($result) {
					// log action
                    $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $arrId));
                    // return result
					$html = $this->load->view('users/list',$this->_index()); 
					return $this->output->set_output(json_encode(array('status' => 'success','html' => $html, 'result' => $result, 'message' => $this->lang->line("common_delete_success"))));
				}
			break;
			default:
				# code...
				break;
		}	
		return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_no_row_update"))));
	}

	public function suggest(){
		$keyword = $this->input->get("term");
        $page = (int) $this->input->get('page');
        $page = ($page > 1) ? $page : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $this->load->model('admin/users_model','users');
        $params = array('limit' => $limit + 1,'keyword' => $keyword,'offset' => $offset);
        $arrUsers = $this->users->lists($params);
        $data = $option = array();
        if (count($arrUsers) > $limit) {
            $option['nextpage'] = true;
            unset($arrUsers[$limit]);
        }
        foreach ($arrUsers as $key => $user) {
            $data[] = array('id' => $user['user_id'], 'text' => $user['fullname'].' ('.$user['email'].')','item_id' => $user['user_id']);
        }
        return $this->output->set_output(json_encode(array('status' => 'success','data' => $data,'option' => $option)));
	}
}
?>