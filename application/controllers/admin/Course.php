<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Course extends CI_Controller{
	public $module = 'course';
    function __construct(){
		parent::__construct();
		$this->lang->load('backend/course');
		$this->load->setData('title',$this->lang->line('course_title'));

	}
	public function index(){
		if ($this->input->post('delete'))
		{
			return $this->_action('delete');
		}
		$this->load->setArray(array("isLists" => 1));
		$data = $this->_index();
		// render view
		$this->load->layout('course/list',$data);
	} 
	
	public function add(){ 
        // load model
		if ($this->input->post('submit')){ 
			return $this->_action('add');
		}
		$this->load->setArray(array("isForm" => 1));
		// get data
		$data = $this->_add();
		$this->load->layout('course/form',$data);
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
		$this->load->layout('course/form',$data);
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
		$this->load->layout('course/form', $data);
	} 
	private function _index(){
		$limit = $this->config->item("limit_item");
		$this->load->model('admin/course_model','course');
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
		$rows = $this->course->lists($params);
		/** PAGING **/
		$config['total_rows'] = count($rows);
  		$config['per_page'] = $limit;
  		$this->load->library('paging',$config);
  		$paging = $this->paging->create_links();
		unset($rows[$limit]);
		// arrCate
		$params['type'] = 4;
		$arrCate = $this->category->get_category($params);
		$arrCate = $this->category->recursiveCate($arrCate);
		// set limit
		$this->load->setArray(array("isLists" => 1));
		// set data
		return array('rows' => $rows, 'paging' => $paging, 'arrCate' => $arrCate,'filter' => $params_filter);
	}
	private function _add() {
		$this->load->model('admin/category_model','category');
		$this->load->model('admin/expert_model','expert');
		// get array cate
		$params['type'] = 4;
		$arrCate = $this->category->get_category($params);
		$arrCateRev = $this->category->recursiveCate($arrCate);
		//get teacher
		$arrTeacher = $this->expert->lists(array('publish' => 1));
		//var_dump($arrTeacher); die;
		return array(
			'arrCate' => $arrCateRev,
			'arrTeacher' => $arrTeacher
		);
	}
	private function _edit($id) {
		$this->load->model('admin/course_model','course');
		$this->load->model('admin/video_model','video');
		$this->load->model('admin/category_model','category');
		$this->load->model('admin/expert_model','expert');
		$this->load->model('admin/news_model','news');
		// row detail
		$userLevel = $this->permission->get_level_user();
		if ($userLevel == 1) {
			$params['user_id'] = $this->permission->get_user_id();
		}

		$row = $this->course->detail($id,$params);
		if (!$row) {
			return array();
		}

		$row['params'] = json_decode($row['params'],TRUE);
		// get array cate
		$params['type'] = 4;
		$arrCate = $this->category->get_category($params);
		$arrCate = $this->category->recursiveCate($arrCate);
		// get course_to_cate
		$arrCateCourse = $this->course->get_cate_by_course($id);
		$arrCateId = array();
		foreach ($arrCateCourse as $key => $cate) {
			$arrCateId[] = $cate['cate_id'];
		}
		// get news_to_tag
		$arrTag = $this->course->get_tags_by_course($id);
		//get video detail
        $arrVideo = $this->video->detail($row['video_id']);
        $data_suggest_video = ($arrVideo) ? array('text' =>$arrVideo['title'],'item_id' => $arrVideo['video_id']) : array();
        //data document
        $data_suggest_document = $this->news->detail($row['document_id']);
        //Data test
        $data_test = $this->course->get_test_by_course($id);
        //Data teacher
		$data_teacher = $this->expert->get_teacher_by_course($id);

//		var_dump($data_teacher); exit;
        $data_teacher_offline =  $this->expert->get_teacher_offline_by_course($id);

//        var_dump($data_teacher);
//
//        var_dump($data_teacher_offline);
//        exit;

		return  array(
			'arrCate' => $arrCate,
			'row' => $row,
			'data_teacher' => $data_teacher,
			'data_teacher_offline' => $data_teacher_offline,
			'arrCateId' => $arrCateId,
			'arrTag' => $arrTag,
			'data_suggest_video' => $data_suggest_video,
			'data_suggest_document' => $data_suggest_document,
			'data_document' => $data_document,
			'data_test' => $data_test,
		);
	}
    

    ////////////////////////////////// TOPIC /////////////////////////////////
    public function topic_index($course_id){
    	$course_id = (int)$course_id;
		if(!$course_id){
			show_404();
		}	
		$this->load->model('admin/course_model','course');
		$row = $this->course->detail($course_id);
		if ($this->input->post('delete'))
		{
			if($this->input->post('type') == "class"){
				return $this->_action('class_delete',array('course_id' => $course_id));
			}
			return $this->_action('topic_delete',array('course_id' => $course_id));
		}
		$this->load->setArray(array("isLists" => 1));
		$data = $this->_topic_index($course_id);
		$data['course_detail'] = $row;
		// render view
		$this->load->layout('course/topic_list',$data);
	}
	public function topic_add($course_id){	
		$course_id = (int)$course_id;
		if(!$course_id){
			show_404();
		}	
		$this->load->model('admin/course_model','course');
		$row = $this->course->detail($course_id);
		if(!$row){
			show_404();
		}
		if ($this->input->post('submit')) {
			return $this->_action('topic_add',array('course_id' => $course_id));
		}
		$this->load->setArray(array("isForm" => 1));
		$data = $this->_topic_add($course_id);
		$this->load->layout('course/topic_form',$data);
	}
	
	public function topic_edit($id) {
		$id = (int) $id;
		if ($this->input->post('submit')) {
			return $this->_action('topic_edit',array('id' => $id));
		}
		$this->load->setArray(array("isForm" => 1));
		$data = $this->_topic_edit($id);
		$this->load->layout('course/topic_form',$data);
	}
	public function _topic_index($course_id){
		$this->load->model('admin/course_model','course');
		//get topic
		$rows = $this->course->get_topic_by_course($course_id);
		if(!$rows){
			return array();
		}
		$arrTopicId = array();
		$arrTopic = array();
		foreach($rows as $row){
			$arrTopicId[] = (int)$row['topic_id'];
			$arrTopic[$row['topic_id']] = $row;
		}
		//get class
		if($arrTopicId){
			$arrClass = $this->course->get_class_by_arrtopic($arrTopicId);
			foreach($arrClass as $class){
				$arrTopic[$class['topic_id']]['class'][] = $class;
			}
		}
		// get config data
		$this->load->config('data');
		// set data
		return array('rows' => $arrTopic, 'arrClass' => $arrClass);
	}
	public function _topic_add($course_id){
		// set data to view
		return array(
			'course_id' => $course_id
		);
	}
	public function _topic_edit($id){
		$this->load->model('admin/course_model','course');
		$this->load->model('admin/video_model','video');
		$row = $this->course->topic_detail(intval($id));
		if (!$row) {
			show_404();
		}
		//get video detail
        $arrVideo = $this->video->detail($row['video_id']);
        $data_suggest_video = ($arrVideo) ? array('text' =>$arrVideo['title'],'item_id' => $arrVideo['video_id']) : array();
		// set data to view
		return  array(
			'row' => $row,
			'course_id' => $row['course_id'],
			'data_suggest_video' => $data_suggest_video,
		);
	}
	///////////////////////////CLASS///////////////////
	public function class_add($topic_id){	
		$topic_id = (int)$topic_id;
		if(!$topic_id){
			show_404();
		}	
		$type = (int)$this->input->get('type');
		if ($type <= 0) {
            return $this->load->layout('course/class_layout', array('topic_id' => $topic_id));
        }
		if ($this->input->post('submit')) {
			return $this->_action('class_add',array('topic_id' => $topic_id));
		}
		$this->load->setArray(array("isForm" => 1));
		$data = $this->_class_add($topic_id, $type);
		$this->load->layout('course/class_form_'.$type,$data);
	}
	public function _class_add($topic_id, $type = 1){
		$this->load->model('admin/course_model','course');
		$row = $this->course->topic_detail($topic_id);
		if(!$row){
			show_404();
		}
		// show document suggest
		$limit_docs = 30;
		$this->load->model('admin/news_model','documents');
		$arrDocs = $this->documents->lists(array('limit' => $limit_docs + 1,'publish' => 1));
		$showMoreDocs = (count($arrDocs) > $limit_docs) ? 1 : 0;
		unset($arrDocs[$limit_docs]);
		// get array cate docs recursive
		$this->load->model('admin/category_model','category');
		$arrCateDocs = $this->category->get_category(array('type' => 4));
		$arrCateDocs = $this->category->recursiveCate($arrCateDocs);

		// set data to view
		//var_dump($arrDocs); die;
		return array(
			'type' => $type,
			'course_id' => $row['course_id'],
			'arrDocs' => $arrDocs,
			'showMoreDocs' => $showMoreDocs,
			'arrCateDocs' => $arrCateDocs,
			'rowsDocs' => array()
		);
	}
	public function class_edit($id) {
		$id = (int) $id;
		if ($this->input->post('submit')) {
			return $this->_action('class_edit',array('id' => $id));
		}
		$this->load->setArray(array("isForm" => 1));
		$data = $this->_class_edit($id);

		$this->load->layout('course/class_form_'.$data['row']['type'],$data);
	}
	public function _class_edit($id){
		$this->load->model('admin/course_model','course');
		$this->load->model('admin/video_model','video');
		$this->load->model('admin/news_model','news');
		$row = $this->course->class_detail(intval($id));
		if (!$row) {
			show_404();
		}
		//get video detail
        $arrVideo = $this->video->detail($row['video_id']);
        $data_suggest_video = ($arrVideo) ? array('text' =>$arrVideo['title'],'item_id' => $arrVideo['video_id']) : array();
        //data document
        $data_suggest_document = $this->news->detail($row['document_id']);
        //Data test
        $data_test = $this->course->get_test_by_course_class($id);
		// set data to view
		return  array(
			'type' => $row['type'],
			'row' => $row,
			'data_suggest_document' => $data_suggest_document,
			'data_suggest_video' => $data_suggest_video,
			'data_test' => $data_test
		);
	}
	//Nhập điểm cho giáo viên - Đối với những bài test
	public function class_point($id) {
		$id = (int) $id;
		if ($this->input->post('submit')) {
			return $this->_action('class_point',array('id' => $id));
		}
		$this->load->setArray(array("isForm" => 1));
		$data = $this->_class_point($id);

		$this->load->layout('course/class_point',$data);
	}
	public function _class_point($id){
		$this->load->model('admin/course_model','course');
		$this->load->model('admin/video_model','video');
		$this->load->model('admin/news_model','news');
		$row = $this->course->class_detail(intval($id));
		if (!$row || $row['type'] != 2) {
			show_404();
		}
		//Data test
        $data_test = $this->course->get_test_by_course_class($id);
        if(!$data_test[0]){
        	show_404();
        }

		//Get topic 
        $topic_detail = $this->course->topic_detail(intval($row['topic_id']));
        if (!$topic_detail || empty($topic_detail['course_id'])) {
			show_404();
		}
		$course_id = $topic_detail['course_id'];
		//Get list user by course
		$list_users = $this->course->get_users_by_course($course_id, array('test_id' => $data_test[0]['test_id']));
		// set data to view
		return  array(
			'row' => $row,
			'users' => $list_users,
			'test' => $data_test[0]
		);
	}
	////////////////////////////////// USER /////////////////////////////////
    public function users_index($course_id){
    	$course_id = (int)$course_id;
		if(!$course_id){
			show_404();
		}	
		if ($this->input->post('delete'))
		{
			return $this->_action('course_user_delete',array('course_id' => $course_id));
		}
		$this->load->setArray(array("isLists" => 1));
		$data = $this->_users_index($course_id);

		// render view

//        echo '<pre>'.print_r($data['test_log']).'</pre>'; exit;
//        echo '<pre>'; print_r($data['test_log']); echo '</pre'; exit;
		$this->load->layout('course/users_list',$data);
	}
	public function users_add(){
		if ($this->input->post('submit'))
		{
			$this->load->model('admin/course_model','course');

			$course_id = $this->input->post('course_id');
			$users = $this->input->post('users');
			if(empty($course_id) || empty($users)){
				return $this->output->set_output(json_encode(array('status' => 'error', 'message' => 'Dữ liệu truyền vào không đúng')));
			}
			$number = 0;		//Count số lượng học viên được insert
			foreach ($users as $user_id) {
				//Check học viên đã được thêm vào khóa học chưa???
				if($this->course->insert_course_to_user($course_id, $user_id)){
					$number ++;
				}
			}
			return $this->output->set_output(json_encode(array('status' => 'success', 'message' => 'Đã thêm thành công '.$number.' học viên')));
		}
		return $this->output->set_output(json_encode(array('status' => 'error', 'message' => 'Phương thức truyền dữ liệu không đúng')));
	}
	public function _users_index($course_id){
		$this->load->model('admin/course_model','course');
		$course_detail = $this->course->detail($course_id);

		//get list users
		$rows = $this->course->get_users_by_course($course_id);
		$arr_user_id = array_unique(array_column($rows, 'user_id'));
		//Get list test by course_id
		$arr_test = $this->course->get_test_by_course($course_id);
		$arr_topic = $this->course->get_topic_by_course($course_id);
		if($arr_topic){
			foreach ($arr_topic as $topic) {
				$list_class = $this->course->get_class_by_topic($topic['topic_id']);
				if($list_class){
					//Insert class 
					foreach ($list_class as $class) {
						$test = $this->course->get_test_by_course_class($class['class_id']);
						if($test){
							$arr_test = array_merge($arr_test, $test);
						}
					}
				}
			}
		}
		$arr_test_id = array_unique(array_column($arr_test, 'test_id'));
		//Get score of user in course
		$arr_test_logs = $this->course->get_user_score_by_course($arr_user_id, $arr_test_id);

		$arr_test_id_need_infor = array();
        $arr_test_name = array();

		$test_log = array();
		if($arr_test_logs){
			foreach ($arr_test_logs as $item) {
				$test_log[$item['user_id']][] = $item;
				array_push($arr_test_id_need_infor,$item['test_id']);
			}
		}

		for ($i = 0; $i < count($arr_test_id_need_infor); $i++) {
		    $test_id_mono = $arr_test_id_need_infor[$i];
            $this->db->where('test_id',$test_id_mono);
            $this->db->select('title');
            $query = $this->db->get('test');
            $arr_res = $query->result_array();
            $name_test = $arr_res[0]['title'];
            $arr_test_name[$test_id_mono] = $name_test;
		}



		// get config data
		$this->load->config('data');
		// set data
		return array('rows' => $rows, 'course_detail' => $course_detail, 'test_log' => $test_log, 'arr_test_name' => $arr_test_name);
	}
	///////////////////////BUILDTOP///////////////////
	public function buildtop($position = '') {
        if ($this->input->post('order')){
			return $this->_action('buildtop');
		}
		$this->load->setArray(array("isLists" => 1,"isForm" => 1));
		$data = $this->_buildtop($position);
		if (!$data) {
			show_404();
		}
		$this->load->layout('course/buildtop',$data);
	}
		
	public function _buildtop($position) {
		$limit = 30;
		$configBlock = $this->config->item('block');
		$configBlock = $configBlock['course_special']['position'];
		$arrPosition = array_keys($configBlock);
		if (!in_array($position, $arrPosition)) {
			$position = $arrPosition[0];
		}
		$this->load->model('admin/course_model','course');
		$this->load->model('admin/category_model','category');
		// get latest news 
		$latest =$this->course->lists(array('limit' => $limit + 1));
		$showMore = (count($latest) > $limit) ? 1 : 0;
		unset($latest[$limit]);
		// get news special
		$rows = $this->course->get_buildtop(array('position' => $position));
		// get array cate recursive
		$arrCate = $this->category->get_category(array('type' => 1));
		$arrCate = $this->category->recursiveCate($arrCate);
		// return
		return array('rows' => $rows,'latest' => $latest,'arrCate' => $arrCate,'position' => $position, 'showMore' => $showMore, 'arrPosition' => $configBlock);
	}

	public function suggest_course() {
		$this->load->model('admin/course_model','course');
		$this->load->model('admin/category_model','category');
		$limit = 30;
		$page = (int) ($this->input->get('page') >= 1) ? $this->input->get('page') : 1;
		$cate_id = (int) $this->input->get('cate_id');
		$offset =  ($page - 1) * $limit;
		$keyword = trim($this->input->get('keyword'));

		$params = array('limit' => $limit + 1, 'offset' => $offset, 'cate_id' => $cate_id, 'keyword' => $keyword);
		// get array news
		$rows = $this->course->lists($params);
		$showMore = 0;
		if (count($rows) > $limit) {
			$showMore = 1;
			// delete last row
			unset($rows[$limit]);
		}
		if ($rows) {
			// get all cate to check original cate
			// get array cate recursive
			$arrCate = $this->category->get_category(array('type' => 1));
			$arrCate = $this->category->recursiveCate($arrCate);
			foreach ($rows as $key => $row) {
				$rows[$key]['original_cate'] = $arrCate[$row['original_cate']]['name'];
			}
		}
		$data = array(
			'rows' => $rows,
			'showMore' => $showMore,
			'cate_id' => $cate_id,
			'keyword' => $keyword,
			'page' => $page
		);
		if ($this->input->get('dataType') == 'html') {
			$data =	$this->load->view('course/suggest_course',$data);
		}
		return $this->output->set_output(json_encode(array('status' => 'success', 'data' => $data)));
	}
	
	public function _action($action, $params = array()) {
		$this->load->model('admin/course_model','course');
		$this->load->model('admin/logs_model','logs');
		$this->load->model('admin/test_model','test');
		switch ($action) {
			case 'add':
			case 'copy':
			case 'edit':
				$this->load->library('form_validation');
				$valid = array(
					array(
		                 'field'   => 'title',
		                 'label'   => $this->lang->line('course_name'),
		                 'rules'   => 'required'
		            ),
		            array(
		                'field'   => 'original_cate',
		                'label'   => $this->lang->line('course_original_cate'),
		                'rules'   => 'is_natural_no_zero'
		            )
				);
		  		$this->form_validation->set_rules($valid);
				if ($this->form_validation->run() == true)
				{
					// set input params
					$inputParams = array();
					if ($proParams = $this->input->post('params')) {
						foreach ($proParams as $key => $value) {
							if ($value['key'] && $value['value']) {
								$inputParams[$value['key']] = $value['value'];
							}
							
						}
					}

					$inputParams = json_encode($inputParams);
					// set input to save
					$input['course'] = array(
						'title' => $this->input->post('title'),
						'sku' => $this->input->post('sku'),
						'detail' => $this->input->post('detail'),
						'publish' => intval($this->input->post('publish')),
			            'original_cate' => intval($this->input->post("original_cate")),
			            'publish_time' => (int) convert_datetime($this->input->post('publish_time')),
						'description' => $this->input->post('description'),
			            'images' => $this->input->post('images'),
			            'seo_title' => $this->input->post("seo_title"),
			            'seo_keyword' => $this->input->post("seo_keyword"),
			            'seo_description' => $this->input->post("seo_description"),
			            'teacher_id' => intval($this->input->post('teacher_id')),
			            'number_lesson' => (int) $this->input->post('number_lesson'),
			            'rate' => (int) $this->input->post('rate'),
			            'count_rate' => (int) $this->input->post('count_rate'),
			            'video_id' => (int)$this->input->post("video_id"),
			            'document' => $this->input->post("document"),
			            'muc_tieu' => $this->input->post('muc_tieu'),
			           	'input' => $this->input->post('input'),		//Điểm đầu vào	
			           	'output' => $this->input->post('output'),		//Đầu ra
			            /////
			            'params' => $inputParams,
						'price' => (int) $this->input->post('price'),
						'price_discount' => (int) $this->input->post('price_discount'),
						'price_note' => $this->input->post('price_note'),
						'start_time' => (int) convert_datetime($this->input->post('start_time')),
						'end_time' => (int) convert_datetime($this->input->post('end_time')),
					);
					if ($this->input->post('tag_exist') || $this->input->post('tag_new')) {
						$input['tags'] = array(
							'tag_exist' => @array_map('intval', $this->input->post('tag_exist')),
							'tag_new' => $this->input->post('tag_new'),
						);
					}
					if (!$this->permission->check_permission_backend('publish')) {
						unset($input['course']['publish']);
					}
					// $input['documents'] = $this->input->post('documents');
					$input['test'] = $this->input->post('test');
					$input['teacher'] = $this->input->post('teacher');
					$input['teacher_offline'] = $this->input->post('teacher_offline');

					$input['category'] = $this->input->post('category');
					if ($action == 'add' || $action == "copy") {
						$result = $this->course->insert($input);
						if ($item_id = $result) {
							$html =$this->load->view('course/form',$this->_add()); 
						}
					}
					else {
						if ($this->security->verify_token_post($params['id'],$this->input->post('token'))) {
							$result = $this->course->update($params['id'],$input);	
						}
						if ($result) {
							$item_id = $params['id'];
							$html =$this->load->view('course/form',$this->_edit($params['id'])); 
						}
					}
					if ($result) {
						//Insert topic + class
						if($action == "copy"){
							$course_id = $params['id'];
							//Get list topic
							$list_topic = $this->course->get_topic_by_course($course_id);	
							if($list_topic){
								//Insert topic 
								foreach ($list_topic as $topic) {
									$old_topic_id = $topic['topic_id'];
									$removeKeys = array('topic_id', 'share_url', 'create_time', 'update_time');
									foreach($removeKeys as $key) {
									   unset($topic[$key]);
									}
									$topic['course_id'] = $item_id;
									$news_topic_id = $this->course->topic_insert($topic);
									//Get list class by topic
									$list_class = $this->course->get_class_by_topic($old_topic_id);
									if($list_class){
										//Insert class 
										foreach ($list_class as $class) {
											$removeKeys = array('class_id', 'hit', 'share_url', 'create_time', 'update_time');
											foreach($removeKeys as $key) {
											   unset($class[$key]);
											}
											$class['topic_id'] = $news_topic_id;
											$this->course->class_insert(array('class' => $class));
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
				$result = $this->course->delete($arrId);
				if ($result) {
					// log action
	                $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $arrId));
	                // return result
					$html = $this->load->view('course/list',$this->_index()); 
					return $this->output->set_output(json_encode(array('status' => 'success','html' => $html, 'result' => $result, 'message' => $this->lang->line("common_delete_success"))));
				}
			break;
			case 'topic_add':
			case 'topic_edit':
				$this->load->library('form_validation');
				$valid = array(
					array(
		                 'field'   => 'name',
		                 'label'   => $this->lang->line('course_topic_name'),
		                 'rules'   => 'required'
		              ),
		           array(
		                 'field'   => 'ordering',
		                 'label'   => $this->lang->line('course_topic_ordering'),
		                 'rules'   => 'required|integer'
		              ),
				);
		  		$this->form_validation->set_rules($valid);
				if ($this->form_validation->run() == true)
				{
					$input = array(
						'name' => $this->input->post('name'),
						'ordering' => (int) $this->input->post('ordering'),
			            'description' => $this->input->post("description"),
			            'images' => $this->input->post("images"),
			            'seo_title' => $this->input->post("seo_title"),
			            'seo_keyword' => $this->input->post("seo_keyword"),
			            'seo_description' => $this->input->post("seo_description"),
			            'price' => (int) $this->input->post('price'),
						'price_discount' => (int) $this->input->post('price_discount')
					);
					if ($action == 'topic_add') {
						$course_id = (int)$params['course_id'];
						$input['course_id'] = $course_id;
						$result = $this->course->topic_insert($input);
						if ($item_id = $result) {
							$html =$this->load->view('course/topic_form',$this->_topic_add($course_id)); 
						}
					}
					else {
						if ($this->security->verify_token_post($params['id'],$this->input->post('token'))) {
							$result = $this->course->topic_update($params['id'],$input);	
						}
						if ($result) {
							$item_id = $params['id'];
							$html =$this->load->view('course/topic_form',$this->_topic_edit($params['id'])); 
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
			case 'topic_delete':
				$course_id = (int)$params['course_id'];
				$arrId = $this->input->post('cid');
				$arrId = (is_array($arrId)) ? array_map('intval', $arrId) : (int) $arrId;
				if (!$arrId) {
					return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_delete_min_select"))));
				}
				if (!$this->permission->check_permission_backend('topic_delete')){
					return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_access_denied"))));
				}
				$result = $this->course->topic_delete($arrId);
				
				if ($result) {
					// log action
	                $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $arrId));
	                // return result
					$html = $this->load->view('course/topic_list',$this->_topic_index($course_id)); 
					return $this->output->set_output(json_encode(array('status' => 'success','html' => $html, 'result' => $result, 'message' => $this->lang->line("common_delete_success"))));
				}
			break;
			case 'class_add':
			case 'class_edit':
				$this->load->library('form_validation');
				$valid = array(
					array(
		                 'field'   => 'title',
		                 'label'   => $this->lang->line('course_name'),
		                 'rules'   => 'required'
		            ),
				);
		  		$this->form_validation->set_rules($valid);
				if ($this->form_validation->run() == true)
				{
					// set input params
					$inputParams = array();
					if ($proParams = $this->input->post('params')) {
						foreach ($proParams as $key => $value) {
							if ($value['key'] && $value['value']) {
								$inputParams[$value['key']] = $value['value'];
							}
							
						}
					}
					$inputParams = json_encode($inputParams);
					// set input to save
					$input['class'] = array(
						'title' => $this->input->post('title'),
						'detail' => $this->input->post('detail'),
						'publish' => intval($this->input->post('publish')),
			            'publish_time' => (int) convert_datetime($this->input->post('publish_time')),
						'description' => $this->input->post('description'),
			            'images' => $this->input->post('images'),
			            'seo_title' => $this->input->post("seo_title"),
			            'seo_keyword' => $this->input->post("seo_keyword"),
			            'seo_description' => $this->input->post("seo_description"),
			            'video_id' => (int)$this->input->post("video_id"),
			            'document' => $this->input->post("document"),
			            /////
			            'params' => $inputParams,
			            'type' => (int)$this->input->post("type"),
			            'start_time' => (int) convert_datetime($this->input->post('start_time')),
						'end_time' => (int) convert_datetime($this->input->post('end_time')),
						'duration' => $this->input->post("duration"),
					);
					$input['test'] = $this->input->post('test');
					//Test kỹ năng
					if((int)$this->input->post("type") == 2 && $input['test']){
						$this->load->model('admin/test_model','test');
						$arr_test_type = $this->config->item('test_type');
						foreach ($input['test'] as $test_id) {
							foreach ($arr_test_type as $type_id => $type_name) {
			                    // Check question
			                    $arrQuestion = $this->test->get_question_by_test(array('test_id' => $test_id, 'type' => $type_id, 'limit' => 200));
			                    if($arrQuestion){
			                    	//Get detail test
			                    	$detailTest = $this->test->detail($test_id);
			                        $input['class']['share_url'] = str_replace('/test/', '/test/'.strtolower($type_name).'/', $detailTest['share_url']);
			                        break;
			                    }
			                }
						}
					}
					if ($action == 'class_add') {
						$topic_id = (int)$params['topic_id'];
						$input['class']['topic_id'] = $topic_id;
						$result = $this->course->class_insert($input);
						if ($item_id = $result) {
							$html =$this->load->view('course/class_form_'.$input['class']['type'],$this->_class_add($topic_id, $input['class']['type'])); 
						}
					}
					else {
						if ($this->security->verify_token_post($params['id'],$this->input->post('token'))) {
							$result = $this->course->class_update($params['id'],$input);	
						}
						if ($result) {
							$item_id = $params['id'];
							$html =$this->load->view('course/class_form_'.$input['class']['type'],$this->_class_edit($params['id'])); 
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
			case 'class_delete':
				$arrId = $this->input->post('cid');
				$arrId = (is_array($arrId)) ? array_map('intval', $arrId) : (int) $arrId;
				if (!$arrId) {
					return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_delete_min_select"))));
				}
				if (!$this->permission->check_permission_backend('delete')){
					return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_access_denied"))));
				}
				$result = $this->course->class_delete($arrId);
				
				if ($result) {
					// log action
	                $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $arrId));
	                // return result
					$html = $this->load->view('course/topic_list',$this->_topic_index($params['course_id'])); 
					return $this->output->set_output(json_encode(array('status' => 'success','html' => $html, 'result' => $result, 'message' => $this->lang->line("common_delete_success"))));
				}
			break;
			case 'class_point':
				$test_id = $this->input->post('test_id');
				$point = $this->input->post('point');
				if ($point) {
					foreach ($point as $user_id => $score) {
						$input = array(
							'user_id' => $user_id,
							'test_id' => $test_id,
							'score' => $score,
						);
						if($test_log = $this->test->test_log_detail($input)){
							//Update
							$this->test->test_log_update($test_log['logs_id'], $input);
						}else{
							$this->test->test_log_insert($input);
						}
					}
	                // return result
					$html = $this->load->view('course/class_point',$this->_class_point($params['id'])); 
					return $this->output->set_output(json_encode(array('status' => 'success','html' => $html, 'result' => $result, 'message' => $this->lang->line("common_update_success"))));
				}
			break;
			case 'buildtop':
				$arrId = $this->input->post('cid');
				$position = $this->input->post('position');
				$arrId = (is_array($arrId)) ? array_map('intval', $arrId) : (int) $arrId;
				$result = $this->course->update_buildtop($arrId,$position);
				if ($result) {
					// log action
	                $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => 0));
	                // return result
					return $this->output->set_output(json_encode(array('status' => 'success', 'result' => $result, 'message' => $this->lang->line("common_update_success"))));
				}
				break;
			case 'course_user_delete':
				$arrId = $this->input->post('cid');
				$arrId = (is_array($arrId)) ? array_map('intval', $arrId) : $arrId;
				if (!$arrId) {
					return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_delete_min_select"))));
				}
				if (!$this->permission->check_permission_backend('users_delete')){
					return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_access_denied"))));
				}
				$course_id = $this->course->users_delete($arrId);
				
				if ($course_id) {
					// log action
	                $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $arrId));
	                // return result
					$html = $this->load->view('course/users_list',$this->_users_index($course_id)); 
					return $this->output->set_output(json_encode(array('status' => 'success','html' => $html, 'result' => $result, 'message' => $this->lang->line("common_delete_success"))));
				}
			break;
			default:
				# code...
				break;
		}	
		return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_no_row_update"))));
	}

	// Điểm học viên
	public function class_score($class_id){
		$this->load->setArray(array("isLists" => 1));
		$data = $this->_class_score($class_id);
		$html = $this->load->view('course/class_score',$data); 

		return $this->output->set_output($html);
	}

	private function _class_score($class_id){
		if(!$class_id){
			return NULL;
		}
		$this->load->model('admin/test_model','test');
        $arrTest = $this->test->list_for_course_class($class_id);
        $rows = array();
        if($arrTest){
            foreach ($arrTest as $key => $test) {
                $rows = array_merge($rows, $this->test->log_lists(array('test_id' => $test['test_id'])));
            }
        }

        return array('rows' => $rows);
	}
}