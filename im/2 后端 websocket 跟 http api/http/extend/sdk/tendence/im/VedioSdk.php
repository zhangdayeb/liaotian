<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020/10/10 0010
 * Time: 16:25
 */

namespace extend\sdk\tendence\im;


use extend\service\JsonDataService;
use extend\video\TLSSigAPI;

class VedioSdk
{
    public static function getUsersig($user_id){
        $api = new TLSSigAPI();
        $vedio_appid = config('vedio_appid');
        $private = config('vedio_privatekey');
        $ttl = config('vedio_ttl');
        $api->SetAppid($vedio_appid);
        $api->SetPrivateKey($private);
        $userid = self::getSdkUserId($user_id);
        return $api->genSig($userid, $ttl);
    }



    /**
     * 获取SDK的用户ID
     * @param $user_id
     * @return string
     */
    public static function getSdkUserId($user_id){
        return clientOS() . '_trtc_' . $user_id;
    }
    /**
     * 加入语音房间
     * @param $user_id $roomid
     */
    public static function joinRoom($user_id,$roomid = 0 ){
        if(!$roomid) $user_id = $roomid;  //如果没有Roomid则创建房间
         $userid = self::getSdkUserId($user_id);
         $sign = self::getUsersig($user_id);
         return ['userid'=>$userid,'roomid'=>$roomid,'usersig'=>$sign];
    }
}