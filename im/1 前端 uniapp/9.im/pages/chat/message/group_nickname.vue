<template>
	<view class="page">
		<view class="page-content">
			<input type="text" class="uni-input" v-model="nickname"/>
			 <view class="page-content-info">设置您在群里的昵称，这个昵称只会在群内显示</view>
		</view>
	</view>
</template>

<script>
	import _hook from '../../../common/_hook';
	import _get from '../../../common/_get';
	export default {
		data() {
			return {
				nickname:'',
				list_id:''
			}
		},
		onShow(){
			_hook.routeSonHook();
			let _this = this;
		},
		onLoad(options){
			if('nickname' in options){
				this.nickname = options.nickname
				this.list_id = options.list_id
			}
		},
		methods: {

		},
		onNavigationBarButtonTap(e) {
			//保存昵称
			_get.saveGroupNickName({nickname:this.nickname,list_id:this.list_id},function () {
				uni.showToast({title:'操作成功',duration: 2000,icon:'none'});
				setTimeout(function () {
					uni.navigateBack();
				},1000)
			},function (ret) {
				uni.showToast({title:ret.msg,duration: 2000,icon:'none'})
			});
		}
	}
</script>

<style>
page{
	background-color: #ffffff;
}
.page-content-info{
	word-break: break-all;
	margin-top: 10px;
}
.page{
	margin-top: 40px;
	display: flex;
	justify-content: center;
}
.page-content{
	display: flex;
	justify-content: center;
	flex-direction: column;
	width: 80%;
	height: 100%
;
}
.page-content input{
	background-color: #f1f1f1;
	height: 35px;
	border-radius: 5px;
}
</style>
