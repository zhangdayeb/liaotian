<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-08-28
 * Time: 10:32
 */

namespace app\im\model\mysql;


use think\Model;

class VendorUser extends Model
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
}