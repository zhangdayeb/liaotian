<template>
	<view>

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
						<input type="number" v-model="luckMoney"  placeholder="输入金额" /> 元
					</view>
				</view>
				<view class="row">
					<view class="term">
						红包雷值
					</view>
					<view class="input">
						<input type="number" disabled="true" placeholder="请点击下方选择雷值" v-if="!lei.length"/>
						<view class="lei-content" v-if="lei.length">
							<view class="input-num" v-for="(item,index) in lei">{{item}}</view>
						</view>

				</view>
				</view>
				<view class="tis">
					* 提示再次点击选中的雷为取消
				</view>
				<view class="blessing">
					<view :class="['input-num-select',selected_num0 ? ' active': '']" @tap="taptLei(0)">0</view>
					<view :class="['input-num-select',selected_num1 ? ' active': '']" @tap="taptLei(1)">1</view>
					<view :class="['input-num-select',selected_num2 ? ' active': '']" @tap="taptLei(2)">2</view>
					<view :class="['input-num-select',selected_num3 ? ' active': '']" @tap="taptLei(3)">3</view>
					<view :class="['input-num-select',selected_num4 ? ' active': '']" @tap="taptLei(4)">4</view>
					<view :class="['input-num-select',selected_num5 ? ' active': '']" @tap="taptLei(5)">5</view>
					<view :class="['input-num-select',selected_num6 ? ' active': '']" @tap="taptLei(6)">6</view>
					<view :class="['input-num-select',selected_num7 ? ' active': '']" @tap="taptLei(7)">7</view>
					<view :class="['input-num-select',selected_num8 ? ' active': '']" @tap="taptLei(8)">8</view>
					<view :class="['input-num-select',selected_num9 ? ' active': '']" @tap="taptLei(9)">9</view>
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
						<input type="number" v-model="number" placeholder="输入红包个数" /> 个
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
				lei:[],
				page_params:{},
				selected_num0:false,
				selected_num1:false,
				selected_num2:false,
				selected_num3:false,
				selected_num4:false,
				selected_num5:false,
				selected_num6:false,
				selected_num7:false,
				selected_num8:false,
				selected_num9:false,
			};
		},
		onLoad(options) {
			let _this = this;
			_this.page_params = options;
		},
		onShow(){
			_hook.routeTabBarHook();
			// uni.$on('get_password_reslut',this.getPassword);
		},
		computed:{

		},
		methods:{
			deleteNum(i){
				var index = this.lei.indexOf(i);
				this.lei.splice(index, 1)
			},
			taptLei(num){
				switch (num) {
					case 0:
						if(this.selected_num0){
							 this.deleteNum(num)
							return this.selected_num0 = false;
						}else {
							this.lei.push(num)
							return this.selected_num0 = true;
						}

					case 1:
						if(this.selected_num1){
							this.deleteNum(num)
							return this.selected_num1 = false;
						}else {
							this.lei.push(num)
							return this.selected_num1 = true;
						}

					case 2:
						if(this.selected_num2){
							 this.deleteNum(num)
							return this.selected_num2 = false;
						}else {
							this.lei.push(num)
							return this.selected_num2 = true;
						}

					case 3:
						if(this.selected_num3){
							 this.deleteNum(num)
							return this.selected_num3 = false;
						}else {
							this.lei.push(num)
							return this.selected_num3 = true;
						}

					case 4:
						if(this.selected_num4){
							 this.deleteNum(num)
							return this.selected_num4 = false;
						}else {
							this.lei.push(num)
							return this.selected_num4 = true;
						}

					case 5:
						if(this.selected_num5){
							 this.deleteNum(num)
							return this.selected_num5 = false;
						}else {
							this.lei.push(num)
							return this.selected_num5 = true;
						}

					case 6:
						if(this.selected_num6){
							 this.deleteNum(num)
							return this.selected_num6 = false;
						}else {
							this.lei.push(num)
							return this.selected_num6 = true;
						}

					case 7:
						if(this.selected_num7){
							 this.deleteNum(num)
							return this.selected_num7 = false;
						}else {
							this.lei.push(num)
							return this.selected_num7 = true;
						}

					case 8:
						if(this.selected_num8){
							 this.deleteNum(num)
							return this.selected_num8 = false;
						}else {
							this.lei.push(num)
							return this.selected_num8 = true;
						}

					case 9:
						if(this.selected_num9){
							 this.deleteNum(num)
							return this.selected_num9 = false;
						}else {
							this.lei.push(num)
							return this.selected_num9 = true;
						}


				}
			},
			switchType(type){
						this.typeClass = type;
			},
			hand(type){
				//校验余额判断有无设置交易密码
                let _this = this;
				let redEnvelopeData = {
					type:2, //拼手气红包
					num:this.number,
					hongbao_msg:this.lei,
					amount:this.money
				}
				if(type == 'luck'){
					redEnvelopeData.amount = this.luckMoney;
				}
				if(_this.lei.length <= 0){
                    return uni.showToast({title:"请选择红包雷",icon:'none'});
                }
				//判断数据有效性
				if((!redEnvelopeData.amount)||redEnvelopeData.amount<=0)
				{
					return uni.showToast({title:"金额不能为空",icon:'none'});
				}
				if(redEnvelopeData.num!=Math.abs(parseInt(redEnvelopeData.num))){
					return uni.showToast({title:"数量填写大于0的整数",icon:'none'});
				}
				redEnvelopeData.hongbao_msg = JSON.stringify(redEnvelopeData.hongbao_msg)||'恭喜发财';//没填写则默认恭喜发财
				redEnvelopeData = Object.assign(this.page_params,redEnvelopeData);
				_get.checkBeforePay(redEnvelopeData,function (res) {
                    _get.createLeiHongBao(redEnvelopeData,function (res) {
                        uni.navigateTo({url:'../message?list_id='+_this.page_params.list_id})
                    },function (res) {
                        _this.click = true;
                        uni.showToast({title:res.msg,icon:'none'});
                    })
				},function (res) {
					console.log("fail callback")
					uni.showToast({title:res.msg,icon:'none'});
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
				_get.createLeiHongBao(n,function (res) {
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
			padding: 30upx;
			background-color: #fff;
			display: flex;
			justify-items: center;
			justify-content: center;
		}
		.row,.hand{
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
		.input-lei {
			flex-shrink: 0;
			flex-wrap: nowrap;
			justify-content: flex-end;
			align-items: center;
			text{
				height: 50upx;
				display: flex;
				justify-content: flex-start;
				align-items: center;
				text-align: left;
				margin-right: 20upx;
				font-size: 30upx;
			}
		}
		.tis{
			height: 60upx;
			padding: 20upx 3%;
			font-size: 16px;
			color: red;
		}
		.hand{
			margin: 30upx 3%;
			background-color: #cf3c35;
			color: #fff;
			font-size: 34upx;
			justify-content: center;
			border-radius: 10upx;
			height: 100upx;
		}
		.input-num{
			width: 20px;
			height: 20px;
			font-size: 12px;
			font-weight: 700;
			line-height: 20px;
			text-align: center;
			background: url('/static/theme/default/chat/lei1.png') no-repeat;
			background-size: 100% 100%;
			display: inline-block;
			margin-left: 5px;
		}
	}
	.input-num-select{
		display: inline-block;
		width: 50px;
		height: 50px;
		line-height: 50px;
		text-align: center;
		border-radius: 100%;
		background: #fff;
		font-size: 18px;
		font-weight: 700;
		margin: 0 9px 10px 0;
		background: url('/static/theme/default/chat/lei1.png') no-repeat;
		background-size: 100% 100%;
	}
	.input-num-select:nth-child(2n){ //双号的球换图片
		background: url('/static/theme/default/chat/lei2.png') no-repeat !important;
		background-size: 100% 100% !important;
	}
	.lei-content{
		display: flex;
		word-break: break-all;
		width: 300rpx;
		justify-content: flex-end;
	}
	.blessing .active{
		background: url('/static/theme/default/chat/lei3.png') no-repeat !important;
		background-size: 100% 100% !important;
	}
		
</style>
