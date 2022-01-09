{include file="Public/meta" /}
<title>消息管理</title>
</head>
<body>

<div class="page-container">
	<form method="get" action="{:U(CONTROLLER_NAME.'/'.ACTION_NAME)}" class="text-c">
        接收人id：<input class="input-text" type="text" style="width:120px;" value="{$RecID}" name="RecID">
        <input class="btn btn-primary-outline radius" type="submit" value="查询">
        <a class="btn btn-success radius r btn-refresh" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont"></i></a>
    </form>
    <a href="javascript:;" layer-url="{:U('add')}" title="添加新消息" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加新消息</a>
	<div class="mt-5">
    <form method="post" action="">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				<th width="25"><input type="checkbox" name="" value=""></th>
                <th width="40">ID</th>
                <th width="100">标题</th>
                <th width="200">内容</th>
                <th width="40">收信人id</th>
                <th width="40">时间</th>
				<th width="40">操作</th>
			</tr>
		</thead>
		<tbody>
			{volist name="list" id="vo"}
            <tr class="text-c">
				<td><input type="checkbox" class="checkids" value="{$vo.id}" name="ids[{$vo.id}]"></td>
                <td>{$vo.id}</td>
                <td>{$vo.Title}</td>
                <td>{:substr(strip_tags($vo['Message']),0,30)}</td>
                <td>{$vo.RecID}</td>
                <td>{$vo.PDate|date="Y-m-d H:i:s",###}</td>
				<td class="td-manage">
                    <a style="text-decoration:none" class="ml-5" layer-url="{:U('view',['id'=>$vo['id']])}" href="javascript:;" title="查看">查看</a>
                    <a style="text-decoration:none" class="ml-5" layer-url="{:U('edit',['id'=>$vo['id']])}" href="javascript:;" title="编辑">编辑</a>
                    <a style="text-decoration:none" class="ml-5" layer-del-url="{:U('del',['id'=>$vo['id']])}" href="javascript:;" title="删除">删除</a>
               </td>
			</tr>
            {/volist}
		</tbody>
	</table>
    <div class="cl pd-5 bg-1 bk-gray mt-20 text-c">
        <div class="l" style="padding:0"><!--<a href="javascript:;" deleteall-url="{:U('deleteall')}" title="删除" class="btn btn-danger-outline radius">删除</a>--></div>
        <div class="r">
            <div class="pageNav l" style="padding:0">{$page}</div>
            <div class="r">共有数据：<strong>{$count}</strong> 条 </div>
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