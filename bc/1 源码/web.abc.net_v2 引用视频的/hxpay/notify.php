<?php
//$_POST=include '6643.php';
include 'mysql2.class.php';
include 'config.php';
if(!@$_POST)die;
file_put_contents('pay1.txt',var_export($_POST,true));
ksort($_POST); //排序post参数
reset($_POST); //内部指针指向数组中的第一个元素
$mch_key=$config["key"]; //这是您的密钥
$sign = '';//初始化
foreach ($_POST AS $key => $val) { //遍历POST参数
	if ($val == '' || $key == 'sign') continue; //跳过这些不签名
	if ($sign) $sign .= '&'; //第一个字符串签名不加& 其他加&连接起来参数
	$sign .= "$key=$val"; //拼接为url参数形式
}
if (!$_POST['transaction_id'] || md5($sign . $mch_key) != $_POST['sign'] || $_POST['status']!=1) { //不合法的数据
	exit('fail');  //返回失败 继续补单
} else { //合法的数据
	//业务处理
	$out_trade_no = $_POST['out_trade_no']; //需要充值的ID 或订单号 或用户名
	$mepay_total = (float)$_POST['mepay_total']; //提交金额
	$total_fee = (float)$_POST['total_fee']; //用户实际付款
	//$param = $_POST['param']; //自定义参数
	$transaction_id = $_POST['transaction_id']; //流水号
	////////////////这里写业务逻辑/////////////////
	
	$sql="select * from caipiao_recharge where trano ='{$_POST['out_trade_no']}'";
   $order = $db->getOne($sql);
   
   if(!$order) exit('fail');
   if($order['state']!=0)exit('success');
   $sql="select * from caipiao_member where id ='{$order['uid']}'";
   //die($sql);
   $user = $db->getOne($sql);
   if(!$user)exit('success');
   $res=$db->update('caipiao_member',[ 'balance' => ($user['balance']+$mepay_total)],"id ='{$order['uid']}'");
   if(!$res)exit('success');
   $res=$db->update('caipiao_recharge',[ 'state' =>1],"trano ='{$_POST['out_trade_no']}'");
   //帐变
   if(!$res)exit('success');
	$fuddetaildata = [];
	$fuddetaildata['trano'] = $_POST['out_trade_no'];
	$fuddetaildata['uid'] = $user['id'];
	$fuddetaildata['username'] = $user['username'];
	$fuddetaildata['type'] = 'activity_cz';
	$fuddetaildata['typename'] = '充值';
	$fuddetaildata['amount'] = $mepay_total;
	$fuddetaildata['amountbefor'] = $user['balance'];
	$fuddetaildata['amountafter'] = $user['balance']+$mepay_total;
	$fuddetaildata['remark'] = '账户充值';
	$fuddetaildata['oddtime'] = time();
	$db->insert('caipiao_fuddetail', $fuddetaildata);
	curl_request("http://61cpyl.com/apijiekou.czzs.do",'post',$order);
   exit('success');
	
	
	exit('success'); //返回成功 不要删除哦
}
