<template>
	<view>
		<!--<view class="tabr">-->
			<!--<view :class="{on:typeClass=='luck'}" @tap="switchType('luck')">拼手气红包</view><view :class="{on:typeClass=='normal'}"  @tap="switchType('normal')">普通红包</view>-->
			<!--<view class="border" :class="typeClass"></view>-->
		<!--</view>-->
		<view class="content" :class="typeClass">
			<view class="luck">
				<view class="row">
					<view class="term">
						红包个数
					</view>
					<view class="input">
						<input type="number" v-model="number" placeholder="输入红包个数"  /> 个
					</view>
				</view>
				<view class="row">
					<view class="term">
						总金额
					</view>
					<view class="input">
						<input type="number" v-model="luckMoney" placeholder="输入金额" /> 元
					</view>
				</view>
				<view class="tis">
					小伙伴领取的金额随机
				</view>
				<view class="blessing">
					<input type="text" maxlength="12" placeholder="恭喜发财" v-model="blessing"  />
				</view>
				<view class="hand" @tap="hand('luck')">
					发红包
				</view>
			</view>
			<view class="normal">
				<view class="row">
					<view class="term">
						红包个数
					</view>
					<view class="input">
						<input type="number" :disabled="disable" v-model="number" placeholder="输入红包个数" /> 个
					</view>
				</view>
				<view class="row">
					<view class="term">
						单个金额
					</view>
					<view class="input">
						<input type="number" v-model="money" placeholder="输入金额" /> 元
					</view>
				</view>
				<view class="tis">
					小伙伴领取的金额相同
				</view>
				<view class="blessing">
					<input type="text" maxlength="12" placeholder="恭喜发财" v-model="blessing"  />
				</view>
				<view class="hand" @tap="hand('normal')">
					发红包
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	import _get from '../../../common/_get';
	import _hook from '../../../common/_hook';
	import _page from '../../../common/common';
	export default {
		data() {
			return {
				typeClass:'luck',//normal
				number:'',
				money:'',
				luckMoney:'',
				blessing:'',
				click:true,
				disable:false,
				page_params:{}
			};
		},
		onLoad(options) {
			let _this = this;
			_this.page_params = options;
			if(_this.page_params.msg_type == 1){
				this.typeClass = 'luck';
			}else {
				_this.number = 1;
				_this.disable = true;
				this.typeClass = 'normal';
			}
		},
		onShow(){
			_hook.routeTabBarHook();
			// uni.$on('get_password_reslut',this.getPassword);
		},
		methods:{
			switchType(type){
				if(this.page_params.msg_type == 1){
					return false;
				}
				this.typeClass = type;
			},
			hand(type){
				//校验余额判断有无设置交易密码
				let _this = this;
				let redEnvelopeData = {
					type:(type == 'luck' ? 2 : 1),
					num:this.number,
					hongbao_msg:this.blessing,
					amount:this.money
				}
				if(type == 'luck'){
					redEnvelopeData.amount = this.luckMoney;
				}
				//判断数据有效性
				if((!redEnvelopeData.amount)||redEnvelopeData.amount<=0)
				{
					return uni.showToast({title:"金额不能为空",icon:'none'});
				}
				if(redEnvelopeData.num!=Math.abs(parseInt(redEnvelopeData.num))){
					return uni.showToast({title:"数量填写大于0的整数",icon:'none'});
				}
				redEnvelopeData.hongbao_msg = redEnvelopeData.hongbao_msg||'恭喜发财';//没填写则默认恭喜发财
				redEnvelopeData = Object.assign(this.page_params,redEnvelopeData);
				_get.checkBeforePay(redEnvelopeData,function (res) {
					_get.createLeiHongBao(redEnvelopeData,function (res) {
						uni.navigateTo({url:'../message?list_id='+_this.page_params.list_id})
					},function (res) {
						_this.click = true;
						uni.showToast({title:res.msg,icon:'none'});
					})
				},function (res) {
					uni.showToast({title:res.msg,icon:'none'});
				});


			},
			getPassword(n) {
				console.log("参数传递", n);
				let _this = this;
				if(!_this.click) return false;
				_this.click = false;
				//此处实际应用时应该post到服务器，然后服务器广播长连接
				uni.showLoading({title:'提交中'});
				_get.createHongBao(n,function (res) {
						uni.navigateTo({url:'../message?list_id='+_this.page_params.list_id})
				},function (res) {
					_this.click = true;
				})
				// this.$refs.payKeyboard.cleanNum();
			}
		}
	}
</script>

<style lang="scss">
	page{
		background-color: #f3f3f3;
	}
	view{
		display: flex;
		flex-wrap: wrap;
	}
	.tabr{
		width: 94%;
		height: 105upx;
		padding: 0 3%;
		border-bottom: solid 1upx #dedede;
		view{
			width: 50%;
			height: 100upx;
			justify-content: center;
			align-items: center;
			font-size: 28upx;
			color: #999;
		}
		.on{
			color: #cf3c35;
		}
		.border{
			height: 4upx;
			background-color: #cf3c35;
			transition: all .3s ease-out;
			&.normal{
				transform: translate3d(100%,0,0);
			}
		}
		
	}
	.content{
		width: 100%;
		height: 80vh;
		overflow: hidden;
		&.normal{
			.luck{
				transform: translate3d(-100%,0,0);
			}
			.normal{
				transform: translate3d(0,-100%,0);
			}
		}
		.luck,.normal{
			
			transition: all .3s ease-out;
		}
		.luck{
			
		}
		.normal{
			transform: translate3d(100%,-100%,0);
		}
		.row,.tis,.blessing,.hand{
			width: 94%;
		}
		.row,.tis,.blessing{
			border-bottom: #dedede solid 1upx;
		}
		.row,.blessing{
			padding: 0 3%;
			background-color: #fff;
		}
		.row,.blessing,.hand{
			height: 100upx;
			align-items: center;
		}
		.row{
			justify-content: space-between;
			flex-wrap: nowrap;
			.term,.input{
				width: 50%;
			}
			.input{
				flex-shrink: 0;
				flex-wrap: nowrap;
				justify-content: flex-end;
				align-items: center;
				input{
					height: 50upx;
					display: flex;
					justify-content: flex-end;
					align-items: center;
					text-align: right;
					margin-right: 20upx;
					font-size: 30upx;
				}
			}
		}
		.tis{
			height: 60upx;
			padding: 20upx 3%;
			font-size: 30upx;
			color: #999;
		}
		.blessing{
			input{
				width: 100%;
				height: 50upx;
				font-size: 32upx;
			}
		}	
		.hand{
			margin: 30upx 3%;
			background-color: #cf3c35;
			color: #fff;
			font-size: 34upx;
			justify-content: center;
			border-radius: 10upx;
			height: 90upx;
		}
	}
		
</style>
