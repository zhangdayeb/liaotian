<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<title><?php echo GetVar('webtitle');?></title>
	<meta name="keywords" content="<?php echo GetVar('keywords');?>" />
	<meta name="description" content="<?php echo GetVar('description');?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" >

	<link rel="stylesheet" href="/resources/css2/bootstrap.min.css">
	<link rel="stylesheet" href="/resources/css2/reset.css">
	<link rel="stylesheet" href="/resources/css2/icon.css">
	<link rel="stylesheet" href="/resources/css2/header.css">
	<link rel="stylesheet" href="/resources/css2/activity.css">
	<link rel="stylesheet" href="/resources/css2/footer.css">
	<link rel="stylesheet" href="/resources/js2/layer/skin/default/layer.css">
	
</head>
<body>
<!--header start-->

<!--禁止非法用途    交流qq 1178087691-->
<script>
    var WebConfigs = {
        "ROOT" : "",
        'IMG' : "/resources/images",
    }
</script>
<script type="text/javascript" src="/resources/js/jquery-3.1.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="/resources/css/artDialog.css" />
<link rel="stylesheet" type="text/css" href="/resources/css/headernav.css" />
<script type="text/javascript" src="/resources/js/artDialog.js"></script>
<script type="text/javascript" src="/resources/js/way.min.js"></script>
<script type="text/javascript" src="/resources/main/common.js"></script>
<header class="header" style="height:35px;">
    <div class="container claerfix">
        <div class="pull-left">
            Hi，欢迎来到<?php echo GetVar('webtitle');?>！
        </div>

        <?php if(!empty($userinfo["username"])): ?><div class="pull-right user_login_info">
                <ul>
                    <!--<p class="margin_0">性别：<span><?php if(($userinfo['sex']) == "1"): ?>男<?php endif; if(($userinfo['sex']) == "2"): ?>女<?php endif; if(($userinfo['sex']) == ""): ?>保密<?php endif; ?></span></p>-->
                    <li class="user_login_info1">
                        <a  href="<?php echo U('Member/index');?>" class="user_header" data-html="true" class="user_header" data-container="body" data-toggle="popover" data-placement="bottom"data-content='<div class="ceng"><div class="media"><div class="media-left"><a href="<?php echo U('Member/index');?>"><img src="<?php echo ($userinfo["face"]); ?>" alt="" class="media-boject img-circle"></a><p><?php echo ($userinfo["username"]); ?></p></div><div class="media-body" style="padding-bottom:10px;">
                <p class="margin_0">账号：<span><?php echo ($userinfo["username"]); ?></span></p>
                <p class="margin_0">等级：<span><?php echo ($userinfo["groupname"]); ?></span></p>
                <p class="margin_0">头衔：<span><?php if(($userinfo['groupname']) == "代理"): ?>总代理 <?php else: echo ($userinfo["touhan"]); endif; ?></span></p>
                <p class="margin_0">累积中奖：<span><?php echo (session('okamountcount')); ?></span></p>
            </div>
            <div class="media-footer">
                <?php if(is_array($_SESSION['k3names'])): $i = 0; $__LIST__ = $_SESSION['k3names'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Game/k3');?>?code=<?php echo ($value['cpname']); ?>" title="<?php echo ($value["cptitle"]); ?>" class="color_res" style="font-size:5px;"><span style="color:#333;display: block;margin-top:4px;"><?php echo (substr($value["cptitle"],0,6)); ?></span><i class="iconfont">&#xe607;</i></a><?php endforeach; endif; else: echo "" ;endif; ?>
            </div></div></div>'>
    <img class="img-circle"  src="<?php echo ($userinfo["face"]); ?>" alt="">
    <?php echo ($userinfo['username']); ?>
    </a>
    <a class="user_info" style="display:none">
        0
    </a>
    <div class="info_sum_box" style="display: none;">
        <div class="info_sum clearfix">
            <a href="" class="pull-left">
                我的未读消息
                (<em>0</em>)
            </a>
            <a href="" class="pull-right">
                更多
            </a>
        </div>
    </div>
    </li>
    <!--li class="user_login_info2">
        <a href="<?php echo U('Member/index');?>" class="my_account">
            我的账户
            <i class="iconfont">&#xe6a1;</i>
        </a>
        <div class="user_login_info2_list" style="display:none;">
            <i class="user_login_info2_i"></i>
            <?php if($userinfo["proxy"] == '1'): ?><a href="<?php echo U('Member/Agent');?>">代理中心</a><?php endif; ?>
            <a href="<?php echo U('Member/betRecord');?>">投注记录</a>
            <a href="<?php echo U('Account/dealRecord');?>">交易记录</a>
            <a href="<?php echo U('Member/ziliao');?>">个人信息</a>
            <a href="<?php echo U('Member/index');?>">安全中心</a>
        </div>
    </li-->
    <!--li class="user_login_info3">
        余额：
						<span class="show_money">
							<em class="smallmoney" style="color:#F70B0F;"><?php echo ($userinfo['balance']); ?></em>
							<i class="iconfont refresh_money">&#xe602;</i>
							<em class="hide_money_btn">隐藏</em>
						</span>
						<span class="hide_money" style="display:none;">
							已隐藏
							<em class="show_money_btn">显示</em>
						</span>
    </li>
    <li class="xima l">洗码：<span class="c-green" style="color:green;" way-data="user.xima">0</span></li>
    <li class="user_login_info4">
        <a href="<?php echo U('Account/bankRecharge');?>">充值</a>
    </li>
    <li class="user_login_info5">
        <a href="<?php echo U('Account/withdrawals');?>">提现</a>
    </li>
    <li class="user_login_info6">
        <a href="<?php echo U('Public/LoginOut');?>">退出</a>
    </li>
    <li>
        <a href="<?php echo GetVar('kefuthree');?>"    target="_blank"   class="keufBox" style="margin-left: 0px;"></a>
    </li>
    <li style="padding:0;line-height: 49px;">
        <a href="https://wpa.qq.com/msgrd?v=3&uin=<?php echo GetVar('kefuqq');?>&site=qq&menu=yes"  target="_blank">
            <img src="/resources/images/qq.gif" width="20" height="20" style="vertical-align: super;" />
        </a>
    </li>
    </ul>
    </div>
    <else/--><?php endif; ?>
    </div>
</header>

<script>
    var ISLOGIN = "<?php echo ($userinfo["id"]); ?>";
</script>

<div class="header head8">
   <div class="nav">
    <div class="container fix">
     <h3><a href="/"><img style="width: 210px;" src="http://tz.jb888888.com/Template/Mobile/images/1122.png" /></a></h3> 
     <!----> 
     <ul class="navItem fix flr" style="position: relative;">
      <li class="" id="navIndex"><a href="/">代理大厅</a></li> 
      <!---->
	  <!--li class="" id="navZRVideo"><a href="<?php echo U('Index/zrvideo');?>">真人视讯</a></li>
      <li class="" id="navLottery"><a href="<?php echo U('Index/lottery');?>">购彩大厅</a></li> 
      <!---->
      <!--li class="" id="navActivity"><a href="<?php echo U('Activity/index');?>">活动中心</a></li> 
      <!---->
      <!--li class="" id="navMobile"><a href="<?php echo U('Index/mobile');?>">手机购彩</a></li> 
      <!---->
      <li class="" id="navSecurityCenter"><a href="<?php echo U('Member/index');?>">我的账户</a></li> 
      <!---->
      <!--li class="" id="navHelp"><a href="<?php echo U('News/lists',array('catid'=>33));?>">帮助指南</a></li--> 
      <!----> 
      <span></span>
     </ul>
    </div>
   </div>
  </div>
  

 
<script>
    $(function () {
        $('.refresh_money').click(function () {
            $.ajax({
                url:"<?php echo U('Account/refreshmoney');?>",
                type:'POST',
                success :function (data) {
                    $('.smallmoney').html(data);
                }
            })
        })

    })
</script>
<script src="/resources/js2/require.js" data-main="/resources/js2/homePage"></script>
	<div class="activity_main">
		<div class="container padding_0">
			<div class="panel-group" id="accordion">

			    <div class="panel panel-default" id="activity_panel" >
			        <div class="panel-heading">
			            <h4 class="panel-title">
			                <div data-toggle="collapse"   href="#collapseOne" class="clearfix">
				                <div class="activity_img pull-left">
				                	<img src="/resources/images/20160924082726681336.png" alt="">
				                </div>
				                <div class="activity_title pull-right">
				                	<h2>每日加奖</h2>
				                	<p>每日加奖是根据会员昨日投注金额进行加奖，奖金无上限。</p>
				                	<a href="" class="btn btn-danger">
				                		查看详情
				                		<i class="iconfont">&#xe604;</i>
				                	</a>
				                </div>
			                </div>
			            </h4>
			        </div>
			        <div id="collapseOne" class="panel-collapse  collapse">
			            <div class="panel-body">
			                <div class="activity_content">
			                	<div class="activity_info1">
			                		<h3 class="activity_common_h3">
			                			每日加奖
			                		</h3>
									<?php if($userinfo["groupid"] != '10'): ?><p>
			                			<span>昨日投注：<em><?php if(($countamount) == ""): ?>0<?php else: echo ($countamount); endif; ?></em></span>
										<span>当前等级：<em><?php echo ($userinfo["groupname"]); ?></em></span>
										<span>加奖比例：<em><?php echo ($fanshuibili); ?>%</em></span>
			                			<span>可得加奖：<em><?php if(($jiajiang) == ""): ?>0<?php else: echo ($jiajiang); endif; ?></em></span>
                                       <?php if(!empty($_SESSION['userinfo'])): if(($jiajiang) == ""): ?><a href="javascript:void(0);" class="btn no_login_btn">无加奖</a>
												<?php else: ?>
												 <a href="javascript:void(0);" class="btn btn-danger" onclick="qingquyongqu();" >点击领取加奖</a><?php endif; ?>
										   <?php else: ?>
										   <a href="<?php echo U('Public/login');?>" class="btn no_login_btn">未登录</a><?php endif; ?>
			                		</p><?php endif; ?>
									<?php if(!empty($_SESSION['userinfo'])): ?><table class="table table-bordered ">
										<tbody>
										<tr><th>领取时会员等级</th><th>流水金额</th><th>反水比例</th><th>领取金额</th><th>领取时间</th><th>状态</th></tr>
									<?php if($userinfo["groupid"] != '10'): if(is_array($lqlist)): $i = 0; $__LIST__ = $lqlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
											<td><?php echo ($vo["groupname"]); ?></td>
											<td><?php echo ($vo["touzhuedu"]); ?></td>
											<td><?php echo ($vo["bili"]); ?></td> 
											<td><?php echo ($vo["amount"]); ?></td>
											<td><?php echo (date("Y-m-d H:i:s",$vo["oddtime"])); ?></td>
											<td><?php if($vo['shenhe'] == 0): ?><span style="color:grey">审核中</span><?php elseif($vo['shenhe'] == 1): ?><span style="color:green">通过</span><?php endif; ?></td></tr><?php endforeach; endif; else: echo "" ;endif; endif; ?>
										</tbody>
									</table><?php endif; ?>
									<div class="ty_page pages" id="lrx_ty_page"><?php echo ($pageshow); ?></div>
			                	</div>
			                	<div class="activity_info2">
			                		<h3 class="activity_common_h3">
			                			加奖比例
			                		</h3>
			                		<table class="table table-bordered">
			                			<thead>
			                				<tr>
			                					<th class="ths">
			                						<i>等级</i>
			                						<ins></ins>
			                						<em>昨日投注</em>
			                					</th>
												<?php if(is_array($mintozhu)): $i = 0; $__LIST__ = $mintozhu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($i % 2 );++$i;?><th><?php echo ($value[0]); ?>+</th><?php endforeach; endif; else: echo "" ;endif; ?>
			                				</tr>
			                			</thead>
			                			<tbody>
										  <?php if(is_array($bilisss)): $i = 0; $__LIST__ = $bilisss;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($i % 2 );++$i;?><tr>
			                					<td><?php echo ($value[0]); ?></td>
			                					<td><?php echo ($value[1]); ?>%</td>
			                					<td><?php echo ($value[2]); ?>%</td>
			                					<td><?php echo ($value[3]); ?>%</td>
			                				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			                			</tbody>
			                		</table>
			                	</div>
			                	<div class="activity_info3">
			                		<h3 class="activity_common_h3">
			                			活动说明
			                		</h3>
			                		<p>1、每日加奖在每日凌晨00:20后开放领取；</p>
			                		<p>2、加奖比例是根据会员等级以及昨日累计投注金额进行一定比例的加奖；</p>
			                		<!--<p>3、需Vip3以上且昨日投注额大于或等于100才能获得加奖；</p>-->
			                		<p>3、撤单和其他无效投注将不计算在内；</p>
													<p>4、提款后相应的降级将会影响加奖的比例。</p>
			                		<p>5、活动奖金逾期未领取，视为自动放弃活动资格。</p>
			                	</div>
			                </div>
			            </div>
				    </div>
				</div>
			    <div class="panel panel-default" id="activity_panel">
			        <div class="panel-heading">
			            <h4 class="panel-title">
			                <div data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="clearfix collapsed" aria-expanded="false">
				                <div class="activity_img pull-left">
				                	<img src="/resources/images/20160924084334202069.png" alt="">
				                </div>
				                <div class="activity_title pull-right">
				                	<h2>晋级奖励</h2>
				                	<p>会员每晋升一个等级，都能获得奖励，最高可达<?php echo ($maxjlje); ?>元。</p>
				                	<a href="" class="btn btn-danger">
				                		查看详情
				                		<i class="iconfont"></i>
				                	</a>
				                </div>
			                </div>
			            </h4>
			        </div>
					<div id="collapseTwo" class="panel-collapse collapse" style="" aria-expanded="false">
			            <div class="panel-body">
			                <div class="activity_content">
			                	<div class="activity_info1">
			                		<h3 class="activity_common_h3">
			                			晋级奖励
			                		</h3>
									
									<?php if($userinfo["groupid"] != '10'): ?><p>
			                			<span>当前等级：<em><?php echo ($userinfo["groupname"]); ?></em></span>
										<span>上次晋级等级：<em><?php if(empty($jjlist[0]['groupid'])): ?>VIP1<?php else: ?>VIP<?php echo ($jjlist[0]["groupid"]); endif; ?></em></span>
			                			<span>晋级奖励：<em><?php echo ($jlje); ?>元</em></span>
										<?php if(!empty($_SESSION['userinfo'])): if(($jlje) == "0"): ?><a href="javascript:void(0);" class="btn no_login_btn">无奖励</a>
												<?php else: ?>
												<a href="javascript:void(0);" class="btn btn-danger" onclick="jiangli();" >点击领取奖励</a><?php endif; ?>
											<?php else: ?>
											<a href="<?php echo U('Public/login');?>" class="btn no_login_btn">未登录</a><?php endif; ?>
			                		</p><?php endif; ?>
									<?php if(!empty($_SESSION['userinfo'])): ?><table class="table table-bordered ">
										<tbody>
										<tr><th>领取时间</th><th>晋级名称</th><th>晋级积分</th><th>领取奖励</th><th>状态</th></tr>
										
									<?php if($userinfo["groupid"] != '10'): if(is_array($jjlist)): $i = 0; $__LIST__ = $jjlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo["groupname"] != ''): ?><tr><td><?php echo (date("m-d H:i",$vo["oddtime"])); ?></td>
												<td><?php echo ($vo["groupname"]); ?></td>
												<td><?php echo ($vo["point"]); ?></td>
												<td><?php echo ($vo["jlje"]); ?></td>
												<td><?php if($vo['shenhe'] == 0): ?><span style="color:grey">审核中</span><?php elseif($vo['shenhe'] == 1): ?><span style="color:green">通过</span><?php elseif($vo['shenhe'] == -1): ?><span style="color:red">未通过</span><?php endif; ?></td></tr><?php endif; endforeach; endif; else: echo "" ;endif; endif; ?>		
										</tbody>
									</table><?php endif; ?>
			                	</div>
			                	<div class="activity_info2">
			                		<h3 class="activity_common_h3">
			                			晋级机制
			                		</h3>
			                		<table class="table table-bordered">
			                			<thead>
			                				<tr>
			                					<th>
			                						<i>等级</i>
			                					</th>
			                					<th>头衔</th>
			                					<th>成长积分</th>
			                					<th>晋级奖励(元)</th>
			                					<th>跳级奖励(元)</th>
			                				</tr>
			                			</thead>
			                			<tbody>
										<?php if(is_array($allbili)): $i = 0; $__LIST__ = $allbili;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($i % 2 );++$i;?><tr>
			                					<td><?php echo ($value["groupname"]); ?></td>
			                					<td><?php echo ($value["touhan"]); ?></td>
			                					<td><?php echo ($value["shengjiedu"]); ?></td>
			                					<td><?php echo ($value["jjje"]); ?></td>
			                					<td><?php echo ($value["tiaoji"]); ?></td>
			                				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			                			</tbody>
			                		</table>
			                	</div>
			                	<div class="activity_info3">
			                		<h3 class="activity_common_h3">
			                			活动说明
			                		</h3>
			                		<p>1、会员每晋升一个等级，都能获得奖励，最高可达<?php echo ($maxjlje); ?>元。 </p>
			                		<p>2、充值1元可获得1成长积分。 </p>
									<p>3、会员每晋升一个等级，都记录在数椐库,下次晋级会以上一次晋级等级来计算,提款后减积分和降级后充值再升级未超过数椐库记录的等级则不在计算内。 </p>
			                		<br />
			                		<p>例1：奥巴马从VIP1直接晋升到VIP4，他将能获得1+5+10=16元奖励。</p>
			                		<p>例2：本拉登从VIP2直接晋升到VIP4，他将能获得5+10=15元奖励。</p>
			                	</div>
			                </div>
			            </div>
				    </div>
				</div>
				 <div class="panel panel-default" id="activity_panel" >
			        <div class="panel-heading">
			            <h4 class="panel-title">
			                <div data-toggle="collapse"   href="#collapse3" class="clearfix">
				                <div class="activity_img pull-left">
				                	<img src="/resources/images/activity_bg5.png" alt="">
				                </div>
				                <div class="activity_title pull-right ">
				                	<h2>银行充值返利</h2>
				                	<p>活动对象: 全体会员 活动简介: 以诚为根 以信为本</p>
				                	<a href="" class="btn btn-danger">
				                		查看详情
				                		<i class="iconfont">&#xe604;</i>
				                	</a>
				                </div>
			                </div>
			            </h4>
			        </div>
			        <div id="collapse3" class="panel-collapse  collapse">
						<?php echo ($houdong1); ?>
				    </div>
			
			</div>
				<div class="panel panel-default" id="activity_panel" >
			        <div class="panel-heading">
			            <h4 class="panel-title">
			                <div data-toggle="collapse"   href="#collapse4" class="clearfix">
				                <div class="activity_img pull-left">
				                	<img src="/resources/images/activity_bg51.png" alt="">
				                </div>
				                <div class="activity_title pull-right ">
				                	<h2>猜灯谜★欢乐今宵</h2>
				                	<p>今夜狂欢、猜灯谜、享豪礼✔其乐融融</p>
				                	<a href="" class="btn btn-danger">
				                		查看详情
				                		<i class="iconfont">&#xe604;</i>
				                	</a>
				                </div>
			                </div>
			            </h4>
			        </div>
			        <div id="collapse4" class="panel-collapse  collapse">
						<?php echo ($houdong2); ?>
					</div>
		</div>
		<div class="panel panel-default" id="activity_panel" >
			        <div class="panel-heading">
			            <h4 class="panel-title">
			                <div data-toggle="collapse"   href="#collapse5" class="clearfix">
				                <div class="activity_img pull-left">
				                	<img src="/resources/images/activity_bg7.png" alt="">
				                </div>
				                <div class="activity_title pull-right ">
				                	<h2>豹子姗姗来迟的惊喜</h2>
				                	<p style="margin: 13px 0;">玩赚五分快三 姗姗来迟的惊喜 豹子号嘉奖188元。第二惠</p>
				                	<a href="" class="btn btn-danger">
				                		查看详情
				                		<i class="iconfont">&#xe604;</i>
				                	</a>
				                </div>
			                </div>
			            </h4>
			        </div>
			        <div id="collapse5" class="panel-collapse  collapse">
						<?php echo ($houdong3); ?>
					</div>
	</div>
	<div class="panel panel-default" id="activity_panel" >
			        <div class="panel-heading">
			            <h4 class="panel-title">
			                <div data-toggle="collapse"   href="#collapse6" class="clearfix">
				                <div class="activity_img pull-left">
				                	<img src="/resources/images/activity_bg3.jpg" alt="">
				                </div>
				                <div class="activity_title pull-right ">
				                	<h2>首充奖励</h2>
				                	<p style="margin: 13px 0;">首次充值送现金【龍源国际】百发钜惠第一惠隆重推出【秒冲，秒送】存款送现金专题活动</p>
				                	<a href="" class="btn btn-danger">
				                		查看详情
				                		<i class="iconfont">&#xe604;</i>
				                	</a>
				                </div>
			                </div>
			            </h4>
			        </div>
			        <div id="collapse6" class="panel-collapse  collapse">
						<?php echo ($houdong4); ?>
					</div>
	</div>
	</div>
	</div>
