<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{:GetVar('webtitle')}</title>
<meta name="keywords" content="{:GetVar('keywords')}" />
<meta name="description" content="{:GetVar('description')}" />
<meta name="renderer" content="webkit" />
<link rel="stylesheet" type="text/css" href="__ROOT__/resources/css/reset.css" />
<link rel="stylesheet" type="text/css" href="__ROOT__/resources/css/layout.css" />
<link rel="stylesheet" type="text/css" href="__ROOT__/resources/css/artDialog.css" />
<link rel="stylesheet" type="text/css" href="__ROOT__/resources/css/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="__ROOT__/resources/css/k3.css" />
<link rel="stylesheet" href="__CSS2__/bootstrap.min.css">
<link rel="stylesheet" href="__CSS2__/reset.css">
<link rel="stylesheet" href="__CSS2__/icon.css">
<link rel="stylesheet" href="__CSS2__/header.css">
<link rel="stylesheet" href="__CSS2__/footer.css">
<link rel="stylesheet" href="__CSS__/style.css"> 
<link rel="stylesheet" href="__CSS2__/main.css">
<link rel="stylesheet" href="__CSS__/common.css">
<link rel="stylesheet" href="__CSS2__/jquery-ui.min.css">
<script>
var WebConfigs = {
	webtitle:"{$webconfigs.webtitle}",
	kefuthree:"{$webconfigs.kefuthree}",
	kefuqq:"{$webconfigs.kefuqq}",
	ROOT : "__ROOT__"
};
</script>
<script>
<?php echo "var k3lotteryrates = ".json_encode($rates,JSON_UNESCAPED_UNICODE);?>
</script>

<!--[if lt IE 9]>
<script src="__ROOT__/resources/js/html5shiv.js"></script>
<![endif]-->

</head>

<body>
<style>	
	.j_lottery_time .shij span{
		color: #fff;
		font-size: 36px;
	}
</style>
<include file="Public/gameHeader" />
<script type="text/javascript" src="__ROOT__/resources/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="__ROOT__/resources/js/artDialog.js"></script>
<script type="text/javascript" src="__ROOT__/resources/js/member.page.js"></script>
<script type="text/javascript" src="__ROOT__/resources/js/way.min.js"></script>
<script type="text/javascript" src="__ROOT__/resources/js/jquery.history.js"></script>
<script type="text/javascript" src="__ROOT__/resources/main/common.js"></script>
<script type="text/javascript" src="__ROOT__/resources/main/index.js"></script>
<script type="text/javascript" src="__ROOT__/resources/main/k3.js"></script>
<script type="text/javascript" src="__ROOT__/resources/js2/bootstrap.min.js"></script>
<script type="text/javascript" src="__ROOT__/resources/js/jquery-ui.min.js"></script>
<!--<script src="__JS2__/require.js" data-main="__JS2__/homePage"></script>-->

