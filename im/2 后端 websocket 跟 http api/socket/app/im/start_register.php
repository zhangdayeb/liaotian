<?php

use \Workerman\Worker;
use \GatewayWorker\Register;
require_once __DIR__ . '/./common/controller/Config.php';
use \common\controller\Config;

// 自动加载类
require_once __DIR__ . '/../../vendor/autoload.php';
// register 必须是text协议
$register = new Register('text://0.0.0.0:' . Config::$registerPort);
// 如果不是在根目录启动，则运行runAll方法
if(!defined('GLOBAL_START'))
{
    Worker::runAll();
}