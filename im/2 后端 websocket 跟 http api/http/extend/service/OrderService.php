<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-07-27
 * Time: 17:52
 */

namespace extend\service;


use app\im\controller\User;
use app\im\model\mysql\ProductOrder;

class OrderService
{
    /**
     * 获取订单列表
     */
    public static function getOrderList($params)
    {
        $user_id = $params['user_id'];
        $user = UserService::getUserInfo($user_id);
        if (empty($user)) return JsonDataService::fail('用户信息不存在!');
        $query = ProductOrder::where(function ($query) use ($params) {
            if($params['status'] == -1){
                $query->where(['pay_user_id' => $params['user_id']]);
                $query->whereOr(['merchart_user_id' => $params['user_id']]);
            }
            if($params['status'] == 1) $query->where(['pay_user_id' => $params['user_id']]);
            if($params['status'] == 2) $query->where(['merchart_user_id' => $params['user_id']]);
        });
        $order_list = $query->order('id', 'desc')->select();
//            ->paginate(10);
        //后面写下拉
        $order_list = $order_list->toArray();
        if ($order_list) {
            foreach ($order_list as &$v){
                $v['is_buyer'] = 1;
                if($v['merchart_user_id'] == $params['user_id'])$v['is_buyer'] = 0;
                $seller_user_info = UserService::getUserInfo($v['merchart_user_id']);
                $buyer_user_info = UserService::getUserInfo($v['pay_user_id']);
                $v['seller_face'] = $seller_user_info['face'];
                $v['buyer_face'] = $buyer_user_info['face'];
                $v['seller_username'] = $seller_user_info['username'];
                $v['buyer_username'] = $buyer_user_info['username'];
                $v['address'] = $v['address'] ?? '';
                $v['mobile'] = $v['mobile'] ?? '';
                $v['username'] = $v['username'] ?? '';
                $v['logistics_code'] = $v['logistics_code'] ?$v['logistics_code']:'';
                $v['status_msg'] = [1=>'待发货',2=>'已发货'][$v['logistics_status']];
            }
        }
        return JsonDataService::success('订单列表', ['is_page'=>0,'data'=>$order_list]);
    }

    /**
     * 修改订单状态
     * @param array $params
     * @return mixed
     * @throws \think\Exception
     * @throws \think\db\exception\PDOException
     * @throws \think\exception\PDOException
     */
    public static function updateOrderStatus(array $params){
        $order_detail = ProductOrder::get($params['id']);
        if(!$order_detail) return JsonDataService::fail('订单信息不存在!');
        if($order_detail['merchart_user_id'] != $params['user_id']) return JsonDataService::fail('该订单不属于您的订单,如有疑问请联系客服!');
        if($order_detail['logistics_status'] != 1) return JsonDataService::fail('该订单已发货');
        if($order_detail['status'] < 1) return JsonDataService::fail('订单状态异常，请联系客服');
        $ret = ProductOrder::where(['id'=>$params['id']])->update(['logistics_code'=>$params['logistics_code'],'logistics_status'=>2]);
        if($ret === false) return JsonDataService::fail('发货失败');
        return JsonDataService::success();
    }
}