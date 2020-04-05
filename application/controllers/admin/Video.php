<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Video extends CI_Controller{
	public $module = 'video';
    function __construct(){
		parent::__construct();
		$this->load->setData('title','Quản lý Video');

	}
	public function index(){
		if ($this->input->post('delete'))
		{
			return $this->_action('delete');
		}
		$this->load->setArray(array("isLists" => 1));
		$data = $this->_index();
		// render view
		$this->load->layout('video/list',$data);
	}
	
	public function add(){
        // load model
		if ($this->input->post('submit')){
			return $this->_action('add');
		}
		$this->load->setArray(array("isForm" => 1));
		$this->load->setArray(array("isUpload" => 1));
		// get data
		$data = $this->_add();
		$this->load->layout('video/form',$data);
	}
	public function edit($id = 0){
        $id = (int) $id;
        if ($this->input->post('submit')){
			return $this->_action('edit',array('id' => $id));
		}
		$this->load->setArray(array("isForm" => 1));
		$this->load->setArray(array("isUpload" => 1));
		$data = $this->_edit($id);
		if (!$data) {
			show_404();
		}
		$this->load->layout('video/form',$data);
	}
	
	private function _index(){
		$limit = $this->config->item("limit_item");
		$this->load->model('admin/video_model','video');
		$this->load->model('admin/category_model','category');
		// get level of user 
		$page = (int) $this->input->get('page');
		$offset = ($page > 1) ? ($page - 1) * $limit : 0;
		$params = array('limit' => $limit + 1,'offset' => $offset);
		$userLevel = $this->permission->get_level_user();
		if ($userLevel == 1) {
			$params['user_id'] = $this->permission->get_user_id();
		}
		////////////////// FITER /////////
		$params_filter = array_filter(array(
			'keyword' => $this->input->get('title'),
			'publish' => $this->input->get('publish'),
			'cate_id' => $this->input->get('cate_id'),
		),'filter_item');
		$params = array_merge($params,$params_filter);
		// get data
		$rows = $this->video->lists($params);
		/** PAGING **/
		$config['total_rows'] = count($rows);
  		$config['per_page'] = $limit;
  		$this->load->library('paging',$config);
  		$paging = $this->paging->create_links();
		unset($rows[$limit]);
		// arrCate
		$params['type'] = 5;
		$arrCate = $this->category->get_category($params);
		$arrCate = $this->category->recursiveCate($arrCate); 

		// set limit
		$this->load->setArray(array("isLists" => 1));
		// set data
		return array('rows' => $rows, 'paging' => $paging, 'arrCate' => $arrCate,'filter' => $params_filter);
	}
	private function _add() {
		$this->load->model('category_model','category');
		
		// get array cate
		$params['type'] = 5;
		$arrCate = $this->category->get_category($params);
		$arrCateRev = $this->category->recursiveCate($arrCate);
		return array(
			'arrCate' => $arrCateRev
		);
	}
	private function _edit($id) {
		$this->load->model('admin/video_model','video');
		$this->load->model('category_model','category');
		$this->load->model('test_model','test');
		// row detail
		$userLevel = $this->permission->get_level_user();
		if ($userLevel == 1) {
			$params['user_id'] = $this->permission->get_user_id();
		}

		$row = $this->video->detail($id,$params);
		if (!$row) {
			return array();
		}
		$row['params'] = ($row['params']) ? json_decode($row['params'],TRUE) : array();
		$listObject = array();
		foreach($row['params'] as $param){
			if($param['object_id'] && $param['type']){
				$listObject[$param['type']][] = $param['object_id'];
			}
		}
		//get list test
		if($listObject[1]){
			$listTest = $this->test->get_list_by_arr_id($listObject[1]);
			foreach($listTest as $test){
				$arrTest[$test['test_id']] = $test;
			}
		}

		// get array cate
		$params['type'] = 5;
		$arrCate = $this->category->get_category($params);
		$arrCate = $this->category->recursiveCate($arrCate);
		// get course_to_cate
		$arrCateDocs = $this->video->get_cate_by_video($id);
		$arrCateId = array();
		foreach ($arrCateDocs as $key => $cate) {
			$arrCateId[] = $cate['cate_id'];
		}
		return  array(
			'arrCate' => $arrCate,
			'arrCateId' => $arrCateId,
			'row' => $row,
			'arrTest' => $arrTest,
		);
	}	
	public function _action($action, $params = array()) {
		$this->load->model('admin/video_model','video');
		$this->load->model('admin/logs_model','logs');
		switch ($action) {
			case 'add':
			case 'edit':
				$this->load->library('form_validation');
				$valid = array(
					array(
		                 'field'   => 'title',
		                 'label'   => 'Tên tài liệu',
		                 'rules'   => 'required'
		            ),
		            array(
		                'field'   => 'original_cate',
		                'label'   => 'Nhóm tài liệu',
		                'rules'   => 'is_natural_no_zero'
		            )
				);
		  		$this->form_validation->set_rules($valid);
				if ($this->form_validation->run() == true)
				{
					// set input params
					$inputParams = array();
					if ($proParams = $this->input->post('params')) {
						
					}
					$inputParams = json_encode($inputParams);
					// set input to save
					$input['video'] = array(
						'title' => $this->input->post('title'),
						'youtube_id' => $this->input->post('youtube_id_video'),
						'vimeo_id' => $this->input->post('vimeo_id_video'),
						'publish' => intval($this->input->post('publish')),
			            'original_cate' => intval($this->input->post("original_cate")),
						'description' => $this->input->post('description'),
			            'images' => $this->input->post('images'),
			            'params' => $inputParams
					);
					if (!$this->permission->check_permission_backend('publish')) {
						unset($input['video']['publish']);
					}
					//get time video
					$input['category'] = $this->input->post('category');
					if ($action == 'add') {
						$result = $this->video->insert($input);
						if ($item_id = $result) {
							$html =$this->load->view('video/form',$this->_add()); 
						}
					}
					else {
						if ($this->security->verify_token_post($params['id'],$this->input->post('token'))) {
							$result = $this->video->update($params['id'],$input);	
						}
						if ($result) {
							$item_id = $params['id'];
							$html =$this->load->view('video/form',$this->_edit($params['id'])); 
						}
					}
					if ($result) {
						if($input['video']['vimeo_id']){
							$this->convert_status();
						}
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
				$result = $this->video->delete($arrId);
				
				if ($result) {
					// log action
	                $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $arrId));
	                // return result
					$html = $this->load->view('video/list',$this->_index()); 
					return $this->output->set_output(json_encode(array('status' => 'success','html' => $html, 'result' => $result, 'message' => $this->lang->line("common_delete_success"))));
				}
			break;
			
			default:
				# code...
				break;
		}	
		return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_no_row_update"))));
	}

	public function suggest_video(){
		$keyword = $this->input->get("term");
        $page = (int) $this->input->get('page');
        $page = ($page > 1) ? $page : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $this->load->model('admin/video_model','video');
        $params = array('limit' => $limit + 1,'keyword' => $keyword,'offset' => $offset);
        $arrVideo = $this->video->lists($params);
        $data = $option = array();
        if (count($arrVideo) > $limit) {
            $option['nextpage'] = true;
            unset($arrVideo[$limit]);
        }
        foreach ($arrVideo as $key => $video) {
            $data[] = array('id' => $video['video_id'], 'text' => $video['title'],'item_id' => $video['video_id']);
        }
        return $this->output->set_output(json_encode(array('status' => 'success','data' => $data,'option' => $option)));
	}
	public function remote_info($id,$type = 'vimeo') {
		$this->load->library('videocdn');
		$videoInfo = $this->videocdn->getVideoInfo($id,$type);
		$this->output->set_output(json_encode($videoInfo));
	}
	public function testvideo() {
        $this->load->library('videocdn');
        $urlVideo = $this->videocdn->remote('https://api.vimeo.com/videos/277233657');
        var_dump($urlVideo); die;
    }
    public function convert_status() {
		$vimeo_oauth = $this->config->item('vimeo_oauth');
    	$this->load->model('admin/video_model','video');
    	$this->load->library('curl');
    	$arrVideo = $this->video->lists(array('convert_status' => 0,'limit' => 100));
    	$i = 0;
    	$options = array(	
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_HTTPHEADER => array(
	            "authorization: Bearer ". $vimeo_oauth['access_token'],
	            "cache-control: no-cache",
			)
    	);
    	// if (ENVIRONMENT == 'development') {
    	// 	$options[CURLOPT_PROXY] = 'http://proxy.fpt.vn:80';
    	// }
    	foreach ($arrVideo as $key => $video) {
    		$videoInfo = $this->curl->simple_get('https://api.vimeo.com/videos/'.$video['vimeo_id'],array(),$options);
    		if (!$videoInfo) {
    			continue;
    		}
    		$arrVideoInfo = json_decode($videoInfo,TRUE);
    		if ($arrVideoInfo['status'] != 'available') {
    			continue;
    		}
    		$arrVideoInfo = array('convert_status' => 1, 'duration' => $arrVideoInfo['duration'],'size' => json_encode(array('width' => $arrVideoInfo['width'], 'height' => $arrVideoInfo['height'])));
    		$this->video->update($video['video_id'],array('video' => $arrVideoInfo));
    		$i ++;
    	}
    } 
}