<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo GetVar('webtitle');?></title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="full-screen" content="yes">
    <meta name="x5-fullscreen" content="true">
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-orientation" content="portrait">
    <meta name="viewport" content="width=device-width, initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=none">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="apple-touch-icon-precomposed" href="/Template/Mobile/images/icon.jpg">
    <link rel="apple-touch-startup-image" href="/Template/Mobile/images/strat.jpg" />


    <link rel="stylesheet" href="/Template/Mobile/css/amazeui.min.css?v=20180826">
    <link rel="stylesheet" href="/Template/Mobile/css/common2.css?v=20180826">
    <link rel="stylesheet" href="/Template/Mobile/css/index.css?v=20180826">
    <link rel="stylesheet" href="/Template/Mobile/css/icon.css?v=20180826">
    <link rel="stylesheet" href="/resources/css/artDialog.css?v=20180826">
    <script>
        var Webconfigs = {
            "ROOT" : ""
        }
    </script>
    
    
</head>
<script src="/Template/Mobile/js/jquery-3.1.1.min.js"></script> 
<script type="text/javascript" src="/resources/js/artDialog.js?v=20180826"></script>
<script type="text/javascript" src="/resources/js/way.min.js?v=20180826"></script>
<script type="text/javascript" src="/resources/main/common.js?v=20180826"></script>
<script src="/Template/Mobile/js/require.js?v=20180826" data-main="/Template/Mobile/js/main"></script>

<link rel="stylesheet" href="/Template/Mobile/css/userHome.css">
<body>
<header data-am-widget="header" class="am-header am-header-default header nav_bg am-header-fixed">
  <div class="am-header-left am-header-nav">
    <a href="javascript:history.back(-1);" class="">
      <i class="iconfont icon-arrow-left"></i>
    </a>
  </div>
  
  <h1 class="am-header-title userHome_h1" style="margin: 0 auto; width: 100%;">用户登录</h1>
  
</header>

<div class="bank_recharge">
  <form method="post" class="ruivalidate_form_class" id="form1" checkby_ruivalidate
        url="" action="<?php echo U('Public/logindo');?>">
    <ul class="bank_form_list">
      <li class="am-cf">
        <span class="bank_form_left am-fl">账　号</span>
        <div class="am-fr bank_right_input">
          <input type="text" class="input_txt" name="name" placeholder="请输入账号">
        </div>
      </li>
      <li class="am-cf">
        <span class="bank_form_left am-fl">密　码</span>
        <div class="am-fr bank_right_input">
          <input type="password" name="pass" class="input_txt" placeholder="请输入密码">
        </div>
      </li>
      <!--            <li class="am-cf" style="position:relative;">
                      <span class="bank_form_left am-fl">验证码</span>
                      <div class="am-fr bank_right_input">
                          <input type="text" name="code" class="input_txt"　style="width:20%;" placeholder="请输入验证码">
                      </div>
                      <span style="position:absolute;right:0;font-size:0.18rem;top:0;"><img style="height:0.20rem;width:1.0rem;" src="<?php echo U('Public/verify',array('imageW'=>110,'imageH'=>30));?>"  onclick="this.src=this.src+'?temp='+ 1" /></span>
                  </li>-->
    </ul>
    <p class="bank_pass"><a href="<?php echo U('Public/forgetPaw');?>">忘记密码?</a></p>
    
    <button id="btn_login" style="margin-top:0.1rem;margin-bottom: 0px;"
            class="am-btn am-btn-danger am-radius am-btn-block" type="button">立即登录
    </button>
    
    <p class="bank_pass " style="text-align: center;"><a href="<?php echo U('Public/register');?>">立即注册</a></p>
  </form>
</div>
<!--include file="Public/footer" /-->
<script>
  function check_login(obj) {
    $.ajax({
      url: "<?php echo U('Public/LoginDo');?>",
      type: 'POST',
      data: $("#form1").serialize(),
      success: function (data) {
        if (data.sign == true) {
            console.log(data);
          alert(data.message);
          window.location.href = "<?php echo U('Member/index');?>"
        } else {
          if (data.message == "你的帐号已在别处登陆，是否重新登陆") {
            if (confirm('你的帐号已在别处登陆，是否重新登陆')) {
              $.ajax({
                url: "<?php echo U('Public/LoginDo');?>",
                type: "POST",
                data: {
                  name: $("input[name=name]").val(),
                  pass: $("input[name=pass]").val(),
                  nocode: true,
                },
                success: function (json) {
                    alert(data.message);
                  window.location.href = "<?php echo U('Member.index');?>";
                }
              })
            }
          } else {
            alert(data.message);
          }
        }
      }
    })
    return false;
  }

  $(function () {
    $('#btn_login').on('click', function () {
      check_login(this);
    })
  });
</script>
</body>
</html>