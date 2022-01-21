<?php
/**
 * Created by PhpStorm.
 * User: 38339
 * Date: 2021-05-21
 * Time: 16:49
 */

namespace app\common\model\mysql;
use think\Model;

class CommonMenu extends Model
{
    protected $name = 'common_menu';

    // 设置字段信息
    protected $schema = [
        'id'          => 'int',
        'title'        => 'string', //菜单名称
        'path'      => 'string',    //路径
        'status'      => 'int',         //状态 1显示  2隐藏
        'parent_id'       => 'int',       //父级ID
        'create_time' => 'datetime',    //创建时间
        'order_num' => 'int',      //排序值
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
        $data['title'] = $model['title'];
        $data['status'] = (string)$model['status'];
        $data['create_time'] = $model['create_time'];
        $data['path'] = $model['path'];
        $data['parent_id'] = $model['parent_id'];
        $data['parent_title'] = self::where(['id'=>$model['parent_id']])->value('title');
        $data['order_num'] = $model['order_num'];
        return $data;
    }
}