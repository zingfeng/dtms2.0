<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dictionary extends CI_Controller{
	public $module = 'expert';
    function __construct(){
		parent::__construct();
		$this->load->setData('title','Từ điển');

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
		$this->load->layout('dictionary/list',$data);
	}
	public function add(){
		if ($this->input->post('submit')) {
			return $this->_action('add');
		}
		$this->load->setArray(array("isForm" => 1));
		$this->load->layout('dictionary/form');
	}
	
	public function edit($id) {
		$id = (int) $id;
		if ($this->input->post('submit')) {
			return $this->_action('edit',array('id' => $id));
		}
		$this->load->setArray(array("isForm" => 1));
		$data = $this->_edit($id);
		$this->load->layout('dictionary/form',$data);
	}
	public function suggest(){
        $keyword = trim($this->input->get("term"));
        $this->load->model('admin/dictionary_model','dictionary');
        $rows = $this->dictionary->lists(array('keyword' => $keyword));
        $result = array();
        foreach ($rows as $row){
            $result[] = '{"id":"'.$row['dict_id'].'","label":"'.$row['word_en'].'","value":"'.$row['word_en'].'"}';
        }
        $this->output->set_output( "[".implode(',', $result)."]" );
    }
	private function _index(){
		$limit = $this->config->item("limit_item");
		$this->load->model('admin/dictionary_model','dictionary');
		// get level of user 
		$page = (int) $this->input->get('page');
		$offset = ($page > 1) ? ($page - 1) * $limit : 0;
		$params = array('limit' => $limit + 1,'offset' => $offset);
		////////////////// FITER /////////
		$params_filter = array_filter(array(
			'keyword' => $this->input->get('keyword'),
		),'filter_item');
		$params = array_merge($params,$params_filter);
		// get data
		$rows = $this->dictionary->lists($params);
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
		$this->load->model('admin/dictionary_model','dictionary');
		$row = $this->dictionary->detail(intval($id));
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
		$this->load->model('admin/dictionary_model','dictionary');
		$this->load->model('admin/logs_model','logs');
		switch ($action) {			
			case 'add':
			case 'edit':
				$this->load->library('form_validation');
				$valid = array(
					array(
		                 'field'   => 'word_en',
		                 'label'   => 'Từ tiếng anh',
		                 'rules'   => 'required'
		              ),
					array(
		                 'field'   => 'word_vn',
		                 'label'   => 'Từ tiếng anh',
		                 'rules'   => 'required'
		              )
				);
		  		$this->form_validation->set_rules($valid);
				if ($this->form_validation->run() == true)
				{
					$input = array(
						'word_en' => trim($this->input->post('word_en')),
			            'word_vn' => $this->input->post("word_vn"),
			            'trans' => trim($this->input->post('trans')),
			            'sound' => $this->input->post("sound")
					);
					if ($action == 'add') {
						//for ($i=0; $i < 10; $i++) { 
							$result = $this->dictionary->insert($input);
						//}
						
						if ($item_id = $result) {
							$html =$this->load->view('dictionary/form',$this->_add()); 
						}
					}
					else {
						if ($this->security->verify_token_post($params['id'],$this->input->post('token'))) {
							$result = $this->dictionary->update($params['id'],$input);	
						}
						if ($result) {
							$item_id = $params['id'];
							$html =$this->load->view('dictionary/form',$this->_edit($params['id'])); 
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
				$result = $this->dictionary->delete($arrId);
				
				if ($result) {
					// log action
	                $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $arrId));
	                // return result
					$html = $this->load->view('dictionary/list',$this->_index()); 
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