<section class="container wapper" id="gamepage" style="width:1030px!important;">
	<div class="open_containers g_Time_Section">
        <!--??????logo-->
        <div class="cz_logo">
            <h2 class="lottery_title_h2" way-data="showLotteryTitle.name">---</h2>
            <a href="javascript:void(0)" >
                 <img src="/icon/{$lotteryname}.png" style="height:60px;with:60px;main-right:12px;margin-left:12px;">
            </a>
        </div>
        <!--??????logo-->
        <!--?????????????????????-->
        <div class="cz_daojishi">
            <div class="open_issue">???&nbsp;&nbsp;
				<b class="c_red" id="f_lottery_info_number" way-data="showExpect.currFullExpect">---</b>&nbsp;&nbsp;????????????????????????
			</div>
            <div class="j_lottery_time" servertime="" style="font-size: 22px; color: rgb(255, 255, 255);">
				<div class="shij">
                	<span way-data="gametimes.h">00</span>
                    :
                	<span way-data="gametimes.m">00</span>
                    :
                	<span way-data="gametimes.s">00</span>
                </div>
			</div>
        </div>
        <!--?????????????????????-->

        <!--??????????????????-->
        <div class="cz_openNumb">

            <div class="open_issue">???&nbsp;&nbsp;<b class="c_red" way-data="showExpect.lastFullExpect" id="f_lottery_info_lastnumber" firstissueno="">---</b>&nbsp;&nbsp;?????????????????????</div>
            <div class="open_number">
                <input type="hidden" value="1,1,2" id="j_openNum"><!--????????????????????????-->
                <ul id="openNum_list">
					<li class="open_numb_gif"></li>
					<li class="open_numb_gif"></li>
					<li class="open_numb_gif"></li>
				</ul>
            </div>

        </div>
        <!--??????????????????-->
    </div>
    
	<div class="lottery_playContainer">
		<div class="system_lottery_box">
			<span class="prev">
				<i class="iconfont icon-a866"></i>
			</span>
			<ul class="system_lottery" style="width: 1506px;">
				<!--????????????-->
				<volist name="k3list" id="vo">
					<li <if condition="$vo['name'] eq $lotteryname">class="curr"</if> lotteryname="{$vo.name}">
						<a href="__ROOT__/Game.k3?code={$vo.name}">{$vo.title}</a>
					</li>
				</volist>	
			</ul>
			<span class="next">
				<i class="iconfont icon-a866"></i>
			</span>
        </div>

		<div class="play_select_insert" id="j_play_select">
			<ul class="play_select_tit">
				<li lottery_code="k3hzzx" class="curr">??????</li>	
				<li lottery_code="k3sthtx">???????????????</li>
				<li lottery_code="k3sthdx">???????????????</li>
				<li lottery_code="k3sbthbz">????????????</li>
				<li lottery_code="k3slhtx">???????????????</li>
				<li lottery_code="k3slhdx">???????????????</li>
				<li lottery_code="k3ethfx">???????????????</li>
				<li lottery_code="k3ethdx">???????????????</li>
				<li lottery_code="k3ebthbz">????????????</li> 
			</ul>
		</div>


    <section id="gameBet" class="cl">
		<section class="gameBet_balls">
			<div class="gameBet_left l">
			<if condition="$nowcpinfo['iswh'] eq 0">
				<div class="bet-num-box ">
					<div class="k3hzzx" style="display:block">
						<p class="text-c pt-10 pb-10">???????????????????????????1???????????????????????????????????????????????????????????????????????????????????????1.95-168???</p>
						<div class="g_Number_Section">
						<ul>
							<li><a class="ball_number" playid="k3hz3" ball-number="3" href="javascript:void(0)">3</a><span class="ball_aid" rate_k3hz3></span></li>
							<li><a class="ball_number" playid="k3hz4" ball-number="4" href="javascript:void(0)">4</a><span class="ball_aid" rate_k3hz4></span></li>
							<li><a class="ball_number" playid="k3hz5" ball-number="5" href="javascript:void(0)">5</a><span class="ball_aid" rate_k3hz5></span></li>
							<li><a class="ball_number" playid="k3hz6" ball-number="6" href="javascript:void(0)">6</a><span class="ball_aid" rate_k3hz6></span></li>
							<li><a class="ball_number" playid="k3hz7" ball-number="7" href="javascript:void(0)">7</a><span class="ball_aid" rate_k3hz7></span></li>
							<li><a class="ball_number" playid="k3hz8" ball-number="8" href="javascript:void(0)">8</a><span class="ball_aid" rate_k3hz8></span></li>
							<li><a class="ball_number" playid="k3hz9" ball-number="9" href="javascript:void(0)">9</a><span class="ball_aid" rate_k3hz9></span></li>
							<li><a class="ball_number" playid="k3hz10" ball-number="10" href="javascript:void(0)">10</a><span class="ball_aid" rate_k3hz10></span></li>
						 </ul>
						 <ul>
							<li><a class="ball_number" playid="k3hz11" ball-number="11" href="javascript:void(0)">11</a><span class="ball_aid" rate_k3hz11></span></li>
							<li><a class="ball_number" playid="k3hz12" ball-number="12" href="javascript:void(0)">12</a><span class="ball_aid" rate_k3hz12></span></li>
							<li><a class="ball_number" playid="k3hz13" ball-number="13" href="javascript:void(0)">13</a><span class="ball_aid" rate_k3hz13></span></li>
							<li><a class="ball_number" playid="k3hz14" ball-number="14" href="javascript:void(0)">14</a><span class="ball_aid" rate_k3hz14></span></li>
							<li><a class="ball_number" playid="k3hz15" ball-number="15" href="javascript:void(0)">15</a><span class="ball_aid" rate_k3hz15></span></li>
							<li><a class="ball_number" playid="k3hz16" ball-number="16" href="javascript:void(0)">16</a><span class="ball_aid" rate_k3hz16></span></li>
							<li><a class="ball_number" playid="k3hz17" ball-number="17" href="javascript:void(0)">17</a><span class="ball_aid" rate_k3hz17></span></li>
							<li><a class="ball_number" playid="k3hz18" ball-number="18" href="javascript:void(0)">18</a><span class="ball_aid" rate_k3hz18></span></li>
						 </ul>
						 <ul>
							<li><a class="ball_number" playid="k3hzbig" ball-number="???" href="javascript:void(0)">???</a><span class="ball_aid" rate_k3hzbig></span></li>
							<li><a class="ball_number" playid="k3hzsmall" ball-number="???" href="javascript:void(0)">???</a><span class="ball_aid" rate_k3hzsmall></span></li>
							<li><a class="ball_number" playid="k3hzodd" ball-number="???" href="javascript:void(0)">???</a><span class="ball_aid" rate_k3hzodd></span></li>
							<li><a class="ball_number" playid="k3hzeven" ball-number="???" href="javascript:void(0)">???</a><span class="ball_aid" rate_k3hzeven></span></li>
						</ul>
						</div>
					</div>
					<div class="k3sthtx" style="display:none">
						<p class="text-c pt-10 pb-10">10?????????6????????????(111,222,333,444,555,666)?????????????????????????????????????????????<span class="ball_aid" rate_k3sthtx style="display:inline">???????????????...</span>??????</p>
						<div class="g_Number_Section">
							<a class="ball_number" playid="k3sthtx" ball-number="???????????????" href="javascript:void(0)">???????????????</a>
						</div>
					</div>
					
					<div class="k3sthdx" style="display:none;">
						<p class="text-c pt-10 pb-10">????????????1?????????????????????????????????????????????????????????<span class="ball_aid" rate_k3sthdx style="display:inline">???????????????...</span>??????</p>
					<div class="g_Number_Section">
					 <ul>
						<li><a class="ball_number" playid="k3sthdx" ball-number="111" href="javascript:void(0)">111</a></li>
						<li><a class="ball_number" playid="k3sthdx" ball-number="222" href="javascript:void(0)">222</a></li>
						<li><a class="ball_number" playid="k3sthdx" ball-number="333" href="javascript:void(0)">333</a></li>
						<li><a class="ball_number" playid="k3sthdx" ball-number="444" href="javascript:void(0)">444</a></li>
						<li><a class="ball_number" playid="k3sthdx" ball-number="555" href="javascript:void(0)">555</a></li>
						<li><a class="ball_number" playid="k3sthdx" ball-number="666" href="javascript:void(0)">666</a></li>
						</ul>
					</div>
					</div>
		
					<div class="k3sbthbz" style="display:none">
						<p class="text-c pt-10 pb-10">????????????3??????????????????????????????????????????????????????<span class="ball_aid" rate_k3sbthbz style="display:inline">???????????????...</span>??????</p>
						<div class="g_Number_Section">
						<ul>
							<li><a class="ball_number" playid="k3sbthbz" ball-number="1" href="javascript:void(0)">1</a></li>
							<li><a class="ball_number" playid="k3sbthbz" ball-number="2" href="javascript:void(0)">2</a></li>
							<li><a class="ball_number" playid="k3sbthbz" ball-number="3" href="javascript:void(0)">3</a></li>
							<li><a class="ball_number" playid="k3sbthbz" ball-number="4" href="javascript:void(0)">4</a></li>
							<li><a class="ball_number" playid="k3sbthbz" ball-number="5" href="javascript:void(0)">5</a></li>
							<li><a class="ball_number" playid="k3sbthbz" ball-number="6" href="javascript:void(0)">6</a></li>
					 	</ul>
						 </div>
					</div>
					<div class="k3slhtx" style="display:none">
						<p class="text-c pt-10 pb-10">10?????????4???????????????123???234???345???456????????????????????????????????????????????????<span class="ball_aid" rate_k3slhtx style="display:inline">???????????????...</span>??????</p>
						<div class="g_Number_Section">
						<a class="ball_number" playid="k3slhtx" ball-number="???????????????" href="javascript:void(0)">???????????????</a>
						</div>
					</div>
		
					<div class="k3slhdx" style="display:none">
						<p class="text-c pt-10 pb-10">10?????????1??????????????????(123,234,345,456)?????????????????????????????????????????????<span class="ball_aid" rate_k3slhdx style="display:inline">???????????????...</span>??????</p>
						<div class="g_Number_Section">
						<ul>
							<li><a class="ball_number" playid="k3slhdx" ball-number="123" href="javascript:void(0)">123</a></li>
							<li><a class="ball_number" playid="k3slhdx" ball-number="234" href="javascript:void(0)">234</a></li>
							<li><a class="ball_number" playid="k3slhdx" ball-number="345" href="javascript:void(0)">345</a></li>
							<li><a class="ball_number" playid="k3slhdx" ball-number="456" href="javascript:void(0)">456</a></li>
					 	</ul>
						 </div>
					</div>
		
					<div class="k3ethfx" style="display:none">
						<p class="text-c pt-10 pb-10">10?????????1????????????(11*,22*,33*,44*,55*,66*)?????????????????????????????????????????????<span class="ball_aid" rate_k3ethfx style="display:inline">???????????????...</span>??????</p>
						<div class="g_Number_Section">
						<ul>
						<li><a class="ball_number" playid="k3ethfx" ball-number="11" href="javascript:void(0)">11</a></li>
						<li><a class="ball_number" playid="k3ethfx" ball-number="22" href="javascript:void(0)">22</a></li>
						<li><a class="ball_number" playid="k3ethfx" ball-number="33" href="javascript:void(0)">33</a></li>
						<li><a class="ball_number" playid="k3ethfx" ball-number="44" href="javascript:void(0)">44</a></li>
						<li><a class="ball_number" playid="k3ethfx" ball-number="55" href="javascript:void(0)">55</a></li>
						<li><a class="ball_number" playid="k3ethfx" ball-number="66" href="javascript:void(0)">66</a></li>
					 </ul>
					 </div>
					</div>
		
					<div class="k3ethdx" style="display:none">
						<p class="text-c pt-10 pb-10">??????1??????????????????1????????????????????????????????????????????????????????????<span class="ball_aid" rate_k3ethdx style="display:inline">???????????????...</span>??????</p>
						<div class="g_Number_Section">
						<ul>
						<li><a class="ball_number" playid="k3ethdx" ball-number="11" href="javascript:void(0)">11</a></li>
						<li><a class="ball_number" playid="k3ethdx" ball-number="22" href="javascript:void(0)">22</a></li>
						<li><a class="ball_number" playid="k3ethdx" ball-number="33" href="javascript:void(0)">33</a></li>
						<li><a class="ball_number" playid="k3ethdx" ball-number="44" href="javascript:void(0)">44</a></li>
						<li><a class="ball_number" playid="k3ethdx" ball-number="55" href="javascript:void(0)">55</a></li>
						<li><a class="ball_number" playid="k3ethdx" ball-number="66" href="javascript:void(0)">66</a></li>
					 </ul>
						<ul>
						<li><a class="ball_number" playid="k3ethdx" ball-number="1" href="javascript:void(0)">1</a></li>
						<li><a class="ball_number" playid="k3ethdx" ball-number="2" href="javascript:void(0)">2</a></li>
						<li><a class="ball_number" playid="k3ethdx" ball-number="3" href="javascript:void(0)">3</a></li>
						<li><a class="ball_number" playid="k3ethdx" ball-number="4" href="javascript:void(0)">4</a></li>
						<li><a class="ball_number" playid="k3ethdx" ball-number="5" href="javascript:void(0)">5</a></li>
						<li><a class="ball_number" playid="k3ethdx" ball-number="6" href="javascript:void(0)">6</a></li>
					 </ul>
					 </div>
					</div>
		
					<div class="k3ebthbz" style="display:none">
						<p class="text-c pt-10 pb-10">????????????2??????????????????????????????????????????????????????<span class="ball_aid" rate_k3ebthbz style="display:inline">???????????????...</span>??????</p>
						<div class="g_Number_Section">
						<ul>
							<li><a class="ball_number" playid="k3ebthbz" ball-number="1" href="javascript:void(0)">1</a></li>
							<li><a class="ball_number" playid="k3ebthbz" ball-number="2" href="javascript:void(0)">2</a></li>
							<li><a class="ball_number" playid="k3ebthbz" ball-number="3" href="javascript:void(0)">3</a></li>
							<li><a class="ball_number" playid="k3ebthbz" ball-number="4" href="javascript:void(0)">4</a></li>
							<li><a class="ball_number" playid="k3ebthbz" ball-number="5" href="javascript:void(0)">5</a></li>
							<li><a class="ball_number" playid="k3ebthbz" ball-number="6" href="javascript:void(0)">6</a></li>
					 	</ul>
						 </div>
					</div>
				</div> 
				<div class="addtobet" style="display:none;">
					<button class="addtobetbtn" type="button">?????????????????????</button>
				</div>
				<div class="xiad-left">
				<dl class="g_Order_Section">
				
				</dl>
				</div>     
				<div class="g_Chase_Section">
					<div class="chase_Program">
						<p class="p_chase">????????????
							<i class="c_green fw_600" way-data="ytotal_money_zhushu" id="f_gameOrder_lotterys_num">0</i> ?????? 
							?????? <i class="c_org fw_600">??<em id="f_gameOrder_amount" way-data="ytotal_money">0</em></i> ???  
						</p>
					</div>
				</div>   
				<div class="xiad-righ">
					<ul>
						<li class="li22"><span id="f_submit_order">
							<img src="__ROOT__/resources/images/icon/icon_06.png">&nbsp;&nbsp;????????????</span>
						</li>
						<li class="li22 li23"><span id="orderlist_clear">
							<img src="__ROOT__/resources/images/icon/icon_19.png">&nbsp;&nbsp;????????????</span>
						</li>
					</ul>
				</div>
			<else />
			<img src="__ROOT__/resources/images/k3cpcz.png" />
			</if>
			</div>

			
		</section>
		<!--??????????????????-->
        <div class="gameBet_right">
            <!--??????????????????-->
            <div class="right_infsoBlock">
                <div class="title">
                    <span class="fl">????????????</span>
                    <span class="fr">
                    <a target="_blank" class="open_lotteryNumb_chart yopen_explain"  href="{:U('Trend/trend_k3',array('code'=>$nowcpinfo['name']))}">?????????</a>
                    |
                    <a href="javascript:void(0);" class="yopen_explain helps">????????????</a>
                    </span>
                </div>
                <div class="block_container lishi">
                    <table id="fn_getoPenGame" border="0px" cellpadding="0" cellspacing="0">
                        <colgroup>
                            <col width="93px" />
                            <col width="50px" />
                            <col width="40px" />
                            <col width="59px" />
                        </colgroup>
                        <thead>
                        <tr>
                            <th>??????</th>
                            <th>??????</th>
                            <th>??????</th>
                            <th>??????</th>
                        </tr>
                        </thead>
                        <tbody class="tbody text-c">
                        <!--????????????-->
                        <!--????????????-->
                        <!--??????-->
                        <!--??????-->
                        <!--??????-->
                        </tbody>
                    </table>
                </div>
            </div>
            <!--??????????????????-->

            <!--??????????????????-->
            <div class="least_luckMember">
                <div class="title">
                    <span>????????????</span>
                    <em class="to_update">????????????????????????</em>
                </div>
                <div class="ranking_scroll_box">
                <ul class="ranking_list sum_icon ranking_scroll">

                    <volist name="list2" id="value" offset="0" length="7">
                    <li data-html="true" class="user_header" data-container="body" data-toggle="popover" data-placement="left" data-content="<div class=&quot;ceng&quot;><div class=&quot;media&quot;><div class=&quot;media-left&quot;><img src=&quot;__ROOT__{$value['face']}&quot; alt=&quot;&quot; class=&quot;media-boject img-circle&quot;><p></p></div><div class=&quot;media-body&quot;><p class=&quot;margin_0&quot;>?????????<span>{$value['username']|substr_replace='**',1,2}</span></p><p class=&quot;margin_0&quot;>?????????<span>{$value['groupname']}</span></p><p class=&quot;margin_0&quot;>?????????<span>{$value['touhan']}</span></p><p class=&quot;margin_0&quot;>???????????????<span>{$value['okamountcount']}</span></p></div>
                   <div class=&quot;media-footer&quot; style=&quot;padding-top:3px;&quot;>
                       <volist name="value['k3names']" offset="0" length="7"  id="val">
                         <a href=&quot;{:U('Game/k3')}?code={$val[name]}&quot; class=&quot;color_res&quot; ><span style=&quot;color:#333&quot;>{$val.title|substr=0,6}</span><i class=&quot;iconfont&quot;>???</i></a>
                       </volist>
                   </div></div></div>" data-original-title="" title="">
                        <div class="media clearfix">
                            <div class="media-left">
                                <img src="__ROOT__{$value['face']}" alt="" class="media-boject img-circle">
                            </div>
                            <div class="media-body">
                                <p class="margin_0">???????????????<span>{$value['username']|substr_replace='**',1,2}</span></p>
                                <p class="margin_0">???????????????<em>{$value['okamount']}</em></p>
                            </div>
                        </div>
                    </li>
                    </volist>
                </ul>
                </div>
            </div>
            <!--??????????????????-->
        </div>
        <!--??????????????????-->
		<!--<section class="gameBet_openlists">
			<div class="jinqi">
				<div class="title" style="height:30px; line-height:30px; border-bottom:1px solid #ddd">
                    <p class="pull-left" style="margin-left:10px;">
                        <img src="__ROOT__/resources/images/jbei.jpg" />????????????
                    </p>
                    <p class="pull-right" style="margin-right:10px;">
                        <a href="{:U('Game/trend',['code'=>$lotteryname])}">????????????</a>
                    </p>
                </div>
				<div class="lishi">
				<table>
					<tbody class="text-c"></tbody>
				</table>
				</div>
			</div>
		</section>-->
    </section>
