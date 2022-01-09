<?php
namespace app\im\common\controller;

use \app\common\controller\Jwt;
use app\common\controller\SendData;
use \app\common\model\mysql\System;
use \Request;
use GatewayClient\Gateway;

/**
 * 操作开始的钩子
 */
class ActionBegin1
{
    protected function _whiteList(){
        return [
            'In',
            'App',
            'Test',
//            'Remove',
        ];
    }
  public function run()
  {
    /** 如果不是登陆、注册、app等入口控制器，需要验证登陆状态 */
    if(!in_array(Request::controller(),$this->_whiteList())){
      $get_token = Request::post('_token') ?? Request::get('_token') ?? '';
      $db_data = System::where('key','JWT')->select()->toArray();
      Jwt::$key = $db_data[0]['value']['key']['value'];
      Jwt::$timeNum = $db_data[0]['value']['time']['value'];
      if(!$get_token || !($token = Jwt::verifyToken($get_token))){
        echo json_encode([
          'err' => 1,
          'msg' => 'token is error',
        ]);
        die;
      }
      /** 赋值user_id为一个常量 */
      define("USER_ID",($token['user_id'] * 1));
      /** 这里设置GatwayWork服务地址 */
      Gateway::$registerAddress = '45.153.129.26:1236';
    }
  }

}
