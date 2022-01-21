<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>午夜约吧</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="/Template/Mobile/css/common2.css" as="style" onload="this.rel='stylesheet'">
    <link rel="apple-touch-icon-precomposed" href="/Template/Mobile/images/icon.jpg">
    <link rel="apple-touch-startup-image" href="/Template/Mobile/images/strat.jpg">
    <link rel="stylesheet" href="/Template/Mobile/css/icon.css" as="style" onload="this.rel='stylesheet'">
    <link rel="stylesheet" href="/Template/Mobile/css/amazeui.min.css" as="style" onload="this.rel='stylesheet'">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="chat_container">
    <div id="containt">
        <!-- 选择 -->
        <nav class="choose" id="choose">
            <div class="addrs" id="chat_nav1" onclick="setChatNav('chat_nav1')" ><a class="chat_nav_a" href="#/city"><span class="choose-span">城市大全</span></a></div>
            <div class="addrs" id="chat_nav2" onclick="setChatNav('chat_nav2')"><a class="chat_nav_a" href="#/price" ><span class="choose-span">流程价格</span></a></div>
        </nav>

        <div class="container" id="container">
            <div class="city" id="city">
                <li class="city-li"><a href="#/mm/beijin" onclick="handleShowPhotos('beijing')">北京</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('shanghai')">上海</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('guangzhou')">广州</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('shenzhen')">深圳</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('chengdu')">成都</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('hangzhou')">杭州</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('wuhan')">武汉</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('tianjin')">天津</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('nanjing')">南京</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('chongqing')">重庆</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('xian')">西安</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('changsha')">长沙</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('qingdao')">青岛</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('shenyang')">沈阳</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('dalian')">大连</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('xiamen')">厦门</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('suzhou')">苏州</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('ningbo')">宁波</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('wuxi')">无锡</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('fuzhou')">福州</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('hefei')">合肥</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('zhenzhou')">郑州</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('haerbing')">哈尔滨</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('jinan')">济南</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('dongguan')">东莞</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('kunming')">昆明</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('taiyuan')">太原</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('nanchang')">南昌</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('wenzhou')">温州</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('shijiazhuang')">石家庄</a></li>
                <!-- <li class="city-li"><a href="#" onclick="handleShowPhotos('changchun')">长春</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('quanzhou')">泉州</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('guiyang')">贵阳</a></li>
                <li class="city-li"><a href="#" onclick="handleShowPhotos('changzhou')">常州</a></li> -->
                <!-- <li class="city-li"><a href="#">珠海</a></li>
                <li class="city-li"><a href="#">海口</a></li>
                <li class="city-li"><a href="#">乌鲁木齐</a></li>
                <li class="city-li"><a href="#">徐州</a></li>
                <li class="city-li"><a href="#">嘉兴</a></li>
                <li class="city-li"><a href="#">洛阳</a></li>
                <li class="city-li"><a href="#">南通</a></li>
                <li class="city-li"><a href="#">扬州</a></li>
                <li class="city-li"><a href="#">兰州</a></li>
                <li class="city-li"><a href="#">桂林</a></li>
                <li class="city-li"><a href="#">呼和浩特</a></li>
                <li class="city-li"><a href="#">绍兴</a></li>
                <li class="city-li"><a href="#">台州</a></li>
                <li class="city-li"><a href="#">义乌</a></li>
                <li class="city-li"><a href="#">银川</a></li>
                <li class="city-li"><a href="#">西宁</a></li> -->

                <li class="city-li" onclick="handleMore()"><a href="#/price" class=" more">解锁更多</a></li>
            </div>

            <div class="price " id="price">
                <div class="back">
                    <div class="price-ques">
                        <p class="question">有哪些资源?</p>
                        <p class="desc">网红、模特、空姐、嫩模、大学生，只有您想不到，没有本平台办不到</p>
                    </div>
                    <div class="price-ques">
                        <p class="question">服务范围?</p>
                        <p class="desc">同城免费约炮，任意地点全国空降，国内一二线城市当地均有，三线城市也可通过联系接待员预约安排。</p>
                        <p class="desc">注：本平台全网最真实空降约炮，为保证每个用户的个人隐私，入会仅限通过联系接待员或有过约炮成功人员实名推荐才可加入。</p>
                    </div>
                    <div class="price-ques">
                        <p class="question">解锁更多城市，请联系接待员即可?</p>
                    </div>
                </div>
            </div>

            <div id="showPhotos" class="chat-photo">

            </div>
        </div>
    </div>
