<?php
namespace app\admin\controller;

use app\BaseController;
use app\common\model\mysql\CommonCityConfig as models;

class CommonCityConfig extends BaseController
{


    public function initialize()
    {
    }

    /*
     * 加载省市数据
     */
    public function listAll(){
        $lists = models::where(['parent_id'=>0])->order('id','asc')->select();
        $data = [
            'lists' => models::fillModelParents($lists)
        ];
        jsonSuccess($data);
    }

    public function list(){
        $fildes = 'page';
        $receiveData = getData($this->request->post(),$fildes);
        $lists = models::order('id','desc')->page($receiveData['page'],env('page_size'))->select();
        $data = [
            'lists' => $lists
        ];
        jsonSuccess($data);
    }

}
