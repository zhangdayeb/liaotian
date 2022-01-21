<?php if (!defined('THINK_PATH')) exit(); $webheadertitle = '代理中心' ?>
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
<title><?php echo ($webheadertitle); ?></title>

<link rel="stylesheet" href="./Template/Mobile/css/sm.css">
<link rel="stylesheet" href="./Template/Mobile/css/sm-extend.min.css">
<link rel="stylesheet" href="./Template/Mobile/css/reset.css">
<link rel="stylesheet" href="./Template/Mobile/css/theme-red.css">
<link rel="stylesheet" href="/Template/Mobile/css/icon.css">
<script type='text/javascript' src='./Template/Mobile/js/zepto.js' charset='utf-8'></script>
<script type='text/javascript' src='./Template/Mobile/js/config.js' charset='utf-8'></script>
<script type='text/javascript' src='./Template/Mobile/js/sm.min.js' charset='utf-8'></script>
<script type='text/javascript' src='./Template/Mobile/js/sm-extend.js' charset='utf-8'></script>
<script type='text/javascript' src='./Template/Mobile/js/way.min.js' charset='utf-8'></script>
<script type='text/javascript' src='./Template/Mobile/js/common.js' charset='utf-8'></script>
<script type="text/javascript" src="./Template/Mobile/js/member.page.js"></script>

