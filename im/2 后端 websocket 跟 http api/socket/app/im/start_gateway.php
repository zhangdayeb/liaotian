<?php

use \Workerman\Worker;
use \GatewayWorker\Gateway;
use \common\controller\Main;
require_once __DIR__ . '/./common/controller/Config.php';
use \common\controller\Config;

// 自动加载类
require_once __DIR__ . '/../../vendor/autoload.php';
$local_ip = '127.0.0.1';
// gateway 进程，这里使用Text协议，可以用telnet测试
$gateway = new Gateway('Websocket://0.0.0.0:' . Config::$gateWayPort);
// gateway名称，status方便查看
$gateway->name = 'Gatway';
// gateway进程数
$gateway->count = 4;
// 本机ip，分布式部署时使用内网ip
$gateway->lanIp = $local_ip;
// 内部通讯起始端口，假如$gateway->count=4，起始端口为4000
// 则一般会使用4000 4001 4002 4003 4个端口作为内部通讯端口
$gateway->startPort = 3900;
// 服务注册地址
$gateway->registerAddress = $local_ip . ':' . Config::$registerPort;
// 心跳间隔(s)
$gateway->pingInterval = 30;
// 心跳数据
$gateway->pingData = '{"type":"ping"}';
// 当客户端连接上来时，设置连接的onWebSocketConnect，即在websocket握手时的回调
$gateway->onConnect = function($connection)
{
    /** 这里设置发送数据给前台的是 arrayBuffer 数据 */
    //$connection->websocketType = Workerman\Protocols\Websocket::BINARY_TYPE_ARRAYBUFFER;

    /** 验证连接来源是否合法，不合法就关掉连接 */
    $connection->onWebSocketConnect = function($connection,$http_header){
        Main::checkConnect($connection,$http_header);
    };
};
// 如果不是在根目录启动，则运行runAll方法
if(!defined('GLOBAL_START'))
{
    Worker::runAll();
}
