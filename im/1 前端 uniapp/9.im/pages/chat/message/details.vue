<template>
	<view>
		<view class="top">
			<view class="blessing">
				{{hong_bao_detail.msg}}
			</view>
			<view class="money" v-if="user_get.money">
				{{user_get.money}}
			</view>
			<view class="face" :style="{'border-radius':radius}">
				<image :src="staticPhoto + own_user_info.face" :lazy-load="true"></image>
			</view>
			<view class="username">
				{{own_user_info.nickname}}的红包
			</view>
		</view>
		<view class="info">
			已领取{{hong_bao_detail.number - hong_bao_detail.sy_number}}/{{hong_bao_detail.number }}个，共{{(hong_bao_detail.money - hong_bao_detail.sy_money).toFixed(2)}}/{{hong_bao_detail.money}}元
		</view>
		<view class="list">
			<view class="row" v-for="(row,index) in list" :key="index">
				<view class="left">
					<image :src="staticPhoto+row.user_info.face"></image>
				</view>
				<view class="right">
					<view class="r1">
						<view class="username">
							{{row.user_info.username}}
						</view>
						<view class="money">
							{{row.money}}元
						</view>
					</view>
					<view class="r2">
						<view class="time">
							{{row.time}}
						</view>
						<view class="lucky" v-if="row.is_best">
							手气王
						</view>
					</view>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	import _get from '../../../common/_get';
	import _hook from '../../../common/_hook';
	import _data from '../../../common/_data';
	export default {
		data() {
			return {
				hong_bao_detail:{},
				user_get:{},
				own_user_info:{},
				list:{},
				blessing:"恭喜发财",
				money:0.01,
				username:"大黑哥",
				receivedNumber:8,
				SumNumber:10,
				receivedMoney:5.43,
				SumMoney:10,
				receivedList:[
					{username:"大黑哥", face:"/static/img/im/face/face_6.jpg",time:"2019-04-12 12:54:12",money:0.01,islucky:false},
					{username:"路人甲", face:"/static/img/im/face/face_5.jpg",time:"2019-04-12 12:54:13",money:1.82,islucky:true},
					{username:"高级黑", face:"/static/img/im/face/face_4.jpg",time:"2019-04-12 12:55:10",money:0.23,islucky:false},
					{username:"低级黑", face:"/static/img/im/face/face_3.jpg",time:"2019-04-12 12:56:10",money:0.56,islucky:false},
					{username:"大明哥", face:"/static/img/im/face/face_2.jpg",time:"2019-04-12 12:56:15",money:0.96,islucky:false},
					{username:"小姐姐", face:"/static/img/im/face/face_1.jpg",time:"2019-04-12 12:56:17",money:1.02,islucky:false},
					{username:"大哥哥", face:"/static/img/im/face/face_7.jpg",time:"2019-04-12 12:56:19",money:0.05,islucky:false},
					{username:"抢红包", face:"/static/img/im/face/face_8.jpg",time:"2019-04-12 12:56:22",money:0.78,islucky:false}
				],
				//动画效果
				radius:'100% 100% 0 0',
				pageParams:{

				}
			};
		},
		computed:{
			staticPhoto() {
				return _data.staticPhoto();
			},
		},
		onShow(){
			let _this = this;
			_hook.routeSonHook();
			_get.getHongBaoDetail(_this.pageParams,function (res) {
				_this.list = res.list;
				_this.own_user_info = res.own_user_info;
				_this.hong_bao_detail = res.hong_bao_detail;
				_this.user_get = res.user_get;
			});
		},
		onLoad(options) {
			let _this = this;
			_this.pageParams = options
		},
		onPageScroll(e) {
			//e.scrollTop;
			if(e.scrollTop>100){return;}
			let radiusTmp = 100 - e.scrollTop;
			this.radius = radiusTmp+'% '+radiusTmp+'% 0 0';
		}
	}
</script>

<style lang="scss">
	view{
		display: flex;
		flex-wrap: wrap;
	}
	.top{
		width: 100%;
		background-color: #cf3c35;
		flex-wrap: wrap;
		.blessing,.money{
			width: 100%;
			color: #f8d757;
			padding: 20upx 0;
			justify-content: center;
			font-size: 34upx;
		}
		.money{
			font-size: 100upx;
		}
		.face{
			background-color: #fff;
			justify-content: center;
			width: 100%;
			height: 130upx;
			margin-top: 65upx;
			border-radius: 100% 100% 0 0;
			transition: border-radius .15s;
			image{
				width: 130upx;
				height: 130upx;
				border-radius: 100%;
				margin-top: -65upx;
			}
		}
		.username{
			width: 100%;
			justify-content: center;
			background-color: #fff;
			margin-top: -50upx;
			font-size: 38upx;
		}
	}
	.info{
		margin-top: 30upx;
		width: 96%;
		height: 50upx;
		padding-left: 4%;
		font-size: 28upx;
		color: #999;
		border-bottom: solid 1upx #dfdfdf;
	}
	.list{
		width: 100%;
		.row{
			width: 92%;
			padding: 0 4%;
			height: 120upx;
			border-bottom: solid 1upx #dfdfdf;
			justify-content:flex-start;
			flex-wrap: nowrap;
			.left{
				flex-shrink: 0;
				width: 100upx;
				height: 120upx;
				justify-content: flex-start;
				align-items: center;
				image{
					width: 80upx;
					height: 80upx;
					border-radius: 100%;
				}
			}
			.right{
				width: 100%;
				height: 150upx;
				
				.r1{
					width: 100%;
					height: 75upx;
					justify-content: space-between;
					align-items: center;
					font-size: 34upx;
				}
				.r2{
					width: 100%;
					height: 75upx;
					justify-content: space-between;
					font-size: 26upx;
					.time{
						color: #8F8F94;
					}
					.lucky{
						padding: 3upx 8upx;
						border-radius: 5upx;
						background-color: #F8D757;
						align-items: center;
						height: 30upx;
						font-size: 24upx;
						color: #CF3C35;
					}
				}
			}
		}
	}
</style>
