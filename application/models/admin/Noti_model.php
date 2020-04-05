<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Noti_model extends CI_Model {
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
//        $query = $this->db->get('block',$params['limit'],$params['offset']);
        $query = $this->db->get('noti');
        return $query->result_array();
    }
    public function detail($id){
        $this->db->where('id_noti',$id);
        $query = $this->db->get('noti');
        return $query->row_array();
    }
    /**
    * @author: Namtq
    * @todo: Insert Block
    */
    public function insert($input){
        $input['noti'] = array_merge($input['noti'], array(
            'creat_time' => time()
        ));
        // insert data
        $this->db->insert('noti',$input['noti']);
        $noti_id = (int)$this->db->insert_id();
//        if ($block_id) {
//            $this->_update_block_access($block_id,$input['access']);
//        }
        return $noti_id;
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
    public function update($noti_id, $input){
        // update block detail
        $this->db->where('id_noti',$noti_id);
        $this->db->update('noti',$input['noti']);
        $countRow = $this->db->affected_rows();
        // update block access
//        if ($noti_id) {
//            $this->_update_block_access($noti_id,$input['access']);
//        }
        return $countRow;
    }
    public function get_access($block_id) {
//        $this->db->where("block_id",$block_id);
//        $query = $this->db->get('block_to_module');
//        return $query->result_array();
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
        $this->db->where_in('id_noti',$cid);
        $this->db->delete('noti');
        return $this->db->affected_rows();
    }

    // Ghi tên và thẻ trung gian ...
    public function make_noti_old($list_noti,$id_user){
        $id_user = (int) $id_user;
        if (! is_array($list_noti)){
            $list_noti = array($list_noti);
        }
        for ($i = 0; $i < count($list_noti); $i++) {
            $id_noti = (int) $list_noti[$i];
            $this->db->where('id_noti',$id_noti);
            $this->db->where('user',$id_user);
            $this->db->set('status', 1);
            $this->db->update('id_noti_to_user');
        }
    }

    public function add_bell_noti($id_noti,$id_course)
    {
        $list_id_user = $this->get_list_id_user_by_id_course($id_course);
        for ($i = 0; $i < count($list_id_user); $i++) {
            $id_user = $list_id_user[$i];
            $data_insert = array(
                'id_noti' => $id_noti,
                'user' => $id_user,
                'status' => 0,
                'creat_time' => time(),
                'update_time' => time(),
            );
            $this->db->insert('id_noti_to_user',$data_insert);
        }
    }
    public function del_bell_noti($id_noti)
    {
        $this->db->delete('id_noti_to_user', array('id_noti' => $id_noti));
    }

    public function edit_bell_noti($id_noti,$id_course)
    {
        $this->del_bell_noti($id_noti);
        $this->add_bell_noti($id_noti,$id_course);
    }

    private function get_list_id_user_by_id_course($arr_id_course)
    {
        $list_id_user = array();
        for ($i = 0; $i < count($arr_id_course); $i++) {
            $this->db->select('user_id');
            $this->db->where('course_id',$arr_id_course[$i]);
            $query = $this->db->get('course_to_user');
            $arr_res = $query->result_array();
            for ($k = 0; $k < count($arr_res); $k++) {
                array_push($list_id_user,$arr_res[$k]['user_id']);
            }
        }
        return $list_id_user;
    }

    public function get_list_noti_client_for_user($id_user)
    {
        $arr_id_noti = $this->get_list_noti_for_user($id_user);
        $arr_noti_client = $this->get_detail_noti($arr_id_noti);
        return $arr_noti_client;
    }

    private function get_list_noti_for_user($id_user)
    {
        $arr_id_noti = array();
        $this->db->where('status',0);
        $this->db->where('user',$id_user);
        $this->db->select('id_noti');
        $query = $this->db->get('id_noti_to_user');
        $arr_res = $query->result_array();

        for ($k = 0; $k < count($arr_res); $k++) {
            $id_noti = $arr_res[$k]['id_noti'];
            array_push($arr_id_noti,$id_noti);
        }

        return $arr_id_noti;
    }

    private function get_detail_noti($arr_id_noti){
        $arr_detail_noti = array();
        for ($i = 0; $i < count($arr_id_noti); $i++) {
            $id_noti = (int) $arr_id_noti[$i];
            $this->db->where('id_noti',$id_noti);
            $this->db->select('id_noti,title,content,link,avarta,creat_time');
            $query = $this->db->get('noti');
            $arr_detail_noti[] = $query->result_array();
        }
        return $arr_detail_noti;
    }

}