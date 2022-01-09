<template>
	<view class="uni-popup-dialog">
		<view class="uni-dialog-content">
			<view class="uni-content-ceil">
				<view class="uni-content-ceil-title">
					<text>帐号：</text>
				</view>
				<input type="text" :value="userinfo.username" @input="username" placeholder="请输入帐号" class="uni-content-ceil-input" />
			</view>
			<view class="uni-content-ceil">
				<view class="uni-content-ceil-title">
					<text>昵称：</text>
				</view>
				<input type="text" :value="userinfo.nickname" @input="nickname" placeholder="请输入昵称" class="uni-content-ceil-input" />
			</view>
			<view class="uni-content-ceil">
				<view class="uni-content-ceil-title">
					<text>密码：</text>
				</view>
				<input type="text" :value="userinfo.password" maxlength="11" @input="password" placeholder="请输入密码" class="uni-content-ceil-input" />
			</view>
		</view>
		<view class="uni-dialog-button-group">
			<button type="primary" @tap="onOk" style="width: 80%;border-radius: 30px;">确认</button>
		</view>
		
	</view>
</template>

<script>
	/**
	 * PopUp 弹出层-对话框样式
	 * @description 弹出层-对话框样式
	 * @tutorial https://ext.dcloud.net.cn/plugin?id=329
	 * @property {String} value input 模式下的默认值
	 * @property {String} placeholder input 模式下输入提示
	 * @property {String} type = [success|warning|info|error] 主题样式
	 *  @value success 成功
	 * 	@value warning 提示
	 * 	@value info 消息
	 * 	@value error 错误
	 * @property {String} mode = [base|input] 模式、
	 * 	@value base 基础对话框
	 * 	@value input 可输入对话框
	 * @property {String} content 对话框内容
	 * @property {Boolean} beforeClose 是否拦截取消事件
	 * @event {Function} confirm 点击确认按钮触发
	 * @event {Function} close 点击取消按钮触发
	 */
	export default {
		name: "uniPopupForm",
		props: {
			value: {
				type: [String, Number],
				default: ''
			},
			maxlength:{
				type: Number,
				default: 10
			},
			placeholder: {
				type: [String, Number],
				default: '请输入内容'
			},
			/**
			 * 对话框主题 success/warning/info/error	  默认 success
			 */
			type: {
				type: String,
				default: 'error'
			},
			/**
			 * 对话框模式 base/input
			 */
			mode: {
				type: String,
				default: 'base'
			},
			/**
			 * 对话框标题
			 */
			title: {
				type: String,
				default: '提示'
			},
			/**
			 * 对话框内容
			 */
			content: {
				type: String,
				default: ''
			},
			/**
			 * 拦截取消事件 ，如果拦截取消事件，必须监听close事件，执行 done()
			 */
			beforeClose: {
				type: Boolean,
				default: false
			},
			userinfo:{
				type:Object,
				default:()=>{
					return {
						username: '',
						password: '',
						nickname: ''
					}
				}
			}
		},
		data() {
			return {
				dialogType: 'error',
				focus: false,
				val: ""
			}
		},
		components:{
		},
		inject: ['popup'],
		watch: {
			type(val) {
				this.dialogType = val
			},
			mode(val) {
				if (val === 'input') {
					this.dialogType = 'info'
				}
			},
			value(val) {
				this.val = val
			}
		},
		created() {
			// 对话框遮罩不可点击
			this.popup.mkclick = false
			if (this.mode === 'input') {
				this.dialogType = 'info'
				this.val = this.value
			} else {
				this.dialogType = this.type
			}
		},
		mounted() {
			this.focus = true
		},
		methods: {
			username(e){
				console.log(e.detail.value)
				return this.userinfo.username = e.detail.value;
			},
			nickname(e){
				console.log(e.detail.value)
				return this.userinfo.nickname = e.detail.value;
			},
			password(e){
				return this.userinfo.password = e.detail.value;
			},
			onOk() {
				//判断手机号
				if(this.userinfo.username == '')return uni.showToast({title:"请输入帐号",icon:'none'});
				if(this.userinfo.nickname == '')return uni.showToast({title:"请输入昵称",icon:'none'});
				if(this.userinfo.password == '')return uni.showToast({title:"请输入密码",icon:'none'});
				this.$emit('confirm',this.userinfo)
			},
			/**
			 * 点击取消按钮
			 */
			close() {
				if (this.beforeClose) {
					this.$emit('close', () => {
						this.popup.close()
					})
					return
				}
				this.popup.close()
			}
		}
	}
</script>

<style lang="scss" scoped>
	.uni-popup-dialog {
		background-color: #fff;
		padding: 20px;
		border-radius: 5px;
	}
	.uni-popup-dialog button{
		line-height: unset;
	}
	.fix-icon-title{
		position: relative;
	}
	.uni-dialog-title {
		/* #ifndef APP-NVUE */
		display: flex;
		/* #endif */
		flex-direction: row;
		justify-content: flex-start;
		padding: 20px 20px;
	}
	.icon-close:before{
		content: "\e620";
		position: absolute;
		display:block;
		width: 0;
		height: 0;
		left: 360rpx;
		top: -20rpx;
	 }

	.uni-popup-image{
		display: flex;
		justify-content: center;
		align-items: center;
	}
	.uni-popup-info {
		display: flex;
		flex-direction: column;
		margin-left: 20px;
	}

	.uni-dialog-content {
		/* #ifndef APP-NVUE */
		display: flex;
		/* #endif */
		flex-direction: column;
		justify-content: center;
		align-items: center;
	}

	.uni-dialog-content-text {
		font-size: 14px;
		color: #6e6e6e;
	}

	.uni-dialog-button-group {
		/* #ifndef APP-NVUE */
		display: flex;
		/* #endif */
		flex-direction: row;
		padding: 10px 0;
	}


	.uni-dialog-input {
		flex: 1;
		font-size: 14px;
		overflow: visible !important;
		line-height :1.9rem !important;
		height:1.9rem !important;
		border-radius: 10px;
		padding-left:2px;
		background-color: #eeeeee;
	}

	.uni-popup__success {
		color: $uni-color-success;
	}

	.uni-popup__warn {
		color: $uni-color-warning;
	}

	.uni-popup__error {
		color: $uni-color-error;
	}

	.uni-popup__info {
		color: #909399;
	},
	.uni-content-ceil{
		display: flex;
		flex-direction: row;
		justify-content: center;
		width: 100%;
		padding: 8px 0;
	}
	.uni-content-ceil-title{
		font-size: 16px;
		margin-right: 10upx;
	}
	.uni-content-ceil-input{
		border-bottom: 1upx solid #A9A9A9;
		padding: 0 50rpx;
		justify-content:space-around;

	}
</style>
