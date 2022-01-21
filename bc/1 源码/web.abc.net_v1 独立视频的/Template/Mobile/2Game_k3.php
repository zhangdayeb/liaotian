<php>$webheadertitle = $nowcpinfo['title'];</php>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>{$webheadertitle}</title>
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<link rel="shortcut icon" href="/favicon.ico">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="__ROOT__/Template/Mobile/css/sm.css">
<link rel="stylesheet" href="__ROOT__/Template/Mobile/css/sm-extend.min.css">

<script>
    var WebConfigs = {
        'ROOT' : "__ROOT__"
    } 
<?php echo "var k3lotteryrates = ".json_encode($rates,JSON_UNESCAPED_UNICODE);?>
</script>
<script type='text/javascript' src='http://8ocop.dcshidafu.cn/zepto.js' charset='utf-8'></script>
<script type='text/javascript' src='__ROOT__/Template/Mobile/js/config.js' charset='utf-8'></script>
<script type='text/javascript' src='__ROOT__/Template/Mobile/js/fx.js' charset='utf-8'></script>
<script type='text/javascript' src='__ROOT__/Template/Mobile/js/sm.min.js' charset='utf-8'></script>
<script type='text/javascript' src='__ROOT__/Template/Mobile/js/slideupdown.js' charset='utf-8'></script>
<script type='text/javascript' src='__ROOT__/Template/Mobile/js/sm-extend.min.js' charset='utf-8'></script>
<link rel="stylesheet" href="__ROOT__/Template/Mobile/css/sm-extend.min.css">
<link rel="stylesheet" href="__ROOT__/Template/Mobile/css/reset.css">
<link rel="stylesheet" href="__ROOT__/Template/Mobile/css/theme-red.css">  

<link rel="stylesheet" href="__CSS__/icon.css">
<script>
var lotteryinfo = <?php echo json_encode($nowcpinfo,JSON_UNESCAPED_UNICODE);?>;
</script>
<script type='text/javascript' src='__ROOT__/Template/Mobile/js/way.min.js' charset='utf-8'></script>
<script type="text/javascript" src="__ROOT__/Template/Mobile/js/member.page.js"></script>
<script type='text/javascript' src='__ROOT__/Template/Mobile/js/common.js' charset='utf-8'></script>
<script type='text/javascript' src='http://8ocop.dcshidafu.cn/k3.js' charset='utf-8'></script>

<!--<link rel="stylesheet" type="text/css" href="__ROOT__/resources/css/chat/appchat-chat-index.css" />-->
<!--    <link rel="stylesheet" type="text/css" href="__ROOT__/resources/css/chat/index1.css" />-->
<!--    <link rel="stylesheet" type="text/css" href="__ROOT__/resources/css/chat/index.css" />-->
    <!--workmand的js-->
    <!-- <script type="text/javascript" src="__ROOT__/resources/js/jquery-1.9.1.min.js"></script> -->
   <!--  <script type="text/javascript" src="__ROOT__/resources/js/chat/swfobject.js"></script>
    <script type="text/javascript" src="__ROOT__/resources/js/chat/web_socket.js"></script>
    <script type="text/javascript" src="__ROOT__/resources/js/chat/jquery-sinaEmotion-2.1.0.js"></script> -->
    
