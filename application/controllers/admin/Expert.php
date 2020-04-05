<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Expert extends CI_Controller{
	public $module = 'expert';
    function __construct(){
		parent::__construct();
		$this->load->setData('title','Giáo viên');

	}
    ////////////////////////////////// CATEGORY /////////////////////////////////
    public function index(){
		if ($this->input->post('delete'))
		{
			return $this->_action('delete');
		}
		$this->load->setArray(array("isLists" => 1));
		$data = $this->_index();
		// render view
		$this->load->layout('expert/list',$data);
	}
	public function add(){
		if ($this->input->post('submit')) {
			return $this->_action('add');
		}
		$this->load->setArray(array("isForm" => 1));
		$this->load->layout('expert/form');
	}
	
	public function edit($id) {
		$id = (int) $id;
		if ($this->input->post('submit')) {
			return $this->_action('edit',array('id' => $id));
		}
		$this->load->setArray(array("isForm" => 1));
		$data = $this->_edit($id);
		$this->load->layout('expert/form',$data);
	}
	private function _index(){
		$limit = $this->config->item("limit_item");
		$this->load->model('admin/expert_model','expert');
		// get level of user 
		$page = (int) $this->input->get('page');
		$offset = ($page > 1) ? ($page - 1) * $limit : 0;
		$params = array('limit' => $limit + 1,'offset' => $offset);
		////////////////// FITER /////////
		/* $params_filter = array_filter(array(
			'keyword' => $this->input->get('title'),
			'publish' => $this->input->get('publish'),
			'cate_id' => $this->input->get('cate_id')
		),'filter_item');
		$params = array_merge($params,$params_filter); */
		// get data
		$rows = $this->expert->lists($params);
		/** PAGING **/
		$config['total_rows'] = count($rows);
  		$config['per_page'] = $limit;
  		$this->load->library('paging',$config);
  		$paging = $this->paging->create_links();
		unset($rows[$limit]);
		// arrCate
		$this->load->setArray(array("isLists" => 1));
		// set data
		return array('rows' => $rows, 'paging' => $paging);
	}
	private function _edit($id){
		$this->load->model('admin/expert_model','expert');
		$row = $this->expert->detail(intval($id));
		if (!$row) {
			show_404();
		}
		// set data to view
		return  array(
			'row' => $row
		);
	}
	private function _add() {
		return array();
	}
	public function _action($action, $params = array()) {
		$this->load->model('admin/expert_model','expert');
		$this->load->model('admin/logs_model','logs');
		switch ($action) {			
			case 'add':
			case 'edit':
				$this->load->library('form_validation');
				$valid = array(
					array(
		                 'field'   => 'name',
		                 'label'   => 'Tên giáo viên',
		                 'rules'   => 'required'
		              )
				);
		  		$this->form_validation->set_rules($valid);
				if ($this->form_validation->run() == true)
				{
					$input = array(
						'name' => $this->input->post('name'),
			            'description' => $this->input->post("description"),
			            'detail' => $this->input->post('detail'),
			            'images' => $this->input->post("images"),
			            'seo_title' => $this->input->post("seo_title"),
			            'seo_keyword' => $this->input->post("seo_keyword"),
			            'seo_description' => $this->input->post("seo_description"),
					);
					if ($action == 'add') {
						//for ($i=0; $i < 10; $i++) { 
							$result = $this->expert->insert($input);
						//}
						
						if ($item_id = $result) {
							$html =$this->load->view('expert/form',$this->_add()); 
						}
					}
					else {
						if ($this->security->verify_token_post($params['id'],$this->input->post('token'))) {
							$result = $this->expert->update($params['id'],$input);	
						}
						if ($result) {
							$item_id = $params['id'];
							$html =$this->load->view('expert/form',$this->_edit($params['id'])); 
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
				$result = $this->expert->delete($arrId);
				
				if ($result) {
					// log action
	                $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $arrId));
	                // return result
					$html = $this->load->view('expert/list',$this->_index()); 
					return $this->output->set_output(json_encode(array('status' => 'success','html' => $html, 'result' => $result, 'message' => $this->lang->line("common_delete_success"))));
				}
			break;
			default:
				# code...
				break;
		}	
		return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_no_row_update"))));
	}

	public function suggest_teacher(){
		$keyword = $this->input->get("term");
        $page = (int) $this->input->get('page');
        $page = ($page > 1) ? $page : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $this->load->model('admin/expert_model','expert');
        $params = array('limit' => $limit + 1,'keyword' => $keyword,'offset' => $offset);
        $arrTeacher = $this->expert->lists($params);
        $data = $option = array();
        if (count($arrTeacher) > $limit) {
            $option['nextpage'] = true;
            unset($arrTeacher[$limit]);
        }
        foreach ($arrTeacher as $key => $teacher) {
            $data[] = array('id' => $teacher['expert_id'], 'text' => $teacher['name'],'item_id' => $teacher['expert_id']);
        }
        return $this->output->set_output(json_encode(array('status' => 'success','data' => $data,'option' => $option)));
	}
    public function suggest_teacher_offline(){
        $keyword = $this->input->get("term");
        $page = (int) $this->input->get('page');
        $page = ($page > 1) ? $page : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

//        $this->load->model('admin/users_model','users');
        $this->load->model('tool_model','tool');

        $params = array('limit' => $limit + 1,'keyword' => $keyword,'offset' => $offset);
        $arrTeacher = $this->tool->get_list_permission_member_to_role($params);
        $data = $option = array();
        if (count($arrTeacher) > $limit) {
            $option['nextpage'] = true;
            unset($arrTeacher[$limit]);
        }
        foreach ($arrTeacher as $key => $teacher) {
            $data[] = array('id' => $teacher['member_id'], 'text' => $teacher['email'],'item_id' => $teacher['member_id']);
        }
        return $this->output->set_output(json_encode(array('status' => 'success','data' => $data,'option' => $option)));
    }

}