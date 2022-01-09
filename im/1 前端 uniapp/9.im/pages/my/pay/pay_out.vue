<template>
	<view class="page">
		<view class="content">
			<view class="content-info">
				<image src="/static/theme/default/my/shoukuan2.png"></image>
				<text>二维码收款</text>
			</view>
			<view class="content-main">
				<text class="content-main-info">无需向我加好友，扫码向我付钱</text>
				 <view v-if="pageParams.amount" class="amount-set-info">
					 <text class="info-amount">￥{{pageParams.amount}}</text>
					 <text class="info-text">{{pageParams.info}}</text>
				 </view>
				<view class="content-main-qrCode">
					<tki-qrcode
							ref="qrcode"
							:val="qrData"
							:onval="true"
							:size="300"
							:iconSize="65"
							unit="upx"
							background="#ffffff"
							foreground="#000000"
							pdground="#000000"
							:loadMake="true"
							:showLoading="true"
							loadingText="加载中..."
							@result="qrR" />
				</view>
				<view class="content-main-footer">
					<view @tap="goPath('set_money')">{{set?'设置金额':'清除金额'}}</view>
					<!-- #ifndef MP-WEIXIN -->
					<view  @click="saveImgToLocal">
						保存收款码
					</view>
					<!-- #endif -->

					<!-- #ifdef MP-WEIXIN -->
					<view v-if="openSettingBtnHidden" class="purple_btn btn_box" @click="saveImg">
						保存收款码
					</view>
					<button v-else  hover-class="none" open-type="openSetting" @opensetting='handleSetting'>保存收款码</button>
					<!-- #endif -->
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	import _hook from '../../../common/_hook';
	import _data from '../../../common/_data';
	import _page from '../../../common/common';
	import tkiQrcode from "../../../components/tki-qrcode/tki-qrcode.vue";
	export default {
		data() {
			return {
				img_path:'',
				my_data:{},
				pageParams:{
					amount:'',
					info:'',
				},
				set:true,
				openSettingBtnHidden:true,
				qrParams:{

				}
			}
		},
		components:{
			tkiQrcode
		},
		onShow(){
			_hook.routeSonHook();
			console.log(this.pageParams)
			let _this = this;
			/** 监听新的个人数据 */
			uni.$on('data_user_info',function(data){
				_this.my_data = data;
			});
			uni.$on('update_money_info',function (data) {
				_this.pageParams = data;
				console.log(data)
				if(_this.pageParams.amount)_this.set = false;
			})
			_this.my_data = _data.data('user_info');
		},
		onLoad(options){
			console.log(options)
		},
		computed:{
			qrData(){
				this.pageParams.user_id = this.my_data.id;
				return _page.qrAction.toPage("/pages/my/pay/user_pay",this.pageParams);
			},
			qrPhoto(){
				return _data.data('cache').local_photo;
			},
			myPhoto(){
				return _data.staticPhoto() + this.my_data.photo;
			},

		},
		methods: {
			handleSetting(e){
				if (!e.detail.authSetting['scope.writePhotosAlbum']) {
					this.openSettingBtnHidden = false;
				} else {
					this.openSettingBtnHidden = true;
				}
			},
			saveImgToLocal(){
				//#ifndef H5
				_page.capture();
				//#endif
				//#ifdef H5
				_page.imgPreview([this.img_path],0);
				//#endif
			},
			saveImg(){
				let _this =this;
				params['local'] = this.img_path
				_page.saveMpImg(params,function () {
					_this.openSettingBtnHidden = false;
				},function () {
					uni.showToast({
						title:'保存成功',
						icon:'none'
					})
				})
			},
			qrR(ref){
				this.img_path = ref;
			},
			goPath(path){
				if(!this.set){
					this.pageParams.amount = '';
					this.pageParams.info = '';
					this.set = true;
					return false;
				}
				if(path){
					let _this = this;
					uni.navigateTo({
						url:path,
						success:function () {
						}
					})
				}
			},

		}
	}
</script>

<style>
	.info-amount,.info-text{
		display: flex;
		width: 100%;
		flex: 1;
		align-items: center;
		justify-content: center;
	}
	.info-text{
		color: black;
		font-weight: 400;
		font-size: 16px;
	}
	.content-main-qrCode{
		margin-top: 30upx;
	}
	.amount-set-info .info-amount{
		font-size: 20px;
		font-weight: 600;
		color: black;
		display: flex;
		justify-content: center;
		align-items: center;
		flex-direction: column;
	}
	.content-main-footer{
		display: flex;
		width: 100%;
	}
	.content-main-info{
		margin: 50upx 0 10upx 0;
	}
	.content-main-footer view{
		display: flex;
		justify-content: center;
		align-items: center;
		flex: 1;
		margin: 30upx 0;
		color: #443d80;
	}
	.page{
		display: flex;
		justify-content: center;
		align-items: center;
		width: 100%;
	}
	.content-main{
		color: #c6c6c6;
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
	}
	.content-info{
		border-bottom: 1px solid #d6d6d6;
		display: flex;
		justify-content: start;
		align-items: center;
	}
	.content-info image{
		width: 50upx;
		height: 55upx;
		padding: 20upx;
	}
	.content-info text{
		color: #5691cb;
	}
	.content{
		width: 90%;
		border-radius: 10upx;
		background-color: white;
	}
page{
	/*7197bc*/
	background-color: #5691cb;
}
</style>
