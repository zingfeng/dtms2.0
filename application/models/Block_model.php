<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Block_model extends CI_Model {
	protected $_position = array();
    protected $_menu = array();
    private $menu_parent = array();
    private $_menu_tree = array();
    function __construct()
    {
        parent::__construct();
    }
    public function get_all_block($option = array()){
        $menuSelect = $this->config->item("menu_select");
        if ($this->config->item("mod_access")){
            $mod = $this->config->item("mod_access");
            $mod = $mod['name'];
            $this->db->where_in("m.module",array("all",$mod));
        }
        else{
            $this->db->where_in("m.module","all");
        }
        $this->db->where_in("b.device",array(0,DEVICE_ENV));
        $this->db->where("b.lang",$this->config->item("lang"));
        $this->db->order_by('b.ordering');
        $this->db->where("b.publish",1);
        if ($option['position']) {
            $this->db->where_in('b.position',$option['position']);
        }
        $this->db->join("block as b","b.block_id = m.block_id");
        $query = $this->db->get('block_to_module as m');
        /// get all block position
        $blocks = $query->result_array();
        // get all data
        foreach ($blocks as $block){
            $pre = false;
            $param = @json_decode($block['params'],TRUE);
            $data = array();
            $data['block'] = $block;
            $data['params'] = $param;
            switch ($block['module']){
                case 'category':
                    $this->load->model('news_model','news');
                    $allNewsCategory = $this->news->get_category(array('style' => 2));
                    if($menuSelect['item_news_cate_id']){
                        $data['params']['cate_id'] = $menuSelect['item_news_cate_id'];
                    }
                    $data['rows'] = $this->news->recursiveCate($allNewsCategory);
                break;
                case 'news_cate':
                    $arrData = $this->news_cate($param);
                    $data['rows'] = $arrData['rows'];
                    $data['cateblock'] = $arrData['cate'];
                break;
                case 'news':
                    $data['rows'] = $this->news($param['id'],1);
                break;
                case 'advertise_cate':
                    $data['rows'] = $this->advertise_cate($param['id'],$param['nums_item']);
                break;
                case 'static':
                    $data['rows'] = $block;
                break;

                case 'menu':
                    $data['rows'] = $this->tree($param['position']);
                break;
                case 'test_cate':
                    $type = $menuSelect['item_type'];
                    $params_test = array();
                    if (in_array($menuSelect['item_mod'], array('test_list','test_detail'))) {
                        $params_test = array('type' => $menuSelect['item_type'],'cate_id' => $menuSelect['item_id']);
                        $pre = true;
                        $data['type'] = $menuSelect['item_type'];
                    }
                    $data['rows'] = $this->test_cate($params_test);

                break;
                default:
                    $data['rows'] = array();
            }
            if (!empty($data['rows'])){
                $file = ($param['template']) ? $block['module'].'_'.$param['template'] : $block['module'];
                $this->load->setArray($block['position'],$this->load->view('block/'.$file,$data),$pre);
            }
        }
        $this->addstatic();
    }
    public function test_cate($params = array()) {

        $this->db->select('name,cate_id,parent,share_url,images');
        if ($params['type']) {
            $this->db->where("type",$params['type']);
        }
        $this->db->order_by("parent,ordering");
        $query = $this->db->get("test_cate");
        $arrCate = $query->result_array();

        $nodeList = array();
        $tree     = array();
        foreach ($arrCate as $row) {
            if ($row['cate_id'] == $params['cate_id']) {
                $row['selected'] = 1;
            }
            $nodeList[$row['cate_id']] = $row;//array_merge($row, array('child' => array()));
        }
        $i = 1;
        foreach ($nodeList as $nodeId => &$node) {

            if (!$node['parent'] || !array_key_exists($node['parent'], $nodeList)) {
                $tree[] = &$node;
            } else {
                $nodeList[$node['parent']]['child'][] = &$node;
            }
            $i ++;
        }
        unset($node);
        unset($nodeList);
        return $tree;
    }
    private function news($id){
        if ($id <= 0){return array();}
        $this->db->select("title,description,images");
        $this->db->where("news_id",$id);
        $query = $this->db->get("news",1);
		return $query->row_array();
    }
    private function news_cate($param){
        if ($param['id'] <= 0 || $param['nums_item'] <= 0){return array();}
        $this->db->where('n.publish',1);
        $this->db->from('news as n');
        $this->db->order_by('n.date_up DESC, n.news_id DESC');
        $this->db->join('news_to_cate as t','t.news_id = n.news_id');
        $this->db->where('t.cate_id = '.$param['id']);
		$this->db->select('n.news_id,n.title,n.share_url,n.images,description');
		$this->db->limit($param['nums_item']);
        $query = $this->db->get();
		$data['rows'] = $query->result_array();
        if ($param['title'] == 1) {
            $this->db->where('cate_id',$param['id']);
            $query = $this->db->get("news_cate");
            $data['cate'] = $query->row_array();
        }
        return $data;
    }
    private function news_detail($id){
        if ($id <= 0){return array();}
        $this->db->select("title,images,description,detail");
        $this->db->where("news_id",$id);
        $query = $this->db->get("news");
        return $query->row_array();
    }
    
    public function advertise_cate($cate_id,$limit = 0){
        if ($cate_id <= 0){return array();}
        if ($limit > 0){
            $this->db->limit($limit);
        }
		$this->db->where('publish',1);
        $this->db->where('cate_id',(int)$cate_id);
        $this->db->order_by('ordering');
        $query = $this->db->get('advertise');
        return $query->result_array();
    }
    /**
    * @todo: Create tree for menu
    * @param: position (str) 
    * @author: namtq
    **/
    public function tree($position) {
        if ($this->_menu_tree[$position]){
            return $this->_menu_tree[$position];
        }
        $menu_select = $this->config->item("menu_select");
        $data = array();
        $this->db->order_by('ordering,menu_id DESC');
        $this->db->where('position',$position);
        $this->db->where("lang",$this->config->item("lang"));
        $query = $this->db->get('menus');
        $rows = $query->result_array();
        // foreach rows
        foreach ($rows as $key => $row) {
            if ($row['item_mod'] == $menu_select['item_mod'] && $row['item_id'] == $menu_select['item_id']) {
                $row['selected'] = 1;
            }
            if ($row['parent'] != 0) {
                $rows[$row['parent']]['select'] = 1;   
            }
            $arr[$row['parent']][] = $row;
        }
        if ($arr) {
            $this->menu_parent = $arr;
            $data = $this->_recursive(0);
        }
        $this->_menu_tree[$position] = $data;
        return $data;
    }
    /**
    * @param: parent_id (int)
    * @todo: support for tree function
    * @author: namtq
    **/
    public function _recursive($parent_id) {
        foreach ($this->menu_parent[$parent_id] as $key =>  $value) {
            
            $rows[$value['menu_id']] = $value;
            if ($this->menu_parent[$value['menu_id']]) {
                $rows[$value['menu_id']]['child'] =  $this->_recursive($value['menu_id']);
            }
        }
        return $rows;
    }
    // default static
    private function addstatic(){
        //$data[] = link_tag('tqn_portal.css');
        //////////////////////////////////
        $script[] = '<div id="message_alert"></div>';
        $script[] = js('common.js');
        $script[] = js($this->config->item("lib").'fancyBox/jquery.fancybox.pack.js');

        
        //$script[] = js('js/jquery-ui-1.10.0.custom.min.js');
        //$script[] = link_tag('css/ui-lightness/jquery-ui-1.10.0.custom.min.css');
        $this->load->setArray('script',$script);
    }
}