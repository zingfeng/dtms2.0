<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Block extends CI_Controller{
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
        $data = $this->_index();
        // render view
        $this->load->layout('block/list',$data);
    }
    public function add(){
        if ($this->input->post('submit')) {
            return $this->_action('add');
        }
        $this->load->setArray(array("isForm" => 1));
        $data = $this->_add();
        $this->load->layout('block/form',$data);
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
            return $this->_action('edit',array('id' => $id));
        }
        $this->load->setArray(array("isForm" => 1));
        $data = $this->_edit($id);
        $this->load->layout('block/form',$data);
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
        $this->load->model('admin/block_model','block');
        $params = array();
        ////////////////// FITER /////////
        $params_filter = array_filter(array(
            'module' => $this->input->get('module'),
            'position' => $this->input->get('position'),
            'publish' => $this->input->get('publish')
        ),'filter_item');
        $params = array_merge($params,$params_filter);
        $rows = $this->block->lists($params);
        // set data
        return array('rows' => $rows,'filter' => $params_filter);
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
        $this->load->model('admin/block_model','block');
        $row = $this->block->detail(intval($id));
        if (!$row) {
            show_404();
        }
        $menuAccess = $this->block->get_access($id);
        $arrMenuAccess = array();
        foreach ($menuAccess as $key => $menuAccess) {
            $arrMenuAccess[] = $menuAccess['menu_id'];
        }
        // get menu access recursive
        $this->load->model('admin/menu_model','menu');
        $arrMenu = $this->menu->get_menu($params);
        $arrMenu = $this->menu->recursiveMenu($arrMenu);
        // set data to view
        return  array(
            'row' => $row,
            'arrMenu' => $arrMenu,
            'arrMenuAccess' => $arrMenuAccess
        );
    }
    public function _action($action, $params = array()) {
        $this->load->model('admin/block_model','block');
        $this->load->model('admin/logs_model','logs');
        switch ($action) {
            case 'add':
            case 'edit':
                $this->load->library('form_validation');
                $valid = array(
                    array(
                         'field'   => 'name',
                         'label'   => $this->lang->line('block_name'),
                         'rules'   => 'required'
                      ),
                    array(
                         'field'   => 'ordering',
                         'label'   => $this->lang->line('block_ordering'),
                         'rules'   => 'required|integer'
                      ),
                    array(
                         'field'   => 'module',
                         'label'   => $this->lang->line('block_module'),
                         'rules'   => 'required'
                    ),
                );
                $this->form_validation->set_rules($valid);
                if ($this->form_validation->run() == true)
                {
                    $input['block'] = array(
                        'name' => $this->input->post('name'),
                        'ordering' => (int) $this->input->post('ordering'),
                        'position' => $this->input->post('position'),
                        'module' => $this->input->post('module'),
                        'content' => $this->input->post('content'),
                        'params' => ($arrParams = $this->input->post('params')) ? json_encode(array_filter($arrParams)) : json_encode(array()),
                        'publish' => (int) $this->input->post('publish'),
                        'device' => (int) $this->input->post('device')
                    );
                    $input['access'] = $this->input->post('access');
                    if ($action == 'add') {
                        $result = $this->block->insert($input);
                        if ($item_id = $result) {
                            $html =$this->load->view('block/form',$this->_add()); 
                        }
                    }
                    else {
                        if ($this->security->verify_token_post($params['id'],$this->input->post('token'))) {
                            $result = $this->block->update($params['id'],$input);   
                        }
                        if ($result) {
                            $item_id = $params['id'];
                            $html =$this->load->view('block/form',$this->_edit($params['id'])); 
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
                $result = $this->block->delete($arrId);
                
                if ($result) {
                    // log action
                    
                    $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $arrId));
                    // return html view
                    $html = $this->load->view('block/list',$this->_index()); 
                    return $this->output->set_output(json_encode(array('status' => 'success','html' => $html, 'result' => $result, 'message' => $this->lang->line("common_delete_success"))));
                }
            break;
            default:
                # code...
                break;
        }   
        return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_no_row_update"))));
    }
} ?>