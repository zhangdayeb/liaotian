{include file="Public/meta" /}
<title>基本设置</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 系统管理 <span class="c-gray en">&gt;</span> 系统设置 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<form class="form form-horizontal" id="AjaxPostForm" method="post" action="{:url('System/settingdo')}" confirm="确定吗修改系统配置吗？">
		<div id="tab-system" class="HuiTab">
			<div class="tabBar cl"><span>基本设置</span><span>后台安全</span><span>前台安全</span><span>邮件设置</span><span>其他设置</span></div>
			<div class="tabCon">
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">网站名称：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" name="info[webtitle]" placeholder="控制在25个字、50个字节以内" value="{$setlist.webtitle}" class="input-text">
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">关键词：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" name="info[keywords]" placeholder="5个左右,8汉字以内,用英文,隔开" value="{$setlist.keywords}" class="input-text">
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">描述：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" name="info[description]" placeholder="空制在80个汉字，160个字符以内" value="{$setlist.description}" class="input-text">
					</div>
				</div>
								
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">SHOW提示：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" name="info[kefuqq]" placeholder="不可看视频的提示" value="{$setlist.kefuqq}" class="input-text">
					</div>
				</div>
				
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">BIAPI接口 -站点code</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" name="info[biapi_sitecode]" placeholder="站点code" value="{$setlist.biapi_sitecode}" class="input-text">
					</div>
					
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">BIAPI接口 -站点密钥</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" name="info[biapi_key]" placeholder="站点密钥" value="{$setlist.biapi_key}" class="input-text">
					</div>
					
				</div>
				
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">BIAPI接口 -用户默认密码</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" name="info[biapi_userpass]" placeholder="用户默认密码" value="{$setlist.biapi_userpass}" class="input-text">
					</div>
					
				</div>
				
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">BIAPI接口 -接口url</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" name="info[biapi_apiurl]" placeholder="接口url 只需填域名 不需要http://" value="{$setlist.biapi_apiurl}" class="input-text">
					</div>
					
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">会员注册默认返点</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" name="info[default_fandian]" placeholder="会员注册默认返点" value="{$setlist.default_fandian}" class="input-text">
					</div>
					
				</div>
                <div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">系统彩利润：</label>
					<div class="formControls col-xs-8 col-sm-9">
                        <input type="text" name="info[xtclirun]" class="input-text" value="{$setlist.xtclirun}" style="width:60px;">%
                        &nbsp;&nbsp;不完善 建议设置为0
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">允许撤单：</label>
					<div class="formControls col-xs-8 col-sm-9">
                        <label><input type="radio" name="info[iskillorder]" value="1" {if condition="$setlist['iskillorder'] eq 1"}checked{/if}>是 </label>&nbsp;&nbsp;
                        <label><input type="radio" name="info[iskillorder]" value="0" {if condition="$setlist['iskillorder'] eq 0"}checked{/if}>否 </label>
					</div>
				</div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">开启代理佣金：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <label><input type="radio" name="info[agent_commission_open]" value="1" {if condition="$setlist['agent_commission_open'] eq 1"}checked{/if}>是 </label>&nbsp;&nbsp;
                        <label><input type="radio" name="info[agent_commission_open]" value="0" {if condition="$setlist['agent_commission_open'] eq 0"}checked{/if}>否 </label>
                    </div>
                </div>
				<div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">代理佣金彩种限制(勾选反拥)：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input name="info[agent_commission_type][]" type="checkbox" value="ssc" {if condition="in_array('ssc',$setlist['agent_commission_type'])"}checked="checked"{/if}  >时时彩
                    

                        <input name="info[agent_commission_type][]" type="checkbox" value="k3"{if condition="in_array('k3',$setlist['agent_commission_type'])"}checked="checked"{/if}  >快三

                        <input name="info[agent_commission_type][]" type="checkbox" value="x5"{if condition="in_array('x5',$setlist['agent_commission_type'])"}checked="checked"{/if}> 选5

                        <input name="info[agent_commission_type][]" type="checkbox" value="keno"{if condition="in_array('keno',$setlist['agent_commission_type'])"}checked="checked"{/if} >快乐彩
  
                        <input name="info[agent_commission_type][]" type="checkbox" value="pk10"{if condition="in_array('pk10',$setlist['agent_commission_type'])"}checked="checked"{/if} >pk10

                        <input name="info[agent_commission_type][]" type="checkbox" value="dpc"{if condition="in_array('dpc',$setlist['agent_commission_type'])"}checked="checked"{/if}  >低频彩
                  
					
                        <input name="info[agent_commission_type][]" type="checkbox" value="lhc"{if condition="in_array ('lhc',$setlist['agent_commission_type'])"}checked="checked"{/if}  >六合彩
                    </div>
                </div>
				
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">返点限制：</label>
					<div class="formControls col-xs-8 col-sm-9">
						最大：<input type="text" name="info[fanDianMax]" class="input-text" value="{$setlist.fanDianMax}" style="width:60px;">%&nbsp;&nbsp;
						最小：<input type="text" name="info[fanDianMin]" class="input-text" value="{$setlist.fanDianMin}" style="width:60px;">%&nbsp;&nbsp;

					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">绑定银行卡：</label>
					<div class="formControls col-xs-8 col-sm-9">
