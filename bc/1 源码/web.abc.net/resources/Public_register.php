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
	<link rel="stylesheet" href="__CSS2__/main.css">
	<link rel="stylesheet" href="__CSS2__/login.css">
	<link rel="stylesheet" href="__CSS2__/footer.css">
</head>
<body>
<include file="Public/header" />
<link rel="stylesheet" type="text/css" href="__CSS__/common.css" />
<link rel="stylesheet" type="text/css" href="__CSS__/layout.css" />
<link rel="stylesheet" type="text/css" href="__CSS__/style.css" />
<link rel="stylesheet" type="text/css" href="__CSS__/artDialog.css" />
<script type="text/javascript" src="__JS__/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="__JS__/artDialog.js"></script>
<script type="text/javascript" src="__JS__/index.js"></script>
<script src="__JS2__/require.js" data-main="__JS2__/homePage"></script>
<div class="login_main">
	<div class="login_bg" style="height:540px">
		<div class="login_title">
			<h2 class="margin_0">用户注册</h2>
			<p>{$mingren}都已经注册了，赶紧加入吧！注册后系统将随机分配一张个性的头像。</p>
		</div>
		<div class="login_input">
			<form method="post" id="form1" class="ruivalidate_form_class" checkby_ruivalidate  onSubmit="return check_form(this)"  action="{:U('Public/register')}">
				<input type="hidden" name="action" value="register_agent" />
				<assign name="defaulttjcode" value="$Think.config.defaulttjcode" /> 
				<if condition="$defaulttjcode neq '0'  ">
					<dl style="padding:0;padding-left:20%;margin-bottom: 20px;margin-top: -20px;">
						<dd style="font-size: 12pt;color: #333333;">无推荐代码请输入：{$defaulttjcode}</dd>
					</dl>
				</if>
					<div class="login_user user_commom_style">
					<span>邀请码：</span>
						<present name="linkinfo"><input type="hidden" name="linkid" value="{$linkinfo.id}"  /></present>
						<input type="text" <if condition="$tgid neq ''">readonly</if> value="{$tgid}" id="reccode" class="input fadeIn delay1"
							size="60" name="reccode" maxlength="16"  placeholder="请输入4-12位的推荐代码" />

					<em class="checkInput">
						<i class="iconfont"></i>
						<span></span>
					</em>
					<!--	<input  type="text" placeholder="请输入邀请码"  class="text_accont"  style="border-radius:4px;"  id="reccode" name="reccode" /><em class="Validform_checktip"></em>-->
				</div>
				<div class="login_pass user_commom_style">
					<span>账号：</span>
					<input  type="text"  class="text_accont" placeholder="请输入账号"  style="border-radius:4px;"  id="userName" name="username"  verify="isLoginName" datatype="/[\w\W]+/" ajaxurl="{:U('Public/checkusername')}" errormsg="用户名格式错误，可以中文英文字符数字！" nullmsg="请填写用户名！"/>
					<em class="checkInput">
						<i class="iconfont"></i>
						<span></span>
					</em>
				</div>
				<div class="login_pass user_commom_style">
					<span>设置密码：</span>
					 <input  type="password" style="border-radius:4px;"  placeholder="请输入密码"   class="text_accont" name="password" id="passWord" plugin="passwordStrength" errormsg="密码范围在6~16位之间！" nullmsg="请设置密码！" datatype="s6-16"/>
					<em class="checkInput">
						<i class="iconfont"></i>
						<span></span>
					</em>
				</div>
				<div class="login_pass user_commom_style">
					<span>确认密码：</span>
					<input  type="password" id="qpassWord"  placeholder="请再次输入密码"  class="text_accont" style="border-radius:4px;"  name="cpassword" datatype="*6-16" recheck="password" nullmsg="请再输入一次密码！" errormsg="您两次输入的账号密码不一致！"/>
					<em class="checkInput">
						<i class="iconfont"></i>
						<span></span>
					</em>
				</div>
				<div class="login_pass user_commom_style">
					<span>资金密码：</span>
					<input  type="password" id="qpassWord" placeholder="请输入资金密码"  class="text_accont" style="border-radius:4px;"  name="tradepassword" datatype="*6-16" recheck="password" nullmsg="请输入资金密码！"/>
					<em class="checkInput">
						<i class="iconfont"></i>
						<span></span>
					</em>
				</div>
				<div class="login_pass user_commom_style position_r">
					<span>验证码：</span>
					<input  type="text" class="text_form" placeholder="请输入验证码"  name="code" maxlength="10"  isNot="true"  verify="isAll" msg="请输入验证码" style="border-radius:4px;width:12em;" />
					<em class="checkInput" style="margin-left: 145px;">
						<i class="iconfont"></i>
						<span></span>
					</em>
					<img class="v_code" src="{:U('Public/verify',array('imageW'=>130,'imageH'=>40,'fontSize'=>18))}" onclick="this.src=this.src+'?temp='+ 1" style="cursor:pointer"  alt="验证码" />
				</div>
				<div class="check_box">
					<input type="checkbox" checked="checked" name="age" />我已经年满18岁
				</div>
				<div class="btn_submit pull-left" >
					<input  type="submit" id="submit" class="btn btn-danger register" style="width:8em;height: 2.5em;" value="立即注册"/>　
					<input  type="reset"  style="width:8em;height: 2.5em;" class="btn btn-default reset"  value="重置" />　<!--已有账号？<a href="{:U('Public/login')}" class="remmber_pwd">立即登录</a>--></p>
				</div>
			</form>
		</div>
	</div>
