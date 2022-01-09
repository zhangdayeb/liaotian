<template>
	<view class="container">
		<view class="ui-all">
			<view class="ui-list">
				<text>发包数量</text>
				<input type="text" placeholder="请点击选择雷的数量" :data-index ="info.selectNum" disabled="true" :value="info.lei_msg" @tap="getNum" placeholder-class="place" />
				<lb-picker :list="list" ref="picker" @confirm="confirm"></lb-picker>
			</view>
			<view class="ui-list">
				<text>发包金额</text>
				<input type="number" placeholder="输入发包金额"    @input="amount1"  :value="info.amount" placeholder-class="place" />
			</view>
			<view class="ui-list" v-if="info.selectNum >= 5">
				<text>单雷赔率</text>
				<input type="number" :placeholder="value" :value="info.lei1" @input="lei1" placeholder-class="place" />
				<input type="number" placeholder="请输入福利奖励" :value="info.fuli1" @input="fuli1" placeholder-class="place" />
			</view>
			<view class="ui-list" v-if="info.selectNum >=7">
				<text>双雷赔率</text>
				<input type="number" :placeholder="value" :value="info.lei2" @input="lei2" placeholder-class="place" />
				<input type="number" placeholder="请输入福利奖励" :value="info.fuli2" @input="fuli2" placeholder-class="place" />
			</view>
			<view class="ui-list" v-if="info.selectNum >= 7">
				<text>三雷赔率</text>
				<input type="number" :placeholder="value" :value="info.lei3" @input="lei3" placeholder-class="place" />
				<input type="number" placeholder="请输入福利奖励" :value="info.fuli3" @input="fuli3" placeholder-class="place" />
			</view>
			<view class="ui-list" v-if="info.selectNum >= 7">
				<text>四雷赔率</text>
				<input type="number" :placeholder="value" :value="info.lei4" @input="lei4" placeholder-class="place" />
				<input type="number" placeholder="请输入福利奖励" :value="info.fuli4" @input="fuli4" placeholder-class="place" />
			</view>
			<view class="ui-list" v-if="info.selectNum >= 8">
				<text>五雷赔率</text>
				<input type="number" :placeholder="value" :value="info.lei5" @input="lei5" placeholder-class="place" />
				<input type="number" placeholder="请输入福利奖励" :value="info.fuli5" @input="fuli5" placeholder-class="place" />
			</view>
			<view class="ui-list" v-if="info.selectNum == 9">
			<text>六雷赔率</text>
				<input type="number" :placeholder="value" :value="info.lei6" @input="lei6" placeholder-class="place" />
				<input type="number" placeholder="请输入福利奖励" :value="info.fuli6" @input="fuli6" placeholder-class="place" />
			</view>
			<view class="ui-list">
				<text>是否开启</text>
				<switch :checked="checked" @change="switch1Change" />
			</view>
			<!--<view class="ui-list" v-if="info.selectNum >= 7">-->
				<!--<text>七雷赔率</text>-->
				<!--<input type="number" :placeholder="value" :value="info.lei7" @input="lei7" placeholder-class="place" />-->
				<!--<input type="number" placeholder="请输入福利奖励" :value="info.lei1" @input="lei1" placeholder-class="place" />-->
			<!--</view>-->
			<!--<view class="ui-list" v-if="info.selectNum >= 8">-->
				<!--<text>八雷赔率</text>-->
				<!--<input type="number" :placeholder="value" :value="info.lei8" @input="lei8" placeholder-class="place" />-->
				<!--<input type="number" placeholder="请输入福利奖励" :value="info.lei1" @input="lei1" placeholder-class="place" />-->
			<!--</view>-->
			<!--<view class="ui-list" v-if="info.selectNum >= 9">-->
				<!--<text>九雷赔率</text>-->
				<!--<input type="number" :placeholder="value" :value="info.lei9" @input="lei9" placeholder-class="place" />-->
				<!--<input type="number" placeholder="请输入福利奖励" :value="info.lei1" @input="lei1" placeholder-class="place" />-->
			<!--</view>-->
			<view class="save-info">
				<button class="save" @tap="savaInfo(1)">确认</button>

			</view>

		</view>

	</view>
</template>

