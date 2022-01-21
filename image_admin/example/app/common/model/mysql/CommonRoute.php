<?php
/**
 * Created by PhpStorm.
 * User: 38339
 * Date: 2021-05-21
 * Time: 16:49
 */

namespace app\common\model\mysql;
use think\Model;

class CommonRoute extends Model
{
    protected $name = 'common_route';

    // 设置字段信息
    protected $schema = [
        'id'          => 'int',
        'name'        => 'string', //路由名称
        'path'      => 'string',    //路径
        'create_time' => 'datetime',    //创建时间
    ];

}