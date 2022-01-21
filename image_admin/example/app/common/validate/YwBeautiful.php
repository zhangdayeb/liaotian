<?php
/**
 * Created by PhpStorm.
 * User: 38339
 * Date: 2021-05-21
 * Time: 17:33
 */

namespace app\common\validate;


use think\Validate;

class YwBeautiful extends Validate
{

    protected $rule = [
        'city_id'  =>  'require',
        'image' => 'require',
        'name'  => 'require'
    ];

    protected $message  =   [
        'city_id.require' => '请选择城市',
        'image.require' => '请上传图片',
        'name.require' => '请输入名称'
    ];

    protected $scene = [
        'edit'  =>  ['city_id','image','name','id'],
        'add'  => ['city_id','image','name'],
    ];

}