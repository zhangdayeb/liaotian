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
	
</style>
<body class="bg_fff">
	<header data-am-widget="header"class="am-header am-header-default header nav_bg am-header-fixed">
		<div class="am-header-left am-header-nav">
			<a href="javascript:history.back(-1);" class="">
				<i class="iconfont icon-arrow-left"></i>
			</a>
      	</div>
<!--		<div class="winners_tab am-header-title">
			<em class="active" data-title="0">投注记录</em><em data-title="1">追号记录</em>
		</div>-->
		<h1 class="am-header-title userHome_h1">下单记录</h1>
		<div class="am-header-right am-header-nav">
			<a href="javascript:void(0);" data-am-modal="{target: '#my-actions'}">
				<em class="bill_day">全部</em>
				<i class="iconfont icon-jiantouxia"></i>
			</a>
		</div>
	</header>

	<div data-am-widget="tabs" class=" am-tabs-d2 billrecord_main">
		<ul class="am-tabs-nav am-cf">
			<li <?php if($_GET['a_item']== '1'): ?>class="am-active"<?php endif; ?>><a href="<?php echo U('Member/betRecord',array('a_item'=>1));?>">全部</a></li>
			<li <?php if($_GET['a_item']== '2'): ?>class="am-active"<?php endif; ?>><a href="<?php echo U('Member/betRecord',array('a_item'=>2));?>">已做单</a></li>
			<li <?php if($_GET['a_item']== '3'): ?>class="am-active"<?php endif; ?>><a href="<?php echo U('Member/betRecord',array('a_item'=>3));?>">未做单</a></li>
			<li <?php if($_GET['a_item']== '4'): ?>class="am-active"<?php endif; ?>><a href="<?php echo U('Member/betRecord',array('a_item'=>4));?>">等待数据单</a></li>
		</ul>
		<div class="am-tabs-bd">

			<!--全部-->
			<?php if($_GET['a_item']== '1' or $_GET['a_item']== ''): ?><div data-tab-panel-0 class="am-tab-panel am-active">
				<div data-am-widget="list_news" class="am-list-news am-list-news-default" >
					<div class="am-list-news-bd">
						<ul class="am-list">
							<!-- <?php if(is_array($tzlist)): $i = 0; $__LIST__ = $tzlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="am-g am-list-item-dated">
										<p class="am-cf">
											<span class="what_type am-fl"><?php echo ($vo["expect"]); ?></span>
											<em class="money am-fr">投注金额:<?php echo ($vo["amount"]); ?></em>
										</p>
										<p class="am-cf billrecord_time">
											<span class="am-fl"><?php echo (date("m-d H:i:s",$vo["oddtime"])); ?></span>
											<?php if($vo["isdraw"] == '0'): ?><em class="am-fr"><?php echo ($vo["cptitle"]); ?>(未做单)</em><?php endif; ?>
											<?php if($vo["isdraw"] == '1'): ?><em class="am-fr"><?php echo ($vo["cptitle"]); ?></em><em class="money am-fr" style="margin-right:1em">做单金额:<?php echo ($vo["okamount"]); ?></em><?php endif; ?>
											<?php if($vo["isdraw"] == '-1'): ?><em class="am-fr" style="color:green"><?php echo ($vo["cptitle"]); ?>(未做单)</em><?php endif; ?>
										</p>
									</li><?php endforeach; endif; else: echo "" ;endif; ?>-->
							<?php if(is_array($tzlist)): $i = 0; $__LIST__ = $tzlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="am-g am-list-item-dated">
								<p class="am-cf" style="font-size:14px">
									<span class="what_type am-fl"><?php echo ($vo["cptitle"]); ?>(<?php echo ($vo["expect"]); ?>期)</span>
									<?php if($vo["isdraw"] == '0'): ?><em class="money am-fr" style="color:#666" >未做单</em><?php endif; ?>
									<?php if($vo["isdraw"] == '1'): ?><em class="money am-fr" style="color:red" >已做单</em><?php endif; ?>
									<?php if($vo["isdraw"] == '-1'): ?><em class="money am-fr" style="color:green" >未做单</em><?php endif; ?>
									<?php if($vo["isdraw"] == '-2'): ?><em class="money am-fr" style="color:#666" >已撤单</em><?php endif; ?>

								</p>
								<p class="am-cf billrecord_time" style="font-size:14px">
									<span class="what_type am-fl">任务：<?php echo ($vo["playtitle"]); ?>(<?php echo ($vo["mode"]); ?>)</span>
								</p>
									<p class="am-cf billrecord_time" style="font-size:14px">
									<span class="what_type am-fl">下单内容(<?php echo ($vo["tzcode"]); ?>)</span>
								</p>
								<p class="am-cf billrecord_time" style="font-size:14px">
									<span class="what_type am-fl">单号：<?php echo ($vo["trano"]); ?></span>
								</p>
								<p class="am-cf billrecord_time" style="font-size:14px">
									<span class="what_type am-fl">金额:<?php echo ($vo["amount"]); ?>,注数:<?php echo ($vo["itemcount"]); ?>,做单金:<?php echo ($vo["okamount"]); ?>,做单数:<?php echo ($vo["okcount"]); ?></span>
									<?php if($vo["isdraw"] == '0'): ?><var class="money am-fr" style="color:red; font-style:normal" onClick="Order_chedan('<?php echo ($vo[id]); ?>','<?php echo ($vo[trano]); ?>',this)" >撤单</var><?php endif; ?>

								</p>
							</li><?php endforeach; endif; else: echo "" ;endif; ?> 
						</ul>
					</div>
				</div>
			</div><?php endif; ?>
			<!--已做单-->
			<?php if(($_GET['a_item']) == "2"): ?><div data-tab-panel-1 class="am-tab-active ">
				<div data-am-widget="list_news" class="am-list-news am-list-news-default" >
					<div class="am-list-news-bd">
						<ul class="am-list">
							<?php if(is_array($tzlist)): $i = 0; $__LIST__ = $tzlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($vo['isdraw']) == "1"): ?><li class="am-g am-list-item-dated" style="font-size:14px">
								<p class="am-cf">
									<span class="what_type am-fl"><?php echo ($vo["cptitle"]); ?>(<?php echo ($vo["expect"]); ?>期)</span>
									<?php if($vo["isdraw"] == '0'): ?><em class="money am-fr" style="color:#666" >未做单</em><?php endif; ?>
									<?php if($vo["isdraw"] == '1'): ?><em class="money am-fr" style="color:red" >已做单</em><?php endif; ?>
									<?php if($vo["isdraw"] == '-1'): ?><em class="money am-fr" style="color:green" >未做单</em><?php endif; ?>
								</p>
								<p class="am-cf billrecord_time" style="font-size:14px">
									<span class="what_type am-fl">任务：<?php echo ($vo["playtitle"]); ?>(<?php echo ($vo["mode"]); ?>)</span>
								</p>
									<p class="am-cf billrecord_time" style="font-size:14px">
									<span class="what_type am-fl">下单内容(<?php echo ($vo["tzcode"]); ?>)</span>
								</p>
								<p class="am-cf billrecord_time" style="font-size:14px">
									<span class="what_type am-fl">单号：<?php echo ($vo["trano"]); ?></span>
								</p>
								<p class="am-cf billrecord_time" style="font-size:14px">
									<span class="what_type am-fl">金额:<?php echo ($vo["amount"]); ?>,注数:<?php echo ($vo["itemcount"]); ?>,做单金:<?php echo ($vo["okamount"]); ?>,做单数:<?php echo ($vo["okcount"]); ?></span>
								</p>
							</li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
						</ul>
					</div>
				</div>
			</div><?php endif; ?>
			<!--未做单-->
		<?php if(($_GET['a_item']) == "3"): ?><div data-tab-panel-2 class="am-tab-active ">
				<div data-am-widget="list_news" class="am-list-news am-list-news-default" >
					<div class="am-list-news-bd">
						<ul class="am-list">
							<?php if(is_array($tzlist)): $i = 0; $__LIST__ = $tzlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($vo[isdraw]) == "-1"): ?><li class="am-g am-list-item-dated">
								<p class="am-cf" style="font-size:14px">
									<span class="what_type am-fl"><?php echo ($vo["cptitle"]); ?>(<?php echo ($vo["expect"]); ?>期)</span>
									<?php if($vo["isdraw"] == '0'): ?><em class="money am-fr" style="color:#666" >未做单</em><?php endif; ?>
									<?php if($vo["isdraw"] == '1'): ?><em class="money am-fr" style="color:red" >已做单</em><?php endif; ?>
									<?php if($vo["isdraw"] == '-1'): ?><em class="money am-fr" style="color:green" >未做单</em><?php endif; ?>
								</p>
								<p class="am-cf billrecord_time" style="font-size:14px">
									<span class="what_type am-fl">任务：<?php echo ($vo["playtitle"]); ?>(<?php echo ($vo["mode"]); ?>)</span>
								</p>
									<p class="am-cf billrecord_time" style="font-size:14px">
									<span class="what_type am-fl">下单内容(<?php echo ($vo["tzcode"]); ?>)</span>
								</p>
								<p class="am-cf billrecord_time" style="font-size:14px">
									<span class="what_type am-fl">单号：<?php echo ($vo["trano"]); ?></span>
								</p>
								<p class="am-cf billrecord_time" style="font-size:14px">
									<span class="what_type am-fl">金额:<?php echo ($vo["amount"]); ?>,注数:<?php echo ($vo["itemcount"]); ?>,做单金:<?php echo ($vo["okamount"]); ?>,做单数:<?php echo ($vo["okcount"]); ?></span>
								</p>
							</li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
						</ul>
					</div>
				</div>
			</div><?php endif; ?>
			<!--等待开奖-->
		<?php if(($_GET['a_item']) == "4"): ?><div data-tab-panel-3 class="am-tab-active ">
				<div data-am-widget="list_news" class="am-list-news am-list-news-default" >
					<div class="am-list-news-bd">
						<ul class="am-list">
							<?php if(is_array($tzlist)): $i = 0; $__LIST__ = $tzlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($vo[isdraw]) == "0"): ?><li class="am-g am-list-item-dated">
								<p class="am-cf" style="font-size:14px">
									<span class="what_type am-fl"><?php echo ($vo["cptitle"]); ?>(<?php echo ($vo["expect"]); ?>期)</span>
									<?php if($vo["isdraw"] == '0'): ?><em class="money am-fr" style="color:#666" >未做单</em><?php endif; ?>
									<?php if($vo["isdraw"] == '1'): ?><em class="money am-fr" style="color:red" >已做单</em><?php endif; ?>
									<?php if($vo["isdraw"] == '-1'): ?><em class="money am-fr" style="color:green" >未做单</em><?php endif; ?>
									<?php if($vo["isdraw"] == '-2'): ?><em class="money am-fr" style="color:#666" >已撤单</em><?php endif; ?>
								</p>
								<p class="am-cf billrecord_time" style="font-size:14px">
									<span class="what_type am-fl">任务：<?php echo ($vo["playtitle"]); ?>(<?php echo ($vo["mode"]); ?>)</span>
								</p>
									<p class="am-cf billrecord_time" style="font-size:14px">
									<span class="what_type am-fl">下单内容(<?php echo ($vo["tzcode"]); ?>)</span>
								</p>
								<p class="am-cf billrecord_time" style="font-size:14px">
									<span class="what_type am-fl">单号：<?php echo ($vo["trano"]); ?></span>
								</p>
								<p class="am-cf billrecord_time" style="font-size:14px">
									<span class="what_type am-fl">金额:<?php echo ($vo["amount"]); ?>,注数:<?php echo ($vo["itemcount"]); ?>,做单金:<?php echo ($vo["okamount"]); ?>,做单数:<?php echo ($vo["okcount"]); ?></span>
									<?php if($vo["isdraw"] == '0'): ?><var class="money am-fr" style="color:red; font-style:normal" onClick="Order_chedan('<?php echo ($vo[id]); ?>','<?php echo ($vo[trano]); ?>',this)" >撤单</var><?php endif; ?>
									
								</p>
							</li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
						</ul>
					</div>
				</div>
			</div><?php endif; ?>
			<div class="page text-center green-black"><?php echo ($pageshow); ?></div>
		</div>
	</div>

	<div class="am-modal-actions billrecord_day" id="my-actions">
		<div class="am-modal-actions-group">
			<ul class="am-list">
				<li class="am-modal-actions-header"><a onClick="return getlist(0);">全部</a></li>
				<li class="am-modal-actions-header"><a onClick="return getlist(1);">今天</a></li>
				<li class="am-modal-actions-header"><a onClick="return getlist(2);">昨天</a></li>
				<li class="am-modal-actions-header"><a onClick="return getlist(3);">七天</a></li>
			</ul>
		</div>
		<div class="am-modal-actions-group">
			<button class="am-btn am-btn-secondary am-btn-block btn_red" data-am-modal-close>取消</button>
		</div>
	</div>

	<script>
		function getlist(atime){
            var a_item = "<?php echo ($_GET['a_item']); ?>";
			if(a_item==""){
				a_item =1;
			}
			window.location.href="Member.betRecord.atime."+atime+".a_item."+a_item;
		}
		setTimeout(function () {
			var str = "<?php echo ($_GET['atime']); ?>";
			switch (str){
				case '1':
					$('.bill_day').html('今天');
					break;
				case '2':
					$('.bill_day').html('昨天');
					break;
				case '3':
					$('.bill_day').html('七天');
					break;
				default:
					$('.bill_day').html('全部');


			}
		})
		
			
 
	</script>
</body>
</html>