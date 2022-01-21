<?php
/**
 * Created by PhpStorm.
 * User: 38339
 * Date: 2021-05-21
 * Time: 16:49
 */

namespace app\common\model\mysql;
use think\Model;

class YwVideoType extends Model
{
    protected $name = 'yw_video_type';

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
        $data['status'] = (string)$model['status'];
        $data['update_time'] = $model['update_time'];
        $data['create_time'] = $model['create_time'];
        $data['name'] = $model['name'];
        $data['order_num'] = $model['order_num'];
        $data['remark'] = $model['remark'];
        return $data;
    }

}