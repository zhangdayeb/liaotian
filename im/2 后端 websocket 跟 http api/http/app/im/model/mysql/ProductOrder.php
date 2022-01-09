<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-07-27
 * Time: 15:55
 */

namespace app\im\model\mysql;


use think\Model;

class ProductOrder extends Model
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

        $table = "\\app\im\\model\\".$params['type']."\\".$params['goods_relation_table'];
        return self::create([
            'goods_name'=>$params['goods_name'],
            'goods_desc'=>$params['goods_desc'] ?? $params['goods_name'],
            'goods_relation_table'=>$table,
            'goods_relation_id'=>$params['goods_relation_id'],
            'amount'=>$params['amount'],
            'pay_user_id'=>$params['user_id'],
            'merchart_user_id'=>$params['to_user_id'],
            'status'=>$params['status'] ?? 0,
            'order_id'=>$params['order_id'] ?? create_guid(),
            'username'=>$params['username'],
            'mobile'=>$params['mobile'],
            'address'=>$params['address'],
            'small_pic'=>$params['small_pic']
        ]);
    }
}