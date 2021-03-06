<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{:GetVar('webtitle')}</title>
	<meta name="keywords" content="{:GetVar('keywords')}" />
	<meta name="description" content="{:GetVar('description')}" />
	<link rel="stylesheet" href="__CSS2__/bootstrap.min.css">
	<link rel="stylesheet" href="__CSS2__/reset.css">
	<link rel="stylesheet" href="__CSS2__/icon.css">
	<link rel="stylesheet" href="__CSS2__/header.css">
	<link rel="stylesheet" href="__CSS2__/main.css">
	<link rel="stylesheet" href="__CSS2__/footer.css">
	<script>
		var ISLOGIN = "{$userinfo.id}";
		var WebConfigs = {
			'ROOT' :"__ROOT__"
		}
	</script>
	<link rel="stylesheet" type="text/css" href="__ROOT__/resources/css/common.css" />
	<link rel="stylesheet" type="text/css" href="__ROOT__/resources/css/layout.css" />
	<link rel="stylesheet" type="text/css" href="__ROOT__/resources/css/style.css" />
	<link rel="stylesheet" type="text/css" href="__ROOT__/resources/css/artDialog.css" />
	<script type="text/javascript" src="__ROOT__/resources/js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="__ROOT__/resources/js/artDialog.js"></script>
	<script type="text/javascript" src="__ROOT__/resources/js/way.min.js"></script>
	<script type="text/javascript" src="__ROOT__/resources/main/common.js"></script>
	
</head>


<body style="background: linear-gradient( #f3fff4, #fff) no-repeat;">
<!--top-->
<!--top-->
<include file="Public/header" />
<!--baner-->

<script type="text/javascript">
	$(function () {
		if ($("#kinMaxShow").size() > 0) {
			$("#kinMaxShow").kinMaxShow({
				height: 225,
				intervalTime: 2,
				button: {
					showIndex: false,
					normal: { marginRight: '8px', border: '0', right: '50%', bottom: '10px', borderRadius: '7px', background: '#fff' },
					focus: { background: '#bd0d0d', border: '0' }
				}
			});
		}
		$(".bann_list li").mouseover(function () {
			$(this).children("dl").show();
		})
		$(".bann_list li").mouseleave(function () {
			$(this).children("dl").hide();
		})
	});
</script>

<!--navlist-->
<!--wapper-->
<!--????????????-->
<!--????????????????????????,true?????????????????????-->
<input id="EachMaxLotteryValue" type="hidden" value="500000.00" />
<input id="MemberBettingAuthority" type="hidden" value="False" />
<input id="_jsurl" type="hidden" value="/templates/SSC" />   <!-- js?????? -->

<script>
	$(function () {
		$('.refresh_money').click(function () {
			$.ajax({
				url:"{:U('Member/refresh_money')}",
				type:'POST',
				success :function (data) {
					$('.smallmoney').html(data);
				}
			})
		})

	})
</script>
<!--wapper-->
<div class="h35"></div>
<div class="wapper ">
	<div class="w1000">
    	<div id="cookie_registerForms" class="register login_m_form b1 bg_wite">
        	<h4>????????????</h4>
            <form method="post" class="ruivalidate_form_class" onsubmit="return check_login(this)" id="ruivalidate_form_class" checkby_ruivalidate url="" action="__ROOT__/Apublic.logindo">
                <input type="hidden" name="action" value="register_agent" />
                <dl>
                	<dt>???&nbsp;&nbsp; ??????</dt>
                    <dd>
                    	<input  type="text"  class="text_accont" name="userName"  verify="isLoginName" isNot="true" msg="??????????????????"/>
                    </dd>
                </dl>
                <dl>
                	<dt>???&nbsp;&nbsp; ??????</dt>
                    <dd>
                    	<input  type="password" class="text_accont" name="passWord" verify="isALL" isNot="true" msg="?????????6-16????????????????????????????????????"/>
                    </dd>
                </dl>
