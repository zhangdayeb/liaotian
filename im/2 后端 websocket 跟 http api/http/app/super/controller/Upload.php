<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020/9/6 0006
 * Time: 11:15
 */

namespace app\super\controller;


use extend\service\JsonDataService;
use extend\service\UploadService;
use think\facade\Request;

class Upload
{
    public function uploadOne(){
        UploadService::upload(Request::post());
    }
}