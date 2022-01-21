<?php 
$host = (isHTTPS() ? 'https://' : 'http://'); //获取域名
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>代理首页</title>
<meta name="renderer" content="webkit" />
<link rel="stylesheet" type="text/css" href="/resources/css2/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="/resources/css2/header.css" />
<link rel="stylesheet" type="text/css" href="/resources/css/reset.css" />
<link rel="stylesheet" type="text/css" href="/resources/css2/reset.css" />
<link rel="stylesheet" type="text/css" href="/resources/css/layout.css" />
<link rel="stylesheet" type="text/css" href="/resources/css/artDialog.css" />
<link rel="stylesheet" type="text/css" href="/resources/css/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="/resources/css/member.css" />
<link rel="stylesheet" type="text/css" href="/resources/css2/footer.css" />
<link rel="stylesheet" href="/resources/css2/icon.css">
<script>
var WebConfigs = {
	webtitle:"{$webconfigs.webtitle}",
	kefuthree:"{$webconfigs.kefuthree}",
	kefuqq:"{$webconfigs.kefuqq}"
};
</script>

<!--[if lt IE 9]>
<script src="/resources/js/html5shiv.js"></script>
<![endif]-->

</head>

<body>
<style>
	.zclip{
		right: 47px !important;
    top: 57px !important;
	}
	.zclip embed{
    width: 50px;
    height: 50px;
	}
</style>
<include file="Public/header" />
<script type="text/javascript" src="/resources/js/way.min.js"></script>
<script type="text/javascript" src="/resources/js/jquery.history.js"></script>
<script type="text/javascript" src="/resources/js2/jquery.zclip.min.js"></script>
<script type="text/javascript" src="/resources/main/common.js"></script>
<script type="text/javascript" src="/resources/main/index.js"></script>
<script type="text/javascript" src="/resources/js/member.page.js"></script>
<script src="/resources/js/laydate/laydate.js" type="text/javascript" ></script>
<script src="/resources/js/jquery-dateFormat.min.js" type="text/javascript"></script>
<script src="/resources/js/echarts-all.js" type="text/javascript"></script>
<script src="/resources/js/macarons.js" type="text/javascript"></script>
<script type="text/javascript" src="/resources/main/agent.js"></script>
<script type="text/javascript" src="/resources/js2/bootstrap.min.js"></script>
<section class="container pt-10 pb-10" id="memberpage" >
 <div class="memberhome">

   <div class="memhome-bottom ml-20 mr-20">
		<div class="memsubnav">

		 </div>
					<div class="mem-main">
						<div class="m-m-cen ym-grid">
							<div class="mem-agent m-a-one m-m-subnav tab pos-r">
								<ul class="level2-nav tabHd">
									<li class="cur">代理首页</li>
									<li onclick="initAddUser();">开户中心</li>
									<li onclick="allUserList();">会员管理</li>
									<li onclick="allUserList(1);">在线会员</li>
									<li onclick="initDownUserBetsList();allDownUserBetsList();">游戏记录</li>
									<li onclick="initAccountChangeList();accountChange();">账变记录</li>
									<li onclick="initGroupDepositList();groupDeposit();">团队存提款</li>
									<li onclick="initGroupReportList();groupReport();">团队报表</li>
								</ul>
								<div class="m-f-cuk m-f-quk tabBd">
									<div class="tb-imte">
										<table class="m-a-table">
											<tbody>
												<tr>
														<td>团队：<strong class="sty-h" way-data="downUserNum.totalnum">0</strong>人</td>
													<td>代理：<strong class="sty-h" way-data="downUserNum.proxynum">0</strong>人</td>
													<td>玩家：<strong class="sty-h" way-data="downUserNum.noproxynum">0</strong>人</td>
												</tr>
												<tr>
													<td colspan="3">团队余额：<strong class="sty-h" way-data="downUserNum.totalamount">0</strong>元&nbsp;(不包含自己)</td>
												</tr>
											</tbody>
										</table>
										<div class="m-a-nav-min tab" id="indexAgent">
											<div class="m-a-n-hd">
												<ul class="subTabHd">
													<li class="cur" onclick="initStatistics('lottery');">彩票娱乐</li>
												</ul>
											</div>
											<div class="m-a-n-bd subTabBd">
												<div class="">
													<div class="sjss">
														<a class="zj" href="javascript:;" onclick="indexQuickDate(-3);">最近三天</a>
														<a class="zj" href="javascript:;" onclick="indexQuickDate(-7);">最近七天</a>
														<a class="zj" href="javascript:;" onclick="indexQuickDate(-30);">最近一个月</a>
														<span>&nbsp;&nbsp;时间：</span>
														<input class="layriqi" type="text" id="indexStartDate" onclick="laydate({format:'YYYY-MM-DD',isclear:false});" readonly="true">
														<span class="zhi">-</span>
														<input class="layriqi" type="text" id="indexEndDate" onclick="laydate({format:'YYYY-MM-DD',isclear:false});" readonly="true">
														<a href="javascript:;" class="in-but-l h-32" onclick="searchStatistics();">查询</a>
													</div>
													<div class="ctsj">
														<dl>
															<dd><span>充值量</span><b>0</b></dd>
															<dd><span>提现量</span><b>0</b></dd>
															<dd><span>投注量</span><b>0</b></dd>
															<dd><span>派奖量</span><b>0</b></dd>
															<dd><span>活动/反水</span><b>0</b></dd>
														</dl>
													</div>
													<div class="dzxz">
														<ul>
															<li><input type="radio" id="cz" value="cz" placeholder="" name="indexType" checked="checked"><label for="cz" class="checked">充值</label></li>
															<li><input type="radio" id="tx" value="tx" placeholder="" name="indexType"><label for="tx">提现</label></li>
															<li><input type="radio" id="tz" value="tz" placeholder="" name="indexType"><label for="tz">投注</label></li>
															<li><input type="radio" id="fd" value="fd" placeholder="" name="indexType"><label for="fd">返点</label></li>
															<li><input type="radio" id="xz" value="xz" placeholder="" name="indexType"><label for="xz">新增用户</label></li>
														</ul>
													</div>
													<div class="sjtu" id="tubiao" style="height:550px"></div>
												</div>
											</div>
										</div>
									</div>
									<div class="tb-imte" style="display:none">
										<div class="m-a-nav-min tab">
											<div class="m-a-n-hd">
												<ul class="tabHd">
													<li class="cur">普通开户</li>
													<li>链接开户</li>
													<li onclick="signuplinkList();">链接管理</li>
												</ul>
											</div>