</div>
<include file="Public/footer" />
<script type="text/javascript" src="__JS__/Validform_v5.3.2.js"></script>
<script type="text/javascript" src="__JS__/passwordStrength-min.js"></script>
<script type="text/javascript">
	$(function(){
		// $("#form1").Validform({
		// 	tiptype:function(msg,o,cssctl){
		// 		var objtip=o.obj.siblings(".Validform_checktip");
		// 		cssctl(objtip,o.type);
		// 		objtip.text(msg);
		// 	},
		// 	usePlugin:{
		// 		passwordstrength:{
		// 			minLen:6,
		// 			maxLen:18
		// 		}
		// 	},
		// 	callback:check_form
		// });

		$('input[name="reccode"]').blur(function () {
			var text = $(this).val();
			if(!text || text.trim() == ''){
				$(this).siblings('.checkInput').show();
				$(this).siblings('.checkInput').find('span').text('邀请码不能为空');
				$(this).siblings('.checkInput').find('.iconfont').removeClass('icon-chenggong');
				$(this).siblings('.checkInput').find('.iconfont').addClass('icon-cross-ivt');
			}else{
				$(this).siblings('.checkInput').show();
				$(this).siblings('.checkInput').find('span').text('');
				$(this).siblings('.checkInput').find('.iconfont').removeClass('icon-cross-ivt');
				$(this).siblings('.checkInput').find('.iconfont').addClass('icon-chenggong');
			}
		})

		$('.text_accont[name="username"]').blur(function () {
			var text = $(this).val();
			if(!text || text.trim() == ''){
				$(this).siblings('.checkInput').show();
				$(this).siblings('.checkInput').find('span').text('账号不能为空');
				$(this).siblings('.checkInput').find('.iconfont').removeClass('icon-chenggong');
				$(this).siblings('.checkInput').find('.iconfont').addClass('icon-cross-ivt');
			}else{
				$(this).siblings('.checkInput').show();
				$(this).siblings('.checkInput').find('span').text('');
				$(this).siblings('.checkInput').find('.iconfont').removeClass('icon-cross-ivt');
				$(this).siblings('.checkInput').find('.iconfont').addClass('icon-chenggong');
			}
		})

		$('.text_accont[name="password"]').blur(function () {
			var text = $(this).val();
			if(!text || text.trim() == ''){
				$(this).siblings('.checkInput').show();
				$(this).siblings('.checkInput').find('span').text('密码不能为空');
				$(this).siblings('.checkInput').find('.iconfont').removeClass('icon-chenggong');
				$(this).siblings('.checkInput').find('.iconfont').addClass('icon-cross-ivt');
			}else if(text.length < 6 || text.length > 16){
				$(this).siblings('.checkInput').show();
				$(this).siblings('.checkInput').find('span').text('密码范围在6-16位');
				$(this).siblings('.checkInput').find('.iconfont').removeClass('icon-chenggong');
				$(this).siblings('.checkInput').find('.iconfont').addClass('icon-cross-ivt');
			}else{
				$(this).siblings('.checkInput').show();
				$(this).siblings('.checkInput').find('span').text('');
				$(this).siblings('.checkInput').find('.iconfont').removeClass('icon-cross-ivt');
				$(this).siblings('.checkInput').find('.iconfont').addClass('icon-chenggong');
			}
		})

		$('.text_accont[name="cpassword"]').blur(function () {
			var text = $(this).val();
			if(!text || text.trim() == ''){
				$(this).siblings('.checkInput').show();
				$(this).siblings('.checkInput').find('span').text('确认密码不能为空');
				$(this).siblings('.checkInput').find('.iconfont').removeClass('icon-chenggong');
				$(this).siblings('.checkInput').find('.iconfont').addClass('icon-cross-ivt');
			}else if(text.length < 6 || text.length > 16){
				$(this).siblings('.checkInput').show();
				$(this).siblings('.checkInput').find('span').text('确认密码范围在6-16位');
				$(this).siblings('.checkInput').find('.iconfont').removeClass('icon-chenggong');
				$(this).siblings('.checkInput').find('.iconfont').addClass('icon-cross-ivt');
			}else if(text != $('.text_accont[name="password"]').val()){
				$(this).siblings('.checkInput').show();
				$(this).siblings('.checkInput').find('span').text('两次密码不相同');
				$(this).siblings('.checkInput').find('.iconfont').removeClass('icon-chenggong');
				$(this).siblings('.checkInput').find('.iconfont').addClass('icon-cross-ivt');
			}else{
				$(this).siblings('.checkInput').show();
				$(this).siblings('.checkInput').find('span').text('');
				$(this).siblings('.checkInput').find('.iconfont').removeClass('icon-cross-ivt');
				$(this).siblings('.checkInput').find('.iconfont').addClass('icon-chenggong');
			}
		})

		$('.text_accont[name="tradepassword"]').blur(function () {
			var text = $(this).val();
			if(!text || text.trim() == ''){
				$(this).siblings('.checkInput').show();
				$(this).siblings('.checkInput').find('span').text('资金密码不能为空');
				$(this).siblings('.checkInput').find('.iconfont').removeClass('icon-chenggong');
				$(this).siblings('.checkInput').find('.iconfont').addClass('icon-cross-ivt');
			}else{
				$(this).siblings('.checkInput').show();
				$(this).siblings('.checkInput').find('span').text('');
				$(this).siblings('.checkInput').find('.iconfont').removeClass('icon-cross-ivt');
				$(this).siblings('.checkInput').find('.iconfont').addClass('icon-chenggong');
			}
		})

		$('input[name="code"]').blur(function () {
			var text = $(this).val();
			if(!text || text.trim() == ''){
				$(this).siblings('.checkInput').show();
				$(this).siblings('.checkInput').find('span').text('验证码不能为空');
				$(this).siblings('.checkInput').find('.iconfont').removeClass('icon-chenggong');
				$(this).siblings('.checkInput').find('.iconfont').addClass('icon-cross-ivt');
			}else{
				$(this).siblings('.checkInput').show();
				$(this).siblings('.checkInput').find('span').text('');
				$(this).siblings('.checkInput').find('.iconfont').removeClass('icon-cross-ivt');
				$(this).siblings('.checkInput').find('.iconfont').addClass('icon-chenggong');
			}
		})

	})
	function rdirect(url){
		window.location.href = url;
	}

	function check_form(obj){

		if(!$('input[name=age]').is(':checked')){
			alt('禁止未成年人注册');
			return false;
		}
 		$.ajax({
			url : "{:U('public/register')}",
			type : 'POST',
			data : {
				linkid          :   $('input[name=linkid]').val(),
				code       :   $('input[name=code]').val(),
				cpassword      :   $('input[name=cpassword]').val(),
				password       :   $('input[name=password]').val(),
				reccode        :   $('input[name=reccode]').val(),
				tradepassword  :   $('input[name=tradepassword]').val(),
				username       :   $('input[name=username]').val(),
			},
			beforeSend : function(){
				$('#submit').attr('disabled','disabled');
			},
			success : function(json){
				if(json.sign==1){
					alt('恭喜您注册成功，感谢您的加入!');
					var url = json.url?json.url:"{:U('Home/Index/index')}";
					// window.location.href= url;
					setTimeout("rdirect('"+url+"')", 1500);
					   $('#submit').attr('disabled',false);
				}else{
					   $('#submit').attr('disabled',false);
					  alt(json.message);
				}
			}
		})

//		$.post($(obj).attr('action'),$(obj).serialize(), function(json){
//			if(json.sign==1){
//				alt('恭喜您注册成功，感谢您的加入!');
//				var url = json.url?json.url:"{:U('Home/Index/index')}";
// 				setTimeout("rdirect('"+url+"')", 1500);
//			}else{
//				alt(json.message);
//			}
//		},'json');
		return false;
	}
