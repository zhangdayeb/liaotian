<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-07-07
 * Time: 0:20
 */

namespace app\super\controller;


use app\im\model\mysql\UserContact;
use think\Controller;
use think\App;
use think\facade\Request;
use think\response\Json;

class Contact extends Controller
{
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->assign('menu',['手机通讯录','手机通讯录列表']);

    }
    /**
     *通讯录列表
     */
    public function contactList(){
        $params = Request::param();
        if(Request::isAjax()){
            $model = (new UserContact());
            $count = $model->count(1);
            $list = $model->page($params['page'],$params['limit'])->select();
            return json(['code'=>0,'data'=>$list->toArray(),'count'=>$count,'msg'=>'success']);
        }
        return view();
    }
}