<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menu extends CI_Controller{
    public $module = 'menu';
    function __construct(){
		parent::__construct();
		$this->lang->load('backend/menu');
		$this->load->setData('title',$this->lang->line('menu_title'));
	}
    public function index(){
        if ($this->input->post('delete'))
        {
            return $this->_action('delete');
        }
        $this->load->setArray(array("isLists" => 1));
        $data = $this->_index();
        // render view
        $this->load->layout('menu/list',$data);
    }
    public function add(){
        if ($this->input->post('submit')) {
            return $this->_action('add');
        }
        $this->load->setArray(array("isForm" => 1));
        $data = $this->_add();
        $this->load->layout('menu/form',$data);
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
        $this->load->layout('menu/form',$data);
    }
    public function edit($id) {
        $id = (int) $id;
        if ($this->input->post('submit')) {
            return $this->_action('edit',array('id' => $id));
        }
        $this->load->setArray(array("isForm" => 1));
        $data = $this->_edit($id);
        $this->load->layout('menu/form',$data);
    }
    public function option() {
        $this->load->model('admin/menu_model','menu');
        $this->load->model('admin/logs_model','logs');
        $type = $this->input->get('type');
        $id = $this->input->get('id');
        $data = $option = array();
        switch ($type) {
            case 'position':
                $excluse = (int) $this->input->get('excluse');
                $arrMenu = $this->menu->get_menu(array('position' => $id));
                $data = $this->menu->recursiveMenu($arrMenu,array('excluse' => $excluse));
                $data = $data[$id];
                break;
            case 'select':
                $module = $this->input->get("module");
                if ($module == 'news_cate') {
                    $this->load->model('admin/category_model','category');
                    // get category recursive
                    $arrCate = $this->category->get_category(array('type' => 1));
                    $arrCate = $this->category->recursiveCate($arrCate);
                    foreach ($arrCate as $key => $cate) {
                        $data[] = array('id' => $cate['share_url'],'text' => $cate['name'],'item_id' => $cate['cate_id']);
                    }
                }
                elseif ($module == 'product_cate') {
                    $this->load->model('admin/category_model','category');
                    // get category recursive
                    $arrCate = $this->category->get_category(array('type' => 2));
                    $arrCate = $this->category->recursiveCate($arrCate);
                    foreach ($arrCate as $key => $cate) {
                        $data[] = array('id' => $cate['share_url'],'text' => $cate['name'],'item_id' => $cate['cate_id']);
                    }
                }
            break;
            case 'suggest':
                $keyword = $this->input->get("term");
                $module = $this->input->get("module");
                $page = (int) $this->input->get('page');
                $page = ($page > 1) ? $page : 1;
                $limit = 10;
                $offset = ($page - 1) * $limit;
                if ($module == 'news') {
                    $this->load->model('admin/news_model','news');
                    $params = array('limit' => $limit + 1,'publish' => 1,'keyword' => $keyword,'offset' => $offset);
                    $arrNews = $this->news->lists($params);
                    if (count($arrNews) > $limit) {
                        $option['nextpage'] = true;
                        unset($arrNews[$limit]);
                    }
                    foreach ($arrNews as $key => $news) {
                        $data[] = array('id' => $news['share_url'],'text' => $news['title'],'item_id' => $news['news_id']);
                    }
                }
            break;
            default:
                $data = array();
                break;
        }
        return $this->output->set_output(json_encode(array('status' => 'success','data' => $data,'option' => $option)));
    }
    public function _index(){
        $this->load->model('admin/menu_model','menu');
        $params = array();
        ////////////////// FITER /////////
        $params_filter = array_filter(array(
            'position' => $this->input->get('position'),
        ),'filter_item');
        $params = array_merge($params,$params_filter);
        // get array cate
        $arrMenu = $this->menu->get_menu($params);
        $rows = $this->menu->recursiveMenu($arrMenu);
        // set data
        return array('rows' => $rows, 'filter' => $params_filter);
    }
    public function _add(){
        $this->load->model('admin/menu_model','menu');
        // get category recursive
        $arrMenu = $this->menu->get_menu(array('position' => 'main'));
        $arrMenu = $this->menu->recursiveMenu($arrMenu);
        $arrMenu = $arrMenu['main'];
        // set data to view
        return array(
            'arrMenu' => $arrMenu,
        );
    }
    public function _edit($id){
        $this->load->model('admin/menu_model','menu');
        $row = $this->menu->detail(intval($id));
        if (!$row) {
            show_404();
        }
        // get category recursive
        $arrMenu = $this->menu->get_menu(array('position' => $row['position']));
        $arrMenu = $this->menu->recursiveMenu($arrMenu,array('excluse' => $id));
        $arrMenu = $arrMenu[$row['position']];
        // get data news or product        
        switch ($row['item_mod']) {
            case 'news':
                $this->load->model('admin/news_model','news');
                $arrNews = $this->news->detail($row['item_id']);
                $data_suggest = ($arrNews) ? array('id' => $arrNews['share_url'],'text' =>$arrNews['title'],'item_id' => $arrNews['news_id']) : array();
                break;
            default:
                $data_suggest = array();
                break;
        }
        // check menu child
        $countChild = $this->menu->check_child($row['menu_id']);
        // set data to view
        return  array(
            'arrMenu' => $arrMenu,
            'row' => $row,
            'data_suggest' => $data_suggest,
            'countChild' => $countChild
        );
    }
    public function _action($action, $params = array()) {
        $this->load->model('admin/menu_model','menu');
        $this->load->model('admin/logs_model','logs');
        switch ($action) {
            case 'add':
            case 'edit':
                $this->load->library('form_validation');
                $valid = array(
                    array(
                         'field'   => 'module',
                         'label'   => $this->lang->line('menu_module'),
                         'rules'   => 'required'
                      ),
                    array(
                         'field'   => 'name',
                         'label'   => $this->lang->line('menu_name'),
                         'rules'   => 'required'
                      ),
                    array(
                         'field'   => 'link',
                         'label'   => $this->lang->line('menu_link'),
                         'rules'   => 'required'
                      ),
                    array(
                         'field'   => 'ordering',
                         'label'   => $this->lang->line('menu_ordering'),
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
                        'link' => $this->input->post("link"),
                        'target' => $this->input->post("target"),
                        'item_mod' =>  $this->input->post('module'),
                        'item_id' => (int) $this->input->post("item_id"),
                        'icon' => $this->input->post('icon'),
                        'hot' => (int)$this->input->post('hot'),
                    );
                    if($this->input->post("position")){
                        $input['position'] = $this->input->post("position");
                    }
                    if ($action == 'add') {
                        $result = $this->menu->insert($input);
                        if ($item_id = $result) {
                            $html =$this->load->view('menu/form',$this->_add()); 
                        }
                    }
                    else {
                        if ($this->security->verify_token_post($params['id'],$this->input->post('token'))) {
                            $result = $this->menu->update($params['id'],$input);   
                        }
                        if ($result) {
                            $item_id = $params['id'];
                            $html =$this->load->view('menu/form',$this->_edit($params['id'])); 
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
                $result = $this->menu->delete($arrId);
                
                if ($result) {
                    // log action
                    $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $arrId));
                    // return result
                    $html = $this->load->view('menu/list',$this->_index()); 
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