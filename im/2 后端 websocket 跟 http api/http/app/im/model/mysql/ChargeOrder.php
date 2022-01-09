<?php

namespace app\im\model\mysql;
use think\Model;

class ChargeOrder extends Model
{
    /** 设置数据库配置 */
    protected $connection = 'mysql';
    /** 自动完成 */
    protected $auto = [];
    protected $insert = [];
    protected $update = [];
    /** 自动时间戳 */
    protected $autoWriteTimestamp = true;
    /** 关闭自动写入update_time字段 */
    protected $updateTime = true;

    protected static function init()
    {

    }

    public static function createOrder(array $params){
        return self::create([
            'user_id'=>$params['user_id'],
            'pay_type'=>$params['pay_type'],
            'amount'=>$params['amount'],
            'goods_name'=>$params['goods_name'],
            'goods_desc'=>isset($params['goods_desc']) ? $params['goods_desc'] : $params['goods_name'],
            'order_id'=>isset($params['order_id']) ? $params['order_id'] : create_guid(),
        ]);
    }

}
