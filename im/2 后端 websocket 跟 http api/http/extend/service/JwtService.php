<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020/9/9 0009
 * Time: 15:19
 */

namespace extend\service;


use \app\common\controller\Jwt;
use \app\common\model\mysql\System;

class JwtService
{
    public static function createToken($user_id)
    {
        $jwt = new Jwt;
        $db_data = System::where('key', 'JWT')->select()->toArray();
        Jwt::$key = $db_data[0]['value']['key']['value'];
        Jwt::$timeNum = $db_data[0]['value']['time']['value'];
        $payload = [
            'user_id' => $user_id,
        ];
        return $jwt->getToken($payload);
    }
}