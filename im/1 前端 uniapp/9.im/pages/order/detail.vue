<template>
	<view class="page">
		<view class="order-info-detail" v-if="orderDetail.is_buyer == 0">
			<uni-list class="list" style="margin-top: 14px;">
				<uni-list-item class="rder-info-detail-item" title="商品标题：" :rightText="orderDetail.goods_name" :showArrow="showArrow"/>
				<uni-list-item class="rder-info-detail-item" title="商品图片：" :rightImage="orderDetail.small_pic" :showArrow="showArrow"/>
				<uni-list-item class="rder-info-detail-item"  title="商品价格：" :rightText="orderDetail.amount" :showArrow="showArrow"/>
				<uni-list-item class="rder-info-detail-item" title="买家昵称：" :rightText="orderDetail.buyer_username" :showArrow="showArrow"/>
				<uni-list-item class="rder-info-detail-item" title="买家头像：" :rightImage="staticPhoto + orderDetail.buyer_face" :showArrow="showArrow"/>
				<uni-list-item class="rder-info-detail-item" title="收货人：" :rightText="orderDetail.username" :showArrow="showArrow"/>
				<uni-list-item class="rder-info-detail-item" title="手机号：" :rightText="orderDetail.mobile" :showArrow="showArrow"/>
				<uni-list-item class="rder-info-detail-item" title="快递单号：" :rightText="orderDetail.logistics_code?orderDetail.logistics_code:''" :showArrow="showArrow"/>
				<uni-list-item class="rder-info-detail-item" title="收货地址：" :rightText="orderDetail.address" :showArrow="showArrow"/>
				<uni-list-item class="rder-info-detail-item" title="订单状态：" :rightText="orderDetail.status_msg" :showArrow="showArrow"/>
				<uni-list-item class="rder-info-detail-item" title="下单时间：" :rightText="orderDetail.create_time" :showArrow="showArrow"/>
			</uni-list>
			  <view v-if="orderDetail.logistics_status == 1">
				  <button type="primary" class="list-fahuo" @tap="open">发货</button>
			  </view>
		</view>
		<view class="order-info-detail" v-if="orderDetail.is_buyer == 1">
			<uni-list class="list" style="margin-top: 14px;">
				<uni-list-item class="rder-info-detail-item" title="商品标题：" :rightText="orderDetail.goods_name" :showArrow="showArrow"/>
				<uni-list-item class="rder-info-detail-item" title="商品图片：" :rightImage="orderDetail.small_pic" :showArrow="showArrow"/>
				<uni-list-item class="rder-info-detail-item"  title="商品价格：" :rightText="orderDetail.amount" :showArrow="showArrow"/>
				<uni-list-item class="rder-info-detail-item" title="卖家昵称：" :rightText="orderDetail.seller_username" :showArrow="showArrow"/>
				<uni-list-item class="rder-info-detail-item" title="卖家头像：" :rightImage="staticPhoto + orderDetail.seller_face" :showArrow="showArrow"/>
				<uni-list-item class="rder-info-detail-item" title="收货人：" :rightText="orderDetail.username" :showArrow="showArrow"/>
				<uni-list-item class="rder-info-detail-item" title="手机号：" :rightText="orderDetail.mobile" :showArrow="showArrow"/>
				<uni-list-item class="rder-info-detail-item" title="快递单号：" :rightText="orderDetail.logistics_code?orderDetail.logistics_code:''" :showArrow="showArrow"/>
				<uni-list-item class="rder-info-detail-item" title="收货地址：" :rightText="orderDetail.address" :showArrow="showArrow"/>
				<uni-list-item class="rder-info-detail-item" title="订单状态：" :rightText="orderDetail.status_msg" :showArrow="showArrow"/>
				<uni-list-item class="rder-info-detail-item" title="下单时间：" :rightText="orderDetail.create_time" :showArrow="showArrow"/>
			</uni-list>
		</view>
		<uni-popup ref="popup" type="dialog">
			<uni-popup-confirm
					mode="input"
					type="input"
					value=""
					placeholder="请输入快递单号"
					title="发货"
					:duration="2000"
					:before-close="true"
					@close="close"
					@confirm="confirm">
			</uni-popup-confirm>
		</uni-popup>
	</view>
</template>
<style>

 .order-info-detail{
	 display: flex;
	 flex-direction: column;
	 justify-content: center;
	 margin-bottom: 80px
 }
.rder-info-detail-item{
	word-break: break-all;
}
.list-fahuo{
	border-radius: 30px;
	margin-top: 20px;
	width: 80%;
	height: 40px;
	line-height: unset;
	line-height: 40px;

}
</style>

<script>
	import _hook from '../../common/_hook';
	import _data from '../../common/_data';
	import _get from '../../common/_get';
	import UniPopupConfirm from '../../components/uni-popup/uni-popup-confirm';
	export default {
		data() {
			return {
				showArrow:false,
				orderDetail:{}
			}
		},
		components:{
			UniPopupConfirm
		},
		computed:{
			staticPhoto(){
				return _data.staticPhoto();
			}
		},
		onShow(){
			_hook.routeSonHook()
		},
		onLoad(option){
			console.log(option)
			this.orderDetail = option
		},
		methods: {
			open(){
				this.$refs.popup.open()
			},
			confirm(sure,value){
				sure();
				_get.updateOrderStatus({logistics_code:value,'id':this.orderDetail.id},function (ret) {
					uni.showToast({title:'发货成功'});
					setTimeout(function () {
						uni.navigateBack()
					},1000)
				},function (ret) {
					uni.showToast({title:ret.msg,icon:"none"})
				});
			},
			close(){
				this.$refs.popup.close()
			},
		}
	}
</script>

