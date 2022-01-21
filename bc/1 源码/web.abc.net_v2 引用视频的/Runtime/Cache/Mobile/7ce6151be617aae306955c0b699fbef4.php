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
<style>
	body{
		background-color: #fff;
	}
</style>
<body>
	<header data-am-widget="header"class="am-header am-header-default header nav_bg am-header-fixed">
		<div class="am-header-left am-header-nav">
			<a href="javascript:history.back(-1);" class="">
				<i class="iconfont icon-arrow-left"></i>
			</a>
      	</div>

		<h1 class="am-header-title activity_h1">
			提现
		</h1>

	</header>
	
	<div class="bank_recharge tankMoney_main">
		<form class="am-form " method="post" action="<?php echo U('Apijiekou/savetikuanorder');?>" url="" checkby_ruivalidate id="register_form"  onsubmit="return checkform(this)" >
 			<ul class="bank_form_list">
				<li class="am-cf">
					<span class="bank_form_left am-fl">持卡人姓名</span>
					<div class="am-fr bank_right_input">
						<?php echo ($_SESSION['userinfo']['userbankname']); ?>
					</div>
				</li>
				<li class="am-cf">
					<span class="bank_form_left am-fl">账户余额</span>
					<div class="am-fr bank_right_input">
						<input type="text" value="<?php echo ($userinfo["balance"]); ?>" class="take_balance" disabled="disabled">
					</div>
				</li>
				<li class="am-cf">
					<span class="bank_form_left am-fl">可提现金</span>
					<div class="am-fr bank_right_input">
						<input type="text" value="<?php echo ($userinfo["balance"]); ?>" class="take_balance" disabled="disabled">
					</div>
				</li>
				<li class="am-cf">
					<span class="bank_form_left am-fl">提现账户</span>

					<div class="am-fr bank_right_input selected_bank">
						<?php if(is_array($banklist)): $v = 0; $__LIST__ = $banklist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($v % 2 );++$v; if($vo['state'] == 1): ?><img src="/resources/images/bank/<?php echo ($vo["banklogo"]); ?>" style="float: left;margin-top: 10px;width:30px;"  />
								<div class="bank_info">
									<em class="bank-name"><?php echo ($vo["bankname"]); ?></em>
									<em>**********<span class="bank-sum"><?php echo (substr($vo["_banknumber"],-5)); ?></span></em>
								</div>
								<i class="iconfont icon-jiantouxia"></i><?php endif; endforeach; endif; else: echo "" ;endif; ?>
					</div>

					<ul class="bank_list_box bank_right_input">
						<?php if(is_array($banklist)): $v = 0; $__LIST__ = $banklist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($v % 2 );++$v;?><li class="bank_list" data-bank-icon="/resources/images/bank/<?php echo ($vo["banklogo"]); ?>" data-bank-name="<?php echo ($vo["bankname"]); ?>" data-bank-sum="<?php echo (substr($vo["_banknumber"],-5)); ?>">
 							<?php if(($vo['state']) == "1"): ?><input type="radio"  name="bankid" class="isplay_no" value="<?php echo ($vo["id"]); ?>" checked="checked">
								<?php else: ?>
								<input type="radio"  name="bankid" value="<?php echo ($vo["id"]); ?>" class="isplay_no" ><?php endif; ?>
							<img src="/resources/images/bank/<?php echo ($vo["banklogo"]); ?>" style="float: left;margin-top: 10px;width:30px;"  />
 							<div class="bank_info">
								<em><?php echo ($vo["bankname"]); ?></em>
								<em><?php echo (substr($vo["_banknumber"],-5)); ?></em>
							</div>
						</li><?php endforeach; endif; else: echo "" ;endif; ?>

						<li>请选择你要提现的银行卡</li>
					</ul>
				</li>
				<li class="am-cf">
					<span class="bank_form_left am-fl">提现金额</span>
					<div class="am-fr bank_right_input">
						<input type="text" name="amount"  class="input_txt" value="10" placeholder="提款金额至少10元" >
					</div>
				</li>
				<li class="am-cf">
					<span class="bank_form_left am-fl">资金密码</span>
					<div class="am-fr bank_right_input">
						<input type="password"  class="input_txt" name="withdraw_pwd" placeholder="请输入您的资金密码">
					</div>
				</li>
			</ul>

			<button class="am-btn am-btn-danger am-radius am-btn-block" type="submit">确定</button>
		</form>	
		<div class="bottom_explain">
			<p>今天还可以提现<em data-tkcount><?php echo ($count); ?></em>次</p>
			<!--<p>可提现金额=有效投注×3(此项需达到充值金额的30%才计入)+奖金+活动礼金</p>-->
			<p>单笔提现最低<em>10</em>元，最高<em>2000000</em>元</p>
		</div>
	</div>
		<?php $a=1; $b=2; $c=3; $d=4; if(strstr($_SERVER['REQUEST_URI'],"Activity")) { $c='33'; } else if(strstr($_SERVER['REQUEST_URI'],"betRecord")) { $b='22'; } else if(strstr($_SERVER['REQUEST_URI'],"Member")) { $d='44'; }else{ $a='11'; } ?>
