<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Test extends CI_Controller{
	public $module = 'test';
	private $_test_type = 2;
    function __construct(){
		parent::__construct();
		$this->load->setData('title','Danh sách bài test');

	}
	public function index(){
		if ($this->input->post('delete'))
		{
			return $this->_action('delete');
		}
		$this->load->setArray(array("isLists" => 1));
		$data = $this->_index();
		// render view
		$this->load->layout('test/index',$data);
	}
	public function add(){
        // load model
		if ($this->input->post('submit')){
			return $this->_action('add');
		}
		$this->load->setArray(array("isForm" => 1));
		// get data
		$data = $this->_add();
		$this->load->layout('test/form',$data);
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
		$this->load->layout('test/form',$data);
	}
	public function copy($id = 0) {
		$id = (int) $id;
		if ($this->input->post('submit')) {
			return $this->_action('copy', array('id' => $id));
		}
		$this->load->setArray(array("isForm" => 1));
		$data = $this->_edit($id);
		if (!$data) {
			show_404();
		}
		$this->load->layout('test/form', $data);
	}
	public function result(){
		if ($this->input->post('delete'))
		{
			return $this->_action('result_delete');
		}
		$type = $this->input->get('type');
		if(!$type){
			redirect(SITE_URL.'/test/result?type=listening','location','301');
		}
		$this->load->setArray(array("isLists" => 1));
		$data = $this->_result_index($type);
		// render view
		$this->load->layout('test/result_index',$data);
	}
	public function result_add(){
        // load model
		if ($this->input->post('submit')){
			return $this->_action('result_add');
		}
		$type = $this->input->get('type');
		if(!$type){
			redirect(SITE_URL.'/test/result?type=listening','location','301');
		}
		$this->load->setArray(array("isForm" => 1));
		// render view
		$this->load->layout('test/result_form', array('type' => $type));
	}
	public function result_edit($id){
        // load model
		if ($this->input->post('submit')){
			return $this->_action('result_edit', array('id' => $id));
		}
		$this->load->setArray(array("isForm" => 1));
		$data = $this->_result_edit($id);
		if (!$data) {
			show_404();
		}
		// render view
		$this->load->layout('test/result_form',$data);
	}
	private function _index(){
		$limit = $this->config->item("limit_item");
		$this->load->model('admin/test_model','test');
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
			'cate_id' => $this->input->get('cate_id'),
		),'filter_item');
		$params = array_merge($params,$params_filter);
		// get data
		$rows = $this->test->lists($params);
		/** PAGING **/
		$config['total_rows'] = count($rows);
  		$config['per_page'] = $limit;
  		$this->load->library('paging',$config);
  		$paging = $this->paging->create_links();
		unset($rows[$limit]);
		// arrCate
		$arrCate = $this->category->get_category(array('type' => $this->_test_type));
		$arrCate = $this->category->recursiveCate($arrCate);

        foreach ($rows as $key_mono => $item_mono) {
            $rows[$key_mono]['share_url'] = str_replace('/test/','/test/listening/',$item_mono['share_url']);
        }
		return array('rows' => $rows, 'paging' => $paging, 'arrCate' => $arrCate,'filter' => $params_filter);
	}
	private function _add() {
		$this->load->model('admin/category_model','category');
		$this->load->model('admin/group_model','group');
		// get array cate
		$arrCate = $this->category->get_category(array('type' => $this->_test_type));
		$arrCateRev = $this->category->recursiveCate($arrCate);
		$arrGroup = $this->group->lists();
		return array(
			'arrCate' => $arrCateRev,
			'row' => array(),
			'arrGroup' => $arrGroup
		);
	}
	private function _edit($id) {
		$this->load->model('admin/category_model','category');
		$this->load->model('admin/group_model','group');
		$this->load->model('admin/test_model','test');
		// row detail
		$userLevel = $this->permission->get_level_user();
		if ($userLevel == 1) {
			$params['user_id'] = $this->permission->get_user_id();
		}

		$row = $this->test->detail($id,$params);
		if (!$row) {
			return array();
		}
		// get array cate
		$arrCate = $this->category->get_category(array('type' => $this->_test_type));
		$arrCate = $this->category->recursiveCate($arrCate);
		//get test to class
		$arrGroupByTest = $this->test->get_group_by_test($id);
		$arrGroup = $this->group->lists();
		$arrGroupId = array();
		foreach ($arrGroupByTest as $key => $group) {
			$arrGroupId[] = $group['class_id'];
		}
		return  array(
			'arrCate' => $arrCate,
			'row' => $row,
			'arrGroupId' => $arrGroupId,
			'arrGroup' => $arrGroup,
		);
	}
	//////////////////////RESULT////////////////////////////
	private function _result_index($type){
		if(!$type){
			return array();
		}
		$this->load->model('admin/test_model','test');
		// get data
		$rows = $this->test->result_lists($type);
		$this->load->setArray(array("isLists" => 1));
		return array('rows' => $rows, 'type' => $type);
	}
	private function _result_edit($id) {
		$this->load->model('admin/test_model','test');
		// row detail
		$row = $this->test->result_detail($id);
		if (!$row) {
			return array();
		}
		return  array(
			'row' => $row,
			'type' => $row['type']
		);
	}

    /////////////////////////////////////// QUESTION /////////////////////////////
    public function question_index($test_id){
    	$test_id = (int)$test_id;
		if(!$test_id){
			show_404();
		}	
		$this->load->model('admin/test_model','test');
		$row = $this->test->detail($test_id);
		if(!$row){
			show_404();
		}
		if ($this->input->post('delete'))
		{
			return $this->_action('question_delete',array('test_id' => $test_id));
		}
		$this->load->setArray(array("isLists" => 1));
		$data = $this->_question_index($test_id);
		$data['test_detail'] = $row;
		// render view
		$this->load->layout('test/question_index',$data);
    }

    public function _question_index($test_id){
		$this->load->model('admin/test_model','test');
		$arrQuestion = $this->test->list_question(array('test_id' => $test_id,'parent_id' => 0));
		$arrQuestionId = array(); $arrQuestionData = array();
		foreach ($arrQuestion as $key => $value) {
			$arrQuestionId[] = $value['question_id']; 
			$arrQuestionData[$value['question_id']] = $value;
		}
		//// LIST QUESTION /////
		$arrQuestionChild = $this->test->list_question(array('test_id' => $test_id,'parent_id' => $arrQuestionId));
		foreach ($arrQuestionChild as $key => $childData) {
			$arrQuestionData[$childData['parent_id']]['child'][] = $childData; 
			$arrChildQuestionId[] = $childData['question_id'];
		}
		/// LIST SUB QUESTION 
		$answerData = array();
		if ($arrChildQuestionId) {
			$arrAnswer = $this->test->get_answer_by_question(array('question_id' =>$arrChildQuestionId));
			foreach ($arrAnswer as $key => $answer) {
				$answerData[$answer['question_id']][] = $answer;
			}
		}

		// get config data
		$this->load->config('data');
		// set data
		return array('rows' => $arrQuestionData, 'answerData' => $answerData);
	}
	public function answer_delete() {
		if ($this->input->post('delete'))
		{
			return $this->_action('answer_delete',array('test_id' => $test_id));
		}
	}
	public function answer_add($question_id) {
		$this->load->model('admin/test_model','test');
		$row = $this->test->question_detail($question_id);
		if(!$row){
			show_404();
		}
		$type = $row['type'];
        if ($this->input->post('submit')){
			return $this->_action('answer_add',array('question_id' => $question_id,'test_id' => $row['test_id'],'type' => $type));
		}
		$this->load->setArray(array("isForm" => 1));
        $this->load->layout('test/answer_form_'.$type,$data);
	}
	public function answer_edit($answer_id) {
		$this->load->model('admin/test_model','test');
		$row = $this->test->answer_detail($answer_id);
		
		if(!$row){
			show_404();
		}
		$questionData = $this->test->question_detail($row['question_id']);
		$type = $questionData['type'];
        if ($this->input->post('submit')){
			return $this->_action('answer_edit',array('answer_id' => $answer_id, 'question_id' => $row['question_id'],'test_id' => $questionData['test_id'],'type' => $type));
		}
		$arrResult = $this->test->get_answer_result($answer_id);
		if($row['dictionary']){
			$arr_dict = json_decode($row['dictionary'], true);
			$this->load->model('admin/dictionary_model','dictionary');
			$direct = $this->dictionary->lists(array('arr_dict' => $arr_dict));
		}
		$data = array(
			'row' => $row,
			'arrResult' => $arrResult,
			'arrTag' => $direct
		);
		$this->load->setArray(array("isForm" => 1));
        $this->load->layout('test/answer_form_'.$type,$data);
	}
	public function question_add(){
		
		$parent_id = (int) $this->input->get('parent');
		$this->load->model('admin/test_model','test');
		$this->load->config('data');
		if ($parent_id) {
			$parentQuestion = $this->test->question_detail($parent_id);	
			$type = $parentQuestion['type'];
			$test_id = $parentQuestion['test_id'];
		}
		else {
			$type = (int)$this->input->get('type');
			$test_id = (int)$this->input->get('testid');
		}
		if ($type <= 0) {
            return $this->load->layout('test/question_choose'); 
        }
		// load model
		if ($this->input->post('submit')){
			return $this->_action('question_add',array('test_id' => $test_id,'type' => $type,'parent_id' => $parent_id));
		}		
		$this->load->setArray(array("isForm" => 1));
		// get data
		$data = $this->_question_add();
		//$data['test_detail'] = $row;
		$data['type'] = $type;
		$data['parent_id'] =  $parent_id;

		$this->load->layout('test/question_form_'.$type,$data);

	}
	public function _question_add(){
		return array();
	}

	public function question_edit($question_id){
		$question_id = (int)$question_id;
		if(!$question_id){
			show_404();
		}	
		// load model
		if ($this->input->post('submit')){
			return $this->_action('question_edit',array('question_id' => $question_id));
		}	
		$this->load->setArray(array("isForm" => 1));
		// get data
		$data = $this->_question_edit($question_id);
		$this->load->layout('test/question_form_'.$data['type'],$data);
	}
	public function _question_edit($question_id){
		$this->load->model('admin/test_model','test');
		$row = $this->test->question_detail($question_id);
		if(!$row){
			show_404();
		}
		$type = $row['type'];
		if ($row['parent_id']) {
			$parent = $this->test->question_detail($row['parent_id']);
			$type = $parent['type'];
		}

		$answer = $this->test->get_answer_by_question(array('question_id' => $question_id));
		return array('row' => $row,'answer' => $answer,'type' => $type,'parent_id' => $row['parent_id']);
	}
	
	/////////////////////////LOG TEST////////////////////////////
	public function log_export() {
		$data = $this->_log_lists(array('limit' => 10000));
		$rows = $data['rows'];
		$filename = 'Export-Test-Log-'.date('d-m-Y').'.xlsx';
        $this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel();
        $i = 1; 
        $baseRow = 2;
        foreach($rows as $key => $row){   
            $count = $baseRow + $key;
            if($i == 1){
                $objPHPExcel->getActiveSheet(0)
                ->setCellValue('A'.$i, "Bài test")
                ->setCellValue('B'.$i, "Link")
                ->setCellValue('C'.$i, "Tên thành viên")
                ->setCellValue('D'.$i, "Email")
                ->setCellValue('E'.$i, "Điện thoại")
                ->setCellValue('F'.$i, "Điểm")
                ->setCellValue('G'.$i, "Ngày làm");
            }
            $objPHPExcel->getActiveSheet()->insertNewRowBefore($count,1);
            $objPHPExcel->getActiveSheet(0)
                ->setCellValue('A'.$count, $row['test_title'])
                ->setCellValue('B'.$count, $row['share_url'])
                ->setCellValue('C'.$count, $row['fullname'])
                ->setCellValue('D'.$count, $row['email'])
                ->setCellValue('E'.$count, $row['phone'])
                ->setCellValue('F'.$count, $row['score'])
                ->setCellValue('G'.$count, date('d/m/Y H:i:s',$row['start_time']))
                ;
            $i++;
        }
        $objPHPExcel->getActiveSheet()->setTitle($filename);
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachement; filename="' . $filename . '"');
        ob_end_clean();
        return $objWriter->save('php://output');exit();
	}
	public function log_lists(){
		if ($this->input->post('delete'))
		{
			return $this->_action('log_delete');
		}

		$this->load->setArray(array("isLists" => 1));
		$data = $this->_log_lists();
		// render view

        $rows_new =  $data['rows'];
        $rows_fulltest = array();
        foreach ($rows_new as $key_one_row => $value_one_row){
            if (isset($value_one_row['timestamp_fulltest'])){
                $timestamp_fulltest = (int) $value_one_row['timestamp_fulltest'];
                if ($timestamp_fulltest > 0){
                    array_push($rows_fulltest,$value_one_row);
                    unset($rows_new[$key_one_row]);
                }
            }
        }
		$this->load->layout('test/log_lists',$data);
	}
	private function _log_lists($options = array()){
		$limit = (!$options['limit']) ? $this->config->item("limit_item") : $options['limit'];
		$this->load->model('admin/test_model','test');
		// get level of user 
		$page = (int) $this->input->get('page');
		$offset = ($page > 1) ? ($page - 1) * $limit : 0;
		$params = array('limit' => $limit + 1,'offset' => $offset);
		////////////////// FITER /////////
		$params_filter = array_filter(array(
			'title' => $this->input->get('title'),
			'email' => $this->input->get('email'),
			'test_id' => (int) $this->input->get("test_id"),
			'from_date' => ($fromdate = $this->input->get('from_date')) ? convert_datetime($fromdate) : (time() - 6*30*3600*24), // 6 thang
			'to_date' => ($todate = $this->input->get('to_date')) ? convert_datetime($todate) : time()
		),'filter_item');
		$params = array_merge($params,$params_filter);
		// get data
		$rows = $this->test->log_lists($params);
        $rows = array_reverse($rows);

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

	public function _action($action, $params = array()) {
		$this->load->model('admin/test_model','test');
		$this->load->model('admin/logs_model','logs');
		switch ($action) {
			case 'add':
			case 'copy':
			case 'edit':
				$this->load->library('form_validation');
				$valid = array(
					array(
		                 'field'   => 'title',
		                 'label'   => 'Tên bài test',
		                 'rules'   => 'required'
		            ),
		            array(
		                'field'   => 'original_cate',
		                'label'   => 'Nhóm',
		                'rules'   => 'is_natural_no_zero'
		            )
				);
		  		$this->form_validation->set_rules($valid);
				if ($this->form_validation->run() == true)
				{
					$input['test'] = array(
						'title' => $this->input->post('title'),
						'publish' => intval($this->input->post('publish')),
			            'original_cate' => intval($this->input->post("original_cate")),
			            'publish_time' => (int) convert_datetime($this->input->post('publish_time')),
						'description' => $this->input->post('description'),
			            'images' => $this->input->post('images'),
			            'type' => 1,
			            'author' => $this->input->post('author'),
					);
					if (!$this->permission->check_permission_backend('publish')) {
						unset($input['test']['publish']);
					}
					if ($action == 'add' || $action == "copy") {
						$result = $this->test->insert($input);
						if ($item_id = $result) {
							$html =$this->load->view('test/form',$this->_add()); 
						}
					}
					else {
						if ($this->security->verify_token_post($params['id'],$this->input->post('token'))) {
							$result = $this->test->update($params['id'],$input);	
						}
						if ($result) {
							$item_id = $params['id'];
							$html =$this->load->view('test/form',$this->_edit($params['id'])); 
						}
					}
					if ($result) {
						//Insert question & question_answer
						if($action == "copy"){
							//Get list question
							$list_question = $this->test->list_question(array('test_id' => $params['id'], 'parent_id' => array(0)));	
							if($list_question){
								//Insert question
								foreach ($list_question as $question) {
									$old_question_id = $question['question_id'];
									$removeKeys = array('question_id', 'create_time','parent_id','test_id');
									foreach($removeKeys as $key) {
									   unset($question[$key]);
									}
									$question['test_id'] = $item_id;
									$news_question_id = $this->test->question_insert($question);
									//Get list question child
									$list_question_child = $this->test->list_question(array('test_id' => $params['id'], 'parent_id' => array($old_question_id)));
									if($list_question_child){
										foreach ($list_question_child as $question_child) {
											$old_question_child_id = $question_child['question_id'];
											$removeKeys = array('question_id', 'create_time','parent_id','test_id');
											foreach($removeKeys as $key) {
											   unset($question_child[$key]);
											}
											$question_child['test_id'] = $item_id;
											$question_child['parent_id'] = $news_question_id;

											$news_question_child_id = $this->test->question_insert($question_child);

											//Get list question_answer by question
											$list_answer = $this->test->get_answer_by_question(array('question_id' => $old_question_child_id));
											if($list_answer){
												//Insert answer
												foreach ($list_answer as $answer) {
													$removeKeys = array('answer_id', 'question_id');
													foreach($removeKeys as $key) {
													   unset($answer[$key]);
													}
													$answer['question_id'] = $news_question_child_id;
													$this->test->answer_insert(array('question' => $answer));
												}
											}
										}
									}
								}
							}
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
				$result = $this->test->delete($arrId);
				
				if ($result) {
					// log action
                    $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $arrId));
                    // return result
					$html = $this->load->view('test/index',$this->_index()); 
					return $this->output->set_output(json_encode(array('status' => 'success','html' => $html, 'result' => $result, 'message' => $this->lang->line("common_delete_success"))));
				}
			break;
			case 'question_add':
			case 'question_edit':
				$this->load->library('form_validation');
				$valid = array(
					array(
		                 'field'   => 'title',
		                 'label'   => 'Tên câu hỏi',
		                 'rules'   => 'required'
		            ),
				);
		  		$this->form_validation->set_rules($valid);
				if ($this->form_validation->run() == true)
				{
					$input = array(
						'title' => $this->input->post('title'),
						'ordering' => (int) $this->input->post('ordering'),
						'publish' => intval($this->input->post('publish')),
						'detail' => $this->input->post('detail'),
						'tapescript' => $this->input->post('tapescript'),
			            'images' => $this->input->post('images'),
			            'sound' => $this->input->post('sound'),
			            'test_time' => $this->input->post('test_time'),
			            'audio_start_time' => $this->input->post('audio_start_time')
					);	
					if ($this->input->post('group')) {
						$input['group'] = $this->input->post('group');
					}				
					if ($action == 'question_add') {
						$input['type'] = $this->input->post('type');
						$input['test_id'] = (int)$params['test_id'];
						$input['parent_id'] = (int) $params['parent_id'];
						$result = $this->test->question_insert($input);
						if($result){
							//insert answer
							$answer = $this->input->post('answer');
							if ($answer) {
								$this->test->answer_insert($result,$answer);
							}
							$item_id = $result;
							$redirect = SITE_URL.'/test/question_index/'.$input['test_id'];
						}
					}
					else {
						if ($this->security->verify_token_post($params['question_id'],$this->input->post('token'))) {
							$result = $this->test->question_update($params['question_id'],$input);
							//insert answer
							$answer = $this->input->post('answer');
							if ($answer) {
								$this->test->answer_insert($params['question_id'],$answer);	
							}
						}
						if($result){
							$item_id = $params['question_id'];
							$html =$this->load->view('test/question_form',$this->_question_edit($params['question_id'])); 
						}
					}
					if ($result) {
						// log action
	                    $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $item_id));
	                    // return result
						return $this->output->set_output(json_encode(array('status' => 'success', 'html' => $html, 'redirect' => $redirect,'result' => $result, 'message' => $this->lang->line("common_update_success"))));
					}
				}
				else{
					return $this->output->set_output(json_encode(array('status' => 'error','valid_rule' => $this->form_validation->error_array(), 'message' => $this->lang->line("common_update_validator_error"))));
				}
			break;
			case 'question_delete':
				$arrId = $this->input->post('cid');
				$arrId = (is_array($arrId)) ? array_map('intval', $arrId) : (int) $arrId;
				if (!$arrId) {
					return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_delete_min_select"))));
				}
				if (!$this->permission->check_permission_backend('delete')){
					return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_access_denied"))));
				}
				$result = $this->test->question_delete($arrId);
				
				if ($result) {
					// log action
                    $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $arrId));
                    // return result
					$html = $this->load->view('test/question_index',$this->_question_index($params['test_id'])); 
					return $this->output->set_output(json_encode(array('status' => 'success','html' => $html, 'result' => $result, 'message' => $this->lang->line("common_delete_success"))));
				}
			break;
			case 'answer_add':
			case 'answer_edit':
				$this->load->library('form_validation');
				if ($params['type'] == 201 || $params['type'] == 301) {
					$valid = array(
						array(
			                 'field'   => 'content',
			                 'label'   => 'Nội dung câu hỏi',
			                 'rules'   => 'required'
			            ),
					);
				}
				else {
					$valid = array(
						array(
			                 'field'   => 'params',
			                 'label'   => 'Nội dung câu hỏi',
			                 'rules'   => 'required'
			            ),
					);
				}
		  		$this->form_validation->set_rules($valid);
				if ($this->form_validation->run() == true)
				{
					if ($params['type'] == 201 || $params['type'] == 301) {
						$number_question = 1;
						$optionsParams = json_encode($this->input->post('options'));
						$postParams = json_encode($this->input->post('params'));

					} else {
						$input['answer'] = array_filter($this->input->post('answer'));
						$arrParams = explode("\n", str_replace("\r", "", $this->input->post('params')));
						$number_question = count($input['answer']);
						if ($number_question <= 0) {
							return $this->output->set_output(json_encode(array('status' => 'error', 'message' => 'Chưa chọn đáp án nào')));
						}
						
						if ($number_question != count($arrParams) && $params['type'] != 104) {
							return $this->output->set_output(json_encode(array('status' => 'error', 'message' => 'Câu hỏi và đáp án không trùng nhau')));
						}
						$postParams = json_encode($arrParams);
						$optionsParams = ($options = $this->input->post('options')) ? explode("\n", str_replace("\r", "", $options)) : array();
						$optionsParams = json_encode($optionsParams);
					}
					$input['question'] = array(
						'content' => $this->input->post('content'),
						'params' => $postParams,
						'ordering' => (int) $this->input->post('ordering'),
						'number_question' => $number_question,
						'options' => $optionsParams,
						'dictionary' => $this->input->post('tag_exist') ? json_encode($this->input->post('tag_exist')) : '',
					);

					$redirect = SITE_URL.'/test/question_index/'.(int) $params['test_id'];				
					if ($action == 'answer_add') {
						$input['question']['question_id'] = (int)$params['question_id'];
						$result = $this->test->answer_insert($input);
						
					}
					else {
						if ($this->security->verify_token_post($params['answer_id'],$this->input->post('token'))) {
							$result = $this->test->answer_update($params['answer_id'],$input);
						}
					}
					if ($result) {
						// log action
	                    $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $item_id));
	                    // return result
						return $this->output->set_output(json_encode(array('status' => 'success', 'html' => $html, 'redirect' => $redirect,'result' => $result, 'message' => $this->lang->line("common_update_success"))));
					}
				}
				else{
					return $this->output->set_output(json_encode(array('status' => 'error','valid_rule' => $this->form_validation->error_array(), 'message' => $this->lang->line("common_update_validator_error"))));
				}
			break;
			case 'answer_delete':
				$arrId = $this->input->post('cid');
				$arrId = (is_array($arrId)) ? array_map('intval', $arrId) : (int) $arrId;
				if (!$arrId) {
					return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_delete_min_select"))));
				}
				if (!$this->permission->check_permission_backend('answer_delete')){
					return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_access_denied"))));
				}
				$redirect = current_url();
				$result = $this->test->answer_delete($arrId);
				
				if ($result) {
					// log action
                    $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $arrId));
                    // return result
					
					return $this->output->set_output(json_encode(array('status' => 'success','redirect' => $redirect, 'result' => $result, 'message' => $this->lang->line("common_delete_success"))));
				}
			break;
			case 'log_delete':
				$arrId = $this->input->post('cid');
				$arrId = (is_array($arrId)) ? array_map('intval', $arrId) : (int) $arrId;
				if (!$arrId) {
					return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_delete_min_select"))));
				}
				if (!$this->permission->check_permission_backend('delete')){
					return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_access_denied"))));
				}
				$result = $this->test->log_delete($arrId);

				
				if ($result) {
					// log action
                    $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $arrId));
                    // return result
					$html = $this->load->view('test/log_lists',$this->_log_lists()); 
					return $this->output->set_output(json_encode(array('status' => 'success','html' => $html, 'result' => $result, 'message' => $this->lang->line("common_delete_success"))));
				}
			break;
			case 'mark_result':
				$arrReview = $this->input->post('result');
				$input = array(
					'score_detail' => json_encode($arrReview),
					'status' => 2
				);

				$test_type = $params['logs_detail']['test_type'];
				if($test_type == 3) {		//Writing
					$total_coefficient = $total_score = 0;
					foreach ($arrReview as $review) {
						$total_score += $review['score'] * $review['coefficient'];
						$total_coefficient += $review['coefficient'];
					}
					$input['score'] = round(($total_score / $total_coefficient) * 2) / 2;
					$test_type_name = "Writing";
				}elseif($test_type == 4){
					$input['score'] = $this->input->post('score');
					$test_type_name = "Speaking";
				}

				if ($this->security->verify_token_post($params['id'],$this->input->post('token'))) {
					$result = $this->test->test_log_update($params['id'],$input);	
				}
				if ($result) {
					$item_id = $params['id'];
					$html = $this->load->view('test/mark_result_'.$test_type,$this->_mark_result($params['id'])); 
					
					$user = json_decode($params['logs_detail']['params'], TRUE);

					//Send mail cho học viên
					$data = array(
						'user' => $user,
						'answer' => json_decode($params['logs_detail']['answer_list'], TRUE),
						'arrReview' => $arrReview,
						'total_score' => $input['score']
					);
					$html_mail = $this->load->view('test/email/mark_result_'.$test_type,$data,TRUE);
                    send_mail($user['email'],'Aland IELTS - Chấm điểm bài test '.$test_type_name, $html_mail);
					//End send mail

					// log action
                    $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $item_id));
                    // return result
					return $this->output->set_output(json_encode(array('status' => 'success', 'html' => $html, 'result' => $result, 'message' => $this->lang->line("common_update_success"))));
				}
				
			break;
			case 'result_add':
			case 'result_edit':
				$this->load->library('form_validation');
				$valid = array(
					array(
		                 'field'   => 'score_min',
		                 'label'   => 'Điểm từ',
		                 'rules'   => 'required'
		            ),
		            array(
		                 'field'   => 'score_max',
		                 'label'   => 'Đến',
		                 'rules'   => 'required'
		            ),
				);
		  		$this->form_validation->set_rules($valid);
				if ($this->form_validation->run() == true)
				{
					$input = array(
						'score_min' => $this->input->post('score_min'),
						'score_max' => $this->input->post('score_max'),
						'result' => $this->input->post('result'),
						'suggest' => $this->input->post('suggest'),
					);	
					if ($action == 'result_add') {
						$type = $this->input->post('type');
						if(!in_array($type, array('listening', 'reading', 'writing', 'speaking', 'fulltest'))){
							return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_update_validator_error"))));
						}
						$input['type'] = $type;

						$result = $this->test->result_insert($input);
						if($result){
							$html = $this->load->view('test/result_form',array('type' => $type)); 
						}
					}
					else {
						if ($this->security->verify_token_post($params['id'],$this->input->post('token'))) {
							$result = $this->test->result_update($params['id'],$input);
						}
						if($result){
							$item_id = $params['id'];
							$html =$this->load->view('test/result_form',$this->_result_edit($params['id'])); 
						}
					}
					if ($result) {
						// log action
	                    $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $item_id));
	                    // return result
						return $this->output->set_output(json_encode(array('status' => 'success', 'html' => $html, 'redirect' => $redirect,'result' => $result, 'message' => $this->lang->line("common_update_success"))));
					}
				}
				else{
					return $this->output->set_output(json_encode(array('status' => 'error','valid_rule' => $this->form_validation->error_array(), 'message' => $this->lang->line("common_update_validator_error"))));
				}
				break;
			case 'result_delete':
				$arrId = $this->input->post('cid');
				$arrId = (is_array($arrId)) ? array_map('intval', $arrId) : array($arrId);
				if (!$arrId) {
					return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_delete_min_select"))));
				}
				if (!$this->permission->check_permission_backend('result_delete')){
					return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_access_denied"))));
				}
				$result = $this->test->result_delete($arrId);
				if ($result) {
					// log action
                    $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $arrId));
                    // return result
                    $type = $this->input->get('type');
					$html = $this->load->view('test/result_index',$this->_result_index($type)); 
					return $this->output->set_output(json_encode(array('status' => 'success','html' => $html, 'result' => $result, 'message' => $this->lang->line("common_delete_success"))));
				}
			break;
			default:
				# code...
				break;
		}	
		return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_no_row_update"))));
	}

	public function suggest_test(){
		$keyword = $this->input->get("term");
        $page = (int) $this->input->get('page');
        $page = ($page > 1) ? $page : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $this->load->model('admin/test_model','test');
        $params = array('limit' => $limit + 1,'keyword' => $keyword,'offset' => $offset);
        $arrTest = $this->test->lists($params);
        $data = $option = array();
        if (count($arrTest) > $limit) {
            $option['nextpage'] = true;
            unset($arrTest[$limit]);
        }
        foreach ($arrTest as $key => $test) {
            $data[] = array('id' => $test['test_id'], 'text' => $test['title'],'item_id' => $test['test_id']);
        }
        return $this->output->set_output(json_encode(array('status' => 'success','data' => $data,'option' => $option)));
	}

	public function question_sort(){
        $test_id = $this->input->post('test_id');
        $arrQuestionId = $this->input->post('question_id');
        if (!$test_id || !$arrQuestionId) {
            return $this->output->set_output(json_encode(array('status' => 'error', 'message' => 'Thứ tự không thay đổi')));
        }
        // get question by test_id
        $this->load->model('admin/test_model','test');

        $i = 1;
        foreach ($arrQuestionId as $question_id) {
            $this->test->question_update($question_id,array('ordering' => $i));
        	$i ++;
        }
        return $this->output->set_output(json_encode(array('status' => 'success', 'message' => 'Đã cập nhật thông tin')));
    }

    public function mark_lists(){
        if ($this->input->post('delete'))
        {
            return $this->_action('log_delete');
        }

        $this->load->setArray(array("isLists" => 1));
        $data = $this->_mark_lists();

        $rows_new =  $data['rows'];
        $rows_fulltest = array();
        foreach ($rows_new as $key_one_row => $value_one_row){
            if (isset($value_one_row['timestamp_fulltest'])){
                $timestamp_fulltest = (int) $value_one_row['timestamp_fulltest'];
                if ($timestamp_fulltest > 0){
                    array_push($rows_fulltest,$value_one_row);
                    unset($rows_new[$key_one_row]);
                }
            }
        }
        $this->load->layout('test/mark_lists',$data);
    }

    private function _mark_lists($options = array()){
        $limit = (!$options['limit']) ? $this->config->item("limit_item") : $options['limit'];
        $this->load->model('admin/test_model','test');
        // get level of user
        $page = (int) $this->input->get('page');
        $offset = ($page > 1) ? ($page - 1) * $limit : 0;
        $params = array('limit' => $limit + 1,'offset' => $offset);
        ////////////////// FITER /////////
        $params_filter = array_filter(array(
            'status' => $this->input->get('status'),
            'test_type' => $this->input->get('test_type'),
            'keyword' => $this->input->get('title'),
        ),'filter_item');
        $params = array_merge($params,$params_filter);
        // get data
        $rows = $this->test->mark_lists($params);
        $rows = array_reverse($rows);

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

    public function mark_result($id){
        $id = (int) $id;
        $data = $this->_mark_result($id);
		if (!$data) {
			show_404();
		}
        if ($this->input->post('submit')){
			return $this->_action('mark_result',array('id' => $id, 'logs_detail' => $data['row']));
		}
		$this->load->setArray(array("isForm" => 1));
		$test_type = $data['row']['test_type'];
		$this->load->layout('test/mark_result_'.$test_type, $data);
    }

    private function _mark_result($id){
    	$this->load->model('admin/category_model','category');
		$this->load->model('admin/group_model','group');
		$this->load->model('admin/test_model','test');
		// row detail
		$row = $this->test->test_log_detail(array('logs_id' => $id));
		if (!$row) {
			return array();
		}
		$arrParentQuestion = $this->test->get_question_by_test(array('test_id' => $row['test_id'], 'type' => $row['test_type']));

		$arrParentId = array();
        foreach ($arrParentQuestion as $key => $questionDetail) {
            $arrParentId[] = $questionDetail['question_id'];
        }
        $arrQuestion = $this->test->get_question_group(array('parent_id' => $arrParentId));
        $arrQuestion =  array_shift($arrQuestion);

		return  array(
			'row' => $row,
			'arrQuestion' => $arrQuestion,
		);
    }
}