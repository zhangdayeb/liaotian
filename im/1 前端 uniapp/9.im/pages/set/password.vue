<template>
	<view>
		<view class="uni-common-mt">
			<view class="uni-form-item uni-column">
				<view class="title">输入原密码</view>
				<view class="with-fun">
					<input class="uni-input" placeholder="请输入密码" :password="showPassword[0]" v-model="formData.pass1" />
					<view class="uni-icon uni-icon-eye" :class="[!showPassword[0] ? 'uni-active' : '']" @click="changePassword(0)"></view>
				</view>
			</view>
			<view class="uni-form-item uni-column">
				<view class="title">输入新密码</view>
				<view class="with-fun">
					<input class="uni-input" placeholder="请输入密码" :password="showPassword[1]" v-model="formData.pass2" />
					<view class="uni-icon uni-icon-eye" :class="[!showPassword[1] ? 'uni-active' : '']" @click="changePassword(1)"></view>
				</view>
			</view>
			<view class="uni-form-item uni-column">
				<view class="title">确认新密码</view>
				<view class="with-fun">
					<input class="uni-input" placeholder="请输入密码" :password="showPassword[2]" v-model="formData.pass3" />
					<view class="uni-icon uni-icon-eye" :class="[!showPassword[2] ? 'uni-active' : '']" @click="changePassword(2)"></view>
				</view>
			</view>
		</view>
	</view>
</template>
<script>
	
	import _action from '../../common/_action';
	import _hook from '../../common/_hook';

	export default {
		data() {
			return {
				showPassword: [ true,true,true ],
				formData: {
					pass1: '',
					pass2: '',
					pass3: '',
				}
			}
		},
		computed: {
			
		},
		onShow(){
			_hook.routeSonHook();
		},
		onLoad() {
			this.platform = uni.getSystemInfoSync().platform
		},
		methods: {
			changePassword(num) {
				this.$set(this.showPassword,num,!this.showPassword[num]);
			},
			send(){
				let _this = this;
				if(!_this.formData.pass1 || _this.formData.pass1.length < 6){
					uni.showModal({
						content: '请输入原密码,不能小于6位',
					});
					return;
				}
				if(!_this.formData.pass2 || _this.formData.pass2.length < 6){
					uni.showModal({
						content: '请输入新密码,不能小于6位',
					});
					return;
				}
				if(!_this.formData.pass3 || _this.formData.pass3.length < 6){
					uni.showModal({
						content: '请确认新密码,不能小于6位',
					});
					return;
				}
				if(_this.formData.pass2 !== _this.formData.pass3){
					uni.showModal({
						content: '两次新密码不一致',
					});
					return;
				}
				_this.$httpSend({
					path: '/im/set/password',
					data: _this.formData,
					success() {
						uni.showToast({
							title: '已修改,请重新登陆',
						});
						setTimeout(() => {
							_action.checkFail();
						},2000);
					}
				});
			},
		},
		onNavigationBarButtonTap(e) {
			this.send();
		},
	}
</script>

<style scoped>
	
	.title {
		padding: 10upx 25upx;
	}
	
	.uni-icon-clear,
	.uni-icon-eye {
		color: #999;
	}
	
</style>