</div>
<div data-am-widget="navbar" class="am-navbar am-cf am-navbar-default bottom_navbar am-no-layout">
    <ul class="am-navbar-nav am-cf am-avg-sm-5 my_nav_b" style="overflow: visible;background-color: F##">
        <li style="position: relative;">
            <!--            <a href="/" class="bottom_navbar_list">-->
            <a href="/Index.index.do" class="bottom_navbar_list mynav1">
                <i class="iconfont icon-shouyeshouye1" style="color:#07b39e" style="height: 30px;"></i>
                <span class="am-navbar-label">首页</span>
            </a>
        </li>

        <li style="position: relative;">
            <!--            <a href="/" class="bottom_navbar_list">-->
            <a href="/Other.xuanmei.do" class="bottom_navbar_list mynav4">
                <i class="iconfont icon-lipin"  style="color:#07b39e" style="height: 30px;"></i>
                <span class="am-navbar-label">选美</span>
            </a>
        </li>

        <li style="position: relative;">
            <a href="/Index.lotteryHall.do" class="bottom_navbar_list mynav3">
                <i class="iconfont icon-jinbei" style="color:#07b39e"></i>
                <span class="am-navbar-label">活动</span>
            </a>
        </li>
        <li style="position: relative;">
            <a href="/Member.index.do" class="bottom_navbar_list mynav5">
                <i class="iconfont icon-wode" style="color:#07b39e" ></i>
                <span class="am-navbar-label">我的</span>
            </a>
        </li>
    </ul>
</div>
</body>
</html>
<script type="text/javascript">
    let url = 'https://www.super1996.vip/Apijiekou.xuanmeiData'
    let city = ''
    window.onload = function() {
        $("#city").hide()
        $("#price").hide()
        getPhotosByCity()
    }

    /**
     * 通过城市查询照片
     * **/
    function getPhotosByCity() {
        $.get(`${url}?key=${city}`, (res) => {
            let result = JSON.parse(res)
            let potos = []
            if(result.length > 0) {
                result.forEach(element => {
                    element.image_link = `https://www.super1996.vip${element.image_link}`
                    potos.push(element)
                });
            }
            handleHtmlPhotos(potos)
        })
    }

    /**
     * 展示图片
     * @param potoList 照片集合
     * **/
    function handleHtmlPhotos(potoList) {
        let htmlStr = ''
        potoList.forEach(poto => {
            htmlStr += `
				<div class="chat-photo-box">
					<div class="chat-photo-title">${poto.name}</div>
					<div>
						<img class="chat-photo-img" src="${poto.image_link}" alt="" srcset="">
					</div>
				</div>
			`
        })
        console.log("htmlStr:",htmlStr)
        $("#showPhotos").html(htmlStr)
    }

    /**
     * 导航选择
     * @param id 元素id
     * **/
    function setChatNav(id) {
        for(var i=1; i < 3; i++) {
            $(`#chat_nav${i}`).removeClass("chat_active")
        }
        $(`#${id}`).addClass("chat_active")
        switch(id) {
            case 'chat_nav1':
                $("#city").show()
                $("#price").hide()
                $("#showPhotos").hide()
                break;
            case 'chat_nav2':
                $("#price").show()
                $("#city").hide()
                $("#showPhotos").hide()
                break;
        }
    }

    /**
     * 显示每个地区的照片
     * @param cityName 城市名
     * **/
    function handleShowPhotos(cityName) {
        city = cityName
        $("#city").hide()
        $("#showPhotos").show()
        getPhotosByCity()
    }

    /**
     * 解锁更多
     */
    function handleMore() {
        setChatNav('chat_nav2')
    }
