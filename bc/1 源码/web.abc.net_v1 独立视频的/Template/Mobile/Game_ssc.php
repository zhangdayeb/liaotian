<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$webheadertitle}</title>
<meta name="viewport" content="width=device-width, initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=none">
<link rel="shortcut icon" href="/favicon.ico">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="renderer" content="webkit" />
<link rel="stylesheet" href="__CSS__/amazeui.min.css">
<link rel="stylesheet" href="__CSS__/common2.css"> 
<link rel="stylesheet" href="__CSS__/index.css">
<link rel="stylesheet" type="text/css" href="__ROOT__/resources/css/reset.css" />
<link rel="stylesheet" type="text/css" href="__ROOT__/resources/css/layout.css" />
<link rel="stylesheet" type="text/css" href="__ROOT__/resources/css/artDialog.css" />
<link rel="stylesheet" type="text/css" href="__ROOT__/resources/css/font-awesome.min.css" />


<link rel="stylesheet" href="__ROOT__/Template/Mobile/css/icons.css">
<link rel="stylesheet" href="__ROOT__/Template/Mobile/css/ssc.css">
<link rel="stylesheet" type="text/css" href="__ROOT__/Template/Mobile/css/jquery.range.css" />
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
<script type="text/javascript" src="__ROOT__/Template/Mobile/js/jquery.range.js"></script>
<!--[if lt IE 9]>
<script src="__ROOT__/resources/js/html5shiv.js"></script>
<![endif]-->

</head>

<body>
 
<style>	
.yGame_list{
	width: 96px;
	background: #fff;
	position: absolute;
	right: 0;
	top: 50px;
	box-shadow: 0 2px 10px rgba(41,41,41,.08);
	display: none;
}
.yGame_list li{
	text-align: center;
	height: 45px;
	line-height: 45px;
	padding: 0;
}
.yGame_list li:first-child:before{
	position: absolute;
	content: "";
	display: block;
	width: 0;
	height: 0;
	border-bottom: 1em solid hsla(0,0%,100%,.96);
	border-left: 1em solid transparent;
	right: 0;
	top: -.96em;
}
</style>
<script type="text/javascript" src="__ROOT__/resources/js/way.min.js"></script>
<script type="text/javascript" src="__ROOT__/resources/js/jquery.history.js"></script>
<script type="text/javascript" src="__ROOT__/resources/main/common.js"></script>
<script type="text/javascript" src="__ROOT__/resources/main/index.js"></script>
<script type="text/javascript" src="__ROOT__/resources/js/member.page.js"></script>
<script type="text/javascript" src="__ROOT__/Template/Mobile/js/tabGameData.js"></script>

<script type="text/javascript" src="__ROOT__/Template/Mobile/js/ssc.js"></script>
<script type="text/javascript" src="__ROOT__/Template/Mobile/js/tabGame.js"></script>

<!--<script src="__JS2__/require.js" data-main="__JS2__/homePage"></script>-->
<script src="__JS__/require.js" data-main="__JS__/main"></script>
<script>
	var lotteryinfo = <?php echo json_encode($nowcpinfo,JSON_UNESCAPED_UNICODE);?>;
</script>
<section class="" id="gamepage">
  <div class="mobileGameTop">
    <header data-am-widget="header"class="am-header am-header-default header nav_bg am-header-fixed" style="background:#000;">
      <div class="am-header-left am-header-nav">
          <a href="/" class="">
              <i class="iconfont icon-shouyeshouye1"></i>
          </a>
      </div>
      <h1 class="am-header-title userHome_h1" style="margin: 0 auto; width: 100%;">
          <em class="gameInfo">???<br>???</em>
          <span class="gameType">
            <string>????????????</string> 
            <i class="iconfont icon-sanjiaoxing"></i>
          </span>
      </h1>
      <div class="am-header-right am-header-nav">
			<a href="javascript:void(0);" id="showGameList" style="text-decoration:none;">
				<em class="bill_day">{$cptitle}</em>
				<i class="iconfont icon-sanjiaoxing"></i>
			</a>
		</div>
		<ul class="yGame_list">
			<volist name="ssclist" id="vo">
				<li class="<if condition="$vo['name'] eq $lotteryname">curr</if> am-modal-actions-header" lotteryname="{$vo.name}">
					<a href="__ROOT__/Game.ssc?code={$vo.name}" style="padding: 0;">{$vo.title}</a>
				</li>
			</volist>
		</ul>
  </header>
    <div class="play_select_insert" id="j_play_select">
			<ul class="play_select_tit" style="overflow:hidden;">
				<li lottery_code="5x" class="curr">??????</li>	
				<li lottery_code="4x">??????</li>
				<li lottery_code="q3">??????</li>
				<li lottery_code="z3">??????</li>
				<li lottery_code="h3">??????</li>
				<li lottery_code="q2">??????</li>
				<li lottery_code="h2">??????</li>
				<li lottery_code="1x">??????</li>
				<li lottery_code="dsds">????????????</li> 
			</ul>
			<!--????????????????????????-->
				<div class="bet_filter_box" style="">
				
				</div>
				<!--????????????????????????-->
		</div>
  </div>
  <!--????????????-->
	<div class="touzhu_tab">
			<li class='li_curr li'>????????????</li>
			<li class='li'>????????????</li>
			<li class='user_money'>??:<span id='user_money'>0.00</span></li>
	</div>
