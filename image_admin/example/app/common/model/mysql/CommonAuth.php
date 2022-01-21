<?php
/**
 * Created by PhpStorm.
 * User: 38339
 * Date: 2021-05-21
 * Time: 16:49
 */

namespace app\common\model\mysql;
use think\Model;

class CommonAuth extends Model
{
    protected $name = 'common_auth';

    // 设置字段信息
    protected $schema = [
        'id'          => 'int',
        'role_id'        => 'int', //角色ID
        'is_no_delete'      => 'int',    //是否可删除[0 可以 1不可以]
        'route_ids'      => 'string',         //可操作路由(为空表示所有)
        'menu_ids'       => 'string',       //可操作菜单(为空表示所有)
        'create_time' => 'datetime',    //创建时间
        'menu_select_ids'=> 'string' //可操作菜单(仅用于权限加载)
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
        $data['role_id'] = $model['role_id'];
        $data['name'] = $model['name'];
        $data['create_time'] = $model['create_time'];
        $data['menu_ids'] = self::getMenuIdList($model['menu_ids']);
        return $data;
    }

    public static function getMenuIdList($menu_ids){
        if(empty($menu_ids)){
            return [];
        }
        $arr = explode(',',$menu_ids);
        $data = [];
        foreach ($arr as $item){
            $data[] = intval($item);
        }
        return $data;
    }

    /*
     * 获取保存的菜单
     */
    public static function getMenuIds($menuIdArr){
        if(count($menuIdArr) == 0){
            return '';
        }
        $where = [];
        $where[] = ['id','in',$menuIdArr];
        $where[] = ['parent_id','>',0];
        $lists = (new CommonMenu())->field('parent_id')->where($where)->group('parent_id')->select();
        if(count($lists) > 0){
            foreach ($lists as $item){
                $menuIdArr[] = intval($item['parent_id']);
            }
        }
        return implode(',',$menuIdArr);
    }

}