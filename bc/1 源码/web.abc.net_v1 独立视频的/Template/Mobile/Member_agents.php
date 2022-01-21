<php>$webheadertitle = '代理中心'</php>
<?php 
$host = (isHTTPS() ? 'https://' : 'http://'); //获取域名
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="MSUI: Build mobile apps with simple HTML, CSS, and JS components.">
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<link rel="shortcut icon" href="/favicon.ico">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<title>{$webheadertitle}</title>
<link rel="stylesheet" href="./Template/Mobile/css/sm.css">
<link rel="stylesheet" href="./Template/Mobile/css/sm-extend.min.css">
<link rel="stylesheet" href="./Template/Mobile/css/reset.css">
<link rel="stylesheet" href="./Template/Mobile/css/theme-red.css">
<link rel="stylesheet" href="__CSS__/icon.css">
<script type='text/javascript' src='./Template/Mobile/js/zepto.js' charset='utf-8'></script>
<script type='text/javascript' src='./Template/Mobile/js/config.js' charset='utf-8'></script>
<script type='text/javascript' src='./Template/Mobile/js/sm.min.js' charset='utf-8'></script>
<script type='text/javascript' src='./Template/Mobile/js/sm-extend.js' charset='utf-8'></script>
<script type='text/javascript' src='./Template/Mobile/js/way.min.js' charset='utf-8'></script>
<script type='text/javascript' src='./Template/Mobile/js/common.js' charset='utf-8'></script>
<script type="text/javascript" src="./Template/Mobile/js/member.page.js"></script>

<script type='text/javascript' src='./Template/Mobile/js/agent.js' charset='utf-8'></script>
  <style>
    .PLSdetail {
      padding: 1rem;
      margin-top: 0;
      font-size: 2em;
      transform: scale(.5);
      width: 200%;
      transform-origin: 0 0;
      background: #fff;
    }
    .PLSdetail li:nth-child(3n+1), .PLSdetail li:nth-child(3n+2) {
      border-right: 1px solid #d0d0d0;
    }
    .PLSdetail li {
      float: left;
      width: 11rem;
      height: 10rem;
      text-align: center;
      font-size: 1.4rem;
      padding: 3rem 0;
      border-bottom: 1px solid #d0d0d0;
    }
    .proxy3colCon li span {
      line-height: 1.5em;
    }
    .PLSdetail li span {
      display: block;
      color: #ff6818;
      font-size: 1.2em;
    }
    
  </style>
