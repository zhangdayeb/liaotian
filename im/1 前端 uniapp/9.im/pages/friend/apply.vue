<template>
    <view>
        <view class="uni-title uni-common-pl">你需要发送验证申请,等对方通过</view>
        <view class="uni-textarea">
            <textarea auto-height v-model="content" />
        </view>
		<view class="send">
			<button class="mini-btn send_button" type="primary" size="mini" @tap="send">发送</button>
		</view>
    </view>
</template>

<script>
	
	import _get from '../../common/_get';
	import _hook from '../../common/_hook';
	
	export default {
		components:{
			
		},
		data() {
			return {
				user_id: '',
				is_type: 0,
				content: '',
			}
		},
		onShow(){
			_hook['routeSonHook']();
		},
		onLoad(option){
			let _this = this;
			_this.user_id = option.user_id;
			_this.is_type = option.is_type;
		},
		computed:{
			
		},
		methods:{
			send(){
				let _this = this;
				_this.$httpSend({
					path: '/im/action/friendAdd',
					data: { content: _this.content,user_id: _this.user_id, is_type: _this.is_type },
					success_action: true,
					success(res) {
						// 1是直接添加成功
						if(res.err == 1){
							_get.getFriendList();
							_get.getChatList();
						}
						uni.showToast({
							title: res.msg,
							duration: 2000
						});
						setTimeout(() => {
							uni.reLaunch({
								url: './index'
							});
						},2000);
					}
				});
			}
		},
		watch:{
			
		}
	}
</script>

<style>
	
	.send {
		width: 100%;
		text-align: right;
	}
	.send_button {
		margin-right: 20upx;
		background-color: #1AAD19 !important;
		margin-top: 30upx;
	}

</style>