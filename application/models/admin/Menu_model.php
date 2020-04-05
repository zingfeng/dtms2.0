<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menu_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }
    /**
    * @param: id (int)
    * @todo: get detail menu
    * @author: namtq
    **/
    public function detail($id){
    	$this->db->where('menu_id',$id);
    	$query = $this->db->get('menus',1);
    	return $query->row_array();
    }
    public function insert($input){
    	$input = array_merge($input,array(
            'create_time' => time()
        ));
		$this->db->insert('menus',$input);
        return (int)$this->db->insert_id();
    }
    public function update($id,$input){
		$this->db->where('menu_id',$id);
		$this->db->update('menus',$input);
        return $this->db->affected_rows();
    }
    public function delete($cid = array()){
        if (is_numeric($cid)) {$cid = array($cid);}
        $arrMenu = $this->get_menu();
        $arrId = $cid;
        foreach ($cid as $key => $id) {
            if ($id <= 0) continue;
            if ($arrMenuRev = $this->recursiveMenu($arrMenu,array('parent_id' => $id))){
                foreach ($arrMenuRev as $key => $c) {
                    $arrId[] = (int) $c['menu_id'];
                }
            }
        }
        $countRow = false;
        if ($arrId) {
            $arrId = array_unique($arrId);
            // DELETE BLOCK
            $this->db->where_in('menu_id',$arrId);
            $this->db->delete('block_to_module');
            // DELETE MENU
            $this->db->where_in('menu_id',$arrId);
            $this->db->delete('menus');
            $countRow = $this->db->affected_rows();
        }
        return $countRow;
    }
    /**
    * @author: namtq
    * @todo: Get menu for dropbox
    */
    public function get_menu($params = array()) {
        $this->db->select("*");
        if ($params['position']) {
            $this->db->where('position',$params['position']);
        }
        $this->db->order_by('position,parent,ordering,menu_id DESC');
        $query = $this->db->get('menus');
        return $query->result_array();
    }
    /**
    * @author: namtq
    * @todo: Get menu for dropbox
    */
    public function recursiveMenu($arrMenu,$params = array()) {
        $params = array_merge(array('parent_id' => 0, 'subStr' => '','excluse' => 0),$params);
        foreach($arrMenu as $key => $menu){
            if ($menu['menu_id'] == $params['excluse']){
                unset($arrMenu[$key]);
                continue;
            }
            if ($menu['parent'] == $params['parent_id']){
                unset($arrMenu[$key]);
                $menu['name'] = $params['subStr'].$menu['name'];
                $result[$menu['position']][$menu['menu_id']] = $menu;
                $rev = $this->recursiveMenu($arrMenu,array('parent_id' => $menu['menu_id'], 'excluse' => $params['excluse'], 'subStr' => '-- '.$params['subStr']));
                if ($rev) {
                    $result[$menu['position']] = $result[$menu['position']] + $rev[$menu['position']];
                }
            }
        }
        return $result;
    }
    /**
    * @author: namtq
    * @todo: check menu if have child
    * @param: cate id
    */
    public function check_child($cate_id) {
        $this->db->where('parent',$cate_id);
        return $this->db->count_all_results('menus');
    }
}