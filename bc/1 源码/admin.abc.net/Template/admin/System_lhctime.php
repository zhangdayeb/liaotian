{include file="Public/meta" /}
<title>六合开盘时间</title>
</head>
<body>

<div class="page-container">
    <span class="r"><a href="javascript:;" layer-url="/System.lhctime_add" title="添加数据" class="btn btn-primary radius"><i class="Hui-iconfont"></i> 添加数据</a>&nbsp;&nbsp;&nbsp;
<a class="btn btn-success radius r btn-refresh" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</span>
	<form method="get" action="{:U(CONTROLLER_NAME.'/'.ACTION_NAME)}" class="text-c">

</select></span>
    </form>
    <div class="mt-5">
    <form method="post" action="{:U(CONTROLLER_NAME.'/'.ACTION_NAME)}">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
                
                <th width="80">期号</th>
				<th width="80">开盘时间</th>
				<th width="80">操作</th>
			</tr>
		</thead>
		<tbody>
		{volist name="list" id="vo"}
            <tr class="text-c">
                <td>{$vo.qihao}</td>
                <td>{$vo.drawTime|date="Y-m-d H:i",###}</td>
				<td>
                <a style="text-decoration:none;color:blue;" class="ml-5" layer-del-url="{:U('System/lhctime_del',['id'=>$vo['id']])}" href="javascript:;" title="删除">删除</a>
                </td>
			</tr>
		{/volist}
            
		</tbody>
	</table>
    <div class="cl pd-5 bg-1 bk-gray mt-20 text-c">
       
        <div class="r">
            <div class="pageNav l" style="padding:0">{$page}</div>
            
        </div>
    </div>
    
    </form>
	</div>
</div>
{include file="Public/footer" /}

<script type="text/javascript" src="__ROOT__/Template/admin/resources/ui/lib/bootstrap-modal/2.2.4/bootstrap-modalmanager.js"></script>
<script type="text/javascript" src="__ROOT__/Template/admin/resources/ui/lib/bootstrap-modal/2.2.4/bootstrap-modal.js"></script>
<script>
$(document).on("click", "[tip-content]", function() {
	var obj       = $(this);
	var content = $(obj).attr('tip-content');
	$("#myModalLabel").text("单号:"+$(obj).attr('trano'));
	$("#_wfts_remark").html(content);
	$("#modalwfts").modal("show");
});

</script>
</body>
</html>