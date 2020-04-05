<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Calendar_model extends CI_Model {
	function __construct()
    {
        parent::__construct();
    }
    public function lists($limit = 10){
        $offset = 0;
        $array = $this->input->get(NULL);
        if (!empty($array)){
            if (array_key_exists('page',$array)){
                $offset = ($array['page'] - 1) * $limit;
            }
            if (array_key_exists('location',$array) AND $array['location'] > 0){
                $this->db->where('location',$array['location']);
            }
        }
		$this->db->order_by('start_time DESC');

		$query = $this->db->get('calendar',$limit+1,$offset);
		return $query->result_array();
    }
    public function get_calendar_by_id($arrId) {
        $arrId = array_unique($arrId);
        $this->db->where_in('calendar_id',$arrId);
        $query = $this->db->get('calendar');
        return $query->result_array();
    }
    public function register_lists($limit = 10){
        $offset = 0;
        $array = $this->input->get(NULL);
        if (!empty($array)){
            if (array_key_exists('page',$array)){
                $offset = ($array['page'] - 1) * $limit;
            }
            if (array_key_exists('location',$array) AND $array['location'] > 0){
                $this->db->where('location',$array['location']);
            }
        }
        $this->db->order_by('register_id DESC');

        $query = $this->db->get('calendar_register',$limit+1,$offset);
        return $query->result_array();
    }
    public function change_status(){
        /** Liet ke danh sach anh can xoa **/
        $id = $this->input->post('cid');
        $this->db->set('status',1);
        $this->db->where_in('register_id',$id);
        $this->db->update('calendar_register');
    }
    public function detail($id){
		$this->db->where('calendar_id',$id);
    	$query = $this->db->get('calendar');
    	return $query->row_array();
    }
    public function insert(){
    	$input = $this->_input();
        $input['create_time'] = time();
    	$this->db->insert('calendar',$input);
    }
    public function update($id){
		$input = $this->_input();
		$this->db->where('calendar_id',$id);
		$this->db->update('calendar',$input);
    }
    public function delete(){
    	/** Liet ke danh sach anh can xoa **/
		$id = $this->input->post('cid');
 		/** xoa adv **/
		$this->db->where_in('calendar_id',$id);
		$this->db->delete('calendar');
    }
    public function delete_register(){
        /** Liet ke danh sach anh can xoa **/
        $id = $this->input->post('cid');
        $this->db->where_in('register_id',$id);
        $this->db->delete('calendar_register');
    }
    private function _input(){
		$input = array(
			'name' => $this->input->post('name'),
			'class' => $this->input->post('class'),
			'date' => $this->input->post('date'),
            'time' => $this->input->post('time'),
			'start_time' => convert_datetime($this->input->post('start_time'),3),
			'price' => intval($this->input->post('price')),
            'location' => intval($this->input->post('location'))
		);
		return $input;
    }
}