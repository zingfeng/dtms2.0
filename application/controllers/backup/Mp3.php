<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mp3 extends CI_Controller{
    protected $user_data;
    protected $username = '';
    public function __construct(){
        parent::__construct();
        $this->lang->load('frontend/users');
    }
/** =================================== LOGIN ========================================= **/
    public function index(){
        $this->load->view('test/test_mp3','',false);
    }

    public function ins(){
//        $this->load->view('test/high','',false);

        // ALTER TABLE `setting` ADD `link_writing` TEXT NULL AFTER `offline_place`, ADD `link_speaking` TEXT NULL AFTER `link_writing`;
//        $this->db->where('site_id',1);
//        $this->db->select('link_writing, link_speaking');
//        $query = $this->db->get('setting');
//        $arr_res = $query->result_array();
//        var_dump($arr_res);

        $this->db->where('test_id',14);
        $this->db->select('title');
        $query = $this->db->get('test');
        $arr_res = $query->result_array();
//        var_dump($arr_res);
//        return $arr_res;
        echo '<pre>'; print_r($arr_res); echo '</pre>';

    }

    public function speaking(){
        $this->load->view('speaking','',false);
    }

    public function highlight(){
        //
        $this->load->view('test/high','',false);
    }

    public function ins2(){
        $this->load->view('test/high2','',false);
    }



}