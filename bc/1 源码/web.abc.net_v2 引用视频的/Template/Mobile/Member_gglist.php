<include file="Public/header" />
<link rel="stylesheet" href="__CSS__/userHome.css">
<body class="bg_fff">
<header data-am-widget="header"class="am-header am-header-default header nav_bg am-header-fixed">
	<div class="am-header-left am-header-nav">
		<a href="javascript:history.back(-1);" class="">
			<i class="iconfont icon-arrow-left"></i>
		</a>
	</div>
	<div class="winners_tab am-header-title">
		<em class="active" data-title="0">公告</em><!-- <em data-title="1">私信</em> -->
	</div>
</header>
<div data-am-widget="tabs" class="am-tabs am-tabs-d2 billrecord_main">
	<div class="am-tabs-bd">
		<div class="am-tab-panel am-active">
			<div data-am-widget="list_news" class="am-list-news am-list-news-default" >
				<div class="am-list-news-bd">
					<ul class="am-list">
						<volist name="gglist" id="vo">
							<li class="am-g am-list-item-dated">
								<a href="{:U('Member/ggshow',array('aid'=>$vo['id']))}">
									<p class="am-cf">
										<span class="what_type am-fl">{$vo[title]}</span>
									</p>
									<p class="am-cf billrecord_time">
										<span class="am-fl">{$vo[oddtime]|date='Y-m-d',###}</span>
									</p>
								</a>
							</li>
						</volist>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<div  class="am-tabs am-tabs-d2 billrecord_main isplay_no">
	<p style="text-align:center;">暂无私信</p>
</div>
<!--<div data-am-widget="navbar" class="am-navbar am-cf am-navbar-default bottom_navbar am-no-layout">-->
<!--    <ul class="am-navbar-nav am-cf am-avg-sm-5 my_nav_b" style="overflow: visible;background-color: #1c1e23">-->
<!--        <li style="position: relative;">-->
<!--            <a href="/" class="bottom_navbar_list">-->
<!--            <a href="/Index.index.do" class="bottom_navbar_list mynav1">-->
<!--                <i class="iconfont icon-shouyeshouye1" style="color:#07b39e" style="height: 30px;"></i>-->
<!--                <span class="am-navbar-label">首  页</span>-->
<!--            </a>-->
<!--        </li>-->

<!--        <li style="position: relative;">-->
            <!--            <a href="/" class="bottom_navbar_list">-->
<!--            <a href="/Other.xuanmei.do" class="bottom_navbar_list mynav4">-->
<!--                <i class="iconfont icon-lipin"  style="color:#07b39e" style="height: 30px;"></i>-->
<!--                <span class="am-navbar-label">选 美</span>-->
<!--            </a>-->
<!--        </li>-->

<!--        <li style="position: relative;">-->
<!--            <a href="/Index.lotteryHall.do" class="bottom_navbar_list mynav3">-->
<!--                <i class="iconfont icon-jinbei" style="color:#07b39e"></i>-->
<!--                <span class="am-navbar-label">任务</span>-->
<!--            </a>-->
<!--        </li>-->
<!--        <li style="position: relative;">-->
<!--            <a href="/Member.index.do" class="bottom_navbar_list mynav5">-->
<!--                <i class="iconfont icon-wode" style="color:#07b39e" ></i>-->
<!--                <span class="am-navbar-label">我的</span> -->
<!--            </a>-->
<!--        </li>-->
<!--    </ul>-->
<!--</div>-->
</body>
</html>