<!--????????????---->
<section class="historylist mt-20">
	<div class="history-box">
		<div class="tabBd lot-tabBd" style="display:block">
			<table class="mem-biao" id="userBets">
				<thead>
				<tr>
					<th>?????????</th>
					<th>??????</th>
					<th>?????????</th>
					<th>??????</th>
					<th>??????</th>
					<th>????????????</th>
					<th>??????</th>
					<th>????????????</th>
					<th>??????</th>
				</tr>
				</thead>
				<tbody id="userBetsListToday"></table>
		</div>
		<div class="member-pag paging"></div>
	</div>
</section>
</section>
</div>
<include file="Public/footer" />

<div id="submitComfirebox" style="display:none">
    <div class="submitComfire">	<ul class="ui-form"><li><label for="question1" class="ui-label">?????????</label><span class="ui-text-info" way-data="showExpect.shortname">--</span></li>		<li><label for="question1" class="ui-label">?????????</label><span class="ui-text-info">??? <span way-data="showExpect.currFullExpect" class="mark">---</span> ???</span></li>		<li><label for="answer1" class="ui-label">?????????</label>		<div id="Orderdetaillist" class="textarea" style="font-size:12px;">		</div>		</li>		<li><label for="question2" class="ui-label">??????????????????</label><span class="ui-text-info"><span id="Orderdetailtotalprice" class="mark">0.00</span>???</span></li>		<li><label for="question2" class="ui-label">???????????????</label><span way-data="user.username" class="ui-text-info mark">---</span></li>	</ul>	<p class="text-note">	</p>	<p class="text-note">	</p></div>
