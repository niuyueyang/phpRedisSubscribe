<?php
/**
 * Created by PhpStorm.
 * User: niuyueyang
 * Date: 2019/4/1
 * Time: 15:06
 */
//发布者
$redis = new Redis();
$redis->connect('127.0.0.1',6379);
$res = $redis->publish('c1','hhh');
echo 'clents'.$res;
