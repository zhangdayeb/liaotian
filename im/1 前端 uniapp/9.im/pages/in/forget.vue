<template>
	<view class="zai-box">
		<view class="zai-viewl">
			<image src="/static/theme/default/login.png" mode='aspectFit' class="zai-logo"></image>
		</view>
		<view class="zai-form">
			<input class="zai-input"  v-model="form.username"  placeholder="请输入手机号" />
			<view class="form-code" >
				<input class="code-input"  v-model="form.sms_code"  placeholder="请输入验证码" />
				<button class="code" @tap="getCode" v-if="showText"> 获取验证码</button>
				<button class="code" v-else>{{second}}重新发送</button>
			</view>

			<!-- <input class="zai-input" placeholder-class password placeholder="请输入密码"/> -->
			<input class="zai-input"  v-model="form.password"  type="password" placeholder="请输入密码"/>
			<button :class="['landing',checkIn ? 'landing_true' : 'landing_false']"
					:disabled="checkIn ? false : true" class="zai-btn" @tap="subForge">确认</button>
			<navigator url="./login" open-type='navigateBack' hover-class="none" class="zai-label">已有账号，点此去登录.</navigator>
		</view>
		<view class="zai-footer" @tap="goPath">《使用条款和隐私政策》</view>
		<uni-popup ref="popup" type="confirm">
			<uni-popup-confirm title="温馨提示" :beforeClose="true" @close="close" :content="popuMsg" @confirm = "confirm"> </uni-popup-confirm>
		</uni-popup>
	</view>
</template>

<script>
	import uniPopup from '../../components/uni-popup/uni-popup.vue';
	import uniPopupConfirm from '../../components/uni-popup/uni-popup-confirm.vue';
	import _get from "../../common/_get";
	export default {
		data () {
			return {
				miaoqiang:'',
				popuMsg:'恭喜您注册成功,是否立即更改资料?',
				showPassword: true,
				showText:true,
				second:60,
				form: {
					mobileCode:1,
					username: '',
					password: '',
					client_id:'',
					sms_code:'',
					type:'FORGET_PASSWORD',
				}
			}
		},
		components:{
			uniPopup,
			uniPopupConfirm
		},
		onLoad () {

		},
		onShow(){
			console.log(this.form.mobileCode);
			let _this = this;
			// #ifdef APP-PLUS
			plus.push.getClientInfoAsync(function(info){
				_this.form.client_id = info.clientid;
			},function(e){
			});
			// #endif
		},
		computed: {
			checkIn () {
				return this.form.password != '' && this.form.username != '' && this.form.password.length > 5 && this.form.username.length > 5;
			}
		},
		methods: {
			goPath(){
				uni.navigateTo({'url':'/pages/in/web'})
			},
			close(){
				let _this = this;
				uni.reLaunch({
					url: '../chat/index',
					success:function () {
						_this.$refs.popup.close();
					}
				});
			},
			confirm(e){
				let _this = this;
				uni.redirectTo({
					url: '/pages/my/details',
					success:function () {
						_this.$refs.popup.close();
					}
				});
			},
			isPoneAvailable($poneInput) {
				let myreg=/^[1][3,4,5,6,7,8,9][0-9]{9}$/;
				if (!myreg.test($poneInput)) {
					return false;
				} else {
					return true;
				}
			},
			getCode(){
				let _this = this;
				if(this.form.username.trim() == ''){
					uni.showToast({
						title: '请输入手机号',
						icon:'none'
					});
					return false;
				}

				if(!this.isPoneAvailable(this.form.username.trim())){
					uni.showToast({
						title: '请输入正确的手机号',
						icon:'none'
					});
					return false;
				}
				_get.getSms({mobile:this.form.username,type:_this.form.type},function (res) {
					_this.cutDown();
				},function (res) {
					uni.showToast({
						title: res.msg,
						duration:2000,
						icon:'none'
					});
				})
			},
			cutDown(val){//倒计时
				//获取验证码
				this.showText = false;
				var interval = setInterval(() => {
					let times = --this.second;
					times = times < 0 ? 0 : times;
					this.second = times<10?'0'+times:times //小于10秒补 0
				}, 1000)
				setTimeout(() => {
					clearInterval(interval)
					this.second=60
					this.showText = true
				}, 60000)
			},
			changePassword () {
				this.showPassword = !this.showPassword;
			},
			delInputUsernameText () {
				this.form.username = ''
			},
			delInputPasswordText () {
				this.form.password = ''
			},
			subForge () {
				let _this = this;
				if (!_this.checkIn) {
					return;
				}
				if (!(/^\w{1,20}$/.test(this.form.username))) {
					uni.showModal({
						content: '新聊号只能包括下划线、数字、字母,并且不能超过20个',
					});
					return;
				}

				if (!(/^\w{1,20}$/.test(this.form.password))) {
					uni.showModal({
						content: '密码只能包括下划线、数字、字母,长度6-20位',
					});
					return;
				}
				uni.showLoading({title:''})
				_this.$httpSend({
					path: '/im/in/forgetPassword',
					data: _this.form,
					success: (data) => {
						uni.showToast('修改成功');
						setTimeout(function () {
							uni.redirectTo({url:'login'});
						},1500)
					}
				});
			},
			go_forget () {
				uni.navigateTo({
					url: '../../pages/in/forget'
				})
			},
			go_register () {
				uni.navigateTo({
					url: '../../pages/in/reg'
				})
			}

		}
	}
</script>

<style>
	page{
		background-color: #FFFFFF;
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
		margin-top: 100upx;
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
	}
	.zai-form{
		margin-top: 150upx;
	}
	.form-code{
		margin-top: 30upx;
		display: flex;
		justify-content: center;
		align-items: center;
		height: 100%;
	}
	.form-code .code{
		height: 100%;
		border-radius: 50px;
		text-align: center;
		font-size: 14px;
		background: #6dcef7;
		color: #ffffff;
	}
	.zai-input{
		background: #e2f5fc;
		margin-top: 30upx;
		border-radius: 100upx;
		padding: 20upx 40upx;
		font-size: 36upx;
	}

	.code-input{
		background: #e2f5fc;
		border-radius: 100upx;
		padding: 20upx 40upx;
		font-size: 36upx;
		width: 40%;
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
		background: #ff65a3;
		color: #fff;
		border: 0;
		border-radius: 100upx;
		font-size: 36upx;
		margin-top: 60upx;
	}
	.zai-btn:after{
		border: 0;
	}
	/*按钮点击效果*/
	.zai-btn.button-hover{
		transform: translate(1upx, 1upx);
	}
	.zai-footer{
		display: flex;
		justify-content: center;
		align-items: center;
		color: #a7b6d0;
		padding-top: 10px;
	}
</style>
