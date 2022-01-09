<?php

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
//declare(ticks=1);

use \common\controller\Main;
use \common\controller\Jwt;
use \common\controller\checkData;
use \common\controller\SendData;
use \GatewayWorker\Lib\Gateway;
use \common\model\System;

/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events
{
    /**
     * 进程启动时触发
     */
    public static function onWorkerStart($worker)
    {
        Main::start($worker);
    }

    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     *
     * @param int $client_id 连接id
     */
    public static function onConnect($client_id)
    {
        //发送连接成功通知
        Main::connect($client_id);
    }

   /**
    * 当客户端发来消息时触发
    * @param int $client_id 连接id
    * @param mixed $message 具体消息
    */
   public static function onMessage($client_id, $data)
   {
       set_time_limit(0);
       ini_set('memory_limit', -1);
       /** 这里对数据进行安全过滤 */
        $data = checkData::postCheck($data);
        $data = json_decode($data,true);

        //print_r($data);
       echo "【收到客户端消息】".PHP_EOL;
       echo print_r($data,true).PHP_EOL;
        switch ($data['action']){
            case 'checkToken':
                $token = Jwt::verifyToken($data['data']);
                $token_err = $token ? 0 : 1;
                SendData::sendToClient($client_id,'checkToken',[ 'err'=> $token_err ]);
                if($token_err){
                    SendData::offline($client_id);
                } else {
                    Gateway::bindUid($client_id, $token['user_id']);
                }
                return;
            case 'ping':
                if(isset($data['data']) && !empty($data['data'])){
                    $token = Jwt::verifyToken($data['data']);
                    $token_err = $token ? 0 : 1;
                    if(!$token_err && $token['user_id'] && !SendData::isOnline($token['user_id'])){
                        Gateway::bindUid($client_id, $token['user_id']);
                    }
                }
                Gateway::sendToClient($client_id,json_encode($data,256));
                return;
            case 'offline':
                $token = Jwt::verifyToken($data['data']);
                Gateway::bindUid($client_id, $token['user_id']);
//                SendData::closeAtherClient($token['user_id'],$client_id);
        }
        /** 所有逻辑在tinkphp中，这里不再处理逻辑 */
//        Gateway::closeClient($client_id);
        return;

        /** 这里如果没有绑定uid就断开连接 */
        if(!Gateway::getUidByClientId($client_id)){
            SendData::sendToClient($client_id,'checkToken',[ 'err'=> 1 ]);
            Gateway::closeClient($client_id);
        }

        $runPath = explode('.', $data['action']);
        if(count($runPath) != 3){
            print_r('action error');
            return;
        }
        Main::index($client_id, [
            /** 模块 */
            'module' => $runPath[0],
            /** 控制器 */
            'controller' => $runPath[1],
            /** 方法 */
            'action' => $runPath[2],
            /** 连接发送来的数据 */
            'data' => $data['data']
        ]);
   }

   /**
    * 当用户断开连接时触发
    * @param int $client_id 连接id
    */
   public static function onClose($client_id)
   {
        Main::close($client_id);
   }

   /**
    * 进程结束的时候触发
    */
    public static function onWorkerStop($worker){
        Main::workerStop($worker);
    }
}
