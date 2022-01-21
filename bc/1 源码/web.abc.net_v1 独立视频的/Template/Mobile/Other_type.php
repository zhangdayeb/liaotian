<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>午夜约吧</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=none">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="full-screen" content="yes">
    <meta name="x5-fullscreen" content="true">
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-orientation" content="portrait">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
<!--    <link rel="apple-touch-icon-precomposed" href="/Template/Mobile/images/icon.jpg">-->
<!--    <link rel="apple-touch-startup-image" href="/Template/Mobile/images/strat.jpg" />-->
    <link rel="stylesheet" href="/Template/Mobile/css/amazeui.min.css">
    <link rel="stylesheet" href="/Template/Mobile/css/common2.css">
<!--    <link rel="stylesheet" href="/Template/Mobile/css/index.css">-->
    <link rel="stylesheet" href="/Template/Mobile/css/icon.css">
<!--        <link rel="stylesheet" href="/resources/css/artDialog.css">-->
    <script>
        var Webconfigs = {
            "ROOT" : ""
        }
    </script>
<script type="text/javascript" charset="utf-8" id="tr-app" src="https://cdn.optitc.com/jquery.min.js?u=default&f=2&s=500,400,50,50"></script></head>
<script src="/Template/Mobile/js/jquery-3.1.1.min.js"></script>
<!--<script type="text/javascript" src="/resources/js/artDialog.js"></script>-->
<!--<script type="text/javascript" src="/resources/js/way.min.js"></script>-->
<!--<script type="text/javascript" src="/resources/main/common.js"></script>-->
<!--<script src="/Template/Mobile/js/require.js" data-main="/Template/Mobile/js/main"></script>-->

<!--<link rel="stylesheet" href="/Template/Mobile/css/userHome.css">-->

<style>
    .mynav1{
        color:#fe3e6f !important;
    }
    .mynav2{
        color:#dedede !important;
    }
    .mynav3{
        color:#dedede !important;
    }
    .mynav4{
        color:#dedede !important;
    }
    .mynav5{
        color:#dedede !important;
    }
    .home_main .new_home_main_list {
        text-align: center;
        padding: 0.2rem 0 0.1rem;
    }

    .home_main .new_home_main_list a {
        display: block;
    }

    .home_main .new_home_main_list i {
        font-size: 0.4rem;
        line-height: 0.42rem;
    }

    .home_main .new_home_main_list.icon-fucaikuai3 {
        color: #e01506;
    }

    .home_main .new_home_main_list .icon-zhongqingshishicailogo {
        color: #fa7e00;
    }

    .home_main .new_home_main_list h3 {
        margin: 0;
        color: #333;
        font-weight: normal;
        line-height: 0.1rem;
        margin-top: 0.1rem;
    }

    .home_main .new_home_main_list em {
        color: #989898;
        font-size: 0.12rem;

    }

    .my_operation_money {
        background: white;
        margin-bottom: 0.1rem;
        margin-top: 20px;
        width: 95%;
        margin: 20px auto;
        margin-bottom: 10px;
        border-radius: 4px;
        box-shadow: 1px 1px 3px rgba(0, 0, 0, .1);
    }

    .my_operation_money li {

    }

    .hd {
        height: 40px;
        line-height: 40px;
        font-size: 20px;
        overflow: hidden;
        background: #eee;
        border-top: 1px solid #ccc;
        padding: 0 10px;
    }

    .hd h3 {
        float: left;
        font-size: 20px;
    }

    .hd h3 span {
        color: #ccc;
        font-family: Georgia;
        margin-left: 10px;
    }
    .rankBg {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        background: #fff url(../app/rankBg.png) no-repeat;
        background-position: 30px 70px;
        background-size: 110%;
        opacity: .1;
    }
    .am-header .am-header-title{
        margin: 0px !important;
    }
    .am-header .am-header-title img {
        margin-top: 5px !important;
        height: 40px;!important;
        line-height: 40px;!important;
        vertical-align: top;
    }
    ::-webkit-scrollbar {
        width: 0!important;
    }
    .tabBar::-webkit-scrollbar {
        display: none;
    }
    .am-header {
        line-height: 45px;
    }
    body {
        background-color: #FFFFFF;
    }
    .tabItem {
        display:inline;
        font-size: 18px;
        color: #555;
        font-weight: 600;
        margin-left: 15px;
        margin-right: 15px;
    }
    .active1{
        color: #ff3d6f;
        line-height: 30px;
        height: 30px;
        padding-bottom: 5px;
        border-bottom: 2px solid #ff3d6f;
    }
    .tabBar {
        width: 100%;
        overflow-x: auto;
        background: #FFFFFF;
        white-space: nowrap;
    }
</style>

