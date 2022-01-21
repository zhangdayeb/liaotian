<?php
namespace Api\Controller;
use Think\Controller\HproseController;
class PayController extends CommonController {
	protected $allowMethodList =    array(
	'paycheck',
	);
	function checkislogin($apiparam=array()){
		$apiparam = _cheacktoken($apiparam);
		if(!$apiparam['sign'])return $apiparam;
		$apiparam = checklogin($apiparam);
		return $apiparam;
	}
	function paycheck($apiparam=array()){
		$apiparam = self::_cheacktoken($apiparam);
		if(!$apiparam['sign'])return $apiparam;
		$uid      = $apiparam['uid'];
		$username = $apiparam['username'];
		$paytype  = $apiparam['paytype'];
		$trano    = $apiparam['trano'];
		$amount   = $apiparam['amount'];
		$id = $apiparam['id'];
		$payinfo = M('recharge')->where(['trano'=>$trano,'paytype'=>$paytype])->find();
		if($payinfo['uid']!=$uid){
			$apiparam['sign']=false;
			$apiparam['message']='充值用户ID校验错误';
			return $apiparam;exit;
		}
		if($payinfo['state']!=0){
			$apiparam['sign']=false;
			$apiparam['message']='充值状态已经修改';
			return $apiparam;exit;
		}
		if($apiparam['threetrano'])$payinfo['threetrano'] = $apiparam['threetrano'];
		$return = userrechargepay($payinfo);
		if($return==0){
			$apiparam['sign']=false;
			$apiparam['message']='充值参数非法';
			return $apiparam;exit;
		}elseif($return==1){
			$apiparam['sign']=true;
			$apiparam['message']='ok充值成功ok';
			return $apiparam;exit;
		}elseif($return==-1){
			$apiparam['sign']=false;
			$apiparam['message']='充值订单已经取消';
			return $apiparam;exit;
		}else{
			$apiparam['sign']=false;
			$apiparam['message']='充值失败2';
			return $apiparam;exit;
		}
		$apiparam['sign']=false;
		return $apiparam;exit;
	}
}