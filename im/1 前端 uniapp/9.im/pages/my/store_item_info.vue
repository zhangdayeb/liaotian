<template>
	<view class="page">
		<view class="page-content-list">
			<view class="page-content-item" v-if="0">
				<view class="content-one">
					<image class="content-one-image" src="https://im.smiaoshen.com/static/circle/5f50a3e3135c8547e810f168/20200903/b38d8b55a43240d2822088e8cd40fb00_thumb.jpg"></image>
					<text></text>
				</view>
				<view class="content-two">
					<text>汪汪汪</text>
					<text>2020-09-28</text>
				</view>
			</view>
			<view class="footer-hr"></view>
			<view class="page-content-item"  v-if="0">
				<view class="content-one">
					<view class="voice">
						<view class="iconfont-im icon-yuyin-you yuyin"></view>
						<view class="length">10:00</view>
					</view>

				</view>
				<view class="content-two">
					<text>汪汪汪</text>
					<text>2020-09-28</text>
				</view>
			</view>

			<view class="page-content-item"  v-if="0">
				<view class="content-one">
					<view class="vedio">
						<image class="content-one-image" src="https://im.smiaoshen.com/static/circle/5f50a3e3135c8547e810f168/20200903/b38d8b55a43240d2822088e8cd40fb00_thumb.jpg"></image>
						<image class="bubble-bofang-left"
							   src="/static/theme/default/my/bofang.png"></image>
					</view>

				</view>
				<view class="content-two">
					<text>汪汪汪</text>
					<text>2020-09-28</text>
				</view>
			</view>

			<view class="page-content-item"  v-if="item.type == 1">
				<view class="content-one">
					<view class="text-info">
						<text>你好</text>
					</view>
				</view>
				<view class="content-two">
					<text>汪汪汪</text>
					<text>2020-09-28</text>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				item:{
					id:0,
					type:1, //1文字, 2图片 ,3语音, 4视频
					content:{
						text:"你好呀"
					},
				}
			}
		},
		onShow(){

		},
		onLoad(options){
			if('id' in options){
				this.item.id = options.id;
			}
		},
		methods: {

		}
	}
</script>

<style>
	.page{
		padding: 10px;
	}
	.page-content-list{
		display: flex;
		flex-direction: column;
		justify-content: space-between;
	}
	.page-content-item{
		display: flex;
		flex-direction: column;
		justify-content: space-between;
		padding: 8px;
	}
	.content-one{
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 10px 0;
	}

	.content-two{
		display: flex;
		justify-content:space-between;
		align-items: center;
	}
	.page-header-info{
		display: flex;
	}
	.page-header-info  image{
		width: 50px;
		height: 50px;
	}
	.voice{
		display: flex;
		justify-content: flex-start;
		align-items: center;
		background-color: #4cb050;
		width: 80px;
		padding: 2px 10px;
		border-radius: 10px;
	}
	.length{
		margin-left: 4rpx
	}
	.vedio{
		position: relative;
	}
	.content-one-image{
		width: 80px;
		height: 100px;
	}
	.bubble-bofang-left {
		position: absolute;
		left: 25px;
		top: 35px;
		width: 30px;
		height: 30px;
	}

	.text-info{
		padding: 10px 0;
	}
	.footer-hr{
		height: 1upx;
		width: 90%;
		background-color: #e1e1e1;
		margin: 0 auto;
	}
</style>
