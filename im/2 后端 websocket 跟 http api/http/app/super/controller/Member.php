<?php

namespace app\super\controller;

use app\im\model\mongo\Friend;
use app\im\model\mongo\UserState;
use app\im\model\mysql\CapitalLog;
use extend\service\AccountService;
use extend\service\JsonDataService;
use extend\service\MsgService;
use extend\service\UserService;
use extend\service\UtilService;
use FormBuilder\Form;
use think\App;
use think\Controller;
use app\im\model\mysql\User;
use app\super\model\BsysConfig;
use think\Exception;
use think\facade\Request;

const PAGE_RECORDS = 15;

class Member extends Controller
{
    public function __construct(App $app = null)
    {

        parent::__construct($app);
        $this->assign('menu', ['系统插件', '系统插件列表']);
        $this->assign('show_menu', 0);

    }
    public function initialize()
    {
        $super_id = session('super_id');
        if(!$super_id)
        {
            $this->error('请先登录');
        }
    }

    public function memberList()
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

              //  $where[] = ['username','=', $val];
              //  $where1[] = ['nickname','=',$val];
                $where[] = ['username','like','%'.$val.'%'];
                $where1[] = ['nickname','like','%'.$val.'%'];
            }
        }
        //获取注册会员
        $list = User::where(function ($q)use($where){
                    $q->where($where);
                })->where(function ($q1)use($where1){
                    $q1->whereOr($where1);
                })
            ->field('*,username as yuan_name')->order('id', 'desc')
            ->paginate(PAGE_RECORDS,false,[
                    'query'=>Request::param()
                ])->each(function ($v)use($key){
                    if(isset($key['key']) && $key['key'])
                    {
                        if(preg_match('/'.$key['key'].'/',$v['username']))
                        {
                            $v['username'] = preg_replace('/'.$key['key'].'/','<span style="color: red">'.$key['key'].'</span>',$v['username']);
                        }
                        if(preg_match('/'.$key['key'].'/',$v['nickname']))
                        {
                            $v['nickname'] = preg_replace('/'.$key['key'].'/','<span style="color: red">'.$key['key'].'</span>',$v['nickname']);
                        }
                    }
                    return $v;
                });

      //  $user_conf_servives = BsysConfig::where('table_name','user')->where('field_key','is_servives')->find();
  
        $this->assign('list',$list);
        $this->assign('key',$key);
       // $this->assign('user_servives',  explode(",", $user_conf_servives->field_val));
        return $this->fetch();
    }

    public function memberShow()
    {
        $user_id = Request::param('user_id');
        $user = User::where('id',$user_id)->find();
        $this->assign('user',$user);
        return view();
    }

    public function changeUserStatus()
    {
        $post = Request::param();
       $change = User::changeStatus($post['id'],$post['act']);
//        $change = BsysConfig::changeUserStatus($post['id'],$post['act']);
        return $change;
    }

    public function changeUserService()
    {
       $post = Request::post();
       $return_data = [
        'err' => 1,
        'msg' => 'fail',
       ];
       $where =  ['id' => $post['id'] ];
       $User_obj = User::where($where)->find();
      
       $is_customer_service = 0;
       if($post['act']){
          $is_customer_service = 1;
       }

       $update = [];
      if( $User_obj){
         //
          $q_permition = $post['q_status'] ?? 0;
          $update = ['is_customer_service' => $is_customer_service,'q_permition'=>$q_permition];
          if( User::where($where)->update( $update ) !== false){
             $return_data['err'] = 0;
             $return_data['msg'] = '数据修改成功！';
          }
         
      }
      //通知所有好友删除缓存
        $data =Friend::where(['user_id'=>$post['id'] * 1])->select()->toArray();
        if($data){
            foreach ($data as $v){
                UserState::where(['user_id'=>($v['user_id'] * 1)])->update(['customer_q_state'=>1]);
                if($post['id'] == $v['friend_id']) continue;
                MsgService::senNormalMsgToUid($v['friend_id'],'clearCicleData');
                $return_data['data'][]=$v['friend_id'];
            }
        }
       return $return_data;
    }

    public function memberByagent(){
        $post = Request::param(); 
        $return_data = [
            'err' => 1,
            'msg' => 'error',
          ];
        $agent_id=$post['agent_id'];
        $where[] = ['agent_id','=',$agent_id];
        $user = User::where($where)->where('is_customer_service',1)->select();
        if($user)
        {
            $return_data['err'] = 0;
            $return_data['msg'] = '数据修改成功！';
            $return_data['data'] = $user;
        }
        return $return_data;
    }

    public function getUserInfo(){
        $params = UtilService::getMore([
            ['key','']
        ]);
        $key = $params['key'];
        $user = User::where(['id|username'=>$key])->find();
        if(!$user)return json(JsonDataService::fail());
        $user = UserService::getUserInfo($user['id']);
        $user['face'] = '//'.$_SERVER['SERVER_NAME'].'/'.$user['face'];
        return json(JsonDataService::success('',$user));
    }

    /**
     * 更新账号余额
     */
    public function updateAmount(){
        $params = UtilService::getMore([
            ['key',''],
            ['amount',''],
            ['type',0],
            ['remark',''],
        ]);
        $key = $params['key'];
       $fast = UtilService::fastCick('USER_AMOUNT:'.$key);
       if($fast)return $fast;
        $user = User::where(['id|username'=>$key])->find();
        if(!$user)return json(JsonDataService::fail('会员账号不存在!'));
        if(!$params['amount'])return json(JsonDataService::fail('请输入金额!'));
        if(!$params['remark'])return json(JsonDataService::fail('请输入备注!'));
        $ret = AccountService::doMoney([
            'type'=>$params['type'],
            'remark'=>$params['remark'],
            'user_id'=>$user['id'],
            'capital_type'=>6,
            'amount'=>$params['amount'],
        ]);
        if(!JsonDataService::checkRes($ret))return json(JsonDataService::fail('操作失败!'));
        return json(JsonDataService::fail('操作成功!'));
    }

    /**
     * 设置机器人
     */
    public function setRebot(){
        $params = UtilService::getMore([
            ['id',0],
            ['act',0],
        ]);
        $user = UserService::getUserInfo($params['id']);
        if(empty($user))   return json(JsonDataService::fail('用户不存在!'));
        $ret = User::where(['id'=>$params['id']])->update(['is_robot'=>$params['act']]);
        if($ret !== false) return json(JsonDataService::success('操作成功!'));
        return json(JsonDataService::fail('操作失败!'));
    }

    /**
     * 重置用户密码页面
     */
    public function updateUserPassword(){
        $params = UtilService::getMore([
            ['user_id', ''],
        ]);
          $field = [
                      Form::input('password','请输入密码')->col(13)->info('请输入密码'),
                      Form::input('confirm_password','确认输入的密码')->col(13)->info('请输入密码')
                  ];
                  $form = Form::create('/super_saveUserPassword?user_id='.$params['user_id']);
                  $form->setMethod('post')->setTitle('修改密码')->components($field);
                  $this->assign(compact('form'));
                  return $this->fetch('public/form-builder');
    }

    /**
     * 重置用户密码页面
     */
    public function updateTradeUserPassword(){
        $params = UtilService::getMore([
            ['user_id', ''],
        ]);
        $field = [
            Form::input('trade_password','请输入密码')->col(13)->info('请输入密码'),
            Form::input('confirm_trade_password','确认输入的密码')->col(13)->info('请输入密码')
        ];
        $form = Form::create('/super_saveUserTradePassword?user_id='.$params['user_id']);
        $form->setMethod('post')->setTitle('修改密码')->components($field);
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }

    public function saveUserTradePassword(){
        $params = UtilService::getMore([
            ['user_id', ''],
            ['trade_password', ''],
            ['confirm_trade_password', ''],
        ]);
        $user = UserService::getUserInfo($params['user_id']);
        if(empty($user))  return json(JsonDataService::fail('用户信息不存在!'));
        if (!is_numeric($params['trade_password']) || mb_strlen($params['trade_password']) != 6) {
            return json(JsonDataService::fail('交易密码只能是6位数字'));
        }
        if($params['trade_password'] != $params['confirm_trade_password'])return json(JsonDataService::fail('两次密码输入不一致!!'));
        $ret  = User::where(['id'=>$params['user_id']])->update(['trade_password'=>create_password($params['trade_password'])]);
        if($ret !== false) return json(JsonDataService::success('修改成功!!'));
        return json(JsonDataService::fail('修改失败!!'));
    }

    public function saveUserPassword(){
        $params = UtilService::getMore([
            ['user_id', ''],
            ['password', ''],
            ['confirm_password', ''],
        ]);
        $user = UserService::getUserInfo($params['user_id']);
        if(empty($user))  return json(JsonDataService::fail('用户信息不存在!'));
        if (!preg_match("/^\w{1,20}$/", $params['password'])) {
            return json(JsonDataService::fail('密码只能包括下划线、数字、字母,长度6-20位!!'));
        }
        if($params['password'] != $params['confirm_password'])return json(JsonDataService::fail('两次密码输入不一致!!'));
        $ret  = User::where(['id'=>$params['user_id']])->update(['password'=>md5($params['password'])]);
        if($ret !== false) return json(JsonDataService::success('修改成功!!'));
        return json(JsonDataService::fail('修改失败!!'));
    }
}