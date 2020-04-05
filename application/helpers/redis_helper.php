<?php 
require_once  APPPATH .'libraries/Predis/Zf_load_Predis.php';

function set_cache($key,$value,$expire = 0){

    $redis = creat_redis();
    $res = $redis->SET($key,$value);
    if ($expire != 0){
        $redis->EXPIRE($key,$expire);
    }
    return $res;
}

function get_cache($key){
    return null;
    $redis = creat_redis();
    $e = $redis->EXISTS($key);
    if ($e == 1){
        return $redis->GET($key);
    }else{
        return null;
    }
}

// hàm này check param có thuộc tính no-cache thì sẽ xóa cache và lấy cách mới
function select_cache($key,$params = array()){
    // return null;
    $redis = creat_redis();
    if (isset($params['no_cache']) && ($params['no_cache'] === true) ){
        $redis->DEL(array($key));
    }

    $e = $redis->EXISTS($key);
    if ($e == 1){

        return $redis->GET($key);
    }else{
        return null;
    }
}

function delAllCache(){
    $redis = creat_redis();
    $list_cache = $redis->KEYS('*');
    $redis->DEL($list_cache);
}

function run_limit($key_redis,$times_run,$live_time = 1200){
    $key_redis = '_run_limit_'.$key_redis;
    $redis = creat_redis();
    $e = $redis->EXISTS($key_redis);
    if ($e != 1){
        $redis->SET($key_redis,0);
        $redis->EXPIRE($key_redis,$live_time);
    }
    $number_now = (int) $redis->GET($key_redis);
    if ($number_now < $times_run){
        $redis->SET($key_redis,$number_now + 1);
        return true;
    }else{
        return false;
    }
}



?>