<div class="m-a-n-bd tabBd">
												<div class="tb-imte cur" style="display: block;">
													<div class="m-warm-prompt">
														<h5>温馨提示：</h5>
														<p>1. 自动注册的会员初始密码为<span class="mark">"123456"</span>。</p>
														<p>2. 为提高服务器效率，系统将自动清理注册一个月没有充值，或两个月未登录，并且金额低于10元的账户。</p>
														<p>3. 固定推广链接：<span class="mark">{$host}{$_SERVER['HTTP_HOST']}/Public.register.tgid.<way way-data="user.id"></way></span></p>
													</div>
													<div class="m-a-kaihu">
														<dl class="ty-biaodan">
															<dd>
																<span class="tt">开户类别：</span>
																<span>
																	<input id="addUserGeneralAgent" value="1" name="addUserGeneral" checked="checked" type="radio">
																	<label for="addUserGeneralAgent">代理</label>
																</span>
																<span>
																	<input id="addUserGeneralPlayer" value="0" name="addUserGeneral" type="radio">
																	<label for="addUserGeneralPlayer">玩家</label>
																</span>
															</dd>
															<dd>
																<span class="tt">用户名：</span>
																<span><input value="" way-data="addUser.username" onkeyup="checkAddUsername(this);" maxlength="10" type="text"></span>
																<span class="tisp" id="addUserGeneralTipsUsername">&nbsp;&nbsp;4-12位字母或数字,字母开头</span>
															</dd>
															<dd>
																<span class="tt">彩票返点：</span>
																<span><input type="text" value="" way-data="addUser.rebateid" onkeyup="checkAddUserRebate();" maxlength="7"></span>
																<span class="tisp" id="addUserGeneralTipsRebate">（可分配范围 0~<way way-data="addUser.maxRebate">0</way>）</span>
															</dd>
														</dl>
														<div class="tianjzh">
															<a class="in-but-l w-16" href="javascript:;" onclick="addUser();">添加账户</a>
														</div>
													</div>
												</div>
												<div class="tb-imte" style="display: none;">
													<div class="m-warm-prompt">
														<h5>温馨提示：</h5>
														<p>1. 生成链接不会立即扣减配额，只有用户使用该链接注册成功的时候，才会扣减配额；请确保您的配额充足，配额不足将造成用户注册不成功！</p>
													</div>
													<div class="m-a-kaihu">
														<dl class="ty-biaodan">
															<dd>
																<span class="tt">开户类别：</span>
																<span>
																	<input id="addSignuplinkAgent" value="1" name="addSignuplink" checked="checked" type="radio">
																	<label for="addSignuplinkAgent">代理</label>
																</span>
																<span>
																	<input id="addSignuplinkPlayer" value="0" name="addSignuplink" type="radio">
																	<label for="addSignuplinkPlayer">玩家</label>
																</span>
															</dd>
														
															<dd>
																<span class="tt">使用次数：</span>
																<span><input value="" way-data="addSignuplink.times" onkeyup="replaceAndSetPos(this,event,/[^\d]/g,'');" maxlength="5" type="text"></span>
																<span class="tisp">&nbsp;&nbsp;1-100的整数</span>
															</dd>
															<dd>
																<span class="tt">彩票返点：</span>
																<span><input type="text" value="" way-data="addSignuplink.rebateid" onkeyup="checkAddUserRebate();" maxlength="7"></span>
																<span class="tisp" id="addUserGeneralTipsRebate">（可分配范围 0~<way way-data="addUser.maxRebate">0</way>）</span>
															</dd>

														</dl>
														<a class="in-but-l w-16" href="javascript:;" onclick="addSignuplink();">生成链接</a>
													</div>
												</div>
												<div class="tb-imte" id="signuplinkList" style="display: none;">
													<table class="mem-biao">
														<tbody></tbody>
													</table>
													<div class="member-pag paging"></div>

												</div>
											</div>										</div>
									</div>
									<div class="tb-imte" id="allUserList" style="display:none">
										<table class="mem-biao">
											<thead>
												<tr>
													<th colspan="8">
														<span>创建时间：</span>
														<input type="text" id="userSearchStartTime" onclick="laydate({format:'YYYY-MM-DD',isclear:false});" readonly="true">
														<span>-</span>
														<input type="text" id="userSearchEndTime" onclick="laydate({format:'YYYY-MM-DD',isclear:false});" readonly="true">
														<span>余额：</span>
														<input type="text" value="" id="userSearchMinMoney">
														<span>-</span>
														<input type="text" value="" id="userSearchMaxMoney">
														<span>用户名：</span>
														<input class="in-tx-1" type="text" value="" id="userSearchLoginname">
														<a href="javascript:;" class="in-but-l h-32" onclick="allUserList();">查询</a>
													</th>
												</tr>
											</thead>
											<tbody></tbody>
										</table>
										<div class="member-pag paging"></div>
									</div>
									<div class="tb-imte" id="allOnlineUserList" style="display:none">
										<table class="mem-biao">
											<thead>
												<tr>
													<th colspan="8">
													<span>创建时间：</span>
													<input type="text" id="userOnlineSearchStartTime" onclick="laydate({format:'YYYY-MM-DD',isclear:false});" readonly="true">
													<span>-</span>
													<input type="text" id="userOnlineSearchEndTime" onclick="laydate({format:'YYYY-MM-DD',isclear:false});" readonly="true">
													<span>余额：</span>
													<input type="text" value="" id="userOnlineSearchMinMoney">
													<span>-</span>
													<input type="text" value="" id="userOnlineSearchMaxMoney">
													<span>用户名：</span>
													<input class="in-tx-1" type="text" value="" id="userOnlineSearchLoginname">
													<a href="javascript:;" class="in-but-l h-32" onclick="allUserList(1);">查询</a>
												</th>
												</tr>
											</thead>
											<tbody></tbody>
										</table>
										<div class="member-pag paging"></div>
									</div>
									<div class="mar-lr20 tb-imte" id="downUserBetsList" style="display:none">
							<table class="mem-biao">
								<thead>
									<tr>
										<th colspan="12">
											<span>下单时间：</span>
											<input type="text" id="downUserBetsSearchStartTime" onclick="laydate({format:'YYYY-MM-DD',isclear:false});" readonly="true">
											<span>-</span>
											<input type="text" id="downUserBetsSearchEndTime" onclick="laydate({format:'YYYY-MM-DD',isclear:false});" readonly="true">
											<span>订单号：</span>
											<input class="in-tx-1" type="text" value="" id="downUserBetsSearchBillno">
											<span>期号：</span>
											<input class="in-tx-1" type="text" value="" id="downUserBetsSearchExpect">
											<span>用户名：</span>
											<input class="in-tx-1" type="text" value="" id="downUserBetsSearchLoginname">
											</th>
											</tr>
											<tr>
											<th colspan="5">
											<span>彩票种类：</span>
											<select id="downUserBetsSearchShortName"></select>
											<span>彩票状态：</span>
											<select id="downUserBetsSearchState">
												<option value="">全部</option>
												<option value="0">未开奖</option>
												<option value="-1">未中奖</option>
												<option value="1">已中奖</option>
												<option value="-2">已撤单</option>
											</select>
											<a href="javascript:;" class="in-but-l h-32" onclick="allDownUserBetsList();">查询</a>
										</th>
                                            <th colspan="7" style="text-align: center; font-size:16px;">
                                            <p class="mark">
											下注统计
											大：<b way-data="allDownUserBetsList.k3hzbig">0.00</b>
                                            小：<b way-data="allDownUserBetsList.k3hzsmall">0.00</b>
                                            单：<b way-data="allDownUserBetsList.k3hzodd">0.00</b>
                                            双：<b way-data="allDownUserBetsList.k3hzeven">0.00</b>
                                            </p>
                                            </th>
                                            </tr>
								</thead>
								<tbody></tbody>
							</table>
							<div class="member-pag paging"></div>
						</div>

						<!-- 帐变记录 -->
						<div class="mar-lr20 tb-imte"	id="accountChange" style="display:none">
							<table class="mem-biao">
								<thead>
									<tr>
										<th colspan="8">
											<span>开始时间：</span>
											<input class="layriqi starTime" id="accountChangeStartTime" type="text" onclick="laydate({format:'YYYY-MM-DD',isclear:false});" readonly="true">
											<span class="zhi">结束时间：</span>
											<input class="layriqi endTime" id="accountChangeEndTime" type="text" onclick="laydate({format:'YYYY-MM-DD',isclear:false});" readonly="true">
											<span>用户名：</span>
											<input class="in-tx-1" type="text" value="" id="accountChangeSearchLoginname">
											<span>账变类型：</span>
											<select id="sourceModule">
												<option value="">全部</option>
