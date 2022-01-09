<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<title>真人视讯</title>
	<meta name="keywords" content="关键字">
	<meta name="description" content="网站主要内容">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" >

	<link rel="stylesheet" href="__CSS2__/bootstrap.min.css">
	<link rel="stylesheet" href="__CSS2__/reset.css">
	<link rel="stylesheet" href="__CSS2__/icon.css">
	<link rel="stylesheet" href="__CSS2__/header.css">
	<link rel="stylesheet" href="__CSS2__/lottery.css">
	<link rel="stylesheet" href="__CSS2__/footer.css">
	<link rel="stylesheet" href="__JS2__/layer/skin/default/layer.css">

</head>
<body>
<include file="Public/header" />
<script type="text/javascript" src="/resources/js/way.min.js"></script>
<script type="text/javascript" src="/resources/main/common.js"></script>
<script src="__JS2__/require.js" data-main="__JS2__/homePage"></script>
<div class="lotter_main">
	<div class="container padding_0 padding_t_15">
		<div class="clearfix main_scroll" style="height:auto">
			<div class="">
				<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="10000">
					<ol class="carousel-indicators">
						<li class="" data-target="#myCarousel" data-slide-to="0"></li>
						<li data-target="#myCarousel" data-slide-to="1" class="active"></li>
						<li class="" data-target="#myCarousel" data-slide-to="2"></li>
					</ol>
					<div class="carousel-inner">
						<div class="item">
							<a href=""><img src="__IMG__/banner3.png" alt="" style="width:100%"></a>
						</div>
						<div class="item active">
							<a href=""><img src="__IMG__/banner2 (1).png" alt="" style="width:100%"></a>
						</div>
					</div>
				</div>
			</div>
			
			
		</div>
		
		<div class="gradient clearfix">
			<i class="pull-left"></i>
			<em class="pull-right"></em>
		</div>
		<div class="lottery_content">
		<div class="clearfix" >
			  <div class="pull-left"><a href="{:U('Zhenren/login',array('type'=>'ag'))}"  target="_blank" ><img src="__IMG__/ag.png" style="width:250px;height:450px"></a></div>
			  <div class="pull-left" ><a href="{:U('Zhenren/login',array('type'=>'bbin'))}" target="_blank"  ><img src="__IMG__/bbin.png" style="width:250px;height:450px"/></a></div>
              <div class="pull-left" ><a href="{:U('Zhenren/login',array('type'=>'ss'))}" target="_blank"  ><img src="__IMG__/ss.png" style="width:250px;height:450px"/></a></div>
              <div class="pull-left" ><a href="{:U('Zhenren/login',array('type'=>'ky'))}"  target="_blank" ><img src="__IMG__/mg.png" style="width:250px;height:450px"></a></div>			  
		</div>
		</div>
	</div>
</div>
<include file="Public/footer" />
<script type="text/javascript" src="__JS__/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="__JS__/artDialog.js"></script>
	<script type="text/javascript" src="__JS__/index.js"></script> 
<script>
  
   
	function openwindow(url,name,iWidth,iHeight) {
		var url; //转向网页的地址;
		var name; //网页名称，可为空;
		var iWidth; //弹出窗口的宽度;
		var iHeight; //弹出窗口的高度;
		//window.screen.height获得屏幕的高，window.screen.width获得屏幕的宽
		var iTop = (window.screen.height-30-iHeight)/2; //获得窗口的垂直位置;
		var iLeft = (window.screen.width-10-iWidth)/2; //获得窗口的水平位置;
		window.open(url,name,'height='+iHeight+',,innerHeight='+iHeight+',width='+iWidth+',innerWidth='+iWidth+',top='+iTop+',left='+iLeft+',toolbar=no,menubar=no,scrollbars=auto,resizeable=no,location=no,status=no');
	}
	//玩法说明
	function helps(name,cz) {
		var url = "__ROOT__/Game.howtoplay.name."+name+".cz."+cz;
		openwindow(url,'',1058,870);

	}
</script>
</body>
</html>