<template>
	<view class="page">
		<view class="content">
			<view class="list" v-if="list.length">
				<view class="item" v-for="(item,index) in list">
					<view class="left-img">
						<view class="circle">
							<image src="../../../static/theme/default/my/alipay.png" class="left-img-img"></image>
						</view>
					</view>
					<view class="right-text">
						 <text class="right-text-name">{{item.bank_name}}</text>
						 <text  class="right-text-info">{{item.account}}</text>
					</view>
					<view class="right-icon">
						<uni-icons :size="20" class="uni-icon-wrapper" color="white" type="arrowright" />
					</view>
				</view>
			</view>
			<button class="withdraw" type="button" @tap="goPath('../set/add_account')">添加支付宝账号</button>
		</view>
	</view>
</template>

<script>
	import uniIcons from '../../../components/uni-ui/uni-icon/uni-icon'
	import _get from '../../../common/_get';
	import _hook from '../../../common/_hook';
	export default {
		data() {
			return {
				list:[]
			}
		},
		components:{
			uniIcons
		},
		onShow(){
			_hook.routeSonHook();
			this.getUserbankList();
			uni.$on("update_bank_list_data",this.updateBankList)
		},
		methods: {
			goPath(path){
				if(path){
					uni.navigateTo({
						url: path
					});
				}
			},
			updateBankList(bank){
				console.log(bank)
				return bank && this.list.concat([{'bank_name':bank.bank_name,'account':bank.account,'id':bank.id}])
			},
			getUserbankList(){
				let _this = this;
				_get.getUserbankList({},function (data) {
					  _this.list = data;
				})
			}
		}
	}
</script>

<style>
page{
	background-color: #f2f2f2;
}
.right-icon{
	position: absolute;
	right: 20upx;
}
.left-img{
	margin-left: 35upx;
	display: flex;
	justify-content: center;
	align-items: center;
}
.item .right-text{
	display: flex;
	flex-direction: column;
	color: white;
	font-size: 16px;
	font-weight: 400;
	margin-left: 20upx;
}
.left-img-img{
	width: 85upx;
	height: 85upx;
}
.left-img .circle{
	height: 100upx;
	width: 100upx;
	border-radius: 10px;
	background-color: white;
	display: flex;
	justify-content: center;
	align-items: center;
}

.list{
	padding: 0 30upx;
}

.list .item{
	height: 200upx;
	border-radius: 15upx;
	display: flex;
	background-color: #498cc0;
	flex-direction: row;
	position: relative;
	align-items: center;
	margin: 20rpx 0;
}

.content .withdraw{
	width: 92%;
	background-color: #5693ee;
	color: white;
	height: 70upx;
	line-height:  70upx !important;
	border-radius: 40upx;
	font-size: 36upx;
	cursor: pointer;
	margin-top: 20upx;
}

@font-face {font-family: "eosfont";
	src: url('https://at.alicdn.com/t/font_943490_fdgw8vjcnhp.ttf') format('truetype');
}

.eosfont {
	font-family:"eosfont" !important;
	font-size:16px;
	font-style:normal;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
}
</style>