<script type="text/javascript">
		function qingquyongqu(){
			$.post("<?php echo U('Home/Activity/fanshui');?>",'', function(json){
				if(json.status==1){
					alert(json.info);
					window.location.reload();
				}else{
					alert(json.info);
				}
			},'json');
			return false;
	}
	function jiangli(){
		$.post("<?php echo U('Home/Activity/jinji');?>",'', function(json){
			if(json.status==1){
				alert(json.info);
				window.location.reload();
			}else{
				alert(json.info);
			}
		},'json');
		return false;
	}
</script>
<footer class="footer" style="clear:both">
    <div class="footer_main">
        <div class="container">
            <div class="row">
                <div class="col-xs-3 footer_left padding_0">
                    <div class="footer_common_title">
                        <h2>技术支持 <span>Technical support</span></h2>
                    </div>
                    <div class="clearfix footer_l_content">
                        <a href="">
                            <div class="pull-left">
                                <img src="/resources/images/dafayun.png" alt="">
                            </div>
                            <p class="pull-left">
                                <span><?php echo GetVar('webtitle');?>系统</span>
                                <span>专业彩票系统平台</span>
                            </p>
                        </a>
                    </div>
                    <i></i>
                </div>
                <div class="col-xs-4 footer_middle">
                    <div class="footer_common_title">
                        <h2>服务体验 <span>Service experience</span></h2>
                        <div class="footer_m_content">
                            <div class="clearfix enter">
                                <span class="pull-left">昨日充值到账平均时间</span>
                                <p class="bar pull-left margin_0">
                                    <span class="bar_red"></span>
                                </p>
                                <span class="miao pull-left"><em>53</em> 秒</span>
                            </div>
                            <div class="clearfix enter">
                                <span class="pull-left">昨日提现到账平均时间</span>
                                <p class="bar pull-left margin_0">
                                    <span class="bar_blue"></span>
                                </p>
                                <span class="miao pull-left"><em>17'40</em> 秒</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-3 footer_right">
                    <div class="footer_common_title">
                        <h2>充值展示 <span>Recharge method</span></h2>
                    </div>
                    <div class="chongzhi_img_box">
                        <span class="chongzhi_img1"></span>
                        <span class="chongzhi_img2"></span>
                        <span class="chongzhi_img3"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer_other">
        <div class="container">
            <p class="footer_link">
                <a href="<?php echo U('News/lists',['catid'=>30,'showid'=>3]);?>?About ">关于我们</a>
                <a href="<?php echo U('News/lists',['catid'=>30,'showid'=>56]);?>?About">联系我们</a>
                <a href="<?php echo U('News/lists',['catid'=>30,'showid'=>57]);?>?About">商务合作</a>
                <a href="<?php echo U('News/lists',['catid'=>30,'showid'=>58]);?>?About">法律声明</a>
                <a href="<?php echo U('News/lists',['catid'=>30,'showid'=>59]);?>?About">隐私声明</a>
            </p>
            <p class="footer_copyright">
                Copyright ©  <?php echo GetVar('webtitle');?>  Reserved | 18+
            </p>
        </div>
    </div>
