<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cache extends CI_Controller
{
    public function index()
    {

        // ini_set('display_errors', 1);
        // ini_set('display_startup_errors', 1);
        // error_reporting(E_ALL);


        $this->load->helper('redis');
        
        $redis = creat_redis();

        delAllCache();
        $list_keys = $redis->KEYS('*');
        echo '<pre>'; print_r($list_keys); echo '</pre>';
    }

    public function list_cache(){
        $this->load->helper('redis');
        $redis = creat_redis();
        $list_keys = $redis->KEYS('*');

        for ($i = 0; $i < count($list_keys); $i++) {
            $mono = $list_keys[$i];
            echo '<h3>'.$i.'. '. $mono .'</h3>';
            $val = $redis->GET($mono);
            var_dump($val);
            $val_live = unserialize($val);
//            echo '<pre>'; print_r($val_live); echo '</pre>';

        }
    }

    
}
