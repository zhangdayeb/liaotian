<?php
/**
 * Created by PhpStorm.
 * User: 38339
 * Date: 2021-05-21
 * Time: 16:49
 */

namespace app\common\model\mysql;
use think\Model;

class YwVideo extends Model
{
    protected $name = 'yw_video';

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
        $data['view_num'] = $model['view_num'];
        $data['video_path'] = $model['video_path'];
        $data['type'] = (string)$model['type'];
        $data['video_type_id'] = $model['video_type_id'];
        $data['video_type_name'] = YwVideoType::where(['id'=>$model['video_type_id']])->find()['name'];
        $data['video_url'] = fullurlList($model['video_url']);
        $data['rate'] = $model['rate'];
        return $data;
    }

    //处理数据模型
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
        if($model['type'] == 1){
            $data['video_path'] = fullurlList($model['video_url'])[0];
        }else{
            $data['video_path'] = $model['video_path'];
        }
        $data['rate'] = $model['rate'];
        return $data;
    }

}