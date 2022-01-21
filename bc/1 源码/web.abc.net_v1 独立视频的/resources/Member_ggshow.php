<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>{:GetVar('webtitle')}</title>
    <meta name="keywords" content="关键字">
    <meta name="description" content="网站主要内容">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" >

    <link rel="stylesheet" href="__CSS2__/bootstrap.min.css">
    <link rel="stylesheet" href="__CSS2__/reset.css">
    <link rel="stylesheet" href="__CSS2__/icon.css">
    <link rel="stylesheet" href="__CSS2__/header.css">
    <link rel="stylesheet" href="__CSS2__/bankCard.css">
    <link rel="stylesheet" href="__CSS2__/userInfo.css">
    <link rel="stylesheet" href="__CSS2__/footer.css">
    <link rel="stylesheet" href="__JS2__/layer/skin/default/layer.css">
    <link rel="stylesheet" href="//at.alicdn.com/t/font_i3jm0mkwlui8uxr.css">
    
</head>
<body>
<include file="Public/header" />
<script src="__JS2__/require.js" data-main="__JS2__/homePage"></script>
<div class="vip_info clearfix container">
    <include file="Member/side" />
    <div class="pull-right vip_info_pan">
        <div class="vip_info_title">
            网站公告
        </div>
        <div class="vip_info_content help_right_content ">
            <h4 class="text-center red">{$ggshow.title}</h4>
            <p class="text-center">{$ggshow.oddtime|date="Y-m-d",###}</p>
            <div class="bankcard_item_box clearfix"  style="margin:20px 10px;">
                {$ggshow.content}
            </div>
        </div>
    </div>
</div>
<include file="Public/footer" />
<!--<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">温馨提示</h4>
            </div>
            <div class="modal-body">
                您还未设置资金密码，请先设置资金密码?
                <div>（资金密码用于提现等操作，可保障资金安全）</div>
            </div>
            <div class="modal-footer">
                <a href="setSecurity.html" class="btn btn-default login_btn">确认</a>
                <a href="" class="btn btn-default register_btn">取消</a>
            </div>
        </div>
    </div>
</div>-->
</body>
</html>