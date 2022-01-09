<?php

namespace app\super\controller;

use think\Controller;
use think\facade\Request;
use Yzm\ValidateCode;
use app\super\model\BsysSuperuser;

class Login extends Controller
{
    public function loginPage()
    {
        return view();
    }

    public function yzmimg()
    {
        $yzm = new ValidateCode();
        $yzm -> doimg();
        session('yzm_save',$yzm->getCode());
    }

    /**
     * 后台超级用户退出页面
     *
     * @return void
     */
    public function signout(){
         // 清除会话数据wipe out session data
         session_unset();
         // 销毁会话destroy session
        // 删除（当前作用域）
        session('super_id',null);
        session('super_name',null);
         header('Location: /admin_login');
         exit();
    }
  

    /**
     * 后台超级用户修改密码页面
     *
     * @return void
     */
    public function changepass(){
       

        $this->assign('super_id',session('super_id'));  
        $this->assign('super_name', session('super_name'));
       return $this->fetch();
        
    }


    /**
     * 后台超级用户保修密码页面
     *
     * @return void
     */
    public function updatepass(){
        $post_data = Request::post();
        
        $update = [];
        $return_data = [
           'err' => 1,
           'msg' => 'fail',
          
         ];
         if (!preg_match("/^\w{1,20}$/", $post_data['password'])) {
			$return_data['msg'] = '密码只能包括下划线、数字、字母,长度6-20位';
			return $return_data;
        }
        if($post_data['password']!==$post_data['repassword']){
            $return_data['msg'] = '密码只能包括下划线、数字、字母,长度6-20位';
			return $return_data;
        }

        $update = ['password' => md5($post_data['password'])];
        $super = new BsysSuperuser();
      
        if($super->where('id',$post_data['super_id'])->update( $update )){
           $return_data['err'] = 0;
           $return_data['msg'] = '数据修改成功！';
        }
         return   $return_data;
    }


    public function loginAction()
    {
        $post = Request::param();
        if(!$post['login_name'])
        {
            return ['status'=>false,'msg'=>'管理员账号不能为空'];
        }
        if(!$post['password'])
        {
            return ['status'=>false,'msg'=>'管理员密码不能为空'];
        }
//        if(!$post['yzm'])
//        {
//            return ['status'=>false,'msg'=>'验证码不能为空'];
//        }
//        $check_yzm = session('yzm_save');
//        if($check_yzm != $post['yzm'])
//        {
//            return ['status'=>false,'msg'=>'您输入的验证码不正确'];
//        }
        $super = new BsysSuperuser();
        $superInfo = $super->where('login_name',$post['login_name'])->find();
        if($superInfo)
        {
            if($superInfo['password'] == md5($post['password']))
            {
                session('super_id',$superInfo['id']);
                session('super_name',$superInfo['login_name']);
            
                return ['status'=>true,'msg'=>'登录成功'];
            }
            else
            {
                return ['status'=>false,'msg'=>'您的密码不正确'];
            }
        }
        else
        {
            return ['status'=>false,'msg'=>'管理员不存在，请核对账号'];
        }
    }
}