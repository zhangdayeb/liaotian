<?php
/**
 * Created by PhpStorm.
 * User: 38339
 * Date: 2021-05-21
 * Time: 17:33
 */

namespace app\common\validate;


use think\Validate;

class CommonRole extends Validate
{

    protected $rule = [
        'name'  =>  'require',
    ];

    protected $message  =   [
        'name.require' => '请输入角色名称',
    ];

    protected $scene = [
        'edit'  =>  ['name','id'],
        'add'  => ['name'],
    ];

}