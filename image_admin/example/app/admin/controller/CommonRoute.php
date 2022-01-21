<?php
namespace app\admin\controller;

use app\BaseController;
use app\common\model\mysql\CommonRoute as models;
use app\common\validate\CommonRoute as ValidateModel;
use think\exception\ValidateException;
use app\common\model\mysql\CommonLog;
use app\common\model\mysql\CommonAdmin;

class CommonRoute extends BaseController
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
            $where[] = ['name|path','like','%'.$receiveData['word'].'%'];
        }
        $query = models::where($where);
        $count = $query->count();
        $limit_start = ($receiveData['page']-1) * env('page_size');
        $lists = $query->order('id','desc')->limit($limit_start,env('page_size'))->select();
        $data = [
            'lists' => $lists,
            'allpage' => getAllPage($count)
        ];
        jsonSuccess($data);
    }

    /*
     * 修改和编辑
     */
    public function edit(){
        $fildes = "id,name,path,token";
        $receiveData = getData($this->request->post(),$fildes);
        //校验token
        $admin = CommonAdmin::checkToken($receiveData['token']);
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
            'name' => $receiveData['name'],
            'path' => $receiveData['path'],
        ];
        $load = models::where(['name'=>$receiveData['name']])->find();
        if(!empty($receiveData['id'])){
            if(!empty($load) && $load['id'] != $receiveData['id']){
                jsonFail('已存在相同路由名称');
            }
            $load = models::where(['id'=>$receiveData['id']])->find();
            models::where(['id'=>$receiveData['id']])->update($data);
            //写入日志
            CommonLog::insertLog($admin['id'],'/route/edit',$load,$data,2);
        }else{
            if(!empty($load)){
                jsonFail('已存在相同路由名称');
            }
            $data['create_time'] = date('Y-m-d H:i:s');
            models::insert($data);
            //写入日志
            CommonLog::insertLog($admin['id'],'/route/edit','',$data,1);
        }
        jsonSuccess();
    }

    public function delete(){
        $fildes = "id,token";
        $receiveData = getData($this->request->post(),$fildes);
        //校验token
        $admin = CommonAdmin::checkToken($receiveData['token']);
        $load = models::where(['id'=>$receiveData['id']])->find();
        if(empty($load)){
            jsonFail('删除的路由不存在');
        }
        models::where(['id'=>$receiveData['id']])->delete();
        //写入日志
        CommonLog::insertLog($admin['id'],'/route/delete',$load,'',3);
        jsonSuccess();
    }

}
