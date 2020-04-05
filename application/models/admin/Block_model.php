<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Block_model extends CI_Model {
	function __construct()
    {
        parent::__construct();
    }
    public function lists($params = array()) {
        $params = array_merge(array('limit' => 30,'offset' => 0),$params);
        if ($params['keyword']){
            $this->db->like('name',$params['keyword']);
        }
        if (isset($params['position'])) {
            $this->db->where('position',$params['position']);
        }
        if (isset($params['module'])) {
            $this->db->where('module',$params['module']);
        }
        if (isset($params['publish'])) {
            $this->db->where('publish',$params['publish']);
        }
        $this->db->order_by('block_id DESC');
        $query = $this->db->get('block',$params['limit'],$params['offset']);
        return $query->result_array();
    }
    public function detail($id){
        $this->db->where('block_id',$id);
        $query = $this->db->get('block');
        return $query->row_array();
    }
    /**
    * @author: Namtq
    * @todo: Insert Block
    */
    public function insert($input){
        $input['block'] = array_merge($input['block'], array(
            'create_time' => time()
        ));
        // insert data
        $this->db->insert('block',$input['block']);
        $block_id = (int)$this->db->insert_id();
        if ($block_id) {
            $this->_update_block_access($block_id,$input['access']);
        }
        return $block_id;
    }
    private function _update_block_access($block_id,$arrMenu = array()) {
        $this->db->where('block_id',$block_id);
        $this->db->delete('block_to_module');
        if (!$arrMenu) {
            $arrMenu = array(0);
        }
        $arrMenu = array_unique($arrMenu);
        foreach ($arrMenu as $key => $menu) {
            $input[] = array('block_id' => $block_id, 'menu_id' => $menu);
        }
        if ($input) {
            $this->db->insert_batch('block_to_module',$input);
        }
    }
    public function update($block_id, $input){
        // update block detail
        $this->db->where('block_id',$block_id);
        $this->db->update('block',$input['block']);
        $countRow = $this->db->affected_rows();
        // update block access
        if ($block_id) {
            $this->_update_block_access($block_id,$input['access']);
        }
        return $countRow;
    }
    public function get_access($block_id) {
        $this->db->where("block_id",$block_id);
        $query = $this->db->get('block_to_module');
        return $query->result_array();
    }
    /**
    * @author: namtq
    * @todo: Delete Block
    */
    public function delete($cid = array()){
        if (is_numeric($cid)) {$cid = array($cid);}
        /*
        $this->db->where_in('block_id',$cid);
        $this->db->delete('block_to_module'); */
        $this->db->where_in('block_id',$cid);
        $this->db->delete('block');
        return $this->db->affected_rows();
    }
}