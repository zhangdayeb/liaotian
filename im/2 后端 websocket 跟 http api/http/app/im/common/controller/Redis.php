<?php
namespace app\im\common\controller;

class Redis
{
    static $redis;
    static public function instance()
    {
        if (empty(self::$redis)) {
            $redis = new \Redis();
            $redis->connect('127.0.0.1', 6379);
            //$redis->auth('123456');
            self::$redis = $redis;
        }
        return self::$redis;
    }
}