</script>
<style type="text/css">
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    html,body{
        width: 100%;
        height: 100%;
    }
    a {
        list-style: none;
        text-decoration: none;
        color: #000000;
    }
    li {
        list-style: none;
    }
    .chat_container{
        max-width: 550px;
        height: 100%;
        margin: 0 auto;
    }
    .chat_nav_a{
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
    }
    .active {
        border-bottom: 2px solid #0000FF;
        color: blueviolet;
    }
    .hidden{
        display: none;
    }
    .pass {
        margin: 10px auto;
        width: 510px;
        height: 120px;
        background-color: #7e5678;
        border-radius: 10px;
    }
    #containt {
        height: 100%;
    }
    .pass-span {
        margin-top: 20px;
        display: inline-block;
        padding-left: 15px;
        padding-right: 15px;
        color: #fff;
        font-size: 18px;
    }
    .choose {
        display: flex;
        height: 47px;
    }
    .addrs {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        border-bottom: 2px solid white;
    }
    .chat_active{
        border-bottom: 2px solid #7e5678;
    }

    .container {
        height: calc(100% - 47px);
        overflow: auto;
        background: #f2f2f5;
    }
    .chat-photo{
        padding: 0 10px 60px 10px;
    }

    .chat-photo-title{
        font-size: 18px;
        text-align: center;
        color: #000;
        height: 50px;
        justify-content: center;
        align-items: center;
        display: flex;
        font-family: Helvetica Neue,Helvetica,PingFang SC,Hiragino Sans GB,Microsoft YaHei,Arial,sans-serif;
    }

    .choose-span {
        text-align: center;
        color: #000;
        font-size: 14px;
        font-weight: 700;
    }
    .chat-photo-img{
        width: 100%;
        height: auto;
    }
    /* .addrs:hover {
        border-bottom: 2px solid blueviolet;
    } */

    .box {
        margin-top: 20px;
        margin-left: 20px;
        width: 90%;
        height: 120px;
        /* border: 1px solid red; */
        display: flex;
    }

    .pic {
        margin: 0 1px;
        flex: 1;
        margin-top: 10px;
        height: 100px;
        /* border: 1px solid aqua; */
    }

    .mm {
        margin-left: 24px;
        border: 2px solid #bbb;
    }

    .city {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        flex-wrap: wrap;
    }

    .city-li {
        width: 25%;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-weight: 400;
        color: #000;
    }

    .more {
        color: #7e5678;
        text-decoration: underline;
    }

    .back {
        height: 600px;
        background: #f2f2f5;
    }

    .price {
        width: 100%;
        height: 100%;
        border: 1px solid #F2F2F5;
    }

    .price-ques {
        margin-top: 10px;
        height: auto;
    }

    .question {
        margin-top: 15px;
        margin-left: 20px;
        color: #ff0000;
        font-weight: 700;
        font-size: 18px;

    }

    .desc {
        margin-top: 15px;
        padding-right: 10px;
        margin-left: 20px;
        font-size: 14px;
    }
    .pic{
        width: 100%;
        height: 100%;
    }
    .title{
        margin-top: 10px;
        text-align: center;
        font-size: 20px;
        font-weight: 700;
    }
    .mm-pic{
        margin:20px 0;
        width: 512px;
        height: 624px;
        border: 1px solid;
    }
    .mm-pic img{
        width: 512px;
        height: 624px;

    }
    .page{
        width: 100%;
        height: 160px;
        /* border: 1px solid red; */
    }
    .page-p{
        margin-top: 10px;
        margin-left: 20px;
        height:44px;
        font-size: 20px;
        font-weight: 700;
        color: #000;
    }
    .am-with-fixed-navbar {
        padding-bottom: 84px;
    }
    .bottom_navbar {
        height: 0.53rem;
    }
    .active {
        color: #fe3e6f;


        padding-bottom: 5px;
        border-bottom: 0px solid #fe3e6f;
    }
    .bottom_navbar .active {
        color: #fe3e6f;
    }
    .bottom_navbar .am-navbar-nav {
        background: white;
        color: #838793;
        box-shadow: 0 0 1px #FFFFFF;
    }
    .am-navbar-label {
        margin-top: 0px;
        line-height: 0;
    }
    .am-navbar {
        padding-bottom: 45px;
        line-height: 40px;
    }
</style>
