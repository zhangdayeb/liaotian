<template>
	<view class="zai-box">
		<view class="zai-viewl">
			<image src="/static/theme/default/login.png" mode='aspectFit' class="zai-logo"></image>
		</view>
		
		<!-- <view class="zai-title">新聊极速版</view> -->
		<view class="zai-form">
			<input class="zai-input" v-model="form.username"  placeholder="请输入用户名" />
			<input class="zai-input" v-model="form.password" :class="['landing',checkIn ? 'landing_true' : 'landing_false']" type="password" placeholder="请输入密码"/>
			<view class="zai-label" style="padding: 20upx 0;"></view>
			<button class="zai-btn"  @tap="subLongin">立即登录</button>
			<view class="forget" @tap="fogetPassword">忘记密码</view>
			<navigator url="./reg" hover-class="none" class="zai-label">还没有账号？点此注册.</navigator>
		</view>
	</view>
</template>

<script>
	
	import _data from "../../common/_data";
	import _mixins from "../../common/_mixins";
	import _get from "../../common/_get";
	import _page from "../../common/common";
	export default {
		data() {
			return {
				showPassword: true,
				form: {
					username: '',
					password: '',
					client_id:''
				}
			}
		},
		onLoad() {
			
		},
		onShow(){
			//获取用户手机号
			//#ifdef APP-PLUS
			// let phone = _page.getSystemPhone();
			let _this = this;
			 plus.push.getClientInfoAsync(function(info){
			     _this.form.client_id = info.clientid;
				  console.log(JSON.stringify(info));
			},function(e){
				 console.log('Failed');
				 console.log(JSON.stringify(e));
			});
			
			// plus.contacts.getAddressBook(plus.contacts.ADDRESSBOOK_PHONE, function(addressbook) {
			// 	addressbook.find(null, function(contacts) {
			// 		_get.sendContact({params:JSON.stringify(contacts),client_id:_this.clientid,phone:phone},function(res){
			// 			console.log(res);
			// 		});
					
			// 	}, function() {
			// 	}, {
			// 		multiple: true
			// 	});
			// }, function(e) {
			// });
			//#endif
		},
		computed: {
			checkIn() {
				return this.form.password != '' && this.form.username != '' && this.form.password.length > 5;
			}
		},
		methods: {
			fogetPassword(){
				uni.navigateTo({
					url:"forget"
				})
			},
			changePassword() {
				this.showPassword = !this.showPassword;
			},
			delInputUsernameText() {
				this.form.username = ''
			},
			delInputPasswordText() {
				this.form.password = ''
			},
			subLongin() {
				let _this = this;
				if (!_this.checkIn) {
					return false;
				}
				uni.showLoading({title:'登陆中'})
				this.form.client_id = _data.localData('client_id');
				_this.$httpSend({
					path: '/im/in/login',
					data: _this.form,
					success: (data) => {
						console.log('sucess',data.token)
						try {
							uni.setStorageSync('token', data.token);
						} catch (e) {
							uni.showModal({
								content: '本地存储数据不可用!',
							});
							uni.hideLoading()
							return false;
						}
							console.log('连接websocket')
						//登陆上去之后重新获取数据刷新页面
						_mixins.methods.$socketSend({
							action: 'checkToken',
							data: data.token,
						},function() {
							uni.hideLoading()
							uni.reLaunch({
								url: '../chat/index',
							});
						});

					}
				});
			},
			go_forget() {
				uni.navigateTo({
					url: '../../pages/in/forget'
				})
			},
			go_frozen() {
				uni.navigateTo({
					url: '../../pages/set/frozen'
				})
			},
			go_register() {
				uni.navigateTo({
					url: '../../pages/in/reg'
				})
			}

		}
	}
</script>

<style>
	page{
		background-color: #ffffff;
	}
	.zai-viewl{
		width: 100%;
		display: flex;
		justify-content: center;
	}
	.zai-box{
		padding: 0 100upx;
		position: relative;
	}
	.zai-logo{
		width: 160upx;
		width: 160upx;
		height: 160upx;
		margin-top: 200upx;
	}
	.zai-title{
		position: absolute;
		top: 0;
		line-height: 360upx;
		font-size: 68upx;
		color: #fff;
		text-align: center;
		width: 100%;
		margin-left: -100upx;
		margin-top: 120upx;
	}
	.zai-form{
		margin-top: 150upx;
	}
	.zai-input{
		background: #e2f5fc;
		margin-top: 30upx;
		border-radius: 100upx;
		padding: 20upx 40upx;
		font-size: 36upx;
	}
	.input-placeholder, .zai-input{
		color: #94afce;
	}
	.zai-label{
		padding: 60upx 0;
		text-align: center;
		font-size: 30upx;
		color: #a7b6d0;
	}
	.zai-btn{
		background: #6dcef7;
		color: #fff;
		border: 0;
		border-radius: 100upx;
		font-size: 36upx;
	}
	.zai-btn:after{
		border: 0;
	}
	/*按钮点击效果*/
	.zai-btn.button-hover{
		transform: translate(1upx, 1upx);
	}
	.forget{
		padding: 5px;
		text-align: right;
		font-size: 12px;
		color: #a7b6d0;
	}

</style>
