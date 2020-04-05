<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Category extends CI_Controller{
	public $module = 'category';
    function __construct(){
		parent::__construct();
		$this->lang->load('backend/category');
		$this->load->setData('title',$this->lang->line('category_cate_title'));

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
		$this->load->layout('category/cate_list',$data);
	}
	public function add(){
		if ($this->input->post('submit')) {
			return $this->_action('add');
		}
		$this->load->setArray(array("isForm" => 1));
		$data = $this->_add();
		$this->load->layout('category/cate_form',$data);
	}
	
	public function edit($id) {
		$id = (int) $id;
		if ($this->input->post('submit')) {
			return $this->_action('edit',array('id' => $id));
		}
		$this->load->setArray(array("isForm" => 1));
		$data = $this->_edit($id);
		$this->load->layout('category/cate_form',$data);
	}
	public function _index(){
		$this->load->model('admin/category_model','category');
		$params['type'] = 1;
		if ($type = (int) $this->input->get('type')){
			$params['type'] = $type;
		} 
		// get array cate
		$arrCate = $this->category->get_category($params);
		$rows = $this->category->recursiveCate($arrCate);
		// get config data
		$this->load->config('data');
		// set data
		return array('rows' => $rows, 'filter' => $params);
	}
	public function _add(){
		
		$this->load->model('admin/category_model','category');
		// get category recursive
		$arrCate = $this->category->get_category(array('type' => 1));
		$arrCate = $this->category->recursiveCate($arrCate);
		// set data to view
		return array(
			'arrCate' => $arrCate,
		);
	}
	public function _edit($id){
		$this->load->model('admin/category_model','category');
		$row = $this->category->cate_detail(intval($id));
		if (!$row) {
			show_404();
		}
		// get category recursive
		$arrCate = $this->category->get_category(array('type'=>$row['type']));
		$arrCate = $this->category->recursiveCate($arrCate,array('excluse' => $id));
		// set data to view
		return  array(
			'arrCate' => $arrCate,
			'row' => $row
		);
	}
	public function _action($action, $params = array()) {
		$this->load->model('admin/category_model','category');
		$this->load->model('admin/logs_model','logs');
		switch ($action) {			
			case 'add':
			case 'edit':
				$this->load->library('form_validation');
				$valid = array(
					array(
		                 'field'   => 'name',
		                 'label'   => $this->lang->line('category_cate_name'),
		                 'rules'   => 'required'
		              ),
		           array(
		                 'field'   => 'ordering',
		                 'label'   => $this->lang->line('category_cate_ordering'),
		                 'rules'   => 'required|integer'
		              ),
				);
		  		$this->form_validation->set_rules($valid);
				if ($this->form_validation->run() == true)
				{
					$input = array(
						'name' => $this->input->post('name'),
						'ordering' => (int) $this->input->post('ordering'),
						'parent' => (int) $this->input->post('parent'),
			            'description' => $this->input->post("description"),
			            'images' => $this->input->post("images"),
			            'icon' => $this->input->post("icon"),
			            'type' => (int) $this->input->post('type'),
			            'show_home' => (int) $this->input->post('show_home'),
			            'hide_folder' => (int) $this->input->post('hide_folder'),
			            'seo_title' => $this->input->post("seo_title"),
			            'seo_keyword' => $this->input->post("seo_keyword"),
			            'seo_description' => $this->input->post("seo_description"),
					);
					if ($action == 'add') {
						$result = $this->category->cate_insert($input);
						if ($item_id = $result) {
							$html =$this->load->view('category/cate_form',$this->_add()); 
						}
					}
					else {
						if ($this->security->verify_token_post($params['id'],$this->input->post('token'))) {
							$result = $this->category->cate_update($params['id'],$input);	
						}
						if ($result) {
							$item_id = $params['id'];
							$html =$this->load->view('category/cate_form',$this->_edit($params['id'])); 
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
				$result = $this->category->cate_delete($arrId);
				
				if ($result) {
					// log action
	                $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $arrId));
	                // return result
					$html = $this->load->view('category/cate_list',$this->_index()); 
					return $this->output->set_output(json_encode(array('status' => 'success','html' => $html, 'result' => $result, 'message' => $this->lang->line("common_delete_success"))));
				}
			break;
			default:
				# code...
				break;
		}	
		return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_no_row_update"))));
	}
	//////// AJAX //////
	public function gettype() {
		$type_id = (int) $this->input->get('type_id');
		$this->load->model('admin/category_model','category');
		$arrCategory = $this->category->get_category(array('type' => $type_id));
		$arrCategoryRecursive = $this->category->recursiveCate($arrCategory);
		return $this->output->set_output(json_encode(array('status' => 'success', 'data' => array_values($arrCategoryRecursive))));
	}
}