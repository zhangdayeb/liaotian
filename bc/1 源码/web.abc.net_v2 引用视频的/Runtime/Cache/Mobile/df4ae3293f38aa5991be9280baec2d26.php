<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
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
			<div style="height:35vh" >
				<video class="video_play" id="video" autoplay="autoplay" muted="muted" >
					<source src="" type="video/mp4" />
				</video>
			</div>
			
			<div class="video_ti">
				<img src='/Template/Mobile/images/1.png' height="26px"  />
				<div>
					推荐视频
				</div>
				
			</div>
			<div class="video_list" id="video_list">
				
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">
	 
	$.getUrlParam = function (name) {
			var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
		　　var r = window.location.search.substr(1).match(reg);
		　　if (r != null) return decodeURI(r[2]); return null;
	}
	window.onload = () => {
		handlePlay()
	}
	
	 
	function handlePlay() {
	 
		let videoId = $.getUrlParam('video_id')
	 
		$.post('https://video.qlkc998.vip/api/home/videoDetail', {id: videoId}, (data) => {
			let res = JSON.parse(data)
			let resData = res.data
			playVideo(resData.model.video_path)
		 
		 
			 
				 
			 
			 
					 
					 
				 
		 
			if(resData.lists.length < 1) {
				return
			}
			resData.lists.forEach(el => {
				let html = `
					<div class="video_img" > 
						<img class="video_view" src="${el.image}" />
						<img class="video_btn" src="/Template/Mobile/images/3.png" onclick="topage('${el.id}')" />
						
					</div>
					<div class="video_text" title="${el.name}">${el.name}</div>
				`
				$('#video_list').append(html)
			})
		})
	}
	
	function topage(videoId) {
		console.log('videoId:',videoId)
		window,location.href = '/Index.video.do?video_id=' + videoId;
	}
	
	function playVideo(path) {
		let showMsg = false
		let video = document.getElementById("video")
		video.src = path
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
}
.video_play{
	height: 35vh;
}

.video_list{
	display: flex;
	flex-direction: column;
    align-items: center;
    justify-content: center;
}
.video_img{
    padding: 5px 8px;
	position: relative;
}
.video_view{
	width: 90vw;
    height: 185px;
}
.video_ti{
	width: 100%;
    padding-left: 8px;
    display: flex;
    font-size: 20px;
    font-weight: bold;
    justify-content: start;
    margin-top: 20px;
}
.video_btn{
	position: absolute;
    width: 33px;
    top: calc(50% - 20px);
    left: calc(50% - 20px);
}

.video_text{
	white-space: nowrap;
    width: 85vw;
    overflow: hidden;
    text-overflow: ellipsis;
    text-align: center;
}
</style>