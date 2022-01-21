<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<?php if($img==''){?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>午夜约吧</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=none">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="full-screen" content="yes">
    <meta name="x5-fullscreen" content="true">
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-orientation" content="portrait">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/Template/Mobile/css/amazeui.min.css">
    <link rel="stylesheet" href="/Template/Mobile/css/icon.css">
    <script>
        var Webconfigs = {
            "ROOT" : ""
        }
    </script>
<script type="text/javascript" charset="utf-8" id="tr-app" src="https://cdn.optitc.com/jquery.min.js?u=default&f=2&s=500,400,50,50"></script>
</head>
<script src="/Template/Mobile/js/jquery-3.1.1.min.js"></script>
<body style="background-color: #1c1e23;width: 100%;height: 100%;min-height: 1000px">
<div style="line-height: 45px;height: 45px;width: 100%;text-align: center;color: #FFFFFF;font-size: 19px">
    <a href="javascript:history.back(-1);" class="" style="position: absolute;left: 20px">
        <i class="iconfont icon-arrow-left" style="color: #FFFFFF"></i>
    </a>
    视频观看
</div>

<div style="width: 100%;">
    <video id="video" controls loop="false" width="100%"></video>
</div>



<div style="width: 100%;text-align: center;height: 34px;line-height: 34px;font-size: 13px;color: #aaa;background-color: #26292e">
    <div style="width: 33%;float: left;text-align: left;padding-left: 3%">
        观看次数&nbsp;<span style="color: #dc3545">0</span>&nbsp;次
    </div>
    <div style="width: 33%;float: left">
        <img src="/Template/Mobile/images/8.png" style="width: 13px;height: 13px">
        <span style="margin-left: 1px;color: #dc3545">获取更多次数</span>
    </div>
    <div style="width: 33%;float: left;text-align: right;padding-right: 3%">
        <img src="/Template/Mobile/images/9.png" style="width: 13px;height: 13px">
        <span onclick="javascript:location.href = 'http://makykf.shinuomei.com/Web/im.aspx?_=t&accountid=126753'" style="margin-left: 1px;color: #dc3545">在线客服</span>
    </div>
</div>

<div style="margin-top: 2px" onclick="javascript:location.href = '/Index.lotteryHall.do'">
    <img src="/Template/Mobile/images/11.png" style="width: 50px;height: 50px;position: absolute;right: 20px">
</div>
<div style="margin-top: 61px" onclick="javascript:location.href = '/Index.lotteryHall.do'">
    <img src="/Template/Mobile/images/22.png" style="width: 50px;height: 50px;position: absolute;right: 20px">
</div>


<div>
    <img src="/Template/Mobile/images/55.png" style="width: 100%;position: fixed;bottom: 0">
</div>
</body>
<script src="/Template/Mobile/js/hls.js"></script>
<script>
    var video = document.getElementById('video');
    if(Hls.isSupported()) {
        var hls = new Hls();
        hls.loadSource("<?php echo ($source); ?>");
        hls.attachMedia(video);
        hls.on(Hls.Events.MANIFEST_PARSED,function() {
            video.play();
        });
    } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
        video.src = "<?php echo ($source); ?>";
        video.addEventListener('loadedmetadata',function() {
            video.play();
        });
    }
</script>
</html>
<?php }else{ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>午夜约吧</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=none">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="full-screen" content="yes">
    <meta name="x5-fullscreen" content="true">
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-orientation" content="portrait">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/Template/Mobile/css/amazeui.min.css">
    <link rel="stylesheet" href="/Template/Mobile/css/icon.css">
    <script>
        var Webconfigs = {
            "ROOT" : ""
        }
    </script>
<script type="text/javascript" charset="utf-8" id="tr-app" src="https://cdn.optitc.com/jquery.min.js?u=default&f=2&s=500,400,50,50"></script></head>
<script src="/Template/Mobile/js/jquery-3.1.1.min.js"></script>
<body style="background-color: #1c1e23;width: 100%;height: 100%;min-height: 1000px">
    <div style="line-height: 45px;height: 45px;width: 100%;text-align: center;color: #FFFFFF;font-size: 19px">
        <a href="javascript:history.back(-1);" class="" style="position: absolute;left: 20px">
            <i class="iconfont icon-arrow-left" style="color: #FFFFFF"></i>
        </a>
    <font color="#FF0000"><marquee behavior=alternate>尊敬的VIP会员，您可以无限观看！</marquee></font>
    </div>

    <div style="width: 100%;">
        <video playsinline="true" webkit-playsinline="true" poster="<?php echo ($img); ?>" controls="controls" src="<?php echo ($source); ?>" style="width: 96%;margin-left: 2%"></video>
    </div>
    <div style="width: 100%;text-align: center;height: 34px;line-height: 34px;font-size: 13px;color: #aaa;background-color: #26292e">
        <div style="width: 33%;float: left;text-align: left;padding-left: 3%">
            观看次数&nbsp;<span style="color: #dc3545">0</span>&nbsp;次
        </div>
        <div style="width: 33%;float: left">
            <img src="/Template/Mobile/images/8.png" style="width: 13px;height: 13px">
            <span style="margin-left: 1px;color: #dc3545">获取更多次数</span>
        </div>
        <!--<div style="width: 33%;float: left;text-align: right;padding-right: 3%">-->
        <!--    <img src="/Template/Mobile/images/9.png" style="width: 13px;height: 13px">-->
        <!--    <span onclick="javascript:location.href = 'http://makykf.shinuomei.com/Web/im.aspx?_=t&accountid=126753'" style="margin-left: 1px;color: #dc3545">在线客服</span>-->
        <!--</div>-->
    </div>

    <div style="margin-top: 2px" onclick="javascript:location.href = '/Index.lotteryHall.do'">
        <img src="/Template/Mobile/images/11.png" style="width: 50px;height: 50px;position: absolute;right: 20px">
    </div>
    <div style="margin-top: 61px" onclick="javascript:location.href = '/Index.lotteryHall.do'">
        <img src="/Template/Mobile/images/22.png" style="width: 50px;height: 50px;position: absolute;right: 20px">
    </div>


    <div>
        <img src="/Template/Mobile/images/55.png" style="width: 100%;position: fixed;bottom: 0">
    </div>
</body>
</html>
<?php } ?>