<!--                <dl>
                	<dt>????????????</dt>
                    <dd>
                    	<input class="text_accont" type="text" autocomplete="off" isnot="true" msg="??????????????????" name="verCode" style="width:120px !important;"><a href="javascript:void(0)" class="two_code">
                                    <img  src="{:U('Public/verify',array('imageW'=>120,'imageH'=>35))}"  onclick="this.src=this.src+'?temp='+ 1" /></a>
                    </dd>
                </dl>-->
                <dl>
                	
                    <dd>
                    	<input  type="submit" value="????????????" class="sub_btn submit"/>
                    </dd>
                	
                    <dd>
                    	<input  type="button" value="??????????????????" onclick="location.href='{:U('Public/login')}'" style="height: 40px;width: 140px;text-align: center;line-height: 40px;color: #FFF;background: #ea544a;font-size: 15px;font-weight: bold;margin-right: 20px; background:orange;"/>
                    </dd>
                </dl>
                <dl style="padding:0;">
                </dl>
            </form>
        </div>





    </div>
</div>
<!--wapper-->
<div class="h35"></div>
<include file="Public/footer" />
<div class="loginCengBox">
	<div class="loginCeng">
		<div class="loginCengH">
			<h3>????????????</h3>
			<span class="loginCengClose">
				<i class="iconfont icon-guanbi-copy"></i>
			</span>
		</div>
		<div class="loginCengB">
		
		</div>
		<div class="loginCengF">
			<button type="submit" >??????</button>
		</div>
	</div>
</div>
<script type="text/javascript" src="__ROOT__/resources/js/jquery.form.min.js"></script><!-- Jquery form???????????? -->
<script type="text/javascript" src="__ROOT__/resources/js/jquery.ruiValidate.js"></script><!-- ???????????????js?????? -->
<script type="text/javascript" src="__ROOT__/resources/js/jquery.kinMaxShow-1.1.min.js"></script>
<script type="text/javascript">
$(function(){
	$("#kinMaxShow").kinMaxShow({
		height:225,
		intervalTime:2,
		button:{
			showIndex:false,
			normal:{marginRight:'8px',border:'0',right:'50%',bottom:'10px',borderRadius:'7px',background:'#fff'},
			focus:{background:'#bd0d0d',border:'0'}
		}
	});

});
</script>
<!-- ???????????? -->
<script type="text/javascript">

$(function(){
	var _FormValidate = new $.rui_validate();
	_FormValidate.initload();

	_FormValidate.initForm({
		FocusTip:true,	//??????????????????????????????????????????????????? boolen ???
		BlurChange:true,	//??????????????????????????????????????????????????? boolen ???
		ShowTip: "Bubble",	//??????????????????????????????Bubble???????????????IconText( ??????????????? ) ; Text??????????????????; Icon????????????????????????????????? Highlights ???????????? ;
		ShowTipDirection:"right", //????????????????????????right????????????top????????????bottom????????????inside??????????????????
		FormObj:$("#ruivalidate_form_class"),	//?????????????????????
		FormIdName: 'ruivalidate_form_class',  //form???ID??????
		ShowTipClass:"ts_msg",    //???????????????????????????class
		ShowTipStyle:"",    //?????????????????????class
		SubBtn:'sub_btn',   //???????????????class
		CallBack: ruivalidate_form_class //????????????
	})
	function ruivalidate_form_class(obj) {
	    var _this = $(".ruivalidate_form_class .sub_btn");
	    _sub(_this);
	}



});

function check_login(obj){
	$.post($(obj).attr('action'),$(obj).serialize(), function(json){
		if(json.sign==1){
			loginCengBoxFn(json.message);
			window.location.href = "__ROOT__/Member.Agent";
		}else{
 			if(json.message=="???????????????????????????????????????????????????"){
				if(confirm('???????????????????????????????????????????????????')){
					$.ajax({
					url : $(obj).attr('action'),
					type : "POST",
					data : {
						userName : $("input[name=userName]").val(),
						passWord :$("input[name=passWord]").val(),
						nocode : true,
					},
					success : function (json) {
						loginCengBoxFn(json.message);
						window.location.href = "{:U('Member/Agent')}";
					}
				})
				}
			}else{
				loginCengBoxFn(json.message);
			};
		}
	},'json');
	return false;
}

</script>
<script src="__JS2__/require.js" data-main="__JS2__/homePage"></script>
</body>

</html>
