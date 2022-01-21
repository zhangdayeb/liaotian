<?php
namespace app\admin\controller;

use app\BaseController;
use app\common\model\mysql\CommonAuth as models;
use app\common\validate\CommonAuth as ValidateModel;
use think\exception\ValidateException;
use app\common\model\mysql\CommonLog;
use app\common\model\mysql\CommonAdmin;

class CommonAuth extends BaseController
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
            $where[] = ['r.name','like','%'.$receiveData['word'].'%'];
        }
        $query = models::alias('a')->join('common_role r','a.role_id = r.id')->field('a.*,r.name')->where($where);
        $count = $query->count();
        $limit_start = ($receiveData['page']-1) * env('page_size');
        $lists = $query->order('a.id','desc')->limit($limit_start,env('page_size'))->select();
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
        $fildes = "id,role_id,menu_ids,route_ids,token";
        $receiveData = getData($this->request->post(),$fildes);
        //校验token
        $admin = CommonAdmin::checkToken($receiveData['token']);
        if(empty($receiveData['menu_ids'])){
            jsonFail('请选择当前角色可操作的菜单栏目');
        }
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
            'role_id' => $receiveData['role_id'],
            'menu_select_ids' => models::getMenuIds($receiveData['menu_ids']),
            'menu_ids' => count($receiveData['menu_ids']) > 0 ? implode(',',$receiveData['menu_ids']) : ''
        ];
        $load = models::where(['role_id'=>$receiveData['role_id']])->find();
        if(!empty($receiveData['id'])){
            if(!empty($load) && $load['id'] != $receiveData['id']){
                jsonFail('已存在相同角色权限');
            }
            $load = models::where(['id'=>$receiveData['id']])->find();
            models::where(['id'=>$receiveData['id']])->update($data);
            //写入日志
            CommonLog::insertLog($admin['id'],'/auth/edit',$load,$data,2);
        }else{
            if(!empty($load)){
                jsonFail('已存在相同角色权限');
            }
            $data['create_time'] = date('Y-m-d H:i:s');
            models::insert($data);
            //写入日志
            CommonLog::insertLog($admin['id'],'/auth/edit','',$data,1);
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
            jsonFail('删除的权限配置不存在');
        }
        if($load['is_no_delete'] == 1){
            jsonFail('该权限配置不可删除');
        }
        models::where(['id'=>$receiveData['id']])->delete();
        //写入日志
        CommonLog::insertLog($admin['id'],'/auth/delete',$load,'',3);
        jsonSuccess();
    }

}
