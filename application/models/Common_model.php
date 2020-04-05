<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Common_model extends CI_Model {
    private $arrMenu;
    function __construct()
    {
        parent::__construct();
    }
    public function set_setting(){
        $query = $this->db->get('setting');
        return $query->row_array();
    }
    /** 
    * @todo: Get all block for layout
    * @param: 
    * @author: namtq
    */
    public function get_all_block(){
        return null;
        $arrMenuIdSelect = $this->_menu_access();
        // get all block
        $this->db->where_in("m.menu_id",$arrMenuIdSelect);
        $this->db->where_in("b.device",array(0,DEVICE_ENV));
        $this->db->order_by('b.ordering');
        $this->db->where("b.publish",1);
        $this->db->join("block as b","b.block_id = m.block_id");
        $query = $this->db->get('block_to_module as m');
        /// get all block data
        $blocks = $query->result_array();
        // get all data
        foreach ($blocks as $block){
            $param = @json_decode($block['params'],TRUE);
            $data = array();
            $data['block'] = $block;
            $data['params'] = $param;
            switch ($block['module']){
                case 'news_special':
                    $this->load->model('news_model','news');
                    $data['rows'] =  $this->news->get_buildtop(array('position' => $block['position']));
                break;
                case 'news_cate':
                    $this->load->model('news_model','news');
                    $this->load->model('category_model','category');
                    $limit = ($param['nums_item'] > 50) ? 50 : $param['nums_item'];
                    $blockParams = array('category_id' => $param['id'],'limit' => $limit);
                    $rows = $this->news->lists_by_cate_rule1($blockParams);
                    foreach ($rows as $key => $row) {
                        $rows[$key]['params'] = json_decode($row['params'],TRUE);
                    }
                    $data['rows'] = $rows;
                    $data['cateDetail'] = $this->category->detail($param['id']);
                break;
                case 'news':

                break;
                case 'news_sub_cate':
                    $this->load->model('category_model','category');
                    $this->load->model('news_model','news');
                    // get category 
                    $arrCate = $this->category->get_category(array('parent' => $param['id'],'limit' => 3));
                    $arrNews = array();
                    if ($param['template'] == 'document') {
                        foreach ($arrCate as $key => $cateData) {
                            $arrNews[$cateData['cate_id']] = $this->news->lists_by_cate_rule1(array('category_id' => $cateData['cate_id'],'limit' => $param['nums_item']));
                        }
                    }
                    else {
                        $arrNews = $this->news->lists_by_cate_rule1(array('category_id' => $param['id'],'limit' => $param['nums_item']));
                    }
                    
                    //var_dump($arrCateId$arrNews); die;
                    $data['rows'] = $arrNews;
                    $data['arrCate'] = $arrCate;
                    $data['cateDetail'] = $this->category->detail($param['id']);
                break;
                case 'expert':
                    $this->load->model('expert_model','expert');
                    $limit = ($param['nums_item'] > 15) ? 15 : $param['nums_item'];
                    $data['rows'] = $this->expert->get_expert(array('limit' => $limit));
                    $data['cateDetail'] = $this->category->detail($param['id']);
                break;
                case 'advertise_cate':
                    $data['rows'] = $this->get_advertise($param['id'],array('limit' => $param['nums_item']));
                break;
                case 'static':
                   $data['rows'] = $block['content'];
                break;
                case 'menu':
                    $arrMenu = $this->_get_menu($param['menu']);
                    $data['rows'] = $this->recursiveMenu($arrMenu);
                    $data['menuSelected'] = $arrMenuIdSelect;
                break;
                case 'course':
                    $this->load->model('course_model','course');
                    $limit = ($param['nums_item'] > 15) ? 15 : $param['nums_item'];
                    $data['rows'] = $this->course->getCourse(array('limit' => $limit, 'price' => 0));
                break;
                default:
                    $data['rows'] = array();
            }
            if (!empty($data['rows'])){
                $file = ($param['template']) ? $block['module'].'_'.$param['template'] : $block['module'];
                $this->load->setArray($block['position'],$this->load->view('block/'.$file,$data));
                if ($block['position'] == 'top' && $block['module'] == 'menu') {
                    $file = $block['module'].'_'.'mobile';
                    $this->load->setArray('menu_mobile',$this->load->view('block/'.$file,$data));
                }
            }
        }
    }
    /** 
    * @todo: Get block advertise
    * @param: cate_id (int), option (array)
    * @author: namtq
    */
    private function get_advertise($cate_id = 0,$option = array()) {
        $option = array_merge(array('limit'=> 10),$option);
        $this->db->select('name,link,images,description');
        $this->db->where('cate_id',$cate_id);
        $this->db->order_by('ordering');
        $this->db->where("publish",1);
        $query = $this->db->get('advertise',$option['limit']);
        return $query->result_array();
    }
    /** 
    * @todo: Get block menu
    * @param: position
    * @author: namtq
    */
    private function _get_menu($position = '') {
        if (!$this->arrMenu){
            $this->db->select("*");
            $this->db->order_by('position,ordering,menu_id DESC');
            $query = $this->db->get('menus');
            $rows = $query->result_array();
            foreach ($rows as $key => $row) {
                $arrMenu[$row['position']][] = $row;
            }
            $this->arrMenu = $arrMenu;
        }
        return ($position) ? $this->arrMenu[$position] : $this->arrMenu;
    }
    private function recursiveMenu($arrMenu,$params = array()) {
        $params = array_merge(array('parent_id' => 0),$params);
        foreach($arrMenu as $key => $menu){
            if ($menu['parent'] == $params['parent_id']){
                unset($arrMenu[$key]);
               
                $result[$menu['menu_id']] = $menu;
                $rev = $this->recursiveMenu($arrMenu,array('parent_id' => $menu['menu_id']));
                if ($rev) {
                    $result[$menu['menu_id']]['child'] = $rev;
                }
            }
        }
        return $result;
    }
    /** 
    * @todo: Get block menu
    * @param: position
    * @author: namtq
    */
    public function _menu_access($params = array()) {
        $arrAccess = $this->config->item("menu_select");
        $arrMenu = $this->_get_menu();
        $arrMenuSelect = array(0);
        foreach ($arrMenu as $position => $arrMenu) {
            foreach ($arrMenu as $key => $menu) {
                $menuId = (int) $menu['menu_id'];
                if ($menu['item_mod'] != 'link') {
                    if (is_array($arrAccess)) {
                        foreach ($arrAccess as $key => $access) {
                            if ($menu['item_mod'] == $access) {
                                if ((is_array($access) && in_array($menu['item_id'], $access)) || $menu['item_mod'] === $access) {
                                    $arrMenuSelect[] = (int) $menu['menu_id'];
                                }
                            }
                        }
                    }
                    else {
                        if ($menu['item_mod'] == $arrAccess) {
                            $arrMenuSelect[] = $menuId;
                        }
                    } 
                }
                elseif ($menu['link'] == current_url() || trim($menu['link'],'/') == uri_string()) {
                    $arrMenuSelect[] = (int) $menu['menu_id'];
                }
            }
        }
        return $arrMenuSelect;
    }
}