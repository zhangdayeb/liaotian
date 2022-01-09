<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-06-29
 * Time: 10:04
 */

namespace app\im\controller;
use extend\service\UserService;
use \Request;

class User
{
    public function checkBeforePay(){
        $post_data = Request::post(); //user_id
        $res = UserService::checkBeforePay([
            'amount'=>$post_data['amount'],
            'user_id'=>USER_ID
        ]);
        return json($res);
    }

    /**
     * 设置交易密码
     */
    public function setUserTradePassword(){
        $post_data = Request::post(); //user_id
        $res = UserService::setUserTradePassword(array_merge(['user_id'=>USER_ID],$post_data));
        return json($res);
    }

    public function checkUserTradePassword(){
        $post_data = Request::post(); //user_id
        $res = UserService::checkUserTradePassword(array_merge(['user_id'=>USER_ID],$post_data));
        return json($res);
    }

    public function payAmount(){
        $post_data = Request::post(); //user_id
        $res = UserService::payAmount(array_merge(['user_id'=>USER_ID],$post_data));
        return json($res);
    }

    public function collectAmount(){
        $post_data = Request::post(); //user_id
        $res = UserService::collectAmount(array_merge(['user_id'=>USER_ID],$post_data));
        return json($res);
    }

}