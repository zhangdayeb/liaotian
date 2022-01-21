<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{:GetVar('webtitle')}</title>
    <meta name="keywords" content="{:GetVar('keywords')}" />
    <meta name="description" content="{:GetVar('description')}" />
    <meta name="renderer" content="webkit" />
    <link rel="stylesheet" href="__CSS2__/bootstrap.min.css">
    <link rel="stylesheet" href="__CSS2__/reset.css">
    <link rel="stylesheet" href="__CSS2__/icon.css">
    <link rel="stylesheet" href="__CSS2__/header.css">
    <link rel="stylesheet" href="__CSS2__/main.css">
    <link rel="stylesheet" href="__CSS2__/footer.css">

</head>
<body>
<script>
    var WebConfigs = {
        "ROOT" : "__ROOT__",
        'IMG' : "__IMG__",
    }
</script>
<style type="text/css">

    
}
</style>
<include file="Public/header" />
<script type="text/javascript" src="__ROOT__/resources/js/way.min.js"></script>
<script type="text/javascript" src="__ROOT__/resources/main/common.js"></script>
<script type="text/javascript" src="__ROOT__/resources/main/index.js"></script>
<script src="__JS2__/require.js" data-main="__JS2__/homePage"></script>
<div class="main">
    <div class="container">
        <div class="row">
            <div class="col-xs-1 main_left padding_0" style="height:210px; ">
                <ul class="magin_left_list indexcplist" >
                        <li>
                            <a href="{:U('Member/Agent')}" class="pull-left">
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
                    <if condition="is_array($userinfo)">
                        <div class="succees_box">
                            <p class="user_name">HI,{$userinfo.username}</p>
                            <p class="user_balance">余额：{$userinfo.balance}</p>
                            <p class="user_c_t">
                                <a href="{:U('Account/recharge')}" class="btn bg_red" style="width:58px;height:38px;">充 值</a>
                                <a href="{:U('Account/withdrawals')}" class="btn bg_org" style="width:58px;height:38px;">提 现</a>
                        </div>
                        <else />
                        <a href="{:U('Home/Public/login')}" class="pull-left" style="width:230px;height:38px;" >登 录</a>
     
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
                                <a href="{:U('Activity/index')}"><img src="__IMG__/indexbanner1.jpg" alt=""></a>
                            </div>
                            <div class="item">
                                <a href="{:U('Activity/index')}"><img src="__IMG__/indexbanner2.jpg" alt=""></a>
                            </div>
                            <div class="item">
                                <a href="{:U('Activity/index')}"><img src="__IMG__/indexbanner3.jpg" alt=""></a>
                            </div>
                            <div class="item">
                                <a href="{:U('Activity/index')}"><img src="__IMG__/indexbanner4.jpg" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ranking main_common_bor" >
                    <div class="title">
                        <h3 class="margin_0">佣金榜</h3>
                    </div>
                    <ul class="ranking_list sum_icon">
                        <volist name="list" offset="0" length="3" id="value" key="k">
                            <li data-html="true" class="user_header" data-container="body" data-toggle="popover" data-placement="left"data-content='
                        <div class="ceng"><div class="media"><div class="media-left">
                        <img src="__ROOT__{$value['face']}" alt="" class="media-boject img-circle"><p><?php echo str_replace_cn($value['username'],1,3);?></p></div><div class="media-body"><p class="margin_0">账号：<span><?php echo str_replace_cn($value['username'],1,3);?></span></p><p class="margin_0">等级：<span>{$value['groupname']}</span></p><p class="margin_0">头衔：<span>{$value['touhan']}</span></p><p class="margin_0">累积佣金：<span>{$value['okamountcount']}</span></p></div>
                <div class="media-footer">
                    <volist name="value['k3names']" offset="0" length="6"  id="val">
                        
                    </volist>
                </div></div></div>'>
        <div class="media clearfix">
            <div class="media-left">
                <img src="__ROOT__{$value['face']}" alt="" class="media-boject img-circle">
            </div>
            <div class="media-body">
                <p class="margin_0">账号昵称：<span><?php echo str_replace_cn($value['username'],1,3);?></span></p>
                <p class="margin_0">昨日佣金：<em>￥{$value['amountcount']}</em></p>
            </div>

            <switch name="k">
                <case value="1">
                    <span class="backs_red">1</span>
                </case>
                <case value="2">
                    <span class="backs_blue">2</span>
                </case>
                <case value="3">
                    <span class="backs_yellow">3</span>
                </case>
                <default />
                <i class="am-fr winners_num">{$key}</i>
            </switch>
        </div>
        </li>
        </volist>
        </ul>
                

<div class="notice ggpop" style="left: 50%;top: 50%; width: 700px;transform: translate(-50%,-50%); bottom: auto;z-index: 1111; ">
    <div class="noticCon">
        <h3>网站最新公告 <a class="iconfont icon-guanbi-copy closeNotice"></a></h3>
     <ul>
         <volist name="gglist" id="vo" key="k" offset="0" length='1'>
          <li style="font-weight: 600; color: #000; font-size: 14px;">{$vo.title}</li>
          <li style="line-height: 28px;color: #000; font-size: 14px; text-align: left; text-indent: 2em;">{$vo.title}{$vo.content}</li>
         </volist>
    </ul>
    </div>
</div>
 </if> 
<script type="text/javascript">
$('.closeNotice').on('click',function(){
    $('.ggpop').hide();
    $('.showzhou').hide();
    $.ajax({
        url : "{:U('Common/closegg')}",
        type:"POST",
    })
})
</script>
</body>
</html>