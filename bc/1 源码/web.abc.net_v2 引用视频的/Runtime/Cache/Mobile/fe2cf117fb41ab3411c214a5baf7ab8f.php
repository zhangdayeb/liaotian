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
    <h1 class="am-header-title userHome_h1">
        安全中心
    </h1>
</header>

<div class="security_h">
    <h4>—— 您的账号安全级别为<?php echo ($aqjibie); ?> ——</h4>
    <p class="security_h_stars">
        <?php
 $num = abs($schedule/100)*10/2; for($i=1;$i<6;$i++){ if($num-$i >= 0){ echo "<i class=\"iconfont icon-favorfill current\"></i>"; }else{ echo "<i class=\"iconfont icon-favorfill\"></i>"; } } ?>
    </p>

    <p class="security_h_time">
        上次登录：<?php echo ($_SESSION['lastlogin']['lasttime']); ?></p>
    <p class="security_h_ress"> IP：<?php echo ($_SESSION['lastlogin']['lastip']); ?>，<?php echo ($_SESSION['lastlogin']['login_address']); ?>  | <a href="<?php echo U('Member/update_pass');?>">不是我登录?</a></p>
</div>

<ul class="my_set_list security_list">
    <li>
        <a href="<?php echo U('Member/update_pass');?>" class="am-cf">
            <span>修改登录密码</span>
            <i class="iconfont icon-arrowright"></i>
            <em class="am-fr security_edit">修改</em>
        </a>
    </li>
    <li>
        <?php  if(empty($userinfo['tradepassword'])){?><a href="<?php echo U('Member/safepass');?>" class="am-cf"><?php }else{?><a href="<?php echo U('Member/update_safepass') ?>" class="am-cf"><?php }?>
            <span><?php  if(empty($userinfo['tradepassword'])){?>未设置资金密码 <?php }else{?>已设置资金密码<?php }?></span>
            <i class="iconfont icon-arrowright"></i>
            <em class="am-fr security_edit"><?php  if(empty($userinfo['tradepassword'])){?>设置<?php }else{?>修改<?php }?></em>
        </a>
    </li>
    <li>
        <a href="<?php echo U('Member/safephone');?>" class="am-cf">
            <span><?php if(($userinfo['tel']) == ""): ?>设置密保手机<?php else: ?>修改密保手机<?php endif; ?></span>
            <i class="iconfont icon-arrowright"></i>
            <em class="am-fr security_edit"><?php if(($userinfo['tel']) == ""): ?>设置<?php else: ?>修改<?php endif; ?></em>
        </a>
    </li>
<!--    <li>
        <a href="<?php if(($userinfo['question']) == ""): echo U('Member/setProblem'); else: echo U('Member/updateProblem'); endif; ?>" class="am-cf">
            <span><?php if(($userinfo['question']) == ""): ?>未设置密保问题<?php else: ?>已设置密保问题<?php endif; ?></span>
            <i class="iconfont icon-arrowright"></i>
            <em class="am-fr security_edit"><?php if(($userinfo['question']) == ""): ?>设置<?php else: ?>修改<?php endif; ?></em>
        </a>
    </li>-->
    <li>
        <a href="<?php echo U('Member/bindmail');?>" class="am-cf">
            <span><?php if(($userinfo['email']) == ""): ?>未设置密保邮箱<?php else: ?>已设置密保邮箱<?php endif; ?></span>
            <i class="iconfont icon-arrowright"></i>
            <em class="am-fr security_edit"><?php if(($userinfo['email']) == ""): ?>设置<?php else: ?>修改<?php endif; ?></em>
        </a>
    </li>
    <li>
        <a href="<?php echo U('Member/bindcard');?>" class="am-cf">
            <span>银行卡管理</span>
            <i class="iconfont icon-arrowright"></i>
            <em class="am-fr security_edit"><?php if(($bankcard) == ""): ?>查看<?php else: ?>添加<?php endif; ?></em>
        </a>
    </li>
</ul>

<!--<div data-am-widget="navbar" class="am-navbar am-cf am-navbar-default bottom_navbar am-no-layout">-->
<!--    <ul class="am-navbar-nav am-cf am-avg-sm-5 my_nav_b" style="overflow: visible;background-color: #1c1e23">-->
<!--        <li style="position: relative;">-->
<!--            <a href="/" class="bottom_navbar_list">-->
<!--            <a href="/Index.index.do" class="bottom_navbar_list mynav1">-->
<!--                <i class="iconfont icon-shouyeshouye1" style="color:#07b39e" style="height: 30px;"></i>-->
<!--                <span class="am-navbar-label">首  页</span>-->
<!--            </a>-->
<!--        </li>-->

<!--        <li style="position: relative;">-->
            <!--            <a href="/" class="bottom_navbar_list">-->
<!--            <a href="/Other.xuanmei.do" class="bottom_navbar_list mynav4">-->
<!--                <i class="iconfont icon-lipin"  style="color:#07b39e" style="height: 30px;"></i>-->
<!--                <span class="am-navbar-label">选 美</span>-->
<!--            </a>-->
<!--        </li>-->

<!--        <li style="position: relative;">-->
<!--            <a href="/Index.lotteryHall.do" class="bottom_navbar_list mynav3">-->
<!--                <i class="iconfont icon-jinbei" style="color:#07b39e"></i>-->
<!--                <span class="am-navbar-label">任务</span>-->
<!--            </a>-->
<!--        </li>-->
<!--        <li style="position: relative;">-->
<!--            <a href="/Member.index.do" class="bottom_navbar_list mynav5">-->
<!--                <i class="iconfont icon-wode" style="color:#07b39e" ></i>-->
<!--                <span class="am-navbar-label">我的</span> -->
<!--            </a>-->
<!--        </li>-->
<!--    </ul>-->
<!--</div>-->
</body>
</html>