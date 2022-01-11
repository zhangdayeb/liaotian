<template>
	
	<view>
		<view class="main">
			<avatar 
				selWidth="600upx" 
				selHeight="600upx" 
				@upload="upload"
				:avatarSrc="myPhoto"
				avatarStyle="width: 600upx; height: 600upx; border-radius: 15upx;">
			</avatar>
		</view>
	</view>
	
</template>
	
<script>
	import avatar from "../../components/yq-avatar/yq-avatar.vue";
	import _hook from '../../common/_hook';
	import _get from '../../common/_get';
	import _action from '../../common/_action';
	import _data from '../../common/_data';
	
	export default {
		
		components: {
			avatar,
		},
		data() {
			return {
				show_path: '',
				my_data: {},
			}
		},
		onShow(){
			_hook.routeSonHook();
			let _this = this;
			_this.my_data = _data.data('user_info');
			_this.show_path = _data.staticPhoto() + _this.my_data.photo;
			/** 监听新的个人数据 */
			uni.$on('data_user_info',function(data){
				_this.my_data = data;
			});
		},
		onLoad(option) {
			
		},
		onUnload(){
			uni.$off('data_user_info');
		},
		computed: {
			myPhoto(){
				return this.show_path.replace('70.jpg','300.jpg');
			}
		},
		methods: {
			upload(e){
				this.show_path = e.path;
				this.send();
			},
			send(){
				let _this = this;
				uni.showLoading();
				_this.$httpSendFile({
					local_url: _this.show_path,
					type: 1,
					success(data){
						/** 更新头像上传状态 */
						_this.$httpSend({
							path: '/im/action/upPhoto',
							success(data) {
								/** 更改头像后,更新下头像 */
								let user_info = _data.data('user_info');
								user_info.photo = user_info.photo.replace(/(\?_=)[\d\.]+$/,'$1' + Math.random());
								_data.data('user_info',user_info);
								uni.$emit('data_user_info',user_info);
								uni.hideLoading();
								
								uni.showToast({
									title: '更换成功',
									duration: 1000,
								});
								/** 重新缓存自己本地头像 */
								_action.downloadPhoto();
							}
						});
						_action.downloadPhoto();
					},
				});
			}
		},
		watch: {
			
		},
	}
	
</script>

<style>
	
	.main {
		text-align: center;
		padding-top: 70upx;
	}
	
</style>