<script>
	import LbPicker from '@/components/lb-picker'
	export default {
		name:'cUserinfo',
		props:{
			info:{
				type: Object,
				default:()=>{
					return {
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
						status:1,
						amount:100
					}
				}
			}
		},
		data() {
			return {
				value: '请输入赔率',
				list: [
					{
						label: '9包',
						value: 9,
					},
					{
						label: '8包',
						value: 8,
					},
					{
						label: '7包',
						value: 7,
					},
					{
						label: '6包',
						value: 6,
					},
					{
						label: '5包',
						value: 5,
					}
				],
				lei_select:9,
				checked:true,
			}

		},
		components:{
			LbPicker
		},
		computed:{

		},
		methods: {
			setStatus(status){
				if(status == 1){
					this.checked = true
				}else {
					console.log(111111)
					this.checked = false
				}
			},
			amount1(e){
				this.info.amount= e.detail.value;
			},
			lei1(e){
				this.info.lei1= e.detail.value;
			},
			lei2(e){
				this.info.lei2= e.detail.value;
			},
			lei3(e){
				this.info.lei3= e.detail.value;
			},
			lei4(e){
				this.info.lei4= e.detail.value;
			},
			lei5(e){
				this.info.lei5= e.detail.value;
			},
			lei6(e){
				this.info.lei6= e.detail.value;
			},
			getNum(){
				this.$refs.picker.show()
			},
			fuli1(e){
				this.info.fuli1= e.detail.value;
			},
			fuli2(e){
				this.info.fuli2= e.detail.value;
			},
			fuli3(e){
				this.info.fuli3= e.detail.value;
			},
			fuli4(e){
				this.info.fuli4= e.detail.value;
			},
			fuli5(e){
				this.info.fuli5= e.detail.value;
			},
			fuli6(e){
				this.info.fuli6= e.detail.value;
			},
			confirm(e){
				this.info.lei_msg = e.item.label;
				this.info.selectNum = e.item.value;
			},
			switch1Change(e){
				if(e.detail.value){
					this.info.status = 1
				}else {
					this.info.status = 0
				}
			},
			savaInfo(val){
				let key = 'bao'+this.info.selectNum
				this.$emit('saveConfig',this.info)
			}
		},
		onLoad() {			
		}

	}
</script>

<style lang="less">
	.container {
		display: block;
	}

	.ui-all {
		padding: 20rpx 40rpx;

		.avatar {
			width: 100%;
			text-align: left;
			padding: 20rpx 0;
			border-bottom: solid 1px #f2f2f2;
			position: relative;

			.imgAvatar {
				width: 140rpx;
				height: 140rpx;
				border-radius: 50%;
				display: inline-block;
				vertical-align: middle;
				overflow: hidden;

				.iavatar {
					width: 100%;
					height: 100%;
					display: block;
				}
			}

			text {
				display: inline-block;
				vertical-align: middle;
				color: #8e8e93;
				font-size: 28rpx;
				margin-left: 40rpx;
			}

			&:after {
				content: ' ';
				width: 20rpx;
				height: 20rpx;
				border-top: solid 1px #030303;
				border-right: solid 1px #030303;
				transform: rotate(45deg);
				-ms-transform: rotate(45deg);
				/* IE 9 */
				-moz-transform: rotate(45deg);
				/* Firefox */
				-webkit-transform: rotate(45deg);
				/* Safari 和 Chrome */
				-o-transform: rotate(45deg);
				position: absolute;
				top: 85rpx;
				right: 0;
			}
		}

		.ui-list {
			width: 100%;
			text-align: left;
			padding: 20rpx 0;
			border-bottom: solid 1px #f2f2f2;
			position: relative;

			text {
				color: #4a4a4a;
				font-size: 28rpx;
				display: inline-block;
				vertical-align: middle;
				min-width: 150rpx;
			}

			input {
				color: #030303;
				font-size: 30rpx;
				display: inline-block;
				vertical-align: middle;
				width: 30%;
			}
			button{
				color: #030303;
				font-size: 30rpx;
				display: inline-block;
				vertical-align: middle;
				background: none;
				margin: 0;
				padding: 0;
				&::after{
					display: none;
				}
			}
			picker {
				width: 90%;
				color: #030303;
				font-size: 30rpx;
				display: inline-block;
				vertical-align: middle;
				position: absolute;
				top: 30rpx;
				left: 150rpx;
			}

			textarea {
				color: #030303;
				font-size: 30rpx;
				vertical-align: middle;
				height: 150rpx;
				width: 100%;
				margin-top: 50rpx;
			}

			.place {
				color: #999999;
				font-size: 28rpx;
			}
		}

		.right:after {
			content: ' ';
			width: 20rpx;
			height: 20rpx;
			border-top: solid 1px #030303;
			border-right: solid 1px #030303;
			transform: rotate(45deg);
			-ms-transform: rotate(45deg);
			/* IE 9 */
			-moz-transform: rotate(45deg);
			/* Firefox */
			-webkit-transform: rotate(45deg);
			/* Safari 和 Chrome */
			-o-transform: rotate(45deg);
			position: absolute;
			top: 40rpx;
			right: 0;
		}

		.save {
			background: #5693ee;
			border: none;
			color: #ffffff;
			margin-top: 40rpx;
			font-size: 28rpx;
			width: 100% !important;
		}
		.save-info{
			display: flex;
			justify-items: center;
			align-items: center;
		}
	}
</style>
