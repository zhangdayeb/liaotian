<?php
namespace app\admin\controller;

use app\BaseController;
use app\common\model\mysql\YwVideo as models;
use app\common\model\mysql\CommonAdmin as commonModels;
use app\common\model\mysql\CommonLog;
use app\common\validate\YwVideo as ValidateModel;
use think\exception\ValidateException;

class YwVideo extends BaseController
{

    /*
     * 所有数组
     */
    public function list(){
        $fildes = 'page,name,video_type_id';
        $receiveData = getData($this->request->post(),$fildes);
        $where = [];
        $where[] = ['status','in',[0,1]];
        if(!empty($receiveData['name'])){
            $where[] = ['name','like','%'.$receiveData['name'].'%'];
        }
        if(!empty($receiveData['video_type_id'])){
            $where[] = ['video_type_id','=',$receiveData['video_type_id']];
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
     * 修改和编辑
     */
    public function edit(){
        $fildes = "token,id,video_type_id,image,remark,name,type,status,order_num,video_path,video_url,rate";
        $receiveData = getData($this->request->post(),$fildes);
        //校验token
        $admin = commonModels::checkToken($receiveData['token']);
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
        if(empty($receiveData['type'])){
            jsonFail('请选择视频类型');
        }
        if($receiveData['type'] == 1 && empty($receiveData['video_url'])){
            jsonFail('请上传视频文件');
        }
        if($receiveData['type'] == 2 && empty($receiveData['video_path'])){
            jsonFail('请输入视频地址');
        }
        $data = [
            'video_type_id' => $receiveData['video_type_id'],
            'status' => $receiveData['status'] == 1 ? 1 : 2,
            'image' => getImage($receiveData['image']),
            'remark' => $receiveData['remark'],
            'order_num' => $receiveData['order_num'],
            'name'  => $receiveData['name'],
            'update_time' => date('Y-m-d H:i:s'),
            'video_path' => $receiveData['video_path'],
            'video_url' => getImageListElementToStr($receiveData['video_url']),
            'type' => $receiveData['type'],
            'rate' => $receiveData['rate']
        ];
        if(!empty($receiveData['id'])){
            models::where(['id'=>$receiveData['id']])->update($data);
            //写入日志
            CommonLog::insertLog($admin['id'],'/yw-video/edit','',$data,2);
        }else{
            $data['create_time'] = date('Y-m-d H:i:s');
            models::insert($data);
            //写入日志
            CommonLog::insertLog($admin['id'],'/yw-video/edit','',$data,1);
        }
        jsonSuccess();
    }

    public function delete(){
        $fildes = "id,token";
        $receiveData = getData($this->request->post(),$fildes);
        //校验token
        $admin = commonModels::checkToken($receiveData['token']);
        $where = [];
        $where[] = ['id','=',$receiveData['id']];
        $where[] = ['status','in',[0,1]];
        $load = models::where($where)->find();
        if(empty($load)){
            jsonFail('删除的数据不存在');
        }
        models::where(['id'=>$receiveData['id']])->update(['status'=>-1,'update_time'=>date('Y-m-d H:i:s')]);
        //写入日志
        CommonLog::insertLog($admin['id'],'/yw-video/delete',$load,'',3);
        jsonSuccess();
    }

}