最多数量：<input type="text" class="input-text" name="info[sysBankMaxNum]" value="{$setlist.sysBankMaxNum}" style="width:60px;">张&nbsp;&nbsp;
                        
					</div>
				</div>
                
			
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">提款限制：</label>
					<div class="formControls col-xs-8 col-sm-9">
打码量：<input type="text" name="info[damaliang]" class="input-text" value="{$setlist.damaliang}" style="width:60px;">%,(打码量 = 充值金额 乘 **%)
<br><br>
最低提款：<input type="text" name="info[tikuanMin]" class="input-text" value="{$setlist.tikuanMin}" style="width:60px;">元&nbsp;&nbsp;
最高提款：<input type="text" name="info[tikuanMax]" class="input-text" value="{$setlist.tikuanMax}" style="width:60px;">元&nbsp;&nbsp;日提款限额：<input type="text" name="info[ritikuanxiane]" class="input-text" value="{$setlist.ritikuanxiane}" style="width:80px;">元
<br><br>
时间段： 从<input type="text" name="info[tikuanstart]" class="input-text" value="{$setlist.tikuanstart}" style="width:60px;">&nbsp;&nbsp;
到<input type="text" name="info[tikuanend]" class="input-text" value="{$setlist.tikuanend}" style="width:60px;">&nbsp;&nbsp;
<br><br>
日提款次数： <input type="text" name="info[tikuannum]" class="input-text" value="{$setlist.tikuannum}" style="width:60px;">次&nbsp;&nbsp;
超出收取费用<input type="text" name="info[tikuannumoverbilv]" class="input-text" value="{$setlist.tikuannumoverbilv}" style="width:60px;">%&nbsp;&nbsp;
最低<input type="text" name="info[tikuannumovermin]" class="input-text" value="{$setlist.tikuannumovermin}" style="width:60px;">元，最高<input type="text" name="info[tikuannumovermax]" class="input-text" value="{$setlist.tikuannumovermax}" style="width:60px;">元
<br><br>
排队人数： <input type="text" name="info[paiduinum]" class="input-text" value="{$setlist.paiduinum}" style="width:60px;">人&nbsp;&nbsp; 排队人数=真实+后台
					</div>
				</div>


                
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">积分规则：</label>
					<div class="formControls col-xs-8 col-sm-9">
