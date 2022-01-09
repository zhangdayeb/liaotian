<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-07-25
 * Time: 17:53
 */

namespace app\im\controller;


use extend\service\PayMentService;
use think\facade\Request;

class Pay
{
    public function userCharge()
    {
        $post_data = Request::post(); //user_id
        $ret = PayMentService::userCharge(array_merge($post_data, ['user_id' => USER_ID]));
        return json($ret);
    }

    /**
     *支付朋友圈商品
     */
    public function payCircleOrder()
    {
        $post_data = Request::post(); //user_id
        $ret = PayMentService::payCircleOrder(array_merge($post_data, ['user_id' => USER_ID]));
        return json($ret);
    }

    public function payVideoAamount(){
        $post_data = Request::post(); //user_id
        $ret = PayMentService::afterCallVideo(array_merge($post_data, ['user_id' => USER_ID]));
        return json($ret);
    }
}