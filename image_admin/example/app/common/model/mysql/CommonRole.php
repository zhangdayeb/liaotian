<?php
/**
 * Created by PhpStorm.
 * User: 38339
 * Date: 2021-05-21
 * Time: 16:49
 */

namespace app\common\model\mysql;
use think\Model;

class CommonRole extends Model
{
    protected $name = 'common_role';

    // 设置字段信息
    protected $schema = [
        'id'          => 'int',
        'name'        => 'string', //角色名称
        'is_no_delete'      => 'int',    //是否可删除[0 可以 1不可以]
        'create_time' => 'datetime',    //创建时间
    ];
}