每充值<input type="text" name="info[pointchongzhi]" class="input-text" value="{$setlist.pointchongzhi}" style="width:60px;">元&nbsp;积分增加<input type="text" name="info[pointchongzhiadd]" class="input-text" value="{$setlist.pointchongzhiadd}" style="width:60px;">分

					</div>
				</div>

				<!--<div class="row cl">-->
				<!--	<label class="form-label col-xs-4 col-sm-2">客服QQ：</label>-->
				<!--	<div class="formControls col-xs-8 col-sm-9">-->
				<!--		<input type="text" name="info[kefuqq]" placeholder="客服QQ" value="{$setlist.kefuqq}" class="input-text">-->
				<!--	</div>-->
				<!--</div>-->


				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">第三方客服链接代码：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" name="info[kefuthree]" placeholder="客服链接代码" value="{$setlist.kefuthree}" class="input-text">
					</div>
				</div>
			</div>
            
            
			<div class="tabCon">
                
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">后台登录最大次数：</label>
					<div class="formControls col-xs-8 col-sm-9">
						密码错误<input type="text" class="input-text" value="{$setlist.loginerrornum}" name="info[loginerrornum]"  style="width:60px;">次后，禁止登陆
                        <input type="text" class="input-text" value="{$setlist.loginerrorclosetime}" name="info[loginerrorclosetime]"  style="width:60px;">小时
					</div>
				</div>
                
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">后台登录图像验证码：</label>
					<div class="formControls col-xs-8 col-sm-9">
                        <label><input type="radio" name="info[islogincode]" value="1" {if condition="$setlist['islogincode'] eq 1"}checked{/if}>开 </label>&nbsp;&nbsp;
                        <label><input type="radio" name="info[islogincode]" value="0" {if condition="$setlist['islogincode'] eq 0"}checked{/if}>关 </label>
					</div>
				</div>
                
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">后台登录邮件验证码：</label>
					<div class="formControls col-xs-8 col-sm-9">
                        <label><input type="radio" name="info[isemailcode]" value="1" {if condition="$setlist['isemailcode'] eq 1"}checked{/if}>开 </label>&nbsp;&nbsp;
                        <label><input type="radio" name="info[isemailcode]" value="0" {if condition="$setlist['isemailcode'] eq 0"}checked{/if}>关 </label>
                        <span class="c-danger">务必保证邮件服务器能正常通过smtp发送邮件，否则后台无法登陆</span>
					</div>
				</div>
                
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">后台邮件验证码过期时间：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" name="info[adminemailcodetime]" class="input-text" value="{$setlist.adminemailcodetime}" style="width:60px;" placeholder="后台邮件验证码过期时间">秒
					</div>
				</div>
                
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">后台邮件验证码接收邮箱：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" name="info[getemailcode]" class="input-text" value="{$setlist.getemailcode}" placeholder="后台邮件验证码接收邮箱">
					</div>
				</div>
                
			</div>
			<div class="tabCon">
                
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">前台登录最大次数：</label>
					<div class="formControls col-xs-8 col-sm-9">
						密码错误<input type="text" class="input-text" value="{$setlist.loginerrornum_q}" name="info[loginerrornum_q]"  style="width:60px;">次后，禁止登陆
                        <input type="text" class="input-text" value="{$setlist.loginerrorclosetime_q}" name="info[loginerrorclosetime_q]"  style="width:60px;">小时
					</div>
				</div>
                
                
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">IP黑名单：<br><small>多个IP用","(英文逗号隔开)</small></label>
					<div class="formControls col-xs-8 col-sm-9">
						<label><input type="radio" name="info[ipblackisopen]" value="1" {if condition="$setlist['ipblackisopen'] eq 1"}checked{/if}>开启 </label>&nbsp;&nbsp;
                        <label><input type="radio" name="info[ipblackisopen]" value="0" {if condition="$setlist['ipblackisopen'] eq 0"}checked{/if}>关闭 </label></br>
                        <textarea class="textarea" name="info[ipblacklist]">{$setlist.ipblacklist}</textarea>
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">IP白名单：<br><small>多个IP用","(英文逗号隔开)<br>白名单开启后只有允许的IP列表可以访问<br>用于网站维护测试等</small></label>
					<div class="formControls col-xs-8 col-sm-9">
						<label><input type="radio" name="info[ipwhiteisopen]" value="1" {if condition="$setlist['ipwhiteisopen'] eq 1"}checked{/if}>开启 </label>&nbsp;&nbsp;
                        <label><input type="radio" name="info[ipwhiteisopen]" value="0" {if condition="$setlist['ipwhiteisopen'] eq 0"}checked{/if}>关闭 </label></br>
                        <textarea class="textarea" name="info[ipwhitelist]">{$setlist.ipwhitelist}</textarea>
					</div>
				</div>
                <div class="row cl">
                    <?php
                    $countries = array(
                        array(
                            'code'=>'PH',
                            'name'=>'菲律宾'
                        ),
                        array(
                            'code'=>'MY',
                            'name'=>'马来西亚'
                        ),
                        array(
                            'code'=>'KH',
                            'name'=>'柬埔寨'
                        ),
                        array(
                            'code'=>'LA',
                            'name'=>'老挝'
                        ),
                        array(
                            'code'=>'JP',
                            'name'=>'日本'
                        ),
                        array(
                            'code'=>'KP',
                            'name'=>'韩国'
                        ),
                        array(
                            'code'=>'VN',
                            'name'=>'越南'
                        ),
                        array(
                            'code'=>'CN',
                            'name'=>'中国'
                        ),
                    );
                    $banCountry = $setlist['bancountry'] ? json_decode($setlist['bancountry']) : array();
                    ?>
                    <label class="form-label col-xs-4 col-sm-2">禁止访问国家：<br></label>
                    <div class="cplist" style="padding:10px 15px; height:1%; overflow:hidden">
                        {volist name="countries" id="v"}
                        <div class="formControls col-xs-6 col-sm-4 col-md-2 skin-minimal radio-box">
                            <input name="info[bancountry][]" type="checkbox" value="{$v.code}" <?php if( in_array($v['code'],$banCountry) ) echo  'checked' ;?>>{$v.name}
                        </div>
                        {/volist}
                    </div>
                </div>
			</div>
			<div class="tabCon">
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">邮件服务器：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" name="info[SMTP_HOST]"  class="input-text" value="{$setlist.SMTP_HOST}" placeholder="邮件服务器">
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">安全协议：</label>
					<div class="formControls col-xs-8 col-sm-9">
                        <label><input type="radio" name="info[SMTP_SSL]" value="1" {if condition="$setlist['SMTP_SSL'] eq 1"}checked{/if}>SSL连接 </label>&nbsp;&nbsp;
                        <label><input type="radio" name="info[SMTP_SSL]" value="0" {if condition="$setlist['SMTP_SSL'] eq 0"}checked{/if}>普通连接 </label>
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">邮件发送端口：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" name="info[SMTP_PORT]"  class="input-text" value="{$setlist.SMTP_PORT}" placeholder="邮件发送端口">
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">你的邮箱名：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" name="info[FROM_EMAIL]"  class="input-text" value="{$setlist.FROM_EMAIL}" placeholder="你的邮箱名">
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">发件人地址：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" name="info[SMTP_USER]"  class="input-text" value="{$setlist.SMTP_USER}" placeholder="发件人地址">
					</div>
				</div>


                
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">发件人姓名</label>
                    <div class="formControls col-xs-8 col-sm-9">
                    	<input type="text" class="input-text" name="info[FROM_NAME]" value="{$setlist.FROM_NAME}" placeholder="发件人姓名">
                    </div>
                </div>
                
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">回复邮件地址</label>
                    <div class="formControls col-xs-8 col-sm-9">
                    	<input type="text" class="input-text" name="info[REPLY_EMAIL]" value="{$setlist.REPLY_EMAIL}" placeholder="回复邮件地址">
                    </div>
                </div>
                
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">回复邮件姓名</label>
                    <div class="formControls col-xs-8 col-sm-9">
                    	<input type="text" class="input-text" name="info[REPLY_NAME]" value="{$setlist.REPLY_NAME}" placeholder="回复邮件姓名">
                    </div>
                </div>

				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">邮箱密码：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="password" name="info[SMTP_PASS]"  class="input-text" value="{$setlist.SMTP_PASS}" placeholder="邮箱密码">
					</div>
				</div>
			</div>
			<div class="tabCon">
                
                
                
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">采集接口设置：</label>
					<div class="formControls col-xs-8 col-sm-9">
                        <input class="input-text" name="info[caijieapiurl]" placeholder="采集接口设置" value="{$setlist.caijieapiurl}" type="text"><br><small>修改5分钟内生效</small>
                        
                        
					</div>
				</div>
                
                
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">允许前台IP地址：</label>
					<div class="formControls col-xs-8 col-sm-9">
                        <textarea class="textarea" name="info[weballowips]">{$setlist.weballowips}</textarea><br><small>前台服务器IP地址，多个用(,)隔开</small>
                        
                        
					</div>
				</div>
                
                <div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">后台提示音：</label>
					<div class="formControls col-xs-8 col-sm-9">
