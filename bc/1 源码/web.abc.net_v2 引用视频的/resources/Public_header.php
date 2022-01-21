<!--header start-->

<!--禁止非法用途    交流qq 1178087691-->
<script>
    var WebConfigs = {
        "ROOT" : "__ROOT__",
        'IMG' : "__IMG__",
    }
</script>
<script type="text/javascript" src="__JS__/jquery-3.1.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="__CSS__/artDialog.css" />
<link rel="stylesheet" type="text/css" href="__CSS__/headernav.css" />
<script type="text/javascript" src="__JS__/artDialog.js"></script>
<script type="text/javascript" src="/resources/js/way.min.js"></script>
<script type="text/javascript" src="/resources/main/common.js"></script>
<header class="header" style="height:35px;">
    <div class="container claerfix">
        <div class="pull-left">
            Hi，欢迎来到{:GetVar('webtitle')}！
        </div>

        <notempty name="userinfo.username">
            <div class="pull-right user_login_info">
                <ul>
                    <!--<p class="margin_0">性别：<span><eq name="userinfo['sex']" value="1">男</eq><eq name="userinfo['sex']" value="2">女</eq><eq name="userinfo['sex']" value="">保密</eq></span></p>-->
                    <li class="user_login_info1">
                        <a  href="{:U('Member/index')}" class="user_header" data-html="true" class="user_header" data-container="body" data-toggle="popover" data-placement="bottom"data-content='<div class="ceng"><div class="media"><div class="media-left"><a href="{:U('Member/index')}"><img src="__ROOT__{$userinfo.face}" alt="" class="media-boject img-circle"></a><p>{$userinfo.username}</p></div><div class="media-body" style="padding-bottom:10px;">
                <p class="margin_0">账号：<span>{$userinfo.username}</span></p>
                <p class="margin_0">等级：<span>{$userinfo.groupname}</span></p>
                <p class="margin_0">头衔：<span><eq name="userinfo['groupname']" value='代理'>总代理 <else />{$userinfo.touhan} </eq></span></p>
                <p class="margin_0">累积中奖：<span>{$Think.session.okamountcount}</span></p>
            </div>
            <div class="media-footer">
                <volist name="Think.session.k3names" id="value">
                    <a href="{:U('Game/k3')}?code={$value['cpname']}" title="{$value.cptitle}" class="color_res" style="font-size:5px;"><span style="color:#333;display: block;margin-top:4px;">{$value.cptitle|substr=0,6}</span><i class="iconfont">&#xe607;</i></a>
                </volist>
            </div></div></div>'>
    <img class="img-circle"  src="__ROOT__{$userinfo.face}" alt="">
    {$userinfo['username']}
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
        <a href="{:U('Member/index')}" class="my_account">
            我的账户
            <i class="iconfont">&#xe6a1;</i>
        </a>
        <div class="user_login_info2_list" style="display:none;">
            <i class="user_login_info2_i"></i>
            <if condition="$userinfo.proxy eq '1'">
                <a href="{:U('Member/Agent')}">代理中心</a>
            </if>
            <a href="{:U('Member/betRecord')}">投注记录</a>
            <a href="{:U('Account/dealRecord')}">交易记录</a>
            <a href="{:U('Member/ziliao')}">个人信息</a>
            <a href="{:U('Member/index')}">安全中心</a>
        </div>
    </li-->
    <!--li class="user_login_info3">
        余额：
						<span class="show_money">
							<em class="smallmoney" style="color:#F70B0F;">{$userinfo['balance']}</em>
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
        <a href="{:U('Account/bankRecharge')}">充值</a>
    </li>
    <li class="user_login_info5">
        <a href="{:U('Account/withdrawals')}">提现</a>
    </li>
    <li class="user_login_info6">
        <a href="{:U('Public/LoginOut')}">退出</a>
    </li>
    <li>
        <a href="{:GetVar('kefuthree')}"    target="_blank"   class="keufBox" style="margin-left: 0px;"></a>
    </li>
    <li style="padding:0;line-height: 49px;">
        <a href="https://wpa.qq.com/msgrd?v=3&uin={:GetVar('kefuqq')}&site=qq&menu=yes"  target="_blank">
            <img src="__ROOT__/resources/images/qq.gif" width="20" height="20" style="vertical-align: super;" />
        </a>
    </li>
    </ul>
    </div>
    <else/-->
    
    </notempty>
    </div>
</header>

<script>
    var ISLOGIN = "{$userinfo.id}";
</script>

<div class="header head8">
   <div class="nav">
    <div class="container fix">
     <h3><a href="/"><img style="width: 210px;" src="http://tz.jb888888.com/Template/Mobile/images/1122.png" /></a></h3> 
     <!----> 
     <ul class="navItem fix flr" style="position: relative;">
      <li class="" id="navIndex"><a href="__ROOT__/">代理大厅</a></li> 
      <!---->
	  <!--li class="" id="navZRVideo"><a href="{:U('Index/zrvideo')}">真人视讯</a></li>
      <li class="" id="navLottery"><a href="{:U('Index/lottery')}">购彩大厅</a></li> 
      <!---->
      <!--li class="" id="navActivity"><a href="{:U('Activity/index')}">活动中心</a></li> 
      <!---->
      <!--li class="" id="navMobile"><a href="{:U('Index/mobile')}">手机购彩</a></li> 
      <!---->
      <li class="" id="navSecurityCenter"><a href="{:U('Member/index')}">我的账户</a></li> 
      <!---->
      <!--li class="" id="navHelp"><a href="{:U('News/lists',array('catid'=>33))}">帮助指南</a></li--> 
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
                url:"{:U('Account/refreshmoney')}",
                type:'POST',
                success :function (data) {
                    $('.smallmoney').html(data);
                }
            })
        })

    })
</script>