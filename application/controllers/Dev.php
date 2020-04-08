<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dev extends CI_Controller
{
   public function check(){
       $this->load->model('Feed_upgrade_model','fu');
       $r = $this->fu->get_class_info_where_in_teacher_id([1],'class_id, class_code, type, point_phone, main_teacher' );
       echo '<pre>';
       print_r($r);
   }

    public function check_duplicate_class_code(){
        $this->db->select('class_code');
        $r = $this->db->get('feedback_class');
        $arr_res = $r->result_array();

        $report = [];
        foreach ($arr_res as $m){
            $class_code = $m['class_code'];
            if (isset($report[$class_code])){
                $n = $report[$class_code];
                $report[$class_code] = $n + 1;
            }else{
                $report[$class_code] = 1;
            }
        }

        foreach ($report as $class_code => $number){
            if ($number > 1){
                echo "\n ". $class_code. "\t\t".$number;
            }
        }

    }

    public function index(){
        $this->load->model('Feed_upgrade_model','fu');
        $r = $this->fu->get_list_bell();
        echo '<pre>';
        print_r($r);
    }


    public function update_main_teacher_first_times()
    {
        ini_set('max_execution_time', '0'); // for infinite time of execution
        $this->db->select('class_id, list_teacher');
        $query = $this->db->get('feedback_class');
        $arr_res = $query->result_array();
        $count = count($arr_res);
        for ($i = 0; $i < $count; $i++) {
            echo "\n ".$i."\t /".$count;
            $m = $arr_res[$i];
            $class_id = $m['class_id'];
            $list_teacher = json_decode($m['list_teacher']);
            if (count($list_teacher) > 0){
                $main_teacher = (int) $list_teacher[0];
            }else{
                $main_teacher = null;
            }
            $this->db->set('main_teacher', $main_teacher, FALSE); // feedback form
            $this->db->where('class_id', $class_id);
            $this->db->update('feedback_class');
        }
    }


    public function update_number_fb_first_times()
    {
        ini_set('max_execution_time', '0'); // for infinite time of execution
        $this->db->select('class_code');
        $query = $this->db->get('feedback_class');
        $arr_res = $query->result_array();
        $count = count($arr_res);
        for ($i = 0; $i < $count; $i++) {
            echo "\n ".$i."\t /".$count;
            $m = $arr_res[$i];
            $class_code = $m['class_code'];
            $this->kill($class_code);
        }
    }
    
    private function kill($class_code){
        $this->load->model('Feedback_model', 'feedback');

        $number_feedback_homthugopy = $this->feedback->get_number_feedback_homthugopy_by_class_code($class_code);
        $count_phone = $this->feedback->get_number_feedback_phone_by_class_code($class_code);
        $count_phone_1 = $this->feedback->get_number_feedback_phone_by_class_code($class_code, 1);
        $count_phone_2 = $this->feedback->get_number_feedback_phone_by_class_code($class_code, 2);
        $count_phone_3 = $this->feedback->get_number_feedback_phone_by_class_code($class_code, 3);
        $count_phone_4 = $this->feedback->get_number_feedback_phone_by_class_code($class_code, 4);
        $count_ksgv1 = $this->feedback->get_number_feedback_ksgv_1_by_class_code($class_code);
        $count_ksgv2 = $this->feedback->get_number_feedback_ksgv_2_by_class_code($class_code);
        $count_feedback_online = $this->feedback->get_number_feedback_online_by_class_code($class_code);

        $this->db->set('number_feedback_phone', $count_phone, FALSE); // feedback form
        $this->db->set('number_feedback_phone_1', $count_phone_1, FALSE); // feedback form
        $this->db->set('number_feedback_phone_2', $count_phone_2, FALSE); // feedback form
        $this->db->set('number_feedback_phone_3', $count_phone_3, FALSE); // feedback form
        $this->db->set('number_feedback_phone_4', $count_phone_4, FALSE); // feedback form
        $this->db->set('number_feedback_ksgv1', $count_ksgv1, FALSE); // feedback form
        $this->db->set('number_feedback_ksgv2', $count_ksgv2, FALSE); // feedback form
        $this->db->set('number_feedback_online', $count_feedback_online, FALSE); // feedback form
        $this->db->set('number_feedback_homthugopy', $number_feedback_homthugopy, FALSE); // feedback form

        $this->db->where('class_code', $class_code);
        $this->db->update('feedback_class');
    }


}
