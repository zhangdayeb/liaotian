<template>
	<view class="uni-popup-share">
		<view class="uni-share-title"><text class="uni-share-title-text">{{title}}</text></view>
		<view class="uni-share-content">
			<view class="uni-list-content-box">
				<view class="uni-list-content-item" v-if="bottomData.length" v-for="(item,index) in bottomData" :key="index" @click.stop="select(index,item)">
					<view class="list-left">
						<view class="uni-list-imgview">
							<image class="uni-list-image" :src="item.icon" mode="aspectFill"></image>
						</view>
						<view class="uni-list-info">
							<text class="uni-list-text">{{item.bank_name}}</text>
							<text class="uni-list-text">{{item.bank_info}}</text>
						</view>
						<view class="content">
							<text class="uni-list-content">{{item.account}}</text>
						</view>
					</view>
					<view class="content-img">
						<view :class="[selectList == item.id ? 'check-style-unequal-width' : '']" :data-index="index"></view>
					</view>
				</view>

			</view>
		</view>
		<view class="uni-share-button-box">
		</view>
	</view>
</template>

<script>
	export default {
		name: 'UniPopupList',
		props: {
			title: {
				type: String,
				default: '请选择渠道'
			},
			bottomData: {
				type: Array,
				default:function () {
					return  [];
				}
			},
			selectIndex:{
				type:Number,
				default:0
			},
			selectList:{
				type:Number,
				default:0
			}
		},
		inject: ['popup'],
		data() {
			return {
			}
		},
		created() {},
		methods: {
			/**
			 * 选择内容
			 */
			select(index,item) {
				this.$emit('select', item, () => {
					this.popup.close()
				})
			},
			checked(){

			},
			/**
			 * 关闭窗口
			 */
			close() {
				this.popup.close()
			}
		}
	}
</script>
<style lang="scss" scoped>
	.list-left{
		width: 80%;
		display: flex;
		flex-direction: row;
		justify-content: space-around;
	}
	.uni-list-imgview{
		display: flex;
		justify-content: center;
		align-items: center;
	}
	.uni-popup-share {
		background-color: #fff;
	}
	.content-img{
		width: 20%;
	}
	.content ,.content-img{
		display: flex;
		justify-content: center;
		align-items: center;
	}
	.uni-list-info{
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
	}
	.uni-share-title {
		/* #ifndef APP-NVUE */
		display: flex;
		/* #endif */
		flex-direction: row;
		align-items: center;
		justify-content: center;
		height: 120rpx;
		border-bottom: 1px solid #eaeaea;
		color: #000000;
	}
	.uni-share-title-text {
		font-size: 14px;
		color: #666;
	}
	.uni-share-content {
		/* #ifndef APP-NVUE */
		display: flex;
		/* #endif */
		flex-direction: row;
		justify-content: center;
	}
	.check-style-unequal-width {
		width:8px;

		height:18px;

		border-color:#85b3e7;

		border-style:solid;

		border-width:0 2px 2px 0;

		transform:rotate(45deg);
	}
	.uni-list-content-box {
		/* #ifndef APP-NVUE */
		display: flex;
		/* #endif */
		flex-direction: column;
		flex-wrap: nowrap;
		width: 100%;
	}
	
	.uni-list-content-item {
		/* #ifndef APP-NVUE */
		display: flex;
		/* #endif */
		flex-direction: row;
		align-items: center;
		padding: 20rpx;
		border-bottom: 1px solid #eaeaea;
		color: #000000;
	}

	
	.uni-share-content-item:active {
		background-color: #f5f5f5;
	}
	
	.uni-list-image {
		width: 30px;
		height: 30px;
	}
	
	.uni-list-text {
		font-size: 14px;
		color: #3B4144;
	}
	
	.uni-share-button-box {
		/* #ifndef APP-NVUE */
		display: flex;
		/* #endif */
		flex-direction: row;
		padding: 10px 15px;
	}
	
	.uni-share-button {
		flex: 1;
		border-radius: 50px;
		color: #666;
		font-size: 16px;
	}
	
	.uni-share-button::after {
		border-radius: 50px;
	}
</style>
