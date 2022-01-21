<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<title>幸运彩</title>
	<meta name="keywords" content="关键字">
	<meta name="description" content="网站主要内容">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" >

	<link rel="stylesheet" href="__CSS2__/bootstrap.min.css">
	<link rel="stylesheet" href="__CSS2__/reset.css">
	<link rel="stylesheet" href="__CSS2__/icon.css">
	<link rel="stylesheet" href="__CSS2__/header.css">
	<link rel="stylesheet" href="__CSS2__/updatePass.css">
	<link rel="stylesheet" href="__CSS2__/footer.css">
	<link rel="stylesheet" href="__JS2__/layer/skin/default/layer.css">
	<link rel="stylesheet" href="//at.alicdn.com/t/font_bnvu6xzx1198uxr.css">

</head>
<body>
<include file="Public/header" />
<script type="text/javascript" src="__ROOT__/resources/js/way.min.js"></script>
<script type="text/javascript" src="__ROOT__/resources/main/common.js"></script>
<script src="__JS2__/require.js" data-main="__JS2__/homePage"></script>
	<div class="update_pass">
	<div class="container-fluid">
		<ul class="queue">
			<li class="now">
				<span>绑定新邮箱</span>
				<i class=" iconfont"></i>
			</li>
			<li class="">
				<span>完成</span>
				<i class="iconfont"></i>
			</li>
		</ul>
		<form action="{:U('Member/bindmail')}" method="post" class="update_form">
			<p>
				<span>邮箱：</span>
				<input type="text" name="email"  id="testtomail" value="{$userinfo.email}" /> 绑定后修改需联系客服!
			</p>
<!--			<p>
				<span>验证码：</span>
				<input type="text" name="code" class="test_code">
				<a href="javascript:void(0)" class="get_code" onclick="testemail();">获取验证码</a>
			</p>-->
			<button class="btn common_btn save_pass" type="submit" >提交</button>
		</form>	
	</div>
	</div>

<include file="Public/footer" />
<script>
	function testemail(){
		$("#testmailbtn").val('正在发送！请稍后...');
		$.post("{:U('Member/testtomail')}",{'to':$("#testtomail").val(),'SMTP_HOST':$("#SMTP_HOST").val(),'SMTP_PORT':$("#SMTP_PORT").val(),'SMTP_USER':$("#SMTP_USER").val(),'SMTP_PASS':$("#SMTP_PASS").val()}, function(json){
			if(json.status==1){
				alt('发送成功,验证码已经发送到你绑定的邮箱');
			}else if(json.status==0){
				alt(json.info);
			}
		}, "json");
	}
</script>

<!--	<div class="modal fade update_pass_success" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">温馨提示</h4>
	      </div>
	      <div class="modal-body">
	        邮箱绑定成功
	      </div>
	      <div class="modal-footer">
	        <a href="securityCenter.html" class="btn common_btn">确定</a>
	      </div>
	    </div>
	  </div>
	</div>-->
</body>
</html>