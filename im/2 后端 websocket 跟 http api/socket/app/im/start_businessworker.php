<?php

use \Workerman\Worker;
use \GatewayWorker\BusinessWorker;
require_once __DIR__ . '/./common/controller/Config.php';
use \common\controller\Config;

// 自动加载类
require_once __DIR__ . '/../../vendor/autoload.php';
// bussinessWorker 进程
$worker = new BusinessWorker();
// worker名称
$worker->name = 'ImWorder';
// bussinessWorker进程数量
$worker->count = 4;
// 服务注册地址
$worker->registerAddress = '127.0.0.1:' . Config::$registerPort;
// 如果不是在根目录启动，则运行runAll方法
if(!defined('GLOBAL_START'))
{
    Worker::runAll();
}