</div>

<div id="submitComfireboxaaa" style="display:none">
    <div class="submitComfire">
    <ul class="ui-form">
    <li>
        <label for="question1" class="ui-label">?????????</label>
        <span class="ui-text-info" way-data="showExpect.shortname">--</span>
    </li>
    <li>
        <label for="question1" class="ui-label">?????????</label>
        <span class="ui-text-info">??? <span way-data="showExpect.currFullExpect" class="mark">---</span> ???</span>
    </li>
    <li>
        <label for="answer1" class="ui-label">?????????</label>
        <div id="Orderdetaillist" class="textarea" style="font-size:12px;">		</div>
    </li>
    <li>
        <label for="question2" class="ui-label">??????????????????</label>
        <span class="ui-text-info"><span id="Orderdetailtotalprice" class="mark">0.00</span>???</span>
    </li>
    <li>
        <label for="question2" class="ui-label">???????????????</label>
        <span way-data="user.username" class="ui-text-info mark">---</span>
    </li>
    </ul>
    </div>
</div>
<div class="loginCengBox">
	<div class="loginCeng">
		<div class="loginCengH">
			<h3>????????????</h3>
			<span class="loginCengClose">
				<i class="iconfont icon-guanbi-copy"></i>
			</span>
		</div>
		<div class="loginCengB">
		
		</div>
		<div class="loginCengF">
			<button type="submit" >??????</button>
		</div>
	</div>
