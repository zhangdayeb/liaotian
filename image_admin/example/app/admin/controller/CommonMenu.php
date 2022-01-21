<?php
namespace app\admin\controller;

use app\BaseController;
use app\common\model\mysql\CommonAuth;
use app\common\model\mysql\CommonLog;
use app\common\model\mysql\CommonMenu as models;
use app\common\validate\CommonMenu as ValidateModel;
use app\common\model\mysql\CommonAdmin;
use think\facade\Log;
use think\exception\ValidateException;

class CommonMenu extends BaseController
{


    public function initialize()
    {
    }

    public function list(){
        $fildes = 'page,word';
        $receiveData = getData($this->request->post(),$fildes);
        $where = [];
        if(!empty($receiveData['word'])){
            $where[] = ['title|path','like','%'.$receiveData['word'].'%'];
        }
        $query = models::where($where);
        $count = $query->count();
        $limit_start = ($receiveData['page']-1) * env('page_size');
        $lists = $query->order('order_num','desc')->limit($limit_start,env('page_size'))->select();
        $data = [
            'lists' => models::fillModels($lists),
            'allpage' => getAllPage($count)
        ];
        jsonSuccess($data);
    }

    /*
     * 所有数据
     */
    public function listAll(){
        $fildes = 'token';
        $receiveData = getData($this->request->post(),$fildes);
        //校验token
        $admin = CommonAdmin::checkToken($receiveData['token']);
        if ($admin['role_id'] == 1) {
            $list = $this->vipMenu();//超级管理员
        } else {
            $list = $this->selectMenu($admin['role_id']);
        }
        jsonSuccess($list);
    }

    public function vipMenu()
    {
        //查询可访问的菜单
        $list = models::where(['parent_id' => 0, 'status' => 1,'is_load'=>1])->order('order_num desc')->paginate()->each(function ($item, $key) {
            $item->children = models::where(['parent_id' => $item['id'], 'status' => 1,'is_load'=>1])->select();
        });
        return $list;
    }


    public function selectMenu($role_id)
    {
        //查询可访问的菜单
        $menu = CommonAuth::where(['role_id'=>$role_id])->find();
        Log::write('权限数据:'.json_encode($menu));
        if(empty($menu)){
            return [];
        }
        $list = models::where(['parent_id' => 0, 'status' => 1,'is_load'=>1])->whereIn('id', $menu['menu_select_ids'])->order('order_num desc')->paginate()->each(function ($item, $key) use ($menu) {
            $item->children = models::where(['parent_id' => $item['id'], 'status' => 1,'is_load'=>1])->whereIn('id', $menu['menu_select_ids'])->order('order_num desc')->select();
        });
        return $list;
    }

    /*
     * 修改和编辑
     */
    public function edit(){
        $fildes = "id,title,path,status,parent_id,order_num,token";
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
        $parent_id = empty($receiveData['parent_id']) ? 0 : $receiveData['parent_id'];
        $data = [
            'title' => $receiveData['title'],
            'path' => empty($receiveData['path']) ? '' : $receiveData['path'],
            'status' => $receiveData['status'] == 1 ? 1 : 2,
            'parent_id' => empty($receiveData['parent_id']) ? 0 : $receiveData['parent_id'],
            'order_num' => $receiveData['order_num'] > 0 ?: 0
        ];
        $load = models::where(['title'=>$receiveData['title'],'parent_id'=>$parent_id])->find();
        if(!empty($receiveData['id'])){
            if(!empty($load) && $load['id'] != $receiveData['id']){
                jsonFail('已存在相同菜单名称');
            }
            $load = models::where(['id'=>$receiveData['id']])->find();
            models::where(['id'=>$receiveData['id']])->update($data);
            //写入日志
            CommonLog::insertLog($admin['id'],'/menu/edit',$load,$data,2);
        }else{
            if(!empty($load)){
                jsonFail('已存在相同菜单名称');
            }
            $data['create_time'] = date('Y-m-d H:i:s');
            models::insert($data);
            //写入日志
            CommonLog::insertLog($admin['id'],'/menu/edit','',$data,1);
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
            jsonFail('删除的菜单不存在');
        }
        if($load['is_load'] == 0){
            jsonFail('该菜单不可删除');
        }
        models::where(['id'=>$receiveData['id']])->delete();
        //写入日志
        CommonLog::insertLog($admin['id'],'/menu/delete',$load,'',3);
        jsonSuccess();
    }

    public function parentList(){
        $lists = models::field('id,title')->where(['parent_id'=>0])->select();
        $data = [
            'lists' => $lists
        ];
        jsonSuccess($data);
    }

}
