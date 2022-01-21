<?php
/**
 * Created by PhpStorm.
 * User: 38339
 * Date: 2021-05-21
 * Time: 17:33
 */

namespace app\common\validate;


use think\Validate;

class CommonAdmin extends Validate
{

    protected $rule = [
        'username'  =>  'require|min:6',
        'password' =>  'require|min:6',
        'role_id' => 'number',
        'city_config_arr' => 'require',
        'mobile' => 'require'
    ];

    protected $message  =   [
        'username.require' => '请输入用户名',
        'username.min' => '用户名不能少于6位',
        'password.require'     => '请输入密码',
        'password.min'     => '密码不能少于6位',
        'role_id.number'   => '请选择角色',
        'city_config_arr.require'  => '请选择省市',
        'mobile.require'        => '请输入手机号',
    ];

    protected $scene = [
        'edit'  =>  ['username','role_id','city_config_arr','mobile','id'],
        'add'  => ['username','password','role_id','city_config_arr','mobile'],
    ];

}