</div>
<div id="getBillInfobox" style="display:none">
<div class="submitComfire">
<ul class="ui-form">
<li style="width:50%; float:left"><label for="question1" class="ui-label">?????????</label><span class="mark" way-data="BillInfo.cptitle">--</span></li>
<li style="width:50%; float:left"><label for="question1" class="ui-label">?????????</label><span class="mark">??? <span way-data="BillInfo.expect" class="mark">--</span> ???</span></li>
<li style="width:50%; float:left"><label for="question1" class="ui-label">?????????</label><span class="mark" way-data="BillInfo.playtitle">--</span></li>
<li style="width:50%; float:left"><label for="question1" class="ui-label">?????????</label><span way-data="BillInfo.mode" class="mark">--</span></li>
<li><label for="answer1" class="ui-label">???????????????</label><span class="mark" way-data="BillInfo.tzcode">--</span></li>
<li style="width:50%; float:left"><label for="question2" class="ui-label">???????????????</label><span class="mark" way-data="BillInfo.amount">--</span></li><li style="width:50%; float:left"><label for="question2" class="ui-label">???????????????</label><span class="mark" way-data="BillInfo.itemcount">--</span></li>
<li style="width:50%; float:left"><label for="question2" class="ui-label">???????????????</label><span class="mark" way-data="BillInfo.okamount">--</span></li><li style="width:50%; float:left"><label for="question2" class="ui-label">???????????????</label><span class="mark" way-data="BillInfo.okcount">--</span></li>


