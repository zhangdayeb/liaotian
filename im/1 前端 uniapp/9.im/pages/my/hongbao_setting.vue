<template>
	<view>
		<c-hongsetting ref="hongBao" @saveConfig="saveConfig" :info="info"></c-hongsetting>
	</view>
</template>
<script>
	import cHongSeting from "../../components/c-hongsetting/c-hongsetting";
	import _get from '../../common/_get';
	export default {
		data() {
			return {
				info: {
					lei_msg:"9包",
					lei1:"",
					fuli1:"",
					lei2:"",
					fuli2:"",
					lei3:"",
					fuli3:"",
					lei4:"",
					fuli4:"",
					lei5:"",
					fuli5:"",
					lei6:"",
					fuli6:"",
					selectNum:9,
					status:1
				},
				vendor_id:''

			}
		},
		onShow(){
			//获取配置
			console.log('success......')
			let _this = this;
			_get.getVendorInfo({vendor_id:this.vendor_id},function (ret) {
				if(ret && Object.keys(ret).length){
					_this.info = ret;
					_this.info.lei_msg = _this.info.selectNum + '包';
					console.log("ret.status",ret.status)
					_this.$refs.hongBao.setStatus(ret.status)
				}
			})
		},
		onLoad(options){
			this.vendor_id = options.id
		},
		components:{
			cHongSeting
		},
		methods: {
			saveConfig(e){
				let _this = this;
				e.vendor_id = this.vendor_id
				_get.setHongBaoConfig(e,function (ret) {
					uni.showToast({title:'操作成功!',icon:'none'})
				},function (ret) {
					uni.showToast({title:ret.msg,icon:'none'})
				});
			}
		}
	}
</script>

<style>

</style>
