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
	<div class="winners_tab am-header-title">
		<em data-title="1" class="active">??????</em>
	</div>
</header>
<div data-am-widget="tabs" class="am-tabs am-tabs-d2 billrecord_main">
	<div class="am-tabs-bd">
		<div class="am-tab-panel am-active">
			<div data-am-widget="list_news" class="am-list-news am-list-news-default" >
				<div class="am-list-news-bd">
					<ul class="am-list">
						<?php if(is_array($res)): $i = 0; $__LIST__ = $res;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="am-g am-list-item-dated">
								<a href="<?php echo U('Member/Message_show',array('id'=>$vo['bid']));?>">
									<p class="am-cf">
										 <?php if($vo['isyd'] == '0'): ?><span style="color:red;font-size: 8px;">(??????)</span><?php endif; ?><span class="what_type am-fl"><?php echo ($vo[Title]); ?></span>
									</p>
									<p class="am-cf billrecord_time">
										<span class="am-fl"><?php echo (date('Y-m-d',$vo[PDate])); ?></span>
									</p>
								</a>
							</li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul> <div class="pageNav l" style="padding:0"><?php echo ($page); ?></div>
				</div>
			</div>

		</div>
	</div>
</div>

<div  class="am-tabs am-tabs-d2 billrecord_main isplay_no">
	<p style="text-align:center;">????????????</p>
</div>

</body>
</html>