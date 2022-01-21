<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="referrer" content="never">
<?php
//QQ1178087691
include 'mysql2.class.php';
include 'config.php';
date_default_timezone_set('PRC');
$post = @$_POST;
if (!$post) die('Error...');
if (!in_array($post['type'], [1,2])) die(alert('充值方式不存在'));
if (empty($post['user'])) die(alert('用户名不得为空'));

//获取配置
$sql = "select * from caipiao_payset where paytype = 'hxpay'";
$payinfo = $db->getOne($sql);
if (!$payinfo) die(alert('充值方式不存在2'));
if ($post['amount'] < $payinfo['minmoney'] || $post['amount'] > $payinfo['maxmoney']) die(alert("最少充值{$payinfo['minmoney']}元,最高{$payinfo['maxmoney']}元"));
if($payinfo['state']!=1)die(alert('通道已关闭'));
$sql = "select * from caipiao_member where username = '{$post['user']}'";
$user = $db->getOne($sql);
if (!$user) die(alert('用户不存在'));
$uid = $user['id'];
//插入订单
$orderid = 'hxpay_'. date('YmdHis', time()) . mt_rand(1, 9) . mt_rand(1, 9);
$data = array(
    'uid' => $uid,
    "username" => $user['username'],
    "paytype" => "hxpay",
    "paytypetitle" => "幻兮支付",
    "trano" => $orderid,
    "amount" => $post['amount'],
	'oldaccountmoney'=>$user['balance'],
	'newaccountmoney'=>$user['balance']+$post['amount'],
    'state' => '0',
    'oddtime' => time() ,
    "stateadmin" => '自动'
);
if (!$db->insert('caipiao_recharge', $data)) die(alert("订单插入失败"));


$mch_id= $config['id'];//这里改成支付ID
$mch_key=$config['key']; //这是您的通讯密钥
$data = array(
	"mch_uid" => $mch_id,//你的支付ID
	"out_trade_no" =>$orderid, //唯一标识 可以是用户ID,用户名,session_id(),订单ID,ip 付款后返回
	"pay_type_id" => $post['type'],//1微信支付 2支付宝
	"total_fee" =>$post['amount'],//金额
	//"param" => $_POST['param'],//自定义参数
	"notify_url"=>$config['n_url'],//通知地址
	"return_url"=>$config['r_url'],//跳转地址
	"mepay_type"=>  2,//
); //构造需要传递的参数
ksort($data); //重新排序$data数组
reset($data); //内部指针指向数组中的第一个元素
$sign = ''; //初始化需要签名的字符为空
$urls = ''; //初始化URL参数为空
//print_r($data);exit;
foreach ($data AS $key => $val) { //遍历需要传递的参数
	if ($val == ''||$key == 'sign') continue; //跳过这些不参数签名
	if ($sign != '') { //后面追加&拼接URL
		$sign .= "&";
		$urls .= "&";
	}
	$sign .= "$key=$val"; //拼接为url参数形式
	$urls .= "$key=" . urlencode($val); //拼接为url参数形式并URL编码参数值

}
$query = $urls . '&sign=' . md5($sign .$mch_key); //创建订单所需的参数
$url = "https://www.zhapay.com/pay.html?{$query}"; //支付页面
header("Location:{$url}"); //跳转到支付页面

function alert($str) {
    return "<script>alert('{$str}');window.history.back(-1); </script>";
}

