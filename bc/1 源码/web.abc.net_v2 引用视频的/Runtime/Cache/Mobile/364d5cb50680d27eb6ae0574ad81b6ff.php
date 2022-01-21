<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo GetVar('webtitle');?></title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="full-screen" content="yes">
    <meta name="x5-fullscreen" content="true">
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-orientation" content="portrait">
    <meta name="viewport" content="width=device-width, initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=none">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="apple-touch-icon-precomposed" href="/Template/Mobile/images/icon.jpg">
    <link rel="apple-touch-startup-image" href="/Template/Mobile/images/strat.jpg" />


    <link rel="stylesheet" href="/Template/Mobile/css/amazeui.min.css?v=20180826">
    <link rel="stylesheet" href="/Template/Mobile/css/common2.css?v=20180826">
    <link rel="stylesheet" href="/Template/Mobile/css/index.css?v=20180826">
    <link rel="stylesheet" href="/Template/Mobile/css/icon.css?v=20180826">
    <link rel="stylesheet" href="/resources/css/artDialog.css?v=20180826">
    <script>
        var Webconfigs = {
            "ROOT" : ""
        }
    </script>
    
    
</head>
<script src="/Template/Mobile/js/jquery-3.1.1.min.js"></script> 
<script type="text/javascript" src="/resources/js/artDialog.js?v=20180826"></script>
<script type="text/javascript" src="/resources/js/way.min.js?v=20180826"></script>
<script type="text/javascript" src="/resources/main/common.js?v=20180826"></script>
<script src="/Template/Mobile/js/require.js?v=20180826" data-main="/Template/Mobile/js/main"></script>

<link rel="stylesheet" href="/Template/Mobile/css/userHome.css">
<body>
	<header data-am-widget="header"class="am-header am-header-default header nav_bg am-header-fixed">
		<div class="am-header-left am-header-nav">
			<a href="javascript:history.back(-1);" class="">
				<i class="iconfont icon-arrow-left"></i>
			</a>
      	</div>

		<h1 class="am-header-title activity_h1">
			绑定银行卡
		</h1>

	</header>
	
	<div class="bank_recharge">
		<form action="<?php echo U('Member/addBank');?>" method="post" class="am-form">
			<ul class="bank_form_list">
				<li class="am-cf">
					<span class="bank_form_left am-fl">持卡人姓名:</span>

					<div class="am-form-group bank_right_select am-fr">
						<span class="am-form-caret userbankname"><?php echo ($userinfo["userbankname"]); ?></span>
					</div>

					<!--<div class="am-fr bank_right_input">
						<input type="text"  id="accountname" name="accountname"  class="input_txt" placeholder="请输入您的真实姓名" >
					</div>-->
					
				</li>
				<li class="am-cf">
					<span class="bank_form_left am-fl">选择银行</span>
					<div class="am-form-group bank_right_select am-fr">
						<select name="bankname" id="sysBankCard" class="select_common">
							<option value="">请选择银行</option>
							<?php if(is_array($Allbank)): $i = 0; $__LIST__ = $Allbank;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($i % 2 );++$i;?><option value="<?php echo ($value['bankcode']); ?>"><?php echo ($value['bankname']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
						<span class="am-form-caret"></span>
					</div>
				</li>
				<!--<li class="am-cf">
					<span class="bank_form_left am-fl">开户省</span>
					<div class="am-form-group bank_right_select am-fr">
						<select id="s_province" name="province" class="select_common"   data-shen="请选择开户省份">
						</select>
						<span class="am-form-caret"></span>
					</div>
				</li>
				<li class="am-cf">
					<span class="bank_form_left am-fl">开户市</span>
					<div class="am-form-group bank_right_select am-fr">
						<select  name="city" id="s_city" class="select_common"   data-shi="请选择开户城市">
						</select>
						<span class="am-form-caret"></span>
					</div>
				</li>-->
<!--				<li class="am-cf">
					<span class="bank_form_left am-fl" >开户人姓名</span>
					<div class="am-fr bank_right_input">
						<input name="accountname" type="text" class="input_txt" placeholder="请输入银行卡的姓名" >
					</div>
				</li>-->
				<!--<li class="am-cf">
					<span class="bank_form_left am-fl">开户网点</span>
					<div class="am-fr bank_right_input">
						<input type="text"  id="bankBranch" name="accountname"  class="input_txt" placeholder="开户网点" >
					</div>
				</li>-->
				<li class="am-cf">
					<span class="bank_form_left am-fl">银行卡号</span>
					<div class="am-fr bank_right_input">
						<input type="text"  id="bankCardNum" name="banknumber"  class="input_txt" placeholder="请输入银行卡的卡号" >
					</div>
				</li>
				<li class="am-cf">
					<span class="bank_form_left am-fl">确认卡号</span>
					<div class="am-fr bank_right_input">
						<input type="text" id="regBankCardNum" name="rebanknumber"  class="input_txt" placeholder="请再次输入银行卡号">
					</div>
				</li>
			<!--	<li class="am-cf">
					<span class="bank_form_left am-fl">资金密码</span>
					<div class="am-fr bank_right_input">
						<input type="password" id="bankTradPwd" name="safepass"  class="input_txt" placeholder="请输入您的资金密码">
					</div>
				</li>-->
			</ul>

			<button class="am-btn am-btn-danger am-radius am-btn-block"  onclick="userbindbankcard();" type="button">确定</button>
		</form>	
	</div>

	<script>
		var userbindbankcard = function(){

			var url = '/Apijiekou.' + 'userbindbankcard';
			var bankCode = $("#sysBankCard").val();
            var _username = $(".userbankname").html();
			var bankCardNumber = $("#bankCardNum").val();
			var regbankCardNumber = $("#regBankCardNum").val();
			var province = $("#s_province").val();
			var city = $("#s_city").val();

			var bankTradPwd = $("#bankTradPwd").val();
		 
			var bankBranch = $("#bankBranch").val();
			bankBranch = bankBranch?bankBranch:"";
			 

			if(_username.length<2){
				window.location.href="<?php echo U('Account/userbankname');?>"
			}
			if (bankCode.length < 1) {
				alert("请选择银行卡");return false;
			} else if (province=="省份" || city=="地级市") {
				alert("请选择开户省市");return false;

			} else if (bankCardNumber.length < 1) {
				alert("请输入银行卡号");return false;

			} else if (regbankCardNumber.length < 1) {
				alert("请输入确认银行卡号");return false;
			} else if (regbankCardNumber != bankCardNumber) {
				alert("两次卡号输入的不一致，请重新输入");return false;
			}  
			var bankAddress = province + "-" + city;
			$.post(url,{
				"bankCardNumber": bankCardNumber,
				"bankAddress": bankAddress,
				"bankTradPwd": bankTradPwd,
				"bankCode": bankCode,
				"regbankCardNumber": regbankCardNumber,
				"bankBranch": bankBranch,
				"accountname": _username
			}, function(json){
				if(json.sign){
					alert('银行绑定成功',1);
					window.location.href="<?php echo U('Member/bindcard');?>";
				}else{
					alert(json.message,-1);
					return false;
				}
				return false;
			},'json');

			 
		}
	</script>
</body>
</html>