<li style="width:50%; float:left"><label for="question2" class="ui-label">???????????????</label><span class="mark" way-data="BillInfo.opencode">--</span></li><li style="width:50%; float:left"><label for="question2" class="ui-label">???????????????</label><span id="BillInfo_isdraw" way-data="BillInfo.state">--</span></li>
</ul>
</div>
</div>
<script>
	 function winningScroll(obj) {
			var height = $(obj).find('li:first').outerHeight();
			var str = -height + 'px';
			var index = 0;
 
			$(obj).animate({'marginTop' : str},3000,function (){
				$(this).css('marginTop','0px').find('li:first').appendTo($(this));
			})
		}

	function openwindow(url,name,iWidth,iHeight) {
		var url; //?????????????????????;
		var name; //????????????????????????;
		var iWidth; //?????????????????????;
		var iHeight; //?????????????????????;
		//window.screen.height?????????????????????window.screen.width??????????????????
		var iTop = (window.screen.height-30-iHeight)/2; //???????????????????????????;
		var iLeft = (window.screen.width-10-iWidth)/2; //???????????????????????????;
		window.open(url,name,'height='+iHeight+',,innerHeight='+iHeight+',width='+iWidth+',innerWidth='+iWidth+',top='+iTop+',left='+iLeft+',toolbar=no,menubar=no,scrollbars=auto,resizeable=no,location=no,status=no');
	}
	//????????????
	$('.helps').click(function () {
		openwindow("{:U('Game/howtoplay', array('name'=>$nowcpinfo['name'],'cz'=>ACTION_NAME))}",'',1058,870);
	})
	//????????????scroll
	var myar = setInterval("winningScroll('.ranking_scroll')",5000);
	$('.ranking_scroll').hover(function (){ 
		clearInterval(myar);
	},function () {
		myar = setInterval("winningScroll('.ranking_scroll')",5000);
	})
	// ??????????????????
	var timer1 = null;
	$('.my_account,.user_login_info2_list').mouseover(function (){
		if(timer1){
			clearTimeout(timer1);
		}
		$('.user_login_info2_list').show();
	})
	$('.my_account,.user_login_info2_list').mouseout(function (){
		timer1 = setTimeout(function (){
			$('.user_login_info2_list').hide();
		},300)
	})
	// ????????????
	var timer2 = null;
	$('.allLottery,.backLeftLottery').mouseover(function (){
		if(timer2){
			clearTimeout(timer2);
		}
		$('.backLeftLottery').show();
	})
	$('.allLottery,.backLeftLottery').mouseout(function (){
		timer2 = setTimeout(function (){
			$('.backLeftLottery').hide();
		},300)
	})
	//????????????
	$('.hide_money_btn').click(function () {
		$('.show_money').hide();
		$('.hide_money').show();
	})
	$('.show_money_btn').click(function () {
		$('.show_money').show();
		$('.hide_money').hide();
	})
	//????????????
	var index  = 0;
	$('.refresh_money').click(function () {
		index++;
		var sum = index*360;
		$(this).css('transform','rotate('+sum+'deg)');
	})
	//???????????????????????????????????????????????????????????????
	$("[data-toggle='popover']").popover({
	trigger: "hover",
	delay: {hide: 100}
	}).on('shown.bs.popover', function (event) {
			var that = this;
			$('.popover').on('mouseenter', function () {
					$(that).attr('in', true);
			}).on('mouseleave', function () {
					$(that).removeAttr('in');
					$(that).popover('hide');
			});
	}).on('hide.bs.popover', function (event) {
			if ($(this).attr('in')) {
					event.preventDefault();
			}
	});
</script>
<style>
	.looding{
		width:100%;
		height:200%;
		z-index: 999;
		background: rgba(0,0,0,0.7);
		position: absolute;
		color:#333;
		top:0;
		left:0;
		text-align:center
	}
	.looding span{
		z-index: 9999;
		background: #ffffff;
		text-align:center;
		font-size:20px;
		color:#000;
		display: block;
		width:200px;
		height:50px;
		line-height: 50px;
		border-radius: 5px;
		position: fixed;
		top: 50%;
		left: 50%;
		margin-top: -25px;
		margin-left: -100PX;
	}
</style>
<div class="looding"  style="display:none;">
	<span>??????????????????... <img src="__IMG__/addloading.gif" width="23" height="23" alt=""></span>

</div>
</body>
</html>