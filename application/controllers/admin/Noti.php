<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Noti extends CI_Controller{
    public $module = 'block';
    function __construct(){
        parent::__construct();
        $this->lang->load('backend/block');
        $this->load->setData('title',$this->lang->line('block_title'));
    }
    public function index(){
        if ($this->input->post('delete'))
        {
            return $this->_action('delete');
        }
        $this->load->setArray(array("isLists" => 1));
//        echo '<pre>';
//        print_r($_POST);
//        echo '<pre>';exit;
        $data = $this->_index();
        // render view
        $this->load->layout('noti/list',$data);
    }

    public function add(){
        if ($this->input->post('submit')) {
//            echo '<pre>';
//            print_r($_POST);
//            echo '<pre>';exit;
            return $this->_action('add');
        }
        $this->load->setArray(array("isForm" => 1));
        $data = $this->_add();

        // Get list Course
        $this->db->select('course_id,title');
        $query = $this->db->get('course');
        $list_course = $query->result_array();
        $data['list_course'] = $list_course;
        $this->load->layout('noti/form',$data);
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
        $this->load->layout('block/form',$data);
    }
    public function edit($id) {
        $id = (int) $id;
        if ($this->input->post('submit')) {
            return $this->_action('edit',array('id_noti' => $id));
        }
        $this->load->setArray(array("isForm" => 1));
        $data = $this->_edit($id);
        // Get list Course
        $this->db->select('course_id,title');
        $query = $this->db->get('course');
        $list_course = $query->result_array();
        $data['list_course'] = $list_course;

        $this->load->layout('noti/form',$data);
    }
    public function option() {
        $module = $this->input->get('module');
        $data  = array();
        $arrConfig = $this->config->item("block");
        $arrConfig = $arrConfig[$module];
        // option for edit
        $block_id = (int) $this->input->get('block_id');
        $block_detail = array();
        if ($block_id > 0) {
            $this->load->model('admin/block_model','block');
            $block_detail = $this->block->detail($block_id);
            $block_detail['params'] = json_decode($block_detail['params'],TRUE);
        }


        switch ($module) {
            case 'news_cate':
            case 'news_sub_cate':
                $this->load->model("admin/category_model","category");
                // get category recursive
                $arrCate = $this->category->get_category(array('type' => 1));
                $arrCate = $this->category->recursiveCate($arrCate);
                foreach ($arrCate as $key => $cate) {
                    $arrId[$cate['cate_id']] = $cate['name'];
                }
                $arrConfig['params']['id'] = $arrId;
                break;
            case 'advertise_cate':
                $this->load->model("admin/category_model","category");
                // get category recursive
                $arrCate = $this->category->get_category(array('type' => 3));
                $arrCate = $this->category->recursiveCate($arrCate);
                foreach ($arrCate as $key => $cate) {
                    $arrId[$cate['cate_id']] = $cate['name'];
                }
                $arrConfig['params']['id'] = $arrId;
                break;
            case 'special';

                break;
            default:
                $data = array();
                break;
        }
        $html = $this->load->view('block/option',array('arrConfig' => $arrConfig,'row' => $block_detail));


        return $this->output->set_output(json_encode(array('status' => 'success','html' => $html,'option' => $option)));
    }
    public function _index(){
        $this->load->model('admin/noti_model','noti');
//        $params = array();
        ////////////////// FITER /////////
//        $params_filter = array_filter(array(
//            'module' => $this->input->get('module'),
//            'position' => $this->input->get('position'),
//            'publish' => $this->input->get('publish')
//        ),'filter_item');
//        $params = array_merge($params,$params_filter);
//        $rows = $this->noti->lists($params);
        $rows = $this->noti->lists();
        // set data
//        return array('rows' => $rows,'filter' => $params_filter);
        return array('rows' => $rows);
    }
    public function _add(){
        $this->load->model('admin/block_model','block');
        // get menu access recursive
        $this->load->model('admin/menu_model','menu');
        $arrMenu = $this->menu->get_menu($params);
        $arrMenu = $this->menu->recursiveMenu($arrMenu);
        // set data to view

        return array(

            'arrMenu' => $arrMenu,
            'arrMenuAccess' => array()
        );
    }
    public function _edit($id){
        $this->load->model('admin/noti_model','noti');
        $row = $this->noti->detail(intval($id));
        if (!$row) {
            show_404();
        }
//        $menuAccess = $this->noti->get_access($id);
//        $arrMenuAccess = array();
//        foreach ($menuAccess as $key => $menuAccess) {
//            $arrMenuAccess[] = $menuAccess['menu_id'];
//        }
        // get menu access recursive
//        $this->load->model('admin/menu_model','menu');
//        $arrMenu = $this->menu->get_menu($params);
//        $arrMenu = $this->menu->recursiveMenu($arrMenu);
        // set data to view
        return  array(
            'row' => $row,
//            'arrMenu' => $arrMenu,
//            'arrMenuAccess' => $arrMenuAccess
        );
    }
    public function _action($action, $params = array()) {
        $this->load->model('admin/noti_model','noti');
//        $this->load->model('admin/logs_model','logs');
        switch ($action) {
            case 'add':
            case 'edit':
                $this->load->library('form_validation');
                {
                    // handle course
                    $course = array();
                    if ( is_array( $this->input->post('course'))){
                        $course = $this->input->post('course');
                    }
                    // $course = array(
                    // '43071' => 'on'
                    // )
                    // ===================
                    $arr_course = array();
                    if (count($course) > 0){
                        foreach ($course as $id_course => $text_on) {
                            $id_course = (int) $id_course;
                            array_push($arr_course,$id_course);
                        }
                    }

                    $input['noti'] = array(
                        'title' => $this->input->post('title'),
                        'content' => $this->input->post('content'),
                        'link' => $this->input->post('link'),
                        'avarta' => $this->input->post('avarta'),
                        'creator' => 0,
                        'course' => json_encode($course),
                    );
                    if ($action == 'add') {
                        $result = $this->noti->insert($input); // $result = $id_noti new insert
                        if ($item_id = $result) {
                            $data2 = $this->_add();
                            $this->db->select('course_id,title');
                            $query = $this->db->get('course');
                            $list_course = $query->result_array();
                            $data2['list_course'] = $list_course;

                            // Xử lý noti
                            $this->noti->add_bell_noti($result,$arr_course);

                            $html =$this->load->view('noti/form',$data2);
                        }
                    }
                    else {

//                        if ($this->security->verify_token_post($params['id_noti'],$this->input->post('token'))) {
                            $result = $this->noti->update($params['id_noti'],$input);
//                        }

                        if ($result) {
                            $item_id = $params['id_noti'];
                            $data3 = $this->_edit($params['id_noti']);
                            $this->db->select('course_id,title');
                            $query = $this->db->get('course');
                            $list_course = $query->result_array();
                            $data3['list_course'] = $list_course;

                            // Xử lý noti
                            $this->noti->edit_bell_noti($params['id_noti'],$arr_course);
                            $html =$this->load->view('noti/form',$data3);
                        }
                    }
                    if ($result) {
                        // log action
//                        $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $item_id));
                        // return result
                        return $this->output->set_output(json_encode(array('status' => 'success', 'html' => $html, 'result' => $result, 'message' => $this->lang->line("common_update_success"))));
                    }
                }
                break;
            case 'delete':
//                var_dump($_POST); exit;
                $arrId = $this->input->post('cid');
                $arrId = (is_array($arrId)) ? array_map('intval', $arrId) : (int) $arrId;
                if (!$arrId) {
                    return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_delete_min_select"))));
                }
                if (!$this->permission->check_permission_backend('delete')){
                    return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_access_denied"))));
                }
                $result = $this->noti->delete($arrId);

                if ($result) {
                    // log action

//                    $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $arrId));
                    // return html view
                    $html = $this->load->view('noti/list',$this->_index());
                    return $this->output->set_output(json_encode(array('status' => 'success','html' => $html, 'result' => $result, 'message' => $this->lang->line("common_delete_success"))));
                }
            break;
            default:
                # code...
                break;
        }
        return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_no_row_update"))));
    }
    public function zf(){


            echo '<pre>';
//            print_r($list_id_user);
            echo '<pre>';
    }
} ?>