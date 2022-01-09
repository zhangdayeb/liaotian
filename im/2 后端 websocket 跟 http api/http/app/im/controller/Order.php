<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-07-27
 * Time: 17:46
 */

namespace app\im\controller;


use extend\service\OrderService;
use think\facade\Request;

class Order
{
    /**
     * 获取用户订单列表
     */
    public function getUserOrderList(){
        return json(OrderService::getOrderList(array_merge(['user_id'=>USER_ID],Request::post())));
    }

    /**
     * 修改订单状态
     * @return \think\response\Json
     */
    public function updateOrderStatus(){
        return json(OrderService::updateOrderStatus(array_merge(['user_id'=>USER_ID],Request::post())));
    }
}
