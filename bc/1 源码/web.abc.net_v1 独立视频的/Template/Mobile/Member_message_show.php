<include file="Public/header" />
<link rel="stylesheet" href="__CSS__/userHome.css">
<body class="bg_fff">
	<header data-am-widget="header"class="am-header am-header-default header nav_bg am-header-fixed">
		<div class="am-header-left am-header-nav">
			<a href="javascript:history.back(-1);" class="">
				<i class="iconfont icon-arrow-left"></i>
			</a>
      	</div>
		<h1 class="am-header-title userHome_h1">
			私信详情
		</h1>
	</header>
	
	<div class="noticeContent">
		<div class="noticeContent_t">
			<h2>{$res.Title}</h2>
			<p>{$res.PDate|date="Y-m-d",###}</p>
		</div>
		<hr />
		<div class="noticeContent_bd">
			{$res.Message}
		</div>
	</div>
</body>
</html>