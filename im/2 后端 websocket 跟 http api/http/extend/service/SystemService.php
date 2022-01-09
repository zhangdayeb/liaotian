<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-08-02
 * Time: 2:03
 */

namespace extend\service;


use app\super\model\BsysConfig;

class SystemService
{
  public static function getBaseConfig(){
        $config = BsysConfig::getAllVal('basic_config');
        return JsonDataService::success('config',$config);
  }
}