<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-08-02
 * Time: 2:30
 */

namespace app\im\model\mysql;


use think\Model;

class Withdraw extends Model
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


}