<script type='text/javascript' src='./Template/Mobile/js/agent.js' charset='utf-8'></script>
</head>
<body>
<div class="page-group">
      <!-- 你的html代码 -->
      <div class="page">
		            <header class="bar bar-nav theme-red">

				  <a class="button button-link button-nav pull-left bar-nav-top-left" href="javascript:history.go(-1);">
					  <span class="icon icon-left"></span>
				  </a>

				   <h1 class="title" style="position:static;text-align:center;"><?php echo ($webheadertitle); ?></h1>

          </header>
          <nav class="bar bar-tab" style="background-color: #000;">
              <a class="tab-item external active" href="/" style="color: #fff;">
                  <span class="iconfont icon-shouyeshouye1" style="font-size: 25px;line-height: 17px;padding-top: 7px;display: block;"></span>
                  <span class="tab-label" style="font-size:12px;">首页</span>
              </a>
              <a class="tab-item external" href="<?php echo U('Member/betRecord');?>" style="color: #fff;">
                  <span class="iconfont icon-touzhujilu" style="font-size: 25px;line-height: 17px;padding-top: 7px;display: block;"></span>
                  <span class="tab-label" style="font-size:12px;">下单</span>
              </a>
              <a class="tab-item external" href="<?php echo GetVar('kefuthree');?>" style="color: #fff;">
                  <span class="iconfont icon-kefu" style="font-size: 25px;line-height: 17px;padding-top: 7px;display: block;"></span>
                  <span class="tab-label" style="font-size:12px;">客服</span>
              </a>
              <a class="tab-item external" href="<?php echo U('Member/index');?>" style="color: #fff;">
                  <span class="iconfont icon-wode" style="font-size: 25px;line-height: 17px;padding-top: 7px;display: block;"></span>
                   <span class="tab-label" style="font-size:12px;">我的</span>
              </a>
          </nav>

          <div class="content" id="page-modal" style="background:#fff;">
  <div class="buttons-tab">
    <a href="#tab1" class="tab-link active button" data-tabid="userbets">概况</a>
    <a href="#tab2" class="tab-link button" data-tabid="userfuddetail">开户</a>
    <a href="#tab3" class="tab-link button" data-tabid="lotteryreport" onclick="allUserList();">下线</a>
    <a href="#tab4" class="tab-link button" data-tabid="rechargelist" onclick="allUserList();">在线</a>
  </div>
  <div class="buttons-tab">
    <a href="#tab5" class="tab-link button" onclick="allDownUserBetsList();">游戏</a>
    <a href="#tab6" class="tab-link button" onclick="accountChange()">账变</a>
    <a href="#tab7" class="tab-link button" onclick="groupDeposit();">充提</a>
    <a href="#tab8" class="tab-link button" onclick="groupReport();">报表</a>
  </div>
  <div class="content-block" style="">
    <div class="tabs">
      <div id="tab1" class="tab active">
		  <div class="list-block media-list" style="margin:0; padding:0">
		  <ul id="userbetshistorylist">

		  <li>
			  <div class="item-inner item-content">
				<div class="item-title-row">
					<div class="item-title">代理概况</div>
				</div>
			  </div>
		  </li>
		  <li>
			  <div class="item-inner item-content">
				<div class="item-title-row">
					<div class="item-title">团队人数:</div>
					<div class="item-after"><strong class="sty-h" way-data="downUserNum.totalnum">0</strong>人</div>
				</div>
			  </div>
		  </li>
		  <li>
			  <div class="item-inner item-content">
				<div class="item-title-row">
					<div class="item-title">代理人数:</div>
					<div class="item-after"><strong class="sty-h" way-data="downUserNum.proxynum">0</strong>人</div>
				</div>
			  </div>
		  </li>
		  <li>
			  <div class="item-inner item-content">
				<div class="item-title-row">
					<div class="item-title">玩家人数:</div>
					<div class="item-after"><strong class="sty-h" way-data="downUserNum.noproxynum">0</strong>人</div>
				</div>
			  </div>
		  </li>
		  <li>
			  <div class="item-inner item-content">
				<div class="item-title-row">
					<div class="item-title">团队余额:</div>
					<div class="item-after"><strong class="sty-h" way-data="downUserNum.totalamount">0.00</strong>元</div>
				</div>
			  </div>
		  </li>
		  </ul>
		  </div>
		<div class="searchbar row" style="margin-top:10px;">
			<div class="search-input col-33">
				<input id="indexStartDate" class="layriqi starTime date-input-picker" placeholder="开始时间" type="text">
			</div>
			<div class="search-input col-33">
				<input id="indexEndDate" class="layriqi endTime date-input-picker" placeholder="结束时间" type="text">
			</div>
			<a class="button button-fill button-danger col-33"  onclick="initIndexLottery();"><span class="icon icon-search"></span>查询</a>
		</div>
		   <div class="list-block media-list" style="margin-top:0;">
		  <ul id="userbetshistorylist">

		  <li>
			  <div class="item-inner item-content">
				<div class="item-title-row">
					<div class="item-title">彩票概况</div>
				</div>
			  </div>
		  </li>
		  <li>

		  </li>
		  <li>
			  <div class="item-inner item-content">
				<div class="item-title-row">
					<div class="item-title">充值量:</div>
					<div class="item-after"><strong class="sty-h" way-data="reportstatistics.transferIn">0</strong></div>
				</div>
			  </div>
		  </li>
		  <li>
			  <div class="item-inner item-content">
				<div class="item-title-row">
					<div class="item-title">提现量:</div>
					<div class="item-after"><strong class="sty-h" way-data="reportstatistics.transferOut">0</strong></div>
				</div>
			  </div>
		  </li>
		  <li>
			  <div class="item-inner item-content">
				<div class="item-title-row">
					<div class="item-title">代购量:</div>
					<div class="item-after"><strong class="sty-h" way-data="reportstatistics.validAmount">0</strong></div>
				</div>
			  </div>
		  </li>
		  <li>
			  <div class="item-inner item-content">
				<div class="item-title-row">
					<div class="item-title">派奖量:</div>
					<div class="item-after"><strong class="sty-h" way-data="reportstatistics.payoutAmount">0</strong></div>
				</div>
			  </div>
		  </li>
		  <li>
			  <div class="item-inner item-content">
				<div class="item-title-row">
					<div class="item-title">活动/反水:</div>
					<div class="item-after"><strong class="sty-h" way-data="reportstatistics.activityAmount">0</strong></div>
				</div>
			  </div>
		  </li>
		  </ul>

		  </div>
      </div>
      <div id="tab2" class="tab">
		<div class="content-block" style="margin: 0; padding: 0">
			<div class="buttons-row">
				<a href="#tab1-1" class="tab-link active button">普通开户</a>
				<a href="#tab1-2" class="tab-link button">链接开户</a>
				<a href="#tab1-3" class="tab-link button" onclick="signuplinkList();">链接管理</a>
			</div>
			<div class="tabs">
				<div class="tab active" id="tab1-1">
					<div class="m-warm-prompt" style="border:1px solid #e7e7e7; margin-top:15px; background:#fff; padding:10px;border-radius:0.25rem">
						<div>温馨提示：</div>
						<div>1. 自动注册的会员初始密码为<span class="mark">"123456"</span>。</div>
						<div>2. 为提高服务器效率，系统将自动清理注册一个月没有充值，或两个月未登录，并且金额低于10元的账户。</div>
						<div>3. 固定推广链接：</div>
						<?php $tglink= isset ( $_SERVER ['HTTPS'] ) && $_SERVER ['HTTPS'] == 'on' ? 'https://'.$_SERVER['HTTP_HOST'].'/Public.register.tgid.'.$userinfo['id'] :'http://'.$_SERVER['HTTP_HOST'].'/Public.register.tgid.'.$userinfo['id'] ;?>
						<textarea style="width:100%;"id='tg_ma' readonly><?php echo ($tglink); ?></textarea>
						<div>4. 固定推广二维码：</div>
						<div id='qrcode'style="text-align:center;"><img src='https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo ($tglink); ?>'></div>
					</div>
					<div class="list-block">
				<ul>
				  <li>
					<div class="item-content">
					  <div class="item-inner">
						<div class="item-title label">开户类别：</div>
						<div class="item-input">
							<select id="addUserGeneralAgent" name="addUserGeneral">
								<option value="0">玩家</option>
								<option value="1">代理</option>
							  </select>
						</div>
					  </div>
					</div>
				  </li>
				  <li class="nuonlinepayname">
					<div class="item-content">
					  <div class="item-inner">
						<div class="item-title label">用户名：</div>
						<div class="item-input">
						  <input value="" id="addUser_username" maxlength="10" type="text">
						</div>
					  </div>
					</div>
				  </li>
					<li class="nuonlinepayname">
						<div class="item-content">
							<div class="item-inner">
								<div class="item-title label">彩票返点：</div>
								<div class="item-input">
									<input value="" id="addUser_rebateid" placeholder="返点在0.0-<?php echo ($userinfo["fandian"]); ?>" maxlength="10" type="text">
								</div>
							</div>
						</div>
					</li>
				</ul>
				<botton class="button button-big button-fill button-danger nextrechargebtn" onclick="addUser();">添加账户</botton>
			  </div>
				</div>
				<div class="tab" id="tab1-2">
					<div class="list-block">
				<ul>
				  <li>
					<div class="item-content">
					  <div class="item-inner">
						<div class="item-title label">开户类别：</div>
						<div class="item-input">
							<select id="addSignuplinkAgent" name="addUserGeneral">
								<option value="0">玩家</option>
								<option value="1">代理</option>
							  </select>
						</div>
					  </div>
					</div>
				  </li>
				  <li class="nuonlinepayname">
					<div class="item-content">
					  <div class="item-inner">
						<div class="item-title label">使用次数：</div>
						<div class="item-input">
						  <input value="" id="addSignuplink_times" min="1" max="100" type="number" way-data="addSignuplink.times" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" maxlength="5">
						</div>
					  </div>
					</div>
				  </li>
					</li>
					<li class="nuonlinepayname">
						<div class="item-content">
							<div class="item-inner">
								<div class="item-title label">彩票返点：</div>
								<div class="item-input">
									<input value="" id="addlink_rebateid"  placeholder="返点在0.0-<?php echo ($userinfo["fandian"]); ?>" maxlength="10" type="text">
								</div>
							</div>
						</div>
					</li>
				</ul>
				<botton class="button button-big button-fill button-danger nextrechargebtn" onclick="addSignuplink();">生成链接</botton>
			  </div>

				</div>
				<div class="tab" id="tab1-3">
					<div class="list-block media-list" style="padding-top: 0; margin-top: 0">
						<ul id="signuplinkList"></ul>
						<div class="member-pag paging" id="signuplinkList_page"></div>
					</div>
				</div>
			</div>
		</div>
      </div>
      <div id="tab3" class="tab allUserListsearchbar">
		<div class="searchbar row">
			<div class="search-input col-50">
				<input class="layriqi starTime date-input-picker" id="userSearchStartTime" placeholder="开始时间" type="text">
			</div>
			<div class="search-input col-50">
				<input class="layriqi endTime date-input-picker" id="userSearchEndTime" placeholder="结束时间" type="text">
			</div>
		</div>
		<div class="searchbar row">
			<div class="search-input col-50">
				<input id="userSearchLoginname" placeholder="用户名" type="text">
			</div>
			<a class="button button-fill button-danger col-50" onclick="allUserList();"><span class="icon icon-search"></span>查询</a>
		</div>
		<div class="list-block media-list" style="padding-top: 0; margin-top: 0">
			<ul class="allUserList"></ul>
			<div class="member-pag paging" id="allUserList_paging"></div>
		</div>

      </div>
      <div id="tab4" class="tab">
		<div class="searchbar row">
			<div class="search-input col-50">
				<input class="layriqi starTime date-input-picker" id="userOnlineSearchStartTime" placeholder="开始时间" type="text">
			</div>
			<div class="search-input col-50">
				<input class="layriqi endTime date-input-picker" id="userOnlineSearchEndTime" placeholder="结束时间" type="text">
			</div>
		</div>
		<div class="searchbar row">
			<div class="search-input col-50">
				<input id="userOnlineSearchLoginname" placeholder="用户名" type="text">
			</div>
			<a class="button button-fill button-danger col-50" onclick="allUserList(1);"><span class="icon icon-search"></span>查询</a>
		</div>
		<div class="list-block media-list" style="padding-top: 0; margin-top: 0">
			<ul class="allUserList"></ul>
			<div class="member-pag paging" id="allOnlineUserList_paging"></div>
		</div>
      </div>
      <div id="tab5" class="tab">
		<div class="searchbar row">
			<div class="search-input col-33">
				<input id="downUserBetsSearchStartTime" class="layriqi starTime date-input-picker" placeholder="开始时间" type="text">
			</div>
			<div class="search-input col-33">
				<input id="downUserBetsSearchEndTime" class="layriqi endTime date-input-picker" placeholder="结束时间" type="text">
			</div>
			<div class="search-input col-33">
					<?php $cplist = C('cplist.k3'); ?>
					<select class="lotteryname" id="downUserBetsSearchShortName"><option value="">全部彩种</option>
						<?php if(is_array($cplist)): foreach($cplist as $key=>$cpvo): ?><option value="<?php echo ($cpvo["name"]); ?>"><?php echo ($cpvo["title"]); ?></option><?php endforeach; endif; ?>

					</select>
			</div>
		</div>
		<div class="searchbar row">
			<div class="search-input col-33">
				<select class="state" id="downUserBetsSearchState">
					<option value="">订单状态</option>
					<option value="0">未开奖</option>
					<option value="-1">未中奖</option>
					<option value="1">已中奖</option>
					<option value="-2">已撤单</option>
				</select>
			</div>
			<div class="search-input col-33">
				<input class="in-tx-1" placeholder="期号" type="text" id="downUserBetsSearchExpect">
			</div>
			<div class="search-input col-33">
				<input class="in-tx-1" placeholder="订单编号" type="text" id="downUserBetsSearchLoginname">
			</div>
		</div>
		<a class="button button-fill button-danger col-33"  onclick="allDownUserBetsList();"><span class="icon icon-search"></span>查询</a>
		<div class="list-block media-list" style="padding-top: 0; margin-top: 0">
			<p class="mark">											下注统计<br />
											大：<b way-data="allDownUserBetsList.k3hzbig">0.00</b>
                                            小：<b way-data="allDownUserBetsList.k3hzsmall">0.00</b>
                                            单：<b way-data="allDownUserBetsList.k3hzodd">0.00</b>
                                            双：<b way-data="allDownUserBetsList.k3hzeven">0.00</b>

			</p>
			<ul id="downUserBetsList"></ul>
			<div class="member-pag paging" id="allDownUserBetsList_paging"></div>
		</div>

      </div>
	  <div id="tab6" class="tab">
		<div class="searchbar row">
			<div class="search-input col-33">
				<input id="accountChangeStartTime" class="layriqi starTime date-input-picker" placeholder="开始时间" type="text">
			</div>
			<div class="search-input col-33">
				<input id="accountChangeEndTime" class="layriqi endTime date-input-picker" placeholder="结束时间" type="text">
			</div>
			<div class="search-input col-33">
											<select id="sourceModule">
												<option value="">全部</option>
					<?php $fuddetailtypes = C('fuddetailtypes');?>
					 <?php if(is_array($fuddetailtypes)): foreach($fuddetailtypes as $fk=>$ft): ?><option value="<?php echo ($fk); ?>" <?php if($fk == $type): ?>selected<?php endif; ?>><?php echo ($ft); ?></option><?php endforeach; endif; ?>
											</select>
			</div>
		</div>
		<div class="searchbar row">
			<div class="search-input col-50">
				<input id="accountChangeSearchLoginname" placeholder="用户名" type="text">
			</div>
		<a class="button button-fill button-danger col-50"  onclick="accountChange();"><span class="icon icon-search"></span>查询</a>
		</div>
		<div class="list-block media-list" style="padding-top: 0; margin-top: 0">

			<ul id="downuserchangelist"></ul>
			<div class="member-pag paging" id="groupDeposit_paging"></div>
		</div>
	  </div>
	  <div id="tab7" class="tab">
		<div class="searchbar row">
			<div class="search-input col-33">
				<input id="groupDepositStartTime" class="layriqi starTime date-input-picker" placeholder="开始时间" type="text">
			</div>
			<div class="search-input col-33">
				<input id="groupDepositEndTime" class="layriqi endTime date-input-picker" placeholder="结束时间" type="text">
			</div>
			<div class="search-input col-33">
											<select id="groupDepositType">
												<option>全部充提</option>
												<option value="0">充值</option>
												<option value="1">提款</option>
											</select>
			</div>
		</div>
		<div class="searchbar row">
			<div class="search-input col-33">
											<select id="groupDepositState">
												<option value="">全部状态</option>
												<option value="0">正在处理</option>
												<option value="1">审核通过</option>
												<option value="-1">取消申请</option>
											</select>
			</div>
			<div class="search-input col-33">
				<input id="groupDepositSearchLoginname" placeholder="用户名" type="text">
			</div>
			<div class="search-input col-33">
				<input id="groupDepositSearchBillNo" placeholder="订单号" type="text">
			</div>
		</div>
		<a class="button button-fill button-danger"  onclick="groupDeposit();"><span class="icon icon-search"></span>查询</a>
		<div class="list-block media-list" style="padding-top: 0; margin-top: 0">

			<ul id="groupDeposit"></ul>
			<div class="member-pag paging" id="groupDeposit_paging"></div>
		</div>
	  </div>
	  <div id="tab8" class="tab">
		<div class="searchbar row">
			<div class="search-input col-50">
				<input id="groupReportStartTime" class="layriqi starTime date-input-picker" placeholder="开始时间" type="text">
			</div>
			<div class="search-input col-50">
				<input id="groupReportEndTime" class="layriqi endTime date-input-picker" placeholder="结束时间" type="text">
			</div>
		</div>
		<div class="searchbar row">
			<div class="search-input col-50">
				<input id="groupReportSearchLoginname" placeholder="用户名" type="text">
			</div>
			<a class="button button-fill button-danger col-50"  onclick="groupReport();"><span class="icon icon-search"></span>查询</a>
		</div>
		<div class="list-block media-list" style="padding-top: 0; margin-top: 0">

			<ul id="downuseraccountreportlist"></ul>
		</div>
	  </div>
    </div>
  </div>

          </div>
      </div>
  </div>
<!--	<?php $a=1; $b=2; $c=3; $d=4; if(strstr($_SERVER['REQUEST_URI'],"Activity")) { $c='33'; } else if(strstr($_SERVER['REQUEST_URI'],"betRecord")) { $b='22'; } else if(strstr($_SERVER['REQUEST_URI'],"Member")) { $d='44'; }else{ $a='11'; } ?>
<div data-am-widget="navbar" class="am-navbar am-cf am-navbar-default bottom_navbar am-no-layout">
    <ul class="am-navbar-nav am-cf am-avg-sm-5 my_nav_b" style="overflow: visible;background-color: #D9006C">
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
<script>	
var cpname="<?php echo I('code');?>"; 
function Order_chedan(id,trano,obj){
				artDialog({
					content:'确定撤单吗',
					cancel:function(){},
					ok:function(){
					$.post('/Apijiekou.chedan',{'id':id,'trano':trano}, function(json){
							if(json.sign==true){
							 
								art.dialog({
									time: 2,
									content:'撤单成功',
									lock:true
								});
								$(obj).html('<span style="color:grey">已撤单</span>');
							}else{
								alt(json.message);
							}
						},'json'); 

					},
					lock:true
				})
				
	};</script>-->

  </body>
</html>