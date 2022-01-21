<?php
/**
 * Created by PhpStorm.
 * User: 38339
 * Date: 2021-05-21
 * Time: 16:49
 */

namespace app\common\model\mysql;
use think\Model;

class YwBeautiful extends Model
{
    protected $name = 'yw_beautiful';

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
        $data['image'] = fullurl($model['image']);
        $data['status'] = (string)$model['status'];
        $data['update_time'] = $model['update_time'];
        $data['remark'] = $model['remark'];
        $data['create_time'] = $model['create_time'];
        $data['name'] = $model['name'];
        $data['order_num'] = $model['order_num'];
        $data['city_id'] = $model['city_id'];
        $data['city_name'] = YwCity::where(['id'=>$model['city_id']])->value('name');
        return $data;
    }

    public static function fillModelHomes($models){
        $list = [];
        foreach ($models as $model) {
            $listItem = static::fillModelHome($model);
            $list[] = $listItem;
        }
        return $list;
    }

    public static function fillModelHome($model){
        $data = [];
        $data['id'] = $model['id'];
        $data['image'] = fullurl($model['image']);
        $data['name'] = $model['name'];
        return $data;
    }

}