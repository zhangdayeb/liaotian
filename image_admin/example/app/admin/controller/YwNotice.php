<?php
namespace app\admin\controller;

use app\BaseController;
use app\common\model\mysql\YwNotice as models;
use app\common\model\mysql\CommonAdmin as commonModels;
use app\common\model\mysql\CommonLog;

class YwNotice extends BaseController
{

    public function initialize()
    {
    }

    /*
     * 所有数组
     */
    public function list(){
        $where = [];
        $query = models::where($where);
        $count = $query->count();
        $lists = $query->order('id','desc')->select();
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
        $fildes = "token,id,title,detail";
        $receiveData = getData($this->request->post(),$fildes);
        //校验token
        $admin = commonModels::checkToken($receiveData['token']);
        if(empty($receiveData['title'])){
            jsonFail('请输入标题');
        }
        $data = [
            'title' => $receiveData['title'],
            'detail'  => $receiveData['detail'],
        ];
        if(!empty($receiveData['id'])){
            models::where(['id'=>$receiveData['id']])->update($data);
            //写入日志
            CommonLog::insertLog($admin['id'],'/yw-notice/edit','',$data,2);
        }else{
            models::insert($data);
            //写入日志
            CommonLog::insertLog($admin['id'],'/yw-notice/edit','',$data,1);
        }
        jsonSuccess();
    }

}