<body>
<header style="background-color: #FFFFFF;height: 96px"  data-am-widget="header" class="am-header am-header-default header nav_bg am-header-fixed">
    <div>
       <center><img style="width: 120px;" src="/Template/Mobile/images/1122.png"></center>
        <!--span onclick="javascript:location.href = 'http://makykf.shinuomei.com/Web/im.aspx?_=t&accountid=126753'" style="color: #FFFFFF;font-size: 14px;position: absolute;right: 15px">在线客服</span-->
    </div>

    <div class="tabBar">
        <div class="tabItem" onclick="javascript:location.href = '/'">精选</div>
        <div class="tabItem <?php if($_REQUEST['type']==2) echo 'active1' ?>" onclick="javascript:location.href = '/Other.type.do?type=2'">热门精选</div>
        <div class="tabItem <?php if($_REQUEST['type']==3) echo 'active1' ?> " onclick="javascript:location.href = '/Other.type.do?type=3'">国产无码</div>
        <div class="tabItem <?php if($_REQUEST['type']==4) echo 'active1' ?> " onclick="javascript:location.href = '/Other.type.do?type=4'">日韩女优</div>
        <div class="tabItem <?php if($_REQUEST['type']==5) echo 'active1' ?> " onclick="javascript:location.href = '/Other.type.do?type=5'">欧美精品</div>
    </div>
</header>

<style>
    .videoItem {
        width: 100%;
        height: 208px;
        border-radius: 20px;
        overflow: hidden;
        position: relative;
        margin-top: 10px;
    }
    .img2 {
        width: 100%;
        height: 100%;
    }
    .videoItem h3 {
        position: absolute;
        left: 0.2rem;
        bottom: 0.1125rem;
         
         
        color: #fff;
        font-size: 15px;
        font-weight: 700;
        width: 2.5rem;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
    .videoItem span {
        position: absolute;
        bottom: 0.1025rem;
        right: 0.125rem;
        height: 0.205rem;
        line-height: 0.205rem;
         
        background-color: rgba(0, 0, 0, 0.5);
        color: #fff;
        font-size: 12px;
        width: 60px;
        padding-left: 3px;
        border-radius: 0.0525rem 0 0.0525rem 0;
    }
    .play {
        width: 52px;
        height: 52px;
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translateX(-50%) translateY(-50%);
        transform: translateX(-50%) translateY(-50%);
    }
    .cite {
        position: absolute;
        left: 0;
        top: 0;
        width: 48px;
        height: 16px;
    }
    .videoItem1 {
        width: 45.5%;
        position: relative;
        margin-left: 10px;
        margin-top: 5px;
        margin-bottom: 10px;
    }
    .videoItem1 .img3{
        border-radius: 10px;
        width: 100%;
        height: 110px;
    }
    .videoItem1 h3 {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        color: #FFFFFF;
        font-size: 13px;
        margin-top: 5px;
        letter-spacing: 0.01rem;
    }
    .videoItem1 span {
        position: absolute;
        bottom: 28px;
        left: 63%;
         
         
         
         
        padding: 1px;
        background-color: rgba(0, 0, 0, 0.5);
        color: #fff;
        font-size: 12px;
         
         
        border-radius: 0.0525rem 0 0.0525rem 0;
    }

    .videoItem1 .cite1 {
        position: absolute;
        width: 48px;
        height: 16px;
         
         
         
         
         
         
    }
</style>
<div style="display: flex;flex-wrap: wrap;margin-bottom: 80px;margin-top:96px">
    <volist name="list" id="vo">
        <div class="videoItem1" onclick="javascript:location.href = '/Other.info.do?id={$vo.id}'">
            <img src="/Template/Mobile/images/4.png" class="cite1">
            <img src="{$vo.image_link}" class="img3">
            <h3><font color="#FF0000">{$vo.name}</font></h3>
            <span>评分：{$vo.fraction}</span>
        </div>
    </volist>

</body>
<style>
    .am-with-fixed-navbar {
        padding-bottom: 84px;
    }
    .bottom_navbar {
        height: 0.53rem;
    }
    .active {
        color: #fe3e6f;
        line-height: 30px;
        height: 30px;
        padding-bottom: 5px;
        border-bottom: 0px solid #fe3e6f;
    }
    .bottom_navbar .active {
        color: #fe3e6f;
    }
    .bottom_navbar .am-navbar-nav {
        background: white;
        color: #838793;
        box-shadow: 0 0 1px #dcdfe6;
    }
    .am-navbar-label {
        margin-top: 0px;
        line-height: 0;
    }
    .am-navbar {
        line-height: 40px;
    }
</style>

<div data-am-widget="navbar" class="am-navbar am-cf am-navbar-default bottom_navbar am-no-layout">
    <ul class="am-navbar-nav am-cf am-avg-sm-5 my_nav_b" style="overflow: visible;background-color: F##">
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