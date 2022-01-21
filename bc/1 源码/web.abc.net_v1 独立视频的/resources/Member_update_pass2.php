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
				<span>验证原密码</span>
				<i class="icon-chenggong iconfont"></i>
			</li>
			<li class="now">
				<span>设置新密码</span>
				<i class="iconfont"></i>
			</li>
			<li>
				<span>完成</span>
				<i class="iconfont"></i>
			</li>
		</ul>
		<form action="{:U('Member/update_pass')}" class="update_form" method="post">
			<input type="hidden" name="settype" value="2">
			<p>
				<span>登录密码：</span>
				<input type="password" name="pa1">
			</p>
			<p>
				<span>重复密码：</span>
				<input type="password" name="password">
			    请牢记新修改的密码!
			</p>
			<button class="btn common_btn save_pass" type="submit">提交</button>
		</form>	
	</div>
	</div>

<include file="Public/footer" />

	<div class="modal fade update_pass_success" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">温馨提示</h4>
	      </div>
	      <div class="modal-body">
	        密码设置成功
	      </div>
	      <div class="modal-footer">
	        <a href="securityCenter.html" class="btn common_btn">确定</a>
	      </div>
	    </div>
	  </div>
	</div>
</body>
</html>