<?php $fuddetailtypes = C('fuddetailtypes');?>
<foreach name="fuddetailtypes" item="ft" key="fk">
<option value="{$fk}" <if condition="$fk eq $type">selected</if>{$ft}</option>
</foreach>
											</select>
											<a href="javascript:;" class="in-but-l h-32" onclick="accountChange();">查询</a>
										</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
							<div class="member-pag paging"></div>
						</div>

						<div class="mar-lr20 tb-imte" id="groupDeposit" style="display:none">
							<table class="mem-biao">
								<thead>
									<tr>
										<th colspan="10">
											<span>开始时间：</span>
											<input class="layriqi starTime" id="groupDepositStartTime" type="text" onclick="laydate({format:'YYYY-MM-DD',isclear:false});" readonly="true">
											<span class="zhi">结束时间：</span>
											<input class="layriqi endTime" id="groupDepositEndTime" type="text" onclick="laydate({format:'YYYY-MM-DD',isclear:false});" readonly="true">
											<span>用户名：</span>
											<input class="in-tx-1" type="text" value="" id="groupDepositSearchLoginname">
											<span>订单号：</span>
											<input class="in-tx-1" type="text" value="" id="groupDepositSearchBillNo">
										</th>
									</tr>
									<tr>
										<th colspan="10">
											<span>类型：</span>
											<select id="groupDepositType">
												<option value="0">充值</option>
												<option value="1">提款</option>
											</select>
											<span>状态：</span>
											<select id="groupDepositState">
												<option value="">全部</option>
												<option value="0">正在处理</option>
												<option value="1">审核通过</option>
												<option value="-1">取消申请</option>
											</select>
											<a href="javascript:;" class="in-but-l h-32" onclick="groupDeposit();">查询</a>
										</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
							<div class="member-pag paging"></div>
						</div>

						<div class="mar-lr20 tb-imte" style="display:none">
							<table class="mem-biao" id="groupReport">
								<thead>
									<tr>
										<th colspan="8">
											<span>开始时间：</span>
											<input class="layriqi starTime" id="groupReportStartTime" type="text" onclick="laydate({format:'YYYY-MM-DD',isclear:false});" readonly="true">
											<span class="zhi">结束时间：</span>
											<input class="layriqi endTime" id="groupReportEndTime" type="text" onclick="laydate({format:'YYYY-MM-DD',isclear:false});" readonly="true">
											<span>用户名：</span>
											<input class="in-tx-1" type="text" value="" id="groupReportSearchLoginname">

											<a href="javascript:;" class="in-but-l h-32" onclick="groupReport();">查询</a>
										</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
							<div class="member-pag paging"></div>
						</div>




					</div>
				</div>

						</div>
					</div>
					</div>
		</div>
</section>

<script>
$(function (){
		// 我的账户信息
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
	// 全部彩票
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
	//余额切换
	$('.hide_money_btn').click(function () {
		$('.show_money').hide();
		$('.hide_money').show();
	})
	$('.show_money_btn').click(function () {
		$('.show_money').show();
		$('.hide_money').hide();
	})
	//余额刷新
	var index  = 0;
	$('.refresh_money').click(function () {
		index++;
		var sum = index*360;
		$(this).css('transform','rotate('+sum+'deg)');
	})
	//个人信息和昨日奖金榜以及中奖信息的名片显示
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
})

</script>
</body>
</html>