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
		<h1 class="am-header-title activity_h1">
			交易记录
		</h1>
		<div class="am-header-right am-header-nav">
			<a href="javascript:void(0);" data-am-modal="{target: '#my-actions'}">
				<em class="bill_day">全部</em>
				<i class="iconfont icon-jiantouxia"></i>
			</a>
		</div>
	</header>
	
	<div data-am-widget="" class="am-tabs am-tabs-d2 billrecord_main">
		<ul class="am-tabs-nav am-cf am-avg-sm-3" style="text-align:center;">
			<li class=""><a href="<?php echo U('Mobile/Account/dealRecord');?>">所有类型</a></li>
			<li class="am-active"><a href="<?php echo U('Mobile/Account/dealRecord2');?>">充值记录</a></li>
			<li class=""><a href="<?php echo U('Mobile/Account/dealRecord3');?>">提现记录</a></li>
		</ul>

		<?php $typearray = AbstractType();?>
			<div data-tab-panel-2 class="am-tab-panel ">
				<div data-am-widget="list_news" class="am-list-news am-list-news-default" >
					<div class="am-list-news-bd">
						<ul class="am-list">
							<?php if(is_array($mxlist)): $i = 0; $__LIST__ = $mxlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="am-g am-list-item-dated">
								<p class="am-cf">
									<span class="what_type am-fl"><?php echo ($paylist[$vo['paytype']]['title']); ?>支付</span>
									<em class="money am-fr">+<?php echo ($vo["amount"]); ?></em>
								</p>
								<p class="am-cf billrecord_time">
									<span class="am-fl"><?php echo (date("Y-m-d H:i:s",$vo["oddtime"])); ?></span>
									<?php if($vo['state'] == 1): ?><em class="am-fr" style="color:green">成功</em>
										<?php elseif($vo['state'] == 0): ?>
										<em class="am-fr" style="color:grey">支付中</em>
										<?php elseif($vo['state'] == -1): ?>
										<em class="am-fr" style="color:grey">订单关闭</em><?php endif; ?>
								</p>
							</li><?php endforeach; endif; else: echo "" ;endif; ?>
						</ul>
						<div class="page"><?php echo ($pageshow); ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="am-modal-actions billrecord_day" id="my-actions">
		<div class="am-modal-actions-group">
			<ul class="am-list">
				<li class="am-modal-actions-header" onclick="chaxun(0)">全部</li>
				<li class="am-modal-actions-header" onclick="chaxun(1)">今天</li>
				<li class="am-modal-actions-header" onclick="chaxun(2)">昨天</li>
				<li class="am-modal-actions-header" onclick="chaxun(3)">七天</li>
			</ul>
		</div>
		<div class="am-modal-actions-group">
			<button class="am-btn am-btn-secondary am-btn-block btn_red" data-am-modal-close>取消</button>
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
		setTimeout(function () {
			var test = window.location.href;
			var str = test.substr(test.length-7);
			switch (str){
				case 'atime=1':
					$('.bill_day').html('今天');
					break;
				case 'atime=2':
					$('.bill_day').html('昨天');
					break;
				case 'atime=3':
					$('.bill_day').html('七天');
					break;

			}
		})
		function chaxun(t){ 
			var atime = t;
			var url = "/?m=Mobile&c=Account&a=dealRecord2&atime="+atime ;
			window.location.href = url;
		}
	</script>
</body>
</html>