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
<body class="bg_fff">
	<header data-am-widget="header"class="am-header am-header-default header nav_bg am-header-fixed">
		<div class="am-header-left am-header-nav">
			<a href="javascript:history.back(-1);" class="">
				<i class="iconfont icon-arrow-left"></i>
			</a>
      	</div>
		<h1 class="am-header-title userHome_h1">
			公告
		</h1>
	</header>
	
	<div class="noticeContent">
		<div class="noticeContent_t">
			<h2><?php echo ($ggshow["title"]); ?></h2>
			<p><?php echo (date("Y-m-d",$ggshow["oddtime"])); ?></p>
		</div>
		<hr />
		<div class="noticeContent_bd">
			<?php echo ($ggshow["content"]); ?>
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
</body>
</html>