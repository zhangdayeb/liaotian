<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-07-15
 * Time: 22:35
 */

namespace extend\service;


use think\facade\Log;
use think\Queue;

class QueueService
{
    /**
     * 发送消息之后触发
     */
    public static function AfterSendMsg($params){
        //执行消息推送
        Queue::push(ConfigService::QUEUE_PUSH_TASK ,$params);
        $params['keywords'] = $params['content'];
        Log::info('relay_msg:'.print_r($params,true));
        if($params['type'] == 1)Queue::push(ConfigService::QUEUE_QUN_AUTO_REPLAY,$params);//群聊
    }

    /**
     * 登陆完成之后触发
     */
    public static function AfterLogin($params){
        Queue::push(ConfigService::QUEUE_ADD_FRIENDS_TASK ,$params);
    }

    /**
     * 红包发送抢完之后触发
     */
    public static function afterLeiHongbao($params){
        Queue::push(ConfigService::QUEUE_AFTER_LEIHONGBAO ,$params);
    }

    /**
     * 自动抢包
     */
    public static function autoPackage($params){
        //60秒抢包
        RedisService::setex(ConfigService::HONGBAO_AUTO_GET.$params['rid'],1,120);
        Log::info("秒抢....:".$params['rid']);
        Queue::push(ConfigService::QUEUE_HONGBAO_GET_AUTO ,$params);
    }
}