<?php
/**
 * Created by PhpStorm.
 * User: 38339
 * Date: 2021-05-21
 * Time: 16:49
 */

namespace app\common\model\mysql;
use think\Model;

class CommonLog extends Model
{
    protected $name = 'common_log';

    // 设置字段信息
    protected $schema = [
        'id'          => 'int', //日志管理
        'admin_id'        => 'int', //操作者
        'ip'      => 'string',    //操作IP
        'create_time' => 'datetime',    //操作时间
        'action'    => 'string', //操作action
        'content'   => 'string', //操作内容
        'type'      => 'int'  //type
    ];

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
        (new self())->insert($data);
        return true;
    }
}