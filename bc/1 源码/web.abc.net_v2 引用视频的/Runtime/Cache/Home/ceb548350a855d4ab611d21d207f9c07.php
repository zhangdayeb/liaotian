<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo GetVar('webtitle');?></title>
    <meta name="keywords" content="<?php echo GetVar('keywords');?>" />
    <meta name="description" content="<?php echo GetVar('description');?>" />
    <meta name="renderer" content="webkit" />
    <link rel="stylesheet" href="/resources/css2/bootstrap.min.css">
    <link rel="stylesheet" href="/resources/css2/reset.css">
    <link rel="stylesheet" href="/resources/css2/icon.css">
    <link rel="stylesheet" href="/resources/css2/header.css">
    <link rel="stylesheet" href="/resources/css2/main.css">
    <link rel="stylesheet" href="/resources/css2/footer.css">

</head>
<body>
<script>
    var WebConfigs = {
        "ROOT" : "",
        'IMG' : "/resources/images",
    }
</script>
<style type="text/css">

    
}
</style>
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
<script type="text/javascript" src="/resources/js/way.min.js"></script>
<script type="text/javascript" src="/resources/main/common.js"></script>
<script type="text/javascript" src="/resources/main/index.js"></script>
<script src="/resources/js2/require.js" data-main="/resources/js2/homePage"></script>
<div class="main">
    <div class="container">
        <div class="row">
            <div class="col-xs-1 main_left padding_0" style="height:210px; ">
                <ul class="magin_left_list indexcplist" >
                        <li>
                            <a href="<?php echo U('Member/Agent');?>" class="pull-left">
                            <i class="iconfont">&#xe61e;</i>
                            代理中心
                        </a>
                            <a href="/" class="pull-left">
                            <i class="iconfont">&#xe61e;</i>
                            申请代理
                          </a>
                        </li>
                        <div class="col-xs-3 main_right padding_0">
                <div class="login clearfix">
                    <?php if(is_array($userinfo)): ?><div class="succees_box">
                            <p class="user_name">HI,<?php echo ($userinfo["username"]); ?></p>
                            <p class="user_balance">余额：<?php echo ($userinfo["balance"]); ?></p>
                            <p class="user_c_t">
                                <a href="<?php echo U('Account/recharge');?>" class="btn bg_red" style="width:58px;height:38px;">充 值</a>
                                <a href="<?php echo U('Account/withdrawals');?>" class="btn bg_org" style="width:58px;height:38px;">提 现</a>
                        </div>
                        <?php else: ?>
                        <a href="<?php echo U('Home/Public/login');?>" class="pull-left" style="width:230px;height:38px;" >登 录</a>
     
                </div>
                    </volist>
                </ul>
            </div>

                <div class="col-xs-6 main_middle">
                <div class="middle_swiper">
                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li class="active" data-target="#myCarousel" data-slide-to="0"></li>
                            <li data-target="#myCarousel" data-slide-to="1"></li>
                            <li data-target="#myCarousel" data-slide-to="2"></li>
                            <li data-target="#myCarousel" data-slide-to="3"></li>
                            <li data-target="#myCarousel" data-slide-to="4"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="item active">
                                <a href="<?php echo U('Activity/index');?>"><img src="/resources/images/indexbanner1.jpg" alt=""></a>
                            </div>
                            <div class="item">
                                <a href="<?php echo U('Activity/index');?>"><img src="/resources/images/indexbanner2.jpg" alt=""></a>
                            </div>
                            <div class="item">
                                <a href="<?php echo U('Activity/index');?>"><img src="/resources/images/indexbanner3.jpg" alt=""></a>
                            </div>
                            <div class="item">
                                <a href="<?php echo U('Activity/index');?>"><img src="/resources/images/indexbanner4.jpg" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ranking main_common_bor" >
                    <div class="title">
                        <h3 class="margin_0">佣金榜</h3>
                    </div>
                    <ul class="ranking_list sum_icon">
                        <?php if(is_array($list)): $k = 0; $__LIST__ = array_slice($list,0,3,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($k % 2 );++$k;?><li data-html="true" class="user_header" data-container="body" data-toggle="popover" data-placement="left"data-content='
                        <div class="ceng"><div class="media"><div class="media-left">
                        <img src="<?php echo ($value['face']); ?>" alt="" class="media-boject img-circle"><p><?php echo str_replace_cn($value['username'],1,3);?></p></div><div class="media-body"><p class="margin_0">账号：<span><?php echo str_replace_cn($value['username'],1,3);?></span></p><p class="margin_0">等级：<span><?php echo ($value['groupname']); ?></span></p><p class="margin_0">头衔：<span><?php echo ($value['touhan']); ?></span></p><p class="margin_0">累积佣金：<span><?php echo ($value['okamountcount']); ?></span></p></div>
                <div class="media-footer">
                    <?php if(is_array($value['k3names'])): $i = 0; $__LIST__ = array_slice($value['k3names'],0,6,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i; endforeach; endif; else: echo "" ;endif; ?>
                </div></div></div>'>
        <div class="media clearfix">
            <div class="media-left">
                <img src="<?php echo ($value['face']); ?>" alt="" class="media-boject img-circle">
            </div>
            <div class="media-body">
                <p class="margin_0">账号昵称：<span><?php echo str_replace_cn($value['username'],1,3);?></span></p>
                <p class="margin_0">昨日佣金：<em>￥<?php echo ($value['amountcount']); ?></em></p>
            </div>

            <?php switch($k): case "1": ?><span class="backs_red">1</span><?php break;?>
                <?php case "2": ?><span class="backs_blue">2</span><?php break;?>
                <?php case "3": ?><span class="backs_yellow">3</span><?php break;?>
                <?php default: ?>
                <i class="am-fr winners_num"><?php echo ($key); ?></i><?php endswitch;?>
        </div>
        </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
                

<div class="notice ggpop" style="left: 50%;top: 50%; width: 700px;transform: translate(-50%,-50%); bottom: auto;z-index: 1111; ">
    <div class="noticCon">
        <h3>网站最新公告 <a class="iconfont icon-guanbi-copy closeNotice"></a></h3>
     <ul>
         <?php if(is_array($gglist)): $k = 0; $__LIST__ = array_slice($gglist,0,1,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li style="font-weight: 600; color: #000; font-size: 14px;"><?php echo ($vo["title"]); ?></li>
          <li style="line-height: 28px;color: #000; font-size: 14px; text-align: left; text-indent: 2em;"><?php echo ($vo["title"]); echo ($vo["content"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
    </div>
</div><?php endif; ?> 
<script type="text/javascript">
$('.closeNotice').on('click',function(){
    $('.ggpop').hide();
    $('.showzhou').hide();
    $.ajax({
        url : "<?php echo U('Common/closegg');?>",
        type:"POST",
    })
})
</script>
</body>
</html>