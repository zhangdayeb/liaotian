{include file="Public/meta" /}
<title>改单</title>
</head>
<body>
<article class="page-container">
	<form action="{:U('Game/gaido')}" method="post" class="form form-horizontal validate-form" id="AjaxPostForm">
		
        <div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>单号</label>
			<div class="formControls col-xs-8 col-sm-9">
				{$info.trano}
				<input type="hidden" readonly="true" class="input-text" value="{$info.id}" placeholder="" name="id">
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>投注号码</label>
			<div class="formControls col-xs-8 col-sm-9">
				<textarea name='code'rows=20 cols =80>{$info.tzcode}</textarea>
			</div>
		</div>
     
        
        
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;确定&nbsp;&nbsp;">
			</div>
		</div>
	</form>
</article>

{include file="Public/footer" /}

</body>
</html>