</script>
<script type="text/javascript">
	function sendtelcode(obj){
		if($("input[name='username']").val().length<3){
			alert('用户名设置错误');
			return false;
		}

		if($("input[name='password']").val().length<6){
			alert('密码设置错误');
			return false;
		}
		if($("input[name='password']").val()!=$("#qpassWord").val()){
			alert('两次密码输入不一致');
			return false;
		}
		var tel = $("#tel").val();
		var exp = new RegExp("^(1)[0-9]{10}$");
		if(!exp.test(tel)){
			alert('手机号码填写错误');
			$("#tel").focus();
			return false;
		}
		if($("input[name='verCord']").val().length<4){
			alert('图形验证码设置错误');
			return false;
		}else{
			$.post("{:U('Public/check_verify')}",{'code':$("input[name='verCord']").val()}, function(json){
				if(json.status=='y'){
					var token = json.token;
					sendmsg(tel,token,obj);
				}else{
					alert('图形验证码错误!');
					return false;
				}
			},'json');
		}
	}
	function sendmsg(tel,token,obj){
		$.post("{:U('Public/sendmsn')}",{'token':token,'mobile':tel}, function(json){
			if(json.status=='y'){
				settime(obj);
			}else{
				alert(json.message);
				return false;
			}
		},'json');
	}
	var countdown=180;
	function settime(obj) {
		if (countdown == 0) {
			obj.removeAttribute("disabled");
			obj.value="免费获取验证码";
			countdown = 180;
			return;
		} else {
			obj.setAttribute("disabled", true);
			obj.value="重新发送(" + countdown + ")";
			countdown--;
		}
		setTimeout(function() {
				settime(obj) }
			,1000)
	}
</script>
<!--<style>
	.loading{
		width:100%;
		height:100%;
		background:#000;
		display: block;
		z-index: 9999;
	}
</style>
<div class="loading">

</div>-->
</body>
</html>