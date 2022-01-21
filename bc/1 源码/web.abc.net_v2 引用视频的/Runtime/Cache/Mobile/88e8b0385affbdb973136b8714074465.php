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

<body>
	<header data-am-widget="header"class="am-header am-header-default header nav_bg am-header-fixed">
		<div class="am-header-left am-header-nav">
			<a href="javascript:history.back(-1);" class="">
				<i class="iconfont icon-arrow-left"></i>
			</a>
    </div>
		<h1 class="am-header-title activity_h1">
			全部活动
		</h1>
	</header>
	 <!--div data-am-widget="tabs" class="am-tabs am-tabs-default" style="margin: 0;">
      <ul class="am-tabs-nav am-cf" style="background: #000;overflow: auto;overflow-y: hidden;">
          <li class="am-active"><a href="[data-tab-panel-0]">
						<i class="iconfont icon-quanbu"></i>
						午夜约吧</a></li>
      <!--    <li class=""><a href="[data-tab-panel-1]">-->
						<!--<i class="iconfont icon-fucaikuai3"></i>-->
						<!--午夜约吧</a></li>-->
    <!--      <li class=""><a href="[data-tab-panel-2]">-->
				<!--		<i class="iconfont icon--shishicai"></i>-->
				<!--		时时彩</a></li>-->
				<!--	<li class=""><a href="[data-tab-panel-3]">-->
				<!--		<i class="iconfont icon-kuaile8"></i>-->
				<!--		快乐彩</a></li>-->
		  <!--<li class=""><a href="[data-tab-panel-4]">-->
				<!--  <i class="iconfont icon-kuaile8"></i>-->
				<!--  PK10</a></li>-->
    <!--      <li class=""><a href="[data-tab-panel-5]">-->
				<!--		<i class="iconfont icon-11xuan5"></i>-->
				<!--		11选5</a></li>-->
				<!--	<li class=""><a href="[data-tab-panel-6]">-->
				<!--		<i class="iconfont icon-pailie3"></i>-->
				<!--		低频彩</a></li>-->
		  <!--<li class=""><a href="[data-tab-panel-6]">-->
				<!--  <i class="iconfont" style="color:#07b39e">&#xe65a;</i>-->
				<!--  六合彩</a></li>-->
      </ul>
      <div class="am-tabs-bd">
          <div data-tab-panel-0 class="am-tab-panel am-active">
            <ul class="home_main am-avg-sm-3">
				<?php if(is_array($cplist)): $i = 0; $__LIST__ = $cplist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cp): $mod = ($i % 2 );++$i; if(($cp["typeid"]) == "pk10"): ?><li class="home_main_list">
												<a href="/Game.old<?php echo ($cp["typeid"]); ?>.code.<?php echo ($cp["name"]); ?>.do">
													<img src="/icon/<?php echo ($cp[name]); ?>.png" style="height:43px;with:40px;main-right:12px;margin-left:3px;">
												</a>
													<h4><?php echo ($cp["title"]); ?></h4>
													<em><?php echo ($cp["ftitle"]); ?></em>
											</li><?php endif; ?>
					<?php if(($cp["typeid"]) == "ssc"): ?><li class="home_main_list">
												<a href="/Game.old<?php echo ($cp["typeid"]); ?>.code.<?php echo ($cp["name"]); ?>.do">
													<img src="/icon/<?php echo ($cp[name]); ?>.png" style="height:43px;with:40px;main-right:12px;margin-left:3px;">
												</a>
													<h4><?php echo ($cp["title"]); ?></h4>
													<em><?php echo ($cp["ftitle"]); ?></em>
											</li><?php endif; ?>
										
				
					 <!--li class="home_main_list">
						
						      <a href="/Game.<?php echo ($cp["typeid"]); ?>?code=<?php echo ($cp["name"]); ?>">
							  <img src="/icon/<?php echo ($cp[name]); ?>.png" style="height:43px;with:40px;main-right:12px;margin-left:3px;">
							  </a>
							
							<h3><?php echo ($cp["title"]); ?></h3>
							<em><?php echo ($cp["ftitle"]); ?></em>
					</li-->
					
					<?php if(($cp["typeid"]) == "k3"): ?><li class="home_main_list">
												<a href="/Game.<?php echo ($cp["typeid"]); ?>.code.<?php echo ($cp["name"]); ?>.do">
													<img src="/icon/<?php echo ($cp[name]); ?>.png" style="height:43px;with:40px;main-right:12px;margin-left:3px;">
												</a>
													<h3><?php echo ($cp["title"]); ?></h3>
													<em><?php echo ($cp["ftitle"]); ?></em>
											</li><?php endif; ?>
										
										<?php if(($cp["typeid"]) == "keno"): ?><li class="home_main_list">
												<a href="/Game.<?php echo ($cp["typeid"]); ?>.code.<?php echo ($cp["name"]); ?>.do">
													<img src="/icon/<?php echo ($cp[name]); ?>.png" style="height:43px;with:40px;main-right:12px;margin-left:3px;">
												</a>
													<h3><?php echo ($cp["title"]); ?></h3>
													<em><?php echo ($cp["ftitle"]); ?></em>
											</li><?php endif; ?>
										
										<?php if(($cp["typeid"]) == "x5"): ?><li class="home_main_list">
												<a href="/Game.<?php echo ($cp["typeid"]); ?>.code.<?php echo ($cp["name"]); ?>.do">
													<img src="/icon/<?php echo ($cp[name]); ?>.png" style="height:43px;with:40px;main-right:12px;margin-left:3px;">
												</a>
													<h3><?php echo ($cp["title"]); ?></h3>
													<em><?php echo ($cp["ftitle"]); ?></em>
											</li><?php endif; ?>
										<?php if(($cp["typeid"]) == "dpc"): ?><li class="home_main_list">
												<a href="/Game.<?php echo ($cp["typeid"]); ?>.code.<?php echo ($cp["name"]); ?>.do">
													<img src="/icon/<?php echo ($cp[name]); ?>.png" style="height:43px;with:40px;main-right:12px;margin-left:3px;">
												</a>
													<h3><?php echo ($cp["title"]); ?></h3>
													<em><?php echo ($cp["ftitle"]); ?></em>
											</li><?php endif; ?>
										<?php if(($cp["typeid"]) == "lhc"): ?><li class="home_main_list">
												<a href="/Game.<?php echo ($cp["typeid"]); ?>.code.<?php echo ($cp["name"]); ?>.do">
													<img src="/icon/<?php echo ($cp[name]); ?>.png" style="height:43px;with:40px;main-right:12px;margin-left:3px;">
												</a>
													<h3><?php echo ($cp["title"]); ?></h3>
													<em><?php echo ($cp["ftitle"]); ?></em>
											</li><?php endif; endforeach; endif; else: echo "" ;endif; ?>

				</ul>
					</div>
          <div data-tab-panel-1 class="am-tab-panel ">
								<ul class="home_main am-avg-sm-3">
									<?php if(is_array($cplist2)): $i = 0; $__LIST__ = $cplist2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cp): $mod = ($i % 2 );++$i; if(($cp["typeid"]) == "k3"): ?><li class="home_main_list">
												<a href="/Game.<?php echo ($cp["typeid"]); ?>.code.<?php echo ($cp["name"]); ?>.do">
													<img src="/icon/<?php echo ($cp[name]); ?>.png" style="height:43px;with:40px;main-right:12px;margin-left:3px;">
												</a>
													<h3><?php echo ($cp["title"]); ?></h3>
													<em><?php echo ($cp["ftitle"]); ?></em>
											</li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
								</ul>
          </div>
          <div data-tab-panel-2 class="am-tab-panel ">
            <ul class="home_main am-avg-sm-3">
				<?php if(is_array($cplist2)): $i = 0; $__LIST__ = $cplist2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cp): $mod = ($i % 2 );++$i; if(($cp["typeid"]) == "ssc"): ?><li class="home_main_list">
												<a href="/Game.old<?php echo ($cp["typeid"]); ?>.code.<?php echo ($cp["name"]); ?>.do">
													<img src="/icon/<?php echo ($cp[name]); ?>.png" style="height:43px;with:40px;main-right:12px;margin-left:3px;">
												</a>
													<h3><?php echo ($cp["title"]); ?></h3>
													<em><?php echo ($cp["ftitle"]); ?></em>
											</li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
			 </ul>
          </div>
		 <div data-tab-panel-3 class="am-tab-panel">
            <ul class="home_main am-avg-sm-3">
				<?php if(is_array($cplist2)): $i = 0; $__LIST__ = $cplist2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cp): $mod = ($i % 2 );++$i; if(($cp["typeid"]) == "keno"): ?><li class="home_main_list">
												<a href="/Game.<?php echo ($cp["typeid"]); ?>.code.<?php echo ($cp["name"]); ?>.do">
													<img src="/icon/<?php echo ($cp[name]); ?>.png" style="height:43px;with:40px;main-right:12px;margin-left:3px;">
												</a>
													<h3><?php echo ($cp["title"]); ?></h3>
													<em><?php echo ($cp["ftitle"]); ?></em>
											</li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
				 </ul>
			 </div>
		  <div data-tab-panel-4 class="am-tab-panel">
			  <ul class="home_main am-avg-sm-3">
				  <?php if(is_array($cplist2)): $i = 0; $__LIST__ = $cplist2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cp): $mod = ($i % 2 );++$i; if(($cp["typeid"]) == "pk10"): ?><li class="home_main_list">
												<a href="/Game.old<?php echo ($cp["typeid"]); ?>.code.<?php echo ($cp["name"]); ?>.do">
													<img src="/icon/<?php echo ($cp[name]); ?>.png" style="height:43px;with:40px;main-right:12px;margin-left:3px;">
												</a>
													<h3><?php echo ($cp["title"]); ?></h3>
													<em><?php echo ($cp["ftitle"]); ?></em>
											</li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
			  </ul>
		  </div>
		  <div data-tab-panel-5 class="am-tab-panel">
			  <ul class="home_main am-avg-sm-3">
				  <?php if(is_array($cplist2)): $i = 0; $__LIST__ = $cplist2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cp): $mod = ($i % 2 );++$i; if(($cp["typeid"]) == "x5"): ?><li class="home_main_list">
												<a href="/Game.<?php echo ($cp["typeid"]); ?>.code.<?php echo ($cp["name"]); ?>.do">
													<img src="/icon/<?php echo ($cp[name]); ?>.png" style="height:43px;with:40px;main-right:12px;margin-left:3px;">
												</a>
													<h3><?php echo ($cp["title"]); ?></h3>
													<em><?php echo ($cp["ftitle"]); ?></em>
											</li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
			  </ul>
		  </div>
		  <div data-tab-panel-6 class="am-tab-panel">
			  <ul class="home_main am-avg-sm-3">
				  <?php if(is_array($cplist2)): $i = 0; $__LIST__ = $cplist2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cp): $mod = ($i % 2 );++$i; if(($cp["typeid"]) == "dpc"): ?><li class="home_main_list">
												<a href="/Game.<?php echo ($cp["typeid"]); ?>.code.<?php echo ($cp["name"]); ?>.do">
													<img src="/icon/<?php echo ($cp[name]); ?>.png" style="height:43px;with:40px;main-right:12px;margin-left:3px;">
												</a>
													<h3><?php echo ($cp["title"]); ?></h3>
													<em><?php echo ($cp["ftitle"]); ?></em>
											</li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
			  </ul>
		  </div>
		  <div data-tab-panel-6 class="am-tab-panel">
			  <ul class="home_main am-avg-sm-3">
				  <?php if(is_array($cplist2)): $i = 0; $__LIST__ = $cplist2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cp): $mod = ($i % 2 );++$i; if(($cp["typeid"]) == "lhc"): ?><li class="home_main_list">
												<a href="/Game.<?php echo ($cp["typeid"]); ?>.code.<?php echo ($cp["name"]); ?>.do">
													<img src="/icon/<?php echo ($cp[name]); ?>.png" style="height:43px;with:40px;main-right:12px;margin-left:3px;">
												</a>
													<h3><?php echo ($cp["title"]); ?></h3>
													<em><?php echo ($cp["ftitle"]); ?></em>
											</li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
			  </ul>
		  </div>
      </div>
  </div>
<!--	<script>
		$('li.home_main_list a').click(function(event){
			var url = $(this).attr('href');
			$.ajax({
				url:url,
				type: 'POST',
				success : function(json){
					if(json.sign == 'fase'){
						alert(json.message);
						window.location.href="<?php echo U('Public/login');?>";
					}else{
						window.location.href=url;
					}
				}
			})
		})
	</script>-->
</body>
</html>