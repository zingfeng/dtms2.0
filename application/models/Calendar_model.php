<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Calendar_model extends CI_Model {
	function __construct()
    {
        parent::__construct();
    }
    public function get_all() {
        $this->db->order_by('location, start_time DESC');
        $query = $this->db->get('calendar');
        return $query->result_array();
    }
    public function insert($input = array()){
        $input['create_time'] = time();
    	$this->db->insert('calendar_register',$input);
    }
}