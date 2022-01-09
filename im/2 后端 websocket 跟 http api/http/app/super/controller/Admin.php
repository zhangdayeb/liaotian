<?php

namespace app\super\controller;

use think\Controller;
use app\im\model\mysql\User;
use app\super\model\Admin as Model_Admin;
use think\facade\Request;

const PAGE_RECORDS = 15;

class Admin extends Controller
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
            }*/
            if($key['key'])
            {
                $val = (String) $key['key'];
                $where[] = ['username','=',$val];
                $where1[] = ['phone','=',$val];
            }
        }
       
        $adminArr =  Model_Admin::where($where)
         ->whereOr($where1)->order('id', 'desc')->paginate(PAGE_RECORDS);
       
        $list = array();
        foreach($adminArr as $key => $val){
          
            array_push($list,$val);
        }
  
        $this->assign('adminlist',  $adminArr);
        $this->assign('list',  $list);
        $this->assign('key',$key);
        return $this->fetch();
       
       
    }

}