<div class='game_body game_body_curr'>
	<div class="open_containers g_Time_Section">
        <!--?????????????????????-->
        <div class="cz_daojishi">
            <div class="open_issue">
				<span class="c_red" id="f_lottery_info_number" way-data="showExpect.currFullExpect">---</span>???????????????
			</div>
            <div class="j_lottery_time" servertime="">
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

            <div class="open_issue" id="showTabel"><span class="c_red" way-data="showExpect.lastFullExpect" id="f_lottery_info_lastnumber" firstissueno="">---</span>???????????????<i class="iconfont icon-jiantouxia"></i></div>
            <div class="open_number">
                <input type="hidden" value="1,1,2" id="j_openNum"><!--????????????????????????-->
                <ol id="ssc_winning_sum">
					        <li class="ssc_winning_sum_gif" way-data="showExpect.openCode1"></li>
                    <li class="ssc_winning_sum_gif" way-data="showExpect.openCode2"></li>
                    <li class="ssc_winning_sum_gif" way-data="showExpect.openCode3"></li>
                    <li class="ssc_winning_sum_gif" way-data="showExpect.openCode4"></li>
                    <li class="ssc_winning_sum_gif" way-data="showExpect.openCode5"></li>
				        </ol>
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
                      <th>????????????</th>
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
    </div>
    
	<div class="lottery_playContainer">

		
	
  
    <section id="gameBet" class="cl">
		<section class="gameBet_balls">
			<div class="gameBet_left l">
			<if condition="$nowcpinfo['iswh'] eq 0">
				
				<!--????????????????????????-->
				<div class="play_select_prompt">
					<i class="iconfont c_org"></i>
					<span way-data="tabDoc"></span>
				</div>
				<div class="changeBtn">
					<ul>
						<li class="on">???</li>
						<li class="router-link-exact-active">???</li>
					</ul>
				</div>
				<div class="sliderConter">
					<table  style="height: 100%; border: 0px;">
						<tr>
							<td>
								<div class="peilu">
									<var style="color: rgb(202, 202, 202);">??????</var><span id="amount">47.628</span>

								</div>
							</td> 
							<td style="padding-top: 8px;">
								<a  id="minus"></a>
							</td> 
							<td style="width: 100%;">
								<input type="hidden" class="single-slider" value="0" />	
							</td> 
							<td style="padding-top: 8px; ">
								<a  id="plus"></a>
							</td> 
							<td >
								<div class="fandian"><p style="display: inline-block; color: rgb(202, 202, 202);">??????</p> <p  style="display: inline-block;" class="fans">0.0</p>
								</div>	
						</tr>
					</table>
				</div>
				
				<div class="g_Number_Section" >
				</div>
				<div class="selectMultiple">
          <div class="selectMultipleT" id="selectMultipleTId">
            <div class="selectMultipleNumber">
              <i class="reduce">-</i>
              <input type="tel" value="1" class="selectMultipInput" onKeypress="return (/[\d]/.test(String.fromCharCode(event.keyCode)))">
              <i class="add">+</i>
            </div>
            ???
            <select class="selectMultipleCon">
              <option value="1">???</option>
              <option value="0.1">???</option>
              <option value="0.01">???</option>
            </select>
          </div>
          <div class="selectMultipleB addtobetbtn">
						<span class="lanIconNumber" id="lanIconNumberss">
							1
						</span>
						<div class="addIcon" id="addIconId">
							+
						</div>
            <span class="select_zhushu">
              ???
              <em class="zhushu">0</em>
              ???,
            </span>
            <span class="selectMultipleOld">
              ???
              <em class="selectMultipleOldMoney">
                0.00
              </em>
              ???
            </span>
						<div class="selectMultipleB_n" id="selectMultipleB_nId">
							
						</div>
          </div>
					<div class="selectMultipleLz" id="selectMultipleLz_show">
						<span class="lanIconNumber" id="lanIconNumbere">
							0
						</span>
						<i class="iconfont icon-lanzi"></i>
						<a href="javascript:void(0);" class="selectMultipleLz_a">?????????</a>
					</div>
						
				</div>
				<!--????????????????????????-->
				<div class="numberLan" style="display: none;">
					<header data-am-widget="header" class="am-header am-header-default header nav_bg am-header-fixed am-no-layout">
						<div class="am-header-left am-header-nav">
								<a href="javascript:void(0);" class="" style="text-decoration:none;">
										<i class="iconfont icon-arrow-left"></i>
								</a>
						</div>
						<h1 class="am-header-title userHome_h1" style="margin: 0 auto; width: 100%;font-size: 20px;">
								?????????
						</h1>
					</header>
					<div class="randomBox">
						<div class="random">
							<a class="randomBtn random1">+ ??????1???</a>
							<a class="randomBtn random5">+ ??????5???</a>
							<a class="randomBtn closeNumberlan">+ ????????????</a>
						</div>
					</div>
						<div class="xiad-left">
							<dl class="yBettingLists">
								
							</dl>
							<div class="mo_empty" id="orderlist_clear">
								????????????
							</div>
						</div>     

				<div class="selectMultiple">
          <div class="selectMultipleB" style="padding-left: 10px;">
            <span class="selectMultipleOld">
              <div class="g_Chase_Section">
								<div class="chase_Program">
									<p class="p_chase">??????
										<i class="c_green fw_600" way-data="ytotal_money_zhushu" id="f_gameOrder_lotterys_num">0</i>?????? 
										<em id="f_gameOrder_amount" way-data="ytotal_money">0</em></i> ???  
									</p>
								</div>
						</div>
            </span>
						<div style="font-size: 14px;color: #a9a9a9;">
							????????????
						</div>
          </div>
					<div class="selectMultipleLz" style="background:#dc3b40">
						<span id="f_submit_order"  style="font-size: 18px;color: #fff;">
							????????????
						</span>
					</div>
						
				</div>
				</div>
			<else />
			<img src="__ROOT__/resources/images/k3cpcz.png" />
			</if>
			</div>
		
		</section>
    </section>
