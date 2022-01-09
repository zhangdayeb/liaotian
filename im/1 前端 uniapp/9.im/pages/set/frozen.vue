<template>
	<view class="content">
		<view class="frozen-bg">
			<view class="frozen-card">
				<view class="uni-media-image">
					<image class="uni-media-loading" src="/static/theme/default/frone.png" />
				</view>
				<view class="frozen-head">&nbsp;&nbsp;</view>
				<view class="frozen-head">发现趣聊帐号被盗或手机丢失，你可以冻结相遇号</view>
				<view class="frozen-function">
					
						<text>防止坏人窃取你的个人隐私
						防止坏人冒用你的身份诈骗好友
						防止坏人盗刷你的支付资金
						</text>

					  
				
				</view>
			</view>
			<view class="frozen-btn">
				<button type="primary" :class="['landing', 'landing_true' ]" @tap="subLongin">开始冻结</button> 
				<!--  <view :class="['landing',checkIn ? 'landing_true' : 'landing_false']" @tap="subLongin">登 陆</view> -->
			</view>
		
	    </view>
    </view>
</template>

<script>
	
	export default {
		data() {
			return {
				showPassword: true,
				form: {
					username: '',
					password: '',
				}
			}
		},
		onLoad() {
			return;
		},
		computed: {
			checkIn(){
				return this.form.password != '' && this.form.username != '' && this.form.password.length > 5;
			}
		},
		methods: {
			changePassword() {
				this.showPassword = !this.showPassword;
			},
			delInputUsernameText(){
				this.form.username = ''
			},
			delInputPasswordText(){
				this.form.password = ''
			},
			subLongin(){
				let _this = this;
				if(!_this.checkIn){
					return;
				}
				_this.$httpSend({
					path: '/im/in/frozen',
					data: _this.form,
					success: (data) => {
						uni.setStorage({
							key: 'token',
							data: data.token,
							fail: () => {
								uni.showModal({
									content: '本地存储数据不可用!',
								});
							},
							success(){
								uni.reLaunch({
									url: '../chat/index',
								});
							},
						});
					}
				});
			},
			go_forget(){
				uni.navigateTo({
				    url: '../../pages/in/forget'
				})
			},
			go_register(){
				uni.navigateTo({
					url: '../../pages/in/reg'
				})
			}
			
		}
	}
</script>

<style>
	.uni-media-image{
		padding: 10upx 10upx;
		margin-top: 10upx;
		text-align: center;
	}
	.uni-media-loading {
		width:150upx;
		height:150upx;
	}
	.landing {
		height: 84upx;
		line-height: 84upx;
		color: #FFFFFF;
		font-size: 32upx;
		bordor: none;
		border-radius: 10upx;
	}
	.landing_true {
		
	}
	.landing_false {
		background-color: #d8d8d8;
	}
	.uni-button[type=primary] {
		background-color: #b2e281;
	}
	.frozen-btn{
		padding: 10upx 20upx;
		margin-top: 55upx;
		text-align: center;
	}
	.frozen-function{
		font-size: 26upx;

		margin-top:20upx;
		margin-bottom: 0upx;
		padding: 0upx 10upx;
		color: #999;
		text-align: center;
	}
	.frozen-forget{
		float: left;
		font-size: 26upx;
		color: #999;
	}
	.textspace {
		padding: 10upx 10upx;
	}
	.frozen-register{
		color: #666;
		float: right;
		font-size: 26upx;

	}
	.frozen-input input{
		background: #F2F5F6;
		font-size: 28upx;
		padding: 10upx 25upx;
		height: 62upx;
		line-height: 62upx;
		border-radius: 8upx;
	}
	.frozen-margin-b{
		margin-bottom: 25upx;
	}
	.frozen-input{
		padding: 20upx 20upx;
	}
	.frozen-head{
		font-size: 34upx;
		text-align: center;
		padding: 25upx 10upx 25upx 10upx;
	}
	.frozen-card{
		background: #fff;
		border-radius: 12upx;
		padding: 10upx 25upx;
		/* box-shadow: 0 6upx 18upx rgba(0,0,0,0.12); */
		position: relative;
		margin-top: 100upx;
	}
	.frozen-bg {
		/* height: 260upx;
		padding: 25upx;
		background: linear-gradient(#FF978D, #FFBB69); */
	}
	
	page {
		background-color: #FFFFFF;
	}
	
	.uni-form-item .with-fun .uni-icon {
		text-align: center;
	}
</style>
