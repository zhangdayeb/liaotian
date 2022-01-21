<?php
/**
 * Created by PhpStorm.
 * User: 38339
 * Date: 2021-05-21
 * Time: 16:49
 */

namespace app\common\model\mysql;
use think\Model;

class CommonAdmin extends Model
{
    protected $name = 'common_admin';

    // 设置字段信息
    protected $schema = [
        'id'                        => 'int',
        'username'                  => 'string', //用户名
        'password'                  => 'string',    //密码
        'status'                    => 'int',         //状态 1正常 2禁用
        'role_id'                   => 'int',       //角色ID
        'create_time'               => 'datetime',    //创建时间
        'city_config_id'            => 'int',      //省市ID
        'remark'        => 'string', //备注
        'mobile'        => 'string', //手机号
        'token'         => 'string', //token
        'token_flush_at' => 'datetime', //token刷新时间
        'is_no_delete' => 'int', //是否可删除[0 可以 1不可以]
        'city_config_arr' => 'string' //city_config_arr
    ];

    /**
     * @param $models
     * @return array
     */
    public static function fillModels($models)
    {
        $list = [];
        foreach ($models as $model) {
            $listItem = static::fillModel($model);
            $list[] = $listItem;
        }
        return $list;
    }

    public static function fillModel($model)
    {

        $data = [];
        $data['id'] = $model['id'];
        $data['username'] = $model['username'];
        $data['status'] = (string)$model['status'];
        $data['create_time'] = $model['create_time'];
        $data['role_id'] = $model['role_id'];
        $data['role_name'] = CommonRole::where(['id'=>$model['role_id']])->value('name');
        $data['city_config_id'] = $model['city_config_id'];
        $data['city_config_name'] = CommonCityConfig::where(['id'=>$model['city_config_id']])->value('name');
        $data['remark'] = $model['remark'];
        $data['mobile'] = $model['mobile'];
        $data['city_config_arr'] = checkCityConfigArr($model['city_config_arr']);
        return $data;
    }

    public static function checkToken($token){
        $admin = self::where(['token'=>$token])->find();
        if(empty($admin)){
            jsonFail('请重新登录',7);
        }
        if($admin['status'] != 1){
            jsonFail('该帐号已禁用',7);
        }
        return $admin;
    }

}