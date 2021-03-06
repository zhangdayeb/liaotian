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
<link rel="stylesheet" href="__CSS2__/ssc.css">
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
<script type="text/javascript" src="__ROOT__/resources/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="__ROOT__/resources/js/artDialog.js"></script>
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
		input:focus, textarea:focus, select:focus {
    outline-offset: -2px;
}

:focus {
    outline: -webkit-focus-ring-color auto 5px;
}
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none !important;
}
input{}
</style>
<include file="Public/gameHeader" />
<script type="text/javascript" src="__ROOT__/resources/js/way.min.js"></script>
<script type="text/javascript" src="__ROOT__/resources/js/jquery.history.js"></script>
<script type="text/javascript" src="__ROOT__/resources/main/common.js"></script>
<script type="text/javascript" src="__ROOT__/resources/js/member.page.js"></script>
<script type="text/javascript" src="__ROOT__/resources/js2/tabGameData.js"></script>
<script type="text/javascript" src="__ROOT__/resources/main/lhc.js"></script>
<script type="text/javascript" src="__ROOT__/resources/js2/lhctabGame.js"></script>
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
            <div class="open_number" id="ssc_winning_sum">
                <div class="number-box"><em class="blue" way-data="showExpect.openCode1"></em> <span class="number-box-text" way-data="showExpect.openCodes1">-</span></div>
                <div class="number-box"><em class="blue" way-data="showExpect.openCode2"></em> <span class="number-box-text" way-data="showExpect.openCodes2">-</span></div>
                <div class="number-box"><em class="blue" way-data="showExpect.openCode3"></em> <span class="number-box-text" way-data="showExpect.openCodes3">-</span></div>
                <div class="number-box"><em class="blue" way-data="showExpect.openCode4"></em> <span class="number-box-text" way-data="showExpect.openCodes4">-</span></div>
                <div class="number-box"><em class="blue" way-data="showExpect.openCode5"></em> <span class="number-box-text" way-data="showExpect.openCodes5">-</span></div>
                <div class="number-box"><em class="blue" way-data="showExpect.openCode6"></em> <span class="number-box-text" way-data="showExpect.openCodes6">-</span></div>
                <!---->
                <div class="number-box plus"><em class="symbol">+</em></div>
                <div class="number-box"><em class="blue" way-data="showExpect.openCode7"></em> <span class="number-box-text" way-data="showExpect.openCodes7">-</span></div>
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
				
				<volist name="ssclist" id="vo">
					<li <if condition="$vo['name'] eq $lotteryname">class="curr"</if> lotteryname="{$vo.name}">
						<a href="__ROOT__/Game.lhc?code={$vo.name}">{$vo.title}</a>
					</li>
				</volist>	
			</ul>
			<span class="next">
				<i class="iconfont icon-a866"></i>
			</span>
        </div>

		<div class="play_select_insert" id="j_play_select">
			<ul class="play_select_tit">
				<li lottery_code="lhc_tm" class="curr">??????</li>
				<li lottery_code="lhc_zm">??????</li>
				<li lottery_code="lhc_lm">??????</li>
				<li lottery_code="lhc_bb">??????</li>
				<li lottery_code="lhc_sx">??????</li> 
				<li lottery_code="lhc_ws">??????</li> 
				<li lottery_code="lhc_bz">??????</li> 
			</ul>
		</div>
	
  
    <section id="gameBet" class="cl">
		<section class="gameBet_balls">
			<div class="gameBet_left l">
			<if condition="$nowcpinfo['iswh'] eq 0">
				<!--????????????????????????-->
				<div class="bet_filter_box">
				
				</div>
				<!--????????????????????????-->
				<!--????????????????????????-->
				<div class="play_select_prompt" style="padding:10px 0;">
					<i class="iconfont c_org"></i>
					<span way-data="tabDoc"></span>
				</div>
				
				<div class="g_Number_Section " style="width: 720px;padding: 15px 0;">
					<!-- <div class="g_Number_Section_sliderbox sliderbox" style="">
						<span class="buyNumberTitle">????????????<i ></i></span>
						<div class="progressTime">
							<div class="peilu">
								<p data-v-021cdaa0="" style="display: inline-block; color: rgb(153, 153, 153);">??????</p> 
								<p style="display: inline-block;" id="amount">
									
								</p>
							</div>
							<div class="upBottom">
								<a id="minus"></a>
							</div>
							<div class="mains">
								<div id="slider-range-min"></div>
							</div>
							<div class="dowmBottom">
								<a id="plus"></a>
							</div>
							<div class="fandian">
								<p style="display: inline-block; color: rgb(153, 153, 153);">??????</p> 
								<p style="display: inline-block;"><span class="fans">0</span>%</p>
							</div>
						</div>
					</div> -->
				</div>
				<div class="selectMultiple">
					<span class="select_zhushu">
						????????????
						<em class="zhushu">0</em>
						???
					</span>
					<div class="selectMultipleNumber" style="display: none;">
						<i class="reduce">-</i>
						<input type="tel" value="0" class="selectMultipInput" onKeypress="return (/[\d]/.test(String.fromCharCode(event.keyCode)))">
						<i class="add">+</i>
					</div>
					<!-- ??? -->
					<select class="selectMultipleCon" style="display: none;">
						<option value="1">???</option>
						<option value="0.1">???</option>
						<option value="0.01">???</option>
					</select>
					<span class="selectMultipleOld" style="display: none;">
						???
						<em class="selectMultipleOldMoney">
							0.00
						</em>
						???
					</span>
				</div>
				<!--????????????????????????-->
				<div class="addtobet">
					<button class="addtobetbtn" type="button">????????????</button>
				</div>
				<div class="xiad-left">
					<dl class="yBettingLists">
						
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
						<li class="li22">
							<span id="f_submit_order" style="cursor: pointer;">
							<img src="__ROOT__/resources/images/icon/icon_06.png">&nbsp;&nbsp;????????????
							</span>
						</li>
						<li class="li22 li23"><span id="orderlist_clear" style="cursor: pointer;">
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
                    <a target="_blank" class="open_lotteryNumb_chart yopen_explain"  href="{:U('Trend/trend_lhc',array('code'=>$nowcpinfo['name']))}">?????????</a>
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
                <div class="ranking_scroll_box" style="height:435px;">
                <ul class="ranking_list sum_icon ranking_scroll">

                    <volist name="list2" id="value">
                    <li data-html="true" class="user_header" data-container="body" data-toggle="popover" data-placement="left" data-content="<div class=&quot;ceng&quot;><div class=&quot;media&quot;><div class=&quot;media-left&quot;><img src=&quot;__ROOT__{$value['face']}&quot; alt=&quot;&quot; class=&quot;media-boject img-circle&quot;><p></p></div><div class=&quot;media-body&quot;> <p class=&quot;margin_0&quot;>?????????<span>{$value['username']|substr_replace='**',1,2}</span></p><p class=&quot;margin_0&quot;>?????????<span>{$value['groupname']}</span></p><p class=&quot;margin_0&quot;>?????????<span>{$value['touhan']}</span></p><p class=&quot;margin_0&quot;>???????????????<span>{$value['okamountcount']}</span></p></div>
                   <div class=&quot;media-footer&quot; style=&quot;padding-top:3px;&quot;>
                       <volist name="value['k3names']" offset="0" length="10"  id="val">
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
<div id="submitComfirebox" style="display:none">
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
				<div id="Orderdetaillist" class="textarea" style="font-size:12px;"></div>		
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
		<p class="text-note">	</p>	<p class="text-note">	</p>
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