<style>
.bottom_navbar{position: absolute;bottom: 0;z-index: 9999;width: 100%;}
.bottom_navbar ul{list-style: none;overflow: hidden;padding: 0;margin: 0;background: #22292c;color: #fff;padding-top: 5px;}
.bottom_navbar ul li{ float: left;width: 20%;text-align: center;}
.am-navbar-default a {color: #000;}
.am-navbar-nav a { display: inline-block;width: 100%;height: 49px;line-height: 20px;}
.bottom_navbar .bottom_navbar_list i{font-size: 25px;line-height: 30px;}
.am-navbar-nav a .am-navbar-label {padding-top: 2px;line-height: 1;font-size: 12px;display: block;word-wrap: normal;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;font-size: 14px;}
.bottom_navbar .active {color: #e54042;}
.choice_lottery_playdetail {
    position: absolute;
    z-index: 100;
    top: -50px;
    left: 50%;
}
.my_jiantouxia {
    width: 30px !important;
    position: absolute;
    height: 20px !important;
    margin-top: 4px;
    left: 50%;
    border-bottom-left-radius: 3px;
    border-bottom-right-radius: 3px;
    margin-left: -15px;
    line-height: 20px;
    text-align: center;
    font-size: 12px;
    
    color: #999;
    top: 54px !important;
    background-color: white;
}
.start_video{
    background-color: rgba(255,255,255,0.4) !important;
    box-shadow: 0 0 5px rgba(255,255,255,0.4) !important;
    z-index: 3000 !important;
    color: white !important;
}
#chat_box{
    z-index: 10000;
}
details{
    overflow:hidden;
    height:0;
    padding-left:200px;
    position:relative;
    display:block;
    }
details[open]{height:auto;}
</style>
</head>
<body>
<div class="page-group">
    
    <span onclick="strat_chat()" class="start_video mychat_start" style="display: none;">
        聊<br>天<br>室
        <span id="username" style="display: none;">{$username}</span>
         <span id="myhead" style="display: none;">{$face}</span>
    </span>
    <!-- start -->
        <div id="chat_box" style="width: 100vw; height: 100vh; background-color: rgba(0,0,0,0.8);">
            <span id="level" style="display: none;">{$level}</span>
             <div class="mychat">
     <div class="chatbar" style="position: relative !important;">
    <!---->
    <div class="chatwin type-normal">
        <div class="chat" style="border: 3px solid #f00;">
            <div class="lay-relative">
                <!---->
                <div class="profile">
                    <div class="inner" style="animation-duration: 0.3s;">
                        <div class="avatar" ><img src="{$info['head']}" alt="" id="userhead"></div>
                        <p><span class="txt-nick">北京pk10</span></p>
                        <!--<p>当前等级: <img src="__ROOT__/resources/images/chat/icon_member01.gif" alt="" class="head_level_img"></p>-->
                        <div>
                            <p>
                                <input type="file" id="upload_head" style="display: none">
                                <a href="javascript:void(0)" class="u-btn1">关闭</a>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="chat-header">
                    <div class="ttl"><span><i class="iconfont icon-shouyeshouye1" style="vertical-align: 0px;font-size: 18px;"></i> 聊天室</span></div>
                </div>
                <div class="list" style="bottom: 98px;" >
                    <div class="lay-scroll" style="padding-top: 45px;" id="content_parent">
                       
                        <volist name="chat_list" id="vo1" key="k1">
                
                        <div class="Item {$vo1['class']}">
                            <div class="lay-block">
                                <div class="avatar" ><img src="{$vo1['head']}" alt="84***20"></div>
                                <div class="lay-content">
                                    <div class="msg-header">
                                        <h4>{$vo1['name']}</h4> <span><img src="{$vo1['level_img']}" alt="普通会员"></span> <span class="MsgTime">{$vo1['create_at']}</span></div>
                                    <div class="Bubble" style="{$vo1['style']}">
                                        <p><span style="white-space: pre-wrap; word-break: break-all;">{$vo1['content']}</span></p>
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    
                        </volist>

                    </div>
                    <div class="controls" style="top: 38px;">
                        <a href="javascript:void(0)" class="ListCtrl roll_screen"><i class="iconfont" style="vertical-align: -1px;"></i>滚屏</a>
                        <a href="javascript:void(0)" class="ListCtrl clear_screen"><i class="iconfont" style="vertical-align: 0px;"></i>清屏</a>
                    </div>
                    <div class="chat-announce">
                        <div class="ttl"><i class="iconfont icon-icon100"></i> 公告:</div>
                        <div class="scroll">
                            <marquee scrollamount="3">
                                <ol>
                     
          <li>{$notice}</li>
      
                                </ol>
                            </marquee>
                        </div>
                    </div>
                </div>
                <div class="compose">
                    <div class="control-bar">
                        <div class="el-popover"  x-placement="top-start">

                            <div class="emoji-container">
                                <i class="Emoji emoji-smile" data-id="[smile]"></i>
                                <i class="Emoji emoji-laughing" data-id="[laughing]"></i>
                                <i class="Emoji emoji-blush" data-id="[blush]"></i>
                                <i class="Emoji emoji-heart_eyes" data-id="[heart_eyes]"></i>
                                <i class="Emoji emoji-smirk" data-id="[smirk]"></i>
                                <i class="Emoji emoji-flushed" data-id="[flushed]"></i>
                                <i class="Emoji emoji-grin" data-id="[grin]"></i>
                                <i class="Emoji emoji-kissing_smiling_eyes" data-id="[kissing_smiling_eyes]"></i>
                                <i class="Emoji emoji-wink" data-id="[wink]"></i>
                                <i class="Emoji emoji-kissing_closed_eyes" data-id="[kissing_closed_eyes]"></i>
                                <i class="Emoji emoji-stuck_out_tongue_winking_eye" data-id="[stuck_out_tongue_winking_eye]"></i>
                                <i class="Emoji emoji-sleeping" data-id="[sleeping]"></i>
                                <i class="Emoji emoji-worried" data-id="[worried]"></i>
                                <i class="Emoji emoji-sweat_smile" data-id="[sweat_smile]"></i>
                                <i class="Emoji emoji-cold_sweat" data-id="[cold_sweat]"></i>
                                <i class="Emoji emoji-joy" data-id="[joy]"></i>
                                <i class="Emoji emoji-sob" data-id="[sob]"></i>
                                <i class="Emoji emoji-angry" data-id="[angry]"></i>
                                <i class="Emoji emoji-mask" data-id="[mask]"></i>
                                <i class="Emoji emoji-scream" data-id="[scream]"></i>
                                <i class="Emoji emoji-sunglasses" data-id="[sunglasses]"></i>
                                <i class="Emoji emoji-thumbsup" data-id="[thumbsup]"></i>
                                <i class="Emoji emoji-clap" data-id="[clap]"></i>
                                <i class="Emoji emoji-ok_hand" data-id="[ok_hand]"></i>
                            </div>
                            <div x-arrow="" class="popper__arrow" style="left: 15.5px;"></div>
                        </div>
                        <span></span>
                        <a href="javascript:void(0)" title="发送表情" class="btn-control">
                            <!--<img style="width: 26px;" src="__ROOT__/resources/images/chat/biaoqing.png" />-->
                            </a><label for="imgUploadInput" style="display: none;"><span title="上传图片" class="btn-control"><i class="iconfont icon-erjiyemian-liaotianduihua-danchuangtianjiatupian"></i> <input id="imgUploadInput" type="file" accept=".jpg, .png, .gif, .jpeg, image/jpeg, image/png, image/gif" style="width: 0.1px; height: 0.1px; opacity: 0; position: absolute; top: -20px;"></span></label>
                        <!---->
                        <!---->
                        <!---->
                    </div>
                    <div class="typing">
                        <div class="txtinput el-textarea {if $info['is_temporary']==1}is-disabled{/if}">
                            <textarea  id="textarea_content" {if $info['is_temporary']==1}disabled  placeholder="输入内容" {/if} type="textarea" autosize="[object Object]" rows="2" autocomplete="off" validateevent="true" class="el-textarea__inner" style="height: 54px;"></textarea>
                        </div>
                        <div class="sendbtn" onclick="onSubmit()">
                            <a href="javascript:void(0)" class="u-btn1">发送</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="controls chat-header">
                <span class="ttl">
                    <a href="javascript:void(0)" title="修改昵称" style="display: none;"><i class="iconfont icon-user"></i></a>
                    <a onclick="close_chat()" href="javascript:void(0)" title="隐藏聊天室"><i class="iconfont icon-guanbi-copy" style="font-size: 14px;"></i></a>
                </span>
            </div>


        </div>
    </div>
</div>
 </div>
        </div>
        <!-- end -->
      <!-- 你的html代码 -->
      <div class="pa yyplay_select_container" id="PageSwitch">
        <volist name="k3list" id="k3vo">
            <a  data-k3url="{:U('Game/k3',['code'=>$k3vo['name']])}">{$k3vo.title}</a>
        </volist>
    </div>
      <div class="page">
        <include file="Game/header" />
          <div class="content">
			
            <div class="play_select_container yyplay_select_container">
                <!-- 玩法切换 -->
                <div class="play_select_insert" id="j_play_select">
                    
                    <ul class="play_select_tit"> 
                
                            
                            <li lottery_code="k3hzzx" parent_code="{$nowcpinfo.name}" class="curr lottery_1">
                                <a href="javascript:void(0)" class="lineMore-item">和值</a>
                                <p class="ypeil">{$minPeilv}-{$maxPeilv}倍</p>
                                <p class="ysaizi">
                                    <span class="dice dice1"></span>+
                                    <span class="dice dice2"></span>+
                                    <span class="dice dice3"></span>
                                </p>
                            </li>
                        
                            <li lottery_code="k3sthtx" parent_code="{$nowcpinfo.name}" class=" lottery_3">
                                <a href="javascript:void(0)" class="lineMore-item">三同号通选</a> 
                                <p class="ypeil">赔率{$peilv.k3sthtx}倍</p>
                                <p class="ysaizi">
                                    <span class="dice dice1"></span> 
                                    <span class="dice dice1"></span> 
                                    <span class="dice dice1"></span>
                                </p>
                            </li>
                        
                            <li lottery_code="k3sthdx" parent_code="{$nowcpinfo.name}" class=" lottery_5">
                                <a href="javascript:void(0)" class="lineMore-item">三同号单选</a>
                                <p class="ypeil">赔率{$peilv.k3sthdx}倍</p>
                                <p class="ysaizi">
                                    <span class="dice dice1"></span> 
                                    <span class="dice dice1"></span> 
                                    <span class="dice dice1"></span>
                                </p>
                            </li>
                        
                            <li lottery_code="k3sbthbz" parent_code="{$nowcpinfo.name}" class=" lottery_7">
                                <a href="javascript:void(0)" class="lineMore-item">三不同号</a>
                                <p class="ypeil">赔率{$peilv.k3sbthbz}倍</p>
                                <p class="ysaizi">
                                    <span class="dice dice2"></span> 
                                    <span class="dice dice3"></span> 
                                    <span class="dice dice5"></span>
                                </p>
                            </li>
                        
                            <li lottery_code="k3slhtx" parent_code="{$nowcpinfo.name}" class=" lottery_9">
                                <a href="javascript:void(0)" class="lineMore-item">三连号通选</a>
                                <p class="ypeil">赔率{$peilv.k3slhtx}倍</p>
                                <p class="ysaizi">
                                    <span class="dice dice1"></span> 
                                    <span class="dice dice2"></span> 
                                    <span class="dice dice3"></span>
                                </p>
                            </li>
                        
                            <li lottery_code="k3ethfx" parent_code="{$nowcpinfo.name}" class=" lottery_11">
                                <a href="javascript:void(0)" class="lineMore-item">二同号复选</a>
                                <p class="ypeil">赔率{$peilv.k3ethfx}倍</p>
                                <p class="ysaizi">
                                    <span class="dice dice1"></span> 
                                    <span class="dice dice1"></span> 
                                    <span class="dice dice3"></span>
                                </p>
                            </li>
                        
                            <li lottery_code="k3ethdx" parent_code="{$nowcpinfo.name}" class=" lottery_13">
                                <a href="javascript:void(0)" class="lineMore-item">二同号单选</a>
                                <p class="ypeil">赔率{$peilv.k3ethdx}倍</p>
                                <p class="ysaizi">
                                    <span class="dice dice1"></span> 
                                    <span class="dice dice1"></span> 
                                    <span class="dice dice3"></span>
                                </p>
                            </li>
                        
                            <li lottery_code="k3ebthbz" parent_code="{$nowcpinfo.name}" class=" lottery_15">
                                <a href="javascript:void(0)" class="lineMore-item">二不同号</a>
                                <p class="ypeil">赔率{$peilv.k3ebthbz}倍</p>
                                <p class="ysaizi">
                                    <span class="dice dice1"></span> 
                                    <span class="dice dice4"></span> 
                                    <span class="dice dice4"></span>
                                </p>
                            </li>
                        
                    </ul> 
                </div>
                <!-- 玩法切换 -->
            </div>
            <style type="text/css">
                
            </style>
			<div class="row no-gutter text-center Betting_Issue_CountDown cz_openNumb" style="padding-top:5px;background: #ffffff;position: relative;height: 59px;overflow: visible;">
                       <dl class="col-50">
                              <dt style="font-size:14px;"><i class="f_lottery_info_lastnumber red"  id="f_lottery_info_lastnumber" way-data="showExpect.lastFullExpect">--</i><span id="issueText">期</span></dt>
                               <dd style="font-size:20px; padding:0; margin:0;">
							   <ul id="openNum_list" style="padding: 0px; display: inline-block;margin:0;">
                    <li class="open_numb_gif"></li>
                    <li class="open_numb_gif"></li>
                    <li class="open_numb_gif"></li>
                </ul>

							  </dd>
                        </dl>
                       <dl class="col-50" style="color:#000000">
                        <dt style="font-size:14px;">距<i class="f_lottery_info_number red" id="f_lottery_info_number" way-data="showExpect.currFullExpect">--</i>期截止</dt>
                         <dd style="font-size:20px; padding:0; margin:0;"><i class="j_lottery_time red" id="j_lottery_time">
							<t class="hh bj"><span way-data="gametimes.h">00</span></t>
							<em>:</em>
							<t class="mm bj"><span way-data="gametimes.m">00</span></t>
							<em>:</em>
							<t class="ss bj"><span way-data="gametimes.s">00</span></t>
						 </i></dd>
                        </dl> 
                        <i onclick="" class="iconfont icon-jiantouxia my_jiantouxia cz_daojishi my_close_lishi2"></i>
			</div>
					<div id="fn_getoPenGame" style="width: 100%;
    height: 100vh;
    position: absolute;
    overflow: scroll;
     background-color: rgba(0,0,0,0.5); 
    margin-top: -4px;
    display: none; ">
    <div style="height: 50vh;text-align: center; background-color: #ffffff;">
                <div style="height: 49vh;padding-bottom: 10px; overflow: scroll;background-color: #ffffff;">
                           <table id="fn_getoPenGame" border="0px" cellpadding="0" cellspacing="0" style="width:100%;text-align:center">
                            <colgroup>
                                <col width="30%">
                                <col width="20%">
                                <col width="20%">
                                <col width="20%">
                            </colgroup>
                            <thead 
    style="background-color: #DADADA; border-bottom: 1px solid #BBBBBB;border-top: 1px solid hsla(0,0%,100%,.3);background-color: #ffffff;width: 16rem;font-size: .7em;color: #000000;text-align: center;clear: both;border-bottom: 1px solid #BBBBBB;height: 64px;">
                                <tr style="    border-bottom: 1px solid #212121;">
                                    <th>期数</th>
                                    <th>奖号</th>
                                    <th>和值</th>
                                    <th>形态</th>
                                </tr>
                            </thead>
                            <tbody class="tbody" style="background: #ffffff;"></tbody>
                        </table>
                    </div>
                    <span onclick="" class="cz_daojishi my_close_lishi Betting_Issue_CountDown" style="">关闭</span>
                </div>
                 
                         </div>


<section class="ui-container">   
			<!-- 选择与切换玩法 -->
			<!-- 投注期号与倒计时 -->
			<!-- 投注期号与倒计时 --> 
			<!-- 选号区域 -->
			<div class="Choice_Ball_Container ui-whitespace" id="Game_CheckBall">
				<if condition="$nowcpinfo['iswh'] eq 0">
				<div class="gn_main_cont k3_ball_conatiner" id="gn_main_cont">

				</div>
				<else />
					<p style="font-size:30px; color:#f60; text-align:center; padding:15px 0;">彩种维护中...</p>
				</if>
            </div>
		</section>  
          </div>
      </div>
  </div>

<!--<div class="lottey_footer" style="bottom: 58px;">-->
<div class="lottey_footer">
    <!--<div class="lottery_footer_sum" style="display:none;">-->
    <!--    <span class="lottery_sum_text">当前号码</span>-->
        <input id="lottery_sum_old_b" type="hidden">

    <!--    </div>-->
    <!--</div>-->
    <!--<div class="lottery_inputBox" style="display:none;">-->
    <!--    每注金额-->
    <!--    <input type="number" class="lottery_input" placeholder="金额">-->
    <!--    <span class="lottery_input_text">请输入要投注的金额</span>-->
    <!--</div>-->
    <div class="kuaijie_money" style="display: none;text-align: center;" id="testD" style="border:#ddd 1px solid">
        <ul class="kuaijie_money_ul">
            <li class="kuaijie_item">
                <img src="https://img.khdd.top/img/369" style="width:40px" />
                10
            </li>
            <li class="kuaijie_item">
                <img src="https://img.khdd.top/img/367" style="width:40px" />
                50
            </li>
            <li class="kuaijie_item">
                <img src="https://img.khdd.top/img/370" style="width:40px" />
                100
            </li>
            <li class="kuaijie_item">
                <img src="https://img.khdd.top/img/372" style="width:40px" />
                200
            </li>
            <li class="kuaijie_item">
                <img src="https://img.khdd.top/img/371" style="width:40px" />
                500
            </li>
            <li class="kuaijie_item">
                <img src="https://img.khdd.top/img/368" style="width:40px" />
                1000
            </li>
            
        </ul>
    </div>  
    <div class="betting_box" style="background: #1c1c1c;">
        <div class="betting_left ">
            <input type="number" class="lottery_input" placeholder="请输入金额">
            <img src="__ROOT__/Template/Mobile/images/khdd-cm.png" style="width: 37px;
    margin-left: 0.5rem;
    margin-top: 10px;" onClick="testDisplay();"/>
            
            <em class="betting_sum_box" >
                <p style="margin-top: -81px;margin-left: 7.2rem;">已选中<span class="betting_sum">0</span>注</p>
               <p style="margin-top: -47px; margin-left: 7.2rem;">共计<span class="betting_sum_moery">0</span>元</p>
            </em>
        </div>
        <div class="betting_right">
            <button class="betting_empty">清空</button>
            <button class="betting_right_btn">
                投注
            </button>
        </div>
    </div>
</div>
<a href="/member.betrecord.do" >注单</a>

<script>
function testDisplay()   
{   
    var divD = document.getElementById("testD");   
    if(divD.style.display=="none")   
    {   
        divD.style.display = "block";   
    }else{   
        divD.style.display = "none";   
    }   
}  
</script>

<include file="Game/wf" />
<div class="popup" id="userbetshistory">
		<div class="list-block media-list" style="padding-top: 0; margin-top: 0">
			<div class="card-header "><botton id="formaubmitdo" class="button button-fill button-danger close-popup" style="width:100%;">关闭</botton></div>
			<ul id="userbetshistorylist"></ul>
			<div class="member-pag paging"></div>
		</div>
</div>
<script>

</script>
</body>
<!-- <script type="text/javascript" src="__ROOT__/resources/js/chat/mobilechat.js"></script> -->
</html>