<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-07-01
 * Time: 21:42
 */

namespace app\im\model\mysql;


use think\Model;

class UserContact extends Model
{
    /** 设置数据库配置 */
    protected $connection = 'mysql';
    /** 自动完成 */
    protected $auto = [];
    protected $insert = [];
    protected $update = [];
    /** 自动时间戳 */
    protected $autoWriteTimestamp = true;

    protected static function init()
    {

    }

    public function getCreateTimeAttr($val){
        return date('Y-m-d H:i:s',$val);
    }

}