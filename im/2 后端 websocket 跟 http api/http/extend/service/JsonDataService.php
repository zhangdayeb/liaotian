<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-06-06
 * Time: 15:31
 */
namespace extend\service;

class JsonDataService
{
    const FAIL = 1;
    const SUCESS = 0;


    //err
    public static function fail($msg = 'fail',$data = []){
        $arr['err'] = self::FAIL;
        $arr['msg'] = $msg;
        $arr['data'] = $data;
        if(is_array($msg)){
            $arr['msg'] = $msg['msg'];
            $arr['data'] = $msg['data'];
        }
        return $arr;
    }
    //fail
    public static function success($msg = 'success',$data = []){
        $arr['err'] = self::SUCESS;
        $arr['msg'] = $msg;
        $arr['data'] = $data;
        if(is_array($msg)){
            $arr['msg'] = $msg['msg'];
            $arr['data'] = $msg['data'];
        }
        return $arr;
    }

    public static function checkRes(array $res){
        if(!isset($res['err']) || $res['err'] !== 0){
            return false;
        }
        return true;
    }

    public static function fastClick($unique){
        $flat = RedisService::setnx(ConfigService::NALMAL_FAST_SEND_KEY.$unique,1,5);
        if(!$flat) return self::fail('您点击太快啦');
        return self::success();
    }
}