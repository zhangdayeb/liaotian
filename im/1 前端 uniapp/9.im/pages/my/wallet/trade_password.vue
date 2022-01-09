<template>
	<view class="page">
		<view class="content">
			<uni-list class="list">
				<uni-list-item ref="uitem" :title="title"
							   :show-arrow="true"
							   :showArrow="true"
							   @tap="goPath(path)"/>
				<uni-list-item title="忘记支付密码"
							   :show-arrow="true"
							   :showArrow="true"
							   @tap="goPath('/pages/my/foget_trade_password')"/>
			</uni-list>
		</view>
	</view>
</template>

<script>
	import _hook from '../../../common/_hook';
	import _data from '../../../common/_data';
	import _get from '../../../common/_get';
	import ulist from  '../../../components/uni-list/uni-list'
	import uitem from  '../../../components/uni-list-item/uni-list-item'

	export default {
		data() {
			return {
				set_msg:'请输入交易密码',
				set_info:'请输入交易密码，以确认身份',
				password:'',
				show_key:false,
				showCose:true,
				user_info:{}
			}
		},
		components:{
			ulist,
			uitem
		},
		computed:{
			title(){
				return this.user_info.trade_password ? '修改支付密码' : '设置支付密码';
			},
			path(){
				return this.user_info.trade_password ? '../set/edit_trade_password' : '../set/set_trade_password';
			}
		},
		onShow(){
			_hook.routeSonHook();
			let _this = this;

			_get.getUserInfo({},function (data) {
				_this.user_info = data;
			});

			if(!_this.user_info.length){
				_this.user_info = _data.data('user_info');
			}

		},
		methods: {
			goPath(path){
				if(path){
					uni.navigateTo({
						url: path
					});
				}
			}
		}
	}
</script>

<style>
.content .list{
	margin-top: 20upx;
}
</style>
