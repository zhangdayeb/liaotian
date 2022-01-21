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
			银行卡管理
		</h1>

	</header>
	
	<div class="bank_recharge tankMoney_main security6_main">
		<form action="" class="am-form">
			<ul class="bank_form_list">
				<?php if(is_array($banklist)): $i = 0; $__LIST__ = $banklist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="am-cf">
					<div class="am-fl bank_right_input">
						<svg class="icon" aria-hidden="true">
							<img src="/resources/images/bank/<?php echo ($vo["banklogo"]); ?>" style="margin-bottom: 30px;" />
						</svg>
						<div class="bank_info">
							<em class="bank-name"><?php echo ($vo["bankname"]); ?></em>
							<em>**********<span class="bank-sum"><?php echo (substr($vo["banknumber"],-4)); ?></span></em>
						</div>
					</div>
					<?php if(($vo["isdefault"]) == "1"): ?><a href="javascript:void(0);" class="am-fr security6_edit">默认</a>
					 <?php else: ?>
					<a href="javascript:void(0);" class="am-fr security6_edit "  onclick="setdefault(<?php echo ($vo["id"]); ?>)">设为默认</a><?php endif; ?>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
             <?php if(($count) < "3"): ?><a href="<?php echo U('Member/addBank');?>" class="am-btn am-btn-danger am-radius am-btn-block">添加银行卡</a><?php endif; ?>
		</form>	
		<div class="bottom_explain">
			<p>您已绑定<?php echo (count($banklist)); ?>张银行卡，你还可以可以绑定<?php echo 3-count($banklist)?>张银行卡。为了您的资金安全，成功提现的银行卡会自动锁定，无法删除和修改。</p>
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
	 
		function setdefault(id) {
			$.ajax({
				url : "<?php echo U('Apijiekou/defaultuserbankcard');?>",
				type : "POST",
				data : {
					id : id
				},
				success : function (data) {
					if(data.sign==1)
					{
						alert(data.message);
						window.location.reload();

					}else{
						alert(data.message);
					}
				}
			})
		}
	</script>
</body>
</html>