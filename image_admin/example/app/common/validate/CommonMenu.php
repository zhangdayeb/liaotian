<?php
/**
 * Created by PhpStorm.
 * User: 38339
 * Date: 2021-05-21
 * Time: 17:33
 */

namespace app\common\validate;


use think\Validate;

class CommonMenu extends Validate
{

    protected $rule = [
        'title'  =>  'require',
    ];

    protected $message  =   [
        'title.require' => '请输入菜单名称',
    ];

    protected $scene = [
        'edit'  =>  ['title','id'],
        'add'  => ['title'],
    ];

}