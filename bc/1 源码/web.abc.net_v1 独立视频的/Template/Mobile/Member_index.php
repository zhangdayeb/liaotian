<include file="Public/header" />
<style>
    .mynav1:visited{
        color: red;
    }
    .mynav1{
        color:#dedede !important;
    }
    .mynav2{
        color:#dedede !important;
    }
    .mynav2:visited{
        color: red;
    }
    .mynav3{
        color:#dedede !important;
    }
    .mynav3:visited{
        color: red;
    }
    .mynav4{
        color:#dedede !important;
    }
    .mynav4:visited{
        color: red;
    }
    .mynav5:visited{
        color: red;
    }
    /*.mynav5{*/
    /*    color:#dedede !important;*/
    /*}*/
</style>
<link rel="stylesheet" href="__CSS__/userHome.css">
<body>
<header data-am-widget="header"class="am-header am-header-default header nav_bg am-header-fixed">
    <h1 class="am-header-title userHome_h1">
        我的账户
    </h1>
    <div class="am-header-right am-header-nav header_down">
        <a href="{:GetVar('kefuthree')}" class="">
            客服
        </a>
    </div>
</header>

<div class="my_header">
    <div class="my_info am-cf">
        <div class="img am-fl">
            <img src="__ROOT__{$userinfo['face']}" class="am-radius" alt="">
        </div>
        <div class="am-fl my_header_content">
            <p>账号：<em>{$userinfo['username']}</em></p>

            <p>余额：{$userinfo['balance']} </p>
        <p><a href="{:U('Member.index.do')}">余额刷新</p>
        </div>

    </div>
    <div class="my_operation_money">
        <ul class="am-avg-sm-4">
            <li>
                <a href="{:U('Account/rechargeList')}">
                    <i class="iconfont icon-chongzhi"></i>
                    <em>我要充值</em>
                </a>
            </li>
            <li>
                <a href="{:U('Account/withdrawals')}">
                    <i class="iconfont icon-tixian"></i>
                    <em>我要提现</em>
                </a>
            </li>
            <li>
                <a href="{:U('Account/dealRecord')}">
                    <i class="iconfont icon-jiaoyijilu"></i>
                    <em>交易记录</em>
                </a>
            </li>
            <li>
                <a href="{:U('Member/betRecord')}">
                    <i class="iconfont icon-touzhujilu"></i>
                    <em>下单记录</em>
                </a>
            </li>
        </ul>
    </div>
</div>

<ul class="my_set_list">
    <li>
        <a href="{:U('Member/personalInfo')}" class="am-cf">
            <i class="iconfont icon-wode square_bg"></i>
            <span>个人信息</span>
            <i class="iconfont icon-arrowright"></i>
        </a>
    </li>
   <eq name="userinfo['proxy']" value="1">
    <li>
        <a href="http://154.22.127.171/" class="am-cf">
            <i class="iconfont icon-qian square_bg" style="background: #dd514c;"></i>
            <span>代理大厅(PC)</span>
            <i class="iconfont icon-arrowright"></i>
        </a>
    </li>
   </eq>
   <li>
        <a href="{:U('Member/agent1')}" class="am-cf">
            <i class="iconfont icon-qian square_bg" style="background: #dd514c;"></i>
            <span>代理中心(M)</span>
            <i class="iconfont icon-arrowright"></i>
        </a>
    </li>
   </eq>
    <li>
        <a href="{:U('Member/Message')}" class="am-cf">
            <i class="iconfont icon-tubiao15 square_bg"></i>
            <span>站内消息（<em class="message_number" style="color: red;">0</em>）</span>
            <i class="iconfont icon-arrowright"></i>
        </a>
    </li>
   <!-- <eq name="userinfo['proxy']" value="1">-->
   <!-- <li>-->
   <!--     <a href="{:U('Member/agents')}" class="am-cf">-->
   <!--         <i class="iconfont icon-qian square_bg" style="background: #dd514c;"></i>-->
   <!--         <span>下级账户</span>-->
   <!--         <i class="iconfont icon-arrowright"></i>-->
   <!--     </a>-->
   <!-- </li>-->
   <!--</eq>-->
    <li>
        <a href="{:U('Member/setting')}" class="am-cf">
            <i class="iconfont icon-safe square_bg"></i>
            <span>安全中心</span>
            <i class="iconfont icon-arrowright"></i>
        </a>
    </li>
	<!--<li>-->
 <!--       <a href="/Activity.index.do" class="am-cf">-->
 <!--           <i class="iconfont icon-giftfill square_bg" style="background:#f37b1d;"></i>-->
 <!--           <span>活动中心</span>-->
 <!--           <i class="iconfont icon-arrowright"></i>-->
 <!--       </a>-->
 <!--   </li>-->
	<!-- <li>-->
 <!--       <a href="{:U('Member/trans')}" class="am-cf">-->
 <!--           <i class="iconfont icon-shuju square_bg"></i>-->
 <!--           <span>额度转换</span>-->
 <!--           <i class="iconfont icon-arrowright"></i>-->
 <!--       </a>-->
 <!--   </li>	-->
    <!--<li>-->
    <!--    <a href="{:U('Account/todayLoss')}" class="am-cf">-->
    <!--        <i class="iconfont icon-shuju square_bg"></i>-->
    <!--        <span>今日盈亏</span>-->
    <!--        <i class="iconfont icon-arrowright"></i>-->
    <!--    </a>-->
    <!--</li>-->
    <li>
        <a href="{:U('Member/gglist')}" class="am-cf">
            <i class="iconfont icon-tubiao15 square_bg"></i>
            <span>平台公告</span>
            <i class="iconfont icon-arrowright"></i>
        </a>
    </li>
</ul>
<div class="security_close">
    <a href="javascript:if(confirm('是否退出？'))location='{:U('Public/LoginOut')}'" class="am-cf">
        <span>退出登录</span>
        <i class="iconfont icon-arrowright am-fr"></i>
    </a>
</div>

<div data-am-widget="navbar" class="am-navbar am-cf am-navbar-default bottom_navbar am-no-layout">
    <ul class="am-navbar-nav am-cf am-avg-sm-5 my_nav_b" style="overflow: visible;background-color: F##">
        <li style="position: relative;">
<!--            <a href="/" class="bottom_navbar_list">-->
            <a href="/Index.index.do" class="bottom_navbar_list mynav1">
                <i class="iconfont icon-shouyeshouye1" style="color:#07b39e" style="height: 30px;"></i>
                <span class="am-navbar-label">首页</span>
            </a>
        </li>

        <li style="position: relative;">
            <!--            <a href="/" class="bottom_navbar_list">-->
            <a href="/Other.xuanmei.do" class="bottom_navbar_list mynav4">
                <i class="iconfont icon-lipin"  style="color:#07b39e" style="height: 30px;"></i>
                <span class="am-navbar-label">选美</span>
            </a>
        </li>

        <li style="position: relative;">
            <a href="/Index.lotteryHall.do" class="bottom_navbar_list mynav3">
                <i class="iconfont icon-jinbei" style="color:#07b39e"></i>
                <span class="am-navbar-label">活动</span>
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
    // $(document).on('click','.security_close',function () {

    // })
</script>
</body>
</html>