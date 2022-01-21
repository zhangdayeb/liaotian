<?php
/**
 * Created by PhpStorm.
 * User: 38339
 * Date: 2021-05-26
 * Time: 14:58
 */

namespace app\common\business\mysql;
use app\common\model\mysql\CommonLog as Model;


class CommonLog
{

    /**
     * @param $admin_id 操作者ID
     * @param $action 操作action
     * @param $contentBefore 变更前数据
     * @param $contentLast 变更后数据
     * @param $type 操作类型[1新增2修改3删除]
     */
    public static function insertLog($admin_id,$action,$contentBefore,$contentLast,$type){
        $data = [
            'admin_id' => $admin_id,
            'ip' => get_server_ip(),
            'create_time' => date('Y-m-d H:i:s'),
            'action' => $action,
            'content' => json_encode([
                'before' => $contentBefore,
                'last' => $contentLast
            ]),
            'type' => $type

        ];
        Model::insert($data);
        return true;
    }

}