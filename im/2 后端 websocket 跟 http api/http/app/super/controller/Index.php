<?php

namespace app\super\controller;

use think\Controller;

class Index extends Controller
{
    public function initialize()
    {
        $super_id = session('super_id');
        if(!$super_id)
        {
            $this->error('====抱歉，您还没有登录，请先登录===');
        }
    }
    public function index()
    {
        return view();
    }

    public function welcome()
    {
        return view();
    }
}