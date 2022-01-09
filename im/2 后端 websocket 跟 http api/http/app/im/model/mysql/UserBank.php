<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-07-01
 * Time: 21:42
 */

namespace app\im\model\mysql;


use think\Model;

class UserBank extends Model
{
    /** 设置数据库配置 */
    protected $connection = 'mysql';
    /** 自动完成 */
    protected $auto = [];
    protected $insert = [
    ];
    protected $update = [];
    /** 自动时间戳 */
    protected $autoWriteTimestamp = true;

    protected static function init()
    {

    }

    public function  getCreateTimeAttr($time){
        return date('Y-m-d H:i:s',$time);
    }

    public function  getUpdateTimeAttr($time){
        return date('Y-m-d H:i:s',$time);
    }

    public static function getBankName($val){
        switch (true){
            case $val==1:
                $bank_name = '支付宝';
                break;
            case $val==2:
                $bank_name = '微信';
                break;
            default:
                $bank_name = '支付宝';
        }
        return $bank_name;
    }
}