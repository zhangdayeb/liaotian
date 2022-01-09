<template>
	<view class="page">
		<view class="content">
			<view class="item">
				<uni-list class="list">
					<uni-list-item title="选择提现方式"
								   :show-arrow="true"
								   :rightText="item.bank_name"
								   :showArrow="true"
								   @click="open"/>
				</uni-list>
			</view>

			<view class="main">
				<view class="main-content">
					<view class="msg">
						<text>提现金额</text>
					</view>
				<view class="msg-type">
					<text>￥</text>
				</view>
				<view class="msg-input">
					<input class="uni-input" type="number" @input="input" :value="amount" placeholder-class="placeholder" focus placeholder="请输提现金额"/>
				</view>
				<view class="msg-introduce">
					<text class="first">零钱余额￥{{user_info.money}}，<text class="all" @tap="allWithDraw">全部提现</text></text>
				</view>
					<view class="button">
						<button class="withdraw" type="button" @tap="withdrawMoney">确认提现</button>
					</view>
					<view class="withdraw-msg">
						<text>提现手续费为{{withdraw.fee}}，最低提现费用为{{withdraw.min_amount}}元</text>
					</view>
				</view>
			</view>
		</view>
		<uni-popup ref="popup" type="list">
			<uni-popup-list title="请选择渠道" @select="select" :bottomData ="bottomData" :selectList ="selectList"></uni-popup-list>
		</uni-popup>
	</view>
</template>

<script>
	import uniPopup from '@/components/uni-popup/uni-popup.vue';
	import UniPopupList from '@/components/uni-popup/uni-popup-list.vue';
	import _get from '../../../common/_get';
	import _hook from '../../../common/_hook';
	import _data from '../../../common/_data';
	export default {
		data() {
			return {
				item:{
					bank_name:'请选择提现方式'
				},
				user_info:{
					money:0.00
				},
				withdraw:{
					fee:'0%',
					min_amount:0
				},
				bottomData:[],
				amount:"",
				selectList:0,
			}
		},
		components:{
			uniPopup,
			UniPopupList
		},
		onShow(){
			let _this = this;
			_hook.routeTabBarHook();
			_this.user_info = _data.data('user_info');

			/** 监听新的个人数据 */
			uni.$on('data_user_info', function (data) {
				_this.user_info = data;
			});
			_this.getUserbankList();
			uni.$on("update_bank_list_data",this.updateBankList);
			_get.getWithDrawConfig({},function (ret) {
				_this.withdraw.min_amount = ret.user_min_withdraw;
				_this.withdraw.fee = ret.user_withdraw_fee * 100 + "%";
			});
		},
		methods: {
			open(){
				this.$refs.popup.open()
			},
			updateBankList(bank){
				return bank && this.bottomData.concat([{
					'bank_name':bank.bank_name,
					'bank_info':bank.bank_info,
					'account':bank.account,
					'id':bank.id,
					'icon':'https://img-cdn-qiniu.dcloud.net.cn/uni-ui/grid-8.png',
				}])
			},
			getUserbankList(){
				let _this = this;
				_get.getUserbankList({},function (data) {
					_this.bottomData = data;
					if(_this.bottomData.length){
						_this.selectList = _this.bottomData[0].id;
						_this.bottomData = _this.bottomData.map(item => {
							return {
								'bank_name':item.bank_name,
								'bank_info':item.bank_info,
								'account':item.account,
								'id':item.id,
								'icon':'https://img-cdn-qiniu.dcloud.net.cn/uni-ui/grid-8.png',
							}
						})
					}
				})
			},
			select(val,cb){
				if(!this.bottomData.length){
					uni.navigateTo({
						'url':'alipay_set'
					});
					return false;
				}
				this.item = val;
				this.selectList = val.id;
				console.log(this.item)
				if(cb){
					cb();
				}
			},
			input(e){
				console.log(e.detail.value)
				return this.amount = e.detail.value;
			},
			withdrawMoney(){
				//微信和支付宝待
				if(!this.item.id)return uni.showToast({'title':'最选择提现方式','icon':'none'});
				if(this.amount < this.withdraw.min_amount)
					return uni.showToast({'title':'最少提现'+this.withdraw.min_amount+'元','icon':'none'});
				_get.withDrawMoney({amount:this.amount,'bank_id':this.item.id},function (ret) {
					uni.showToast({
						title: '提现成功,请等待审核',
						duration: 1000,
						icon:"none"
					});
				},function (ret) {
					uni.showToast({
						title: ret.msg,
						duration: 1000,
						icon:"none"
					});
				})

			},
			allWithDraw(){
				return this.amount = this.user_info.money;
			}
		}
	}
</script>

<style>
	.main-content .msg-type text{
		font-size: 20px !important;
		font-weight: 600;
	}
	.main-content .msg{
		font-weight: 500;
		font-size: 16px;
	}
	.main-content .msg,.msg-type,.msg-input,.msg-introduce,.withdraw-msg{
		margin-left: 40upx;
		padding-bottom: 30upx;
	}
.msg-introduce .first,.withdraw-msg text{
	color: #929292;
	/*626880*/
}
.main-content .button{
	display: flex;
	justify-content: center;
	align-items: center;
	padding-bottom: 30upx;
}
.withdraw{
	background-color: #5693ee;
	color: white;
	height: 80upx;
	line-height: 80upx;
	border-radius: 50upx;
	width: 90%;
}
.msg-introduce .all{
	color: #5f5c77;
	margin-left: 40upx;
}
.content .list{
	margin-top: 25upx;
}
.content .main{
	display: flex;
	padding: 10upx;
	margin-top: 20upx;
	justify-content: center;
	align-items: center;
}
.main .main-content{
	display: flex;
	width: 95%;
	background-color: white;
	flex-direction: column;
	border-radius: 5upx;
	padding-top: 40upx;
	padding-bottom: 40upx;
}
	.uni-input{
		border-bottom: 1px solid #f2f2f2;
		padding-left: 0px !important;
		width: 90%;
		font-size: 18px;
	}
	.uni-list-item__extra-text{
		font-size: 14px !important;
		margin-right: 20upx;
	}
</style>
