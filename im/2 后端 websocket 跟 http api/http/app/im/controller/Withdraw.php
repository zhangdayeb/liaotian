<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-08-02
 * Time: 2:01
 */

namespace app\im\controller;


use extend\service\SystemService;
use extend\service\UserService;
use think\facade\Request;

class Withdraw
{
    //获取提现配置
    public function getWithDrawConfig(){
        $ret = SystemService::getBaseConfig();
        return json($ret);
    }

    /**
     * 提现
     */
    public function withDrawMoney(){
        $post_data = Request::post();
        $ret = UserService::withDrawMoney(array_merge($post_data,['user_id'=>USER_ID]));
        return json($ret);
    }
}