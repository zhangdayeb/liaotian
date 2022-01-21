<?php
namespace app\admin\controller;

use app\BaseController;
use app\common\model\mysql\CommonAdmin as models;
use app\common\model\mysql\CommonLog;
use app\common\validate\CommonAdmin as ValidateModel;
use think\exception\ValidateException;

class CommonAdmin extends BaseController
{

    public function initialize()
    {
    }

    /*
     * 所有数组
     */
    public function list(){
        $fildes = 'page,word';
        $receiveData = getData($this->request->post(),$fildes);
        $where = [];
        if(!empty($receiveData['word'])){
            $where[] = ['username|mobile','like','%'.$receiveData['word'].'%'];
        }
        $query = models::where($where);
        $count = $query->count();
        $limit_start = ($receiveData['page']-1) * env('page_size');
        $lists = $query->order('id','desc')->limit($limit_start,env('page_size'))->select();
        $data = [
            'lists' => models::fillModels($lists),
            'allpage' => getAllPage($count)
        ];
        jsonSuccess($data);
    }

    /*
     * 修改和编辑
     */
    public function edit(){
        $fildes = "id,username,password,role_id,remark,mobile,status,city_config_arr,token";
        $receiveData = getData($this->request->post(),$fildes);
        //校验token
        $admin = models::checkToken($receiveData['token']);
        try {
            if(!empty($receiveData['id'])){
                validate(ValidateModel::class)->scene('edit')->check($receiveData);
            }else{
                validate(ValidateModel::class)->scene('add')->check($receiveData);
            }
        } catch (ValidateException $e) {
            // 验证失败 输出错误信息
            jsonFail($e->getError());
        }
        $data = [
            'username' => $receiveData['username'],
            'city_config_arr' => json_encode($receiveData['city_config_arr']),
            'status' => $receiveData['status'] == 1 ? 1 : 2,
            'role_id' => $receiveData['role_id'],
            'city_config_id' => end($receiveData['city_config_arr']),
            'remark' => $receiveData['remark'],
            'mobile' => $receiveData['mobile'],
        ];
        $load = models::where(['username'=>$receiveData['username']])->find();
        if(!empty($receiveData['id'])){
            if(!empty($load) && $load['id'] != $receiveData['id']){
                jsonFail('已存在相同用户名');
            }
            $load = models::where(['id'=>$receiveData['id']])->find();
            if(!empty($receiveData['password'])){
                if(strlen($receiveData['password']) < 6){
                    jsonFail('密码不能少于6位');
                }
                $data['password'] = pwdMd5($receiveData['password']);
            }
            models::where(['id'=>$receiveData['id']])->update($data);
            //写入日志
            CommonLog::insertLog($admin['id'],'/admin/edit',$load,$data,2);
        }else{
            if(!empty($load)){
                jsonFail('已存在相同用户名');
            }
            $data['password'] = pwdMd5($receiveData['password']);
            $data['create_time'] = date('Y-m-d H:i:s');
            models::insert($data);
            //写入日志
            CommonLog::insertLog($admin['id'],'/admin/edit','',$data,1);
        }
        jsonSuccess();
    }

    public function delete(){
        $fildes = "id,token";
        $receiveData = getData($this->request->post(),$fildes);
        //校验token
        $admin = models::checkToken($receiveData['token']);
        $load = models::where(['id'=>$receiveData['id']])->find();
        if(empty($load)){
            jsonFail('删除的管理员不存在');
        }
        if($load['is_no_delete'] == 1){
            jsonFail('该管理员不可删除');
        }
        models::where(['id'=>$receiveData['id']])->delete();
        //写入日志
        CommonLog::insertLog($admin['id'],'/admin/delete',$load,'',3);
        jsonSuccess();
    }

}
