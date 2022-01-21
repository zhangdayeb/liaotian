<?php
namespace app\api\controller;

use app\BaseController;
use app\common\model\mysql\YwBeautiful;
use app\common\model\mysql\YwCity;
use app\common\model\mysql\YwNotice;
use app\common\model\mysql\YwVideo;
use app\common\model\mysql\YwVideoType;

class Home extends BaseController
{

    /*
     * 获取城市列表
     */
    public function cityList(){
        $where = [];
        $where[] = ['status','=',1];
        $lists = YwCity::where($where)->field('id,name')->order('order_num','desc')->select();
        $data = [
            'lists' => $lists
        ];
        jsonSuccess($data);
    }

    /*
     * 获取选美列表
     */
    public function beautifulList(){
        $fildes = 'page,city_id';
        $receiveData = getData($this->request->post(),$fildes);
        if(empty($receiveData['page']) || $receiveData['page'] < 1){
            $receiveData['page'] = 1;
        }
        $where = [];
        $where[] = ['status','=',1];
        if(!empty($receiveData['city_id'])){
            $where[] = ['city_id','=',$receiveData['city_id']];
        }else{
            $one = YwCity::where(['status'=>1])->order('order_num','desc')->find();
            if(!empty($one)){
                $where[] = ['city_id','=',$one['id']];
            }else{
                $where[] = ['city_id','=',0];
            }
        }
        $limit_start = ($receiveData['page']-1) * env('home_page_size');
        $lists = YwBeautiful::where($where)->field('id,name,image')->order('order_num','desc')
            ->limit($limit_start,env('home_page_size'))->select();
        $data = [
            'lists' => YwBeautiful::fillModelHomes($lists)
        ];
        jsonSuccess($data);
    }

    /*
     * 获取视频分类列表
     */
    public function videoTypeList(){
        $where = [];
        $where[] = ['status','=',1];
        $lists = YwVideoType::where($where)->field('id,name')->order('order_num','desc')->select();
        $data = [
            'lists' => $lists
        ];
        jsonSuccess($data);
    }

    /*
     * 获取视频列表
     */
    public function videoList(){
        $fildes = 'page,video_type_id';
        $receiveData = getData($this->request->post(),$fildes);
        if(empty($receiveData['page']) || $receiveData['page'] < 1){
            $receiveData['page'] = 1;
        }
        $where = [];
        $where[] = ['status','=',1];
        /*if(!empty($receiveData['video_type_id'])){
            $where[] = ['video_type_id','=',$receiveData['video_type_id']];
        }else{
            $data = [
                'lists' => []
            ];
            jsonSuccess($data);
        }*/
        $limit_start = ($receiveData['page']-1) * env('home_page_size');
        $lists = YwVideo::where($where)->field('id,name,image,type,video_url,video_path,rate')->order('order_num','desc')
            ->limit($limit_start,env('home_page_size'))->select();
        $data = [
            'lists' => YwVideo::fillModelHomes($lists)
        ];
        jsonSuccess($data);
    }

    public function notice(){
        $model = YwNotice::where(['id'=>1])->find();
        $data = [
            'model' => $model
        ];
        jsonSuccess($data);
    }

    public function videoDetail(){
        $fildes = 'id';
        $receiveData = getData($this->request->post(),$fildes);
        $model = YwVideo::where(['id'=>$receiveData['id']])->field('id,name,image,type,video_url,video_path,rate')->find();
        $where = [];
        $where[] = ['id','<>',$receiveData['id']];
        $lists = YwVideo::where($where)->field('id,name,image,type,video_url,video_path,rate')->orderRaw("rand() , id DESC")
            ->limit(0,6)->select();
        $data = [
            'lists' => YwVideo::fillModelHomes($lists),
            'model' => YwVideo::fillModelHome($model)
        ];
        jsonSuccess($data);
    }

}
