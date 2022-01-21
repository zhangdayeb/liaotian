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

<style>
	body{
		background-color: #fff;}
</style>
<link rel="stylesheet" href="/Template/Mobile/css/userHome.css">
<body>
	<header data-am-widget="header"class="am-header am-header-default header nav_bg am-header-fixed">
		<div class="am-header-left am-header-nav">
			<a href="javascript:history.back(-1);" class="">
				<i class="iconfont icon-arrow-left"></i>
			</a>
      	</div>
		<div class="winners_tab am-header-title">
			<em class="active" data-title="0">个人资料</em><?php if(($userinfo['proxy']) == "0"): ?><em data-title="1">等级头衔</em><?php endif; ?>
		</div>
	</header>
	<div class="personalInfo1 personalInfo">
		<form class="am-form register_form" method="post" url="" checkby_ruivalidate id="register_form" onsubmit="return checkform(this)">
			<ul class="my_set_list personalInfo_top margin_0">
				 <input type="hidden" class="faceinput" style="width: 700px" name="info[face]" value="<?php echo ($userinfo['face']); ?>" />
				<li class="am-cf am-vertical-align special faceimg" data-am-modal="{target: '#my-actions'}">
					<i class="iconfont icon-arrowright"></i>
					<img class="am-fr padding_lr_5 personalInfo_header am-radius" src="<?php echo ($userinfo['face']); ?>" style="float:right;" alt="">
					<span style="width:90%;">头像<a href="###" style="font-size: 0.9em;color:#ccc !important;float:right;">点击修改头像</a></span>
				</li>
<!--		 <li class="am-cf">
					<span>昵称</span>
					<i class="iconfont icon-arrowright"></i>
					<input type="text" value="<?php echo ($userinfo["username"]); ?>" class="personalInfo_input am-fr padding_lr_5" placeholder="请设置昵称">
				</li>-->
				<li class="am-cf" style="border-bottom:1px solid #ccc">
					<span>账号</span>
					<i class="iconfont icon-arrowright"></i>
					<em class="personalInfo_text am-fr padding_lr_5"><?php echo ($userinfo["username"]); ?></em>
				</li>
			</ul>
			<ul class="my_set_list personalInfo_top margin_0" >
				<li class="am-cf " >
					<span>真实姓名</span>
					<i class="iconfont icon-arrowright"></i>
					<em class="personalInfo_text am-fr padding_lr_5">
						<!-- <?php if(empty($userinfo['userbankname'])){echo "去绑定";}else{ echo substr_replace($userinfo['userbankname'],'****',3,4);}?> -->
						<?php if(($userinfo['userbankname']) == ""): ?><a href="<?php echo U('Account/userbankname');?>">去绑定</a><?php else: ?><a href="<?php echo U('Account/userbankname');?>"><?php echo (substr_replace($userinfo['userbankname'],'*',3,3)); ?></a><?php endif; ?>
					</em>
				</li>
				<li class="am-cf " >
					<span>手机</span>
					<i class="iconfont icon-arrowright"></i>
					<em class="personalInfo_text am-fr padding_lr_5">
					<!-- <?php if(empty($userinfo['tel'])){echo "去绑定";}else{ echo substr_replace($userinfo['tel'],'****',3,4);}?> -->
<?php if(($userinfo['tel']) == ""): ?><a href="<?php echo U('Member/safephone');?>">去绑定</a><?php else: ?><a href="<?php echo U('Member/safephone');?>"><?php echo (substr_replace($userinfo['tel'],'****',3,4)); ?></a><?php endif; ?>
					</em>
				</li>
				<li class="am-cf">
					<span>邮箱</span>
					<i class="iconfont icon-arrowright"></i>
					<em class="personalInfo_text am-fr padding_lr_5">
						<?php if(($userinfo['email']) == ""): ?><a href="<?php echo U('Member/bindmail');?>">去绑定</a><?php else: ?><a href="<?php echo U('Member/bindmail');?>"><?php echo (substr_replace($userinfo['email'],'****',3,4)); ?></a><?php endif; ?>
					</em>
				</li>
				<li class="am-cf">
					<span>QQ</span>
					<i class="iconfont icon-arrowright"></i>
			       			        <input type="text" name="info[setqq]" id="setqq" value="<?php if(!empty($userinfo[qq])): echo (substr_replace($userinfo['qq'],'******',0,4)); endif; ?>" class="personalInfo_input am-fr padding_lr_5" autocomplete="on" style="width:50%;border:none;" onblur="yzqq(this)" onfocus="rego(this);"  placeholder="请设置QQ号码" />

					<input type="hidden" name="info[qq]" id="qq" value="<?php echo ($userinfo['qq']); ?>" />
					<script>
						var v  = document.getElementById("setqq").value;
						var qq = document.getElementById("qq");
						var v2 = qq.value;
						function rego(obj) {
							obj.value="";
						}
						function yzqq(obj) {
							if(obj.value==""){
							   obj.value = v;
							   document.getElementById("qq").value=v2;
							}else{
								pattern="[1-9][0-9]{4,14}";
								var fag = obj.value.match(pattern);
								if(fag==null){
									alert('请输入正确的QQ号码');
									obj.value = v;
									document.getElementById("qq").value= v2;
									return false;
								}else{
									document.getElementById("qq").value=obj.value;
								}
							}
						}
					</script>
				</li>
				<!--<li class="am-cf">
					<span>性别</span>
					<i class="iconfont icon-arrowright"></i>
					<div class="am-form-group am-fr sex">
						<select id="doc-select-1">
							<option value="1" >男</option>
							<option value="0"  >女</option>
							<option value="2" >保密</option>
						</select>
					</div>
				</li>
				<li class="am-cf">
					<span>生日</span>
					<i class="iconfont icon-arrowright"></i>
					<div class="am-input-group am-datepicker-date am-fr" data-am-datepicker="<?php echo ($userinfo['birthday']); ?>">
					  	<input name="info[birthday]" style="background:none;" type="text" class="am-form-field am-datepicker-add-on"  value="<?php echo ($userinfo['birthday']); ?>" readonly="readonly">
					</div>
				</li>-->
			</ul>

			<button type="submit" class="am-btn am-btn-danger am-btn-block am-radius btn_red personalInfo_sbumit">提交</button>
		</form>
	</div>

	<div class="personalInfo2 personalInfo">
		<div class="personalInfo2_box">
			<div class="personalInfo2_h">
				<div class="am-cf personalInfo2_t">
					<div class="img am-fl">
						<img class="am-circle" src="<?php echo ($userinfo["face"]); ?>" alt="头像">
					</div>
					<div class="am-fl user_name_box">
						<p><strong class="user_name"><?php echo ($userinfo["username"]); ?></strong> <span class="user_vip">&nbsp;&nbsp;<?php echo ($userinfo["groupname"]); ?></span></p>
						<p><span class="user_grade">头衔：<?php echo ($userinfo["touhan"]); ?> </span><em class="user_fraction"> 成长值<?php echo ($userinfo["point"]); ?>分</em></p>
					</div>
				</div>
				<div class="personalInfo2_b">
					<p class="am-text-center">
						<?php switch($userinfo["groupid"]): case "1": ?>距离下一级还要<?php echo (abs($userinfo['point']-1000)); ?>分<?php break;?>
							<?php case "2": ?>距离下一级还要<?php echo (abs($userinfo['point']-2000)); ?>分<?php break;?>
							<?php case "3": ?>距离下一级还要<?php echo (abs($userinfo['point']-5000)); ?>分<?php break; endswitch;?>
						         每充值1元加1分</p>
					<div class="y_progress">
						<em class="y_progress_l"><?php echo ($userinfo["groupname"]); ?></em>
						<div class="am-progress am-inline-block" style="height:14px;">
							<?php switch($userinfo["groupid"]): case "1": ?><div class="am-progress-bar" style="width:<?php echo (round($userinfo['point']/$GROUPMSG[1]['shengjiedu']*100,2)); ?>% !important;"><?php echo (round($userinfo['point']/$GROUPMSG[1]['shengjiedu']*100,2)); ?>%</div><?php break;?>
								<?php case "2": ?><div class="am-progress-bar" style="width:<?php echo (round($userinfo['point']/$GROUPMSG[2]['shengjiedu']*100,2)); ?>% !important;"><?php echo (round($userinfo['point']/$GROUPMSG[2]['shengjiedu']*100,2)); ?>%</div><?php break;?>
								<?php case "3": ?><div class="am-progress-bar" style="width:<?php echo (round($userinfo['point']/$GROUPMSG[3]['shengjiedu']*100,2)); ?>% !important;"><?php echo (round($userinfo['point']/$GROUPMSG[3]['shengjiedu']*100,2)); ?>%</div><?php break;?>
								<?php case "4": ?><div class="am-progress-bar" style="width:<?php echo (round($userinfo['point']/$GROUPMSG[4]['shengjiedu']*100,2)); ?>% !important;"><?php echo (round($userinfo['point']/$GROUPMSG[4]['shengjiedu']*100,2)); ?>%</div><?php break;?>
								<?php case "5": ?><div class="am-progress-bar" style="width:<?php echo (round($userinfo['point']/$GROUPMSG[5]['shengjiedu']*100,2)); ?>% !important;"><?php echo (round($userinfo['point']/$GROUPMSG[5]['shengjiedu']*100,2)); ?>%</div><?php break;?>
								<?php case "6": ?><div class="am-progress-bar" style="width:<?php echo (round($userinfo['point']/$GROUPMSG[6]['shengjiedu']*100,2)); ?>% !important;"><?php echo (round($userinfo['point']/$GROUPMSG[6]['shengjiedu']*100,2)); ?>%</div><?php break;?>
								<?php case "7": ?><div class="am-progress-bar" style="width:<?php echo (round($userinfo['point']/$GROUPMSG[7]['shengjiedu']*100,2)); ?>% !important;"><?php echo (round($userinfo['point']/$GROUPMSG[7]['shengjiedu']*100,2)); ?>%</div><?php break;?>
								<?php case "8": ?><div class="am-progress-bar" style="width:<?php echo (round($userinfo['point']/$GROUPMSG[8]['shengjiedu']*100,2)); ?>% !important;"><?php echo (round($userinfo['point']/$GROUPMSG[8]['shengjiedu']*100,2)); ?>%</div><?php break;?>
								<?php case "8": ?><div class="am-progress-bar" style="width:100% !important;">100%</div><?php break;?>
								<?php default: ?>
								<div class="am-progress-bar" style=	"width:0% !important;">0%</div><?php endswitch;?>

						</div>
						<?php switch($userinfo["groupid"]): case "1": ?><em class="y_progress_l"><?php echo ($GROUPMSG[1]['groupname']); ?></em><?php break;?>
							<?php case "2": ?><em class="y_progress_l"><?php echo ($GROUPMSG[2]['groupname']); ?></em><?php break;?>
							<?php case "3": ?><em class="y_progress_l"><?php echo ($GROUPMSG[3]['groupname']); ?></em><?php break;?>
							<?php case "4": ?><em class="y_progress_l"><?php echo ($GROUPMSG[4]['groupname']); ?></em><?php break;?>
							<?php case "5": ?><em class="y_progress_l"><?php echo ($GROUPMSG[5]['groupname']); ?></em><?php break;?>
							<?php case "6": ?><em class="y_progress_l"><?php echo ($GROUPMSG[6]['groupname']); ?></em><?php break;?>
							<?php case "7": ?><em class="y_progress_l"><?php echo ($GROUPMSG[7]['groupname']); ?></em><?php break;?>
							<?php case "8": ?><em class="y_progress_l"><?php echo ($GROUPMSG[8]['groupname']); ?></em><?php break;?>
							<?php default: ?>default<?php endswitch;?>
					</div>
				</div>
			</div>
			<div class="personalInfo2_f">
				<div class="personalInfo2_h2">
					<i class="iconfont icon-wenhao1"></i>
					<h2 class="am-inline-block">等级机制</h2>
				</div>
				<table class="am-table am-table-bordered">
					<thead>
						<tr>
							<th>等级</th>
							<th>头衔</th>
							<th>成长积分</th>
						</tr>
					</thead>
					<tbody>
					<?php if(is_array($GROUPMSG)): $key = 0; $__LIST__ = $GROUPMSG;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($key % 2 );++$key; if($value["groupname"] != '普通代理'): ?><tr>
							<td class="am-text-left" style="padding-left:15%;"><?php echo ($value["groupname"]); ?></td>
							<td><?php echo ($value["touhan"]); ?></td>
							<td> <!--<?php if(($value['shengjiedu']) == "申请"): ?><a href="###">申请</a><?php else: ?>--><?php echo ($value["shengjiedu"]); ?><!--<?php endif; ?>--></td>
						</tr><?php endif; endforeach; endif; else: echo "" ;endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<script>
		function checkform(obj){
			$.post($(obj).attr('action'),$(obj).serialize(), function(json){
				if(json.status==1){
					alert(json.info);
					window.location.reload();
				}else{
					alert(json.info);
				};
			},'json');
			return false;
		};
	</script>
</body>
</html>