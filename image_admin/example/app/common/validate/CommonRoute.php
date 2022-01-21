<?php
/**
 * Created by PhpStorm.
 * User: 38339
 * Date: 2021-05-21
 * Time: 17:33
 */

namespace app\common\validate;


use think\Validate;

class CommonRoute extends Validate
{

    protected $rule = [
        'name'  =>  'require',
        'path'  => 'require'
    ];

    protected $message  =   [
        'name.require' => '请输入路由名称',
        'path.require'  => '请输入路径'
    ];

    protected $scene = [
        'edit'  =>  ['name','path','id'],
        'add'  => ['name','path'],
    ];

}