</head>
<body>
<div class="page-group">
      <!-- 你的html代码 -->
      <div class="page">
		<!--  <include file="Public/header2" />-->
  <!--        <div class="content" id="page-modal" style="background:#fff;">-->
  <div class="buttons-tab">
    <a href="#tab1" class="tab-link active button" data-tabid="userbets">一级用户</a>
    <a href="#tab2" class="tab-link button" data-tabid="userfuddetail">二级用户</a>
  </div>
  <!--<div class="buttons-tab">-->
  <!--  <a href="#tab5" class="tab-link button" onclick="allDownUserBetsList();">任务</a>-->
  <!--  <a href="#tab6" class="tab-link button" onclick="accountChange()">账变</a>-->
  <!--  <a href="#tab7" class="tab-link button" onclick="groupDeposit();">充提</a>-->
   <!-- <a href="#tab8" class="tab-link button" onclick="groupReportCur(1);">报表</a>-->
  <!--</div>-->
  <div class="content-block" style="">
      <div class="tabs">
    <div id="tab1" class="tab allUserListsearchbar active">
		<!--<div class="searchbar row">-->
		<!--	<div class="search-input col-50">-->
		<!--		<input class="layriqi starTime date-input-picker" id="userSearchStartTime" placeholder="开始时间" type="text" readonly="">-->
		<!--	</div>-->
		<!--	<div class="search-input col-50">-->
		<!--		<input class="layriqi endTime date-input-picker" id="userSearchEndTime" placeholder="结束时间" type="text" readonly="">-->
		<!--	</div>-->
		<!--</div>-->
		<!--<div class="searchbar row">-->
		<!--	<div class="search-input col-50">-->
		<!--		<input id="userSearchLoginname" placeholder="用户名" type="text">-->
		<!--	</div>-->
		<!--	<a class="button button-fill button-danger col-50" onclick="allUserList();"><span class="icon icon-search"></span>查询</a>-->
		<!--</div>-->
        <div class="list-block media-list" style="padding-top: 0; margin-top: 0">
        	<ul class="allUserList">
        	    <volist name="no1" id="vo1">
            		<li>
            			<div class="item-inner item-content">
            				<div class="item-title-row">
            					<div class="item-title">
            						用户名:{$vo1.username}
            					</div>
            					<div class="item-after">
            						<t>
            						    <if condition='$vo1.isonline eq "1"'>
            						        <span style="color:green">在线</span>
            						    <else/>
            						        <span style="color:grey">离线</span>
            						    </if>    
        
            						</t>
            					</div>
            				</div>
            				<div class="item-subtitle">
            					余额:{$vo1.balance}
            				</div>
            				<div class="item-subtitle">
            					注册时间:{$vo1.regtime|date="Y-m-d H:i:s",###}
            				</div>
            			</div>
            		</li>
        		</volist>
        	</ul>
        	<!--<div class="member-pag paging" id="allUserList_paging">-->
        	<!--	<div style="text-align: center;">-->
        	<!--		<ul class="r">-->
        	<!--			<li>-->
        	<!--				<a class="prev" href="javascript:;">-->
        	<!--					上一页-->
        	<!--				</a>-->
        	<!--			</li>-->
        	<!--			<li class="cur">-->
        	<!--				<a class="start" href="javascript:;">-->
        	<!--					1-->
        	<!--				</a>-->
        	<!--			</li>-->
        	<!--			<li>-->
        	<!--				<a class="next" href="javascript:;">-->
        	<!--					下一页-->
        	<!--				</a>-->
        	<!--			</li>-->
        	<!--		</ul>-->
        	<!--	</div>-->
        	<!--</div>-->
        </div>

    </div>
    <div id="tab2" class="tab allUserListsearchbar">
		<!--<div class="searchbar row">-->
		<!--	<div class="search-input col-50">-->
		<!--		<input class="layriqi starTime date-input-picker" id="userSearchStartTime" placeholder="开始时间" type="text" readonly="">-->
		<!--	</div>-->
		<!--	<div class="search-input col-50">-->
		<!--		<input class="layriqi endTime date-input-picker" id="userSearchEndTime" placeholder="结束时间" type="text" readonly="">-->
		<!--	</div>-->
		<!--</div>-->
		<!--<div class="searchbar row">-->
		<!--	<div class="search-input col-50">-->
		<!--		<input id="userSearchLoginname" placeholder="用户名" type="text">-->
		<!--	</div>-->
		<!--	<a class="button button-fill button-danger col-50" onclick="allUserList();"><span class="icon icon-search"></span>查询</a>-->
		<!--</div>-->
        <div class="list-block media-list" style="padding-top: 0; margin-top: 0">
        	<ul class="allUserList">
        	    <volist name="no2" id="vo2">
            		<li>
            			<div class="item-inner item-content">
            				<div class="item-title-row">
            					<div class="item-title">
            						用户名:{$vo2.username}
            						<!--(上级:{$vo2.parentname})-->
            					</div>
            					<div class="item-after">
            						<t>
            						    <if condition='$vo2.isonline eq "1"'>
            						        <span style="color:green">在线</span>
            						    <else/>
            						        <span style="color:grey">离线</span>
            						    </if>    
        
            						</t>
            					</div>
            				</div>
            				<div class="item-subtitle">
            					余额:{$vo2.balance}
            				</div>
            				<div class="item-subtitle">
            					注册时间:{$vo2.regtime|date="Y-m-d H:i:s",###}
            				</div>
            			</div>
            		</li>
        		</volist>
        	</ul>
        	<!--<div class="member-pag paging" id="allUserList_paging">-->
        	<!--	<div style="text-align: center;">-->
        	<!--		<ul class="r">-->
        	<!--			<li>-->
        	<!--				<a class="prev" href="javascript:;">-->
        	<!--					上一页-->
        	<!--				</a>-->
        	<!--			</li>-->
        	<!--			<li class="cur">-->
        	<!--				<a class="start" href="javascript:;">-->
        	<!--					1-->
        	<!--				</a>-->
        	<!--			</li>-->
        	<!--			<li>-->
        	<!--				<a class="next" href="javascript:;">-->
        	<!--					下一页-->
        	<!--				</a>-->
        	<!--			</li>-->
        	<!--		</ul>-->
        	<!--	</div>-->
        	<!--</div>-->
        </div>

    </div>
  </div>

          </div>

      </div>
  </div>
<!--<include file="Public/footer" />-->

  </body>
</html>