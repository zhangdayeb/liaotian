<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<title>{:GetVar('webtitle')}</title>
	<meta name="keywords" content="{:GetVar('keywords')}" />
	<meta name="description" content="{:GetVar('description')}" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" >

	<link rel="stylesheet" href="__CSS2__/bootstrap.min.css">
	<link rel="stylesheet" href="__CSS2__/reset.css">
	<link rel="stylesheet" href="__CSS2__/icon.css">
	<link rel="stylesheet" href="__CSS2__/header.css">
	<link rel="stylesheet" href="__CSS2__/record.css">
	<link rel="stylesheet" href="__CSS2__/userInfo.css">
	<link rel="stylesheet" href="__CSS2__/footer.css">
	<link rel="stylesheet" href="__JS2__/layer/skin/default/layer.css">
	<script type="text/javascript" src="__JS__/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="__JS__/artDialog.js"></script>

	<script>
		var ISLOGIN = "{$userinfo.id}";
	</script>
	<script src="__JS__/index.js"></script>
</head>
<body>
<include file="Public/header" />
	<script src="__JS2__/require.js" data-main="__JS2__/homePage"></script>
	<div class="vip_info clearfix container">
		<include file="Member/side" />
		<div class="pull-right vip_info_pan">
			<div class="vip_info_title">
			</div>
			<div class="vip_info_content betRecord_main">
				<div class="betRecord_top">
					<strong>今日概况</strong>
					<span>投注金额：<em>{$touzhujine}元</em></span>
					
					<span> 输赢金额：<em>{$allokamount-$touzhujine}元</em></span>
				</div>
				<div class="betRecord_tab clearfix">
					<div class="category pull-left" style="display:none">
						<em class="tle">彩种：</em>
						<div class="form-group">
							<select name="lotteryId" id="lottery_code" onchange="chaxun();" class="form-control" id="">
								<option value="0">全部彩票</option> {$cp[name]} 
								<volist name="ALLCP" id="cp">
								 <option value="{$cp[name]}"  <eq name="cp[name]" value="$Think.get.name">selected="selected"</eq> >{$cp[title]}</option>
								</volist>
							</select>
						</div>
					</div>
					<span class="bet_status pull-left" id="status-box">
						<em class="tle">游戏类别：</em>
						<span class="bet_common_bor a_item  <if condition="$Think.get.a_item eq 1">active</if> <if condition="$Think.get.a_item eq ''">active</if>" value="1""  onclick="chaxun(null,'1');">AG游戏</span>
						<span class="bet_common_bor a_item  <if condition="$Think.get.a_item eq 2">active</if>" value="2""  onclick="chaxun(null,'2');">BB游戏</span>
						<span class="bet_common_bor a_item  <if condition="$Think.get.a_item eq 3">active</if>" value="3""  onclick="chaxun(null,'3');">皇冠体育</span>
						
					<div class="bet_time pull-left" id="time-box">
						<em class="tle">时间：</em>
						<span class="bet_common_bor <if condition="$Think.get.atime eq 1">active</if>" value="1"  onclick="chaxun('1',null);">今天</span>
						<span class="bet_common_bor <if condition="$Think.get.atime eq 2">active</if>" value="2" onclick="chaxun('2',null);">昨天</span>
						<span class="bet_common_bor <if condition="$Think.get.atime eq 3">active</if>" value="3" onclick="chaxun('3',null);">七天</span>
					</div>
					
					</div>


									<div class="bet_info  col-sm-12">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>订单号</th>
								<th>游戏</th>
								<th>投注金额</th>
								<th>输赢金额</th>
								<th>时间</th>
								<!--<th>操作项</th>-->
							</tr>
						</thead>
						<tbody>
						
						<if condition="$Think.get.a_item eq 2">
						<volist name="tzlist" id="vo">
							<tr>113
								<td>{$vo.WagersID}</td>
								<td>{$vo.GameCode}</td>
								<td>{$vo.BetAmount}</td>
								<td>{$vo.Payoff}</td>
								<td>{$vo.WagersDate}</td>
								</tr>
							</volist>
							</if>
						<if condition="$Think.get.a_item eq 3">
						<volist name="tzlist" id="vo">
							<tr>111
								<td>{$vo.transactionid}</td>
								<td>{$vo.play_type}</td>
								
								<td>{$vo.wager_stake}</td>
								<td>{$vo.win_amt}</td>
								<td>{$vo.date_created}</td>
								</tr>
									</volist>
							</if>
								<if condition="$Think.get.a_item eq ''">
						<volist name="tzlist" id="vo">
							<tr>
								<td>{$vo.BillNo}</td>
								<td>{$vo.GameType}</td>
								
								<td>{$vo.BetAmount}</td>
								<td>{$vo.NetAmount}</td>
								<td>{$vo.BetTime}</td>
								
								
								</tr>
								</volist>
								</if>
								<if condition="$Think.get.a_item eq 1">
						<volist name="tzlist" id="vo">
							<tr>
								<td>{$vo.BillNo}</td>
								<td>{$vo.GameType}</td>
								
								<td>{$vo.BetAmount}</td>
								<td>{$vo.NetAmount}</td>
								<td>{$vo.BetTime}</td>
								
								
								</tr>
								</volist>
								</if>
						</tbody>
					</table>
				</div>
				<!-- 如果没有查到就显示这个 -->
				<div class="no_result" style="display:none;">
					暂无记录
				</div>
<!--				<ul class="pagination bet_paging">
					<li><a href="">上一页</a></li>
					<li class="active"><a href="">1</a></li>
					<li><a href="">2</a></li>
					<li><a href="">3</a></li>
					<li><a href="">4</a></li>
					<li><a href="">下一页</a></li>
					<li><a href="">共 <em class="color_res">0</em> 页</a></li>
				</ul>-->
				<div class="page" id="page">{$pageshow}</div>
				<div class="prompt">
					<i class="iconfont">&#xe659;</i>
					温馨提示：投注记录最多只保留7天。
				</div>
				</div>


			</div>
		</div>
	</div>
<include file="Public/footer" />

<div class="modal fade ytz_model" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">投注内容</h4>
            </div>
            <div class="modal-body" style="word-wrap:break-word ;">
                ----
            </div>
        </div>
    </div>
</div>

<script>
	function chaxun(t,s){
		var name=$("#lottery_code").val();
		/*var qihao=$("#qihao_code").val();*/
		if(t){
			var atime = t;
		}else{
			var atime = $('#time-box span.active').attr('value');
		}
		if(s){
			var a_item = s;
		}else{
			var a_item = $('#status-box span.active').attr('value');
		}
		var url = '__ROOT__'+"/Member.zrbetRecord.name."+name+".atime."+atime+".a_item."+a_item;
		window.location.href = url;
	}
/*	function chexun() {
		alert();
	}*/
</script>

</body>
</html>