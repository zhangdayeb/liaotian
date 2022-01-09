<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-08-02
 * Time: 18:10
 */

namespace app\super\controller;


use app\im\model\mysql\CapitalLog;
use extend\service\UtilService;
use think\Controller;
use think\facade\Request;

class Capital extends Controller
{
     public function index()
         {
             $params = UtilService::getMore([
                 ['capital_type',''],
                 ['username',''],
                 ['time',''],
                 ['page',1],
                 ['limit',10],
             ]);
             if (Request::isAjax()) {
                 $model = (new CapitalLog());
                 $count = $model->count(1);
                 $model = $model->alias('w');
                 $model = $model->leftJoin('user u','w.user_id = u.id');
                 $model = $model->field('w.*,u.username');
                 if($params['time']){
                    $time = explode(" - ",$params['time']);
                     $model->where("w.create_time between '{$time[0]}' and '{$time[1]}'");
                 }
                 if($params['capital_type'] > 0){
                     $model = $model->where(['w.capital_type'=>$params['capital_type']]);
                 }
                 if($params['username'] > 0){
                     $model = $model->where(['u.username'=>$params['username']]);
                 }
                 $list = $model->page($params['page'], $params['limit'])->order('w.id desc')->select();
                 if ($list) {
                     foreach ($list as &$v) {
                       $v['record_type'] = [0=>'支出',1=>'收入'][$v['record_type']];
                     }
                 }
                 return json(['code' => 0, 'data' => $list->toArray(), 'count' => $count, 'msg' => 'success']);
             }
             return $this->fetch();
         }
}