充值提示音：
<label><input type="radio" name="info[czaudioplay]" value="1" {if condition="$setlist['czaudioplay'] eq 1"}checked{/if}>开启提示 </label>&nbsp;&nbsp;
<label><input type="radio" name="info[czaudioplay]" value="0" {if condition="$setlist['czaudioplay'] eq 0"}checked{/if}>关闭提示 </label>
&nbsp;&nbsp;&nbsp;&nbsp;
提示<input name="info[czaudioplaytime]" class="input-text"  value="{$setlist.czaudioplaytime}" style="width:60px;" type="number">分钟内的，超过：<input name="info[czaudioqxtime]" class="input-text" value="{$setlist.czaudioqxtime}" style="width:60px;" type="number">分钟自动关闭
<br><br>
提款提示音：
<label><input type="radio" name="info[tkaudioplay]" value="1" {if condition="$setlist['tkaudioplay'] eq 1"}checked{/if}>开启提示 </label>&nbsp;&nbsp;
<label><input type="radio" name="info[tkaudioplay]" value="0" {if condition="$setlist['tkaudioplay'] eq 0"}checked{/if}>关闭提示 </label>
&nbsp;&nbsp;&nbsp;&nbsp;
<input name="info[tkaudioplaytime]" class="input-text" value="{$setlist.tkaudioplaytime}" style="width:60px;" type="number">分钟内的
<br><br>
银行绑定提示音：
<label><input type="radio" name="info[cardaudioplay]" value="1" {if condition="$setlist['cardaudioplay'] eq 1"}checked{/if}>开启提示 </label>&nbsp;&nbsp;
<label><input type="radio" name="info[cardaudioplay]" value="0" {if condition="$setlist['cardaudioplay'] eq 0"}checked{/if}>关闭提示 </label>
&nbsp;&nbsp;&nbsp;&nbsp;

<br><br>

					</div>
				</div>
                
                <div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">默认推荐码：</label>
					<div class="formControls col-xs-8 col-sm-9">
                        <input type="text" name="info[defaulttjcode]" class="input-text" value="{$setlist.defaulttjcode}" style="width:80px;">会员注册页面提示(0 不提示)
                        
                        
					</div>
				</div>
                
                
			</div>
			
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
				<button onClick="article_save_submit();" class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存</button>
				<button onClick="layer_close();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
			</div>
		</div>
	</form>
</div>
{include file="Public/footer" /}
<script>
	setTimeout(function(){
		$('.tabBar span').eq(0).click();
	}) 
</script>
</body>
</html>