<template>
	<view class="page">
		<view class="page-user-info">
			<view class="info-left">
				<text class="info-left-title">付款给个人</text>
				<text class="info-left-info">{{user_info.username}}</text>
			</view>
			<view class="info-right">
				<image :src="staticPhoto + user_info.face"></image>
			</view>
		</view>
		<view class="content">
			<view class="content-main">
				<view class="content-main-other-info" v-if="pageParams.info">
						{{pageParams.info}}
				</view>
				<view class="content-main-icon">
					<text class="icon-msg">￥</text>
					<input class="uni-input" :disabled="disabled" v-model="value"   @input="setAmount" type="number" placeholder=""/>
				</view>
				<view class="footer-msg">
					<view class="footer-msg-main" v-if="my_input.info">
						<text class="info">{{my_input.info}}</text>
						<text class="footer-msg-do" @tap="editShuoming">修改</text>
					</view>
					<view class="footer-msg-main" v-else>
						<text class="footer-msg-do" @tap="editShuoming">添加说明</text>
					</view>
				</view>
				<view class="footer-button">
					<button class="withdraw" type="submit" @tap="payAmount">确定</button>
				</view>
			</view>
		</view>
		<uni-popup ref="popup" type="dialog">
			<uni-popup-confirm
					mode="input"
					type="input"
					:value="my_input.info"
					placeholder="最多输入10个字"
					title="添加收钱说明"
					:duration="2000"
					:before-close="true"
					@close="close"
					@confirm="confirm">
			</uni-popup-confirm>
		</uni-popup>
		<pay-keyboard  :showCose="showCose" :set_info = "set_info" :show_key="show_key" ref="payKeyboard" :set_msg="set_msg" @hideFun="hideFun" @getPassword="getPassword" :password="password"></pay-keyboard>
	</view>
</template>

<script>
	import _hook from '../../../common/_hook';
	import _data from '../../../common/_data';
	import _get from '../../../common/_get';
	import uniPopup from '../../../components/uni-popup/uni-popup'
	import uniPopupConfirm from '../../../components/uni-popup/uni-popup-confirm'
	import payKeyboard from '../../../components/uni-keyword/uni-keyword';
	export default {
		data() {
			return {
				my_data:{},
				pageParams:{
					info:'',
					user_id:0,
					amount:0
				},
				disabled:false,
				user_info:{},
				my_input:{
					info:''
				},
				set_msg:'请输入交易密码',
				set_info:'请输入交易密码，以确认身份',
				password:'',
				show_key:false,
				showCose:true
			}
		},
		components:{
			uniPopup,
			uniPopupConfirm,
			payKeyboard
		},
		onLoad(options){
			this.pageParams = options;
			if(options.amount) this.disabled = true;
		},
		onShow(){
			_hook.routeTabBarHook();
			let _this = this;
			/** 监听新的个人数据 */
			_get.getUserInfo(_this.pageParams,function(ret){
				console.log(ret);
				_this.user_info = ret;
			});
		},
		computed:{
			staticPhoto(){
				return _data.staticPhoto();
			},
			value(){
				return this.pageParams.amount;
			}
		},
		methods: {
			hideFun(){
				this.show_key = false;
			},
			getPassword(n){
				//付款
				let _this  = this;
				uni.showLoading({
					title:'付款中...'
				});
				_get.payAmount({to_user_id:this.pageParams.user_id,amount:this.pageParams.amount,info:this.my_input.info},function (ret) {
					uni.$emit('data_user_info',ret);
					_data.data('user_info',ret);
					 _this.$refs.payKeyboard.cleanNum();
					uni.hideLoading();
					uni.showToast({
						title:'支付成功',
						icon:'none'
					})
					setTimeout(function(){
						uni.redirectTo({
							url:'/pages/my/wallet/capital'
						})
					},1000)
				},function(ret){
						uni.hideLoading();
						uni.showToast({
							title:ret.msg,
							icon:'none'
						})
					   _this.$refs.payKeyboard.cleanNum();
				});
			},
			setAmount(e){
				this.pageParams.amount= e.detail.value;
			},
			close(){
				this.$refs.popup.close()
			},
			confirm(val,value){
				val();
				this.my_input.info = value;
			},
			editShuoming(){
				this.$refs.popup.open();
			},
			payAmount(){
				let _this = this;
				if(!this.pageParams.amount){
					 _this.$refs.payKeyboard.cleanNum();
					return uni.showToast({
						title:'金额错误',
						icon:'none'
					});
				}
				if(_data.data('user_info').id == _this.user_info.user_id) {
					 _this.$refs.payKeyboard.cleanNum();
					return uni.showToast({
						title:'不能付款给自己',
						icon:'none'
					});
				}
				this.show_key = true;
			}
		}
	}
</script>

<style>
	.content-main-other-info{
		margin-left: 12px;
		margin-top: 20px;
		font-size: 14px;
		font-weight: 500;
	}
	.info-left-title{
		font-size: 14px;
		font-weight: 500;
	}
	.info-left-info{
		color: #b1b0b5;
	}
	.info-left{
		display: flex;
		flex-direction: column;
		justify-content: center;
	}
	.page-user-info{
		display: flex;
		flex-direction: row;
		justify-content: space-between;
		align-items: center;
		width: 90%;
		padding: 20upx 0;
	}
	 .info-right image{
		width: 80upx !important;
		height: 80upx !important;
		 border-radius: 10px;
	}
	 .info-right{
		 display: flex;
		 align-items: center;
	 }
	.footer-msg-do{
		color: #a1a3b0;
		margin-left: 20upx;
	}
	.content .withdraw{
		width: 90%;
		background-color: #51a938;
		color: white;
		height: 90upx;
		line-height:  90upx !important;
		border-radius: 15upx;
		font-size: 36upx;
		cursor: pointer;
	}
	.footer-button{
		margin-bottom: 50upx;
	}
	.page{
		display: flex;
		flex-direction:column;
		justify-content: center;
		align-items: center;
	}
	.footer-msg .footer-msg-main{
		margin: 30upx 0 30upx 12px;
		font-size: 14px;
	}
	.content{
		margin-top: 10upx;
		width: 95%;
		background-color: white;
		border-radius: 10upx;
	}
	.icon-msg{
		margin-bottom: 17px;
		font-weight: 600;
		font-size: 22px;
	}
	.content-main-icon{
		display: flex;
		justify-content: center;
		flex-direction: row;
		align-items: center;
		margin-top: 12px;
		margin-left: 30upx;
		border-bottom: 1px solid #f3f3f3;
	}
	.content-main-icon input{
		font-size: 30px;
		padding: 10upx;
		margin-left: 8px;
		font-weight: 600;
	}
</style>
