<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Test_model extends CI_Model
{
    private $_db_table = array(
        'test' => 'test',
        'test_question' => 'test_question',
        'test_question_answer' => 'test_question_answer',
        'test_logs' => 'test_logs',
        'users' => 'users'
    );

    function __construct()
    {
        parent::__construct();
    }

    public function get_rule()
    {
        $this->db->where('type', 'reading');
        $query = $this->db->get('result_test');
        $arr_reading = $query->result_array();

        $this->db->where('type', 'writing');
        $query = $this->db->get('result_test');
        $arr_writing = $query->result_array();

        $this->db->where('type', 'listening');
        $query = $this->db->get('result_test');
        $arr_listening = $query->result_array();

        $this->db->where('type', 'speaking');
        $query = $this->db->get('result_test');
        $arr_speaking = $query->result_array();

        // pass to view
        return array(
            'reading' => $arr_reading,
            'writing' => $arr_writing,
            'listening' => $arr_listening,
            'speaking' => $arr_speaking,
        );
    }

    public function delete($id_rule)
    {
        $this->db->delete('result_test', array('id' => $id_rule));
    }

    public function set_rule($data)
    {
//        $data = array(
//            'type' => 'reading',
//            'form_point' => 9,
//            'to_point' => 10,
//            'result' => 'result',
//            'suggest' => 'suggest',
//        );

        $this->db->insert('result_test', $data);
    }
}