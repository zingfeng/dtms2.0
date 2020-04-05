<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Comment extends CI_Controller{
	public $module = 'comment';
    function __construct(){
		parent::__construct();
		$this->lang->load('backend/comment');
		$this->load->setData('title',$this->lang->line('comment_title'));

	}
    ////////////////////////////////// comment /////////////////////////////////
    public function index(){
		if ($this->input->post('delete'))
		{
			return $this->_action('delete');
		}
		$this->load->setArray(array("isLists" => 1));
		$data = $this->_index();
		// render view
		$this->load->layout('comment/list',$data);
	}
	public function _index(){
		$this->load->model('admin/comment_model','comment');
		// get array cate
		$params = array(
			'from_date' => ($fromdate = $this->input->get('from_date')) ? convert_datetime($fromdate) : '',
            'to_date' => ($todate = $this->input->get('to_date')) ? convert_datetime($todate) : '',
			'parent_id' => 0,		//Chỉ get comment cha
			'limit' => 10
		);
		$rows = $this->comment->lists($params);
		if($rows) {
			foreach($rows as $row){
				$arrComment[$row['comment_id']] = $row;
				$params_child = array(
					'parent_id' => (int)$row['comment_id'],
					'limit' => 999
				);
				$arrComment[$row['comment_id']]['child'] = $this->comment->lists($params_child);
			}
		}
		// set data
		return array('rows' => $arrComment, 'filter' => $params);
	}

	public function _action($action, $params = array()) {
		$this->load->model('admin/comment_model','comment');
		$this->load->model('admin/logs_model','logs');
		switch ($action) {			
			case 'delete':
				$arrId = $this->input->post('cid');
				$arrId = (is_array($arrId)) ? array_map('intval', $arrId) : (int) $arrId;
				if (!$arrId) {
					return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_delete_min_select"))));
				}
				if (!$this->permission->check_permission_backend('delete')){
					return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_access_denied"))));
				}
				$result = $this->comment->delete($arrId);
				
				if ($result) {
					// log action
	                $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $arrId));
	                // return result
					$html = $this->load->view('comment/list',$this->_index()); 
					return $this->output->set_output(json_encode(array('status' => 'success','html' => $html, 'result' => $result, 'message' => $this->lang->line("common_delete_success"))));
				}
			break;
			default:
				# code...
				break;
		}	
		return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_no_row_update"))));
	}

	public function change_status() {
		$comment_id = (int)$this->input->post('id');
		$this->load->model('admin/comment_model','comment');
		if(!empty($comment_id)){
				if (!$this->permission->check_permission_backend('change_status')){
					return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_access_denied"))));
				}
				$detailComment = $this->comment->detail($comment_id);
				$result = $this->comment->update_status($comment_id, !$detailComment['status']);
				if ($result) {
	                // return result
					$html = $this->load->view('comment/list',$this->_index()); 
					return $this->output->set_output(json_encode(array('status' => 'success','html' => $html, 'result' => $result, 'message' => "Cập nhật trạng thái thành công")));
				}
		}	
		return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_no_row_update"))));
	}	
}