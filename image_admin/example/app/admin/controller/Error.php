<?php
namespace app\admin\controller;

use app\BaseController;

class Error
{

    public function __call($name, $arguments)
    {
        jsonFail('控制器不存在',-10);
    }
}
