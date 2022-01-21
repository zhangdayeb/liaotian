<?php
namespace app\task\controller;
use app\BaseController;
use app\common\model\mysql\YwOrder as orderModel;
use app\common\model\mysql\YwCouponReceiveRecord as receiveModel;
use app\common\model\mysql\YwOtherConfig as otherConfigModel;
use app\common\model\mysql\YwCoupon as couponModel;
use think\facade\Log;

class Task extends BaseController
{
    protected $orderModel;
    protected $receiveModel;
    protected $otherConfigModel;
    protected $couponModel;

    public function initialize()
    {
        $this->orderModel = new orderModel();
        $this->receiveModel = new receiveModel();
        $this->otherConfigModel = new otherConfigModel();
        $this->couponModel = new couponModel();
    }

    /*
     * 检查领取卡券的过期[30秒执行1次]
     */
    public function checkCouponReceiveRecord(){
        Log::write('检查领取卡券的过期开始：'.date('Y-m-d H:i:s'));
        $where = [];
        $where[] = ['is_use','=',1];
        $where[] = ['is_delete','=',0];
        $where[] = ['end_time','<=',date('Y-m-d H:i:s')];
        $this->receiveModel->where($where)->update(['is_use'=>3]);
        Log::write('检查领取卡券的过期结束：'.date('Y-m-d H:i:s'));
    }

    /*
     * 检查卡券的过期[30秒执行1次]
     */
    public function checkCoupon(){
        Log::write('检查卡券的过期开始：'.date('Y-m-d H:i:s'));
        $where = [];
        $where[] = ['time_type','=',1];
        $where[] = ['is_delete','=',0];
        $where[] = ['end_time','<=',date('Y-m-d H:i:s')];
        $this->couponModel->where($where)->update(['is_expire'=>1]);
        Log::write('检查卡券的过期结束：'.date('Y-m-d H:i:s'));
    }

    /*
     * 检查订单失效[30秒执行1次]
     */
    public function checkOrder(){
        Log::write('检查订单失效开始：'.date('Y-m-d H:i:s'));
        $where = [];
        $where[] = ['status','=',1];
        $where[] = ['is_delete','=',0];
        $order_no_pay_expire = $this->otherConfigModel->where(['id'=>1])->value('order_no_pay_expire');
        $where[] = ['create_time','<=',date('Y-m-d H:i:s',strtotime("-$order_no_pay_expire minute"))];
        $this->orderModel->where($where)->update(['status'=>9]);
        //這裏還需要退款卡券和庫存
        Log::write('检查订单失效结束：'.date('Y-m-d H:i:s'));
    }

}