<div data-am-widget="navbar" class="am-navbar am-cf am-navbar-default bottom_navbar am-no-layout">
    <ul class="am-navbar-nav am-cf am-avg-sm-5 my_nav_b" style="overflow: visible;background-color: #D9006C">
        <li style="position: relative;">
<!--            <a href="/" class="bottom_navbar_list">-->
            <a href="/Index.index.do" class="bottom_navbar_list mynav1">
                <i class="iconfont icon-shouyeshouye1" style="color:#07b39e" style="height: 30px;"></i>
                <span class="am-navbar-label">首  页</span>
            </a>
        </li>

        <li style="position: relative;">
            <!--            <a href="/" class="bottom_navbar_list">-->
            <a href="/Other.xuanmei.do" class="bottom_navbar_list mynav4">
                <i class="iconfont icon-lipin"  style="color:#07b39e" style="height: 30px;"></i>
                <span class="am-navbar-label">选 美</span>
            </a>
        </li>

        <li style="position: relative;">
            <a href="/Index.lotteryHall.do" class="bottom_navbar_list mynav3">
                <i class="iconfont icon-jinbei" style="color:#07b39e"></i>
                <span class="am-navbar-label">任务</span>
            </a>
        </li>
        <li style="position: relative;">
            <a href="/Member.index.do" class="bottom_navbar_list mynav5">
                <i class="iconfont icon-wode" style="color:#07b39e" ></i>
                <span class="am-navbar-label">我的</span> 
            </a>
        </li>
    </ul>
    
</div>
<script>	
var cpname="<?php echo I('code');?>"; 
function Order_chedan(id,trano,obj){
				artDialog({
					content:'确定撤单吗',
					cancel:function(){},
					ok:function(){
					$.post('/Apijiekou.chedan',{'id':id,'trano':trano}, function(json){
							if(json.sign==true){
							 
								art.dialog({
									time: 2,
									content:'撤单成功',
									lock:true
								});
								$(obj).html('<span style="color:grey">已撤单</span>');
							}else{
								alt(json.message);
							}
						},'json'); 

					},
					lock:true
				})
				
	};</script>
	<script>
		function checkform(obj){
			$.post($(obj).attr('action'),$(obj).serialize(), function(json){
				if(json.sign){
					alert(json.message,'success');
					var tkcount = $("[data-tkcount]").text()/1;
					tkcount = tkcount-1;
					if(tkcount<=0){
						tkcount = 0;
					}
					$("[data-tkcount]").text(tkcount);
					window.location.reload();
				}else{
					alert(json.message);
				};
			},'json');
			return false;
		};
	</script>
</body>
</html>