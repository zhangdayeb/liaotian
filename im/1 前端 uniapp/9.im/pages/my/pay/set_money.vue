<template>
	<view class="page">
		<view class="content">
			<view class="content-main">
				<view class="content-main-icon">
					<text class="icon-msg">￥</text>
					<input class="uni-input" @input="getAmount" type="text" placeholder=""/>
				</view>
				<view class="footer-msg">
					<view class="footer-msg-main" v-if="pagaParams.info">
						<text class="info">{{pagaParams.info}}</text>
						<text class="footer-msg-do" @tap="editShuoming">修改</text>
					</view>
					<view class="footer-msg-main" v-else>
						<text class="footer-msg-do" @tap="editShuoming">添加说明</text>
					</view>
				</view>
				<view class="footer-button">
					<button class="withdraw" type="submit" @tap="setAmount">确定</button>
				</view>
			</view>
			<uni-popup ref="popup" type="dialog">
				<uni-popup-confirm
						mode="input"
						type="input"
						:value="pagaParams.info"
						placeholder="最多输入10个字"
						title="添加收钱说明"
						:duration="2000"
						:before-close="true"
						@close="close"
						@confirm="confirm">
				</uni-popup-confirm>
			</uni-popup>
		</view>

	</view>
</template>

<script>
	import uniPopup from '../../../components/uni-popup/uni-popup'
	import uniPopupConfirm from '../../../components/uni-popup/uni-popup-confirm'
	import _page from '../../../common/common'
	import _hook from '../../../common/_hook'
	export default {
		data() {
			return {
				pagaParams:{
					amount:'',
					info:''
				}
			}
		},
		components:{
			uniPopup,
			uniPopupConfirm
		},
		onShow() {
			_hook.routeSonHook();
		},
		methods: {
			editShuoming(){
				this.$refs.popup.open();
			},
			getAmount(e){
				return this.pagaParams.amount = e.detail.value;
			},
			close(){
				this.$refs.popup.close()
			},
			confirm(val,value){
				val();
				this.pagaParams.info = value;
			},
			setAmount(){
				let _this =this;
				console.log(_this.pagaParams);
				if(!_this.pagaParams.amount.trim()){
					uni.showToast({title:'请输入金额!',icon:'none'});
					return false;
				}
				uni.$emit('update_money_info',{amount:_this.pagaParams.amount,info:_this.pagaParams.info});
				uni.navigateBack();
			}
		}
	}
</script>

<style>
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
		margin-top: 100upx;
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
