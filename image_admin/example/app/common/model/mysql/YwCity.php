<?php
/**
 * Created by PhpStorm.
 * User: 38339
 * Date: 2021-05-21
 * Time: 16:49
 */

namespace app\common\model\mysql;
use think\Model;

class YwCity extends Model
{
    protected $name = 'yw_city';

    //处理数据模型
    public static function fillModels($models){
        $list = [];
        foreach ($models as $model) {
            $listItem = static::fillModel($model);
            $list[] = $listItem;
        }
        return $list;
    }

    public static function fillModel($model){
        $data = [];
        $data['id'] = $model['id'];
        $data['name'] = $model['name'];
        $data['status'] = (string)$model['status'];
        $data['update_time'] = $model['update_time'];
        $data['remark'] = $model['remark'];
        $data['create_time'] = $model['create_time'];
        $data['order_num'] = $model['order_num'];
        return $data;
    }

}