<?php

namespace app\super\controller;

use think\Controller;
use app\im\model\mongo\Chat;
use app\im\model\mysql\User;
use think\facade\Request;
const PAGE_RECORDS = 15;
class Chatlist extends Controller
{
    public function initialize()
    {
        $super_id = session('super_id');
        if(!$super_id)
        {
            $this->error('请先登录');
        }
    }

    public function index()
    {
        $post_data = Request::post();
        $key = Request::param();
        $where = [];
        $where1 = [];
        if(isset($key['act']) && $key['act'] == 'check')
        {
            if($key['start_time'] && !$key['end_time'])
            {
                $where[] = ['create_time','>=',strtotime($key['start_time'].' 00:00:00')];
            }
            else if(!$key['start_time'] && $key['end_time'])
            {
                $where[] = ['create_time','<=',strtotime($key['end_time'].' 23:59:59')];
            }
            else if($key['start_time'] && $key['end_time'])
            {
                if(strtotime($key['start_time'].' 00:00:00') < strtotime($key['end_time'].' 00:00:00'))
                {
                    $where[] = ['create_time','>=',strtotime($key['start_time'].' 00:00:00')];
                    $where[] = ['create_time','<=',strtotime($key['end_time'].' 23:59:59')];
                }
                else
                {
                    $where[] = ['create_time','>=',strtotime($key['end_time'].' 00:00:00')];
                    $where[] = ['create_time','<=',strtotime($key['start_time'].' 23:59:59')];
                }
            }
            $userids = User::getUserIdByNickname($key['key']);
            if($key['key'])
            {
                $where1[] =  ['u.id','in', $userids];
            }
        }
       
        $chatArr =  Chat::where('user_id','>',0)->order('time', 'desc')->paginate(PAGE_RECORDS);
     

        $list = array();
        foreach($chatArr as $key => $val){
            $user = User::getUserByUserId($val->user_id);
            if(empty($user)){
                unset($chatArr[$key]);
                continue;
            }
            $val->nickname = $user->nickname ;
            array_push($list,$val);
          
        }
        $this->assign('chatlist',  $chatArr);
        $this->assign('list',  $list);
        $this->assign('key',$key);
        return $this->fetch();
    }

    public function memberChatList()
    {
        $user_id = (int)Request::param('user_id');
        $parmas = Request::param();
        $where[] =  ['user_id','=',$user_id];
        $chatArr =  Chat::where('user_id','=', $user_id)->order('time', 'desc')->paginate(PAGE_RECORDS);
        $list = array();
        foreach($chatArr as $key => $val){
           // $user = User::getUserByUserId($val->user_id);
           // $val->nickname = $user->nickname ;
            array_push($list,$val);
          
        }
        $this->assign('chatlist',  $chatArr);
        $this->assign('list',  $list);
        $this->assign('user_id',$user_id);

        return $this->fetch();
     
    }

}