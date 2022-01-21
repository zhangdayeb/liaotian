<?php
/**
 * Created by PhpStorm.
 * User: 38339
 * Date: 2021-05-21
 * Time: 17:33
 */

namespace app\common\validate;


use think\Validate;

class CommonAuth extends Validate
{

    protected $rule = [
        'role_id'  =>  'require|number',
    ];

    protected $message  =   [
        'role_id.require' => '请选择角色',
    ];

    protected $scene = [
        'edit'  =>  ['role_id','id'],
        'add'  => ['role_id'],
    ];

}