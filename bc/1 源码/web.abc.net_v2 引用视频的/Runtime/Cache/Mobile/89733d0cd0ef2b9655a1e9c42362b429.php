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
			????????????
		</h1>

	</header>
	
	<div class="bank_recharge">
		<form action="" method="post" id="formrecharge" class="am-form">
			<ul class="bank_form_list">
				<li class="am-cf">
					<span class="bank_form_left am-fl">????????????</span>
					<div class="am-fr bank_right_input">
						<input type="hidden"   name="paytype" value="<?php echo ($payinfo["paytype"]); ?>"  class="copy_txt" >
						<em style="padding-top:10px;display:block;"><?php echo ($payinfo["ftitle"]); ?></em>
						<span class="am-form-caret"></span>
					</div>
				</li>
				<li class="am-cf">
					<span class="bank_form_left am-fl">????????????</span>
					<div class="am-fr bank_right_input">
						<input type="text" value="<?php echo ($bankname); ?>" class="copy_txt" disabled="disabled">
					</div>
				</li>
				<li class="am-cf">
					<span class="bank_form_left am-fl">????????????</span>
					<div class="am-fr bank_right_input">
						<input type="text" value="<?php echo ($bankcode); ?>" class="copy_txt" disabled="disabled">
					</div>
				</li>
				<li class="am-cf">
					<span class="bank_form_left am-fl">????????????</span>
					<div class="am-fr bank_right_input">
						<input type="text" value="<?php echo ($payinfo["ftitle"]); ?>" class="copy_txt" disabled="disabled">
					</div>
				</li>
				<li class="am-cf">
					<span class="bank_form_left am-fl">????????????</span>
					<div class="am-fr bank_right_input">
						<input type="text" name="amount" value="<?php echo (floor($payinfo["minmoney"])); ?>"  class="input_txt" placeholder="??????<?php echo (floor($payinfo["minmoney"])); ?>" >
					</div>
				</li>
				<li class="am-cf">
					<span class="bank_form_left am-fl">????????????</span>
					<div class="am-fr bank_right_input">
						<input type="text"  class="input_txt" name="userpayname" placeholder="????????????????????????????????????">
					</div>
				</li>
			</ul>

			<button class="am-btn am-btn-danger am-radius am-btn-block" type="button" onclick="addrecharge()">??????</button>
		</form>	
		<div class="bottom_explain">
			<p>1??????????????????????????????????????????</p>
			<p>2??????????????????????????????????????????????????????????????????????????????????????????</p>
			<p>3?????????1?????????1?????????????????????????????????</p>
			<p>4????????????????????????????????????,???????????????????????????????????????</p>
		</div>
	</div>

	<script>
		function addrecharge() {
			$.ajax({
				type:"post",
				url:"<?php echo U('Apijiekou/addrecharge');?>",
				data : $('#formrecharge').serialize(),
				success : function (json) {
					if(json.sign==1){
						alert(json.message);
						window.location.href = "<?php echo U('Account/dealRecord2');?>";
					}else{
						if(json.message=="???????????????????????????"){
							alert("??????????????????????????????")
						}else{
							alert(json.message);
						}

					}

				}
			})
		}
	</script>
</body>
</html>