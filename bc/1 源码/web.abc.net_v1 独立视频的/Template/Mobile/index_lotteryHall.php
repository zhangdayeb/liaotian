<include file="Public/header" />
<link rel="stylesheet" href="__CSS__/activity.css">

<body>
	<header data-am-widget="header"class="am-header am-header-default header nav_bg am-header-fixed">
		<div class="am-header-left am-header-nav">
			<a href="javascript:history.back(-1);" class="">
				<i class="iconfont icon-arrow-left"></i>
			</a>
    </div>
		<h1 class="am-header-title activity_h1">
			全部活动
		</h1>
	</header>
	 <!--div data-am-widget="tabs" class="am-tabs am-tabs-default" style="margin: 0;">
      <ul class="am-tabs-nav am-cf" style="background: #000;overflow: auto;overflow-y: hidden;">
          <li class="am-active"><a href="[data-tab-panel-0]">
						<i class="iconfont icon-quanbu"></i>
						午夜约吧</a></li>
      <!--    <li class=""><a href="[data-tab-panel-1]">-->
						<!--<i class="iconfont icon-fucaikuai3"></i>-->
						<!--午夜约吧</a></li>-->
    <!--      <li class=""><a href="[data-tab-panel-2]">-->
				<!--		<i class="iconfont icon--shishicai"></i>-->
				<!--		时时彩</a></li>-->
				<!--	<li class=""><a href="[data-tab-panel-3]">-->
				<!--		<i class="iconfont icon-kuaile8"></i>-->
				<!--		快乐彩</a></li>-->
		  <!--<li class=""><a href="[data-tab-panel-4]">-->
				<!--  <i class="iconfont icon-kuaile8"></i>-->
				<!--  PK10</a></li>-->
    <!--      <li class=""><a href="[data-tab-panel-5]">-->
				<!--		<i class="iconfont icon-11xuan5"></i>-->
				<!--		11选5</a></li>-->
				<!--	<li class=""><a href="[data-tab-panel-6]">-->
				<!--		<i class="iconfont icon-pailie3"></i>-->
				<!--		低频彩</a></li>-->
		  <!--<li class=""><a href="[data-tab-panel-6]">-->
				<!--  <i class="iconfont" style="color:#07b39e">&#xe65a;</i>-->
				<!--  六合彩</a></li>-->
      </ul>
      <div class="am-tabs-bd">
          <div data-tab-panel-0 class="am-tab-panel am-active">
            <ul class="home_main am-avg-sm-3">
				<volist name="cplist" id="cp">
				
				<eq name="cp.typeid" value="pk10">
											<li class="home_main_list">
												<a href="__ROOT__/Game.old{$cp.typeid}.code.{$cp.name}.do">
													<img src="/icon/{$cp[name]}.png" style="height:43px;with:40px;main-right:12px;margin-left:3px;">
												</a>
													<h4>{$cp.title}</h4>
													<em>{$cp.ftitle}</em>
											</li>
					</eq>
					<eq name="cp.typeid" value="ssc">
											<li class="home_main_list">
												<a href="__ROOT__/Game.old{$cp.typeid}.code.{$cp.name}.do">
													<img src="/icon/{$cp[name]}.png" style="height:43px;with:40px;main-right:12px;margin-left:3px;">
												</a>
													<h4>{$cp.title}</h4>
													<em>{$cp.ftitle}</em>
											</li>
					</eq>
										
				
					 <!--li class="home_main_list">
						
						      <a href="__ROOT__/Game.{$cp.typeid}?code={$cp.name}">
							  <img src="/icon/{$cp[name]}.png" style="height:43px;with:40px;main-right:12px;margin-left:3px;">
							  </a>
							
							<h3>{$cp.title}</h3>
							<em>{$cp.ftitle}</em>
					</li-->
					
					<eq name="cp.typeid" value="k3">
											<li class="home_main_list">
												<a href="__ROOT__/Game.{$cp.typeid}.code.{$cp.name}.do">
													<img src="/icon/{$cp[name]}.png" style="height:43px;with:40px;main-right:12px;margin-left:3px;">
												</a>
													<h3>{$cp.title}</h3>
													<em>{$cp.ftitle}</em>
											</li>
										</eq>
										
										<eq name="cp.typeid" value="keno">
											<li class="home_main_list">
												<a href="__ROOT__/Game.{$cp.typeid}.code.{$cp.name}.do">
													<img src="/icon/{$cp[name]}.png" style="height:43px;with:40px;main-right:12px;margin-left:3px;">
												</a>
													<h3>{$cp.title}</h3>
													<em>{$cp.ftitle}</em>
											</li>
										</eq>
										
										<eq name="cp.typeid" value="x5">
											<li class="home_main_list">
												<a href="__ROOT__/Game.{$cp.typeid}.code.{$cp.name}.do">
													<img src="/icon/{$cp[name]}.png" style="height:43px;with:40px;main-right:12px;margin-left:3px;">
												</a>
													<h3>{$cp.title}</h3>
													<em>{$cp.ftitle}</em>
											</li>
										</eq>
										<eq name="cp.typeid" value="dpc">
											<li class="home_main_list">
												<a href="__ROOT__/Game.{$cp.typeid}.code.{$cp.name}.do">
													<img src="/icon/{$cp[name]}.png" style="height:43px;with:40px;main-right:12px;margin-left:3px;">
												</a>
													<h3>{$cp.title}</h3>
													<em>{$cp.ftitle}</em>
											</li>
										</eq>
										<eq name="cp.typeid" value="lhc">
											<li class="home_main_list">
												<a href="__ROOT__/Game.{$cp.typeid}.code.{$cp.name}.do">
													<img src="/icon/{$cp[name]}.png" style="height:43px;with:40px;main-right:12px;margin-left:3px;">
												</a>
													<h3>{$cp.title}</h3>
													<em>{$cp.ftitle}</em>
											</li>
										</eq>
										
				</volist>

				</ul>
					</div>
          <div data-tab-panel-1 class="am-tab-panel ">
								<ul class="home_main am-avg-sm-3">
									<volist name="cplist2" id="cp">
										<eq name="cp.typeid" value="k3">
											<li class="home_main_list">
												<a href="__ROOT__/Game.{$cp.typeid}.code.{$cp.name}.do">
													<img src="/icon/{$cp[name]}.png" style="height:43px;with:40px;main-right:12px;margin-left:3px;">
												</a>
													<h3>{$cp.title}</h3>
													<em>{$cp.ftitle}</em>
											</li>
										</eq>
									</volist>
								</ul>
          </div>
          <div data-tab-panel-2 class="am-tab-panel ">
            <ul class="home_main am-avg-sm-3">
				<volist name="cplist2" id="cp">
					<eq name="cp.typeid" value="ssc">
											<li class="home_main_list">
												<a href="__ROOT__/Game.old{$cp.typeid}.code.{$cp.name}.do">
													<img src="/icon/{$cp[name]}.png" style="height:43px;with:40px;main-right:12px;margin-left:3px;">
												</a>
													<h3>{$cp.title}</h3>
													<em>{$cp.ftitle}</em>
											</li>
										</eq>
				</volist>
			 </ul>
          </div>
		 <div data-tab-panel-3 class="am-tab-panel">
            <ul class="home_main am-avg-sm-3">
				<volist name="cplist2" id="cp">
					<eq name="cp.typeid" value="keno">
											<li class="home_main_list">
												<a href="__ROOT__/Game.{$cp.typeid}.code.{$cp.name}.do">
													<img src="/icon/{$cp[name]}.png" style="height:43px;with:40px;main-right:12px;margin-left:3px;">
												</a>
													<h3>{$cp.title}</h3>
													<em>{$cp.ftitle}</em>
											</li>
										</eq>
				</volist>
				 </ul>
			 </div>
		  <div data-tab-panel-4 class="am-tab-panel">
			  <ul class="home_main am-avg-sm-3">
				  <volist name="cplist2" id="cp">
					  <eq name="cp.typeid" value="pk10">
											<li class="home_main_list">
												<a href="__ROOT__/Game.old{$cp.typeid}.code.{$cp.name}.do">
													<img src="/icon/{$cp[name]}.png" style="height:43px;with:40px;main-right:12px;margin-left:3px;">
												</a>
													<h3>{$cp.title}</h3>
													<em>{$cp.ftitle}</em>
											</li>
										</eq>
				  </volist>
			  </ul>
		  </div>
		  <div data-tab-panel-5 class="am-tab-panel">
			  <ul class="home_main am-avg-sm-3">
				  <volist name="cplist2" id="cp">
					  <eq name="cp.typeid" value="x5">
											<li class="home_main_list">
												<a href="__ROOT__/Game.{$cp.typeid}.code.{$cp.name}.do">
													<img src="/icon/{$cp[name]}.png" style="height:43px;with:40px;main-right:12px;margin-left:3px;">
												</a>
													<h3>{$cp.title}</h3>
													<em>{$cp.ftitle}</em>
											</li>
										</eq>
				  </volist>
			  </ul>
		  </div>
		  <div data-tab-panel-6 class="am-tab-panel">
			  <ul class="home_main am-avg-sm-3">
				  <volist name="cplist2" id="cp">
					  <eq name="cp.typeid" value="dpc">
											<li class="home_main_list">
												<a href="__ROOT__/Game.{$cp.typeid}.code.{$cp.name}.do">
													<img src="/icon/{$cp[name]}.png" style="height:43px;with:40px;main-right:12px;margin-left:3px;">
												</a>
													<h3>{$cp.title}</h3>
													<em>{$cp.ftitle}</em>
											</li>
										</eq>
				  </volist>
			  </ul>
		  </div>
		  <div data-tab-panel-6 class="am-tab-panel">
			  <ul class="home_main am-avg-sm-3">
				  <volist name="cplist2" id="cp">
					 <eq name="cp.typeid" value="lhc">
											<li class="home_main_list">
												<a href="__ROOT__/Game.{$cp.typeid}.code.{$cp.name}.do">
													<img src="/icon/{$cp[name]}.png" style="height:43px;with:40px;main-right:12px;margin-left:3px;">
												</a>
													<h3>{$cp.title}</h3>
													<em>{$cp.ftitle}</em>
											</li>
										</eq>
				  </volist>
			  </ul>
		  </div>
      </div>
  </div>
<!--	<script>
		$('li.home_main_list a').click(function(event){
			var url = $(this).attr('href');
			$.ajax({
				url:url,
				type: 'POST',
				success : function(json){
					if(json.sign == 'fase'){
						alert(json.message);
						window.location.href="{:U('Public/login')}";
					}else{
						window.location.href=url;
					}
				}
			})
		})
	</script>-->
</body>
</html>