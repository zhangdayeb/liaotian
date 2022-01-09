<template>
	<view class="page">
		<view class="page-content">
			<view class="page-title">
				<text>收款金额</text>
			</view>
			<view class="page-content-input">
				<text class="page-money-fuhao">￥</text>
				<input class="uni-input-collect" @input="getAmount" type="text" placeholder=""/>
			</view>
			<view class="footer-button">
				<button class="withdraw" type="submit" @tap="collectAmount">确定</button>
			</view>
		</view>
	</view>
</template>

<script>
	import _hook from '../../../common/_hook';
	import _data from '../../../common/_data';
	import _get from '../../../common/_get';
	export default {
		data() {
			return {
				pageParams:{
					amount:''
				},
				user_info:{
					id:0
				},
				user_id:0
			}
		},
		onShow() {
			let _this = this;
			_hook.routeSonHook();
			_get.getUserInfo({user_id:_this.user_id},function(ret){
				_this.user_info = ret;
				uni.setNavigationBarTitle({
					title:'向'+ret.username+'收款'
				})
			});
			uni.$on('pay_amount_after',function(ret){
				 uni.$emit('data_user_info',ret);
				_data.data('user_info',ret);
				uni.hideLoading();
				uni.showToast({
					title:'交易成功',
					icon:'none'
				})
				setTimeout(function(){
					uni.redirectTo({
						url:'/pages/my/wallet/capital'
					})
				},1000)
			})
		},
		onLoad(options){
			this.user_id = options.user_id;
		},
		methods: {
			getAmount(e){
				return this.pageParams.amount = e.detail.value;
			},
			collectAmount(){
				uni.showLoading({
					title:'请求中...'
				});
				_get.collectAmount({amount:this.pageParams.amount,to_user_id:this.user_id},function(){
					 uni.showLoading({
					 	title:'等待用户输入交易密码...'
					 });
				})
			}
		}
	}
</script>

<style>
	 .withdraw{
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
		padding: 50upx;
	}
	.page-title{
		padding: 40upx 0;
	}
	.page-money-fuhao{
		font-size: 22px;
		font-weight: 800;
	}
	.page-content-input{
		display: flex;
	}
page{
	background-color: #f1f0f5;
}
.page{
	margin-top: 30rpx;
	padding: 0 30rpx;
}
.page-money-fuhao{
 margin-bottom: 50upx;
}
.page-content{
	background-color: white;
	border-radius: 5rpx;
	padding-left: 40rpx;
}
.uni-input-collect{
	border-bottom: 1px solid #bcbcbc;
	padding: 10px;
	font-size: 30px;
	font-weight: 800;
	width: 80%	;
}
</style>
