<?php
/**
 * Created by PhpStorm.
 * User: 38339
 * Date: 2021-05-21
 * Time: 17:33
 */

namespace app\common\validate;


use think\Validate;

class YwVideo extends Validate
{

    protected $rule = [
        'video_type_id'  =>  'require',
        'image' => 'require',
        'name'  => 'require',
    ];

    protected $message  =   [
        'video_type_id.require' => '请选择分类',
        'image.require' => '请上传图片',
        'name.require' => '请输入名称',
    ];

    protected $scene = [
        'edit'  =>  ['video_type_id','image','name','id'],
        'add'  => ['video_type_id','image','name'],
    ];

}