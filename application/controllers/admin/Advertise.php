<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Advertise extends CI_Controller{
	public $module = 'advertise';
	private $_adv_type = 3;
	function __construct(){
		parent::__construct();
		$this->lang->load('backend/advertise');
		$this->load->setData('title',$this->lang->line('adv_title'));

	}
	public function index(){
		if ($this->input->post('delete'))
		{
			return $this->_action('delete');
		}
		$this->load->setArray(array("isLists" => 1));
		$data = $this->_index();
		// render view
		$this->load->layout('advertise/list',$data);
	}
	public function add(){
		// load model
		if ($this->input->post('submit')){
			return $this->_action('add');
		}
		$this->load->setArray(array("isForm" => 1));
		// get data
		$data = $this->_add();
		$this->load->layout('advertise/form',$data);
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
		$this->load->layout('advertise/form',$data);
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
		$this->load->layout('advertise/form',$data);
	}
	private function _index(){
		$limit = $this->config->item("limit_item");
		$this->load->model('admin/advertise_model','adv');
		$this->load->model('admin/category_model','category');
		// get level of user 
		$page = (int) $this->input->get('page');
		$offset = ($page > 1) ? ($page - 1) * $limit : 0;
		$params = array('limit' => $limit + 1,'offset' => $offset);
		////////////////// FITER /////////
		$params_filter = array_filter(array(
			'publish' => $this->input->get('publish'),
			'cate_id' => $this->input->get('cate_id')
			),'filter_item');
		$params = array_merge($params,$params_filter);
		// get data
		$rows = $this->adv->lists($params);
		/** PAGING **/
		$config['total_rows'] = count($rows);
		$config['per_page'] = $limit;
		$this->load->library('paging',$config);
		$paging = $this->paging->create_links();
		unset($rows[$limit]);
		// arrCate
		$arrCate = $this->category->get_category(array('type' => $this->_adv_type));
		$arrCate = $this->category->recursiveCate($arrCate);

		// set limit
		$this->load->setArray(array("isLists" => 1));
		// set data
		return array('rows' => $rows, 'paging' => $paging, 'arrCate' => $arrCate,'filter' => $params_filter);
	}
	private function _add() {
		$this->load->model('admin/advertise_model','adv');
		$this->load->model('admin/category_model','category');
		// get array cate
		$arrCate = $this->category->get_category(array('type' => $this->_adv_type));
		$arrCate = $this->category->recursiveCate($arrCate);
		return array(
			'arrCate' => $arrCate
			);
	}
	private function _edit($id) {
		$this->load->model('admin/advertise_model','adv');
		$this->load->model('admin/category_model','category');
		// row detail
		$row = $this->adv->detail($id,$params);
		if (!$row) {
			return array();
		}
		// get array cate
		$arrCate = $this->category->get_category(array('type' => $this->_adv_type));
		$arrCate = $this->category->recursiveCate($arrCate);
		return  array(
			'arrCate' => $arrCate,
			'row' => $row
			);
	}
	public function _action($action, $params = array()) {
		$this->load->model('admin/advertise_model','adv');
		$this->load->model('admin/logs_model','logs');
		switch ($action) {
			case 'add':
			case 'edit':
				$this->load->library('form_validation');
				$valid = array(
					array(
						'field'   => 'name',
						'label'   => $this->lang->line('adv_name'),
						'rules'   => 'required'
						),
					array(
						'field'   => 'images',
						'label'   => $this->lang->line('adv_images'),
						'rules'   => 'required'
						),
					array(
						'field'   => 'link',
						'label'   => $this->lang->line('adv_link'),
						'rules'   => 'required'
						),
					array(
						'field'   => 'cate_id',
						'label'   => $this->lang->line('adv_cate'),
						'rules'   => 'is_natural_no_zero'
						)
					);
				$this->form_validation->set_rules($valid);
				if ($this->form_validation->run() == true)
				{
					$input = array(
						'name' => $this->input->post('name'),
						'images' => $this->input->post('images'),
						'link' => $this->input->post('link'),
						'cate_id' => (int) $this->input->post('cate_id'),
						'ordering' => (int) $this->input->post('ordering'),
						'publish' => (int) $this->input->post('publish'),
						'description' => $this->input->post('description')
						
						);			
					if ($action == 'add') {
						$result = $this->adv->insert($input);
						if ($item_id = $result) {
							$html =$this->load->view('advertise/form',$this->_add()); 
						}
					}
					else {
						if ($this->security->verify_token_post($params['id'],$this->input->post('token'))) {
							$result = $this->adv->update($params['id'],$input);	
						}
						if ($result) {
							$item_id = $params['id'];
							$html =$this->load->view('advertise/form',$this->_edit($params['id'])); 
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
				$result = $this->adv->delete($arrId);
				
				if ($result) {
					// log action
		            $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $arrId));
					// return html
					$html = $this->load->view('advertise/list',$this->_index()); 
					return $this->output->set_output(json_encode(array('status' => 'success','html' => $html, 'result' => $result, 'message' => $this->lang->line("common_delete_success"))));
				}
			break;
		}	
		return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_no_row_update"))));
	}
}