</section>
</div>
</div>

<!--????????????-->
<div class='game_body touzhu_log'>
<div class="am-tabs-bd" id='touzhu_log_body'>
			
</div>
</div>
<include file="public/touzhu_js" />
<include file="public/footer" />
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
  $(document).on('click','.gameType',function (){
    if($('.play_select_insert').is(':hidden')){
      $(this).find('.icon-sanjiaoxing').css('transform','rotate(360deg)');
      $('#j_play_select').show();
      $('.bet_filter_box').show();
			$('.ymask').show();
    }else{
			$(this).find('.icon-sanjiaoxing').css('transform','rotate(180deg)');
      $('#j_play_select').hide();
      $('.bet_filter_box').hide();
			$('.ymask').hide();
    }
  })

	$(document).on('click','.ymask',function (){
		$('#j_play_select').hide();
		$('.bet_filter_box').hide();
		$('.ymask').hide();
	})
    
  $(document).on('click','#showTabel',function (){
    
    if($('.lishi').is(':hidden')){
      $('.lishi').show();
    }else{
      $('.lishi').hide();
    }
  })
  

	
	$(document).on('click','#selectMultipleLz_show',function (){
		$(document).scrollTop(0);
		if($('.yBettingLists .yBettingList').length > 0){
			$('#orderlist_clear').show();
		}else{
			$('#orderlist_clear').hide();
		}
		$('.numberLan').show();
	})

	$(document).on('click','.numberLan .am-header-left , .closeNumberlan',function (){
		$('.numberLan').hide();
	})

	$(document).on('click','#showGameList',function () {
		if($('.yGame_list').is(':hidden')){
      $(this).find('.icon-sanjiaoxing').css('transform','rotate(360deg)');
			$('.yGame_list').show();
    }else{
			$(this).find('.icon-sanjiaoxing').css('transform','rotate(180deg)');
			$('.yGame_list').hide();
    }
	})
	$('.changeBtn').find('ul').on('click',function(){
    	window.location.href='/Game.oldssc?code='+lotteryname;
    });
	var ytext = $('.bill_day').text().substring(0,2);
	$('.bill_day').text(ytext);

	


</script>
<style>
#showGameList .icon-sanjiaoxing{
	display: inline-block;
	transform: rotate(180deg);
	transition: .6s;
	font-size: 22px;
}
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
<div class="am-modal-actions  am-modal-active" id="my-actions" style="display:none;">
		<div class="am-modal-actions-group">
			<ul class="am-list">
				<volist name="ssclist" id="vo">
					<li class="<if condition="$vo['name'] eq $lotteryname">curr</if> am-modal-actions-header" lotteryname="{$vo.name}">
						<a href="__ROOT__/Game.ssc?code={$vo.name}" style="padding: 0;">{$vo.title}</a>
					</li>
				</volist>
			</ul>
		</div>
		<div class="am-modal-actions-group">
			<button class="am-btn am-btn-secondary am-btn-block btn_red" data-am-modal-close="">??????</button>
		</div>
	</div>
  <div class="ymask" style="width: 100%;height: 100%;position:fixed;top:0;left:0;background: rgba(0,0,0,0.3);display:none;"></div>
</body>
</html>