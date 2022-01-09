<template>
	<view class="page">
		<view class="bode_main">
			<view class="uni-list my_padding">
					<view class="uni-list-cell">
						<view class="uni-media-list uni-list-cell-navigate">
							<view class="uni-media-list-logo photo">
								<image :src="myPhoto" :lazy-load="true"/>
							</view>
							<view class="uni-media-list-body">
								<view class="uni-media-list-text-top">{{my_data.nickname}}</view>
								<view class="uni-media-list-text-bottom uni-ellipsis">{{my_data.doodling}}</view>
							</view>
						</view>
					</view>
			</view>
			<!--:icon="qrPhoto"-->
			<view class="qrimg">
				<tki-qrcode
				ref="qrcode"
				:val="qrData"
				:onval="true"
				:size="500"
				unit="upx"
				background="#ffffff"
				foreground="#000000"
				pdground="#000000"
				:loadMake="true"
				:showLoading="true"
				loadingText="加载中..."
				@result="qrR" />
				<text class="text_font">扫一扫上面的二维码,加我为好友</text>
			</view>
			
		</view>
	</view>
</template>

<script>
	
	import uniList from '../../components/uni-list/uni-list.vue';
	import uniListItem from '../../components/uni-list-item/uni-list-item.vue';
	import _page from '../../common/common';
	import _hook from '../../common/_hook';
	import _data from '../../common/_data';
	import tkiQrcode from "../../components/tki-qrcode/tki-qrcode";
	
	export default {
		components: {
			uniList,
			uniListItem,
			tkiQrcode,
		},
		data() {
			return {
				my_data: { id: 0 },
				img_path: '',
			}
		},
		onShow(){
			_hook.routeTabBarHook();
			let _this = this;
			/** 监听新的个人数据 */
			uni.$on('data_user_info',function(data){
				_this.my_data = data;
			});
			_this.my_data = _data.data('user_info');
		},
		onLoad() {
			
		},
		onUnload(){
			uni.$off('data_user_info');
		},
		computed: {
			qrPhoto(){
				return _data.data('cache').local_photo;
			},
			myPhoto(){
				return _data.staticPhoto() + this.my_data.photo;
			},
			qrData(){
				let qr = _page.qrAction.chatAdd({user_id:this.my_data.id});
				return qr;
			},
		},
		methods: {
			qrR(ref){
				this.img_path = ref;
			},
		},
		watch: {
			
		},
	}
</script>

<style scoped>
	
	.qrimg {
		text-align: center;
		background: #FFFFFF;
		padding-bottom: 40upx;
	}
	
	.bode_main {
		margin: 150upx 35upx 0 35upx;
		width: 680upx;
		height: 800upx;
		border-radius: 50upx;
	}
	
	.photo {
		width: 110upx;
		height: 110upx;
		margin-left: 30upx;
		margin-right: 30upx;
	}
	
	.my_padding {
		padding-bottom: 20px;
	}
	
	.my_padding:before {
		background-color:white;
	}
	
	.my_padding:before {
		background-color:white;
	}	
	
	.my_padding:after {
		background-color:white;
	}
	
	.text_font {
		color: #8f8f94;
	}
	
</style>