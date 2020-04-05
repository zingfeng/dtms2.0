<?php
/**
 * Created by PhpStorm.
 * User: Zingfeng-Dragon
 * Date: 18/5/2018
 * Time: 8:53 AM
 */

/*
 * @return \Predis\Client
 */

function creat_redis(){

    if ( isset($redis_wb)== false) // Trước khi sử dụng redis, thêm hàm này vào
    {
        require_once('autoload.php');
        Predis\Autoloader::register();

        $redis_wb = new Predis\Client(array(
            'scheme' => 'unix', 
            'path' => '/home/alandedu/.applicationmanager/redis.sock'
        ));


        // $redis_wb = new Predis\Client(array(
        //     'scheme' => 'tcp',
        //     'host'   => '192.168.1.2',
        //     'port'   => 6379,
        // ));
    }

    return $redis_wb;

}
