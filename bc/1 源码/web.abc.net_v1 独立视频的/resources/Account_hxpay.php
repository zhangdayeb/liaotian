<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<title>{:GetVar('webtitle')}</title>
	<meta name="keywords" content="{:GetVar('keywords')}" />
	<meta name="description" content="{:GetVar('description')}" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" >

	<link rel="stylesheet" href="__CSS2__/bootstrap.min.css">
	<link rel="stylesheet" href="__CSS2__/reset.css">
	<link rel="stylesheet" href="__CSS2__/icon.css">
	<link rel="stylesheet" href="__CSS2__/header.css">
	<link rel="stylesheet" href="__CSS2__/userInfo.css">
	<link rel="stylesheet" href="__CSS2__/recharge.css">
	<link rel="stylesheet" href="__CSS2__/footer.css">
	<link rel="stylesheet" href="https://at.alicdn.com/t/font_lo77yrw5tt8adcxr.css">
	<link rel="stylesheet" type="text/css" href="__CSS__/artDialog.css" />

</head>
<body>
<style>
	.me-infor {
		overflow: hidden;
		margin: 10px 0;
	}
	.me-infor .infor-xx {
		padding: 10px 20px;
		margin: 0 0 10px;
		border: 1px solid #e3e3e3;
	}
	.me-infor .infor-xx ul li {
		display: block;
		height: 36px;
		line-height: 36px;
		padding: 3px 0;
	}
	.me-infor .infor-xx h6{
		float:left;
	}
	.mark {
		color: #f33d3d;
	}
</style>
<include file="Public/header" />
<script type="text/javascript" src="__ROOT__/resources/js/way.min.js"></script>
<script type="text/javascript" src="__ROOT__/resources/main/common.js"></script>
<script src="__JS2__/require.js" data-main="__JS2__/homePage"></script>
	<div class="vip_info clearfix container">

		<div class="pull-right vip_info_pan">
			<div class="vip_info_title">
				我要充值
			</div>
			<div class="vip_info_content recharge_main">
				 <include file="Account/paylist" />
				<form  method="post" action="/hxpay/pay.php" onSubmit="return checkform(this)">
					<div class="common_border_box1 choiceBank_box">
						<div class="choiceMoney">
							<span class="choiceMoney_l">充值金额：</span>
							<input type="text" name="amount" id="amount" placeholder="最低充值{$payinfo.minmoney}" class="common_input">
						</div>
						<div class="choiceBank clearfix">
							<span class="choiceMoney_l pull-left">充值方式：</span>
							<select name="type" id='pay_type'>
							  <option value ="0">请选择支付方式</option>
							  <option value ="2">支付宝</option>
							   <option value ="1">微信</option>
							</select>
						</div>
						
						<input type="hidden"  name="user" value="{$_SESSION['userinfo']['username']}" checked="checked"  style="display:none;">
						<button class="btn common_btn nextbtn">充值</button>

						<div class="prompt">
							<p>※ 温馨提示：</p>
							<p>单笔充值金额最低{$payinfo.minmoney}元，最{$payinfo.maxmoney}高元。</p>
								{$payinfo.remark}
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

<script type="text/javascript">
	$('.nextbtn').click(function () {
		 if($('input[name=amount]').val()=="") {
			 alt('请输入充值金额');return false;
		 }
		 if($('#pay_type').val()==0) {
			 alt('请选择支付方式');return false;
		 }
		
	})
	
</script>
</body>
</html>