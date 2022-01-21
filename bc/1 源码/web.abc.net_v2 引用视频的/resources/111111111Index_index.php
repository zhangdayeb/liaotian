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
<include file="Public/header" />
<script type="text/javascript" src="__ROOT__/resources/js/way.min.js"></script>
<script type="text/javascript" src="__ROOT__/resources/main/common.js"></script>
<script type="text/javascript" src="__ROOT__/resources/main/index.js"></script>
<script src="__JS2__/require.js" data-main="__JS2__/homePage"></script>
<div class="main">
    <div class="container">
        <div class="row">
            <div class="col-xs-3 main_left padding_0">
                <ul class="magin_left_list indexcplist" >
                     <volist name="bncaipiao" id="cp">
                        <li>
                             <switch name="cp.typeid">
                                <case value="k3">
                                    <a href="__ROOT__/Game.k3?code={$cp[name]}" title="{$cp[ftitle]}">
                                         <img src="/icon/{$cp[name]}.png" style="height:41px;with:38px;main-right:12px;margin-left:8px;">
                                </case>
                                <case value="lhc">
                                    <a href="__ROOT__/Game.lhc?code={$cp[name]}" title="{$cp[ftitle]}">
                                         <img src="/icon/{$cp[name]}.png" style="height:41px;with:38px;main-right:12px;margin-left:8px;">
                                </case>
                                <case value="ssc">                                                                                                                               <a href="__ROOT__/Game.ssc?code={$cp[name]}" title="{$cp[ftitle]}">
                                         <img src="/icon/{$cp[name]}.png" style="height:41px;with:38px;main-right:12px;margin-left:8px;">
                                </case>
                                <case value="pk10">
                                    <a href="__ROOT__/Game.pk10?code={$cp[name]}" title="{$cp[ftitle]}">
                                         <img src="/icon/{$cp[name]}.png" style="height:41px;with:38px;main-right:12px;margin-left:8px;">
                                </case>
                                <case value="keno">
                                    <a href="__ROOT__/Game.keno?code={$cp[name]}" title="{$cp[ftitle]}">
                                         <img src="/icon/{$cp[name]}.png" style="height:41px;with:38px;main-right:12px;margin-left:8px;">
                                </case>
                                <case value="x5">
                                    <a href="__ROOT__/Game.x5?code={$cp[name]}" title="{$cp[ftitle]}">
                                         <img src="/icon/{$cp[name]}.png" style="height:41px;with:38px;main-right:12px;margin-left:8px;">
                                </case>
                                <case value="dpc">
                                    <a href="__ROOT__/Game.dpc?code={$cp[name]}" title="{$cp[ftitle]}">
                                        <i class="<?php if(strstr($cp['name'],'3d')){echo 'icon-fucai3d fc3d_c';}else{echo ' icon-pailie3 pl3_c';}?>  iconfont " style="color:<?php if(strstr($cp['name'],'3d')){echo '#00b7ee';}else{echo '#38b366';}?>" ></i>
                                </case>
                            </switch>
                            <em>{$cp[title]}</em>
                            <span>{$cp[ftitle]|msubstr='0','6','utf-8',''}</span>
                            </a>
                        </li>
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
                <!--                    <div class="middle_swiper">
                                        <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="100">
                                            <ol class="carousel-indicators">
                                                <li class="active" data-target="#myCarousel" data-slide-to="0"></li>
                                                <li data-target="#myCarousel" data-slide-to="1"></li>
                                            </ol>
                                            <div class="carousel-inner">
                                                <div class="item active">
                                                    <a href=""><img src="img/banner1.png" alt=""></a>
                                                </div>
                                                <div class="item">
                                                    <a href=""><img src="img/banner2.png" alt=""></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->
                <div class="middle_tab main_common_bor">
                    <div class="tab_menu">
                        <ul class="tab_menu_box row margin_0">
                            <volist name="bncaipiao" id="value" key="key">
                                <eq name="value[name]" value="jsk3">
                                    <li class=" active col-xs-4">{$value['title']}</li>
                                </eq>
                                <eq name="value[name]" value="cqssc">
                                    <li class="col-xs-4">{$value['title']}</li>
                                </eq>
                                <eq name="value[name]" value="sh11x5">
                                    <li class="col-xs-4">{$value['title']}</li>
                                </eq>
                            </volist>

                        </ul>
                        <div class="tab_menu_content">
                            <ul class="tab_content_box">
                                <volist name="bncaipiao" id="value" key="key" >
                                    <eq name="value[name]" value="jsk3">
                                        <li style="display:block;">
                                            <div class="sum">
                                                <span class="sum{$value[opencode]|implode=',',###|substr=0,1}"></span>
                                                <i>+</i>
                                                <span class="sum{$value[opencode]|implode=',',###|substr=2,1}"></span>
                                                <i>+</i>
                                                <span class="sum{$value[opencode]|implode=',',###|substr=4,1}"></span>
                                                <i>=</i>
                                                <em>{$value[opencode]|array_sum}</em>
                                            </div>
                                            <p class="words">
                                                <span>当前期：第<em>{$value['expect']}</em>期</span>
                                                <span>开奖号码：第<em>{$value[opencode]|implode=',',###}</em></span>
                                                <span>和值：<em>{$value[opencode]|array_sum}</em></span>
											<span>形态：
												<a href="javascript:void(0);">{$value['daxiao']}</a>
												<a href="javascript:void(0);">{$value['danshuang']}</a>
											</span>
                                            </p>
                                        </li>
                                    </eq>
                                    <eq name="value[name]" value="cqssc">
                                        <li>
                                            <div class="clearfix">
                                                <div class="five_sumber pull-left">
                                                    <em>{$value[opencode][0]}</em>
                                                    <em>{$value[opencode][1]}</em>
                                                    <em>{$value[opencode][2]}</em>
                                                    <em>{$value[opencode][3]}</em>
                                                    <em>{$value[opencode][4]}</em>
                                                </div>
                                                <a href="__ROOT__/Game.ssc?code={$value[name]}" class="bet pull-left">立即投注</a>
                                            </div>
                                            <p class="words">
                                                <span>当前期：第<em>{$value['expect']}</em>期</span>
                                                <span>开奖号码：第<em>{$value[opencode]|implode=',',###}</em></span>
                                            </p>
                                        </li>
                                    </eq>
                                    <eq name="value[name]" value="sh11x5">
                                        <li>
                                            <div class="clearfix">
                                                <div class="five_sumber pull-left">
                                                    <em>{$value[opencode][0]}</em>
                                                    <em>{$value[opencode][1]}</em>
                                                    <em>{$value[opencode][2]}</em>
                                                    <em>{$value[opencode][3]}</em>
                                                    <em>{$value[opencode][4]}</em>
                                                </div>
                                                <a href="__ROOT__/Game.x5?code={$value[name]}" class="bet pull-left">立即投注</a>
                                            </div>
                                            <p class="words">
                                                <span>当前期：第<em>{$value['expect']}</em>期</span>
                                                <span>开奖号码：第<em>{$value[opencode]|implode=',',###}</em></span>
                                            </p>
                                        </li>
                                    </eq>
                                </volist>
                            </ul>
                        </div>
                    </div>
                </div>

                <!--                <div class="middle_tab main_common_bor">
                    <div class="tab_menu">
                        <ul class="tab_menu_box row margin_0">
                            <assign name="i" value='0' />
                            <volist name="bncaipiao" id="value" key="key" offset="0" length='3'>
                                <li class=" <eq name='i' value='0'> active </eq> col-xs-2">{$value['title']}</li>
                                <?php /*$i++;*/?>
                            </volist>
                        </ul>
                        <div class="tab_menu_content">
                            <ul class="tab_content_box">
                                <assign name="j" value='0' />
                                <volist name="bncaipiao" id="value" key="key" offset="0" length='3'>
                                    <li style="display: <eq name='j' value='0'>block<else />none</eq>;">
                                        <div class="sum">
                                            <span class="sum{$value[opencode]|implode=',',###|substr=0,1}"></span>
                                            <i>+</i>
                                            <span class="sum{$value[opencode]|implode=',',###|substr=2,1}"></span>
                                            <i>+</i>
                                            <span class="sum{$value[opencode]|implode=',',###|substr=4,1}"></span>
                                            <i>=</i>
                                            <em>{$value[opencode]|array_sum}</em>
                                        </div>
                                        <p class="words">
                                            <span>当前期：第<em>{$value['expect']}</em>期</span>
                                            <span>开奖号码：第<em>{$value[opencode]|implode=',',###}</em></span>
                                            <span>和值：<em>{$value[opencode]|array_sum}</em></span>
											<span>形态：
												<a href="javascript:void(0);">{$value['daxiao']}</a>
												<a href="javascript:void(0);">{$value['danshuang']}</a>
											</span>
                                        </p>
                                    </li>
                                    <?php /*$j++;*/?>
                                </volist>
                            </ul>
                        </div>
                    </div>
                </div>
                -->

            </div>

            <div class="col-xs-3 main_right padding_0">
                <div class="login clearfix">
                    <if condition="is_array($userinfo)">
                        <div class="succees_box">
                            <p class="user_name">HI,{$userinfo.username}</p>
                            <p class="user_balance">余额：{$userinfo.balance}</p>
                            <p class="user_c_t">
                                <a href="{:U('Account/recharge')}" class="btn bg_red">充 值</a>
                                <a href="{:U('Account/withdrawals')}" class="btn bg_org">提 现</a>
                            </p>
                        </div>
                        <else />
                        <a href="{:U('Home/Public/login')}" class="pull-left">
                            <i class="iconfont">&#xe61e;</i>
                            登 录
                        </a>
                        <a href="{:U('Home/Public/register')}" class="pull-right">
                            用户注册
                        </a>
                    </if>


                </div>
                <div class="ranking main_common_bor">
                    <div class="title">
                        <h3 class="margin_0">昨日奖金榜</h3>
                    </div>
                    <ul class="ranking_list sum_icon">
                        <volist name="list" offset="0" length="3" id="value" key="k">
                            <li data-html="true" class="user_header" data-container="body" data-toggle="popover" data-placement="left"data-content='
                        <div class="ceng"><div class="media"><div class="media-left">
                        <img src="__ROOT__{$value['face']}" alt="" class="media-boject img-circle"><p><?php echo str_replace_cn($value['username'],1,3);?></p></div><div class="media-body"><p class="margin_0">账号：<span><?php echo str_replace_cn($value['username'],1,3);?></span></p><p class="margin_0">等级：<span>{$value['groupname']}</span></p><p class="margin_0">头衔：<span>{$value['touhan']}</span></p><p class="margin_0">累积中奖：<span>{$value['okamountcount']}</span></p></div>
                <div class="media-footer">
                    <volist name="value['k3names']" offset="0" length="6"  id="val">
                        <a href="{:U('Game/k3')}?code={$val[name]}" class="color_res"><span style="color:#333;display: block;margin-top:4px;">{$val.title|substr=0,6}</span><i class="iconfont">&#xe607;</i></a>
                    </volist>
                </div></div></div>'>
        <div class="media clearfix">
            <div class="media-left">
                <img src="__ROOT__{$value['face']}" alt="" class="media-boject img-circle">
            </div>
            <div class="media-body">
                <p class="margin_0">账号昵称：<span><?php echo str_replace_cn($value['username'],1,3);?></span></p>
                <p class="margin_0">昨日奖金：<em>￥{$value['amountcount']}</em></p>
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
    </div>
    <div class="ranking main_common_bor winning" style=" <empty name='userinfo'> height:204px  !important; <else /> height:150px !important; </empty> ">
        <div class="title">
            <h3 class="margin_0">中奖信息</h3>
        </div>
        <div class="ranking_scrooll_box" style="<empty name='userinfo'> height:172px  !important; <else /> height:115px !important; </empty>">
            <ul class="ranking_list ranking_scroll">
                <volist name="list2" id="value">
                    <li data-html="true" class="user_header" data-container="body" data-toggle="popover" data-placement="left"data-content='
                            <div class="ceng"><div class="media"><div class="media-left">
                            <img src="__ROOT__{$value['face']}" alt="" class="media-boject img-circle"><p><?php echo str_replace_cn($value['username'],1,3);?></p></div><div class="media-body"> <p class="margin_0">账号：<span><?php echo str_replace_cn($value['username'],1,3);?></span></p><p class="margin_0">等级：<span>{$value['groupname']}</span></p><p class="margin_0">头衔：<span>{$value['touhan']}</span></p><p class="margin_0">累积中奖：<span>{$value['okamountcount']}</span></p></div>
        <div class="media-footer">
            <volist name="value['k3names']" offset="0" length="7"  id="val">
                <a href="{:U('Game/k3')}?code={$val[name]}" class="color_res"><span style="color:#333;display: block;margin-top:4px;">{$val.title|substr=0,6}</span><i class="iconfont">&#xe607;</i></a>
            </volist>
        </div></div></div>'>
<div class="media">
    <div class="media-left">
        <img src="__ROOT__{$value['face']}" alt="" class="media-boject img-circle">
    </div>
    <div class="media-body">
        <p class="margin_0"><?php echo str_replace_cn($value['username'],1,3);?> <span>在{$value['k3name']}</span></p>
        <p class="margin_0">喜中 <em>￥{$value['okamount']}</em></p>
    </div>
</div>
</li>
</volist>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>

<include file="Public/footer" />
<if condition="$Think.cookie.showgg eq '1' && $Think.session.userinfo neq ''">
<div class='showzhou' style="background: rgba(0,0,0,.4);position: fixed;width: 100%;height: 100%;top: 0;bottom: 0;"></div>
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