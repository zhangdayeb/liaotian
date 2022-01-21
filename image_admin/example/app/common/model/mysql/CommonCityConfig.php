<?php
/**
 * Created by PhpStorm.
 * User: 38339
 * Date: 2021-05-21
 * Time: 16:49
 */

namespace app\common\model\mysql;
use think\Model;

class CommonCityConfig extends Model
{
    protected $name = 'common_city_config';

    // 设置字段信息
    protected $schema = [
        'id'          => 'int',
        'name'        => 'string', //省市名称
        'parent_id'      => 'int', //父级ID
    ];

    /**
     * @param $models
     * @return array
     */
    public static function fillModelParents($models)
    {
        $list = [];
        foreach ($models as $model) {
            $listItem = static::fillModelParent($model);
            $list[] = $listItem;
        }
        return $list;
    }

    public static function fillModelParent($model)
    {

        $data = [];
        $data['value'] = $model['id'];
        $data['label'] = $model['name'];
        $childrenList = self::where(['parent_id'=>$model['id']])->select();
        if(count($childrenList) > 0){
            $data['children'] = static::fillModelParents($childrenList);
        }
        return $data;
    }

}