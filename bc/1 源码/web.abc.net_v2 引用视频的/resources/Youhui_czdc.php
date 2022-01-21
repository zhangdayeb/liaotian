<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{:GetVar('webtitle')}</title>
    <meta name="keywords" content="{:GetVar('keywords')}" />
    <meta name="description" content="{:GetVar('description')}" />
<meta name="renderer" content="webkit" />
<link rel="stylesheet" type="text/css" href="__ROOT__/resources/css/reset.css" />
<link rel="stylesheet" type="text/css" href="__ROOT__/resources/css/layout.css" />
<link rel="stylesheet" type="text/css" href="__ROOT__/resources/css/artDialog.css" />
<link rel="stylesheet" type="text/css" href="__ROOT__/resources/css/font-awesome.min.css" />
<script type="text/javascript" src="__ROOT__/resources/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="__ROOT__/resources/js/artDialog.js"></script>
<!--[if lt IE 9]>
<script src="__ROOT__/resources/js/html5shiv.js"></script>
<![endif]-->
<script type="text/javascript" src="__ROOT__/resources/js/way.min.js"></script>
<script type="text/javascript" src="__ROOT__/resources/js/jquery.history.js"></script>
<script type="text/javascript" src="__ROOT__/resources/main/common.js"></script>

</head>

<body>

{include file="Public/header" /}
    <!--wapper-->
    <div class="active1 active2">
        <div class="hight"></div>
        <div class="give_mo">
            <div class="move">
                <div class="open">
                    <!--今日最大充值金额-->
                     <!--今日最大充值金额-->
             <p class="title">单次充值赠送活动</p>       
            <div class="youhuilist">
            <?php
			$newmemberrecharge1 = GetVar('activity_cz0_money');
			$newmemberrechargeamount1 = GetVar('activity_cz0_zsmoney');
			$newmemberrecharge2 = GetVar('activity_cz1_money');
			$newmemberrechargeamount2 = GetVar('activity_cz1_zsmoney');
			$newmemberrecharge3 = GetVar('activity_cz2_money');
			$newmemberrechargeamount3 = GetVar('activity_cz2_zsmoney');
			$newmemberrecharge4 = GetVar('activity_cz3_money');
			$newmemberrechargeamount4 = GetVar('activity_cz3_zsmoney');
			$newmemberrecharge5 = GetVar('activity_cz4_money');
			$newmemberrechargeamount5 = GetVar('activity_cz4_zsmoney');
			?>
            {if condition="$newmemberrecharge1 and $newmemberrechargeamount1"}
            <dl>
                <dt>
                <p>单次充值{:substr($newmemberrecharge1,0,strpos($newmemberrecharge1,'~'))}元或以上领取充值金额{$newmemberrechargeamount1}%</p>
                </dt>
            </dl>
            {/if}
            {if condition="$newmemberrecharge2 and $newmemberrechargeamount2"}
            <dl>
                <dt>
                <p>单次充值{:substr($newmemberrecharge2,0,strpos($newmemberrecharge2,'~'))}元或以上领取充值金额{$newmemberrechargeamount2}%</p>
                </dt>
            </dl>
            {/if}
            {if condition="$newmemberrecharge3 and $newmemberrechargeamount3"}
            <dl>
                <dt>
                <p>单次充值{:substr($newmemberrecharge3,0,strpos($newmemberrecharge3,'~'))}元或以上领取充值金额{$newmemberrechargeamount3}%</p>
                </dt>
            </dl>
            {/if}
            {if condition="$newmemberrecharge4 and $newmemberrechargeamount4"}
            <dl>
                <dt>
                <p>单次充值{:substr($newmemberrecharge4,0,strpos($newmemberrecharge4,'~'))}元或以上领取充值金额{$newmemberrechargeamount4}%</p>
                </dt>
            </dl>
            {/if}
            {if condition="$newmemberrecharge5 and $newmemberrechargeamount5"}
            <dl>
                <dt>
                <p>单次充值{:substr($newmemberrecharge5,0,strpos($newmemberrecharge5,'~'))}元或以上领取充值金额{$newmemberrechargeamount5}%</p>
                </dt>
            </dl>
            {/if}
                    
            </div>
            <div class="warm2">
                <span>活动规则：</span>
                
                {if condition="$newmemberrecharge1 and $newmemberrechargeamount1"}
                <p>单次充值{:substr($newmemberrecharge1,0,strpos($newmemberrecharge1,'~'))}元或以上领取充值金额{$newmemberrechargeamount1}%</p>
                {/if}
                
                {if condition="$newmemberrecharge2 and $newmemberrechargeamount2"}
                <p>单次充值{:substr($newmemberrecharge2,0,strpos($newmemberrecharge2,'~'))}元或以上领取充值金额{$newmemberrechargeamount2}%</p>
                {/if}
                
                {if condition="$newmemberrecharge3 and $newmemberrechargeamount3"}
                <p>单次充值{:substr($newmemberrecharge3,0,strpos($newmemberrecharge3,'~'))}元或以上领取充值金额{$newmemberrechargeamount3}%</p>
                {/if}
                
                {if condition="$newmemberrecharge4 and $newmemberrechargeamount4"}
                <p>单次充值{:substr($newmemberrecharge4,0,strpos($newmemberrecharge4,'~'))}元或以上领取充值金额{$newmemberrechargeamount4}%</p>
                {/if}
                
                {if condition="$newmemberrecharge5 and $newmemberrechargeamount5"}
                <p>单次充值{:substr($newmemberrecharge5,0,strpos($newmemberrecharge5,'~'))}元或以上领取充值金额{$newmemberrechargeamount5}%</p>
                {/if}
                <p>单次充值赠送活动充值金额不累计</p>
                    
            </div>
                    
                    
                </div>
            </div>
        </div>
    </div>

{include file="Public/footer" /}
</body>
</html>