<?php
namespace app\admin\controller;

use app\BaseController;
use app\common\model\mysql\CommonAdmin as models;
use app\common\model\mysql\CommonRole;
use app\common\model\mysql\CommonLog;
use think\captcha\facade\Captcha;
use think\facade\Log;

class Login extends BaseController
{

    public function initialize()
    {
    }

    /*
     * 后台登录
     */
    public function login(){
        $fildes = 'username,password';
        $receiveData = getData($this->request->post(),$fildes);
        if(empty($receiveData['username']) || empty($receiveData['password'])){
            jsonFail('用户名,密码不能为空');
        }
        /*if(!captcha_check($receiveData['code'])){
            jsonFail('验证码不正确'.$receiveData['code']);
        }*/
        $load = models::where(['username'=>$receiveData['username'],'password'=>pwdMd5($receiveData['password'])])->find();
        if(empty($load)){
            jsonFail('用户名或密码错误');
        }
        if($load['status'] != 1){
            jsonFail('该用户已禁用');
        }
        $token = api_token($load['id']);
        models::where(['id'=>$load['id']])->update(['token'=>$token,'token_flush_at'=>date('Y-m-d H:i:s')]);
        $data = [
            'token' => $token
        ];
        //写入日志
        CommonLog::insertLog($load['id'],'/login/login',$load,'',4);
        jsonSuccess($data);
    }

    /*
     * 加载登录人信息
     */
    public function loadAdmin(){
        $fildes = 'token';
        $receiveData = getData($this->request->post(),$fildes);
        $load = models::where(['token'=>$receiveData['token']])->find();
        if(empty($load)){
            jsonFail('请重新登录',10);
        }
        $role = CommonRole::where(['id'=>$load['role_id']])->find();
        $lists = [];
        $item = [
            'user_name' => $load['username'],
            'role_name' => $role['name'],
            'login_at' => date('Y-m-d H:i:s')
        ];
        $lists[] = $item;
        $data = [
            'lists' => $lists
        ];
        jsonSuccess($data);
    }

    public function captcha(){
        return Captcha::create();
    }

}