</footer>
<?php if($_COOKIE['showgg']== '1' && $_SESSION['userinfo']!= ''): ?><div class="notice">
    <div class="noticCon">
        <h3>网站最新公告 <a class="iconfont icon-guanbi-copy closeNotice"></a></h3>
     <ul>
         <?php if(is_array($gglist)): $k = 0; $__LIST__ = array_slice($gglist,0,1,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li><a href=<?php echo U('Member/ggshow',array('aid'=>$vo['id']));?>><?php echo ($vo["title"]); ?><br>[<?php echo (date("Y-m-d H:i:s",$vo["oddtime"])); ?>]</a></li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
    </div>
</div><?php endif; ?> 
<script>
    $('.notice').find('.closeNotice').click(function (){
     
        $('.notice').hide();
        $.ajax({
            url : "<?php echo U('Common/closegg');?>",
            type:"POST",
        })
    })
</script>
<div class="loginCengBox">
	<div class="loginCeng">
		<div class="loginCengH">
			<h3>温馨提示</h3>
			<span class="loginCengClose">
				<i class="iconfont icon-guanbi-copy"></i>
			</span>
		</div>
		<div class="loginCengB">
		
		</div>
		<div class="loginCengF">
			<button type="submit" >确定</button>
		</div>
	</div>
</div>


<div id="_leftAD" class="_float_AD l_AD animated bounceInLeft">
	<img src="/images/1.png">
	<div name="close_btn"></div>
	<a class="top1_btn" href="" target="_blank"></a>
	
	<a href="" target="_blank" style="position: absolute;top: 185px;height: 60px;width: 100%;"></a>
	<a href="" target="_blank" style="position: absolute;top: 250px;height: 105px;width: 100%;"></a>
	
</div>

<div id="_rightAD" class="_float_AD r_AD animated bounceInRight">
	<img src="/images/1.png">
	<div name="close_btn"></div>
	<a class="top1_btn" href="" target="_blank"></a>
	
	<a href="" target="_blank" style="position: absolute;top: 185px;height: 60px;width: 100%;"></a>
	<a href="" target="_blank" style="position: absolute;top: 250px;height: 105px;width: 100%;"></a>
	
</div>

<style>

._float_AD.l_AD {
    left: 0.6%;
}
._float_AD {
    position: fixed;
    z-index: 19;
    top: 29%;
    overflow: visible;
    margin-top: -142px;
}
._float_AD>img {
    display: block;
    width: 175px;
    height: 562px;
    border: none;
}
._float_AD [name=close_btn] {
    position: absolute;
    top: 368px;
    z-index: 2;
    width: 90px;
    height: 37px;
    left: 50%;
    margin-left: -45px;
    cursor: pointer;
    border-radius: 8px;
    opacity: 0;
    border: none;
    outline: none;
}
._float_AD .top1_btn {
    position: absolute;
    z-index: 2;
    width: 128px;
    height: 38px;
    left: 50%;
    margin-left: -64px;
    top: 83px;
    cursor: pointer;
    border-radius: 5px;
    opacity: 0;
    border: none;
    outline: none;
}
._float_AD.r_AD {
    right: 0.6%;
}
(index):1371
._float_AD {
    position: fixed;
    z-index: 19;
    top: 29%;
    overflow: visible;
    margin-top: -142px;
}

</style>
</body>
</html>