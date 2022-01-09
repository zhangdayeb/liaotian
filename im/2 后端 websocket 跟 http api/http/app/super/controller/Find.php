<?php

namespace app\super\controller;

use think\Controller;
use app\im\model\mongo\Find as DB_Find;
use app\im\model\mysql\User;
//use app\super\model\BsysConfig;
use think\facade\Request;

const PAGE_RECORDS = 15;

class Find extends Controller
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
          if($key['key'])
          {
            //  $where[] =  ['appName','like','%'.$key['key'].'%'];
              $where1[] =  ['appName','=',$key['key']];
            //  $where1[] =  ['appName','=',$key['act']];
          }
      }else{
          $where[] =  ['appName','<>',''];
        
      }

     // echo "<pre>";
     // var_dump(  $where, $where1 );
     // echo "</pre>";
      $findArr =  DB_Find::where($where)
         ->whereOr($where1)->order('create_time', 'desc')->paginate(PAGE_RECORDS);
       
        $list = array();
        foreach($findArr as $key => $val){
           $namestr='';
           if($val['is_customer_service']){
               foreach($val['is_customer_service'] as $k =>$v){
                   $user = User::getUserByUserId($v);
                   $namestr .=$user['username'].',';
               }
           }
            $val->username = $namestr ;
            $val->is_customer_service = $val['is_customer_service'] ? implode(",", $val['is_customer_service']) : '';
            array_push($list,$val);
        }
        
        $this->assign('findlist',  $findArr);
        $this->assign('list',  $list);
        $this->assign('key',$key);
        return $this->fetch();
    }

    public function getAgentList()
    {
      $where[] =  ['agent_id','<>',''];
        $findArr =  DB_Find::where($where)->order('agent_id', 'desc')->paginate(1000);
        $list = array();
        foreach($findArr as $key => $val){
            array_push($list,$val);
        }
        return json(array('err' => 0,  'msg' => "数据获取成功！", 'data' =>   $list ));
    }

    public function addGame(){
          // $key = Request::param();
          $post_data = Request::post();
          $return_data = [
            'err' => 1,
            'msg' => 'error',
          ];
         // $find_id = md5(uniqid('JWT',true) . rand(1, 100000));
          $game_obj = DB_Find::create([
            'agent_id'  => $post_data['agent_id'],
            'appName' => $post_data['appName'],
            'url' => $post_data['url'],
            'port' => $post_data['port'],
            'status' => 0,
            'is_customer_service'=>[],
           // 'appIcon_url' => $post_data['appIcon_url'],
            'logo_url' => $post_data['logo_url'],
            'create_time' => time(),
          ]);

       /*
          $list = array();         
          $this->assign('list',  $post_data);
          echo "<pre>";
          var_dump( $post_data);
          echo "</pre>";
          return $this->fetch();
         */
         return json(array('err' => 0,  'msg' => "数据添加成功！", 'data' => $post_data));
        
    }

    public function updateGame(){
       $post_data = Request::post();
       $update = [];
       $return_data = [
          'err' => 1,
          'msg' => 'fail',
         
        ];
        
       $where =  ['_id' => $post_data['id'] ];
       $game_obj = DB_Find::where($where)->find();

      
       
      if( $game_obj){
            $update = [
            'agent_id'  => $post_data['agent_id'],
            'appName' => $post_data['appName'],
            'url' => $post_data['url'],
            'port' => $post_data['port'],
           // 'status' => $post_data['status'],
           'logo_url' => $post_data['logo_url'],
           // 'create_time' => time(),
            // 'update_time' => time(),
          ];
          if( DB_Find::where($where)->update( $update )){
             $return_data['err'] = 0;
             $return_data['msg'] = '数据修改成功！';
          }
         
      }
     
      return json($return_data);     
    }

    public function show()
    {
        $id = Request::param('id');
        $where =  ['_id' => $id ];
        $game_obj = DB_Find::where($where)->find();
        $return_data['err'] = 0;
        $return_data['msg'] = '获取数据成功！';
        $return_data['data'] = $game_obj;

        return $return_data;    
    }

    public function checkAgentId(){
        $post_data = Request::post();
        $agent_id =  $post_data['agent_id'];
      
        $return_data = [
          'err' => 1,
          'msg' => 'fail',
          
        ];

        $where =  ['agent_id' => $agent_id ];
        $game_obj = DB_Find::where($where)->find();
        if($game_obj){
          $return_data['err'] = 0;
          $return_data['msg'] = '获取数据成功！';
          $return_data['data'] = $game_obj;
        }
       

        return $return_data;    
    }

    /**
     * Undocumented function
     * 上传图片
     * @return void
     */
    public function imgupload() {//图片上传
        $file = request()->file('file');
        $info = $file->validate(['size' => 1024 * 1024 * 2, 'ext' => 'jpg,png,gif,jpeg,svg'])->move('uploads');
        if ($info) {
          // 成功上传后 获取上传信息
          $path = '/uploads/' . $info->getSaveName();
          return json(array('error' => 0, 'msg' => $path));
        } else {
          // 上传失败获取错误信息
          return json(array('error' => 1, 'msg' => $file->getError()));
        }
    }
  
    /**
     * Undocumented function
     *
     * @return void
     */
    public function changeGameStatus(){
       $post_data = Request::post();
       $return_data = [
        'err' => 1,
        'msg' => 'fail',
       ];
       $where =  ['_id' => $post_data['id'] ];
       $game_obj = DB_Find::where($where)->find();
      
       $num = 0;
       if($post_data['act']){
          $num = 1;
       }

       $update = [];
      if( $game_obj){
         //
          $update = ['status' => $num];
          if( DB_Find::where($where)->update( $update )){
             $return_data['err'] = 0;
             $return_data['msg'] = '数据修改成功！';
          }
         
      }
      return json($return_data);      
    }

    public function updateService(){
      $post_data = Request::post();
     
      $return_data = [
        'err' => 1,
        'msg' => 'fail',
      ];
      $where =  ['_id' => $post_data['id'] ];
      $game_obj = DB_Find::where($where)->find();
     
      $is_customer_service = $post_data['is_customer_service'];
      $agent_id =  $post_data['agent_id'];

      $update = [];
     if( $game_obj){
        //
         $update = ['is_customer_service' => $is_customer_service];
         if( DB_Find::where($where)->update( $update )){
            $return_data['err'] = 0;
            $return_data['msg'] = '数据修改成功！';
         }
        
     }
      return  $return_data;
    }

    public function gameDel(){
        $post_data = Request::post();
        $return_data = [
          'err' => 1,
          'msg' => 'fail',
        ];
        $where =  ['_id' => $post_data['id'] ];
        $game_obj = DB_Find::where($where)->delete();
        if($game_obj ){
          $return_data['err'] = 0;
          $return_data['msg'] = '数据删除成功！';
          $return_data['data'] = $game_obj;
       }

        return $return_data; 
    }
}