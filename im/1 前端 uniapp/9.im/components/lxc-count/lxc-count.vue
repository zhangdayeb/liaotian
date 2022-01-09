<template>
	<view class="count-box" :class="status ? 'count-box-light' : 'count-box-gray'">
		<view class="count-less count-pub" :class="[myValue <= min ? 'light' : 'gray']" @tap.stop="less"  @longpress='longpressLess' @touchend="handletouchend">-</view>
		<view class="count-add count-pub" :class="[myValue >= max ? 'light' : 'gray']" @tap.stop="add" @longpress='longpressAdd' @touchend="handletouchend">+</view>
		<input type="number" v-model="myValue" @focus="onFocus" @blur="onBlue" class="count-input"/>
	</view>
</template>

<script>
	export default {
		data(){
			return{
				myValue: 0,
				status: false,
				timer: null
			}
		},
		props: {
			// 计数器中的值
			value: {
				type: Number,
				default: 0
			},
			max: {
				type: Number,
				default: 10000
			},
			min: {
				type: Number,
				default: 2
			},
			// 点击当前数据的索引
			index: {
				type: Number
			},
			delayed: {
				type: Number,
				default: 200
			}
		},
		created() {
			this.myValue = this.value
		},
		watch:{
			value(val) {
				this.myValue = val
			}
		},
		methods: {
			onBlue() {
				if(+this.myValue >= this.max) {
					this.myValue = this.max
					this.status = false
				}else if(+this.myValue <= this.min) {
					this.myValue = this.min
					this.status = false
				}else {
					this.status = true
					this.myValue = +this.myValue
				}
				if(!isNaN(this.myValue)) {
					this.$emit('handleCount', this.myValue, this.index)
				}else {
					this.$emit('handleCount', 0, this.index)
				}
				
			},
			onFocus() {
				this.status = true
			},
			add() {
				this.addPublick()
			},
			addPublick() {
				if(this.myValue >= this.max) {
					this.status = false
					this.myValue = this.max
					clearInterval(this.timer)
				}else {
					this.status = true
					this.myValue ++
				}
				this.$emit('handleCount', this.myValue, this.index)
			},
			longpressAdd() {
				this.timer = setInterval(() => {
					this.addPublick()
				}, this.delayed)
			},
			less() {
				this.lessPublick()
			},
			lessPublick() {
				if(this.myValue <= this.min) {
					clearInterval(this.timer)
					this.status = false
					this.myValue = this.min
				}else {
					this.status = true
					this.myValue --
				}
				this.$emit('handleCount', this.myValue, this.index)
			},
			longpressLess() {
				this.timer = setInterval(() => {
					this.lessPublick()
				}, this.delayed)
			},
			handletouchend() {
				clearInterval(this.timer)
			}
		}
	}
</script>
<style>
	.gray{
		background: #eef3f9;
		color: #555555;
	}
	.light{
		background: #f5f7fa;
		color: #C8C7CC;
	}
	.count-box{
		position: relative;
		width: 220rpx;
		height: 60rpx;
		border-radius: 5px;
		z-index: 1;
		transition: all .3s;
	}
	.count-box-light{
		border: 1px solid #add4ff;
	}
	.count-box-gray{
		border: 1px solid #e4e4e4;
	}
	.count-pub{
		position: absolute;
		top: 50%;
		transform: translate(0, -50%);
		width: 60rpx;
		height: 100%;
		text-align: center;
		font-size: 20px;
	}
	.count-less{
		left: 0;
		border-top-left-radius:4px;
		border-bottom-left-radius:4px;
	}
	.count-add{
		right: 0;
		border-top-right-radius:4px;
		border-bottom-right-radius:4px;
	}
	.count-input{
		width: 110rpx;
		height: 100%;
		position: absolute;
		top: 0;
		left: 50%;
		transform: translate(-50%, 0);
		padding: 6rpx 10rpx;
		box-sizing: border-box;
		color: #808080;
		font-size: 26rpx;
		text-align: center;
	}
</style>
