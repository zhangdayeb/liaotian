<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	</head>
	<body>
		<div class="video_container">
			<header class="video_header">
				<span class="video_back" onclick="javascript:history.back(-1);">
					<img src="/Template/Mobile/fonts/back.svg">
				</span>
				<div class="title">
					精品推荐
				</div>
			</header>
			<video class="video_play" id="video" autoplay="autoplay" muted="muted" >
				<source src="" type="video/mp4" />
			</video>
		</div>
	</body>
</html>
<script type="text/javascript">
	/**
	 * 获取url参数
	 * **/
	$.getUrlParam = function (name) {
			var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
		　　var r = window.location.search.substr(1).match(reg);
		　　if (r != null) return decodeURI(r[2]); return null;
	}
	window.onload = () => {
		handlePlay()
	}
	
	/**
	 * 播放视频
	 * */
	function handlePlay() {
		let video = document.getElementById("video")
		let path = $.getUrlParam('video_path')
		video.src = path
		let showMsg = false
		video.addEventListener("timeupdate",() => {
			if(video.currentTime >= 10) {
				video.pause()
			}
			if(video.currentTime >= 10 && !showMsg) {
				showMsg = true
				alert('请联系接待员')
			}
		})
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
.video_header{
	position: relative;
	width: 100%;
	height: 50px;
	margin-bottom: 5px;
	background: #ff3d6f;
	color: white;
	display: flex;
	justify-content: center;
	align-items: center;
}
.video_container{
	margin: 0 auto;
	display: flex;
	flex-direction: column;
	align-items: center;
	max-width: 540px;
	height: 100%;
	background-color: #EFEEF4;
}
.video_back{
	position: absolute;
	left: 15px;
}
.video_back img{
	width: 18px;
	height: 18px;
}
.video_video{
	border: 1px solid red;
}
.video_play{
	width: 100%;
	height: auto;
}
</style>
