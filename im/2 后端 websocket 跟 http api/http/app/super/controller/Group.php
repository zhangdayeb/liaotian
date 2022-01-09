<?php

namespace app\super\controller;

use think\Controller;
use app\im\model\mysql\User;
use app\im\model\mongo\ChatGroup;
use think\facade\Request;

const PAGE_RECORDS = 15;

class Group extends Controller
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
            /*
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
           */
            //  $userids = User::getUserIdByNickname($key['key']);
           
            if($key['key'])
            {
                $val = (String) $key['key'];
               // $where[] =  ['name','like','%'.$val.'%'];
                $where[] = ['name','=',$val];
               //$where[] = ['name','like','%'.$key['key'].'%'];
               // $where1[] =  ['name','like','%'.$val.'%'];
            }
        
        }
       
       // $groupArr = ChatGroup::select();
      
        $groupArr =  ChatGroup::where($where)
                     ->whereOr($where1)->order('id', 'desc')
                     ->paginate(PAGE_RECORDS);
                      
        $list = array();

        $data = $groupArr->toArray();
        $data = $data['data'];
        foreach($data as $key => &$val){
            if(!$val['main_id'])continue;
            $user = User::getUserByUserId($val['main_id']);
            if(!$user)continue;
           // $friend = User::getUserByUserId($val->friend_id);
            $val['nickname'] = $user->nickname ;
           // $val->friend_nickname = $friend->nickname ;
            array_push($list,$val);
        }
        /* 
       echo "<pre>";
       var_dump($list);
       echo "</pre>";
    
      //  $user_conf_status = BsysConfig::where('table_name','user')
      //                            ->where('field_key','status')->find();
                                  

      //  $user_conf_servives = BsysConfig::where('table_name','user')
      //                            ->where('field_key','is_servives')->find();
      */    
        $this->assign('grouplist',  $groupArr);                   
        $this->assign('list',$list);
        $this->assign('key',$key);
      //  $this->assign('user_status', explode(",", $user_conf_status->field_val) );
      //  $this->assign('user_servives',  explode(",", $user_conf_servives->field_val));
        return $this->fetch();
       
    }

    public function memberShow()
    {
        $user_id = Request::param('user_id');
        $user = User::where('id',$user_id)->find();
        $this->assign('user',$user);
        return $this->fetch();
    }

    public function changeUserStatus()
    {
        $post = Request::param();
       // $change = User::changeStatus($post['id'],$post['act']);
        $change = BsysConfig::changeUserStatus($post['id'],$post['act']);
        return $change;
    }

    public function changeUserService()
    {
        $post = Request::param();
      //  $change = User::changeUserService($post['id'],$post['act']);
       $change = BsysConfig::changeUserService($post['id'],$post['act']);
        return $change;
    }
}