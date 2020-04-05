<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Setting_model extends CI_Model {
	function __construct()
    {
        parent::__construct();
    }
    public function detail(){
    	$query = $this->db->get('setting');
    	return $query->row_array();
    }
    public function update($input){
        // update news 
        $input['setting'] = array_merge($input['setting'],array(
            'update_time' => time()
        ));
        $this->db->where('site_id',SITE_ID);
        $this->db->update('setting',$input['setting']);
        $countRow = $this->db->affected_rows();
        return $countRow;
    }

    public function get_redirect_link_test($writing_or_speaking){
	    // ALTER TABLE `setting` ADD `link_writing` TEXT NULL AFTER `offline_place`, ADD `link_speaking` TEXT NULL AFTER `link_writing`;
        $this->db->where('site_id',1);
        $this->db->select('link_writing, link_speaking');
        $query = $this->db->get('setting');
        $arr_res = $query->result_array();
        $link_writing = $arr_res[0]["link_writing"];
        $link_speaking = $arr_res[0]["link_speaking"];
        if (trim(strtolower($writing_or_speaking)) == 'speaking'){
            return $link_speaking;
        }else{
            return $link_writing;
        }
    }
}