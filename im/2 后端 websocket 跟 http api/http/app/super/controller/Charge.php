<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-08-01
 * Time: 4:29
 */

namespace app\super\controller;


use app\im\model\mysql\CapitalLog;
use app\im\model\mysql\ChargeOrder;
use extend\service\UtilService;
use think\App;
use think\Controller;
use think\facade\Request;

class charge extends Controller
{
    public function __construct(App $app = null)
    {

        parent::__construct($app);
        $this->assign('menu', ['财务操作', '资金记录']);

    }

    public function index()
        {
            $params = UtilService::getMore([
                ['key',''],
                ['time',''],
                ['status','-1'],
                ['page',1],
                ['limit',10],
            ]);
            if (Request::isAjax()) {
                $model = (new ChargeOrder());
                $count = $model->count(1);
                $model = $model->alias('w');
                $model = $model->leftJoin('user u','w.user_id = u.id');
                $model = $model->leftJoin('user_bank b','w.user_bank_id = b.id');
                $model = $model->field('w.*,w.status as v_status,u.nickname,b.account,b.fullname');
                if($params['key']){
                    $map['u.nickname|b.fullname|b.account'] = ['like','%'.$params['key']];
                    $model = $model->where("u.nickname like '%{$params['key']}%' or b.fullname like '%{$params['key']}%' or b.account like '%{$params['key']}%'");
                }
                if($params['status'] > 0){
                    $model = $model->where(['w.status'=>$params['status']]);
                }
                if($params['time'] > 0){
                    $model = $model->where(['w.status'=>$params['status']]);
                }
                $list = $model->page($params['page'], $params['limit'])->select();
                if ($list) {
                    foreach ($list as &$v) {
                        $v['bank_code'] = $v['account'];
                        $v['status_msg'] = $v['v_status'] ? '已审核' : '待审核';
                        $v['true_amount'] = bcsub($v['draw_money'], $v['fee'], 2);
                        $v['update_time'] = $v['update_time'] ? date('Y-m-d H:i:s', $v['update_time']) : '';
                    }
                }
                return json(['code' => 0, 'data' => $list->toArray(), 'count' => $count, 'msg' => 'success']);
            }
            return $this->fetch();
        }
}