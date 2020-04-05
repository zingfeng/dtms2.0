<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class statistic {
	var $timeout = 600;
	function user_online(){
        $CI = &get_instance();
        $CI->db->where("timestamp >",time() - 60);
        return $CI->db->count_all_results("ci_sessions");
	}
    function hit_counter(){
        $CI = &get_instance();
        $CI->load->helper("file");
        $data = read_file('statistic.txt');
        $data = @unserialize($data);
        if ($CI->session->userdata("is_hit_counter") !== 1 OR $data === FALSE){
            if (!is_array($data) OR !array_key_exists('hit_counter',$data)){
                $data['hit_counter'] = 1000;
            }
            else{
                $data['hit_counter'] = $data['hit_counter'] + 1;
            }
            write_file("statistic.txt",serialize($data));
            $CI->session->set_userdata("is_hit_counter",1);
        }
        return $data['hit_counter'];
    }
}

?>