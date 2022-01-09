<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-07-07
 * Time: 18:02
 */

namespace app\im\controller;


use extend\service\AgentService;
use think\Controller;
use think\facade\Request;

class Agent extends Controller
{
    /**
     * 获取商家网址列表
     */
    public function getOnlineList(){
        $params = Request::param();
        $res = (new AgentService())->getOnlineList([
            'agent_id'=>$params['_agent_id']
        ]);
        return json($res);
    }
}