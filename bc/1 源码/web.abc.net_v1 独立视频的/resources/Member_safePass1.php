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
	<link rel="stylesheet" href="__CSS2__/securityCenter.css">
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
			<li class="now">
				<span>验证原始资金密码</span>
				<i class="iconfont"></i>
			</li>
			<li>
				<span>修改密码资金密码</span>
				<i class=" iconfont "></i>
			</li>
			<li class="">
				<span>完成</span>
				<i class="iconfont"></i>
			</li>
		</ul>
		<form action="{:U('Member/update_safepass')}" class="update_form" method="post">
			<input type="hidden" name="settype" value="1">
			<p>
				<span>原始密码：</span>
				<input type="password" name="oldpassword">
			</p>
			<button type="submit" class="btn common_btn" >提交</button>
		</form>
	</div>
	</div>

<include file="Public/footer" />
</body>
</html>