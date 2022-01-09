{include file="Public/meta" /}
<title>额度转换管理</title>
</head>
<body>
<nav class="breadcrumb">



<span class="r">
<a class="btn btn-success radius r btn-refresh" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</span>
</nav>
<div class="page-container">
	<form method="get" action="{:U('transrecord')}" class="text-c">

下注时间:&nbsp;&nbsp;&nbsp;<input class="input-text" type="text" style="width:180px;" 
onFocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" name="sDate" value="{$_sDate}"> - 
<input class="input-text" type="text" style="width:180px;" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" value="{$_eDate}" name="eDate">&nbsp;&nbsp;

        用户名：<input class="input-text" type="text"  value="{$username}" name="username" style="width:180px">
        
        <a class="btn btn-default-outline radius" href="{:U('transrecord')}">重置</a>
      
        <input class="btn btn-primary-outline radius" type="submit" value="查询">
        
    </form>
	<div class="mt-5">
    <form method="post" action="">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				
                <th width="40">ID</th>
				
				<th width="80">用户名</th>
	            <th width="80">下注编号</th>
	            <th width="50">游戏CODE</th>
				<th width="60">赛事详情</th>
	            <th width="70">下注类型</th>
				<th width="60">下注金额</th>
				<th width="60">输赢金额</th>
				<th width="60">日期</th>
				
				
			</tr>
		</thead>
		<tbody>
			{volist name="list" id="vo"}
            <tr class="text-c">
				
                <td>{$vo.kyID}</td>
               
                <td>{$vo.account_code}</u></td>
                 <td>{$vo.transactionid}</td>
                <td>{$vo.play_type}</td>
                <td>{$vo.league_name} {$vo.teamA_name}VS{$vo.teamB_name}</td>
			
				<td>{$vo.bet_type_code}/{$vo.Team_bet_code}@{$vo.wager_odds}</td>
                <td>{$vo.wager_stake}</td>
				   <td>{$vo.win_amt}</td>
             
				<td>{$vo.date_created}</td>
				</tr>
            {/volist}
		</tbody>
	</table>
    <div class="cl pd-5 bg-1 bk-gray mt-20 text-c">
        <div class="l" style="padding:0">
		</div>
        <div class="r">
            <div class="pageNav l" style="padding:0">{$page}</div>
            <div class="r">共有数据：<strong>{$totalcount}</strong> 条 </div>
        </div>
    </div>
    </form>
	</div>
</div>
{include file="Public/footer" /}
<script>
$(document).on("click", "[lock-url]", function() {
	var obj       = $(this);
	var url       = $(this).attr('lock-url');
	var title     = obj.attr('title')?$(this).attr('title'):'您确认操作吗？';
	var issuccess = obj.hasClass('label-success');
	layer.confirm(title,function(index){
		$.getJSON(url, function(json){
			if(json.status==1){
				if(obj.text()=='锁定'){
					obj.removeClass('c-999').addClass('c-green').text('解锁');
				}else{
					obj.removeClass('c-green').addClass('c-999').text('锁定');
				}
				
				layer.msg('操作成功',{icon: 1,time:1000});
			}else{
				layer.msg(json.info,{icon: 2,time:2000});
			};
		});
	});
});

</script>
</body>
</html>