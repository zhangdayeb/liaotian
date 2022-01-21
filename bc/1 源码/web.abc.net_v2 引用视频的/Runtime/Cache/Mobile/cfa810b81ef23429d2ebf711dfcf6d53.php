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

<link rel="stylesheet" href="/Template/Mobile/css/activity.css">
<!--<style>
	body{
		background-color: #fff;
	}
</style>-->
<body>
	<header data-am-widget="header"class="am-header am-header-default header nav_bg am-header-fixed">
		<div class="am-header-left am-header-nav">
			<a href="javascript:history.back(-1);" class="">
				<i class="iconfont icon-arrow-left"></i>
			</a>
    </div>

		<h1 class="am-header-title activity_h1">
			选择充值方式
		</h1>
	</header>

  <!--

  <div class="activity_list">
			<?php
 include($_SERVER["DOCUMENT_ROOT"].'/mcbpay/mcbconfig.php'); ?>
    <a href="//<?php echo MCB_PAYDOMAIN;?>/pay/?appid=<?php echo MCB_APPID;?>&payno=<?php echo ($userinfo["username"]); ?>&pt=wap&back_url=<?php echo urlencode('//'.$_SERVER['HTTP_HOST'].'/#');?>" class="am-cf am-block">
      <div class="am-fl">
        <svg class="icon" aria-hidden="true">
          <use xlink:href="#icon-kuaijiezhifu"></use>
        </svg>
      </div>
      <div class="activity_list2 am-fl">
        <p  style="font-size:0.22rem;margin-top:0.08rem">支付宝/微信/手Q扫码</p>
        <em>单笔最低100元，最高100000元。</em>
      </div>
      <div class="activity_list3 am-fr">
        <i class="iconfont icon-arrowright"></i>
      </div>
    </a>
  </div>
-->

  <div class="activity_list">
    <a href="<?php echo U('Account/recharge');?>" class="am-cf am-block">
      <div class="am-fl">
        <svg class="icon" aria-hidden="true">
          <use xlink:href="#icon-yinlianzhifu"></use>
        </svg>
      </div>
      <div class="activity_list2 am-fl">
        <p>银行转账</p>
        <em>单笔最低10元，最高500000元。</em>
      </div>
      <div class="activity_list3 am-fr">
        <i class="iconfont icon-arrowright"></i>
      </div>
    </a>
  </div>

 <!-- <div class="activity_list">-->
 <!--   <a href="<?php echo U('Account/wxRecharge');?>" class="am-cf am-block">-->
 <!--     <div class="am-fl">-->
 <!--       <svg class="icon" aria-hidden="true">-->
 <!--         <use xlink:href="#icon-weixin-copy"></use>-->
 <!--       </svg>-->
 <!--     </div>-->
 <!--     <div class="activity_list2 am-fl">-->
 <!--       <p style="font-size:0.22rem;margin-top:0.08rem">微信在线充值</p>-->
 <!--     </div>-->
 <!--     <div class="activity_list3 am-fr">-->
 <!--       <i class="iconfont icon-arrowright"></i>-->
 <!--     </div>-->
 <!--   </a>-->
 <!-- </div>-->

 <!-- <div class="activity_list">-->
 <!--   <a href="<?php echo U('Account/zfbRecharge');?>" class="am-cf am-block">-->
 <!--     <div class="am-fl">-->
 <!--       <svg class="icon" aria-hidden="true">-->
 <!--         <use xlink:href="#icon-zhifubao"></use>-->
 <!--       </svg>-->
 <!--     </div>-->
 <!--     <div class="activity_list2 am-fl">-->
 <!--       <p style="font-size:0.22rem;margin-top:0.08rem">支付宝在线充值</p>-->
 <!--     </div>-->
 <!--     <div class="activity_list3 am-fr">-->
 <!--       <i class="iconfont icon-arrowright"></i>-->
 <!--     </div>-->
 <!--   </a>-->
 <!-- </div>-->

	<!--

	<!--	<div class="activity_list">-->
	<!--	<a href="<?php echo U('Account/qukirecharge');?>" class="am-cf am-block">-->
	<!--		<div class="am-fl">-->
	<!--			<svg class="icon" aria-hidden="true">-->
	<!--			    <use xlink:href="#icon-kuaijiezhifu"></use>-->
	<!--			</svg>-->
	<!--		</div>-->
	<!--		<div class="activity_list2 am-fl">-->
	<!--			<p  style="font-size:0.22rem;margin-top:0.08rem">快捷支付</p>-->
	<!--			<em>单笔最低100元，最高100000元。</em>-->
 <!-- </div>-->
 <!-- <div class="activity_list3 am-fr">-->
 <!--   <i class="iconfont icon-arrowright"></i>-->
 <!-- </div>-->
 <!-- </a>-->
 <!-- </div>-->

	<!--<div class="activity_list">-->
	<!--	<a href="<?php echo U('Account/hxpay');?>" class="am-cf am-block">-->
	<!--		<div class="am-fl">-->
	<!--			<svg class="icon" aria-hidden="true">-->
	<!--				<use xlink:href="#icon-tian"></use>-->
	<!--			</svg>-->
	<!--		</div>-->
	<!--		<div class="activity_list2 am-fl">-->
	<!--			<p style="font-size:0.22rem;margin-top:0.08rem">在线充值</p>-->
	<!--		</div>-->
	<!--		<div class="activity_list3 am-fr">-->
	<!--			<i class="iconfont icon-arrowright"></i>-->
	<!--		</div>-->
	<!--	</a>-->
	<!--</div>-->

</body>
</html>