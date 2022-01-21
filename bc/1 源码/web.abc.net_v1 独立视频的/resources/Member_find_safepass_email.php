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
	<link rel="stylesheet" href="__CSS2__/updatePass.css">
	<link rel="stylesheet" href="__CSS2__/footer.css">
	<link rel="stylesheet" href="__JS2__/layer/skin/default/layer.css">
	<link rel="stylesheet" href="//at.alicdn.com/t/font_bnvu6xzx1198uxr.css">
	

</head>
<body>
<include file="Public/header" />
<script src="__JS2__/require.js" data-main="__JS2__/homePage"></script>
	<div class="update_pass">
	<div class="container-fluid">
		<ul class="queue">
			<li class="right">
				<span>选择验证方式</span>
				<i class=" iconfont  icon-chenggong"></i>
			</li>
			<li class="now">
				<span>身份验证</span>
				<i class=" iconfont "></i>
			</li>
			<li>
				<span>修改密码</span>
				<i class=" iconfont"></i>
			</li>
			<li class="">
				<span>完成</span>
				<i class="iconfont"></i>
			</li>
		</ul>
		<form action="{:U('Member/find_safepass_email')}" method="post" class="update_form">

			<p>
				<span>邮箱：</span>
				<input type="text" name="email" id="testtomail" placeholder="请输入你绑定的邮箱" value="" />
			</p>
<!--			<p>
				<span>验证码：</span>
				<input type="text" name="code" class="test_code">
				<a href="javascript:void(0)" class="get_code" onclick="testemail();">获取验证码</a>
			</p>-->
			<button class="btn common_btn save_pass" type="submit">提交</button>
		</form>	
	</div>
	</div>

<include file="Public/footer" />
<script>
	function testemail(){
		$("#testmailbtn").val('正在发送！请稍后...');
		$.post("{:U('Member/testtomail')}",{'to':$("#testtomail").val(),'SMTP_HOST':$("#SMTP_HOST").val(),'SMTP_PORT':$("#SMTP_PORT").val(),'SMTP_USER':$("#SMTP_USER").val(),'SMTP_PASS':$("#SMTP_PASS").val()}, function(json){
			if(json.status==1){
				alert('发送成功,验证码已经发送到你绑定的邮箱');
			}else if(json.status==0){
				alert(json.info);
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