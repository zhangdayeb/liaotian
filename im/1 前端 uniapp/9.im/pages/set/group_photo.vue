<template>
	
	<view>
		<view class="main">
			<avatar 
				selWidth="600upx" 
				selHeight="600upx" 
				@upload="upload"
				:avatarSrc="show_path"
				avatarStyle="width: 600upx; height: 600upx; border-radius: 15upx;">
			</avatar>
		</view>
	</view>
	
</template>
	
<script>
	import avatar from "../../components/yq-avatar/yq-avatar.vue";
	import _hook from '../../common/_hook';
	import _get from '../../common/_get';
	import _data from '../../common/_data';
	
	export default {
		
		components: {
			avatar,
		},
		data() {
			return {
				show_path: '',
				list_id: 0,
			}
		},
		onShow(){
			let _this = this;
			_hook.routeSonHook();
			/** 更新头像上传状态 */
			_this.$httpSend({
				path: '/im/message/getGroupPhoto',
				data: {list_id: _this.list_id },
				success(data) {
					_this.show_path = _data.staticPhoto() + data;
				}
			});
		},
		computed: {
			
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
					data: { list_id: _this.list_id },
					type: 4,
					success(data){
						/** 更新头像上传状态 */
						_this.$httpSend({
							path: '/im/message/upGroupPhoto',
							data: { list_id: _this.list_id },
							success(data) {
								
								/** 更换群头像时,更新会话列表 */
								_get.getChatList();
								
								uni.hideLoading();
								uni.showToast({
									title: '更换成功',
									duration: 1000,
								});
							}
						});
					},
				});
			}
		},
		onLoad(option) {
			let _this = this;
			_this.list_id = option.list_id;

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
