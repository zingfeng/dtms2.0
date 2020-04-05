<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Course extends CI_Controller{
    function __construct(){
		parent::__construct();
	}
    public function index() {
        //get model
        $this->load->model('course_model','course');
        $this->load->model('category_model','category');
        //get list sub category
        $arrCate = $this->category->recursiveCate(array('type' => 1));
        $menuCate = $this->load->view('course/box/menu',array('arrCate' => $arrCate));
        //neu ko co subcate, lay subcate hien tai  
        $arrCourse = array();

        foreach($arrCate as $cateDetail){
            unset($cateDetail['child']);
            //get list course
            $arrCourse[] = array('rows' => $this->course->lists_by_cate_rule1(array('cate_id' => $cateDetail['cate_id'], 'limit' => 6)), 'category' => $cateDetail);
        }
        // set data
        $data = array(
            'menuCate' => $menuCate,
            'arrCourse' => $arrCourse,
        );

        $this->config->set_item("breadcrumb",array(array("name" => 'Khóa học', 'link' => '/khoa-hoc.html'),array('name' => $cate_name)));
        $this->config->set_item("menu_select",array('course_cate' => 0));
        $this->load->setData('title','Khóa học');
        // render html
        $this->load->layout('course/index',$data);
    }
	public function lists($cate_id){
        $limit = 12; $cate_id = (int) $cate_id;
        // instance
        $page = (int)$this->input->get('page');
        $page = ($page > 1) ? $page : 1;
        $offset = ($page - 1) * $limit;
        //get model
        $this->load->model('course_model','course');
        $this->load->model('category_model','category');

        //get cate_detail
        
        $cate_detail = $this->category->detail($cate_id);
        if (!$cate_detail) {
            show_404();
        }

        $url = $this->uri->uri_string();
        if ($url != trim($cate_detail['share_url'],'/')){
            redirect_seo(array('url' => $cate_detail['share_url']),'location','301');
        }
        /// GET ALL CATE FOR MENU
        $arrCate = $this->category->recursiveCate(array('type' => 1));
        $menuCate = $this->load->view('course/box/menu',array('arrCate' => $arrCate,'cate_id' => array($cate_id,$cate_detail['parent'])));
        /// PARAMS INPUT 
        $param = array('cate_id' => $cate_id, 'limit' => $limit, 'offset' => $offset);


        $config['total_rows'] = $this->course->lists_total_by_cate_rule1(array('cate_id' => $cate_id, 'limit' => $limit, 'offset' => $offset));
        $config['per_page'] = $limit;
        $arrCourse = $this->course->lists_by_cate_rule1(array('cate_id' => $cateid, 'limit' => $limit_course, 'offset' => $offset_course));
        // GET PAGINATION
        $this->load->library('pagination',$config);
        // set data
        $data = array(
            'cateDetail' => $cate_detail,
            'paging' => $this->pagination->create_links(),
            'arrCourse' => $arrCourse,
            'menuCate' => $menuCate
        );

        $this->config->set_item("breadcrumb",array(array("name" => 'Khóa học', 'link' => '/khoa-hoc.html'),array('name' => $cate_detail['name'])));
        $this->config->set_item("menu_select",array('course_cate' => array($cate_id,$cate_detail['parent'])));
        $this->load->setData('title',($cate_detail['seo_title']) ? $cate_detail['seo_title'] : $cate_detail['name']);
        $this->load->setData('meta',array(
            'keyword' => ($cate_detail['seo_keyword']) ? $cate_detail['seo_keyword'] : $cate_detail['name'],
            'description' => ($cate_detail['seo_description']) ? $cate_detail['seo_description'] : $cate_detail['description']
        ));
        $this->load->setData('ogMeta',array(
                'og:image' => getimglink($cate_detail['images']),
                'og:title' => $cate_detail['name'],
                'og:description' => $cate_detail['description'],
                'og:url' => current_url())
        );
        // render html
        $this->load->layout('course/list',$data);
	}

    public function detail($id = '', $class_id = ''){
        $id = (int) $id;
        $class_id = (int) $class_id;
        if(!$id){
            show_404();
        }
        $this->load->model('course_model','course');
        $this->load->model('video_model','video');
        $this->load->model('category_model','category');
        $this->load->model('order_model','order');
        $this->load->model('news_model','news');
        $detail = $this->course->detail($id);
        if (empty($detail)){
            show_404();
        }
        if($class_id){
            $class_detail = $this->course->get_class_detail($class_id);
        }

        // check valid url
        // $url = $this->uri->uri_string();
        // if ($url != trim($detail['share_url'],'/')){
        //     redirect_seo(array('url' => $detail['share_url'], 'lang' => 1),'location','301');
        // }
        $data['row'] = $detail;
        // check course
        // if($user_id = $this->permission->getId()){
        //     //get order_detail
        //     $registerCourse = $this->order->get_order_by_course((array('course_id' => $id, 'user_id' => $user_id)));
        // }
        // neu can lay category info
        $cate = $this->category->detail($detail['original_cate']);
        //get chuyen de
        $arrTopic = $this->course->get_lists_topic($id);
        foreach($arrTopic as $topic){  
            $arrTopicId[] = (int)$topic['topic_id']; 
        }
        //get bai hoc
        if($arrTopicId){
            if ($this->permission->hasIdentity()){
                $profile = $this->permission->getIdentity();
                $params = array(
                    'user_id' => $profile['user_id'],
                    'all' => 1
                );
            }
            $arrData = $this->course->get_lists_class($arrTopicId, $params);
            foreach($arrData as $class){
                $arrClass[$class['topic_id']][] = $class;
            }
        }

        // get comment 
        // $this->load->model('comment_model','comment');
        // $arrComment = $this->comment->get_rev_comment(array('id' => $id,'type' => 2));
        // $block_comment = $this->load->view('comment/lists',array('id' => $id, 'arrComment' => $arrComment, 'type' => 2));
        //Get khóa học liên quan
        $limit_relate = 3;
        $params_relate = array(
            'course_id' => $id,
            'cate_id' => $detail['original_cate'],
            'limit' => $limit_relate,
        );
        $arrRelated = $this->course->lists_related($params_relate);
        //get video
        if($detail['video_id']){
            $video = $this->video->get_detail_by_id((int)$detail['video_id']);
            $video_params = json_decode($video['params'],TRUE);
            if($video_params){
                foreach($video_params as $param){
                    if($param['object_id'] && $param['type'] && $param['time']){
                        $videoObject[$param['type']][] = array('time' => $param['time'],'object_id' => $param['object_id']);
                    }
                }
            }
        }
        //Get array test
        $this->load->model('test_model','test');
        $arrTest = $this->test->list_for_course($id); 
        if($arrTest){
            $this->load->config("data");
            $arr_test_type = $this->config->item('test_type');
            foreach ($arrTest as $key => $test) {
                foreach ($arr_test_type as $type_id => $type_name) {
                    // Check question
                    $arrQuestion = $this->test->get_question_by_test(array('test_id' => $test['test_id'], 'type' => $type_id, 'limit' => 200));
                    if($arrQuestion){
                        $arrTest[$key]['test_list'][] = $type_name;
                    }
                }
            }
        }

        //Get array teacher 
        $this->load->model('expert_model','expert');
        $arrTeacher = $this->expert->lists_teacher_by_course_id($id);

        // set data
        $data = array(
            'cate' => $cate,
            'courseId' => $id,
            'courseDetail' => $detail,
            'classDetail' => $class_detail,
            'arrTopic' => $arrTopic,
            'arrClass' => $arrClass,
            'arrRelated' => $arrRelated,
            'arrTest' => $arrTest,
            'arrTeacher' => $arrTeacher,
            'video' => $video,
            'registerCourse' => $registerCourse,
            'videoObject' => $videoObject,
            // 'block_comment' => $block_comment
        );

        if($class_detail){
            $data['next'] = $this->course->class_relate(array("class_id" => $class_id, 'topic_id' => $class_detail['topic_id'], 'limit' => 1, 'type' => 'next', 'sort' => 'ASC'));
            $data['prev'] = $this->course->class_relate(array("class_id" => $class_id, 'topic_id' => $class_detail['topic_id'], 'limit' => 1, 'type' => 'prev', 'sort' => 'DESC'));
        }



        // set meta and config //
        $this->config->set_item("breadcrumb",array(array("name" => 'Khóa học', "link" => "javascript:;"),array("name" => $cate['name'],"link" => $cate['share_url'])));
        $this->config->set_item("menu_select",array('item_mod' => 'course_cate', 'item_id' => $detail['original_cate']));
        $this->load->setData('seo_title',($detail['seo_title']) ? $detail['seo_title'] : $detail['title']);
        $this->load->setData('meta',array(
            'keyword' => ($detail['seo_keyword']) ? $detail['seo_keyword'] : $detail['title'],
            'description' => ($detail['seo_description']) ? $detail['seo_description'] : $detail['description']
        ));
        $this->load->setData('ogMeta',array(
                'og:image' => getimglink($detail['images']),
                'og:title' => $detail['title'],
                'og:description' => $detail['description'],
                'og:url' => current_url())
        );
        // update count hit
        $this->course->count_hit($id);
        // render view

//        var_dump($arrClass[$topic['topic_id']]) ;
        foreach($arrTopic as $key => $topic) {
            if($arrClass[$topic['topic_id']]) {
                foreach($arrClass[$topic['topic_id']] as $item){
                    $data['first_topic'] = $item['share_url'];
                    break;
                }
                break;
             }
        }
                $this->load->layout('course/detail',$data);
    }
    public function class_detail($class_id,$alias){
        if(!$class_id){
            show_404();
        } 
        // if(!($user_id = $this->permission->getId())){
        //     $redirect_uri = SITE_URL.'/users/login?redirect_uri='.current_url();
        //     redirect($redirect_uri);
        // }
        $this->load->model('course_model','course');
        $this->load->model('video_model','video');
        $this->load->model('news_model','news');
        $this->load->model('category_model','category');
        $this->load->model('order_model','order');
        //get detail class
        $detail = $this->course->get_class_detail($class_id);
        if (empty($detail)){
            show_404();
        }
        //get topic detail
        $topic_detail = $this->course->get_topic_detail($detail['topic_id']);
        //get course detail
        $course_detail = $this->course->detail($topic_detail['course_id']);
        //get document
        $document_id = $detail['document_id'];
        $document = $this->news->detail((int)$document_id);
        // check course
        // $registerCourse = $this->order->get_order_by_course((array('course_id' => $topic_detail['course_id'], 'user_id' => $user_id)));
        // if ($topic_detail['price'] > 0 && !$registerCourse[1]  && !isset($registerCourse[2][$detail['topic_id']])) {
        //     return redirect($course_detail['share_url'],'refresh');
        // }
        //get video
        if($detail['video_id']){
            $video = $this->video->get_detail_by_id((int)$detail['video_id']);
        }
        //get chuyen de
        $arrTopic = $this->course->get_lists_topic($course_detail['course_id']);
        foreach($arrTopic as $topic){  
            $arrTopicId[] = (int)$topic['topic_id']; 
        }
        //get bai hoc
        if($arrTopicId){
            $CoursePrev = array(); $CourseNext = array(); $flag = 0;
            $arrData = $this->course->get_lists_class($arrTopicId);
            foreach($arrData as $class){
                $arrClass[$class['topic_id']][] = $class;
                //////// GET NEXT && PREV //////
                if ($flag == 1) {
                    $CourseNext = $class;
                }
                if ($class['class_id'] == $class_id) {
                    $CoursePrev = $tmp;
                    $flag = 1;
                }
                else {
                    $tmp = $class;
                    $flag = 0;
                }
            }
        }

        // set meta and config //
        $this->load->setData('title',$detail['title']);
        $this->load->setData('meta',array(
            'keyword' => $detail['title'],
            'description' => $detail['description']
        ));

        //Get array test
        $this->load->model('test_model','test');
        $arrTest = $this->test->list_for_course_class($class_id);
        if($arrTest){
            $this->load->config("data");
            $arr_test_type = $this->config->item('test_type');
            foreach ($arrTest as $key => $test) {
                foreach ($arr_test_type as $type_id => $type_name) {
                    // Check question
                    $arrQuestion = $this->test->get_question_by_test(array('test_id' => $test['test_id'], 'type' => $type_id, 'limit' => 200));
                    if($arrQuestion){
                        $arrTest[$key]['test_list'][] = $type_name;
                    }
                }
            }
        }
    
        // set data
        $data = array(
            'class_id' => $class_id,
            'classDetail' => $detail,
            'topicDetail' => $topic_detail,
            'courseDetail' => $course_detail,
            'video' => $video,
            'arrTopic' => $arrTopic,
            'arrClass' => $arrClass,
            'arrTest' => $arrTest,
            'document' => $document,
            'registerCourse' => $registerCourse,
            'checkReg' => $checkReg,
            'block_comment' => $block_comment,
            'CoursePrev' => $CoursePrev,
            'CourseNext' => $CourseNext
        );


        
        if($detail){
            $data['next'] = $this->course->class_relate(array("class_id" => $class_id, 'topic_id' => $class_detail['topic_id'], 'limit' => 1, 'type' => 'next', 'sort' => 'ASC'));
            $data['prev'] = $this->course->class_relate(array("class_id" => $class_id, 'topic_id' => $class_detail['topic_id'], 'limit' => 1, 'type' => 'prev', 'sort' => 'DESC'));
            $data['present'] = $this->course->class_relate(array("class_id" => $class_id, 'topic_id' => $class_detail['topic_id'], 'limit' => 1, 'type' => 'present', 'sort' => 'DESC'));
        }

        //Lưu trạng thái user đã học
        if ($this->permission->hasIdentity()){
            $profile = $this->permission->getIdentity();
            $this->load->model('users_model','users');
            $this->users->save_users_to_class($profile['user_id'], $class_id); 
        }
        
        // set meta and config //
        $this->config->set_item("breadcrumb",array(array("name" => $course_detail['title'], "link" => $course_detail['share_url']),array("name" => $detail['title'])));
        $this->load->setData('seo_title',($detail['seo_title']) ? $detail['seo_title'] : $detail['title']);
        $this->load->setData('meta',array(
            'keyword' => ($detail['seo_keyword']) ? $detail['seo_keyword'] : $detail['title'],
            'description' => ($detail['seo_description']) ? $detail['seo_description'] : $detail['description']
        ));
        $this->load->setData('ogMeta',array(
                'og:image' => getimglink($detail['images']),
                'og:title' => $detail['title'],
                'og:description' => $detail['description'],
                'og:url' => current_url())
        );



//        print_r($data['courseDetail']);
        $this->load->layout('course/class_detail',$data);
    }
    public function ajax_get_course(){
        if($this->input->post()){
            $this->load->library('form_validation');
            $valid = array(
                array(
                    'field'   => 'cate_id',
                    'label'   => 'Nhóm khóa học',
                    'rules'   => 'required'
                    )
                );
            $this->form_validation->set_rules($valid);
            if ($this->form_validation->run()){
                $cate_id = (int)$this->input->post('cate_id');
                $limit = 4;
                $this->load->model('course_model','course');
                $arrData = $this->course->lists_by_cate_rule1(array('cate_id' => $cate_id, 'limit' => $limit, 'offset' => 0));
                $html = $this->load->view('course/box/item',array('rows' => $arrData));
                return $this->output->set_output(json_encode(array('status' => 'success','data' => $html)));
            } else {
                return $this->output->set_output(json_encode(array('status' => 'error','valid_rule' => $this->form_validation->error_array())));
            }
        }
    }

    //get khóa học xem đã lưu hay chưa?
    public function get_course_to_user(){
        $saved = 0;
        if (!$this->permission->hasIdentity()) {
           return $this->output->set_output(json_encode(array('error' => 1, 'msg' => 'Bạn chưa đăng nhập')));
        }
        $user_id = (int)$this->permission->getId();

        if($user_id){
            $this->load->model('course_model','course');
            $arrData = $this->course->get_course_to_user($user_id);
            if($arrData){
                $result = array();
                foreach ($arrData as $course) {
                    $result[] = $course['course_id'];
                }
                return $this->output->set_output(json_encode(array('result' => $result)));
            }
        }
        return $this->output->set_output(json_encode(array('result' => array())));
    }

    //Lưu khóa học
    public function save_course_to_user(){
        
        if (!$this->permission->hasIdentity()) {
            $uri = $this->input->post('uri', '/');
            $redirect_uri = BASE_URL.'/users/login?redirect_uri='.$uri;
            return $this->output->set_output(json_encode(array('errors' => 1, 'msg' => 'Bạn cần đăng nhập để lưu khóa học', 'redirect_uri' => $redirect_uri)));
        }
        $this->load->model('course_model','course');
        if ($course_id = (int)$this->input->post('course_id')){
            $courseDetail = $this->course->detail($course_id);
            if (!$courseDetail) {
                return $this->output->set_output(json_encode(array('errors' => 1, 'msg' => 'Khóa học không tồn tại')));
            }
            $user_id = (int)$this->permission->getId();
            $intId = $this->course->save_course_to_user($course_id, $user_id);
            if ($intId) {
                $arrData = $this->course->get_course_to_user($user_id);
                $arrCourseId = array();
                foreach ($arrData as $arrData) {
                    $arrCourseId[] = $arrData['course_id'];
                }
                return $this->output->set_output(json_encode(array('errors' => 0, 'msg' => 'Lưu khóa học thành công','result' => $arrCourseId)));

            }
        }
        return $this->output->set_output(json_encode(array('errors' => 1, 'msg' => 'Chưa lưu được khóa học')));
    }
}