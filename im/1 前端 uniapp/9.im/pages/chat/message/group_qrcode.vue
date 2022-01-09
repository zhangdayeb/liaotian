<template>
	<view class="page">
		<view class="bode_main">
			<view class="qrimg">
				<tki-qrcode
				ref="qrcode"
				:val="qrData"
				:onval="true"
				:size="500"
				:icon="group_photo"
				:iconSize="65"
				unit="upx"
				background="#ffffff"
				foreground="#000000"
				pdground="#000000"
				:loadMake="true"
				:showLoading="true"
				loadingText="加载中..."
				@result="qrR" />
				<view class="qrimg-info">
					<text class="text_font" @tap="saveQrcode">保存到相册</text>
				</view>
				<!-- <view class="hr"></view>
				<uni-list class="list">
					<uni-list-item class="list-item" title="分享邀请链接"  :showArrow="true"/>
				</uni-list> -->
			</view>
			
		</view>
	</view>
</template>

<script>
	
	import tkiQrcode from '../../../components/tki-qrcode/tki-qrcode.vue';
	import _data from '../../../common/_data';
	import _hook from '../../../common/_hook';
	import _page from '../../../common/common';

	export default {
		components: {
			tkiQrcode,
		},
		data() {
			return {
				list_id: '',
				my_data: { id: 0 },
				group_photo: '',
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
			this.group_photo = _data.data('cache')['group_photo_' + _this.list_id];
		},
		onLoad(option) {
			this.list_id = option.list_id;
		},
		onUnload(){
			uni.$off('data_user_info');
		},
		computed: {
			qrData(){
				return _page.qrAction.addGroup({user_id:this.my_data.id,list_id:this.list_id});
			},
		},
		methods: {
			qrR(ref){
				this.img_path = ref;
			},
			saveQrcode(){
				_page.saveImgToPhotos(this.img_path);
			}
		},
		watch: {
			
		},
	}
</script>

<style scoped>
	page{
		background-color: #ffffff;
	}
	.qrimg-info{
		padding: 20px 0 10px 0;
	}
	.text_font{
		font-size: 16px;
		color: #3d6db7;
	}
	.bode_main {
		margin: 150upx 0;
		border-radius: 50upx;
		text-align: center;
	}
	.hr{
		height: 18px;
		width: 100%;
		background-color: #e1e1e1;
	}
	.list-item{
		text-align: left;
		padding-left: 10px;
	}
</style>