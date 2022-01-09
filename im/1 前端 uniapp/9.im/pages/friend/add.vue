<template>
	<view class="page">	
		<view class="header">
			<view class="input-view">
				<uni-icon type="search" size="22" color="#666666"></uni-icon>
				<input class="input" type="text" placeholder="好友的用户名\邮箱\手机" @input="handleInput" :focus="true" />
			</view>
		</view>
		<view class="search-main" v-if="keyword">
			<view class="search-main-errtitle" v-if="hasNoData">无搜索结果</view>
			<view class="uni-list">
				<view class="uni-list-cell" hover-class="none" v-for="(item,index) of list" @tap="handleClick(item.id)" :key="index">
					<view class="uni-media-list">
						<view class="uni-media-list-logo">
							<image :src="staticPhoto + item.photo" :lazy-load="true"></image>
						</view>
						<view class="uni-media-list-body">
							<view class="uni-list-cell-navigate">{{item.nickname}}</view>
						</view>
					</view>
				</view>
			</view>
		</view>
	</view>		
</template>

<script>
	
	import uniIcon from '../../components/uni-ui/uni-icon/uni-icon.vue';
	import _get from '../../common/_get';
	import _hook from '../../common/_hook';
	import _data from '../../common/_data';
	
	export default {
		components:{
			uniIcon
		},
		data() {
			return {
				is_type: 0,
				keyword: '',
				list: [],
				timer: null
			}
		},
		onShow(){
			_hook.routeSonHook();
		},
		computed:{
			hasNoData () {
				return !this.list.length;
			},
			staticPhoto(){
				return _data.staticPhoto();
			},
		},
		watch:{
			keyword (new_val,old_val) {
				let _this = this;
				if(_this.timer) {
					clearTimeout(_this.timer);
				}
				if(!new_val){
					_this.list = [];
					return
				}
				_this.timer = setTimeout(() => {
					_this.$httpSend({
						path: '/im/get/searchUser',
						data: { val: new_val },
						success(data) {
							_this.list = data.data;
							_this.is_type = data.is_type;
						}
					});
				},100);
			}
		},
		methods:{
			handleInput (e) {
				this.keyword = e.detail.value
			},
			handleClick (id) {
				uni.navigateTo({
					url: ('../details/index?user_id=' + id + '&is_type=' + this.is_type),
				});
			}
		}
	}
</script>

<style>
	
	.search-main {
		height: 100%;
		padding-bottom: 20upx;
		background-color:#fff;
		overflow: hidden;
	}
	
	.search-main-errtitle {
		width: 100%;
		height: 92upx;
		line-height: 92upx;
		font-size: 32upx;
		padding: 0 20upx;
		border-bottom: 1px solid #e5e5e5;
	}
	
	.header {
		display: flex;
		flex-direction: row;
		padding: 10px 15px;
		align-items: center;
	}
	
	.input-view {
		display: flex;
		align-items: center;
		flex-direction: row;
		background-color: #e7e7e7;
		height: 30px;
		border-radius: 5px;
		padding: 0 10px;
		flex: 1;
	}
	
	.input {
		flex: 1;
		padding: 0 5px;
		height: 24px;
		line-height: 24px;
		font-size: 16px;
	}

</style>