<template>
	<view class="page">
		
		<uni-list v-if="friend_apply_list.length">
			<view v-for="(value,key) in friend_apply_list" @longtap.stop="listAction(value.id+'',key+0)" :key="key">   
				<view class="uni-media-list btm_border"  @tap="goPath(value.user_id)">
					<view class="uni-media-list-logo">
				    	<image :src="staticPhoto + value.photo" class="img-icon" />
				    	
				    </view>
				    <view class="uni-media-list-body">
				    	<view class="uni-list-cell-navigate">{{value.nickname}}</view>
						<view class="uni-list-cell-navigate content">{{value.content}}</view>
				    </view>
					<view >
						<view class="badge-text"><text>{{value.text}}</text></view>
						<view ><text>&nbsp;</text></view>
					</view>
				</view>		   
			</view>
			
		</uni-list>		
		<uni-load-more status="noMore" v-if="noMore"/>
	</view>
</template>

<script>
	
	import uniList from '../../components/uni-ui/uni-list/uni-list.vue';
	import uniListItem from '../../components/uni-ui/uni-list-item/uni-list-item.vue';
	import uniLoadMore from "../../components/uni-ui/uni-load-more/uni-load-more.vue";
	import _get from '../../common/_get';
	import _hook from '../../common/_hook';
	import _data from '../../common/_data';
	
	export default {
		components: {
			uniList,
			uniListItem,
			uniLoadMore,
		},
		data() {
			return {
				noMore: 0,
				friend_apply_list: [],
				action: 0,
			}
		},
		onShow(){
			_hook.routeSonHook();
			
			let friend_apply_list = _data.localData('friend_apply_list'),
				_this = this;
				
			/** 监听最新数据 */
			uni.$on('data_friend_apply_list',function(data){
				_this.friend_apply_list = data;
			});

			/** 加载本地缓存数据,如果有新的朋友申请,更新本地数据 */
			if(friend_apply_list && _this.action == 0){
				_this.friend_apply_list = friend_apply_list;
			}else{
				_get.getFriendApplyList((data) => {
					if(data.length < 1){
						_this.noMore = 1;
					}
				});
			}
		},
		onLoad(option) {
			this.action = option.action;
		},
		onUnload(){
			uni.$off('data_friend_apply_list');
		},
		computed: {
			staticPhoto(){
				return _data.staticPhoto();
			},
		},
		methods: {
			listAction(id,key){
				let _this = this;
				uni.showActionSheet({
					itemList: [ '删除', ],
					success: function (res) {
						switch (res.tapIndex){
							case 0:
								uni.showModal({
									title: '提示',
									content: '确定删除这条好友申请记录吗？',
									success: function (res) {
										if (res.confirm) {
											_this.$httpSend({
												path: '/im/friend/removeApply',
												data: { id },
												success(res) {
													_this.friend_apply_list.splice(key,1);
													_data.localData('friend_apply_list',_this.friend_apply_list);
													uni.showToast({
														title: '删除成功!',
														icon: 'none',
													})
												}
											});
										}
									}
								});
								break;
							case 1:
								break;
							default:
								break;
						}
					},
					fail: function (res) {
						//console.log(res.errMsg);
					}
				});
			},
			goPath(user_id){
				if(user_id){
					uni.navigateTo({
						url: '../details/index?user_id=' + user_id + '&in=1'
					});
				}
			},
		},
		watch: {
			
		},
	}
</script>

<style>
	.img-icon{
		width:85upx;
		height: 85upx;
		border-radius: 10upx;
	}
	.uni-list-cell-navigate {
		padding: 0;
	}
	.content{
		color:#7D7D72;
		font-size: 28upx;
	}
	.badge-text{
		background-color: #EEEEEE;
		padding: 3upx  10upx 0 10upx;
		border-radius: 15upx;
		font-size: 22upx;
	}
	.btm_border{
		position: relative;
		display: flex;
		flex-direction: row;
		justify-content: space-between;
		align-items: center;	
	}
	.btm_border::after {
		position: absolute;
	     z-index: 3;
		right: 0;
		bottom: 0;
		left: 115upx;
		height: 1px;
		content: '';
		-webkit-transform: scaleY(.5);
		transform: scaleY(.5);
		background-color: #c8c7cc;
	}
</style>