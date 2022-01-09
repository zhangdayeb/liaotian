<?php

namespace app\super\controller;
use think\Db;
use think\Controller;
use app\im\model\mysql\User;
use app\super\model\LoginLog;
use think\facade\Request;

const PAGE_RECORDS = 15;

class Memberlog extends Controller
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
                $where1[] =  ['u.id','in','('.$userids.')'];
            }
        }
    
        $list = LoginLog::alias('l')
                ->leftJoin('txzh_user u', 'u.id = l.user_id ')
                ->field('l.*, u.nickname,u.username')
               // ->where('u.id > 0')
                ->where($where)
                ->whereOr($where1)->paginate(PAGE_RECORDS);
                

      // echo LoginLog::getLastSql();
        $this->assign('key',$key);
        $this->assign('list',  $list);
        return $this->fetch();
    }

    public function show()
    {
        $conf_id = Request::param('conf_id');
        $conf = User::where('id',$conf_id)->find();
        $this->assign('conf',$conf);
        return $this->fetch();
    }

}