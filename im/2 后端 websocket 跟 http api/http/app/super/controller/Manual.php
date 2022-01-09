<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-08-01
 * Time: 4:29
 */

namespace app\super\controller;


use FormBuilder\Form;
use think\App;
use think\Controller;

class Manual extends Controller
{
    public function __construct(App $app = null)
    {

        parent::__construct($app);
        $this->assign('menu', ['财务操作', '提现管理']);

    }
    public function index(){
       return $this->fetch();
    }
}