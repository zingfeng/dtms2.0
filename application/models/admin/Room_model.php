<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Room_model extends CI_Model {
	private $_table = 'rooms';
    private $_table_to_source = 'rooms_to_source';
    function __construct()
    {
        parent::__construct();
    }
    public function lists(){
		$query = $this->db->get($this->_table,100);
		return $query->result_array();
    }
    public function detail($id){
		$this->db->where('room_id',$id);
    	$query = $this->db->get($this->_table);
    	return $query->row_array();
    }
    public function insert(){
    	$input = $this->_input();
        $input['create_time'] = time();
    	$this->db->insert($this->_table,$input);
    }
    public function update($id){
		$input = $this->_input();
		$this->db->where('room_id',$id);
		$this->db->update($this->_table,$input);
    }
    public function delete(){
    	/** Liet ke danh sach anh can xoa **/
		$id = $this->input->post('cid');
 		/** xoa room **/
		$this->db->where_in('room_id',$id);
		$this->db->delete($this->_table);
        // xoa room by resource
        $this->db->where_in("room_id",$id);
        $this->db->delete($this->_table_to_source);
    }
    private function _input(){
		$input = array(
			'name' => $this->input->post('name'),
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password')
		);
		return $input;
    }
    /**
    * @todo: get room by source 
    * @param: array('source_id' => int, type => int)
    */
    public function getRoomBySource($params) {
        $this->db->select("s.room_id");
        $this->db->where('source_id',$params['source_id']);
        $this->db->where("type",$params['type']);
        //$this->db->join($this->_table .' as r','s.room_id = r.room_id');
        $query = $this->db->get($this->_table_to_source. ' as s',100);
        return $query->result_array();
    }
    /**
    * @todo: get room by source 
    * @param: array('source_id' => int, type => int, room_id => array())
    */
    public function insertSourceToRoom($params) {
        // delete old
        $this->deleteSourceToRoom($params);
        // insert
        if ($params['room_id']) {
            foreach ($params['room_id'] as $key => $room_id) {
                $input[] = array(
                    'room_id' => $room_id,
                    'type' => $params['type'],
                    'source_id' => $params['source_id']
                );
            }
            $this->db->insert_batch($this->_table_to_source,$input);
        }
    }
    /**
    * @todo: delete source by source_id 
    * @param: array('source_id' => int,array, type => int,)
    */
    public function deleteSourceToRoom($params) {
        // delete old
        $this->db->where('type',$params['type']);
        $this->db->where_in('source_id',$params['source_id']);
        $this->db->delete($this->_table_to_source);
    }
}