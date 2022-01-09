<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020/10/16 0016
 * Time: 14:52
 */

namespace app\im\controller;


use extend\service\GroupService;
use think\facade\Request;

class Group
{
    /**
     * 销毁记录
     */
    public function xiaoHuiMessage(){
        return json(GroupService::xiaoHuiMessage(array_merge(Request::post(),['user_id'=>USER_ID])));
    }
}